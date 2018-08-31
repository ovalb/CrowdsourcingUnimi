<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requester Login Form</title>
</head>
<body>
    <form action='verify-login.php' method='POST'>
        <label for='user'> Username: </label>
        <input type="text" name="username" id='user'>
        <label for='psw'> Password: </label>
        <input type="password" name="password" id='psw'>
        <input type="submit" name="login" value='Login'>
    </form>
</body>
</html>