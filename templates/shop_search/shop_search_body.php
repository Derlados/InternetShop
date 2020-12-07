<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/styles/body_main.css">
        <link rel="stylesheet" href="/styles/header.css">
        <link rel="stylesheet" href="/styles/shop_search.css">
        <link rel="stylesheet" href="/styles/goods_search.css">
        <link rel="stylesheet" href="/styles/filters.css">
        <script src="/scripts/js/filters.js"></script>
    </head>
    <body onload="restoreFilters()">
        <?php include("templates/shop_main/shop_header.html")?>
        <div class="body_main">
            <ul class="route_list">
                <li>Главная</li>
                <li><?php echo $category; ?></li>
            </ul>
            <h1 class="component_title"><?php echo $category; ?></h1>
            <div class="content_body">
                <div class="filters" id="filters">
                    <?php
                        $keys = array_keys($filters);
                        for ($i = 0; $i < count($filters); ++$i) {
                            $filterGroup = $keys[$i];

                            // Определение id для фильтра и изображения (кнопка стролочка)
                            $filterItemId = "filter_item_$i";
                            $filterImgId = "filter_img_$i";

                            echo '<div id="'.$filterItemId.'" class="filter_item">
                                    <div class="filter_group">
                                        <span class="filter_text"><b>'.$filterGroup.'</b></span>
                                        <img id="'.$filterImgId.'" class="filter_img" src="/Images/Site/filter_arrow_right.png" onclick="hideCheckbox(\''.$filterItemId.'\',\''.$filterImgId.'\')">
                                    </div>';

                            createFilterList($filters[$filterGroup], $receivedFilters);
                            echo '</div>';
                        }    

                        /** Создание списка фильтров
                         * @param filterValue - массив значений фильтров
                         */
                        function createFilterList ($filterValues, $receivedFilters) {

                            for ($j = 0; $j < count($filterValues); ++$j) {
                                $filterValue = $filterValues[$j]['value'];
                                $filterIdValue = $filterValues[$j]['id_value'];
                                $countGoods = $filterValues[$j]['count'];

                                $checked = '';
                                if ($receivedFilters != null && in_array($filterIdValue, $receivedFilters))
                                    $checked = "checked";

                                include("templates/shop_search/filter_value.php");
                            }
                        }
                    ?>
                    <div id="filter_finded" class="filter_finded">
                        <span id="filter_finded_text">Найдено 50</span>
                        <a onclick="showWithFilters()">Показать</a>
                    </div>
                </div>
                <div class="goods_content">
                    <div class="goods_list">
                        <?php
                            for ($i = 0; $i < count($goodsItems); ++$i) {
                                $good = $goodsItems[$i];
                                include ("templates/shop_search/goods_item.php");
                            }
                        ?>
                    </div>
                    <div class="goods_pager">
                        <?php
                            $pageUri = explode('page', $_SERVER['REQUEST_URI'])[0];
                            $pageUri = explode(';', $pageUri)[0];

                            if ($receivedFilters != null)
                                $hrefTemplate = 'href="http://' . API::$MAIN_DOMAIN . $pageUri . ';page={page}"';
                            else
                                $hrefTemplate = 'href="http://' . API::$MAIN_DOMAIN . $pageUri . '/page={page}"';

                            // Создание ссылки на предыдущую страницу если она есть
                            $backPageHref = '';
                            $backPageStr = strval($currentPage - 1);
                            if ($currentPage > 1)
                                $backPageHref = str_replace('{page}', strval($currentPage - 1), $hrefTemplate);

                            // Создание ссылки на следующую страницу если она есть
                            $nextPageHref = '';
                            $nextPageStr = strval($currentPage + 1);
                            if ($currentPage < $maxPages)
                                $nextPageHref = str_replace('{page}', strval($currentPage + 1), $hrefTemplate);
                            
                            include("templates/shop_search/goods_pager.php");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>