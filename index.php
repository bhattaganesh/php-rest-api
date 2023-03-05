<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/config.php';

use Ganesh\PhpRestApi\Database\Database;

$db = Database::getInstance();
$conn = $db->getConnection();

if($conn) {
    echo 'Connected successfully.';
} else {
    echo 'Connection failed';
}