<?php
    session_start();

    require '../utility/redirect.php';

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Worker Profile</title>
</head>
<body class='text-center'>
    <header> 
        <?php require_once("../includes/worker-header.php");?>    
    </header>  

    <div class='container' style='width:40%; margin-bottom:160px;'>
    <div class='row'> 
    <div class="col">

    <h2 style='margin-top:40px;'>Your keywords</h2>

        <form action='../remove-keyword.php' method='post'>
        <table class='table table-borderless'>
        <thead>
        <tr>
            <th>Keyword</th>
            <th>Level</th>
        </tr>
        </thead>
        <tbody>

        <?php
            $query = "SELECT k.id, k.name, wk.level 
            FROM worker_keyword wk JOIN keyword k on wk.keyword = k.id
            WHERE worker = $id";
        
            $query_result = pg_query($db_conn, $query);

            while ($arr = pg_fetch_array($query_result)) {
                echo "<tr><td>$arr[1]</td><td>$arr[2]</td>
                        <td><button type='submit' class='btn btn-sm btn-danger' name='rmv_keyword' value='$arr[0]'>Remove</button>
                        </td></tr>";
            }
        ?>

        </tbody></table></form>        

        <form id='addkeyword' action='../add-keyword.php' method='post'>

        <h5 style='margin-top:50px'> Add one or more skills/competencies </h5>
        <ul id="added_levels"></ul>

        <fieldset class="worker_keyword only_worker">
            <select style='width:300px; margin:auto;' name='selected_keyword' class="form-control" form='addkeyword' data-placeholder="Choose keywords..." >
                <?php
                    $query = "SELECT k.id, k.name FROM keyword k
                                EXCEPT
                            SELECT k.id, k.name 
                            FROM keyword k JOIN worker_keyword wk ON k.id = wk.keyword
                            WHERE worker = $id";

                    $result = pg_query($db_conn, $query);
                    while ($arr = pg_fetch_array($result)) {
                        $id = $arr[0];
                        $name = $arr[1];
                        echo "<option value=$id>$name";
                    }
                ?>
            </select><br>
            <label for='slider'>Skill level</label><br>
            <input id='slider' type='range' class='only_worker' style='width:300px;' min='1' max='5' step='1' name='level' /><br><br>
            <button type='submit' class="btn btn-secondary btn-sm only_worker" name='add-btn' value='add_pressed'>Add keyword</button>
        </fieldset>
        </form>

    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</body>
</html>