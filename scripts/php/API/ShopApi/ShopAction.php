<?php 
    require_once ('scripts/php/Objects/Goods/Goods.php');

    function getTypesDelivery(DataBase $db) {
        $sqlQuery = "SELECT * FROM `type_delivery`";
        $data = $db->execQuery($sqlQuery, ReturnValue::GET_ARRAY);
        return $data;
    }

    function getTypesPayment(DataBase $db) {
        $sqlQuery = "SELECT * FROM `type_payment`";
        $data = $db->execQuery($sqlQuery, ReturnValue::GET_ARRAY);
        return $data;
    }

    function getCities(DataBase $db) {
        $sqlQuery = "SELECT * FROM `city`";
        $data = $db->execQuery($sqlQuery, ReturnValue::GET_ARRAY);
        return $data;
    }

    function getAddresses(DataBase $db, $idCity) {
        $sqlQuery = "   SELECT * FROM `address`
                        WHERE `id_city`='$idCity'";
        $data = $db->execQuery($sqlQuery, ReturnValue::GET_ARRAY);
        return $data;
    }

    function getGoodsFromCart(DataBase $db, $ids) {
        $sqlQuery = "SELECT * FROM `component` WHERE `id_component`= '$ids[0]'";
        for ($i = 1; $i < count($ids); ++$i)
            $sqlQuery .= " OR `id_component`= '$ids[$i]'";
        $data = $db->execQuery($sqlQuery, ReturnValue::GET_ARRAY);

        $dataGoods = array();
        for ($i = 0; $i < count($data); ++$i)
            $dataGoods[$i] = new Goods($data[$i]);

        return $dataGoods;
    }
?>