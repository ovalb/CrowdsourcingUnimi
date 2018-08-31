<?php
    include 'utility.php';

    if (!isset($_POST['login'])) {
        redirect("requester-login.php");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password))
        redirect("requester-login.php?result=empty_field_err");
    
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
        or redirect("requester-login.php?result=connect_err");
    
    $query = "SELECT u.password 
            FROM users u JOIN requester r ON u.id = r.user_id 
            WHERE u.username = '$username';";

    $result = pg_query($db_conn, $query);
    $arr = pg_fetch_row($result);

    if (empty($arr[0]))
        redirect("requester-login.php?result=invalid_login");

    $correct_psw = password_verify($password, $arr[0]);

    if ($correct_psw) {
        session_start();
        $_SESSION['username'] = $username;
        redirect("requester.php");
    } else {
        redirect("requester-login.php?result=invalid_login");
    }
?>