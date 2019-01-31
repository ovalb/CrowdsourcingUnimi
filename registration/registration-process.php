<?php
    require '../utility/redirect.php';
    
    if (!isset($_POST['register']))
        redirect("registration-form.php");

    $user_type = $_POST['usertype']; //either worker or requester

    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeated_psw = $_POST['repeated-psw'];

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
    $query_result = pg_query($db_conn, $query);
    //  or redirect("registration-form.php?result=insert_err");
    redirect("registration-success.php");
?>