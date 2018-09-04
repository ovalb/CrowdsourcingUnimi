<?php
    session_start();

    include '../utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_SESSION['username'])))
        redirect("requester.php");
    
    if (!isset($_SESSION['campaign']))
        redirect("create-campaign-form.php");
?>

<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tasks Form</title>
</head>
<body>
    <b>Create Tasks</b> <br>

    <form action='validate-task.php' method='POST'>
        <label for='title'> Title: </label>
        <input type="text" name="title" id='title'>
        
        <br>

        <label for='desc'> Description: </label>
        <input type="text" name="desc" id='desc' required>

        <br>

        <label for='options'> Options (separate with comma): </label>
        <input type="text" name="options" id='options' required>

        <label for='keywords'> Keywords: </label>
        <input type="text" name="keywords" id='keywords' required>

        <input type="submit" name="add" value='Add Task'>
    </form>

    <a href="../requester.php"> Finish </a>
</body>