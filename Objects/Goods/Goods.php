<?php

    class Goods {    
        protected $id_component;
        protected $component;
        protected $cost;
        protected $count_component;
        protected $img;

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