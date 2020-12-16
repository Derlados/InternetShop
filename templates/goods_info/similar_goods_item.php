<li class="similar_goods_item">
    <a href="/id=<?php echo $similarGood->id_component?>">
        <img class="goods_img" <?php echo "src='/Images/PC_component/$similarGood->id_category/$similarGood->img' alt='$similarGood->img'"?>>
        <span class="goods_name"><?php echo $similarGood->name; ?></span>
    </a>
    <div class="price_and_bts">
        <span><b><?php echo $similarGood->price; ?></b></span>
        <img src="/Images/Site/favorite2.png" alt="favorite2.png">
        <img src="/Images/Site/compare2.png" alt="compare2.png">
    </div>
</li>