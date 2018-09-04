<?php
    include '../utility/redirect.php';
    
    if (!isset($_POST['register']))
        redirect("registration-form.php");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeated_psw = $_POST['repeated-psw'];

    if (empty($username) || empty($email) || 
        empty($password) || empty($repeated_psw)) {
            redirect("registration-form.php?result=empty_field_err");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect("registration-form.php?result=invalid_email_err");
    }

    if ($password !== $repeated_psw) {
        redirect("registration-form.php?result=mismatch_psw_err");
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
                    or redirect("registration-form.php?result=connect_err");

    $table = $_POST['kind']; //either worker or requester
    $query = "INSERT INTO $table (username, email, password) VALUES ('$username', '$email', '$password');";
    $query_result = pg_query($db_conn, $query) or redirect("registration-form.php?result=insert_err");

    redirect("registration-success.php");
?>