<?php
    require_once "db/dbfunction.php";

    $input = file_get_contents('php://input');
    logout();
    echo "logout";
?>