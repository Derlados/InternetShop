<div class="goods_item">
    <a href="/id=<?php echo $good->id_component?>">
        <img class="goods_img" src="/Images/PC_component/<?php echo "$good->id_category/$good->img"?>">
        <span class="goods_name"><?php echo $good->name?></span>
        <span class="goods_price"><b><?php echo $good->price?> ГРН</b></span>
        <div class="goods_buttons">
            <a onclick="addToCart(<?php echo $good->id_component?>)">
                <span class="goods_buy_bt">Купить</span>
            </a>
            <img class="goods_img_bt" src="/Images/Site/favorite2.png">
            <img class="goods_img_bt" src="/Images/Site/compare2.png">
        </div>
    </a>
</div>