<?php
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// Set headers for JSON responses.
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
