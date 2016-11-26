<?php

    class Brand {
        private $name;
        private $id;

        function __construct($name, $id=null) {
            $this->name = $name;
            $this->id = $id;
        }

        function getName() {
            return $this->name;
        }

        function setName($new_name) {
            $this->name = (string) $new_name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
          $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function addStore($new_store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$new_store->getId()});");
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN brands_stores ON (brands_stores.brands_id = brands.id)
                JOIN stores ON (stores.id = brands_stores.stores_id)
                WHERE brands.id = {$this->getId()};");
            $stores = array();
            foreach ($returned_stores as $store)
            {
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function getAll()
        {
            $collected_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($collected_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        function delete() {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores;");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach ($brands as $brand) {
                if ($brand->getId() == $search_id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }
    }
 ?>
