let allowCloseCategoryList = false

function onClickSearch() {
    inputText = document.getElementById("in_search_text").value
    if (inputText.toString() == '')
        return
    category = document.getElementById("selected_category").getAttribute('value')

    words = (inputText.toString()).split(' ');
    searchHref = 'http://' +  window.location.hostname + '/' + category + '?search=' + words[0]
    for (i = 1; i < words.length; ++i)
        searchHref += ',' + words[i]

    console.log(searchHref)

    document.location = searchHref
}

function showCategory() {
    categoryList = document.getElementById("category_list")
    if (categoryList.style.display != "block") {
        categoryList.style.display = "block"
        allowCloseCategoryList = false
    }
}

function setCategory(element) {
    selectedCategory = document.getElementById("selected_category")
    categoryUrl = element.getAttribute('value')
    selectedCategory.setAttribute('value', categoryUrl)
    selectedCategory.innerText = element.innerText
    console.log(selectedCategory.innerText)
}

window.onclick = function (event) {
    categoryList = document.getElementById("category_list")
    if (categoryList.style.display == "block" && allowCloseCategoryList) 
        categoryList.style.display = "none"
    allowCloseCategoryList = true
}