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
        echo $_POST["newDir"];
        $newDir = htmlspecialchars($_POST["newDir"]);
        if(!$db->directoryExist($_COOKIE["username"], $newDir, $_SESSION["workingDir"]->getID())) {
            $db->insertDirectory($_COOKIE["username"], $newDir, $_SESSION["workingDir"]->getID());
        } 
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
            $result .= "<div> <a href=\"?directory={$parent}\" class=\"font-medium text-blue-600 hover:underline\"> DIR </a> .. </div>";
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
    <script src="https://cdn.tailwindcss.com"></script>
        <title>
            Your PmfStorage 
        </title>   
    </head>
    <body class="bg-teal-100">
    <div class="flex flex-col items-center justify-center h-screen">
        <?php 
            echo "<h1 class=\"text-2xl\">Welcome back, {$_COOKIE["username"]}</h1>";
            echo "<h2 class=\"text-xl mt-4\">Session history</h2>";
            echo getSesHistory();
            echo "<h2 class=\"text-xl mt-4\"> Content of directory </h2>";
            echo getCurrDir($db);
            echo "</br>";
        ?>
        
        <form action="?directory=<?php echo $_SESSION["workingDir"]->getID()?>" method="POST">
            <input type="text" name="newDir"  placeholder="New folder name..." class="border-solid  border-2 w-full">
            <input class="mt-4 w-full px-6 py-2.5 bg-black text-white" type="submit" value="Add new directory">
        </form> 
        <div class="flex flex-row">
        <a href="adding.php"><button class="mt-4 mr-4 justify-left  px-6 py-2.5 bg-black text-white"> Add new file</button></a>
        <a href="index.php?exit"><button class="mt-4 ml-4 justify-right px-6 py-2.5 bg-black text-white"> Exit storage </button></a>
        </div>
    </div>

    </body>
</html>