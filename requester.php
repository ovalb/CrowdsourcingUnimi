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
    <span>You are logged in as
        <?php echo "Pluto" ?>    
    </span>
        </header>
    <div class="container"> 
        <?php
            echo "<p>No campaign has been created </p>" 
        ?>
    </div>
    <form action="create_campaign.php">
        <input type='button'> Create campaign</input>
    </form>
</body>
</html>