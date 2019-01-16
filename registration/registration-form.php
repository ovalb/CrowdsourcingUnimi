<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdsourcing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/registration-form.css" >
    <link rel="stylesheet" href="../sticky-footer.css" >
</head>

<body>
    <header class="page-header text-center mb-4">
        <h1 id='derp'>REGISTRATION PAGE</h1>
    </header>
        <div class='container'>
        <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
        <form id='registration' action="registration-process.php" name='reg_form' method="post">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">    
                <label class="btn btn-secondary btn-lg active"> Requester
                    <input id="requester" type='radio' name='usertype' value='requester' hideautocomplete="off" checked> 
                </label>
                <label class="btn btn-secondary btn-lg"> Worker
                    <input id="worker" type='radio' name='usertype' value='worker' autocomplete="off"> 
                </label>
            </div>

            <fieldset class="form-group input-form">
                <input class='form-control' type="text" name="username" placeholder="Username" required> 
                <input class='form-control' type="password" name='password' placeholder="Password" required>
                <input class='form-control' type="password" name='repeated-psw' placeholder="Repeat Password" required>
            </fieldset>


            <!-- <fieldset class="worker_keyword">
            <select id="keys" name='keywords[]' class="form-control" data-placeholder="Choose keywords..." >     
            <?php
                // $db_conn = pg_connect("host=localhost port=5432 dbname=crowdsourcing user=onval"); 
                // $result = pg_query($db_conn, "SELECT id, name FROM keyword;");
                // while ($arr = pg_fetch_array($result)) {
                //     $id = $arr[0];
                //     $name = $arr[1];
                //     echo "<option value=$id>$name";
                // }
            ?>
            </select>   
            <label for='slider'>Skill level:</label>               
            <input id='slider' type='range' min='0' max='5' step='1' />
            <button class="btn btn-secondary btn-sm" onclick="add_keyword()">+</button>
        </fieldset> -->

        <input class='btn btn-primary btn-lg register-btn' type="submit" name='register' value='Register'>

        <!-- <div class='worker-nav'>
            <button id='prev-btn' class='btn btn-secondary btn-md'> Previous </button>
            <button id='next-btn' class='btn btn-primary btn-md'> Next </button>
        </div> -->
        </form>
        </div>
    </div>
    </div>

   

    <footer class="footer text-right pr-4">
        <span class="text-muted">Made by Giorgio Valbonesi</span>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

    <script>
        $(function() {
            

            // showRequesterRegistration();

            $("#requester").click(reqRegistration);
            $("#worker").click(workRegistration);

        })

      var reqRegistration = function showRequesterRegistration() {
            $("fieldset.worker_keyword").hide();
            $(".input-form").show();
            $(".register-btn").show();

            $("#prev-btn").hide();
            $("#next-btn").hide();
        }

        var workRegistration = function showWorkerRegistrationPage1() {
            $(".register-btn").hide();
            $("fieldset.worker_keyword").hide();
            $(".input-form").show();
            $("#prev-btn").hide();
            $("#next-btn").show();
        }

        function showWorkerRegistrationPage2() {
            $(".register-btn").hide();
            $(".input-form").hide();
        }
    </script>
    <!-- <script>
        $(function() {
            $().button('toggle');
        });
    </script> -->
    <!-- <script>
        $(function() {
            $(".chosen-select").chosen(); 

        });

        var keywords = [];

        function hideChosen() {
            $("#key_container").hide();
        }

        function showChosen() {
            $("#key_container").show();
        }

        function add_keyword() {
            var trait = $("#keys").val();
            var level = $("#slider").val();

            var input = `<input type='hidden' class='textfield' name='keys[${trait}]' value='${level}' >`;
            $("#reg-form").append(input);
        }
   </script> -->

</body>
</html>