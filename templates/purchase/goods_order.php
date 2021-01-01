<div class="order_goods">
    <div class="order_good">
        <img class="goods_img" <?php echo "src='/Images/PC_component/$good->id_category/$good->img' alt='$good->img'";?>>
        <a class="goods_name" href="/id=<?php echo $good->id_component;?>">
            <span><?php echo $good->name;?></span>
        </a>
    </div>
    <div class="goods_option">
        <div>
            <span class="name_option">Цена</span>
            <span class="value_option"><?php echo $good->price;?></span>
        </div>
        <div>
            <span class="name_option">Количество</span>
            <span class="value_option">1</span>
        </div>
        <div>
            <span class="name_option">Сумма</span>
            <span class="value_option"><?php echo $good->price;?></span>
        </div>
        <span class="delete_text" onclick="deleteFromCart(<?php echo $good->id_component;?>, <?php echo $good->price;?>, this)">Удалить</span>
    </div>
</div>