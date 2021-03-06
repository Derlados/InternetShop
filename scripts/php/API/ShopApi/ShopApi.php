<?php
    require_once ('scripts/php/Managers/Cart.php');
    require_once ('scripts/php/API/Api.php');
    require_once ('scripts/php/API/ShopApi/ShopAction.php');
    require_once ('scripts/php/Objects/Goods/Goods.php');

    class ShopApi extends Api {
        
        public function createAction() { 
            if ($this->requestUri[0] == '') {
                
                $id = $_POST['id'];    
                $cart = new Cart();
                $cart->set($id);
                $cart->save();

                print_r($cart->get());
                return;
            } 
            else if ($this->requestUri[0] == 'accept') {
                $cart = new Cart();
                $fullName = $_POST['fullName'];    
                $phone = $_POST['phone'];    
                $idAddress = $_POST['idAddress'];    
                $idTypePayment = $_POST['idTypePayment'];    
                $email = $_POST['email'];     
                $ids = $cart->get();    
                addUserOrder($this->db, $fullName, $phone, $idAddress, $idTypePayment, $email, $ids);
                $cart->deleteAll();
                $cart->save();
            }
        }

        public function viewAction() {
            if ($this->requestUri[0] == '') {
                $typesDelivery = getTypesDelivery($this->db);
                $typesPayment = getTypesPayment($this->db);
                $cities = getCities($this->db);

                $cart = new Cart();
                $orderGoods = getGoodsFromCart($this->db, $cart->get());

                $sumPrice = 0;
                for ($i = 0; $i < count($orderGoods); ++$i)
                    $sumPrice += intval($orderGoods[$i]->price);
        
                include('templates/purchase/purchase_body.php');
            } 
            else if ($this->requestUri[0] == 'addresses') {
                $id = $_GET['id'];
                echo json_encode(getAddresses($this->db, $id));
                return;
            }
        }

        public function deleteAction() { 
            $id = explode('id=', $this->requestUri[0])[1];    
            $cart = new Cart();
            $cart->delete($id);
            $cart->save();

            return;
        }

        public function updateAction() { }
    }
?>