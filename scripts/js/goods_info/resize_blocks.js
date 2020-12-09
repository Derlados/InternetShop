function resize_bllock(idElement) {
    let block = document.getElementById(idElement)

    let height = parseInt(block.children[0].offsetHeight)

    console.log(height)

    if (parseInt(block.style.height) != height)
        block.style.height = height + "px"
    else
        block.style.height = "190px"
}