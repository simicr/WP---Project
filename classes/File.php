<?php

    class Fajl {
        private $idf;
        private $idd;
        private $ime;

        public function __construct($row) {
            $this->idd = (int) $row["IDD"];
            $this->idf = (int) $row["IDF"];
            $this->ime = $row["IME"];
        }
    }

?>