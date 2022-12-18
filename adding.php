<?php
    require_once("DBUtils.php");
    session_start();
    $msg = "File uploaded to the server";
    $db = new DataBase();
    function getUploadForm() {
        return 
            "
            <div>
            <form method=\"post\" action=\"\" enctype=\"multipart/form-data\">
            <h2>Select a file to upload to {$_COOKIE["username"]} 's directory:</h2> </br>
            <input type=\"file\" name=\"file\"> </br>
            <input type=\"submit\" value=\"Upload\" name=\"uploadFile\"> </br>
            </form>
            </div>
            ";
    }

    /*
        Should check if file exist?
    */
    function isValid() {
        if($_FILES["file"]["size"] > 100000) {
            global $msg;
            $msg = "File is to large";
            return 0;
        }

        $allowed = array("jpg", "jpeg", "png","txt");
        $filename = $_FILES['file']["name"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed)) {
            global $msg;
            $msg = "The uploaded extension is of wrong type. Only jpg and txt allowed.";
            return 0;
        }

        return 1;
    }
?>
<html>
    <head>

    </head>
    <body>
        <?php
            if (!isset($_POST["uploadFile"])) {
                echo getUploadForm();
            } else {
                if(isValid()) {
                    $filename = htmlspecialchars($_FILES["file"]["name"]);
                    $db->insertFile($_SESSION["workingDir"], $filename);
                    $id = $db->getFileID($filename, $_SESSION["workingDir"]->getID());  
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES["file"]["tmp_name"], "res/{$id}.{$ext}");
                    echo "<p style=\"color:green;\">{$msg}</p>";
                } else {
                    echo "<p style=\"color:red;\">{$msg}</p>";
                }
            }
            echo "</br>";
        ?>
        <a href="storage.php?directory=<?php echo $_SESSION["workingDir"]->getID();?>">Back</a>
    </body>
</html>