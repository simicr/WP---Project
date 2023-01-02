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
		public function getUserID($user) {
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

		/*
			Inserts a file in the data base.
		*/
		public function insertFile($dir, $fileName) {
			$sql = "INSERT INTO `" . TBL_FILE . "` (`IDD`, `IME`) VALUES ({$dir->getID()}, '{$fileName}');";
			return $this->conn->query($sql);
		}

		/*
			Finds the ID of file given the name and the directory.
		*/
		public function getFileID($fileName, $dir) {
			$sql = "SELECT * FROM " . TBL_FILE . " WHERE IDD={$dir} AND IME=\"{$fileName}\"";
			$res = $this->conn->query($sql)->fetch();
			return $res["IDF"];
		}


		/*
			Checks if a file in that dir exist, could improve so that it checks if the dir is the users.
		*/
		public function isValidFile($idf, $dir) {
			$sql = "SELECT * FROM " . TBL_FILE . " WHERE IDF={$idf} AND IDD={$dir}";

			return $this->conn->query($sql)->rowCount() > 0;
		}
		
		/*
			Returns the file in dir with the idf.
		*/
		public function getFile($idf, $dir) {
			$sql = "SELECT * FROM " . TBL_FILE . " WHERE IDD={$dir} AND IDF={$idf}";
			return new Fajl($this->conn->query($sql)->fetch());
		}

		/*
			Record a new access of a file.
		*/
		public function insertAccesss($acc) {
			$time = date("Y-m-d H:i:s", $acc->getTime());
			$sql = "INSERT INTO `Pristup`(`IDK`, `IDD`, `IDF`, `VREME`) VALUES ({$acc->getUser()}, {$acc->getDir()}, {$acc->getFile()}, '{$time}')";
			$this->conn->query($sql);
		}


		public function directoryExist($user,$name, $parent) {
			$uid = $this->getUserID($user);
			$sql = "SELECT * FROM Direktorijum WHERE RODITELJ={$parent} AND IDK={$uid} AND IME=\"{$name}\"";
			return $this->conn->query($sql)->rowCount() > 0;
		}

		public function insertDirectory($user, $name, $parent) {
			$uid = $this->getUserID($user);
			$sql = "INSERT INTO `Direktorijum`(`IDK`, `RODITELJ`, `IME`) VALUES ({$uid}, {$parent}, \"{$name}\")";
			return $this->conn->query($sql);
		}
	}

?>