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
    }
?>