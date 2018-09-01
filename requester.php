<?php
    session_start();
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
        echo ("REQUESTER: You are logged in as " . $_SESSION['username']);
        ?>    
    </span>
        </header>
    <div class="container"> 
        <?php
            echo "<p>No campaign has been created </p>" 
        ?>
    </div>

    <a href="/create_campaign.php">Create campaign </a>
    <a href="login/logout.php">Logout </a>
</body>
</html>