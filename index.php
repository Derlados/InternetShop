<?php
    require_once ('ServerAPI/Api.php');
    require_once ('ServerAPI/GoodsAPI/GoodApi.php');

    // Возникла сложность с GET запросами, их параметрі передаются вместе с адресной строкой,
    // потому необходимо удалить все значения после ?, так же необходимо добавлять в конце '?' чтобы функция могла нормально спарсить
    $requestUri = explode('/', stristr($_SERVER['REQUEST_URI'] . '?', '?', true));
    array_shift($requestUri); // Делается сдвиг потому первый элемент всегда пустой ''

    // API
    // $goodApi = new GoodApi($requestUri);
    // $goodApi->run();
    
    
?>