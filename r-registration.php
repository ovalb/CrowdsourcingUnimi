<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css" type="text/css" >
    <link rel="stylesheet" href="css/r-registration.css" type="text/css">
    <title>Crowdsourcing</title>
</head>

<body>
    <header>
    <p class='subtitle'>Welcome to the crowdsourcing university project for the 2018 Database Course</p>
        <h1><a href="index.php"> <span id='crowd_title'>CROWD</span><span id='sourcing_title'>SOURCING</span> </a></h1>
    </header>
    <div class="container">
        <div class="permission-section">
            <p class=bold>Request admin permission</p><br>
            <p> Requesters need a website admin's permission to be able to register.</p><br>
            <p> For the sake of this project, click the button below and the 'admin' will 
                grant you the permission to register by providing a 4 digit pin number.<p><br>
            <button id='permbtn' name='get-perm-code' type='button'>Get permission</button>
        </div>
        <div class="form_container">
            <form name='reg_form' class="form" method="post" action="/actionpage.php" onsubmit="return validateForm()">
                <span>Username</span><br>
                <div id='empty-usr' class='input-error'>Username can't be empty</div>
                <div id='bad-usr' class='input-error'>Username needs to be between 4 and 25 
                    alphanumerical characters. No special symbol other than _ (underscore) are allowed.
                </div>
                <input class='textfield' type="text" name="username">
                <br>
                <span>Password</span><br>
                <div id='empty-psw' class='input-error'>Password can't be empty</div>
                <div id='bad-psw' class='input-error'>Password needs to be between 4 and 25 
                    alphanumerical characters. No special symbol other than _ (underscore) are allowed.</div>
                <input class='textfield' type="password" name='password'>
                <br>
                <span>Permission code</span><br>
                <div id='empty-code' class='input-error'>Code can't be empty. <br>
                    You need admin permission to register as a requester</div>
                <div id='bad-code' class='input-error'>Incorrect code. <br>You've inserted an invalid code.</div>
                <input class='textfield' type="password" name='pin'>
                <br><br>
                <input class='reg_button' type="submit" name='register' value='Register'>
            </form>
        </div>
    </div>
    

    <footer> Made by Giorgio Valbonesi </footer>
    <script src="js/requester_permission.js"></script>
    <script src="js/validate-requester-registration.js"></script>

</body>
</html>