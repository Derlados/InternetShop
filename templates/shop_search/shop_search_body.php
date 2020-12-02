<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/body_main.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/shop_search.css">
        <link rel="stylesheet" href="styles/goods_search.css">
        <link rel="stylesheet" href="styles/filters.css">
        <script src="scripts/filters.js"></script>
    </head>
    <body>
        <?php include("templates/shop_main/shop_header.html")?>
        <div class="search_body_main">
            <ul class="route_list">
                <li>Главная</li>
                <li><?php echo $category; ?></li>
            </ul>
            <h1 class="component_title"><?php echo $category; ?></h1>
            <div class="content_body">
                <div class="filters">
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
                                        <img id="'.$filterImgId.'" class="filter_img" src="Images/Site/filter_arrow_right.png" onclick="hideCheckbox(\''.$filterItemId.'\',\''.$filterImgId.'\')">
                                    </div>';

                            $filterValues = $filters[$filterGroup];
                            for ($j = 0; $j < count($filterValues); ++$j) {
                                $filterValue = $filterValues[$j]['value'];
                                include("templates/shop_search/filter_value.php");
                            }

                            echo '</div>';
                        }    
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>