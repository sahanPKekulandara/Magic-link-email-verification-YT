function signUp() {
    var email = document.getElementById("email2").value; // Get the email input value
    var password1 = document.getElementById("password2").value; // Get the password input value

    var f = new FormData(); // Create a new FormData object to send form data via XMLHttpRequest
    f.append("email", email); // Append the email to the form data
    f.append("password1", password1); // Append the password to the form data
    
    document.getElementById("waitMes").style.display = "flex"; // Show the "Please Wait" message

    var r = new XMLHttpRequest(); // Create a new AJAX request
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) { // If the request is complete and successful
            var t = (r.responseText); // Get the server's response

            if(t == "success"){ // If the response is "success", redirect to another page
                window.location = "mailMessage.php"; // Redirect to mailMessage.php
            }else{
                alert(t); // Otherwise, alert the error message
            }
        }
    };
    r.open("POST", "signUpProcess.php", true); // Open a POST request to "signUpProcess.php"
    r.send(f); // Send the form data to the server
}
