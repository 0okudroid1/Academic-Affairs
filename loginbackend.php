


<?php
    // check to see if the user successfully created an account
    if (isset($success) && $success = true){
      echo '<font color="green">You have logged in. Please go to the <a href="./index.php">home page</a>.<font>';
    }
    // check to see if the error message is set, if so display it
    else if (isset($error_msg))
     echo '<font color="red">'.$error_msg.'</font>'; 
?>

if (isset($_POST['loginBtn'])){
    // get the form data for processing
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    
    // make sure the required fields were entered
    if ($username != "" && $passwd != ""){ 
        // next code block
    }
    else
        $error_msg = 'Please fill out all required fields.';
}
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='{$username}'");
if (mysqli_num_rows($query) == 1){
    // get the record from the query
    $record = mysqli_fetch_assoc($query);
    
    // encrypt the user's password
    $passwd = md5($passwd);
    
    // compare the passwords to make sure they match
    if ($passwd === $record['password']){
        // make sure the user has activated their account
        if ($record['status'] == 1){
            // next code block
        }
        else
        $error_msg = 'Please activate your account before you login.';
    }
    else
     $error_msg = 'Your password was incorrect.';
}
else
    $error_msg = 'That account does not exist.';

$last_login = time();
mysqli_query($conn, "UPDATE users SET last_login='{$last_login}' WHERE id='{$record['id']}'");

/* IF YOU GET HERE THE USER CAN LOGIN */

$_SESSION['username'] = $record['username'];
$_SESSION['userid'] = $record['id'];

$success = true;

// redirect the user to the home page
header("Location: ./index.php");