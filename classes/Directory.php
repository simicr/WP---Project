<?php
    class Direktorijum {
        private $idd;
        private $idk;
        private $roditelj;
        private $ime;

        public function __construct($row) {
            $this->idd = (int) $row["IDD"];
            $this->idk = (int) $row["IDK"];
            $this->roditelj = (int) $row["RODITELJ"];
            $this->ime = $row["IME"];
        }

        public function getHtml() {
            return 
                "<div> 
                    <a class=\"font-medium text-blue-600 hover:underline\" href=\"?directory={$this->idd}\"> DIR </a> 
                    {$this->ime} 
                </div>";
        }

        public function getID() {
            return $this->idd;
        }

        public function getName() {
            return $this->ime;
        }

        public function getParent() {
            return $this->roditelj;
        }
    }
?>