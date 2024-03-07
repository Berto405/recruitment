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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <link rel="stylesheet" href="style.css">
</head>

<body>


    <header class="p-3 shadow" style="background-color: #8b0000; border-color: #8b0000;">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/recruitment"
                    class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none me-2">
                    <h4>Recruitment</h4>
                </a>


                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <!-- Home Nav -->
                    <li>
                        <a href="/recruitment"
                            class="nav-link px-2 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment' || $_SERVER['REQUEST_URI'] == '/recruitment/' || $_SERVER['REQUEST_URI'] == '/recruitment/index.php') ? 'text-white' : 'text-secondary'; ?>">
                            Home
                        </a>
                    </li>

                    <?php
                    //Admin Dashboard Nav
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                        $adminDashboardUrl = "/recruitment/admin/home.php";

                        // Set the href attribute based on the user's role
                        $href = $adminDashboardUrl;

                        // Check if the current URL matches the admin dashboard URL
                        $isActive = ($_SERVER['REQUEST_URI'] == $adminDashboardUrl || $_SERVER['REQUEST_URI'] == $adminDashboardUrl . '/') ? ' text-white' : ' text-secondary';

                        echo '
                        <li>
                            <a href="' . $href . '" class="nav-link px-2' . $isActive . '">
                                Dashboard
                            </a>
                        </li>
                        ';
                    }
                    //My Jobs Nav
                    if (isset($_SESSION['user_id'])) {
                        echo '
                        <li><a href="#" class="nav-link px-2 text-secondary">My Jobs</a></li>
                        <li>
                            <a href="/recruitment/upload_resume.php" class="nav-link px-2 ' . ($_SERVER['REQUEST_URI'] == '/recruitment/upload_resume.php' || $_SERVER['REQUEST_URI'] == '/recruitment/upload)resume.php/' ? 'text-white' : 'text-secondary') . '">
                                Upload Resume
                            </a>
                        </li>
                        ';
                    }
                    ?>
                </ul>



                <div class="text-end">
                    <?php
                    //User's name and Logout Nav
                    if (isset($_SESSION["user_id"])) {
                        $user = $_SESSION["user_name"];
                        echo '
                
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <a href="#" class="text-white  text-decoration-none d-inline-block text-truncate">' . $user . '</a>
                            </div>
                            <div class="col-md-6">
                                <a href="/recruitment/logout.php" class="btn btn-outline-warning me-2">Logout</a>
                            </div>
                        </div>

                        ';
                    }//Login and Sign up Nav
                    else {
                        echo '
                        <a href="login.php" class="btn btn-outline-light me-2">Login</a>
                        <a href="register.php" class="btn btn-warning">Sign-up</a>
                        ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

</body>

</html>