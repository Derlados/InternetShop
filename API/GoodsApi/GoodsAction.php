<?php
    /**
     * @param db - экземпляр базы данных
     * @param name - название категории
     * @param page - номер страницы (каждая страница, это 20 товаров максимум)
     */
    function getGoodPreview(DataBase $db, $name, $page = 0) {
        $offset = $page * 20; // Сдвиг выборки относительно страницы
        
        $sqlgetProcessors = "   SELECT * FROM `component` 
                                WHERE component.id_category = (SELECT id_category FROM category WHERE category.category = '$name')
                                LIMIT 20 OFFSET $offset";

        $data = $db->execQuery($sqlgetProcessors, ReturnValue::GET_ARRAY);
        return json_encode($data);
    }

    // Загрузка полной информации комплектующего по id
    function getGoodFullData(DataBase $db, $id) {
        $sqlFullData = "SELECT characteristic.characteristic, components_characteristic.value 
                        FROM `components_characteristic` 
                        INNER JOIN characteristic ON characteristic.id_characteristic = components_characteristic.id_characteristic 
                        WHERE `components_characteristic`.`id_component` = '$id'";

        $data = $db->execQuery($sqlFullData, ReturnValue::GET_ARRAY);
        return json_encode($data);
    }

    // Загрузка фильтров процессора
    function getProcessorsFilters(DataBase $db) {

        $filters = array();

        $filters["Производитель"] = array(["value" => "Intel"], ["value" => "AMD"]);
        $filters["Частота ядра"] = array(["value" => "1.0 - 1.5"], ["value" => "1.5 - 3.0"], ["value" => "3.0 - 3.2"], ["value" => "3.3 - 3.5"], ["value" => "3.6 - 4.2"]);
        $filters["Семейство процессора"] = $db->execQuery(getFiltersQuery("Семейство процессора"), ReturnValue::GET_ARRAY);
        $filters["Тип сокета"] = $db->execQuery(getFiltersQuery("Тип сокета"), ReturnValue::GET_ARRAY);
        $filters["Количество ядер"] = $db->execQuery(getFiltersQuery("Количество ядер"), ReturnValue::GET_ARRAY);
        $filters["Теплопакет (TDP)"] = $db->execQuery(getFiltersQuery("Теплопакет (TDP)"), ReturnValue::GET_ARRAY);
        $filters["Техпроцесс, nm"] = $db->execQuery(getFiltersQuery("Техпроцесс, nm"), ReturnValue::GET_ARRAY);

        return json_encode($filters);
    }

    // Запрос на получение фильтров по названию аттрибута
    function getFiltersQuery($nameAttr) {
        return "SELECT DISTINCT(components_characteristic.value) 
                FROM `components_characteristic` 
                WHERE components_characteristic.id_characteristic = (  SELECT characteristic.id_characteristic 
                                                                        FROM characteristic 
                                                                        WHERE characteristic.characteristic = '$nameAttr')";
    }

    // Запрос на получение всех категорий
    function getAllCategory(DataBase $db) {
        $sqlGetAllCategory = "SELECT * FROM category";
        $data = $db->execQuery($sqlGetAllCategory, ReturnValue::GET_ARRAY);  
        return $data;
    }
?>
        