<?php
    class Cart
    {
        protected $data = [];
        
        protected $name = 'MY_SHOP_CART';
    

        public function __construct() {
            $this->decode();
        }
        
        public function set($id) {
            if (!in_array($id, $this->data)) {
                $this->data[] = (int) $id;
            }
        }
        
        public function get() {
            return $this->data;
        }
        
        public function delete($id){
            if (false !== $key = array_search($id, $this->data)) {
                unset($this->data[$key]);
            }
        }
        
        protected function decode() {        
            $data = $_COOKIE[$this->name] ?? '';
            
            if ($data = json_decode($data, true)) {
                $this->data = array_filter($data, 'is_int');
            }
        }

        public function save() {
            setcookie($this->name, json_encode($this->data), time() + 30 * 86400);
        }
    }
?>
