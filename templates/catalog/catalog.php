<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/body_main.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/catalog_search.css">
        <script src="/scripts/js/header/header_func.js"></script>
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