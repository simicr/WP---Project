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
            <label class=\"block mb-2 text-sm font-medium text-gray-900 \" for=\"file_input\">Upload file</label>
            <input type=\"file\"class=\" w-full block text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray focus:outline-none \" name=\"file\" id=\"file_input\"> 
            <p class=\"mt-1 text-sm text-gray-500 \" > PNG, JPG or TXT.</p>
            <input class=\"mt-4 w-full px-6 py-2.5 bg-black text-white\" type=\"submit\" value=\"Upload\" name=\"uploadFile\"> </br>
            </form>
            </div>
            ";
    }

    /*
        Should check if file exist?
    */
    function isValid() {
        if($_FILES["file"]["size"] > 1000000) {
            global $msg;
            $msg = "File is to large";
            return 0;
        }

        $allowed = array("jpg", "jpeg", "png","txt");
        $filename = $_FILES['file']["name"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed)) {
            global $msg;
            $msg = "The uploaded extension is of wrong type. Only jpg, jpeg, png and txt allowed.";
            return 0;
        }

        return 1;
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
            if (!isset($_POST["uploadFile"])) {
                echo getUploadForm();
            } else {
                if(isValid()) {
                    $filename = htmlspecialchars($_FILES["file"]["name"]);
                    $db->insertFile($_SESSION["workingDir"], $filename);
                    $id = $db->getFileID($filename, $_SESSION["workingDir"]->getID());  
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $path = __DIR__;
                    $ok = move_uploaded_file($_FILES["file"]["tmp_name"], "{$path}/res/{$id}.{$ext}");
                    if ($ok) {
                        echo "radi";
                    } else {
                        echo "ne radi";
                    }
                    echo "<p style=\"color:green;\">{$msg}</p>";
                } else {
                    echo "<p style=\"color:red;\">{$msg}</p>";
                }
            }
            echo "</br>";
        ?>
        <a class="font-medium text-blue-600 hover:underline" href="storage.php?directory=<?php echo $_SESSION["workingDir"]->getID();?>">Back</a>
        </div>
    </body>
</html>