<?php           
    require_once ('scripts/php/API/GoodsApi/GoodsApi.php');
    require_once ('scripts/php/API/Api.php');

    
    $str = $_SERVER['REQUEST_URI'];


    // Возникла сложность с GET запросами, их параметрі передаются вместе с адресной строкой,
    // потому необходимо удалить все значения после ?, так же необходимо добавлять в конце '?' чтобы функция могла нормально спарсить
    $requestUri = explode('/', stristr($_SERVER['REQUEST_URI'] . '?', '?', true));
    array_shift($requestUri); // Делается сдвиг потому первый элемент всегда пустой ''


    $currentApi = new GoodApi($requestUri); // текущее API для работы
    $currentApi->run();
?>