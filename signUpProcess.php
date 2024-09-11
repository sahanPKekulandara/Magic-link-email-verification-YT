<?php
include "connectin.php"; // Include the file to connect to the database

require 'SMTP.php'; // Include SMTP configuration for sending emails
require 'PHPMailer.php'; // Include PHPMailer library
require 'Exception.php'; // Include Exception handling for PHPMailer

use PHPMailer\PHPMailer\PHPMailer; // Use the PHPMailer class
use PHPMailer\PHPMailer\Exception; // Use the Exception class

$email = $_POST["email"]; // Get the email from the form submission
$password1 = $_POST["password1"]; // Get the password from the form submission

if (empty($email)) {
    echo ("Please Enter Your Email"); // If email is empty, return error
} else if (empty($password1)) {
    echo ("Please Enter Your Password"); // If password is empty, return error
} else {

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `verified` = '1'"); 
    // Check if a user with the same email already exists and is verified
    $n = $rs->num_rows; // Get the number of results

    if ($n > 0) {
        echo ("User with the same Email Address already exists."); // If the email already exists, return error
    } else {

        // Generate a token for email verification
        $verification_token = bin2hex(random_bytes(16)); // Create a random token for verification
        
        // Create the verification link with the token
        $verification_link = "http://localhost/test/verify.php?token=" . $verification_token;

        // Set token expiration time (15 minutes from now)
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $d->modify('+15 minutes');
        $token_expiration = $d->format('Y-m-d H:i:s');

        // Insert the new user into the database along with the verification token and its expiration time
        Database::iud("INSERT INTO `users` (`email`, `password`, `verification_token`, `token_expiration`) 
        VALUES ('" . $email . "', '" . $password1 . "', '" . $verification_token . "', '" . $token_expiration . "')");

        $mail = new PHPMailer(true); // Initialize PHPMailer
        try {
            $mail->isSMTP(); // Use SMTP for sending email
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = '*****'; // Your Gmail address
            $mail->Password = '*****'; // Your Gmail password or app password (recommended)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL/TLS encryption
            $mail->Port = 465; // SMTP port for SSL

            // Set the sender's email and name
            $mail->setFrom('your Gmail Address', 'noreply@.com');
            $mail->addAddress($email); // Add the recipient's email

            // Create the email content
            $mail->isHTML(true); // Send as HTML
            $mail->Subject = 'Verify Your Email Address'; // Email subject

            // Email body with a verification link
            $bodyContent = '
                <div style="text-align: center; margin: 35px 0;">
                    <a href="' . $verification_link . '" style="display: inline-block; padding: 16px 34px; background-color: #007bff; color: #ffffff; font-size: 19px; font-weight: bold; text-decoration: none; border-radius: 10px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);">
                        Verify Email
                    </a>
                </div>';
            $mail->Body = $bodyContent;
            $mail->send(); // Send the email

            echo ("success"); // Return "success" if the email is sent
        } catch (Exception $e) {
            echo ("Message could not be sent."); // Return error if the email could not be sent
        }
    }
}
?>
