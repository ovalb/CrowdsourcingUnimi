<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Crowdsourcing</title>
    <base href="/Crowdsourcing/" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/registration-form.css" >
    <link rel="stylesheet" href="sticky-footer.css" >
</head>

<body>
    <header class="page-header text-center mb-4">
        <h1>REGISTER</h1>
    </header>
        <div class='container'>
        <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
        <form id='registration' action="registration/registration-process.php" name='reg_form' method="post">
            <?php require_once('../includes/work-req-radio.php'); ?>
            <p></p>

            <fieldset class="form-group input-form">
                <input class='form-control' type="text" name="username" placeholder="Username" autocomplete required> 
                <input class='form-control' type="password" name='password' placeholder="Password" autocomplete required>
                <input class='form-control' type="password" name='repeated-psw' placeholder="Repeat Password" autocomplete required>
            </fieldset>

            <input class='btn btn-primary btn-lg register-btn' type="submit" name='register' value='Register'> <br><br><br>
        </form>
        </div>
    </div>
    </div>

    <footer class="footer text-right pr-4">
        <span class="text-muted">Made by Giorgio Valbonesi</span>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>