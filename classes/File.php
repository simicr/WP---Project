<?php

    class Fajl {
        private $idf;
        private $idd;
        private $ime;

        public function __construct($row) {
            $this->idd = (int) $row['IDD'];
            $this->idf = (int) $row['IDF'];
            $this->ime = $row['IME'];
        }

        public function getHtml() {
            return 
                "<div> 
                    <a href=\"view.php?id={$this->idf}\"> FILE </a> 
                    {$this->ime} 
                </div>";
        
        
        }

        public function getID() {
            return $this->idf;
        }

        public function getDir() {
            return $this->idd;
        }

        public function getName() {
            return $this->ime;
        }
    }

?>