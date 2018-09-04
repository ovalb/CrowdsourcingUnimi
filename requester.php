<?php
    session_start();

    include 'utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_SESSION['username'])))
        redirect("index.php");
    
    $req_id = $_SESSION['id'];
    $req_username = $_SESSION['username'];
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
        echo ("REQUESTER: You are logged in as " . $req_username);
        ?> 
            <a href="login/logout.php">Logout </a>
    </span>
        </header>
    <div> 
        <?php
            //if this user doenn't have permission show that he can't do stuff
            $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval") 
                or redirect("index.php");
            
            $result = pg_query("SELECT has_permission FROM requester WHERE username='$req_username'");

            $req_permission = pg_fetch_result($result, 0);

            if ($req_permission == 'f') {
                echo "You don't have permission to create any campaign yet. Wait for admin.";
                exit;
            }
            $campaigns = pg_query("SELECT * FROM campaign WHERE requester = $req_id");

            if (pg_num_rows($campaigns) == 0)
                echo "No campaigns have been created. Press the button below.";
            else {
                while ($row = pg_fetch_row($campaigns)) {
                    echo "<div class='campaign'>";
                    echo "<b>$row[1]</b> Open/close: $row[3] - $row[4] <br>";
                    echo "Registration period: $row[5]";
                    echo "</div>";
                }
            }
        ?>
    </div>

    <a href="campaign/create-campaign-form.php">Create campaign </a>
</body>
</html>