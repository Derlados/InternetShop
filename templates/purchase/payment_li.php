<li class="choose_payment_li">
    <label class="container_bt">
        <input type="radio" name="payment" onclick="showHiddenElement('payment')">
        <span class="radio_bt"></span>
        <span class="radio_bt_text"> <?php echo $typePayment; ?></span>
    </label>
    <div class="label correct_label">
        <span class="header_text">Введите электронную почту</span>
        <input class="data_text" type="text"></input>
        <span class="error_text">Почта не введена</span>
    </div>
</li>