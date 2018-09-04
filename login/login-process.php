<?php
    include '../utility/redirect.php';

    if (!isset($_POST['login'])) {
        redirect("login-form.php");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password))
        redirect("login-form.php?result=empty_field_err");
    
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
        or redirect("login-form.php?result=connect_err");
    
    $table = $_POST['kind']; //either worker or requester

    $result = pg_query($db_conn, "SELECT id, password FROM $table WHERE username = '$username';") 
        or redirect("login-form.php?result=db_err");
    
        $returned_id = pg_fetch_result($result, 0);
        $returned_psw = pg_fetch_result($result, 1);

    if (empty($returned_psw))
        redirect("login-form.php?result=invalid_login");

    if (password_verify($password, $returned_psw)) {
        session_start();
        $_SESSION['id'] = $returned_id;
        $_SESSION['username'] = $username;
        redirect("../{$table}.php");
    } else {
        redirect("login-form.php?result=invalid_login");
    }
?>