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
    

    $query = "SELECT password FROM admin WHERE username = '$username';";

    $result = pg_query($db_conn, $query) or redirect("login-form.php?result=db_err");
    $arr = pg_fetch_row($result);

    if (empty($arr[0]))
        redirect("login-form.php?result=invalid_login");

    $correct_psw = password_verify($password, $arr[0]);

    if ($correct_psw) {
        session_start();
        $_SESSION['username'] = $username;
        redirect("home.php");
    } else {
        redirect("login-form.php?result=invalid_login");
    }
?>