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

// = // NOTE // = // The following functions provide the Store class object access to a join table and its contents.

        function acquireBrand($new_brand) {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$new_brand->getId()}, {$this->getId()});");
        }

        function deleteBrand($brand_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()} AND brand_id = $brand_id;");
        }

        function getBrands() {

            $collected_brands =
            $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN brands_stores ON (brands_stores.store_id = stores.id)

            JOIN brands ON (brands.id = brands_stores.brand_id) WHERE stores.id = {$this->getId()};");

            $brands = array();

            foreach ($collected_brands as $brand) {

                $name = $brand['name'];
                $id = $brand['id'];
                $number = $brand['number'];
                $new_brand = new Brand($id, $name, $number);
                array_push($brands, $new_brand);

            }
            return $brands;
        }

        static function find($search_id) {

           $found_store = null;
           $stores = Store::getAll();
           
           foreach ($stores as $store) {
               $store_id = $store->getId();
               if ($store_id == $search_id) {
                   $found_store = $store;
               }
           }
           return $found_store;
       }
    }
 ?>
