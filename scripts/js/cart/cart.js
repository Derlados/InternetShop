function addToCart(id) {
    const request = new XMLHttpRequest();
    const url = "/cart";
    const params = "id=" + id

    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200) {       
            console.log(request.responseText);
        }
    });

    request.send(params);
    alert('Товар добавлен в корзину');
}

function deleteFromCart(id, price, element) {
    const request = new XMLHttpRequest();
    const url = "/cart/id=" + id;

    request.open("DELETE", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200) {       
            console.log(request.responseText);
        }
    });

    request.send();
    element.parentElement.parentElement.style.display = "none"

    let sumPrice = document.getElementById("sum_price_order").innerText
    sumPrice = parseInt(sumPrice.match(/\d+/)) - price
    document.getElementById("sum_price_finish").innerText = sumPrice + " грн"
    document.getElementById("sum_price_order").innerText = sumPrice + " грн"
}