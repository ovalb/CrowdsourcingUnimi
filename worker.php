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
    <base href="/Crowdsourcing/" >
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
    integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <link rel="stylesheet" href="css/worker.css" type="text/css" >
    <link rel="stylesheet" href="css/campaign-card.css" type="text/css" >
    <title>Worker</title>
</head>
<body>
    <header> 
        <?php require_once("includes/worker-header.php");?>    
    </header>
    <div class="container text-center">
        
        <?php
            echo "<div class='row'>
                  <div class='col'>
                  <h2>Campaigns to join</h2>";
            $res = pg_query("SELECT id, name, reg_period, open_date, close_date 
                            FROM campaign 
                            WHERE reg_period >= CURRENT_DATE
                        EXCEPT
                            SELECT id, name, reg_period, open_date, close_date 
                            FROM campaign c JOIN worker_campaign wc 
                            ON wc.worker = '$id' and wc.campaign = c.id");

            echo "<form action='enroll-process.php' method='POST'>
                <div class='card-deck'>";
            
                while ($arr = pg_fetch_array($res)) {
                    echo "<div class='card bg-secondary text-light'> 
                        <div class='card-body p-4'>
                        <h4 class='card-title'>$arr[1]</h4>
                        <table class='card-text'>
                        <tr><th>Join before</th><td>$arr[2]</td><tr>
                        <tr><th>Open date</th><td>$arr[3]</td><tr>
                        <tr><th>Close date</th><td>$arr[4]</td><tr>
                        </table> <br>
                        <button class='btn btn-md btn-outline-light btn-block' type='submit' name='enroll' value='$arr[0]'>Enroll</button> </a><br>
                        </div></div>";   
                                         
                    $index++;
                }
            echo "</form></div></div></div>
                <div class='row'>
                <div class='col'>
                <h2> Open Campaigns</h2>";

            $res = pg_query("SELECT c.id, c.name, reg_period, c.open_date, c.close_date 
                        FROM campaign c JOIN worker_campaign wc 
                        ON wc.worker = '$id' and wc.campaign = c.id
                        WHERE c.open_date <= CURRENT_DATE and
                            c.close_date >= CURRENT_DATE");

            echo "<div class='card-deck'>";

            while ($arr = pg_fetch_array($res)) {
                echo "<div class='card bg-secondary text-light'> 
                        <div class='card-body p-4'>
                        <h4 class='card-title'>$arr[1]</h4>
                        <table class='card-text'>
                        <tr><th>Join before</th><td>$arr[2]</td><tr>
                        <tr><th>Open date</th><td>$arr[3]</td><tr>
                        <tr><th>Close date</th><td>$arr[4]</td><tr>
                        </table> <br>
                        <form method='post' action='/Crowdsourcing/campaign/do-campaign-tasks.php'>
                        <button class='btn btn-md btn-outline-light btn-block' type='submit' name='campaign' value='$arr[0]'>Play!</button>
                        </form>
                        <form method='post' action='/Crowdsourcing/worker/worker-statistics.php'>
                        <button class='btn btn-md btn-outline-light btn-block' type='submit' name='campaign' value='$arr[0]'>Show report</button>
                        </form>
                        </div></div>"; 
            }

            echo "</table>";
            echo "</form></div></div></div>";

            echo "<h2> Finished Campaigns </h2>";
            $res = pg_query($db_conn, "SELECT id, name, close_date
                            FROM campaign c JOIN worker_campaign wc
                            ON wc.worker = $id AND wc.campaign = c.id
                            WHERE c.close_date < CURRENT_DATE");

            echo "<div class='row'>
                    <div class='col'>
                        <form action='/Crowdsourcing/worker/worker-statistics.php' method='post'>
                        <div class='card-deck'>";
            while ($arr = pg_fetch_array($res)) {
                echo "<div class='card bg-secondary text-light'> 
                        <div class='card-body p-4'>
                        <h4 class='card-title'>$arr[1]</h4>
                        <table class='card-text'>
                        <tr><th>Closed on</th><td>$arr[2]</td><tr>
                        </table> <br>
                        <button class='btn btn-md btn-outline-light btn-block' type='submit' name='campaign' value='$arr[0]'>Show report</button>
                        </div></div>"; 
            }
            echo "</div></div></div>";
        ?>
    </div>
    </form>
</body>
</html>