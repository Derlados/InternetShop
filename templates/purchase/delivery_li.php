<li class="choose_delivery_li">
    <label class="container_bt">
        <input type="radio" name="address" onclick="showHiddenElement('delivery')">
        <span class="radio_bt"></span>
        <div class="radio_bt_text">
            <span><?php echo $typeDelivery; ?></span>
            <span>Бесплатно</span>
        </div>
    </label>
    <div class="choose_address" onclick="showList(this)">
        <div class="address_text">
            <span class="data" value="none">Выберите подходящее отделение</span>
        </div>
        <ul id="type_delivery_<?php echo $idTypeDelivery; ?>" class="list">

        </ul>
    </div>
</li>