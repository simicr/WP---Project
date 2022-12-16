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

    $workingDir = $db->getRootDir($_COOKIE["username"]);
    if(isset($_GET["directory"])) {
        $dir = htmlspecialchars($_GET["directory"]);
        if($db->validDir($_COOKIE["username"], $dir)) {
            $workingDir = $db->getDir($dir);
        }
    } 


    function getHeader() {
        return 
            "<h1>Welcome back, {$_COOKIE["username"]}</h1>";
    }


    /*
        Gets HTML with the contents of the directory.
    */
    function getCurrDir($db, $workingDir) {
        $dirID = $workingDir->getID();
        $res = $db->getAllFromDir($_COOKIE["username"], $dirID);
        $result = "<div>";
        
        if($workingDir->getName() <> "root") {
            $parent = $db->getParentDir($dirID);
            $result .= "<div> <a href=\"?directory={$parent->getID()}\"> DIR </a> .. </div>";
        }

        if (count($res["Directory"]) + count($res["Files"]) == 0){
            return 
                "<div> No files or directory in this directory. </div>";
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
            echo getCurrDir($db, $workingDir);
        ?>
    </body>
</html>