<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Home</title>
</head>
<body>
    <header> 
        <span>
            <?php 
                echo ("ADMIN: You are logged in as " . $_SESSION['username']);
            ?>    
        </span>
    </header>
    <div> 
    <?php
        $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval");

        if (!$db_conn) {
            echo "nothing to see.";
            exit;
        }

        $result = pg_query($db_conn, "SELECT id, username FROM requester WHERE has_permission = 'f'");
        while ($row = pg_fetch_row($result)) {
            echo "Grant permission to $row[1]";
            echo "<form action='grant-permission.php' method='post'>";
            echo "<button type='submit' name='grant' value=$row[0]> Grant </button>";
            echo "</form>";
        }
        ?>
    </div>

    <a href="../login/logout.php">Logout </a>
    </form>
</body>
</html>