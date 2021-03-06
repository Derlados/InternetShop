<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php include("templates/shop_main/meta_data.html")?>
        <meta property="og:image" content="http://a0496659.xsph.ru/Images/icon.png">
        <title>Корзина</title>
        <link rel="stylesheet" href="/styles/main/footer.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/purchase.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/purchase_form.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/order_goods.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/delivery.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/radio_button.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/payment.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/finish_purchase.css?<?php echo time();?>">
        <link rel="stylesheet" href="/styles/purchase_form/list.css?<?php echo time();?>">
        <script src="scripts/js/purchase/purchase_form.js?<?php echo time();?>"></script>
        <script src="scripts/js/cart/cart.js?<?php echo time();?>"></script>
    </head>
    <body onload="init(); updateAddress(1)">
        <div class="purchase_body">
            <div class="header_purchase">
                <a class="logo" href="/">
                    <img src="/Images/Site/logo.jpg" alt="logo.jpg">
                </a>
                <span>Консультации по телефону: +38 044 537 02 22</span>
            </div>
            <h2 class="">Оформление заказа</h2>
            <form class="purchase_form">
                <div class="data">
                    <div class="person_data">
                        <?php 
                            $numberMark = '!'; $markText = 'Ваши контактные данные';
                            include('templates/purchase/point.php');
                        ?>
                        <div class="labels">
                            <?php
                                $labelHeaders = ['Фамилия', 'Имя', 'Мобильный телефон'];
                                $errorTexts = ['фамилию', 'имя', 'мобильный телефон'];

                                for ($i = 0; $i < count($labelHeaders); ++$i) {
                                    $headerText = $labelHeaders[$i];
                                    $errorText = $errorTexts[$i];
                                    $id = $i;
                                    include('templates/purchase/label.php');
                                }
                            ?>
                            <div class="label">
                                <span class="header_text">Город</span>
                                <div onclick="showList(this)">
                                    <div class="city">
                                        <?php 
                                            $vailue = $cities[0]['id_city'];
                                            $city = $cities[0]['city'];
                                            echo "<span data-value='$vailue'>$city</span>"
                                        ?>
                                    </div>
                                    <ul class="list">
                                        <?php 
                                            for ($i = 0; $i < count($cities); ++$i) {
                                                $vailue = $cities[$i]['id_city'];
                                                $city = $cities[$i]['city'];
                                                echo "<li data-value='$vailue' onclick='setListValue(this); updateAddress($vailue)'>$city</li>";
                                            }
                                        ?>
                                    </ul>   
                                </div>
                                <span class="error_text">Не выбран город</span>
                            </div>
                        </div>
                    </div>
                    <div class="order">
                        <div class="order_header">
                            <h2>Заказ</h2>
                            <span id="sum_price_order">на сумму: <?php echo $sumPrice;?> грн</span>
                        </div>
                        <div class="point_order_goods">
                            <?php 
                                $numberMark = '1'; $markText = 'Выбранные товары';
                                include ('templates/purchase/point.php');

                                for ($i = 0; $i < count($orderGoods); ++$i) {
                                    $good = $orderGoods[$i];
                                    include ('templates/purchase/goods_order.php');
                                }
                            ?>
                        </div>
                        <div class="point_delivery" id="point_delivery">
                            <?php 
                                $numberMark = 2; $markText = 'Доставка';
                                include('templates/purchase/point.php');
                            ?>
                            <div>
                                <ul class="choose_delivery_list">
                                    <?php 
                                        for ($i = 0; $i < count($typesDelivery); ++$i) {
                                            $typeDelivery = $typesDelivery[$i]['type_delivery'];
                                            $idTypeDelivery = $typesDelivery[$i]['id_type_delivery'];
                                            include('templates/purchase/delivery_li.php');
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="point_payment" id="point_payment">
                            <?php 
                                $numberMark = '3'; $markText = 'Способ оплаты';
                                include('templates/purchase/point.php');
                            ?>
                            <div>
                                <ul class="payment_list">
                                    <?php 
                                        for ($i = 0; $i < count($typesPayment); ++$i) {
                                            $typePayment = $typesPayment[$i]['type_payment'];
                                            $idTypePayment = $typesPayment[$i]['id_type_payment'];
                                            include('templates/purchase/payment_li.php');
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="finish_purchase">
                    <span class="text_total">Итого</span>
                    <div class="price_block">
                        <?php 
                            for ($i = 0; $i < count($orderGoods); ++$i) {
                                $price = $orderGoods[$i]->price;
                                echo "  <div class='text_holder'>
                                            <span>1 товар на сумму</span>
                                            <span>$price грн</span>
                                        </div>";
                            }
                        ?>                       
                        <div class="text_holder">
                            <span>Стоимость доставки</span>
                            <span>Бесплатно</span>
                        </div>
                    </div>
                    <div class="total_text_holder">
                        <span>К оплате</span>
                        <span id="sum_price_finish"><b><?php echo $sumPrice;?></b></span>
                    </div>
                    <div id="submit_bt" class="submit_bt" onclick="submitPurchase()">
                        <span>Подтверждение заказа</span>
                    </div>
                    <span class="warning">Получение заказа от 5 000₴ только по паспорту</span>
                </div>
            </form>
        </div>
        <?php include("templates/shop_main/footer.html")?>
    </body>
</html>