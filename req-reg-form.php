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
            <p class=bold>Important</p><br>
            <p> You won't be able to create new campaigns until a website admin<br>grants you the required permissions to do so.</p><br>
        </div>
        <div class="form_container">

            <p> 
                <?php
                    if(isset($_GET['empty_field']))
                        echo "FIELDS ARE EMPTTYYYYY";
                ?>
            </p>
            <form name='reg_form' class="form" method="post" action="req-register.php" onsubmit="return validateForm()">
                <label for='user-field'>Username</label>
                <input id='user-field' class='textfield' type="text" name="username">

                <label for='email-field'>Email</label>
                <input id='email-field' class='textfield' type='text' name='email'>
                
                <label for='psw-field'>Password</label>
                <input id='psw-field' class='textfield' type="password" name='password' >
                
                <label for='repeat-psw-field'>Repeat Password</label>
                <input id='repeat-psw-field' class='textfield' type="password" name='repeated-psw' >
                
                
                <input class='reg_button' type="submit" name='register' value='Register'>
            </form>
        </div>
    </div>

    <footer> Made by Giorgio Valbonesi </footer>
</body>
</html>