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
    <title>Create Campaign Form</title>
</head>
<body>
    Create campaign
    <form action='validate-campaign-info.php' method='POST'>
        <label for='name'> Task name: </label>
        <input type="text" name="name" id='name' required>
        
        <br>

        <label for='reg_period_date'> Can register until: </label>
        <input type="date" name="reg_period_date" id='reg_period_date' required>

        <input type="time" name="reg_period_time" id='reg_period_time'>

        <br>

        <label for='open_date'> Open Date: </label>
        <input type="date" name="open_date" id='open_date' required>
        <label for='close_date'> Close Date: </label>
        <input type="date" name="close_date" id='close_date' required>

        <br>

        <label for='threshold'> Validity threshold (%): </label>
        <input type="text" name="threshold" id='threshold' required>

        <label for='worker_no'> Number of workers to involve: </label>
        <input type="text" name="worker_no" id='worker_no' required>

        <input type="submit" name="continue" value='Continue'>
    </form>
</body>
</html>