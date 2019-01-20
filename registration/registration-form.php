<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
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
                <label style="box-shadow: none;" class="btn btn-secondary btn-lg active noshadow" onclick="requesterForm();"> Requester
                    <input type='radio' name='usertype' id="requester"  value='requester' autocomplete="off"  checked> 
                </label>
                <label style="box-shadow: none;" class="btn btn-secondary btn-lg" onclick="workerForm();"> Worker
                    <input type='radio' name='usertype' id="worker" value='worker' autocomplete="off"> 
                </label> 
            </div>

            <fieldset class="form-group input-form">
                <input class='form-control' type="text" name="username" placeholder="Username" autocomplete required> 
                <input class='form-control' type="password" name='password' placeholder="Password" autocomplete required>
                <input class='form-control' type="password" name='repeated-psw' placeholder="Repeat Password" autocomplete required>
            </fieldset>


            <h5 class="only_worker"> Add one or more competencies </h5>
            <ul class="only_worker" id="added_traits"> 
            </ul>
            <ul id="added_levels"></ul>

            <p id="no_skills" class="only_worker"> You must add at least one trait or expertise</p>

            <fieldset class="worker_keyword only_worker">
                <select id="keys" class="form-control" data-placeholder="Choose keywords..." >     
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
                <label for='slider' class='only_worker'>Skill level:</label>               
                <input id='slider' type='range' class='only_worker' min='0' max='5' step='1' />
                <button type='button' class="btn btn-secondary btn-sm only_worker" onclick="add_keyword()">+</button>
        </fieldset>

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
            requesterForm();
        });

        function add_keyword() {
            var traitText = $("#keys option:selected").text();
            var traitValue = $("#keys option:selected").val();

            var level = $('#slider').val();
            var removeButtonCode = "<button class='remove_keyword' onclick=remove_keyword(this) >X</button></li>";

            $("#no_skills").hide();
            $("#added_traits").append(`<li>${traitText} : ${level} ${removeButtonCode}</li>`);

            $("form").append(`<input type='hidden' name='traits[]' value='${traitValue}' />`);
            $("form").append(`<input type='hidden' name='levels[]' value='${level}' />`);
            $("#keys option:selected").attr('disabled', true);
        } 

        function remove_keyword(e) {
            $(e).parent().remove();

            var valueHtml = $(e).parent().html();

            var firstWords = [];
            for (var i=0;i<valueHtml.length;i++) {
                var codeLine = valueHtml[i];
                var firstWord = valueHtml.substr(0, valueHtml.indexOf(" "));
                firstWords.push(firstWord);
            }
            
            $(`#keys option:contains(${firstWords[0]})`).removeAttr('disabled');
        }

        function requesterForm() {
            $(".only_worker").hide();
        }

        function workerForm() {
            $(".only_worker").show();
        }
    </script>

</body>
</html>