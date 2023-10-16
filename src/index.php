<?php

/**
 * Hide AmqpLib warnings with deprecated type
 */
error_reporting(E_ALL & ~E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

//phpinfo();

try {
    $db = new PDO('mysql:host=db;dbname=demo', 'user1', 'pass');

    $stmt = $db->query("SELECT * FROM sad");
    while ($row = $stmt->fetch())
    {
        echo '<pre>';
        print_r($row);
    }
} catch (\Throwable $e) {
    echo "<pre>";print_r($e->getMessage());echo "</pre>";die;
}
