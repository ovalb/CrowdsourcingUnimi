<?php
    session_start();

    include '../utility/redirect.php';

    if (!(isset($_SESSION['id'])))
        redirect("../index.php");
    
    if (!isset($_POST['add']))
        redirect("../index.php");


    $campaign_id = $_SESSION['campaign'];

    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $options = $_POST['options'];
    $keywordArray = $_POST['keywords'];

    $optionsArray = explode(",", $options);

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
    or redirect("index.php");

    pg_query("BEGIN;");
    $result = pg_query("INSERT INTO task (title, description, campaign) 
                        VALUES ('$title', '$desc', $campaign_id) RETURNING id;");
    
    $task_id = pg_fetch_result($result, 0);

    foreach($optionsArray as $opt) {
        pg_query("INSERT INTO task_option (name, task) VALUES ('$opt', $task_id);");
    }

    foreach($keywordArray as $kw) {
        pg_query("INSERT INTO task_keyword (task, keyword) VALUES ('$task_id', $kw);");
    }

    pg_query("COMMIT;");

    redirect("create-tasks-form.php?result=ok");

?>

