<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enable CORS headers
header("Access-Control-Allow-Origin: *"); // Allow all origins (use '*' for testing)
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and preflight OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type"); // Allow JSON content type

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    error_log("Preflight OPTIONS request received.");
    exit(0); // Respond early for preflight requests
}

// Include required files
error_log("Including required files...");
require_once '../app/Models/User.php';
require_once '../app/Models/Customer.php';
require_once '../app/Models/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        error_log("POST request received.");

        // Read raw input from the request body
        $input = file_get_contents('php://input');
        error_log("Raw input received: " . $input);

        // Decode JSON payload
        $data = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decoding error: " . json_last_error_msg());
            http_response_code(400); // Bad Request
            echo "Invalid JSON input.";
            exit;
        }

        error_log("Decoded data: " . print_r($data, true));

        // Validate inputs
        if (
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['phone']) ||
            empty($data['service_type']) ||
            empty($data['service_description'])
        ) {
            error_log("Validation failed: Missing fields.");
            http_response_code(400); // Bad Request
            echo "All fields are required.";
            exit;
        }

        error_log("Input validation passed.");

        // Extract form data
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $service_type = $data['service_type'];
        $service_description = $data['service_description'];

        // Initialize the database handler
        error_log("Initializing DatabaseHandler...");
        $dbHandler = new App\Models\DatabaseHandler(
            host: 'localhost',
            dbname: 'test2',
            username: 'root',
            password: ''
        );

        // Create a new customer
        error_log("Creating Customer object...");
        $customer = new App\Models\Customer();
        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setPhone($phone);
        $customer->setServiceType($service_type);
        $customer->setServiceDescription($service_description);

        // Add the customer to the database
        error_log("Adding customer to database...");
        if ($customer->addCustomerToDB($dbHandler)) {
            error_log("Customer added successfully!");
            http_response_code(200); // OK
            echo "Customer added successfully!";
        } else {
            error_log("Failed to add customer.");
            http_response_code(500); // Internal Server Error
            echo "Failed to add customer.";
        }
    } catch (Exception $e) {
        error_log("Exception caught: " . $e->getMessage());
        http_response_code(500); // Internal Server Error
        echo "Error: " . $e->getMessage();
    }
} else {
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed.";
}
?>