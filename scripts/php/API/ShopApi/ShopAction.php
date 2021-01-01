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
        foreach ($ids as $key => $value)
            $sqlQuery .= " OR `id_component`= '$value'";
        $data = $db->execQuery($sqlQuery, ReturnValue::GET_ARRAY);

        $dataGoods = array();
        for ($i = 0; $i < count($data); ++$i)
            $dataGoods[$i] = new Goods($data[$i]);

        return $dataGoods;
    }

    function addUserOrder(DataBase $db, $fullName, $phone, $idAddress, $idTypePayment, $email, $ids) {
        if (count($ids) == 0)
            return;
            
        $sqlQueryInsertUserOrder = "INSERT INTO `userorder`(`FIO`, `phone`, `id_address`, `id_type_payment`, `email`) 
                                    VALUES ($fullName,$phone,$idAddress,$idTypePayment, $email)";
        DataBase::execQuery($sqlQueryInsertUserOrder, ReturnValue::GET_NOTHING);

        $sqlQuery = "SELECT MAX(id_userOrder) as id FROM `userorder`";
        $idUserOrder = DataBase::execQuery($sqlQuery, ReturnValue::GET_OBJECT)['id'];

        $sqlQueryInsertCart = "INSERT INTO `cart` (id_userOrder, id_component) VALUES ($idUserOrder, $ids[0])";
        for ($i = 1; $i < count($ids); ++$i)
            $sqlQueryInsertCart .= "($idUserOrder, $ids[$i])";
        DataBase::execQuery($sqlQueryInsertCart, ReturnValue::GET_NOTHING);

        return;
    }
?>