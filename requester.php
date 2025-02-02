<?php
    session_start();

    include 'utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_SESSION['username'])))
        redirect("index.php");
    
    $req_id = $_SESSION['id'];
    $req_username = $_SESSION['username'];
    unset($_SESSION['campaign']);
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
                or redirect("index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="/Crowdsourcing/" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/campaign-card.css" type="text/css" >
    <link rel="stylesheet" href="css/requester.css" type="text/css" >
    <title>Document</title>
</head>
<body class='text-center'>
    <?php require_once('includes/requester-header.php');?> 
    <div class='container'>
        <div class='row'>
            <div class='col'>
        <?php
            //if this requester doesn't have permission show that he can't do stuff
            $result = pg_query("SELECT has_permission 
                        FROM requester_view
                        WHERE id= $req_id");

            $req_permission = pg_fetch_result($result, 0);

            if ($req_permission == 'f') {
                echo "<p id='no-permission'>You don't have the permission to create any campaign yet.<br>Wait for admin.</p>";
                exit;
            }

            //if it has permission, show campaigns

            echo "<h2> Campaigns </h2>";

            $campaigns = pg_query("SELECT c.id, c.name, reg_period, open_date, close_date 
                                FROM campaign c
                                WHERE requester = $req_id 
                                and close_date >= CURRENT_DATE");

            if (pg_num_rows($campaigns) == 0)
                echo "No open campaign present. Press the button below.";
            else {

                echo "<div class='card-deck'>";

                while ($row = pg_fetch_row($campaigns)) {
                    $res = pg_query($db_conn, "SELECT count(*) FROM task WHERE campaign = $row[0]");
                    $total_task_num = pg_fetch_result($res, 0);
                    $res = pg_query($db_conn, "SELECT count(*) FROM task WHERE campaign = $row[0]
                        AND result IS NOT NULL");
                    $completed_task_num = pg_fetch_result($res, 0);

                    echo "<div class='card bg-secondary text-light'> 
                        <div class='card-body p-4'>
                        <h4 class='card-title'>$row[1]</h4>
                        <table class='card-text'>
                        <tr><th>Tasks done</th><td>$completed_task_num/$total_task_num<td></tr>
                        <tr><th>Join before</th><td>$row[2]</td><tr>
                        <tr><th>Open date</th><td>$row[3]</td><tr>
                        <tr><th>Close date</th><td>$row[4]</td><tr></table><br>
                            <form action='campaign/create-tasks-form.php' method='post'>
                                <button class='btn btn-outline-light btn-block' type='submit' name='campaign' value=$row[0]>Add task</button>
                            </form>
                            <form action='campaign/campaign-report.php' method='post'>
                                <button class='btn btn-outline-light btn-block' type='submit' name='campaign_id' value='$row[0]'>View report</button>
                            </form>
                        </div>
                        </div>";
                }
                echo "</div>";
            }
        ?>
        </div>
        </div>
        <div class='row'>
        <div class='col'>
        <?php

            echo "<h2>Finished</h2>";
            $result = pg_query("SELECT id, c.name, reg_period, open_date, close_date
                            FROM campaign c
                            WHERE requester = $req_id 
                            and close_date < CURRENT_DATE");

            if (pg_num_rows($result) == 0)
            echo "No closed campaign present.";
            else {
                $i = 0;
                echo "<div class='card-deck'>";
                while ($row = pg_fetch_row($result)) {
                    $res = pg_query($db_conn, "SELECT count(*) FROM task WHERE campaign = $row[0]");
                    $total_task_num = pg_fetch_result($res, 0);
                    $res = pg_query($db_conn, "SELECT count(*) FROM task WHERE campaign = $row[0]
                        AND result IS NOT NULL");
                    $completed_task_num = pg_fetch_result($res, 0);

                    echo "<form method='post' action='campaign/campaign-report.php'>" .
                        "<div class='card bg-secondary text-light'>" . 
                        "<div class='card-body p-4'>" .
                        "<h4 class='card-title'>" . $row[1] . "</h4>" .
                        "<table class='card-text'>" . 
                        "<tr><th>Tasks done</th><td>$completed_task_num/$total_task_num<td></tr>" .
                        "<tr><th><b>Join before</b></th><td>"  . $row[2] . "</td><tr>" .
                        "<tr><th><b>Open date</b></th><td>" . $row[3] . "</td><tr>" .
                        "<tr><th><b>Close date</b></th><td>" . $row[4] . "</td><tr></table><br>" .
                        "<button class='btn btn-md btn-outline-light btn-block' type='submit' name='campaign_id' value=$row[0]>View results</button>" .
                        "</div></div></form>";
                }
                echo "</div>";
            }
        ?>
        <br> <br>
        <a class='btn btn-lg btn-primary' href="campaign/create-campaign-form.php">New campaign </a>
        <br><br><br><br>
        </div>    
    </div>    
    </div>
</body>
</html>