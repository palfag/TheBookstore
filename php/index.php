<?php
/*
 *   LOGIN PAGE - REGISTRATION PAGE
 */
    require_once "top.php";
    require_once "db.inc.php";

    // if user already logged will redirect to home.php
    if(isset($_SESSION['email'])){
        header("Location: home.php");
        die;
    }
?>

<!--
    Pagina index.html
-->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/loginSignup.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/index.css">
    <title>Bookstore</title>
</head>
<body>

    <div id="container-div">
        <h2><span>The</span> Bookstore</h2>
        <!--
            Registration form
        -->

        <div id="registration-div" class="invisible">
            <form id="registration-form" method="POST">
                <div>
                    <input id="name" type="text" name="name" placeholder="Name" required>
                </div>
                <div>
                    <input id="surname" type="text" name="surname" placeholder="Surname" required>
                </div>
                <div>
                    <input id="email" type="text" name="email" placeholder="Email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required >
                </div>
                <div>
                    <input id="password" type="password" name="password" placeholder="New password" required>
                </div>
                <div>
                    <input class="submit" id="submit" type="submit" name="submit" value="Sign up">
                </div>
            </form>
            <div class="question-content">Already member? <a id="login" >Login</a></div>
        </div>


        <!--
            Login form
        -->

        <div id="login-div">
            <form id="login-form" method="post">
                <div>
                    <input id="email-login" type="email" name="text"  placeholder="Email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required>
                </div>
                <div>
                    <input id="password-login" type="password" name="password" placeholder="password" required>
                </div>
                <div>
                    <input class="submit" id="submit-login" type="submit" name="submit" value="Log in">
                </div>
            </form>
            <div class="question-content">Not a member yet? <a id="signup">Sign up</a></div>
        </div>


        <!--
               AJAX response
        -->

        <p id="ajax-response"></p>

    </div>

</body>
</html>