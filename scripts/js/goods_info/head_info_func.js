let warranty = 0 // TODO

function checkedWarranty(checkmark) {
    liWarrantyBt = document.getElementById("warranty_year").children
    for (i = 0; i < liWarrantyBt.length; ++i)
        liWarrantyBt[i].children[0].children[0].checked = ""

    if (checkmark.checked) {
        liWarrantyBt[0].children[0].children[0].checked = "checked"
    }
}

function checkedRadioWarranty(radioBt) {
    checkmark = document.getElementById("checkmark_warranty")

    if (radioBt.checked)
        checkmark.checked = "checked"
}