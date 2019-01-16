<?php
    require '../utility/redirect.php';

    if (!isset($_POST['register']))
        redirect("registration-form.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdsourcing</title>
    <!-- <link rel='stylesheet' href='../node_modules/chosen-js/chosen.css' /> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../sticky-footer.css" >
</head>
<body>
<h1>
    <?php
        echo "Seleziona keywords per " . $_POST['username'];
    ?>
</h1>

    <div id="key_container">
    
        <select id="keys" name='keywords[]' form='task-form' class="chosen-select" data-placeholder="Choose keywords..." >
             
            <?php
            $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval"); 
            $result = pg_query($db_conn, "SELECT id, name FROM keyword;");
            while ($arr = pg_fetch_array($result)) {
                $id = $arr[0];
                $name = $arr[1];
                echo "<option value=$id>$name";
            }
        ?>
        </select>
                        
        <input id='slider' type='range' min='0' max='5' step='1' />
        <button class="btn btn-secondary btn-sm" onclick="add_keyword()"> Add </button>

    </div>

    <!-- <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script> -->
</body>
</html>
