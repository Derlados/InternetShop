<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $good->name; ?></title>
        <link rel="stylesheet" href="/styles/body_main.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/header.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/goods_info/goods_info_head.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/goods_info/checkbox_warranty.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/goods_info/stats_and_desc.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/goods_info/similar_goods.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/radio_button.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/media_header.css?<?php echo time();?>">
        <script src="/scripts/js/goods_info/resize_blocks.js?<?php echo time();?>"></script>
        <script src="/scripts/js/goods_info/slider_goods.js?<?php echo time();?>"></script>
        <script src="/scripts/js/goods_info/head_info_func.js?<?php echo time();?>"></script>
        <script src="/scripts/js/header/header_func.js?<?php echo time();?>"></script>
        <script src="/scripts/js/cart/cart.js?<?php echo time();?>"></script>
    </head>
    <body onresize="resize()" onload="init()">
        <?php include("templates/shop_main/shop_header.php")?>
        <div class="body_main">
            <ul class="route_list">
                <li><a href="/">Главная</a></li>
                <li><a href="/<?php echo $categories[0]['url_category'];?>"><?php echo $categories[0]['category']; ?></a></li>
                <li><a href="/id=<?php echo $good->id_component;?>"><?php echo $good->name; ?></a></li>
            </ul>
            <h2 class="component_title"><?php echo $good->name; ?></h2>
            <div class="content_body">
                <div class="goods_info_head">
                    <div class="images">
                        <img src="/Images/PC_component/<?php echo  "$good->id_category/$good->img"; ?>" alt="">
                    </div>
                    <div class="purchase_functions">
                        <?php 
                                $availibility = $good->getAvailibilityStatus();
                                $styleColor = 0;
                                if ($availibility == "Есть в наличии") 
                                    $styleColor = "#CCFF99";
                                else if ($availibility == "Заканчивается")
                                    $styleColor = "#FFCCCC";
                                else 
                                    $styleColor = "#CCCCCC";

                                echo "  <div class='availability' style='background-color: $styleColor'>
                                            <span >$availibility</span>
                                        </div>"
                            ?>
                        <div class="main_functions">
                            <span class="price"><?php echo $good->price; ?> грн</span>
                            <div class="buy_bt">
                                <span onclick="addToCart(<?php echo $good->id_component?>)">КУПИТЬ</span>
                            </div>
                            <div class="compare_and_favorite_bt">
                                <img class="img_button" src="/Images/Site/compare2.png" alt="">
                                <img class="img_button" src="/Images/Site/favorite2.png" alt="">
                            </div>
                        </div>
                        <div class="credit">
                            <span>от <b style="font-size: 20px;"><?php echo floor($good->price / 15); ?> грн / месяц</b> при покупке товара в кредит или оплате частями</span>
                            <div class="buy_bt">
                                <span style="font-size: 18px;" onclick="addToCart(<?php echo $good->id_component?>)">Купить в кредит</span>
                            </div>
                        </div>
                        <div class="warranty">
                            <div class="checkbox">
                                <input type="checkbox" id="checkmark_warranty" onclick="checkedWarranty(this)">
                                <span class="checkmark"></span>
                                <span class="checkmark_text">Продление гарантии</span>
                            </div>
                            <ul class="warranty_years" id="warranty_year">
                               <?php 
                                    $MAX_YEARS = 3;

                                    for ($i = 1; $i <= $MAX_YEARS; ++$i) {
                                        $warrantyPrice = floor($good->price * (0.05 * $i));
                                        include ('templates/goods_info/warranty_bt.php');
                                    }
                               ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="stats_and_desc">
                    <div class="block">
                        <div class="stats">
                            <span style="margin-bottom: 20px;"><b style=" font-size: 32px;">Характеристики</b></span>
                            <div class="stats_list_holder" id="stats_list_holder">
                                <div class="stats_list" id="stats_list">
                                    <?php
                                        for ($i = 0; $i < count($good->characteristics); ++$i) {
                                            $key = $good->characteristics[$i]['characteristic'];
                                            $value = $good->characteristics[$i]['value'];
                                            echo "<div>
                                                    <span>$key</span>
                                                    <span>$value</span>
                                                  </div>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <span class="hide_bt" onclick="resize_bllock('stats_list_holder', this)">Показать полностью</span>
                        </div>
                    </div>
                    <div class="block">
                        <div class="desc">
                            <span style="margin-bottom: 20px;"><b style=" font-size: 32px;">Описание</b></span>
                            <div class="desc_holder" id="desc_holder">
                                <p id="desc"><?php echo $good->description?></p>
                            </div>
                            <span class="hide_bt" onclick="resize_bllock('desc_holder', this)">Показать полностью</span>
                        </div>
                    </div>
                </div>
                <?php if(count($similarGoods) != 1): ?>
                    <div class="similar_goods">
                        <span class="similar_goods_text"><b>Похожие товары</b></span>
                        <div class="similar_list_goods">
                            <div class="slide_bt">
                                <img src="/Images/Site/slide_arrow_left.png" onclick="scrollGoods(1, currentMaxitems)" alt="">
                            </div>
                            <div class="goods_slider_holder" id="goods_slider_holder">
                                <ul class="goods_slider" id="goods_slider">
                                    <?php
                                        for ($i = 0; $i < count($similarGoods); ++$i) {
                                            $similarGood = $similarGoods[$i];
                                            if ($good->id_component != $similarGoods[$i]->id_component)
                                                include('templates/goods_info/similar_goods_item.php');
                                        }

                                        if (count($similarGoods) == 1)
                                            echo "<li style='width: 100%;'> Похожих товаров не найдено </li>"
                                    ?>
                                </ul>
                            </div>
                            <div class="slide_bt">
                                <img src="/Images/Site/slide_arrow_right.png" onclick="scrollGoods(-1, currentMaxitems)" alt="">
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </body>
</html>