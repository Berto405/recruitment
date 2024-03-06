<?php
session_start();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="stylesheet" href="style.css">
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-info justify-content-between py-0"
        style="background-color: #8b0000; border-color: #8b0000;">
        <a class="navbar-brand text-white" href="/recruitment" style="margin-left: 1rem;">
            <h4>Recruitment</h4>
        </a>

        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION["user_id"])) {
                $user = $_SESSION["user_name"];
                echo '
                    <li class="nav-item mt-1"><a href="#" class="text-white me-2 text-decoration-none"> ' . $user . ' </a></li>
                    <li class="nav-item"><a href="/recruitment/logout.php" type="submit" class="btn btn-outline-dark me-2 text-white border-color-white">Logout</a></li>
                       
                ';
            } else {
                echo '
                    <li class="nav-item"><a href="login.php" class="nav-link text-white">Sign in</a></li>
                    <li class="nav-item"><a href="register.php" class="nav-link text-white">Sign up</a></li>
                    ';
            }
            ?>

        </ul>

    </nav>


</body>

</html>