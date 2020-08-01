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
    <link rel="stylesheet" href="../css/check-inputs.css">
    <title>Bookstore</title>
</head>
<body>


<!--
    Registration form
-->

<div id="registration-div" class="invisible">
    <h1>Sign up</h1>
    <form id="registration-form" method="POST">
        <div>
            <input id="name" type="text" name="name" placeholder="Name" required>
            <input id="surname" type="text" name="surname" placeholder="Surname" required>
        </div>
        <div>
            <input id="email" type="text" name="email" placeholder="Email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required >
        </div>
        <div>
            <input id="password" type="password" name="password" placeholder="New password" required>
        </div>
        <div>
            <input id="submit" type="submit" name="submit" value="Sign up">
        </div>
    </form>
    <div>Already member? <a id="login" >Login</a></div>
</div>


<!--
    Login form
-->

<div id="login-div">
    <h1>Login</h1>
    <form id="login-form" method="post">
        <div>
            <input id="email-login" type="email" name="text"  placeholder="Email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required>
        </div>
        <div>
            <input id="password-login" type="password" name="password" placeholder="password" required>
        </div>
        <div>
            <input id="submit-login" type="submit" name="submit" value="Log in">
        </div>
    </form>
    <div>Not a member yet? <a id="signup">Sign up</a></div>
</div>


<!--
       AJAX response
-->

<p id="ajax-response"></p>

</body>
</html>