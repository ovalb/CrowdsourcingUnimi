<?php
    session_start();

    require 'utility/redirect.php';

    if (!isset($_SESSION['username']))
        redirect("index.php");

    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Worker Profile</title>
</head>
<body>
    <span>
        <?php 
        echo ("WORKER: You are logged in as " . $username);
        ?>    
    </span>

    <div class='container'>
    <div class='row'>
    <div class="col-md-8 offset-md-2 text-center">

    <?php
        $query = "SELECT name, level 
                FROM worker_keyword wk JOIN keyword k on wk.keyword = k.id
                WHERE worker = $id";

        $query_result = pg_query($db_conn, $query);

        echo "<b> Your keywords </b><br><br>";
        while ($arr = pg_fetch_array($query_result)) {
            $k_name = $arr[0];
            $k_level = $arr[1];
            echo $k_name . " ----> " . $k_level . "<br>";
        }
    ?>
    </div>
    </div>
    </div>
</body>
</html>