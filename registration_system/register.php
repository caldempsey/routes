<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['user_name'] = $_POST['user_name'];

// Escape all $_POST variables to protect against SQL injections
$user_name = $mysqli->escape_string($_POST['user_name']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
      
// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error);

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (user_name, email, password, hash) "
            . "VALUES ('$user_name','$email','$password','$hash')";

    // Add user to the database
    if ( $mysqli->query($sql) ){

        
        header("location: profile.php"); 

    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}