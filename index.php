<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>               
</head>
<body>
    <h2>Sign Up</h2>
        <input type="email" placeholder="Email" required id="email2"/> <!-- Email input field -->
        <input type="password" placeholder="Password" required id="password2"/> <!-- Password input field -->
        <button onclick="signUp();">Sign Up</button> <!-- Button triggers the signUp() function when clicked -->

        <h1 style="display: none;" id="waitMes">Please Wait... For Redirect to another page</h1>
        <!-- This message is hidden by default and will show while processing -->
    <script src="script.js"></script> <!-- External JavaScript file (script.js) is linked here -->
</body>
</html>
