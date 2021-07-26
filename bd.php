<?php
    $dsn = "mysql:host=localhost;dbname=mydb";
    $username = "root";
    $password = "root";
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>