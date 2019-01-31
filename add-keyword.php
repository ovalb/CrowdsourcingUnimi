<?php
        session_start();

        require 'utility/redirect.php';
    
        if (!isset($_SESSION['id']) || !isset($_POST['add-btn']))
            redirect("index.php");

        $id = $_SESSION['id'];
        $keyword = $_POST['selected_keyword'];
        $level = $_POST['level'];

        $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval");

        $query = "INSERT INTO worker_keyword (worker, keyword, level)
                    VALUES ($id, $keyword, $level)";

        $result = pg_query($db_conn, $query) or redirect("worker/worker-details.php?result=failed");
        redirect('worker/worker-details.php');
?>