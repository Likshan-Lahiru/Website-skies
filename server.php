<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Database credentials
$servername = "localhost";
$username = "root";
$password = "Ijse@1234";
$dbname = "skies";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email) || empty($data->email)) {
        http_response_code(400);
        echo json_encode(array("message" => "Email is required"));
        exit;
    }

    $email = $data->email;

    $stmt = $conn->prepare("INSERT INTO promotions (userEmail) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        // Send Welcome Email
        sendWelcomeEmail($email);
        http_response_code(200);
        echo json_encode(array("message" => "Subscription successful."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to subscribe."));
    }

    $stmt->close();
}

// Function to send welcome email using PHPMailer
function sendWelcomeEmail($toEmail)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lahiru212001@gmail.com';
        $mail->Password = 'wfqm qbdm fxrc npkq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('your-email@gmail.com', 'SKIES Store');
        $mail->addAddress($toEmail);

        //Content
        $mail->isHTML(false);
        $mail->Subject = 'Welcome to SKIES Store!';
        $mail->Body    = "Welcome to SKIES store!\n\n1000+ products are available in our online store with over 2 years of trusted commitment to delivering good products as you wish. For more details, contact our customer support.\n\nThank you for joining with our store!";

        $mail->send();
        echo 'Email has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$conn->close();
?>
