<?php
    session_start();

    include '../utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_SESSION['username'])))
        redirect("index.php");
    
    $req_id = $_SESSION['id'];
    $req_username = $_SESSION['username'];
    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval");

    
    // generates campaign result
    $c_id = $_POST['campaign_id'];
    $result = pg_query($db_conn, "SELECT close_campaign($c_id)");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="/Crowdsourcing/" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/campaign-report.css">
    
    <title>Campaign report</title>
</head>
<body>
    <?php require_once('../includes/requester-header.php');?> 


    <div class='container'>
    <div class='row'>
    <div class="col-md-8 offset-md-2 text-center">

    <?php
        $query_result =  pg_query($db_conn, "SELECT c.name, c.open_date, c.close_date, c.task_threshold, c.min_worker_num
                                FROM campaign c WHERE c.id = $c_id");

        $campaign_row = pg_fetch_row($query_result);
        echo "<h2>Campaign Report</h2>" .
            "<table class='table text-left'><tr><td><h4>" . $campaign_row[0] . "</h4></td></tr>" .
             "<tr><th>Open date</th><td>" . $campaign_row[1] . "</td>" .
             "<th>Close date</th><td>" . $campaign_row[2] . "</td></tr>" .
             "<tr><th>Threshold</th><td>" . $campaign_row[3] . "%</td>" .
             "<th>Min. worker number</th><td> " . $campaign_row[4] . "</td></tr></table>"; 

        $query = "SELECT title, description, o.name AS res
            FROM task t LEFT JOIN task_option o ON t.result = o.id
            WHERE campaign = $c_id;";

        $query_result = pg_query($db_conn, $query);

        echo "<h2> Tasks Results</h2>";
        echo "<table class='table table-bordered'>" .
            "<thead><tr>
            <th scope='col'>Title</th>
            <th scope='col'>Description</th>
            <th scope='col'>Result</th>
            </tr></thead>";
        echo "<tbody>";

        while ($arr = pg_fetch_array($query_result)) {
            $t_title = $arr[0];
            $t_description = $arr[1];
            $t_result = $arr[2];
 
            if (empty($t_result)) $t_result = "---";
            echo "<tr scope='row'><td>$t_title</td><td>$t_description</td><td>$t_result</td></tr>";
        }

        echo "</tbody></table>";

        echo "<h2> Top 10 workers </h2>";
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
                "SELECT username, score
                FROM worker_campaign wc JOIN worker_view v ON wc.worker = v.id 
                WHERE wc.campaign = $c_id 
                ORDER BY score DESC LIMIT 10");
        
        
        $rows_num = pg_num_rows($query_result);
        
        for ($i=1; $i <= $rows_num; $i++)  {
            $row = pg_fetch_row($query_result);
            echo "<tr><td>$i</td><td>$row[0]</td><td>$row[1]</td></tr>";
        }

        echo "</tbody></table>";
    ?>
    </div>
    </div>
    </div>
</body>
</html>