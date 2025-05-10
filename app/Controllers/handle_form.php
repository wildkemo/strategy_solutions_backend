<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

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
    exit(0); // Respond early for preflight requests
}  

// Include required files
require_once '../Models/User.php';
require_once '../Models/Customer.php';
require_once '../Models/Database.php';








if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // Read raw input from the request body
        $input = file_get_contents('php://input');

        // Decode JSON payload
        $data = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad Request
            // echo "Invalid JSON input.";
            exit;
        }


        // Validate inputs
        if (
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['phone']) ||
            empty($data['service_type']) ||
            empty($data['service_description'])

        ) {

            http_response_code(400); // Bad Request
            // echo "All fields are required.";
            exit;

        }


        // Extract form data
        $Cname = $data['name'];
        $Cemail = $data['email'];
        $Cphone = $data['phone'];
        $Cservice_type = $data['service_type'];
        $Cservice_description = $data['service_description'];


        // Initialize the database handler
        $dbHandler = new App\Models\DatabaseHandler(

            host: 'localhost',
            dbname: 'test2',
            username: 'root',
            password: ''
        );



        if($Cemail == "admin@gmail.com"){

            $adminResponse = [
                'databaseSucess' => 'true',
                'emailSucess' => 'true',
                'usertype' => 'admin'
            ];

            echo json_encode($adminResponse);

        }
        else{

            

            // Create a new customer
            $customer = new App\Models\Customer();
            $customer->setName($Cname);
            $customer->setEmail($Cemail);
            $customer->setPhone($Cphone);
            $customer->setServiceType($Cservice_type);
            $customer->setServiceDescription($Cservice_description);



            ///////////////////// SENDING A MAIL

            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'internova.official@gmail.com';
                $mail->Password   = 'ozps yvxc kepw caxa'; // App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
            
                // Recipients
                $mail->setFrom('karimelbanna383@gmail.com', 'kemoooo');
                $mail->addAddress($Cemail, $Cname);
            
                // Additional headers
                $mail->addCustomHeader('X-Mailer', 'PHPMailer');
                $mail->addCustomHeader('Precedence', 'bulk');
            
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Service Request Confirmation';
                $mail->Body    = "
                    <h1>Thank You for Your Submission!</h1>
                    <p>Hello $Cname,</p>
                    <p>We have received your service request and will get back to you shortly.</p>
                    <p><strong>Service Type:</strong> $Cservice_type</p>
                    <p><strong>Description:</strong> $Cservice_description</p>
                    <p>Best regards,<br>Strategy Solutions</p>
                ";
                $mail->AltBody = "Thank you for your submission, $Cname. We have received your service request and will get back to you shortly.";
            
                // Send the email
                $mail->send();
                $emailSucess = 'true';
                // echo 'Email sent successfully!';
            } catch (Exception $e) {
                // echo "Failed to send email. Error: {$mail->ErrorInfo}";
                $emailSucess = 'false';
            }

            // Add the customer to the database
            if ($customer->addCustomerToDB($dbHandler)) {

                $userResponse = [
                    'databaseSucess' => 'true',
                    'emailSucess' => $emailSucess,
                    'usertype' => 'customer'
                ];
                echo json_encode($userResponse);
                // echo "Customer added successfully!";
                
                http_response_code(200); // OK
                
            } else {

                $userResponse = [
                    'databaseSucess' => 'false',
                    'emailSucess' => $emailSucess,
                    'usertype' => 'customer'
                ];
                echo json_encode($userResponse);

                http_response_code(500); // Internal Server Error
                // echo "Failed to add customer.";
            }

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