let deliveryArray, paymentArray;

function init() {
    let pointDelivery = document.getElementById("point_delivery")
    let pointPayment = document.getElementById("point_payment")
    
    deliveryArray = pointDelivery.getElementsByClassName("choose_delivery_li")
    paymentArray = pointPayment.getElementsByClassName("choose_payment_li")
}

function showHiddenElement(typeElement) {
    let elementsArray
    let displayStyle
    if (typeElement == "delivery") {
        elementsArray = deliveryArray
        displayStyle = "block"
    }
    else {
        elementsArray = paymentArray
        displayStyle = "flex"
    }

    for (i = 0; i < elementsArray.length; ++i) {
        let inputAddress = elementsArray[i].children[0].children[0]
        let addressSpin = elementsArray[i].children[1]
       
        if (inputAddress.checked)
            addressSpin.style.display = displayStyle
        else
            addressSpin.style.display = "none"
    }
} 

function showList(element) {
    let list = element.children[element.children.length - 1]

    if (list.style.display != "block")
        list.style.display = "block"
    else
        list.style.display = "none"
}

function setDelivery(element) {
    let parent = element.parentElement.parentElement
    let spanText = parent.children[0].children[0]
    let value = element.getAttribute('value')

    spanText.setAttribute('value', value)
    spanText.innerText = element.innerText
}

function checkInput(element) {
    let parentLabel = element.parentElement

    if (element.innerText == "")
        parentLabel.getElementsByClassName("error_text")[0].style.display ="block"
}