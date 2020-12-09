function resize_bllock(idElement) {
    let block = document.getElementById(idElement)
    if (block.style.height != "max-content")
        block.style.height = "max-content"
    else
        block.style.height = "190px"
}