<?php
    class ReturnValue {
        const GET_NOTHING = 0;
        const GET_OBJECT = 1;
        const GET_ARRAY = 2;
    }

    class DataBase
    {
        private $host;
        private $username;
        private $password;
        private $db_name;
        private $connect;

        public function __construct() {
            $this->host = "localhost";
            $this->username = "root";
            $this->password = "root";
            $this->db_name = "Internet_shop";
            $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
            mysqli_set_charset($this->connect, "utf8");
        }


        /* Выполнение запроса
        * Параметры:
        * query - запрос
        * response - true/false ожидание ответа
        */
        public function execQuery($query, int $returnValue)
        {  
            // Выполнение запроса и получение данных
            $result = mysqli_query($this->connect, $query);   
            
            //Если была получена ошибка, эта ошибка выбрасывается как исключение
            if (mysqli_errno($this->connect)) {
                return;
            }

            // Если ожидается ответ (SELECT запрос), формируется массив данных
            if ($returnValue == ReturnValue::GET_OBJECT)
                return mysqli_fetch_assoc($result);
            else if ($returnValue == ReturnValue::GET_ARRAY)
            {
                if ($result != NULL)
                    $number_of_row = mysqli_num_rows($result);
                else
                    $number_of_row = 0;
                        
                $res_array = array();
                        
                if ($number_of_row > 0)
                    while ($row = mysqli_fetch_assoc($result))
                        $res_array[] = $row;
     
                return $res_array;     
            }
        }

        // Закрывает соединения 
        public function closeConnection() {
            mysqli_close($this->connect);
        }
    }
?>