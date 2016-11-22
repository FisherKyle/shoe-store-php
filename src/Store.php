<?php

    class Store {
        private $name;
        private $id;

        function __construct($name, $id=null) {
            $this->name = $name;
            $this->id = $id;
        }

        function getName() {
            return $this->name;
        }

        function getId() {
            return $this->id;
        }

        static function getAll() {
            $collected_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();

            foreach($collected_stores as $store) {
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
           return $stores;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete() {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        function acquireBrand($new_brand) {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$new_brand->getId()}, {$this->getId()});");
        }

        function getBrands() {
            $collected_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores)
            $brands = array();

            return $brands;
        }
    }
 ?>
