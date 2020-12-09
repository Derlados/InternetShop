const WIDTH_SLIDER_ITEM = 250

function init() {
    let goodsSlider = document.getElementById("goods_slider")
    let goodsItems = goodsSlider.children
    for (i = 0; i < goodsItems.length; ++i)
        goodsItems[i].style.left = "0px"
    resize()
}

function resize() {
    let goodsSlider = document.getElementById("goods_slider")
    goodsSlider.style.width = getMaxItems() + "px"
}

function scrollGoods() {
    let goodsSlider = document.getElementById("goods_slider")
    let goodsItems = goodsSlider.children

    let sliderWidth = getMaxItems() * WIDTH_SLIDER_ITEM
    let maxContentWidth = goodsItems.length * WIDTH_SLIDER_ITEM
    let currentOffset = goodsItems[0].position.left
    
    console.log(goodsItems[0].style.left);
   
    for (i = 0; i < goodsItems.length; ++i) {
        goodsItems[i].style.left = "250px"
    }
}

function getMaxItems() {
    let goodsSliderHolder = document.getElementById("goods_slider_holder")
    let width = goodsSliderHolder.offsetWidth
    return (Math.floor(width / WIDTH_SLIDER_ITEM) * WIDTH_SLIDER_ITEM);
}