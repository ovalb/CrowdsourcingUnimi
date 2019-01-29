<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login-form.css">
    <title>Login Form</title>
</head>
<body class="text-center">
    <form class='form-signin' action='login-process.php' method='POST'>
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <?php require_once('../includes/work-req-radio.php'); ?>
        <br><br>

        <label for='user' class='sr-only'> Username: </label>
        <input type="text" name="username" id='user' class='form-control' placeholder="Username" required>
        <label for='psw' class='sr-only'> Password: </label>
        <input type="password" name="password" id='psw' class='form-control' placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value='Login'>Sign in </button>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>