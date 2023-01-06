<?php 

    require_once("DBUtils.php");
    class Pristup{

        private $idk;
        private $idd;
        private $idf;
        private $vreme;

        public function __construct($idk, $idd, $idf) {
            $this->idk = $idk;
            $this->idd = $idd;
            $this->idf = $idf;
            $this->vreme = time();
        }
        
        public function getUser() {
            return $this->idk;
        }
        public function getDir() {
            return $this->idd;
        }
        public function getFile() {
            return $this->idf;
        }
        public function getTime() {
            return $this->vreme;
        }

        public function getHtml() {
            $ime = (new DataBase())->getFile($this->idf, $this->idd)->getName();
            return
            "<div> 
                    <a class=\"font-medium text-blue-600 hover:underline\" href=\"view.php?id={$this->idf}&dir={$this->idd}\"> FILE </a> 
                    {$ime} 
            </div>";
        }
    }

?>