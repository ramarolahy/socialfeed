<?php 

if(isset($_POST['login_btn'])) {
    // get email
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); // sanitize email

    $_SESSION['log_email'] = $email; // store into session
    $pwd = md5($_POST['log_password']); //get password

    $check_db_query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$pwd'");

    $check_login_query = mysqli_num_rows($check_db_query);
    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_db_query);
        $username = $row['username'];

        $user_closed_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
        if(mysqli_num_rows($user_closed_query) == 1){
            $reopen_account = mysqli_query($conn, "UPDATE users SET user_closed='no' WHERE email='$email'");
        }

        $_SESSION['username'] = $username; // The Session variable will store a username if the user is logged in
        // See http://php.net/manual/en/function.header.php
        header("Location: index.php"); // redirects the browser. Path is relative to register.php
        exit(); // Stops codes below from running
    }
    else {
        array_push($error_array, $error_msgs['login_fail']);
    }

}

?>