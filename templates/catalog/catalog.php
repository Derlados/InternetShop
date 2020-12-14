<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/body_main.css?<?php echo time();?>">
        <link rel="stylesheet" href="styles/header.css?<?php echo time();?>">
        <link rel="stylesheet" href="styles/catalog_search.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/media_header.css?<?php echo time();?>">
        <script src="/scripts/js/header/header_func.js?<?php echo time();?>"></script>
    </head>
    <body>
        <?php include("templates/shop_main/shop_header.php")?>
        <div class="body_main">
            <ul class="route_list">
                <li>Главная</li>
            </ul>
            <h1 class="component_title">Комплектуюшие ПК</h1>
            <div class="content_body">
                <?php
                    // Сборка внутреннего контента
                    for ($i = 0; $i < count($categories); $i++) {
                        $url_category = $categories[$i]['url_category'];
                        $category = $categories[$i]['category']; 
                        $img_path = "Images/PC_component/preview_catalog/".$url_category.".png";

                        include("catalog_block.php");
                    }
                ?>
            </div>
        </div>
    </body>
</html>