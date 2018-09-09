<?php
    session_start();

    include '../utility/redirect.php';

    if (!(isset($_SESSION['id']) && isset($_SESSION['username'])))
        redirect("requester.php");
    
    if (!isset($_SESSION['campaign']))
        redirect("create-campaign-form.php");
?>

<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tasks Form</title>
    <link rel='stylesheet' href='../node_modules/chosen-js/chosen.css' />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
</head>
<body>
    <b>Create Tasks</b> <br>

    <form id='task-form' action='validate-task.php' method='POST'>
        <label for='title'> Title: </label>
        <input type="text" name="title" id='title'>
        
        <br>

        <label for='desc'> Description: </label>
        <input type="text" name="desc" id='desc' required>

        <br>

        <label for='options'> Options (separate with comma): </label>
        <input type="text" name="options" id='options' required>

        <br>
        <label for='keywords'> Keywords: </label>

        <select name='keywords[]' width="120px" form='task-form' class="chosen-select" data-placeholder="Choose keywords..." multiple >
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

        <br>
        <input type="submit" name="add" value='Add Task'>
    </form>

    <a href="../requester.php"> Finish </a>
   <script>
        $(function() {
            $(".chosen-select").chosen();
        });
   </script>
</body>
</html>
