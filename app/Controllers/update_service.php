<?php


use App\Models\DatabaseHandler;

header("Access-Control-Allow-Origin: *"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === "OPTIONS"){
    exit(0);
}


if($_SERVER['REQUEST_METHOD'] === "POST"){

    require_once '../Models/Database.php';

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $where = ['id' => $data['id']];
    unset($data['id']);

    $database = new DatabaseHandler("localhost", "test2", "root", "");

    $op = $database->update("services", $data, $where);

    // $op = 0;
    if($op == 0){
        echo json_encode([
            'status' => 'success',
            'message' => 'updated successfuly'
        ]);
        exit();
    }
    else{
        echo json_encode([
            'status' => 'error',
            'message' => 'database error'
        ]);
        exit();
    }




}