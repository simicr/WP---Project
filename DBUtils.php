<?php 
    require_once("constants.php");
	require_once("classes/Directory.php");
	require_once("classes/File.php");

    class DataBase {
        private $conn;

        public function __construct($configFile = "config.ini") {

            if($config = parse_ini_file($configFile)) {
				$host = $config["host"];
				$database = $config["database"];
				$user = $config["user"];
				$password = $config["password"];
				$this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
			}
			else
				exit("Missing configuration file.");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        }
		
		/*
			Validates the login info, currently note all that secure.
		*/
		public function validate($user, $password) {
			$sql = "SELECT * FROM " . TBL_KORISNIK . " WHERE USER =\"{$user}\" AND PASS = \"{$password}\";";
			$result = $this->conn->query($sql);
			return ($result->rowCount()) > 0;
		}

		/*
			Checks that the Directory $dir is owned by $user.
		*/
		public function validDir($user, $dir) {
			$userID = $this->getUserID($user);

			$sql = "SELECT * FROM " . TBL_DIR . " WHERE IDK={$userID} AND IDD={$dir}";
			$res = $this->conn->query($sql);
			
			return $res-> rowCount() > 0;
		}

		/*
			With the given username $user, returns the ID in the Users(Korisnik) table.
		*/
		private function getUserID($user) {
			$sql = "SELECT * FROM " . TBL_KORISNIK . " WHERE USER=\"{$user}\";";
			$result = $this->conn->query($sql);
			return (int) $result->fetch()["IDK"];
		}

		/*
			Gets the content of the directory $dir of user $user.
		*/
		public function getAllFromDir($user, $dir) {
			$result = array();
			$resultChild = array();
			$resultFiles = array();

			$userID = $this->getUserID($user);
			$sql = "SELECT * FROM " . TBL_DIR . 
					" WHERE RODITELJ IN (SELECT IDD FROM ". TBL_DIR . " WHERE IDD={$dir} AND IDK={$userID})";
			$childDir = $this->conn->query($sql);
			foreach($childDir as $row) { $resultChild[] = new Direktorijum($row);}

			$sql = "SELECT * FROM " . TBL_FILE . " WHERE IDD IN (SELECT IDD FROM " . TBL_DIR . " WHERE IDD={$dir})";
			$files = $this->conn->query($sql);
			foreach($files as $row) {$resultFiles[] = new Fajl($row); }


			$result["Files"] = $resultFiles;
			$result["Directory"] = $resultChild;
			return $result;
		}

		/*
			Gets the $user root directory
		*/
		public function getRootDir($user) {
			$userID = $this->getUserID($user);
			$sql = "SELECT * FROM " . TBL_DIR . " WHERE IDK={$userID} AND IME=\"root\"";
			$res = $this->conn->query($sql)->fetch();
			return new Direktorijum($res);
		}

		/*
			Gets the directory with the ID $dir
		*/
		public function getDir($dir) {
			$sql = "SELECT * FROM " . TBL_DIR . " WHERE IDD={$dir}";
			$res = $this->conn->query($sql)->fetch();
			return new Direktorijum($res);
		}

		/*
			Gets the parent directory of $dir. 
		*/
		public function getParentDir($dir) {
			$sql = "SELECT * FROM " . TBL_DIR . " WHERE IDD={$dir}";
			$res = $this->conn->query($sql)->fetch();
			$sql = "SELECT * FROM " . TBL_DIR . " WHERE IDD={$res["RODITELJ"]}";
			$res = $this->conn->query($sql)->fetch();
			return new Direktorijum($res);
		}
	}

?>