<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requester Login Form</title>
</head>
<body>
    <form action='login-process.php' method='POST'>
        <label for='user'> Username: </label>
        <input type="text" name="username" id='user'>
        <label for='psw'> Password: </label>
        <input type="password" name="password" id='psw'>

        <input type='radio' name='kind' id='worker' value='worker' checked>
        <label for='worker'> Worker </label>
        <input type='radio' name='kind' id='requester' value='requester'>
        <label for='requester'> Requester </label>

        <input type="submit" name="login" value='Login'>
    </form>
</body>
</html>