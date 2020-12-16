<li class="choose_delivery_li">
    <div class="delivery_container">
        <label class="container_bt">
            <input type="radio" name="address" onclick="showHiddenElement('delivery')">
            <span class="radio_bt"></span>
            <span class="radio_text"><?php echo $typeDelivery; ?></span>
        </label>
        <span class="radio_text">Бесплатно</span>
    </div>
    <div class="choose_address" onclick="showList(this)">
        <div class="address_text">
            <span class="data" data-value="none">Выберите подходящее отделение</span>
        </div>
        <ul id="type_delivery_<?php echo $idTypeDelivery; ?>" class="list">

        </ul>
    </div>
</li>