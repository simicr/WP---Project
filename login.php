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
            $msg = "<a class=\"text-white\">" . $msg . "<a>";
            setcookie("bye", "", time() - 120);
        }
        echo "<div class=\"flex flex-col items-center justify-center h-screen\">";
        echo $msg;
        echo "<form method=\"post\" action=\"index.php\">";
        echo "<label class=\"font-bold text-lg\" for=\"user\">Username</label></br>";
        echo "<input type=\"text\" id=\"user\" name=\"user\" class=\"border-solid  border-2\"></br>";
        echo "<label class=\"font-bold text-lg\" for=\"pass\">Password</label></br>";
        echo "<input type=\"password\" id=\"pass\" name=\"pass\" class=\"border-solid  border-2\"></br>";
        echo "<input class=\"mt-4 w-full px-6 py-2.5 bg-black text-white\" type=\"submit\" value=\"Login\" name=\"login\"></br>";
        echo "</form>";
        echo "</div>";
    }

?>
<html>
    <head>
        <title> PmfStorage </title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-teal-400">
        <?php login() ?>
    </body>
</html>