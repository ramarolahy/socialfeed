<?php
require './utils/_config.php';

// Check for current page file name
if(basename($_SERVER['PHP_SELF']) != 'register.php') {
    // If user is logged in, set $_SESSION to username ELSE send to register page.
    if(isset($_SESSION['username'])) {
        $userLoggedIn = $_SESSION['username'];
        $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);
    } else {
        header("Location: register.php");
    }
}
?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SocialFeed</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Coiny|Montserrat:400,600,700|Raleway:400,700,900" rel="stylesheet">
<!-- Boostrap CSS and JS-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<!-- fontawesome -->
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<!-- Custom css -->
<link rel="stylesheet" href="./public/styles/register.css">
<link rel="stylesheet" href="./public/styles/styles.css">
<link rel="stylesheet" href="./public/styles/post.css">
<!-- Custom JS -->


