<?php
    echo "<form id='registration' action='registration-process.php' name='reg_form' method='post'>
    <div class='btn-group btn-group-toggle' data-toggle='buttons'>
        <label style='box-shadow: none;' class='btn btn-secondary btn-lg active noshadow'> Requester
            <input type='radio' name='usertype' id='requester'  value='requester' autocomplete='off'  checked> 
        </label>
        <label style='box-shadow: none;' class='btn btn-secondary btn-lg'> Worker
            <input type='radio' name='usertype' id='worker' value='worker' autocomplete='off'> 
        </label> 
    </div>";
?>