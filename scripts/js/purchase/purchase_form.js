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

function setListValue(element) {
    let parent = element.parentElement.parentElement
    let spanText = parent.children[0].children[0]
    let value = element.getAttribute('value')

    spanText.setAttribute('value', value)
    spanText.innerText = element.innerText
}

function checkInput(element) {
    let parentLabel = element.parentElement

    if (element.value == "")
        parentLabel.getElementsByClassName("error_text")[0].style.display = "block"
    else
        parentLabel.getElementsByClassName("error_text")[0].style.display = "none"
}

function updateAddress(id) {
    const request = new XMLHttpRequest();
    const url = document.location.href + "/addresses?id=" + id;
    console.log(url)

    request.open('GET', url);
    request.addEventListener("readystatechange", () => {
            if (request.readyState === 4 && request.status === 200) {
                let addresses = JSON.parse(request.responseText)
                setAddresses(addresses)
            }
    });
    request.send();
}

function setAddresses(addresses) {
    iterAddr = 0
    
    for (i = 1;  i <= deliveryArray.length; ++i) {
        let list = document.getElementById("type_delivery_" + i)
        list.innerHTML = ''

        // Создания списка адресов
        for (j = iterAddr; j < addresses.length; ++j) {
            if (addresses[j].id_type_delivery != i)
                break;
            
            // Создание элемента в списке
            li = document.createElement('li')
            li.setAttribute('onclick', 'setListValue(this)')
            li.setAttribute('value', addresses[j].id_address)
            li.innerText = addresses[j].address
            list.appendChild(li)
            ++iterAddr
        }
    }
}

function submitPurchase() {
    if (checkAllInput() == false)
        alert("Введите и выберите все необходимые поля")
    else {
        alert("Заказ отправлен на обработку")
        window.location = '/';
    }
}

function checkAllInput() {
    let inputLastName =  document.getElementById("label_0")
    let inputFirstName =  document.getElementById("label_1")
    let inputPhone =  document.getElementById("label_2")

    if (inputLastName.value == "" || inputFirstName.value == "" || inputPhone.value == "")
        return false; 

    for (i = 0; i < deliveryArray.length; ++i) {
        let inputAddress = deliveryArray[i].children[0].children[0]
        
        if (inputAddress.checked) {
            if (deliveryArray[i].getElementsByClassName("data")[0].getAttribute('value') != "none")
                break;
            else
                return false;
        }
    }

    if (i == deliveryArray.length) return false;

    for (i = 0; i < paymentArray.length; ++i) {
        let payment = paymentArray[i].children[0].children[0]
        
        if (payment.checked) {
            if (paymentArray[i].getElementsByClassName("data_text")[0].value != "")
                break;
            else
                return false;
        }
    }

    if (i == paymentArray.length) return false;

    return true;
}