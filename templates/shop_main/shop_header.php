<div class="header_holder">
    <div class="header">
        <a class="logo" href="http://<?php echo API::$MAIN_DOMAIN; ?>/">
            <img src="/Images/Site/logo.jpg" style="height: 100%; width: auto;">
        </a>
        <div class="search">
            <div class="bt_select_category" onclick="showCategory()">
                <div class="bt_select">
                    <span value="none" id="selected_category">Выберите категорию</span>
                </div>
                <ul class="category_list" id="category_list">
                    <div>
                        <li value="processors" onclick="setCategory(this)">Процессоры</li>
                    </div>
                    <div>
                        <li value="videocard"  onclick="setCategory(this)">Видеокарты</li>
                    </div>
                    <div>
                        <li>Материнские платы</li>
                    </div>
                    <div>
                        <li>Модули памяти для ПК</li>
                    </div>
                    <div>
                        <li>Жесткие диски</li>
                    </div>
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
            <img class="img_button" src="/Images/Site/cart.png">
        </div>
    </div>
</div>
