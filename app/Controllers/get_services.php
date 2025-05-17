<?php

header("Access-Control-Allow-Origin: *"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type
header('Content-Type: application/json');

require_once '../Models/Database.php';

$database = new \App\Models\DatabaseHandler('localhost', 'test2', 'root', '');

$services = $database->getAllRecords("services");

// $services = [
//     [
//         'id' => 1,
//         'title' => 'Data Management Solutions',
//         'description' => 'Comprehensive data management solutions to help you organize, analyze, and leverage your data effectively for better business decisions.',
//         'features' => [
//             'Data Analytics',
//             'Data Warehousing',
//             'Data Integration',
//             'Data Governance'
//         ],
//         'category' => 'Data',
//         'icon' => 'box1'
//     ],
//     [
//         'id' => 2,
//         'title' => 'Cloud & Virtualization',
//         'description' => 'Advanced cloud and virtualization services to optimize your IT infrastructure and enhance business scalability.',
//         'features' => [
//             'Cloud Migration',
//             'Virtual Infrastructure',
//             'Cloud Security',
//             'Hybrid Cloud Solutions'
//         ],
//         'category' => 'Cloud',
//         'icon' => 'box2'
//     ],
//     [
//         'id' => 3,
//         'title' => 'Oracle Database Technologies',
//         'description' => 'Expert Oracle database solutions to ensure optimal performance, security, and reliability of your database systems.',
//         'features' => [
//             'Database Administration',
//             'Performance Tuning',
//             'Database Migration',
//             'Oracle Cloud Solutions'
//         ],
//         'category' => 'Database',
//         'icon' => 'box3'
//     ]
// ];

echo json_encode($services);
