function hideCheckbox(idItem, idImg) {
    let filter_item = document.getElementById(idItem);
    let filter_img = document.getElementById(idImg);
    let checkboxes = filter_item.children;

    if (checkboxes[1].style.display != 'flex')
        filter_img.src = "/Images/Site/filter_arrow.png";
    else
        filter_img.src = "/Images/Site/filter_arrow_right.png";

    for (let i = 0; i < checkboxes.length; i++)
        if (checkboxes[i].className == "checkbox") {
            if (checkboxes[i].style.display != 'flex')
                checkboxes[i].style.display = 'flex'
            else 
                checkboxes[i].style.display = 'none'
        }
}

let filters = new Map()
function checkedFilter(element) {
    showFilterFinded(element)
    let filterValue = element.getAttribute('value');
    let filterGroup = element.parentElement.parentElement.getAttribute('id');

    if (element.checked)
        addToMap(filterGroup, filterValue)
    else
        deleteFromMap(filterGroup, filterValue)

    ajaxUpdateFinded();
}

// Показывает подсказку о том сколько найдено продуктов по фильтрам и "показать"
function showFilterFinded(element, number) {
    let filterFinded = document.getElementById('filter_finded');
    filterFinded.style.visibility = 'visible';
    filterFinded.style.top =  element.offsetTop + 'px';
    filterFinded.style.left = element.offsetLeft + 100 + 'px';
}

function showWithFilters() {
   // document.location = getHref(true);
   
}

function ajaxUpdateFinded() {
    const request = new XMLHttpRequest();
    const url = getHref(true);
    request.open('GET', url);
    request.addEventListener("readystatechange", () => {
            if (request.readyState === 4 && request.status === 200) {
                let filterFindedText = document.getElementById('filter_finded_text');
                filterFindedText.textContent = 'Найдено ' +  request.responseText;
            }
    });
    request.send();
}

function getHref(typeJson) {
    let arrayOfStrings = (document.location.toString()).split("page", 1)
    arrayOfStrings = (arrayOfStrings[0]).split('/');

    if (typeJson === true)
        href = 'http://'+ arrayOfStrings[2] +'/json/' + arrayOfStrings[3] + '/filters=' + filters.size
    else
        href = 'http://'+ arrayOfStrings[2] +'/' + arrayOfStrings[3] + '/filters=' + filters.size

    for (let arrValue of filters.values()) {
        for (let i = 0; i < arrValue.length; i++)
            href += ',' + arrValue[i]
    }
    console.log(href);
    return href;
}

// Добавление новых значений в мап, если группы филтров в мапе нету - создается новая группа
function addToMap(filter, value) {
    if (!filters.has(filter))
        filters.set(filter, new Array())

    let arrValue = filters.get(filter);
    arrValue.push(value);
}

// Удаление элемента из мапа фаильтров, если удаляется последний элемент в группе - удаляется группа в мапе
function deleteFromMap(filter, value) {
    let arrValue = filters.get(filter);
    for (let i = 0; i < arrValue.length; ++i) {
        if (arrValue[i] == value) {
            arrValue.splice(i, 1)
            break
        }
    }

    if (arrValue.length == 0) 
        filters.delete(filter)
}