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
     */
    function getFilters(DataBase $db, $categoryUrl) {
        $filterGroups = getFiltersGroups($db, $categoryUrl);
        for ($i = 0; $i < count($filterGroups); ++$i)
            $filters[$filterGroups[$i]['characteristic']] = $db->execQuery(getFiltersQuery($filterGroups[$i]['characteristic']), ReturnValue::GET_ARRAY);
        
        return $filters;
    }

    // Запрос на получение фильтров по названию аттрибута
    function getFiltersQuery(string $nameAttr) {
        return "SELECT DISTINCT(components_characteristic.value) 
                FROM `components_characteristic` 
                WHERE components_characteristic.id_characteristic = (  SELECT characteristic.id_characteristic 
                                                                        FROM characteristic 
                                                                        WHERE characteristic.characteristic = '$nameAttr')
                ORDER BY CONVERT(components_characteristic.value, SIGNED INTEGER), components_characteristic.value;";
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
     */
    function getFiltersGroups(DataBase $db, $categoryUrl) {
        $sqlFilterGroups = "    SELECT characteristic FROM `filters`
                                JOIN characteristic ON  filters.id_characteristic=characteristic.id_characteristic
                                WHERE filters.id_category = (SELECT id_category FROM category WHERE category.url_category='$categoryUrl')";
        $data = $db->execQuery($sqlFilterGroups, ReturnValue::GET_ARRAY);
        return $data;       
    }



?>
        