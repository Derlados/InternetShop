<?php

    class Goods {    
        public $id_component;
        public $name;
        public $id_category;
        public $price;
        public $count_component;
        public $img;
        public $characteristics;
        public $id_description;
        public $description;

        /** 
         * Конструктор - создание нового объекта
         * @param data - сереализованый класс в формате json 
         */
        function __construct($data) {
            foreach ($data as $key=>$value)
                $this->{$key} = $value; 
        }

        public function getAvailibilityStatus() {
            if ($this->count_component > 50)
                return "Есть в наличии";
            else if ($this->count_component < 50)
                return "Заканчивается";
            else
                return "Нет в наличии";
        }

        public function findCharacteristicByName($characteristic) {
            for ($i = 0; $i < count($this->characteristics); ++$i)
                if ($this->characteristics[$i]['characteristic'] == $characteristic)
                    return $this->characteristics[$i];
        }
    }
?>