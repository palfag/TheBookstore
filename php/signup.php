<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../javascript/signup.js"  type="text/javascript"></script>
    <title>Signup</title>
</head>
<body>
    <h1>Sign up</h1>
    <form method="post">
        <div>
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="surname" placeholder="Surname">
        </div>
        <div>
            <input type="email" name="email" placeholder="Email address">
        </div>
        <div>
            <input type="password" name="password" placeholder="New password">
        </div>
        <div>
            <input type="submit" value="Sign up">
        </div>
    </form>

    <div>Already have an account? <a href="login.php">Login</a></div>

</body>
</html>
