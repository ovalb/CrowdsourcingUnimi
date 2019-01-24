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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Campaign report</title>
</head>
<body>
    <span>
        <?php 
        echo ("REQUESTER: You are logged in as " . $req_username);
        ?>    
    </span>

    <div class='container'>
    <div class='row'>
    <div class="col-md-8 offset-md-2 text-center">

    <?php
        $query_result =  pg_query($db_conn, "SELECT c.name, c.open_date, c.close_date, c.task_threshold 
                                FROM campaign c WHERE c.id = $c_id");
        echo "<h2> Campaign Report</h2>" .
            "<p> name: " . pg_fetch_result($query_result, 0) . "<br>" .
             "opened on: " . pg_fetch_result($query_result, 1) . "<br>" .
             "closed on: " . pg_fetch_result($query_result, 2) . "<br>" .
             "threshold: " . pg_fetch_result($query_result, 3) . "%</p>";

        $query = "SELECT title, description, o.name AS res
            FROM task t LEFT JOIN task_option o ON t.result = o.id
            WHERE campaign = $c_id;";

        $query_result = pg_query($db_conn, $query);


        echo "<h2> Tasks Results</h2>";
        while ($arr = pg_fetch_array($query_result)) {
            $t_title = $arr[0];
            $t_description = $arr[1];
            $t_result = $arr[2];
            
            if (empty($t_result)) $t_result = "(not determined)";
            echo "<b> $t_title </b> $t_description --> RESULT: <b>$t_result</b><br/>";
        }

        echo "<br><h2> Top 10 workers </h2>";
        $query_result = pg_query($db_conn, 
                "SELECT username
                FROM worker_campaign wc JOIN worker_view v ON wc.worker = v.id 
                WHERE wc.campaign = $c_id 
                ORDER BY score DESC");
        
        echo "<ol>";

        $rows_num = pg_num_rows($query_result);
        for ($i=0; $i < $rows_num; $i++)  {
            echo "<li>" . pg_fetch_result($query_result, $i, 0) . "</li>";
        }
        echo "</ol>";
    ?>
    </div>
    </div>
    </div>
</body>
</html>