let warranty = 0 // TODO

/** Нажатие на чекмарку. 
 * Когда она стновится активно - первая радиокнопка тоже становится активной
 * Если марка стала неактивной - так же убираются радиокнопки
 * @param checkmark - сам маркер
 */
function checkedWarranty(checkmark) {
    liWarrantyBt = document.getElementById("warranty_year").children
    for (i = 0; i < liWarrantyBt.length; ++i)
        liWarrantyBt[i].children[0].children[0].checked = ""

    if (checkmark.checked) {
        liWarrantyBt[0].children[0].children[0].checked = "checked"
    }
}

/** Нажатие на радиокнопку влечет за собой так же активацию марки
 * @param radioBt - сама кнопка
 */
function checkedRadioWarranty(radioBt) {
    checkmark = document.getElementById("checkmark_warranty")

    if (radioBt.checked)
        checkmark.checked = "checked"
}