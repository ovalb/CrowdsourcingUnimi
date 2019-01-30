<?php
    session_start();
    require '../utility/redirect.php';

    if (!isset($_SESSION['id']))
        redirect('../worker.php');

    $wid = $_SESSION['id'];
    $username = $_SESSION['username'];
    $campaign = $_POST['campaign'];

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval")
            or redirect("home.php?result=conn_err");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Worker Statistics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
        integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
</head>
<body>

    <header>
         <?php require_once('../includes/worker-header.php');?>
    </header>

    <main class='container text-center'>
    <div class='row'>
    <div class='col'>
        <?php
            $res = pg_query($db_conn, "SELECT c.name FROM campaign c WHERE id = $campaign");
            $campaign_name = pg_fetch_result($res, 0);
            echo "<h2>Worker Statistics<h2>";
            echo "<h3>[ Campaign: $campaign_name ]</h2><br>";

            $query = "SELECT t.id, t.title, t.description, o.name, wt.chosen_option, t.result
                    FROM worker_task wt JOIN task t ON wt.task = t.id
                    JOIN task_option o ON o.id = wt.chosen_option
                    WHERE wt.worker = $wid AND t.campaign = $campaign 
                    AND o.task = t.id";
            $res = pg_query($db_conn, $query);

            if (pg_num_rows($res) != 0) {
                echo "<h2>Task eseguiti</h2>
                <p style='color:00cc7a'>(I task evidenziati in verde, sono validi)</p>";

                echo "<table class='table table-bordered'>
                <thead><tr>
                <th scope='col'>Title</th>
                <th scope='col'>Description</th>
                <th scope='col'>Chosen Option</th>
                </tr></thead><tbody>";
                
                while ($arr = pg_fetch_row($res)) {
                    $given_answer = $arr[4];
                    $task_result = $arr[5];
                    if ($given_answer == $task_result)
                        echo "<tr style='background-color:#00cc7a;'><td>$arr[1]</td><td>$arr[2]</td><td>$arr[3]</td></tr>";
                    else 
                        echo "<tr><td>$arr[1]</td><td>$arr[2]</td><td>$arr[3]</td></tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p> You need to participate in order to see any statistics</p>";
            }

            echo "<br><br><h2> Posizione in classifica </h2>";
        echo "<table class='table'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Worker</th>
                    <th>Score</th>
                </tr>
            </thread>
            <tbody>";

        $query_result = pg_query($db_conn, 
                "SELECT id, username, score
                FROM worker_campaign wc JOIN worker_view v ON wc.worker = v.id 
                WHERE wc.campaign = $campaign 
                ORDER BY score DESC LIMIT 10");
        
        
        $rows_num = pg_num_rows($query_result);
        
        for ($i=1; $i <= $rows_num; $i++)  {
            $row = pg_fetch_row($query_result);
            if ($row[0] == $wid)
                echo "<tr style='background-color:#00cc7a;'><td>$i</td><td>$row[1]</td><td>$row[2]</td></tr>";
            else
                echo "<tr><td>$i</td><td>$row[1]</td><td>$row[2]</td></tr>";
        }

        echo "</tbody></table>";

        ?>
    </div>
    </div>

    </main>
</body>
</html>