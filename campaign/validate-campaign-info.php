<?php
    session_start();

    include '../utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_POST['continue'])))
        redirect("create-campaign-form.php");

    $name = $_POST['name'];
    $r_id = $_SESSION['id'];
    $reg_period = $_POST['reg_period_date'] . " " . $_POST['reg_period_time'];
    $open_date = $_POST['open_date'];
    $close_date = $_POST['close_date'];
    $threshold = $_POST['threshold'];
    $worker_no = $_POST['worker_no'];

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
        or redirect("index.php");

    $result = pg_query($db_conn, "INSERT INTO campaign (name, requester, reg_period, open_date, close_date, task_threshold, min_worker_num)" . 
    "VALUES ('$name', $r_id, '$reg_period', '$open_date', '$close_date', $threshold, $worker_no) RETURNING id");

    if (!$result) {
        redirect("create-campaign-form.php?msg=err"); //error msg?
    }
    
    $_SESSION['campaign'] = pg_fetch_result($result, 0);
    redirect("create-tasks-form.php");
    

?>