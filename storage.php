<?php 
    require_once("DBUtils.php");
    require_once("classes/Directory.php");
	require_once("classes/File.php");
    
    /*
        Staring the session, emptying the access history,
        setting up the wokring directory.
    */
    session_start();
    $db = new DataBase();
    if(!isset($_SESSION["history"])) {
        $_SESSION["history"] = array();
    }

    $_SESSION["workingDir"] = $db->getRootDir($_COOKIE["username"]);
    if(isset($_GET["directory"])) {
        $dir = htmlspecialchars($_GET["directory"]);
        if($db->validDir($_COOKIE["username"], $dir)) {
            $_SESSION["workingDir"] = $db->getDir($dir);
        }
    } 


    function getHeader() {
        return 
            "<h1>Welcome back, {$_COOKIE["username"]}</h1>";
    }


    /*
        Gets HTML with the contents of the directory.
    */
    function getCurrDir($db) {
        $dirID = $_SESSION["workingDir"]->getID();
        $res = $db->getAllFromDir($_COOKIE["username"], $dirID);
        $result = "<div>";
        
        if($_SESSION["workingDir"]->getName() <> "root") {
            $parent = $db->getParentDir($dirID);
            $result .= "<div> <a href=\"?directory={$parent->getID()}\"> DIR </a> .. </div>";
        }

        if (count($res["Directory"]) + count($res["Files"]) == 0){
            $result .= "<div> No files or directory in this directory. </div>";
            $result .= "</div>";
            return $result;
        }
        foreach($res["Directory"] as $dir) {
            $result .= $dir->getHtml();
        }

        foreach($res["Files"] as $file) {
            $result .=  $file->getHtml();
        }
        $result .= "</div>";
        
        return $result;
    }
?>

<html>
    <head> 
        <title>
            Your PmfStorage 
        </title>   
    </head>
    <body>
        <?php 
            echo getHeader();
            echo "<h2>Access history</h2>";
            echo "<h2> Content of directory </h2>";
            echo getCurrDir($db);
            echo "</br>";
        ?>
        <a href="adding.php"><button> Add new file</button></a>
        /* 
            Need to finish this.
        */
        <a href=""><button> Add new sub-directory</button></a>
        <a href="index.php?exit"><button> Exit storage </button></a>
    </body>
</html>