
<?php 
    // include our connect script 
    require_once("connect.php"); 
    
    // check to see if there is a user already logged in, if so redirect them 
    session_start(); 
    if (isset($_SESSION['username']) && isset($_SESSION['userid'])) 
        header("Location: ./index.php");  // redirect the user to the home page
?>

if (isset($_POST['registerBtn'])){ 
    // get all of the form data 
    $username = $_POST['username']; 
    $email = $_POST['email']; 
    $passwd = $_POST['passwd']; 
    $passwd_again = $_POST['passwd_again']; 
   
 if ($username != "" && $passwd != "" && $passwd_again != ""){
    // make sure the two passwords match
    if ($passwd === $passwd_again){
        // make sure the password meets the min strength requirements
        if ( strlen($passwd) >= 5 && strpbrk($passwd, "!#$.,:;()") != false ){
            // next code block
        }
        else
            $error_msg = 'Your password is not strong enough. Please use another.';
    }
    else
        $error_msg = 'Your passwords did not match.';
}
else
    $error_msg = 'Please fill out all required fields.';
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='{$username}'");
if (mysqli_num_rows($query) == 0){
    // create and format some variables for the database
    $id = '';
    $passwd = md5($passwd);
    $date_created = time();
    $last_login = 0;
    $status = 1;
    
    // next code block
}
else
    $error_msg = 'The username <i>'.$username.'</i> is already taken. Please use another.';
mysqli_query($conn, "INSERT INTO USERS VALUES (
    '{$id}', '{$username}', '{$email}', '{$passwd}', '{$date_created}', '{$last_login}', '{$status}'
)");

// verify the user's account was created
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='{$username}'");
if (mysqli_num_rows($query) == 1){
    
    /* IF WE ARE HERE THEN THE ACCOUNT WAS CREATED! YAY! */
    
    $success = true;
}
else
    $error_msg = 'An error occurred and your account was not created.';
}