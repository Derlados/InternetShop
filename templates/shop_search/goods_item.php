<div class="goods_item">
    <a href="/id=<?php echo $good->id_component?>">
        <?php if(file_exists("Images/PC_component/$good->id_category/$good->img")): ?> 
            <img class="goods_img" src="/Images/PC_component/<?php echo "$good->id_category/$good->img"?>" alt="">
        <?php else: ?>
            <img class="goods_img" src="/Images/PC_component/<?php echo "$good->id_category/no-photo.png"?>" alt="">
        <?php endif;?>
        <span class="goods_name"><?php echo $good->name?></span>
        <span class="goods_price"><b><?php echo $good->price?> ГРН</b></span>
        <div class="goods_buttons">
            <span class="goods_buy_bt" onclick="addToCart(<?php echo $good->id_component?>)">Купить</span>
            <img class="goods_img_bt" src="/Images/Site/favorite2.png" alt="">
            <img class="goods_img_bt" src="/Images/Site/compare2.png" alt="">
        </div>
    </a>
</div>