<?php

include "connectin.php"; // Include the database connection file

if (isset($_GET["token"])) { // Check if the token is provided via the URL
    $token = $_GET['token']; // Get the token from the URL

    // Check if the token exists in the database and has not expired
    $rs = Database::search("SELECT * FROM `users` WHERE `verification_token`='" . $token . "' AND `token_expiration` > NOW()");

    if ($rs->num_rows > 0) { // If a matching token is found and it's still valid (not expired)
        // Update the user record to mark the email as verified
        Database::iud("UPDATE `users` SET `verified`=1 WHERE `verification_token`='" . $token . "'");
        header("Location: index.php"); // Redirect the user to the index page
    } else {
        echo ("Invalid or expired token."); // If the token is invalid or expired, display an error message
    }

} else {
    echo "No token provided."; // If no token is provided in the URL, display an error message
}

?>
