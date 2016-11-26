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

        static function getAll() {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();

            foreach($returned_brands as $brand) {
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

        static function find($search_id) {

            $found_brand = null;
            $brands = Brand::getAll();

            foreach($brands as $brand) {

                $brand_id = $brand->getId();

                if($brand_id = $searh_id) {

                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        static function clearBrands() {
          $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        function update($new_name) {

            $GLOBALS['DB']->exec("UPDATE brands SET name = '{new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }
    }
 ?>
