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

        function getId() {
            return $this->id;
        }

        static function getAll() {
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

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete() {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
        }

        static function clearBrands() {
          $GLOBALS['DB']->exec("DELETE FROM brands;");
        }



    }
 ?>
