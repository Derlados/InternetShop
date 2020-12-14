<?php       
    require_once ('scripts/php/API/Api.php');
    require_once ('scripts/php/API/GoodsApi/GoodsApi.php');    
    require_once ('scripts/php/API/ShopApi/ShopApi.php');

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Expires: " . date("r"));

    $str = $_SERVER['REQUEST_URI'];
    
    // Возникла сложность с GET запросами, их параметрі передаются вместе с адресной строкой,
    // потому необходимо удалить все значения после ?, так же необходимо добавлять в конце '?' чтобы функция могла нормально спарсить
    $requestUri = htmlspecialchars($_SERVER['REQUEST_URI']);
    $requestUri = explode('/', stristr($requestUri . '?', '?', true));
    
    array_shift($requestUri); // Делается сдвиг потому первый элемент всегда пустой ''

    // Определение API для работы с базой
    if ($requestUri[0] == 'cart') {
        array_shift($requestUri);
        $currentApi = new ShopApi($requestUri);     
    }
    else
        $currentApi = new GoodApi($requestUri);
        
    $currentApi->run();
?>