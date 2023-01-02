<?php 
    require_once("DBUtils.php");
    require_once("classes/Directory.php");
	require_once("classes/File.php");
    require_once("classes/Access.php");
    
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
    

    /*
        Checking where we currently are.
    */
    if(isset($_GET["directory"])) {
        $dir = htmlspecialchars($_GET["directory"]);
        if($db->validDir($_COOKIE["username"], $dir)) {
            $_SESSION["workingDir"] = $db->getDir($dir);
        }
    } 
    
    /*
        Check if we want to create a new directory.
    */
    if (isset($_POST["newDir"])) {
        $dir = htmlspecialchars($_POST["newDir"]);
        if(!$db->directoryExist($_COOKIE["username"], $dir, $_SESSION["workingDir"]->getParent())) {
            $db->insertDirectory($_COOKIE["username"], $dir, $_SESSION["workingDir"]->getID());
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
            $parent = $_SESSION["workingDir"]->getParent();
            $result .= "<div> <a href=\"?directory={$parent}\"> DIR </a> .. </div>";
        }

        if (count($res["Directory"]) + count($res["Files"]) == 0){
            $result .= "<div> <i>No files or sub-directories in this directory. </i> </div>";
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

    function getSesHistory() {
        if(count($_SESSION["history"]) == 0) {
            return "<i>No accesses in this session</i>";
        }

        $end = 6;
        if(count($_SESSION["history"]) < 6) {
            $end = count($_SESSION["history"]);
        }

        $res ="<div>";
        for($i = 0; $i < $end; $i++) {
            $res .= $_SESSION["history"][$i]->getHtml();
        }
        $res .= "</div>";

        return $res;
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
            echo "<h2>Session history</h2>";
            echo getSesHistory();
            echo "<h2> Content of directory </h2>";
            echo getCurrDir($db);
            echo "</br>";
        ?>
        
        <form action="?directory=<?php echo $_SESSION["workingDir"]->getID()?>" method="POST">
            <input type="text" name="newDir">
            <input type="submit" value="Add new directory">
        </form> 
        <a href="adding.php"><button> Add new file</button></a>
        <a href="index.php?exit"><button> Exit storage </button></a>
    </body>
</html>