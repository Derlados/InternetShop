<div class="goods_item">
    <div class="goods_item_container">
        <a href="/id=<?php echo $good->id_component?>">
            <?php if(file_exists("Images/PC_component/$good->id_category/$good->img")): ?> 
                <img class="goods_img" <?php echo "src='/Images/PC_component/$good->id_category/$good->img' alt = '$good->img'"?>>
            <?php else: ?>
                <img class="goods_img" src="/Images/PC_component/<?php echo "$good->id_category/no-photo.png"?>" alt="no-photo.png">
            <?php endif;?>
            <span class="goods_name"><?php echo $good->name?></span>
            <span class="goods_price"><b><?php echo $good->price?> ГРН</b></span>
        </a>
        <div class="goods_buttons">
            <span class="goods_buy_bt" onclick="addToCart(<?php echo $good->id_component?>)">Купить</span>
            <img class="goods_img_bt" src="/Images/Site/favorite2.png" alt="favorite2.png">
            <img class="goods_img_bt" src="/Images/Site/compare2.png" alt="compare2.png">
        </div>
    </div>
</div>