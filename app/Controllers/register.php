<?php
session_set_cookie_params([
    'path'=>'/',
    'domain'=>'localhost',    // remove this
    'secure'=>false,       // ok for dev over HTTP
    'httponly'=>true,
    'samesite'=>'Lax'      // default Lax lets it send on same‑site navigation
  ]);
session_start();

header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");




if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0); // Respond early for preflight requests
} 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_SESSION['logged_in_user']) || isset($_SESSION['logged_in_admin'])){

        echo json_encode([
            'status' => 'error',
            'message' => 'logout first before you register'
        ]);
        exit(0);
    }

    require_once '../Models/Database.php';
    require_once '../Models/User.php';
    require_once '../Models/Customer.php';

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $dbHandle = new App\Models\DatabaseHandler(host:'localhost', dbname:'test2', username:'root', password:'');

    $user = new App\Models\Customer();

    $user->setName($data['name']);
    $user->setEmail($data['email']);
    $user->setPhone($data['phone']);
    $user->setGender($data['gender']);
    $user->setPassword($data['password']);
    $user->setCompanyName($data['company_name']);

    $op = $user->addToDB($dbHandle);

    if($op == 0){
        echo json_encode([
            'status' => 'success',
            'message' => 'register user'
        ]);
    }
    else if($op == 2){
        echo json_encode([
            'status' => 'error',
            'message' => 'User already exists'
        ]);
    }else if($op == 1){
        echo json_encode([
            'status' => 'error',
            'message' => 'An Error happened with the database'
        ]);
    }
    
}




