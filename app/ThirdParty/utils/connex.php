<?php
function connectDB()
{
    static $connex = null;

    $host = "localhost";
    $dbname = "TP_PDF";
    $user = "root";
    $pwd = '';
    try {
        $connex = new PDO("mysql:host=$host:3306;dbname=$dbname", $user, $pwd);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $connex;
}
