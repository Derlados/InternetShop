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
                $this->data[$id] = (int) $id;
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
            $json = json_encode($this->data);
            $status = setcookie($this->name, $json, time() + 30 * 86400, '/');
        }
    }
?>