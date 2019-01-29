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
    <title>Create Tasks</title>
    <link rel='stylesheet' href='../node_modules/chosen-js/chosen.css' />
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
    integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
</head>
<body style='text-align:center; background:#efefef;'>
    <h2>Create Tasks</h2>

    <main class='container' style='width:40%'>
    
    <form id='task-form' action='validate-task.php' method='POST'>
        <label for='title' class='sr-only'> Title: </label>
        <input type="text" class='form-control' name="title" id='title' placeholder='Task title'>
        
        <br>

        <label for='desc' class='sr-only'> Description: </label>
        <input type="text" class='form-control' placeholder='Description' name="desc" id='desc' required>

        <br>

        <label for='options' class='sr-only'> Options (separate with comma): </label>
        <input type="text" class='form-control' placeholder='Options (separate with comma)' name="options" id='options' required>

        <br>
        <label for='keywords' class='sr-only'> Keywords: </label>

        <select name='keywords[]' form='task-form' class=" form-control chosen-select" data-placeholder="Choose keywords..." multiple >
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

        <br><br>
        <div class='row'>
        <div class='col-md-6'>
        <button class='btn btn-lg btn-primary' type="submit" name="add" value='Add Task'>Add Task</button>
        </div>

        <div class='col-md-6'>
        <a class='btn btn-lg btn-danger' href="../requester.php"> Finish </a>
        </div>

    </div>
    </form>
    </main>

   <script>
        $(function() {
            $(".chosen-select").chosen();
        });
   </script>
</body>
</html>
