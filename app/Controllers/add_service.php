<?php

// use App\Models\Service;
// use App\Models\DatabaseHandler;


header("Access-Control-Allow-Origin: *"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');


// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0); // Respond early for preflight requests
}

    

if($_SERVER['REQUEST_METHOD'] == "POST"){

    require_once '../Models/Service.php';
    require_once '../Models/Database.php';


    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $database = new App\Models\DatabaseHandler('localhost', 'test2', 'root', '');

    $service = new App\Models\Service();

    $service->setTitle($data['title']);
    $service->setDescription($data['description']);
    $service->setCategory($data['category']);
    $service->setFeatures(json_encode($data['features']));
    $service->setIcon($data['icon']);

    $op = $service->addToDB($database);

    if($op == 0){
        echo json_encode(["status" => "success"]);
        http_response_code(200);
        exit();
    }else{
        echo json_encode(["status" => "error"]);
        exit();
    }

    // echo json_encode(["status" => "success"]);


}





