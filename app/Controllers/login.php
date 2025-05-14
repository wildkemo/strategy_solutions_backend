<?php

header("Access-Control-Allow-Origin: *"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0); // Respond early for preflight requests
}  

// Include required files
    //require_once '../Models/User.php';
    //require_once '../Models/Customer.php';
require_once '../Models/Database.php';



if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {

        http_response_code(400); // Bad Request
        // echo "Invalid JSON input.";
        exit;
    }

    if($data['action'] == "login"){

        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password'];


        //////// SANITIZATION ////////////

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $json_response = [
                'status' => 'fail',
                'message' => 'Invalid Email'
            ];
            echo json_encode($json_response);
            //http_response_code(200); // Bad Request
            exit(1);
        }

        $database = new App\Models\DatabaseHandler(

            host: 'localhost',
            dbname: 'test2',
            username: 'root',
            password: ''
        );

        $user_exists = $database->is_existing("customers", "email", $email);

        if($user_exists == true){
            $json_response = [
                'status' => 'sucess',
                'message' => 'redirect to users page'
            ];
            echo json_encode($json_response);
            exit(0);
        }
        else{
            $json_response = [
                'status' => 'fail',
                'message' => 'You need to Register first'
            ];
            echo json_encode($json_response);
            exit(1);
        }


    }else{
        http_response_code(400); // Bad Request
        exit();
    }



}