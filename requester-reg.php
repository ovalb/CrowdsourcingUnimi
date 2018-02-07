<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="reg_style.css" type="text/css">
    <title>Requester Registration</title>
</head>
<body>
    <header> 
        Requester registration
    </header>
    <div class="container">

        <div class="request">
        <img class="invert" src="img/request-512.png">
            <span>Request admin permission</span>
            <span> Explanation blabla...</span>
        </div>
        <div class="form_container">
            <form class="form" action="/actionpage.php">
                <span>Username</span><br>
                <input type="text" name="username">
                <br>
                <span>Password</span><br>
                <input type="password" name='password'>
                <br>
                <span>Permission code</span><br>
                <input type="password" name='pin'>
                <br><br>
                <input class='reg_button' type="submit" name='register'>
            </form>
        </div>
    </div>
</body>
</html>