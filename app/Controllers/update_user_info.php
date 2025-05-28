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
// echo session_id();

// echo "hi";
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");

if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    exit(0);
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    require_once '../Models/Database.php';

    $input = file_get_contents('php://input');
    $data1 = json_decode($input, true);

    $where = ['email' => $_SESSION['user_email']];
    $currentpassword = $data1['currentPassword'];
    unset($data1['currentPassword']);
    unset($data1['confirmPassword']);


    $database = new DatabaseHandler("localhost", "test2", "root", "");

    
    $samepassword = $database->getOneValue("customers", "password", "email", $where['email']);

    if($currentpassword === $samepassword){

        $op = $database->update("customers", $data1, $where);

        $data2 = [
            'name' => $data1['name'],
            'email' => $_SESSION['user_email'],
            'company_name' => $data1['company_name']
        ];
        $op2 = $database->update("orders", $data2, $where);

        // $op2 = 0;

    }else{
        $op = 2;
    }


    // $op = 0;
    if($op == 0 && $op2 == 0){
        echo json_encode([
            'status' => 'success',
            'message' => 'updated successfuly'
        ]);
        // echo $data1;
        exit();

    }
    else if($op == 1){
        echo json_encode([
            'status' => 'error',
            'message' => 'database error'
        ]);
        // echo $data1;
        exit();

    }
    else if($op ==2){
        echo json_encode([
            'status' => 'error',
            'message' => 'Wrong Password'
        ]);
        // echo $data1;
        exit();
    }
    else{
        echo json_encode([
            'status' => 'error',
            'message' => 'Unknown Error'
        ]);
        // echo $data1;
        exit();
    }

}

