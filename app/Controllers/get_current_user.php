<?php
session_set_cookie_params([
    'path'=>'/',
    'domain'=>'localhost',    // remove this
    'secure'=>false,       // ok for dev over HTTP
    'httponly'=>true,
    'samesite'=>'Lax'      // default Lax lets it send on same‑site navigation
  ]);
session_start();


use App\Models\DatabaseHandler;

header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");


require_once '../Models/Database.php';

$database = new DatabaseHandler('localhost', 'test2', 'root', '');

// $services = $database->getAllRecordsWhere("customers", "email", $_SESSION['user_email']);
if(isset($_SESSION['user_email'])){
    $services = $database->getAllRecordsWhere("customers", "email", $_SESSION['user_email']);

}else{
    $services = [];
}

echo json_encode($services);
