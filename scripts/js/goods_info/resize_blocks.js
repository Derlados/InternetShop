const SHOW_FULL_INFO = "Показать полностью", HIDE_INFO = "Скрыть"

/**
 * 
 * @param {*} idElement 
 * @param {*} thisBt 
 */
function resize_bllock(idElement, thisBt) {
    let block = document.getElementById(idElement)

    let height = parseInt(block.children[0].offsetHeight)
    if (parseInt(block.style.height) < height) {
        block.style.height = height + "px"
        thisBt.innerText = HIDE_INFO  
    }
    else {
        block.style.height = "190px"
        thisBt.innerText = SHOW_FULL_INFO
    }
}