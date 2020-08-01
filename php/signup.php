<!--
    Pagina html di registrazione
-->


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/signup.js"  type="text/javascript"></script>
    <link rel="stylesheet" href="../css/check-inputs.css">
    <title>Signup</title>
</head>
<body>
<h1>Sign up</h1>

<form method="POST">
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

<div>Already have an account? <a href="index.php">Login</a></div>
<p id="ajax-response"></p>

</body>
</html>
