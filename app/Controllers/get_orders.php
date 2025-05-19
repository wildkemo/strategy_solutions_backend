<?php

use App\Models\DatabaseHandler;

header("Access-Control-Allow-Origin: *"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');

require_once '../Models/Database.php';

$database = new DatabaseHandler('localhost', 'test2', 'root', '');

$services = $database->getAllRecords("orders");

echo json_encode($services);
