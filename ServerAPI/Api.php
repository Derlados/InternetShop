<?php
    require_once 'Managers/DataBase.php';

    //abstract class Api
    abstract class Api
    {
        protected $method; // Метод запроса (GET/POST/PUT/DELETE)     
        protected $requestUri;   
        protected $action; // Название метода для действия
        protected $db;
  
        //Конструктор "вынимает" из запроса все необходимые данные (тип запроса, параметры переданные в URI, параметры переданные в теле запроса)
        public function __construct($requestUri)
        {
            $this->db = new DataBase();
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->requestUri = $requestUri;     
        }
        
        // Обрабатывает запрос
        public function run()
        {       
            $this->action = $this->getAction(); // Определяем действие  
            return $this->{$this->action}(); // Вызываем метод в соответствии с методом
        }
        
        // Метод API который будет выполнятся в зависимости от типа запроса
        public function getAction()
        {
            switch ($this->method)
            {
                case "POST":
                    return 'createAction';
                    break;
                case "GET":
                    return 'viewAction';
                    break;
                case "DELETE":
                    return 'deleteAction';
                    break;
                case "PUT":
                    return 'updateAction';
                    break;
            }
        }
        
        abstract protected function createAction();
        abstract protected function viewAction();
        abstract protected function deleteAction();
        abstract protected function updateAction();
    }
?>