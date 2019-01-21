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
    <link rel="stylesheet" href="css/requester.css" type="text/css" >
    <title>Document</title>
</head>
<body>
    <header> 
    <span>
        <?php 
        echo ("WORKER: You are logged in as " . $username);
        ?>    
    </span>
        </header>
    <div class="container"> 
        <?php
            echo "<b>AVAILABLE CAMPAIGNS TO ENROLL TO:</b><br>";
            $currentDate = date("Y-m-d");
            $res = pg_query("SELECT id, name, reg_period, open_date, close_date 
                            FROM campaign 
                            WHERE reg_period > '$currentDate' 
                        EXCEPT
                            SELECT id, name, reg_period, open_date, close_date 
                            FROM campaign c JOIN worker_campaign wc 
                            ON wc.worker = '$id' and wc.campaign = c.id");

            echo "<form action='enroll-process.php' method='POST'>";

                $index = 0;
                while ($arr = pg_fetch_array($res)) {
                    echo "<$index -> $arr[1] ( $arr[2] | $arr[3] to $arr[4])";
                    echo "<button type='submit' name='enroll' value='$arr[0]'>Enroll</button> </a><br>";
                    $index++;
                }
            echo "</form>";

            echo "<br><b> CAMPAIGNS ENROLLED TO:</b><br>";
            $res = pg_query("SELECT id, name, open_date, close_date 
                        FROM campaign c JOIN worker_campaign wc 
                        ON wc.worker = '$id' and wc.campaign = c.id");

            echo "<form method='post' action='/Crowdsourcing/campaign/do-campaign-tasks.php'>";
            echo "<table>"; 

            while ($arr = pg_fetch_array($res)) {
                echo "<tr>";
                echo "<td>$arr[1]</td> <td>$arr[2]</td> <td>$arr[3]</td> <td><button name='campaign' value='{$arr[0]}'>Do tasks!</a></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</form>"
        ?>
    </div>

    <a href="login/logout.php">Logout </a>
    </form>
</body>
</html>