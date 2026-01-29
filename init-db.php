<?php
include 'db.php';
if (strtolower(php_sapi_name()) !== 'cli')
    die("Error: This script must be run from the command line");

$dbpath = DB_PATH . '/' . DB_NAME;
echo "DB_PATH: ".  DB_PATH . PHP_EOL;
echo "Checking path: " . $dbpath . PHP_EOL;

try{
    $conn = new PDO("sqlite:" . $dbpath);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $schemapath = __DIR__ . '/schema.sql';

    if (!($dbfile = fopen($schemapath, "r")))
        die("Error: opening $schemapath");

    $content = fread($dbfile, filesize($schemapath));
    print("Initializing database...\n");
    $conn->exec($content);
    print("Successfully initialized database\n");
} catch( PDOException $e){
    die("\nDatabase Error: ". $e->getMessage() . '\n');
}
?>
