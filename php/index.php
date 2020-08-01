<?php
/*
 *  THE LOGIN PAGE
 */
    require_once "top.php";
    require_once "db.inc.php";

    // if user already logged will redirect to home.php
    if(isset($_SESSION['email'])){
        header("Location: home.php");
        die;
    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/login.js"  type="text/javascript"></script>
    <link rel="stylesheet" href="../css/check-inputs.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <div>
            <input id="email" type="email" name="text"  placeholder="Email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required>
        </div>
        <div>
            <input id="password" type="password" name="password" placeholder="password" required>
        </div>
        <div>
            <input id="submit" type="submit" name="submit" value="Log in">
        </div>
    </form>

    <div>Not a member yet? <a href="signup.php">Sign up</a></div>
    <p id="ajax-response"></p>
</body>
</html>
