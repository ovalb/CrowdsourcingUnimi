<?php
    include '../utility/redirect.php';
    
    if (!isset($_POST['grant'])) {
        redirect("home.php");
    }

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
                or redirect("home.php?result=conn_err");

    $id = $_POST['grant'];

    pg_query($db_conn, "UPDATE requester SET has_permission = 't' WHERE id = $id") 
        or redirect("home.php?result=fail");

    redirect("home.php?result=success");
?>