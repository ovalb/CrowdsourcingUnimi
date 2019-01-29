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
    
    $user_type = $_POST['usertype']; //either worker or requester

    $query = "SELECT ut.id
            FROM {$user_type}_view ut
            WHERE ut.username = '$username' 
            AND ut.password = crypto.crypt('$password', ut.password)";

    $result = pg_query($db_conn, $query) or redirect("login-form.php?result=db_err");
    $returned_id = pg_fetch_result($result, 0);

    if (pg_num_rows($result) == 1) {
        session_start();
        $_SESSION['id'] = $returned_id;
        $_SESSION['username'] = $username;
        redirect("../{$user_type}.php");
    } else {
        redirect("login-form.php?result=invalid_login");
    }
?>