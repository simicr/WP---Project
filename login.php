<?php 
    function login() {
        $errMsg = "";
        if (isset($_COOKIE["wrongInfo"])) {
            $errMsg = $_COOKIE["wrongInfo"];
            $errMsg = "<a style=\"color:red;\">" . $errMsg . "<a>";
            setcookie("wrongInfo", "", time() - 120);
        }
        echo "<div>";
        echo $errMsg;
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