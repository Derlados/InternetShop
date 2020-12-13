<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/purchase_form/purchase.css">
        <link rel="stylesheet" href="styles/purchase_form/purchase_form.css">
        <link rel="stylesheet" href="styles/purchase_form/order_goods.css">
        <link rel="stylesheet" href="styles/purchase_form/delivery.css">
        <link rel="stylesheet" href="styles/radio_button.css">
        <link rel="stylesheet" href="styles/purchase_form/payment.css">
        <link rel="stylesheet" href="styles/purchase_form/finish_purchase.css">
        <link rel="stylesheet" href="styles/purchase_form/list.css">
        <script src="scripts/js/purchase/purchase_form.js"></script>
    </head>
    <body onload="init(); updateAddress(1)">
        <div class="purchase_body">
            <div class="header_purchase">
                <a class="logo" href="/">
                    <img src="Images/Site/logo.jpg">
                </a>
                <span>Консультации по телефону: +38 044 537 02 22</span>
            </div>
            <h1 class="">Оформление заказа</h1>
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
                                            echo "<span value='$vailue'>$city</span>"
                                        ?>
                                    </div>
                                    <ul class="list">
                                        <?php 
                                            for ($i = 0; $i < count($cities); ++$i) {
                                                $vailue = $cities[$i]['id_city'];
                                                $city = $cities[$i]['city'];
                                                echo "<li value='$vailue' onclick='setListValue(this); updateAddress($vailue)'>$city</li>";
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
                            <span>на сумму: <?php echo $sumPrice;?> грн</span>
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
                            <div сlass="choose_delivery">
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
                            <div сlass="choose_payment">
                                <ul class="payment_list">
                                    <?php 
                                        for ($i = 0; $i < count($typesPayment); ++$i) {
                                            $typePayment = $typesPayment[$i]['type_payment'];
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
                        <span><b><?php echo $sumPrice;?></b></span>
                    </div>
                    <div id="submit_bt" class="submit_bt" onclick="submitPurchase()">
                        <span>Подтверждение заказа</span>
                    </div>
                    <span class="warning">Получение заказа от 5 000₴ только по паспорту</span>
                </div>
            </form>
        </div>
    </body>
</html>