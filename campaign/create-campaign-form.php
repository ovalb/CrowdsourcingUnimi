<?php
    session_start();

    include '../utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_SESSION['username'])))
        redirect("requester.php");
?>

<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
        integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <title>Create Campaign</title>
    
</head>
<body class='text-center' style='background-color:#efefef;'>
    <main class='container' style='margin-top:40px;width:40%'>
        <h2>Create campaign</h2>
        <form action='validate-campaign-info.php' method='POST'>
        <div class='row'>
        <div class='form-group col'>
            <label for='name' class='sr-only'> Campaign name: </label>
            <input class="form-control" type="text" name="name" id='name' placeholder='Campaign name' required>
            <br>

            <label for='reg_period_date'> Can register until: </label>
            <input type="date" class="form-control" name="reg_period_date" placeholder='Registration period' id='reg_period_date' required>
        </div>
        </div>

        <div class='row'> 
            <div class='form-group col-md-6'>
                <label for='open_date'> Open date </label>
                <input type="date" class="form-control" name="open_date" id='open_date' required>
            </div>
            <div class='form-group col-md-6'>
                <label for='close_date'> Close Date: </label>
                <input type="date" class="form-control" name="close_date" id='close_date' required>
            </div>
        </div>
        <div class='row'>
        <div class='form-group col'>

        <label for='threshold' class='sr-only'> Validity threshold (%): </label>
        <input type="text" class="form-control" name="threshold" placeholder='Validity threshold (%)' id='threshold' required>
        <br>
        <label for='worker_no' class='sr-only'> Number of workers to involve: </label>
        <input type="text" class="form-control" name="worker_no" placeholder='Minimum n. of workers to participate' id='worker_no' required>
        <br>
        <button class='btn btn-lg btn-primary' type="submit" name="continue">Continue</button>
        </div>    
        </div>
        </form>
    </main>
</body>
</html>