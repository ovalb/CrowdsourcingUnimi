<?php
    session_start();
    require '../utility/redirect.php';

    if (!isset($_SESSION['id']))
        redirect('../index.php');

    $worker_id = $_SESSION['id'];
    $option_selected = $_POST['sel_option'];

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval")
        or redirect("home.php?result=conn_err");

    $query = "UPDATE worker_task 
            SET chosen_option = $option_selected 
            WHERE worker = $worker_id AND 
                task = 
                (SELECT task FROM task_option where id = $option_selected)";

    $result = pg_query($db_conn, $query);
    redirect('do-campaign-tasks.php');
?>