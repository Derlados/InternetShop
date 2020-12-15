<li class="similar_goods_item">
    <a href="/id=<?php echo $similarGood->id_component?>">
        <img class="goods_img" src="/Images/PC_component/<?php echo "$similarGood->id_category/$similarGood->img" ?>" alt="">
        <span class="goods_name"><?php echo $similarGood->name; ?></span>
    </a>
    <div class="price_and_bts">
        <span><b><?php echo $similarGood->price; ?></b></span>
        <img src="/Images/Site/favorite2.png" alt="">
        <img src="/Images/Site/compare2.png" alt="">
    </div>
</li>