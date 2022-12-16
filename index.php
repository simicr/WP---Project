<?php
    require_once("DBUtils.php");
    
    function validateInput($user, $pass) {
        $db = new DataBase();
        return $db->validate($user, $pass);
    }

    if(!isset($_POST["login"])) {
        header('Location: login.php');
    } else {

        $username = htmlspecialchars($_POST["user"]);
        $pass = htmlspecialchars($_POST["pass"]);
        if (validateInput($username, $pass)) {
            setcookie("username", $username, 0);
            header("Location: storage.php");
        } else {
            setcookie("wrongInfo", "Username or password is incorrect", time() + 120);
            header('Location: login.php ');
        }
    }

?>
