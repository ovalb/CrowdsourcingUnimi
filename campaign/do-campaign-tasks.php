<?php
    session_start();
    require '../utility/redirect.php';

    if (!isset($_SESSION['id']))
        redirect('../index.php');

    $worker_id = $_SESSION['id'];

    if (isset($_POST['campaign'])) {
        $_SESSION['campaign'] = $_POST['campaign'];
    }

    $username = $_SESSION['username'];
    $campaign_id = $_SESSION['campaign'];

    // print "worker id" . $worker_id;
    // print "campaign id " . $campaign_id;

    $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval")
        or redirect("home.php?result=conn_err");

?>

<html>
    <head>
        <title>Do tasks</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
            integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>

    </head>

    <body>
        <header> 
        <?php require_once('../includes/worker-header.php'); ?>
        </header>

        <main class='container'>
            <div class='row'>
                <div class='col-md-8 offset-md-2 text-center'>
        <?php
            pg_query($db_conn, "SELECT assign_task_affinity($worker_id, $campaign_id)");

            $query = "SELECT t.id, t.title, t.description
                FROM worker_task wt RIGHT JOIN task t ON wt.task = t.id
                WHERE wt.worker = $worker_id AND t.campaign = $campaign_id AND chosen_option IS NULL
                ORDER BY affinity DESC
                LIMIT 1";

            $query_result = pg_query($db_conn, $query);
            
            if (pg_num_rows($query_result) == 0) {
                echo "<p>No tasks available right now</p>";
                echo "<a href='../worker.php'>Go back</a>";
            } else {
                $task_id = pg_fetch_result($query_result, 0);
                $task_title = pg_fetch_result($query_result, 1);
                $task_description = pg_fetch_result($query_result, 2);

                $query = "SELECT o.id, o.name FROM task_option o WHERE o.task = $task_id";
                $query_result = pg_query($db_conn, $query);

                echo "<h4>$task_title</h4>";
                echo "<h5>$task_description</h5>";

                // list options
                echo "<form action='execute-task.php' method='post'>
                    <ul style='list-style:none; text-align:left; margin-left:200px;'>";
                for ($i=0; $i < pg_num_rows($query_result); $i++) {
                    $option_id = pg_fetch_result($query_result, $i, 0);
                    $option_name = pg_fetch_result($query_result, $i, 1);
                    if ($i == 0)
                        echo "<li><input type='radio' name='sel_option' value=$option_id checked> $option_name</li>";
                    else
                        echo "<li><input type='radio' name='sel_option' value=$option_id> $option_name</li>";
                }
                echo "</ul>";

                echo "<button class='btn btn-primary' type='submit'> Confirm</button>";
                // echo "<input type='submit' name='skip'> Skip";
                // echo "<input type='submit' name='finish'> Finish";

                echo "</form>";
                }
        ?>
                </div>
            </div>
        </main>
    </body>
</html>

