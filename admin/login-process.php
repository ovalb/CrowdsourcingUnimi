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
    
    $query = "SELECT a.id FROM admin_view a
            WHERE a.username = '$username' 
            AND a.password = crypto.crypt('$password', a.password)";

    $result = pg_query($db_conn, $query) or redirect("login-form.php?result=db_err");
    $arr = pg_fetch_row($result);

    if (empty($arr[0]))
        redirect("login-form.php?result=invalid_login");
    else {
        session_start();
        $_SESSION['admin_id'] = $arr[0];
        $_SESSION['username'] = $username;
        redirect("home.php");
    }
?>