<div class="goods_pager">
    <a <?php echo $backPageHref?>>
        <img class="pager_arrow" src="/Images/Site/pager_arrow_back.png">
    </a>
    <div class="pages_numbers">
        <?php
            for ($i = 0; $i < 7; ++$i) {
                echo '<a href="http://'.API::$MAIN_DOMAIN.'/'.$urlCaregory.'/page='.strval($currentPage + $i).'">
                        <span class=""><b>'.($currentPage + $i).'</b></span>
                      </a>';
            }
        ?>
    </div>
    <a <?php echo $nexrPageHref?>>
        <img class="pager_arrow" src="/Images/Site/pager_arrow_next.png">
    </a>
</div>