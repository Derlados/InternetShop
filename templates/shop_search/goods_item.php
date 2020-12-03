<div class="goods_item">
    <a href="http://<?php echo API::$MAIN_DOMAIN?>/id=<?php echo $good->id_component?>">
        <img class="goods_img" src="/images/PC_component/<?php echo "$urlCaregory/$good->img"?>">
        <span class="goods_name"><?php echo $good->name?></span>
        <span class="goods_price"><b><?php echo $good->price?> ГРН</b></span>
        <div class="goods_buttons">
            <a href="http://<?php echo API::$MAIN_DOMAIN?>/id=none">
                <span class="goods_buy_bt">Купить</span>
            </a>
            <img class="goods_img_bt" src="/images/Site/favorite2.png">
            <img class="goods_img_bt" src="/images/Site/compare2.png">
        </div>
    </a>
</div>