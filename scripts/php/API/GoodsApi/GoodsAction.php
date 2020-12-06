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
    function getGoodPreview(DataBase $db, string $categoryUrl, int $page) {
        $offset = ($page - 1) * 20; // Сдвиг выборки относительно страницы
        
        $sqlgetProcessors = "   SELECT * FROM `component` 
                                WHERE component.id_category = (SELECT id_category FROM category WHERE category.url_category = '$categoryUrl')
                                LIMIT 20 OFFSET $offset";

        $data = $db->execQuery($sqlgetProcessors, ReturnValue::GET_ARRAY);
        return $data;
    }

    // Загрузка полной информации комплектующего по id
    function getGoodFullData(DataBase $db, int $id) {
        $sqlFullData = "SELECT characteristic.characteristic, components_characteristic.value 
                        FROM `components_characteristic` 
                        INNER JOIN characteristic ON characteristic.id_characteristic = components_characteristic.id_characteristic 
                        WHERE `components_characteristic`.`id_component` = '$id'";

        $data = $db->execQuery($sqlFullData, ReturnValue::GET_ARRAY);
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
        return "      SELECT `attribute_value`.`id_value`, `attribute_value`.`value`, COUNT(*) as count FROM `components_characteristic`
                    JOIN `attribute_value` ON `attribute_value`.`id_value` = `components_characteristic`.`id_value`
                    JOIN `category` ON `category`.`id_category` = (SELECT `component`.`id_category` FROM `component` WHERE `component`.`id_component` = `components_characteristic`.`id_component`)
                    WHERE `category`.`url_category` = '$urlCategory' AND `components_characteristic`.`id_characteristic` = ( 	SELECT characteristic.id_characteristic  
                                                                                                                                FROM characteristic 
                                                                                                                                WHERE characteristic.characteristic = '$nameAttr')
                    GROUP BY components_characteristic.id_value
                    ORDER BY CONVERT(`attribute_value`.`value`, SIGNED INTEGER), `attribute_value`.`value`";
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
        $sqlNameCategory = "    SELECT category.category FROM category 
                                WHERE category.url_category='$urlCategory'";
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

    function getCountGoods(DataBase $db, string $urlCategory) {
        $sqlCountGoods = "    SELECT COUNT(*) as countGoods
                            FROM `component` 
                            WHERE `component`.`id_category`= (SELECT id_category FROM category WHERE category.url_category = '$urlCategory')";
        $data = $db->execQuery($sqlCountGoods, ReturnValue::GET_OBJECT);
        return intval($data['countGoods']);
    }

    /** Запрос на получение количества товаров по соотвутствующим фильтрам
     * @param db - менеджер базы данных
     * @param filters - массив фильтров с url запроса, первый элемент всегда должен являться числом групп задействованных фильтров
     * @return countGoods - количество товаров
     */
    function getСountGoodsWithFilters(DataBase $db, $filters, $urlCategory) {
        $countAttr = intval($filters[0]);

        // Создание условия WHERE для запроса
        $whereCond = "WHERE `category`.`url_category` ='$urlCategory' AND (`components_characteristic`.`id_value` = '$filters[1]'";
        for ($i = 2; $i < count($filters); ++$i) 
            $whereCond .= " OR `components_characteristic`.`id_value` = '$filters[$i]'";

        $whereCond .= ")";

        $sqlCountGoods = "  SELECT COUNT(*) countGoods FROM (   SELECT COUNT(*)  FROM `component`
                                                                JOIN `components_characteristic` ON `components_characteristic`.`id_component` = `component`.`id_component`
                                                                JOIN `category` ON `category`.`id_category` = `component`.`id_category`
                                                                $whereCond
                                                                GROUP BY `components_characteristic`.`id_component`
                                                                HAVING COUNT(*)  = $countAttr) newTable";
        
        $data = $db->execQuery($sqlCountGoods, ReturnValue::GET_OBJECT);
        return intval($data['countGoods']);
    }
?>
        