<?php 
    require_once("DBUtils.php");
    require_once("classes/Directory.php");
	require_once("classes/File.php");
    
    session_start();
    $db = new DataBase();


    if(!isset($_SESSION["history"])) {
        $_SESSION["history"] = array();
    }

    

    function printHeader() {
        echo "<h1>Welcome back, {$_COOKIE["username"]}</h1>";
    }

    /*
        For now only prints files in root, later will be
        changed to curr directory.
    */
    function printCurrDir() {
        global $db;
        $res = $db->getAllFromDir($_COOKIE["username"], "root");
        echo "<h2> Directory </h2>";
        foreach($res["Directory"] as $dir) {
            echo $dir->getHtmlTableRow();
        }

        foreach($res["Files"] as $file) {
            echo $file->getHtmlTableRow();
        }
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
            printHeader();

            printCurrDir();
        ?>
    </body>
</html>