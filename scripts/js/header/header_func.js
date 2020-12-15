let allowCloseCategoryList = false

function onClickSearch(idCategory, idSearchText) {
    inputText = document.getElementById(idSearchText).value
    if (inputText.toString() == '')
        return
    category = document.getElementById(idCategory).getAttribute('data-value')

    words = (inputText.toString()).split(' ');
    searchHref = 'http://' +  window.location.hostname + '/' + category + '?search=' + words[0]
    for (i = 1; i < words.length; ++i)
        searchHref += ',' + words[i]

    console.log(searchHref)

    document.location = searchHref
}

function showCategory(id) {
    categoryList = document.getElementById(id)
    if (categoryList.style.display != "block") {
        categoryList.style.display = "block"
        allowCloseCategoryList = false
    }
}

function setCategory(element, id) {
    selectedCategory = document.getElementById(id)
    categoryUrl = element.getAttribute('data-value')
    selectedCategory.setAttribute('data-value', categoryUrl)
    selectedCategory.innerText = element.innerText
}

window.onclick = function (event) {
    categoryList = document.getElementById("category_list")
    if (categoryList.style.display == "block" && allowCloseCategoryList) 
        categoryList.style.display = "none"
   
    categoryList = document.getElementById("category_list_media")
    if (categoryList.style.display == "block" && allowCloseCategoryList) 
        categoryList.style.display = "none"

    allowCloseCategoryList = true
}