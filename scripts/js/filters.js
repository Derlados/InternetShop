/** Раскрывает и скрывает чекбокс список фильтров
 * @param idItem - id контейнера в котором находится список фильтров 
 * @param idImg - id изображения (стрелочки) для изменения вида
 */
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

    hideFilterFinded();
}

let filters = new Map() // Мапа в которой сохраняются все выборы пользователя 

/** Запоминание изменения в фильтрах после соответствующих действий пользователя
 * @param element - html элемент выбранного чекбокса 
 */
function checkedFilter(element) {
    showFilterFinded(element)
    let filterValue = element.getAttribute('value');
    let filterGroupId = element.parentElement.parentElement.getAttribute('id');

    if (element.checked)
        addToMap(filterGroupId, filterValue)
    else
        deleteFromMap(filterGroupId, filterValue)

    ajaxUpdateFinded();
}

/** Показывает подсказку о том сколько найдено продуктов по фильтрам и "показать"
 *  @param element - чекер марка на которую нажали, нужна для того чтобы на её высоти отобразить подсказку
 * */ 
function showFilterFinded(element) {
    let filterFinded = document.getElementById('filter_finded');
    filterFinded.style.visibility = 'visible';
    filterFinded.style.top =  element.offsetTop + 'px';
    filterFinded.style.left = element.offsetLeft + 100 + 'px';
}

/** Скрытие подсказки о найденных товарах
 */
function hideFilterFinded() {
    let filterFinded = document.getElementById('filter_finded');
    filterFinded.style.visibility = 'hidden';
}

/** Отображение страницы с выбранными фильтрами
 */
function showWithFilters() {
    document.location = getHref(false);
}

/** AJAX звпрос который считает количество найденных товаров в соответствии с фильтрами
 */
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

/** Создание href в соответствии с выбранными фильтрами
 * @param isJson - булевская переменная, true - запрос с типо возвращаемого значения (json), false - обычный переход на страницу
 */
function getHref(isJson) {
    let arrayOfStrings = (document.location.toString()).split("page", 1)
    arrayOfStrings = (arrayOfStrings[0]).split('/')

    if (isJson === true)
        href = 'http://'+ arrayOfStrings[2] +'/json/' + arrayOfStrings[3] + '/filters=' + filters.size
    else
        href = 'http://'+ arrayOfStrings[2] +'/' + arrayOfStrings[3] + '/filters=' + filters.size

    for (let arrValue of filters.values()) {
        for (let i = 0; i < arrValue.length; i++)
            href += ',' + arrValue[i]
    }

    return href
}

/** Добавление новых значений в мап, если группы филтров в мапе нету - создается новая группа
 *  @param filter - группа фильтров в которой был сделан выбор
 *  @param value - значение выбранного фильтра (id) 
 *  */ 
function addToMap(filter, value) {
    if (!filters.has(filter))
        filters.set(filter, new Array())

    let arrValue = filters.get(filter);
    arrValue.push(value);
}

/** Удаление элемента из мапа фаильтров, если удаляется последний элемент в группе - удаляется группа в мапе
 *  @param filter - группа фильтров в которой был сделан выбор
 *  @param value - значение выбранного фильтра (id) 
 * */ 
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

/** Восстановление все значений фильтров в filters
 */
function restoreFilters() {
    let filterValues = ((document.location.toString()).match(/filters(=[0-9]+)((,[0-9]+)+)/));
    if (filterValues)

    filterValues = filterValues.replace('filters=', '').split(',');

    htmlFilters = document.getElementById("filters");
    htmlFilterGroups = htmlFilters.children
    
    for (i = 0; i < htmlFilterGroups.length - 1; ++i) {
        htmlFilterList = htmlFilterGroups[i].children
        filterGroupId = htmlFilterGroups[i].getAttribute('id');

        for (j = 0; j < htmlFilterList.length; ++j) {
            htmlFilterValue = htmlFilterList[j].children[0];
            let filterValue = htmlFilterValue.getAttribute('value');

            if (htmlFilterValue.checked) 
                addToMap(filterGroupId, filterValue)
        }
    }
}