<li class="similar_goods_item">
    <a href="/id=<?php echo $similarGood->id_component?>">
        <img class="goods_img" src="/Images/PC_component/<?php echo "$similarGood->id_category/$similarGood->img" ?>">
        <span class="goods_name"><?php echo $similarGood->name; ?></span>
    </a>
    <div class="price_and_bts">
        <span><b><?php echo $similarGood->price; ?></b></span>
        <img src="images/Site/favorite2.png">
        <img src="images/Site/compare2.png">
    </div>
</li>