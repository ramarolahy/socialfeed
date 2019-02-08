<?php
// Declare variables to prevent errors
$fname = "";
$lname = "";
$email = "";
$conf_email = "";
$pwd = "";
$conf_pwd = "";
$date = "";
$error_array = []; // to store error messages as they get called
$error_msgs = [
    "fname" => "<span class='error__message'>First name must be between 2 and 25 characters. <span>",
    "lname" => "<span class='error__message'>Last name must be between 2 and 25 characters. <span>",
    "email_inuse" => "<span class='error__message'>Email already in use.<span>",
    "email_format" => "<span class='error__message'>Invalid email format. <span>",
    "email_match" => "<span class='error__message'>Emails do not match. <span>",
    "pwd_char_num" => "<span class='error__message'>Passwords must be between 5 and 30 characters.<span>",
    "pwd_char" => "<span class='error__message'>Only use english characters and numbers.<span>",
    "pwd_match" => "<span class='error__message'>Passwords do not match.<span>",
    "login_fail" => "<span class='error__message'>The email or password you provided could not be found .</span>",
    "signup_success" => "<span style='color=#22b0e7'>All set! Welcome to the Social Feed!</span>"
];

// if submit btn is pressed
if (isset($_POST['reg_submit_btn'])) {
    // get fname value from form
    $fname = strip_tags($_POST['reg_fname']); // remove html tags
    $fname = str_replace(' ', '', $fname); // remove spaces
    $fname = ucfirst(strtolower($fname)); // lowercase all first then uppercase first letter
    $_SESSION['reg_fname'] = $fname; // Stores fname into session variable

    // get lname value form form
    $lname = strip_tags($_POST['reg_lname']); // remove html tags
    $lname = str_replace(' ', '', $lname); // remove spaces
    $lname = ucfirst(strtolower($lname)); // lowercase all first then uppercase first letter
    $_SESSION['reg_lname'] = $lname; // Stores lname into session variable

    // get email
    $email = strip_tags($_POST['reg_email1']); // remove html tags
    $email = str_replace(' ', '', $email); // remove spaces
    $email = ucfirst(strtolower($email)); // lowercase all first then uppercase first letter
    $_SESSION['reg_email1'] = $email; // Stores email1 into session variable

    $conf_email = strip_tags($_POST['reg_email2']); // remove html tags
    $conf_email = str_replace(' ', '', $conf_email); // remove spaces
    $conf_email = ucfirst(strtolower($conf_email)); // lowercase all first then uppercase first letter
    $_SESSION['reg_email2'] = $conf_email; // Stores conf_email into session variable

    //get pwd value
    $pwd = strip_tags($_POST['reg_pwd1']); // remove html tags
    $conf_pwd = strip_tags($_POST['reg_pwd2']); // remove html tags
    // date
    $date = date("Y-m-d");

    /**
     * ADD DOM MANIPULATION FOR ERROR MESSAGES
     */
    if ($email == $conf_email) {
        // check email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // assign validated value
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            // check if email already exist
            $e_check = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
            // verify if e_check contains anything
            $num_rows = mysqli_num_rows($e_check);
            if ($num_rows > 0) {
                array_push($error_array, $error_msgs['email_inuse']);
            }
        } else {
            array_push($error_array, $error_msgs['email_format']);
        }

    } else {
        array_push($error_array, $error_msgs['email_match']);
    }

    if(strlen($fname) > 25 || strlen($fname) < 3) {
        array_push($error_array, $error_msgs['fname']);
    }
    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, $error_msgs['lname']);
    }
    // Check if pwds match
    if($pwd != $conf_pwd) {
        array_push($error_array, $error_msgs['pwd_match']);
    } else {
        if(preg_match('/[^A-Za-z0-9]/', $pwd)) {
            array_push($error_array, $error_msgs['pwd_char']);
        }
    }

    if (strlen($pwd) > 30 || strlen($pwd) < 5) {
        array_push($error_array, $error_msgs['pwd_char_num']);
    }

    if(empty($error_array)) {
        $pwd = md5($pwd); // Encript password before sending to database
        // Generate username by concatenating first and lastname
        $username = strtolower($fname . "_" . $lname);
        $check_username = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

        $i = 0;
        // add number if username exist
        while(mysqli_num_rows($check_username) != 0) {
            $i++;
            $username = $username . "-" . $i;
            $check_username = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
        }

        // Assign profile picture. Could use more and name them all the same with a number to make diff
        $rand = rand(1, 2); // random num between 1 and 2
        if($rand == 1)
            $profile_pic = "./public/img/profile_pics/defaults/head_belize_hole.png";
        else if ($rand == 2)
            $profile_pic = "./public/img/profile_pics/defaults/head_green_sea.png";

        // make sure field list matches column names in database
        $query = mysqli_query($conn, "INSERT INTO users (id, first_name, last_name, username, email, password, signup_date, profile_pic, num_posts,
        num_likes, user_closed, friend_array) VALUES ( NULL, '$fname', '$lname', '$username', '$email', '$pwd', '$date', '$profile_pic', '0', '0', 
        'no', ',' )");
        //echo "Error:" . mysqli_error($conn);  // prints error
        array_push($error_array, $error_msgs['signup_success']);

        // Clear fields
        //// Why does this not work?
        // foreach($_SESSION as $key => $value) {
        //     $value = '';
        // }
        // unset($value); // without an unset($value), $value is still a reference to the last item: $arr[3]

        $_SESSION['reg_fname'] = $_SESSION['reg_lname'] = $_SESSION['reg_email1'] = $_SESSION['reg_email2'] = "";
    }
}

?>