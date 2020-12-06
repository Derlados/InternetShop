<?php
    foreach (scandir('scripts/php/Objects/Goods/') as $filename) {
        $path = 'scripts/php/Objects/Goods/' . $filename;
        if (is_file($path))
            require_once($path);
    }
    require_once ('scripts/php/API/Api.php');
    require_once ('scripts/php/API/GoodsApi/GoodsAction.php');

    class GoodApi extends Api {
        
        public function createAction() { }

        /** GET запросы
         * internetShop/<catalog> - загрузка первой страницы каталога комплектующих
         * internetShop/<catalog>/page=%d - загрузка страницы соответствующего каталога
         * internetShop/id=%d - загрузка полной информации о комплектующем
         * internetShop/<catalog>/filters=%d,%d... - поиск с фильтрами
         * internetShop/json/... - запросы возвращающие данные в виде json, без отрисовки страниц
         * .../?Search=... - поиск по веденным в поисковике словам 
         */
        public function viewAction() {

            if ($this->requestUri[0] == '') {
                $categories = getAllCategory($this->db);
                include('templates/catalog/catalog.php');
            }
            else if ($this->requestUri[0] == 'json') {
                array_shift($this->requestUri);

                if (preg_match("/([a-z])+/", $this->requestUri[0]) != false && preg_match("/filters=(.*)/", $this->requestUri[1]) != false) {
                    $filterValues = explode('=', $this->requestUri[1])[1];
                    $filterValues = explode(',', $filterValues);
                    $urlCaregory = $this->requestUri[0];
                    echo getСountGoodsWithFilters($this->db, $filterValues, $urlCaregory);
                }
            }
            else if (preg_match("/([a-z])+/", $this->requestUri[0]) != false) {
                $urlCaregory = $this->requestUri[0];
                array_shift($this->requestUri);

                // Взятие номера страницы 
                $pageStr = array();
                if (!empty($this->requestUri) && preg_match("/page=[0-9]+/", $this->requestUri[0], $pageStr) != false) {
                    $currentPage = intval(preg_replace('/[^0-9]/', '', $pageStr[0]));      
                }
                else if (!empty($this->requestUri)) {
                    return;
                }              
                else {
                    $currentPage = 1;
                }   

                // Получение товаров
                $goodsJson = getGoodPreview($this->db, $urlCaregory, $currentPage);
                $category = getNameCategory($this->db, $urlCaregory)['category'];

                if ($goodsJson == null || $category == null) {
                   //TODO
                   return;
                }

                // Десериализация всех товаров
                $goodsItems = array();
                for ($i = 0; $i < count($goodsJson); ++$i)
                    $goodsItems[$i] = new Goods($goodsJson[$i]);

                $maxPages = intval(getCountGoods($this->db, $urlCaregory) / 20 + 1); // Получение максимального количества страниц
                $filters = getFilters($this->db, $urlCaregory); // Получение фильтров
                include('templates/shop_search/shop_search_body.php');
            }

            $this->db->closeConnection();
        }

        public function deleteAction() { }

        public function updateAction() { }
    }

?>