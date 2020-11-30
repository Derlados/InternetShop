<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/body_main.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/shop_search.css">
        <link rel="stylesheet" href="styles/goods_search.css">
    </head>
    <body style="margin-left: 150px; margin-right: 150px; margin-top: 20px;">
        <?php include("templates/shop_main/shop_header.html")?>
        <div class="body_main">
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

                            echo '<div class="filter-item">
                            <span class="filter_text"><b>'.$filterGroup.'</b></span>';

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