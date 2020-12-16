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
                    $receivedFilters = explode('=', $this->requestUri[1])[1];
                    $receivedFilters = explode(',', $receivedFilters);
                    $urlCaregory = $this->requestUri[0];
                    echo  getCountGoods($this->db, $urlCaregory, $receivedFilters, null);
                }
            }
            else if (preg_match("/id=([0-9])+/", $this->requestUri[0]) != false) {
                // Получение текущего элемента
                $idGoods = str_replace('id=', '', $this->requestUri[0]);
                $good = new Goods(getGoodInfoByid($this->db, $idGoods));
                $good ->characteristics = getFullCharacteristic($this->db, $idGoods);
                
                // Информация о категории
                $categoryInfo = getCategoryInfo($this->db, $good->id_category);
                $categoryName = $categoryInfo['category'];
                $categoryUrl = $categoryInfo['url_category'];
                $categories = getAllCategory($this->db); // Все категории (нужны тупо для хедера)

                // Получение списка похожих товаров
                $similarGoodsData = getSimilarGoods($this->db, $good, $categoryUrl);
                $similarGoods = array();
                for ($i = 0; $i < count($similarGoodsData); ++$i)
                    $similarGoods[$i] = new Goods($similarGoodsData[$i]);

                include('templates/goods_info/goods_info_body.php');
            }
            else if (preg_match("/([a-z])+/", $this->requestUri[0]) != false) {
                $urlCaregory = $this->requestUri[0];
                array_shift($this->requestUri);

                // Взятие номера страницы 
                $matches = array();
                $receivedFilters = null;
                $currentPage = 1;

                if (!empty($this->requestUri)) {
                    //Извлечение фильтров
                    if (preg_match("/filters(=[0-9]+)((,[0-9]+)+)/", $this->requestUri[0], $matches) != false) {
                        $receivedFilters = str_replace('filters=', '', $matches[0]);    
                        $receivedFilters = explode(',', $receivedFilters);
                    }

                    // Извлечение текущей страницы
                    if (preg_match("/(.*)page=[0-9]+/", $this->requestUri[0], $matches) != false){
                        $currentPage = intval(preg_replace('/(.*)page=/', '', $matches[0]));           
                    }
                }  
                else {
                    $currentPage = 1;
                }   

                $searchWords = $_GET['search']; // Получение слов для поиска (со строки поиска)

                // Получение товаров
                $goodsData = getGoodPreview($this->db, $urlCaregory, $currentPage, $receivedFilters, $searchWords);
                $categoryName = getNameCategory($this->db, $urlCaregory)['category'];

                // Десериализация всех товаров
                $goodsItems = array();
                for ($i = 0; $i < count($goodsData); ++$i)
                    $goodsItems[$i] = new Goods($goodsData[$i]);

                $maxPages = intval(getCountGoods($this->db, $urlCaregory, $receivedFilters, $searchWords) / 20 + 1); // Получение максимального количества страниц
                $filters = getFilters($this->db, $urlCaregory); // Получение фильтров
                $categories = getAllCategory($this->db);

                include('templates/shop_search/shop_search_body.php');
            }

            $this->db->closeConnection();
        }

        public function deleteAction() { }

        public function updateAction() { }
    }

?>