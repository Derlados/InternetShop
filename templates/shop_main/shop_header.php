<div class="header_holder">
    <div class="header">
        <a class="logo" href="/">
            <img src="/Images/Site/logo.jpg" style="height: 100%; width: auto;">
        </a>
        <div class="search">
            <div class="bt_select_category" onclick="showCategory()">
                <div class="bt_select">
                    <?php 
                        $url = $categories[0]['url_category'];
                        $category = $categories[0]['category'];
                        echo "<span value='$url' id='selected_category'>$category</span>"
                    ?>        
                </div>
                <ul class="category_list" id="category_list">
                    <?php 
                        for ($i = 0; $i < count($categories); ++$i) {
                            $url = $categories[$i]['url_category'];
                            $category = $categories[$i]['category'];
                            echo "  <div onclick='setCategory(this)' value='$url''>
                                        <li>$category</li>
                                    </div>";
                        }
                    ?>
                </ul>
            </div>
            <input class="in_search_text" id="in_search_text" type="text" placeholder="Поиск">
            <div class="bt_search_action" onclick="onClickSearch()">
                <span>Найти</span>
            </div>
        </div>
        <div class="buttons">
            <img class="img_button" src="/Images/Site/call.png">
            <img class="img_button" src="/Images/Site/favorite.png">
            <img class="img_button" src="/Images/Site/compare.png">
            <a href="/cart">
                <img class="img_button" src="/Images/Site/cart.png">
            </a>
        </div>
    </div>
</div>
