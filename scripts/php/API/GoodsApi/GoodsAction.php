<?php   
    // Подключение всех файлов
    foreach (scandir('scripts/php/Objects/Goods/') as $filename) {
        $path = 'scripts/php/Objects/Goods/' . $filename;
        if (is_file($path))
            require_once($path);
    }

    /** Запрос на получение превью данных о товаре
     * @param db - экземпляр базы данных
     * @param categoryUrl - категория из url запроса
     * @param page - номер страницы (каждая страница, это 20 товаров максимум)
     */
    function getGoodPreview(DataBase $db, string $urlCategory, int $page, $filters, $searchWords) {
        $offset = ($page - 1) * 20; // Сдвиг выборки относительно страницы
        
        // Есди фильтры отсутствуют запрос выполняет обычным способом, если присутствует - необходимо сделать более сложный запрос
        $sqlgetGoods = '';
        if ($filters == null) {
            $whereCond = getModifyWhereWithSearch("WHERE component.id_category = (SELECT id_category FROM category WHERE category.url_category = '$urlCategory')", $searchWords);
            $sqlgetGoods = "    SELECT * FROM `component` 
                                $whereCond";
        }
        else {
            $sqlFilters = getSqlFiltersBody($filters, $urlCategory);
            $sqlgetGoods = "    SELECT `component`.`id_component`, `component`.`name`, `component`.`id_category`,`component`. `price`, `component`.`count_component`,`component`.`img`  FROM `component`
                                $sqlFilters";
        }

        $sqlgetGoods .= " LIMIT 20 OFFSET $offset";
        $data = $db->execQuery($sqlgetGoods, ReturnValue::GET_ARRAY);
        return $data;
    }

    /** Запрос на получение всех характеристик о комплектующем по id
     * @param db - экземпляр базы данных
     * @param idGoods - id комплектующего
     */
    function getFullCharacteristic(DataBase $db, $idGoods) {
        $sqlGetFullCharacteristic = "   SELECT `attribute_value`.`id_value`, `characteristic`.`characteristic`, `attribute_value`.`value` FROM `components_characteristic`
                                        JOIN `characteristic` ON `characteristic`.`id_characteristic` = `components_characteristic`.`id_characteristic`
                                        JOIN `attribute_value` ON `attribute_value`.`id_value` = `components_characteristic`.`id_value`
                                        WHERE `components_characteristic`.`id_component` = $idGoods";
        $data = $db->execQuery($sqlGetFullCharacteristic, ReturnValue::GET_ARRAY);
        return $data;
    }

    /** Запрос на получение информации о самом комплектующем по id
     * @param db - экземпляр базы данных
     * @param idGoods - id комплектующего
     */
    function getGoodInfoByid(DataBase $db, $idGoods) {
        $sqlGetGood = " SELECT * FROM `component` 
                        WHERE `id_component`= $idGoods";
        $data = $db->execQuery($sqlGetGood, ReturnValue::GET_OBJECT);

        $idDesc = $data['id_description'];
        $sqlGetDesc = " SELECT `description`.`description` FROM `description` 
                        WHERE `description`.`id_description`= $idDesc";
        $desc = $db->execQuery($sqlGetDesc, ReturnValue::GET_OBJECT);

        $data['description'] = $desc['description'];
        return $data;
    }

    /** Загрузка фильтров в соответствии с категорией
     * @param db - объект менеджера базы данных
     * @param categoryUrl - категория из url запроса
     * @return filters - ассоциативный массив фильтров в виде (<категория фильтра> => <массив значений фильтра>)
     */
    function getFilters(DataBase $db, string $urlCategory) {
        $filterGroups = getFiltersGroups($db, $urlCategory);
        for ($i = 0; $i < count($filterGroups); ++$i)
            $filters[$filterGroups[$i]['characteristic']] = $db->execQuery(getFiltersQuery($filterGroups[$i]['characteristic'], $urlCategory), ReturnValue::GET_ARRAY);
        
        return $filters;
    }

    // Создание запроса на получение фильтров по названию аттрибута
    function getFiltersQuery(string $nameAttr, string $urlCategory) {
        return "    SELECT `attribute_value`.`id_value`, `attribute_value`.`value`, COUNT(*) as count FROM `components_characteristic`
                    JOIN `attribute_value` ON `attribute_value`.`id_value` = `components_characteristic`.`id_value`
                    JOIN `category` ON `category`.`id_category` = (SELECT `component`.`id_category` FROM `component` WHERE `component`.`id_component` = `components_characteristic`.`id_component`)
                    WHERE `category`.`url_category` = '$urlCategory' AND `components_characteristic`.`id_characteristic` = ( 	SELECT characteristic.id_characteristic  
                                                                                                                                FROM characteristic 
                                                                                                                                WHERE characteristic.characteristic = '$nameAttr')
                    GROUP BY components_characteristic.id_value
                    ORDER BY CONVERT(`attribute_value`.`value`, SIGNED INTEGER), `attribute_value`.`value`";
    }

    /** Подготовка основного "тела" SQL запрос для создания фильтров
     * @param filters - фильтры с url
     * @param urlCategory - категория взятая с url
     */
    function getSqlFiltersBody($filters, $urlCategory) {
        $countAttr = intval($filters[0]);

        // Создание условия WHERE для запроса c фильтрами
        $whereCond = "WHERE `category`.`url_category` ='$urlCategory' AND (`components_characteristic`.`id_value` = '$filters[1]'";
        for ($i = 2; $i < count($filters); ++$i) 
            $whereCond .= " OR `components_characteristic`.`id_value` = '$filters[$i]'";
        $whereCond .= ")";

        // Поиск по фильтрам
        $sqlFilters = " JOIN `components_characteristic` ON `components_characteristic`.`id_component` = `component`.`id_component`
                        JOIN `category` ON `category`.`id_category` = `component`.`id_category`
                        $whereCond
                        GROUP BY `components_characteristic`.`id_component`
                        HAVING COUNT(*)  = $countAttr";

        return $sqlFilters;
    }

    function getModifyWhereWithSearch($whereCond, $searchWords) {
        if ($searchWords != null) {
            $searchWords = explode(',', $searchWords);

            $whereCond .= "AND (`name` LIKE '%$searchWords[0]%'";
            for ($i = 1; $i < count($searchWords); ++$i)
                $whereCond .= " OR `name` LIKE '%$searchWords[$i]%'";
            $whereCond .= ")";
        }

        return $whereCond;
    }

    // Запрос на получение всех категорий
    function getAllCategory(DataBase $db) {
        $sqlGetAllCategory = "SELECT * FROM category";
        $data = $db->execQuery($sqlGetAllCategory, ReturnValue::GET_ARRAY);  
        return $data;
    }

    /** Запрос на получение названия категории
     * @param db - менеджер базы данных
     * @param urlCategory - название категории в url запросе
     */
    function getNameCategory(DataBase $db, string $urlCategory) {
        $sqlNameCategory = "    SELECT category.category, category.url_category FROM category 
                                WHERE category.url_category='$urlCategory'";
        $data = $db->execQuery($sqlNameCategory, ReturnValue::GET_OBJECT);
        return $data;
    }

    /** Запрос на получение информации о категории
     * @param db - менеджер базы данных
     * @param urlCategory - название категории в url запросе
     */
    function getCategoryInfo(DataBase $db, string $idCategory) {
        $sqlNameCategory = "    SELECT category.category, category.url_category FROM category 
                                WHERE category.id_category='$idCategory'";
        $data = $db->execQuery($sqlNameCategory, ReturnValue::GET_OBJECT);
        return $data;
    }

    /** Запрос на получение названия групп фильтров
     * @param db - менеджер базы данных
     * @param urlCategory - название категории в url запросе
     **/
    function getFiltersGroups(DataBase $db, string $urlCategory) {
        $sqlFilterGroups = "    SELECT characteristic FROM `filters`
                                JOIN characteristic ON  filters.id_characteristic=characteristic.id_characteristic
                                WHERE filters.id_category = (SELECT id_category FROM category WHERE category.url_category='$urlCategory')";
        $data = $db->execQuery($sqlFilterGroups, ReturnValue::GET_ARRAY);
        return $data;       
    }

    function getCountGoods(DataBase $db, string $urlCategory, $filters, $searchWords) {
        $sqlCountGoods = '';

        if ($filters != null) {
            $sqlFilters = getSqlFiltersBody($filters, $urlCategory, $searchWords);
            $sqlCountGoods = "  SELECT COUNT(*) countGoods FROM (   SELECT COUNT(*)  FROM `component`
                                                                    $sqlFilters) newTable";
        } else {
            $whereCond = getModifyWhereWithSearch("WHERE `component`.`id_category`= (SELECT id_category FROM category WHERE category.url_category = '$urlCategory')", $searchWords);
            $sqlCountGoods = "  SELECT COUNT(*) as countGoods
                                FROM `component` 
                                $whereCond";
        }

        $data = $db->execQuery($sqlCountGoods, ReturnValue::GET_OBJECT);
        return intval($data['countGoods']);
    }

    function getSimilarGoods(DataBase $db, Goods $good, $urlCategory) {
        // Получение аттрибутов для поиска похожих товаров
        $sqlGetSimilarAttribute = " SELECT `characteristic`.`characteristic` FROM `filters` 
                                    JOIN `characteristic` ON `characteristic`.`id_characteristic` = `filters`.`id_characteristic` 
                                    WHERE `as_similar`= 1 AND `filters`.`id_category` = $good->id_category";
        $similarAttr = $db->execQuery($sqlGetSimilarAttribute, ReturnValue::GET_ARRAY);
        
        // Поиск похожих товаров производится по фильтрам
        $filters[0] = count($similarAttr);
        for ($i = 0; $i < count($similarAttr); ++$i) {
            $attribute = $similarAttr[$i]['characteristic'];
            $filters[$i + 1] = $good->findCharacteristicByName($attribute)['id_value'];
        }

        $data = getGoodPreview($db, $urlCategory, 1, $filters, null); // Получение самих комплектующих
        return $data;
    }
?>