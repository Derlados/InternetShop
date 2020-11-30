<?php
    require_once ('Api.php');
    require_once ('GoodsApi');

    class GoodApi extends Api {

        public function createAction() { }

        /** GET запросы
         * internetShop/<catalog> - загрузка первой страницы каталога комплектующих
         * internetShop/<catalog>/page=%d - загрузка страницы соответствующего каталога
         * internetShop/id=%d - загрузка полной информации о комплектующем
         * internetShop/<catalog>/filters=%d,%d... - поиск с фильтрами
         * .../?Search=... - поиск по веденным в поисковике словам 
         */
        public function viewAction() {

            if ($this->requestUri[0] == '') {
                $categories = getAllCategory($this->db);
                include('templates/catalog/catalog.php');
            }
            else if (preg_match("/([a-z])+/", $this->requestUri[0]) !== false) {
                //$goods = getGoodPreview($this->db, $this->requestUri[0]);
                $filters = getProcessorsFilters($this->db);
                $goods = getGoodPreview($this->db, "Процессоры");
                include('templates/shop_search/shop_search_body.php');
            }

            $this->db->closeConnection();

            include("templates/shop_page/shop_header.php");
        }

        public function deleteAction() { }

        public function updateAction() { }
    }

?>