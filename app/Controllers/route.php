<?php
session_set_cookie_params([
    'path'=>'/',
    'domain'=>'localhost',    // remove this
    'secure'=>false,       // ok for dev over HTTP
    'httponly'=>true,
    'samesite'=>'Lax'      // default Lax lets it send on same‑site navigation
  ]);
session_start();
// echo session_id();

// echo "hi";
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");

// var_dump($_SESSION);
// phpinfo();

if(isset($_SESSION['logged_in_admin']) && $_SESSION['logged_in_admin'] == true){
    echo json_encode(['status' => 'success']);
}
else{
    echo json_encode(['status' => 'error']);
}