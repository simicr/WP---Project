<?php 
    require_once("DBUtils.php");
    
    function workingLayout() {
        echo "<h1>Welcome back, {$_COOKIE["username"]}</h1>";
    }

    workingLayout();
?>