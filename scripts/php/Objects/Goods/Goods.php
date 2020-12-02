<?php

    class Goods {    
        public $id_component;
        public $name;
        public $price;
        public $count_component;
        public $img;

        /** 
         * Конструктор - создание нового объекта
         * @param data - сереализованый класс в формате json 
         */
        function __construct($data) {
            foreach ($data as $key=>$value)
                $this->{$key} = $value; 
        }
    }
?>