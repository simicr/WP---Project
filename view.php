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
    </head>
    <body>
        <b>File:</b> <?php echo $file->getName()?> </br>
        <b>Owner:</b> <?php echo $_COOKIE["username"] ?> </br>
        <b>Directory:</b> <?php echo $db->getDir($idDir)->getName() ?> </br>
        SADRZAJ FAJLA: </br></br>

        <?php 
            $ext = explode(".", $file->getName())[1];

            if ($ext == "txt"){ 
                echo htmlspecialchars(file_get_contents("res/{$file->getID() }.{$ext}"));
            } else {
                echo "<img src=\"res/{$file->getID() }.{$ext}\">";
            }
        ?>

        </br></br>
        <a href="storage.php?directory=<?php echo $_SESSION["workingDir"]->getID()?>"><button>Return</button> </a>

    </body>
</html>