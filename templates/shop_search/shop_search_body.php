<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/body_main.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/header.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/shop_search.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/goods_search.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/filters.css"?<?php echo time();?>>
        <link rel="stylesheet" href="/styles/checkbox_filter.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/media_header.css?<?php echo time();?>">
        <script src="/scripts/js/shop_search/filters.js?<?php echo time();?>"></script>
        <script src="/scripts/js/header/header_func.js?<?php echo time();?>"></script>
        <script src="/scripts/js/cart/cart.js?<?php echo time();?>"></script>
    </head>
    <body onload="restoreFilters()">
        <?php include("templates/shop_main/shop_header.php")?>
        <div class="body_main">
            <ul class="route_list">
                <li><a href="/">Главная</a></li>
                <li><a href="/<?php echo $categories[0]['url_category'];?>"><?php echo $categories[0]['category']; ?></a></li>
            </ul>
            <h2 class="component_title"><?php echo $categories[0]['category']; ?></h2>
            <div class="filters_bt_media" onclick="setDisplayMediaFilters('block')">
                <span>Фильтры</span>
            </div>
            <div class="content_body">
                <div class="filters" id="filters">
                    <div class="media_header_filters">
                        <img class="logo_media" src="/Images//Site/logo.jpg">
                        <img class="close_symbol" src="/Images//Site/close.png" onclick="setDisplayMediaFilters('none')">
                    </div>
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
                        <span id="filter_finded_text">Найдено 0</span>
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

                            if (count($goodsItems) == 0) {
                                echo "<img class='notFound'>Товары не найдены</img>";
                            }
                        ?>
                    </div>
                    <div class="goods_pager">
                        <?php
                            if (count($goodsItems) == 0)
                                return;
                            
                            $uriAndGet = explode('?', $_SERVER['REQUEST_URI']);
                            $requestUri = $uriAndGet[0];

                            // Выделение части GET запроса если она есть
                            $searchGet = '';
                            if ($uriAndGet[1] != null)
                                $searchGet = '?' . $uriAndGet[1];

                            // Подготовка uri для перехода между страницами
                            $pageUri = explode('/page', $requestUri)[0];
                            $pageUri = explode(';page', $pageUri)[0];

                            if ($receivedFilters != null)
                                $hrefTemplate = 'href="' . $pageUri . ';page={page}' . $searchGet .'"';
                            else
                                $hrefTemplate = 'href="' . $pageUri . '/page={page}' . $searchGet .'"';

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