<?php
    require_once ('ServerAPI/Api.php');
    require_once ('ServerAPI/GoodsAPI/GoodAction.php');

    class GoodApi extends Api {

        public function createAction() {

        }

        /** GET запросы
         * internetShop/<catalog> - загрузка первой страницы каталога комплектующих
         * internetShop/<catalog>/page=%d - загрузка страницы соответствующего каталога
         * internetShop/id=%d - загрузка полной информации о комплектующем
         * internetShop/<catalog>/filters=%d,%d... - поиск с фильтрами
         * .../?Search=... - поиск по веденным в поисковике словам 
         */
        public function viewAction() {


            switch ($this->requestUri[0]) {
                case '':
                    $categories = getAllCategory($this->db);
                    $file_body = "catalog_body.php");
                    include("templates/shop_page/header.php");
                    break;
                case 'processors':
                    return getGoodPreview($this->db, "Процессоры");
                    break;
                case 'videocards':
                    break;
                case 'motherboards':
                    break;
                case 'ssd':
                    break;
                case 'hdd':
                    break;
            }

            $this->db->closeConnection();
        }

        public function deleteAction() {

        }

        public function updateAction() {

        }
    }

?>