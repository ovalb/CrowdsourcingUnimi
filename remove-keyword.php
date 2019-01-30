<?php
        session_start();

        require 'utility/redirect.php';
    
        if (!isset($_SESSION['id']))
            redirect("index.php");

        $id = $_SESSION['id'];
        $keyword = $_POST['rmv_keyword'];

        $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval");
        $result = pg_query($db_conn, "DELETE FROM worker_keyword WHERE worker=$id AND keyword=$keyword") or
            redirect("worker-details.php?result=failed");

        redirect('worker-details.php');
?>