<?php
    include 'utility.php';
    
    if (!isset($_POST['register']))
        redirect("requester-form.php");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeated_psw = $_POST['repeated-psw'];

    if (empty($username) || empty($email) || 
        empty($password) || empty($repeated_psw)) {
            redirect("requester-form.php?result=empty_field_err");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect("requester-form.php?result=invalid_email_err");
    }

    if ($password !== $repeated_psw) {
        redirect("requester-form.php?result=mismatch_psw_err");
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
                    or redirect("requester-form.php?result=connect_err");

    //Use a transaction to insert requester in db
    pg_query($db_conn, "BEGIN;") or redirect("requester-form.php?result=transaction_err");

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password') RETURNING (id);";
    $query_result = pg_query($db_conn, $query) or redirect("requester-form.php?result=insert_err");
    $arr = pg_fetch_array($query_result);

    if ($query_result && $arr) {
        pg_query($db_conn, "INSERT INTO requester (user_id) VALUES ($arr[0]);");
        pg_query($db_conn, "COMMIT;");
        redirect("registration-success.php");
    } else {
        pg_query($db_conn, "ROLLBACK;");
        redirect("requester-form.php?result=transaction_err");
    }
?>