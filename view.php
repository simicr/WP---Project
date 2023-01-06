<?php
    require_once("DBUtils.php");
    require_once("classes/Directory.php");
    require_once("classes/File.php");
    require_once("classes/Access.php");
    
    session_start();
    $db = new DataBase();

    if (!isset($_GET["id"])) {
        header("Location: storage.php");
    }
    $idf = htmlspecialchars($_GET["id"]);

    if(isset($_GET["dir"])) {
        $idDir = htmlspecialchars($_GET["dir"]);
    } else {
        $idDir = $_SESSION["workingDir"]->getID();
    }
    
    if(!$db->isValidFile($idf, $idDir)) {
        header("Location: storage.php");
    }

    $file = $db->getFile($idf, $idDir);
    $user = $db->getUserID($_COOKIE["username"]);
    $acc = new Pristup($user, $idDir, $idf);
    array_unshift($_SESSION["history"], $acc);
    $db->insertAccesss($acc);

?>
<html>
    <head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>
         <?php echo $file->getName()?>
    </title>
    </head>
    <body class="bg-teal-100">
        <div class="flex flex-col items-center justify-center h-screen">
        <b class="text-xl">File</b> <?php echo $file->getName()?> </br>
        <b class="text-xl">Owner</b> <?php echo $_COOKIE["username"] ?> </br>
        <b class="text-xl">Directory</b> <?php echo $db->getDir($idDir)->getName() ?> </br>
        <b class="text-xl">Content of file</b>

        <?php 
            $ext = explode(".", $file->getName())[1];

            if ($ext == "txt"){ 
                echo htmlspecialchars(file_get_contents("res/{$file->getID() }.{$ext}"));
            } else {
                echo "<img src=\"res/{$file->getID() }.{$ext}\">";
            }
        ?>

        </br></br>
        <a class="font-medium text-blue-600 hover:underline" href="storage.php?directory=<?php echo $_SESSION["workingDir"]->getID()?>"><button>Return</button> </a>
        </div>
    </body>
</html>