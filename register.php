<!DOCTYPE html>
<html>
<head>
    <?php 
    // INSERT HEAD HERE
    include "./partials/head.php";
    ?>
    <!-- REGISTER STYLE AND JS -->
    <link rel="stylesheet" href="./public/styles/register.css">
    <script src="./utils/js/register.js"></script>
    <?php
    // Remember that order matters depending on what is needed first
    require './utils/_config.php';
    require './utils/form_handlers/_register.php';
    require './utils/form_handlers/_login.php';
    // prevent submit button from showing login form if there are errors
    // Maybe look into stopPropagation()?
    if(isset($_POST['reg_submit_btn'])) {
        echo '
        <script>
            $(document).ready(function(){
                $("#login__section").hide();
                $("#signup__section").show();
            });
        </script>
        ';
    }
    ?>


<head>
<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login_header">
                <h2>SocialFeed</h2>
                <span>Login or Signup below.</span>
            </div>

            <div id="login__section">
                <form action="register.php" method="POST">
                    <div>
                        <input class="input" type="email" name="log_email" value="<?php
                                if(isset($_SESSION['log_email'])) { // Keep email on form
                                    echo $_SESSION['log_email'];
                                }   
                                    ?>"
                            placeholder="Email Address" required>
                    </div>
    
                    <div>
                        <input class="input" type="password" name="log_password" placeholder="Password" required>
                    </div>
                    <!-- Display error message -->
                    <?php if(in_array($error_msgs['login_fail'], $error_array)) echo $error_msgs['login_fail'] ?>

                    <div class="control">
                        <button type="submit" name="login_btn">login</button>
                        <button  type="button" id="signup" name="login_btn">Signup</button>
                    </div>
                </form>
            </div>
            
            <div id="signup__section">
                <form action="register.php" method="POST">
                    <div class="control">
                        <input class="input" type="text" name="reg_fname" value="<?php
                                if(isset($_SESSION['reg_fname'])) {
                                    echo $_SESSION['reg_fname'];
                                }   
                                    ?>"
                            placeholder="First Name">
                    </div>
                    <!-- Display error msg if test fail -->
                    <?php if(in_array($error_msgs['fname'], $error_array)) echo $error_msgs['fname'] ?>
                    <div>
                        <input class="input" type="text" name="reg_lname" value="<?php
                                if(isset($_SESSION['reg_lname'])) {
                                    echo $_SESSION['reg_lname'];
                                }   
                                    ?>"
                            placeholder="Last Name">
                    </div>
                    <!-- Display error msg if test fail -->
                    <?php if(in_array($error_msgs['lname'], $error_array)) echo $error_msgs['lname'] ?>
    
                    <div>
                        <input class="input is-danger" type="email" name="reg_email1" value="<?php
                                if(isset($_SESSION['reg_email1'])) {
                                    echo $_SESSION['reg_email1'];
                                }   
                                    ?>"
                            placeholder="Email input">
                    </div>
                    <!-- Display error msg if test fail -->
                    <?php if(in_array($error_msgs['email_inuse'], $error_array)) echo $error_msgs['email_inuse'] ?>
                    <?php if(in_array($error_msgs['email_format'], $error_array)) echo $error_msgs['email_format'] ?>
                    
                    <div>
                        <input class="input is-danger" type="email" name="reg_email2" value="<?php
                                if(isset($_SESSION['reg_email2'])) {
                                    echo $_SESSION['reg_email2'];
                                }   
                                    ?>"
                            placeholder="Email input">
                    </div>
                    <!-- Display error message -->
                    <?php if(in_array($error_msgs['email_match'], $error_array)) echo $error_msgs['email_match'] ?>
    
                    <p>
                        <input class="input" type="password" name="reg_pwd1" placeholder="Password">
                    </p>
                    <!-- Display error message -->
                    <?php if(in_array($error_msgs['pwd_char'], $error_array)) echo $error_msgs['pwd_char'] ?>
                    <?php if(in_array($error_msgs['pwd_char_num'], $error_array)) echo $error_msgs['pwd_char_num'] ?>

                    <p>
                        <input class="input" type="password" name="reg_pwd2" placeholder="Password">
                        <!-- Display error message -->
                        <?php if(in_array($error_msgs['pwd_match'], $error_array)) echo $error_msgs['pwd_match'] ?>
                    </p>
    
    
                    <div>
                        <label class="checkbox">
                            <input type="checkbox">
                            I agree to the <a href="#">terms and conditions</a>
                        </label>
                    </div>
    
                    <div>
                        <button type="submit" name="reg_submit_btn">Submit</button>
                        <button  type="button" id="login" name="reg_cancel_btn">login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>