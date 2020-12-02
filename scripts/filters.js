function hideCheckbox(idItem, idImg) {
    let filter_item = document.getElementById(idItem);
    let filter_img = document.getElementById(idImg);
    console.log(idImg);
    let checkboxes = filter_item.children;

    if (checkboxes[1].style.display != 'flex')
        filter_img.src = "Images/Site/filter_arrow.png";
    else
        filter_img.src = "Images/Site/filter_arrow_right.png";

    for (let i = 0; i < checkboxes.length; i++)
        if (checkboxes[i].className == "checkbox") {
            if (checkboxes[i].style.display != 'flex')
                checkboxes[i].style.display = 'flex'
            else 
                checkboxes[i].style.display = 'none'
        }
}
