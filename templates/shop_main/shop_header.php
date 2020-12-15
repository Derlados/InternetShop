<div class="header_holder">
    <div class="media_header">
        <div class="media_search">
            <input id="in_search_text_media" type="text" placeholder="Поиск" onsubmit="onClickSearch('selected_category_media', 'in_search_text_media')">
            <a href="/cart">
                <img src="/Images/Site/cart.png">
            </a>
        </div>
        <div class="bt_select_category_media" onclick="showCategory('category_list_media')">
            <div class="bt_select_media bt_select_media_arrow">
                <?php 
                    $url = $categories[0]['url_category'];
                    $category = $categories[0]['category'];
                    echo "<span value='$url' id='selected_category_media'>$category</span>"
                ?>        
            </div>
            <ul class="category_list_media" id="category_list_media">
                <?php 
                    for ($i = 0; $i < count($categories); ++$i) {
                        $url = $categories[$i]['url_category'];
                        $category = $categories[$i]['category'];
                        $id = 'selected_category_media';
                        echo "  <div class='bt_select_media' onclick='setCategory(this,"."\"$id\"" .")' value='$url'>
                                    <li>$category</li>
                                </div>";
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="header">
        <a class="logo" href="/">
            <img src="/Images/Site/logo.jpg" style="height: 100%; width: auto;">
        </a>
        <div class="search">
            <div class="bt_select_category" onclick="showCategory('category_list')">
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
                            $id = 'selected_category';
                            echo "  <div onclick='setCategory(this,"."\"$id\"" .")' value='$url'>
                                        <li>$category</li>
                                    </div>";
                        }
                    ?>
                </ul>
            </div>
            <input class="in_search_text" id="in_search_text" type="text" placeholder="Поиск">
            <div class="bt_search_action" onclick="onClickSearch('selected_category', 'in_search_text')">
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
