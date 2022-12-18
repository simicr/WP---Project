<?php 
    function login() {
        $msg = "";
        if (isset($_COOKIE["wrongInfo"])) {
            $msg = $_COOKIE["wrongInfo"];
            $msg = "<a style=\"color:red;\">" . $msg . "<a>";
            setcookie("wrongInfo", "", time() - 120);
        }
        
        if (isset($_COOKIE["bye"])) {
            $msg = $_COOKIE["bye"];
            $msg = "<a style=\"color:green;\">" . $msg . "<a>";
            setcookie("bye", "", time() - 120);
        }
        echo "<div>";
        echo $msg;
        echo "<form method=\"post\" action=\"index.php\">";
        echo "<label for=\"user\">Username</label></br>";
        echo "<input type=\"text\" id=\"user\" name=\"user\"></br>";
        echo "<label for=\"pass\">Password</label></br>";
        echo "<input type=\"password\" id=\"pass\" name=\"pass\"></br>";
        echo "<input type=\"submit\" value=\"Login\" name=\"login\"></br>";
        echo "</form>";
        echo "</div>";
    }

?>
<html>
    <head>
        <title> PmfStorage </title>
    </head>
    <body>
        <?php login() ?>
    </body>
</html>