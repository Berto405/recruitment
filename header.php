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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>



</head>

<body>


    <nav class="navbar navbar-expand-lg shadow bg-white">
        <div class="container">
            <a href="/recruitment" class="navbar-brand text-danger">
                <h4>Recruitment</h4>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-lg-start" id="navbarNav">
                <ul class="navbar-nav me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-item">
                        <a href="/recruitment"
                            class="nav-link link-dark <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment' || $_SERVER['REQUEST_URI'] == '/recruitment/' || $_SERVER['REQUEST_URI'] == '/recruitment/index.php') ? 'text-dark fw-bold' : 'text-dark'; ?>">
                            Home
                        </a>
                    </li>

                    <?php
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                        $adminDashboardUrl = "/recruitment/admin/home.php";
                        $href = $adminDashboardUrl;
                        $isActive = ($_SERVER['REQUEST_URI'] == $adminDashboardUrl || $_SERVER['REQUEST_URI'] == $adminDashboardUrl . '/') ? ' text-dark fw-bold' : ' text-secondary';
                        echo '
                        <li class="nav-item">
                            <a href="' . $href . '" class="nav-link  link-dark ' . $isActive . '">
                                Dashboard
                            </a>
                        </li>
                        ';
                    }
                    if (isset($_SESSION['user_id'])) {
                        echo '
                        <li class="nav-item">
                            <a href="/recruitment/my_jobs.php?status=Pending" class="nav-link link-dark  '
                            . ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Pending' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Pending/' ||
                                $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Reviewed' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Reviewed/' ||
                                $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Interview' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Interview/' ||
                                $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Result' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Result/' ? 'text-dark fw-bold' : 'text-secondary') . '">
                                My Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/recruitment/upload_resume.php" class="nav-link link-dark ' . ($_SERVER['REQUEST_URI'] == '/recruitment/upload_resume.php' || $_SERVER['REQUEST_URI'] == '/recruitment/upload_resume.php/' ? 'text-dark fw-bold' : 'text-secondary') . '">
                                Upload Resume
                            </a>
                        </li>
                        ';
                    }
                    ?>
                </ul>

                <div class="navbar-text text-end">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        $user = $_SESSION["user_name"];
                        echo '
                            <div class="row">
                                <div class="col-sm-1 dropdown d-flex justify-content-start">
                                    <a href="#" class="d-block link-danger text-decoration-none dropdown-toggle text-dark" id="dropdownUser2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ' . $user . '
                                    </a>
                                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                        <li><a class="dropdown-item" href="/recruitment/profile.php"><i class="bi bi-person-circle"></i> Profile</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="/recruitment/logout.php"><i class="bi bi-box-arrow-right"></i> Sign out</i></a></li>
                                    </ul>
                                </div>
                            </div>
                        ';

                    } else {
                        echo '
                            <a href="login.php" class="btn btn-outline-danger me-2">Login</a>
                            <a href="register.php" class="btn btn-danger">Sign-up</a>
                                
                        ';
                    }
                    ?>
                </div>


            </div>
        </div>
    </nav>


</body>

</html>