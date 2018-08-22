<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css" type="text/css" >
    <title>Crowdsourcing</title>
</head>
<body>
    <header>
    <p class='subtitle'>Welcome to the crowdsourcing university project for the 2018 Database Course</p>
        <h1> <span id='crowd_title'>CROWD</span><span id='sourcing_title'>SOURCING</span> </h1>
    </header>

    <section class="join_container" >
        <section id="worker" class="single_join_block"> 
            <a href="#" class='button'> Join as a worker </a>
            <a href="#" class="needtologin-w"> Already have an account? Sign in </a>
            <div class="description">
                <p>
                Workers are users who perform tasks.
                </p>
                <p>They have a profile that includes certain keywords which represent
                    the worker's affiliations and knowledge on specific topics.
                 </p>
            </div>
        </section><section id="requester" class="single_join_block">
            <a class='button' href='requester-form.php'> Join as a requester </a>

            <a href="#" class="needtologin-r"> Already have an account? Sign in </a>
            <div class="description">
                <p>The requester is responsible of creating and promoting work campaigns.</p>
                <p> After campaign creation, the requester defines:</p>
                <ul>
                    <li>the tasks to be done</li>
                    <li>the n. of workers involved in each task</li>
                    <li>the threshold to consider valid a task result</li>
                </ul>
            </div>
        </section>
    </section>

    <footer> Made by Giorgio Valbonesi </footer>
</body>
</html>