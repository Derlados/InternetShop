<?php
    foreach (scandir('Objects/Goods/') as $filename) {
        $path = 'Objects/Goods/' . $filename;
        if (is_file($path))
            require_once($path);
    }
    require_once ('API/Api.php');
    require_once ('GoodsAction.php');

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
            else if (preg_match("/([a-z])+/", $this->requestUri[0]) != false) {
                $urlCaregory = $this->requestUri[0];
                $goodsJson = getGoodPreview($this->db, $urlCaregory);
                $category = getNameCategory($this->db, $urlCaregory)['category'];

                if ($goodsJson == null || $category == null) {
                   //TODO
                   return;
                }

                $filters = getFilters($this->db, $urlCaregory);
                include('templates/shop_search/shop_search_body.php');
            }

            $this->db->closeConnection();
        }

        public function deleteAction() { }

        public function updateAction() { }
    }

?>