<?php
    session_start();

    require 'utility/redirect.php';
    
    if (!isset($_SESSION['id']))
        redirect("index.php");

    $worker_id = $_SESSION['id'];
    $campaign_id = $_POST['enroll'];

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval");

    $res = pg_query("INSERT INTO worker_campaign (worker, campaign, score) VALUES ($worker_id, $campaign_id, 0)");
    redirect("worker.php");
?>