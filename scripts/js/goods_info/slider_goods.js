const WIDTH_SLIDER_ITEM = 250 // Длинна одного товара
let currentMaxitems = 0 // Текущее максимальное количество товаров которые помещаются
let lastDirection = 1 // TODO

/** Инициализация объектов при загрузке страницы
 */
function init() {
    let goodsSlider = document.getElementById("goods_slider")
    let goodsItems = goodsSlider.children
    for (i = 0; i < goodsItems.length; ++i)
        goodsItems[i].style.left = "0px"
    resize()
}

/** Изменение слайдера при изменении размера окна
 */
function resize() {
    // TODO
    if (checkCurMaxItems() === true)
        scrollGoods(lastDirection)   

    let goodsSlider = document.getElementById("goods_slider")
    goodsSlider.style.width = currentMaxitems * WIDTH_SLIDER_ITEM + "px"
}

/** Скроллинг слайдера
 * @param direction - направление скроллинга (-1 вправл, 1 - влево) 
 */
function scrollGoods(direction) {
    lastDirection = direction
    let goodsSlider = document.getElementById("goods_slider")
    let goodsItems = goodsSlider.children

    // Получение значений сдвигов (максимально доступгый, текущий и предположительный следующий)
    let maxLeftOffset = (goodsItems.length * WIDTH_SLIDER_ITEM) - currentMaxitems * WIDTH_SLIDER_ITEM
    let currentOffset = parseInt(goodsItems[0].style.left)
    let nextOffset = currentMaxitems * WIDTH_SLIDER_ITEM * direction + currentOffset

    // Корректировка чтобы не было пустых мест
    if (direction == -1 && Math.abs(nextOffset) > maxLeftOffset)
        nextOffset = -maxLeftOffset
    else if (direction == 1 && nextOffset > 0)
        nextOffset = 0;

    // Установка сдвигов
    for (i = 0; i < goodsItems.length; ++i)
        goodsItems[i].style.left = nextOffset + "px"
}

//TODO
/** Проверка и установка максимального количества помещающихся в слайдер товаров
*/
function checkCurMaxItems() {
    let goodsSliderHolder = document.getElementById("goods_slider_holder")
    let width = goodsSliderHolder.offsetWidth
    let newMaxitems = Math.floor(width / WIDTH_SLIDER_ITEM);
    
    let returnBool = !(newMaxitems === currentMaxitems)

    currentMaxitems = newMaxitems
    return returnBool;
}
