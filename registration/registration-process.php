<?php
    require '../utility/redirect.php';
    
    if (!isset($_POST['register']))
        redirect("registration-form.php");

    $user_type = $_POST['usertype']; //either worker or requester
    if ($user_type == 'worker' && $_POST['traits'] == NULL)
        redirect("registration-form.php?result=insert_err");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeated_psw = $_POST['repeated-psw'];

    $traits = $_POST['traits'];
    $levels = $_POST['levels'];

    if (empty($username) || 
        empty($password) || empty($repeated_psw)) {
            redirect("registration-form.php?result=empty_field_err");
    }

    if ($password !== $repeated_psw) {
        redirect("registration-form.php?result=mismatch_psw_err");
    }
    
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
                    or redirect("registration-form.php?result=connect_err");

    $query = "SELECT insert_user('$username', '$password', '$user_type')";
    $query_result = pg_query($db_conn, $query) or redirect("registration-form.php?result=insert_err");

    if ($user_type == "worker") {
        $query = "SELECT id FROM worker_view WHERE username = '{$username}'";
        $query_result = pg_query($db_conn, $query);
        
        $inserted_worker_id = pg_fetch_result($query_result, 0);

        for ($i=0; $i < count($traits); $i++) {
            $query = "INSERT INTO worker_keyword VALUES (${inserted_worker_id}, $traits[$i], $levels[$i]);";
            pg_query($db_conn, $query) or redirect("registration-form.php?result=insert_err");
        }
    }
    redirect("registration-success.php");
?>