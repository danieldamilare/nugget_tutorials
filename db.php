<?php
require_once __DIR__ . '/config.php';
$dbpath = DB_PATH . '/' . DB_NAME;

function get_db(){
    static $conn;
    if ($conn instanceof PDO)
        return $conn;
    $dbpath = DB_PATH . '/' . DB_NAME;
    $conn =   new PDO("sqlite:" . $dbpath);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $conn;
}
?>
