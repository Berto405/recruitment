<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SweetAlert CDN -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Summernote CDN -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- DataTable CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">

    <!-- JQuery CDN -->
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Apex Chart CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        .sidebarMenu .nav-link:hover {
            background-color: rgba(220, 53, 69, 0.25);
            color: #dc3545;
        }

        .custom-dropdown {
            left: -70px;
            /* Adjust the value as needed */
        }
    </style>

</head>


<body style="background-color: #FEF7F7; ">
    <?php
    if (isset($_SESSION['success_message'])) {
        $message = $_SESSION['success_message'];
        ?>
        <script>
            swal({
                title: "Success!",
                icon: "success",
                content: {
                    element: "p",
                    attributes: {
                        innerHTML: "<?php echo $message; ?>",
                        style: "text-align: center;"
                    }
                }

            });
        </script>

        <?php
        //Unset session of success message so that it wont appear again
        unset($_SESSION['success_message']);
    } else if (isset($_SESSION['error_message'])) {
        $error = $_SESSION['error_message'];
        ?>
            <script>
                swal({
                    title: "Oops!",
                    icon: "error",
                    content: {
                        element: "p",
                        attributes: {
                            innerHTML: "<?php echo $error; ?>",
                            style: "text-align: center;"
                        }
                    }
                });
            </script>

            <?php
            //Unset session of error message so that it wont appear again
            unset($_SESSION['error_message']);
    }
    ?>

    <!--Main Navigation-->
    <header>
        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand " href="/recruitment/index.php">
                    <h3 class="text-danger">Recruitment</h3>
                </a>

                <!-- Toggle button -->
                <button class="navbar-toggler me-3 border-0" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sideBarMobile" aria-controls="sideBarMobile" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="bi bi-list text-danger"></i>
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
                        if (isset($_SESSION['user_role'])) {
                            if ($_SESSION['user_role'] !== 'user' && $_SESSION['user_role'] !== 'Operations') {
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
                            } else if ($_SESSION['user_role'] == 'Operations') {
                                $mrfUrl = "/recruitment/admin/add_mrf.php";
                                $href = $mrfUrl;
                                $isActive = ($_SERVER['REQUEST_URI'] == $mrfUrl || $_SERVER['REQUEST_URI'] == $mrfUrl . '/') ? ' text-dark fw-bold' : ' text-secondary';
                                echo '
                                    <li class="nav-item">
                                        <a href="' . $href . '" class="nav-link  link-dark ' . $isActive . '">
                                            MRF
                                        </a>
                                    </li>
                                ';
                            }
                        }
                        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'user') {
                            echo '
                                <li class="nav-item">
                                    <a href="/recruitment/my_jobs.php" class="nav-link link-dark  '
                                . ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php/' ? 'text-dark fw-bold' : 'text-secondary') . '">
                                        My Jobs
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/recruitment/my_resume.php" class="nav-link link-dark ' . ($_SERVER['REQUEST_URI'] == '/recruitment/my_resume.php' || $_SERVER['REQUEST_URI'] == '/recruitment/my_resume.php/' ? 'text-dark fw-bold' : 'text-secondary') . '">
                                        My Resume
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/recruitment/submit_application.php" class="nav-link link-dark ' . ($_SERVER['REQUEST_URI'] == '/recruitment/submit_application.php' || $_SERVER['REQUEST_URI'] == '/recruitment/submit_application.php/' ? 'text-dark fw-bold' : 'text-secondary') . '">
                                        Submit Application
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/recruitment/verify_phone.php" class="nav-link link-dark ' . ($_SERVER['REQUEST_URI'] == '/recruitment/verify_phone.php' || $_SERVER['REQUEST_URI'] == '/recruitment/verify_phone.php/' ? 'text-dark fw-bold' : 'text-secondary') . '">
                                        Verify Phone Number
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
                            ?>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="dropdown ">
                                        <a href="#" class="link-danger text-decoration-none dropdown-toggle text-dark"
                                            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php echo $user; ?>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile "
                                            style="position: absolute; inset: 0px -100px auto auto; margin: 0px; transform: translate3d(-16px, 38px, 0px);"
                                            data-popper-placement="bottom-end">

                                            <li>
                                                <a class="dropdown-item" href="/recruitment/profile.php">
                                                    <i class="bi bi-person-circle"></i> Profile
                                                </a>
                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="/recruitment/logout.php">
                                                    <i class="bi bi-box-arrow-right"></i> Sign out</i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?php

                        } else {
                            ?>
                            <a href="login.php" class="btn btn-outline-danger me-2" style="border-radius: 0;">Login</a>
                            <a href="register.php" class="btn btn-danger" style="border-radius: 0;">Sign-up</a>

                            <?php
                        }
                        ?>
                    </div>


                </div>
                <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>


    <!-- Sidebar on Smaller Screens -->
    <div class="offcanvas offcanvas-start bg-white" tabindex="-1" id="sideBarMobile" aria-labelledby="sideBarMobile">
        <?php
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_role'])) {
            ?>
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                <ul class="nav flex-column mt-5">
                    <?php
                    if ($_SESSION['user_role'] != "user") {
                        ?>
                        <div class="text-center mt-5">
                            <img src="../img/images/topserveLogo.jpg" alt="Topserve Logo" width="150" height="50">
                        </div>

                        <!-- Dashboard -->
                        <li class="mt-5">
                            <a href="/recruitment/admin/home.php"
                                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                <i class="bi bi-house-fill me-2"></i><span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Manage Applicants -->
                        <li>
                            <a class="nav-link  bg-opacity-25 p-2 ps-4 text-danger <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/placed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/failed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/backout_applicant.php') ? 'bg-danger ' : ''; ?>"
                                data-bs-toggle="collapse" href="#manageApplicantCollapse" role="button" aria-expanded="false"
                                aria-controls="manageApplicantCollapse">
                                <i class="bi bi-person-vcard-fill me-2"></i>Manage Applicants
                                <i class="bi bi-chevron-down me-2 float-end"></i>
                            </a>
                            <div class=" collapse  <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/placed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/failed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/backout_applicant.php') ? 'show' : ''; ?>"
                                id="manageApplicantCollapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal m-0 mb-2 p-0">
                                    <li class="my-1  bg-container text-white">
                                        <a href="../admin/pooling_applicant.php"
                                            class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            Pooling
                                        </a>
                                    </li>
                                    <li class="my-1 menu_">
                                        <a href="../admin/shortlisted_applicant.php"
                                            class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            Shortlisted
                                        </a>
                                    </li>
                                    <li class="my-1 ">
                                        <a href="../admin/identified_applicant.php"
                                            class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            Identified
                                        </a>
                                    </li>
                                    <li class="my-1 ">
                                        <a href="../admin/placed_applicant.php"
                                            class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/placed_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            Placed
                                        </a>
                                    </li>
                                    <li class="my-1 ">
                                        <a href="../admin/failed_applicant.php"
                                            class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/failed_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            Failed
                                        </a>
                                    </li>
                                    <li class="my-1 ">
                                        <a href="../admin/backout_applicant.php"
                                            class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/backout_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            Backout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- MRF List -->
                        <li>
                            <a href="../admin/mrf_list.php"
                                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/mrf_list.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/mrf_list.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                <i class="bi bi-briefcase-fill me-2"></i>MRF List
                            </a>
                        </li>

                        <!-- Interview Calendar -->
                        <li>
                            <a href="../admin/interview_calendar.php"
                                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/interview_calendar.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/interview_calendar.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                <i class="bi bi-calendar-fill me-2"></i>Interview Calendar
                            </a>
                        </li>
                        <?php
                        if ($_SESSION['user_role'] == 'Super Admin') {
                            ?>
                            <li>
                                <!-- Manage User -->
                                <a href="../admin/manage_user.php"
                                    class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                    <i class="bi bi-person-fill-gear me-2"></i>Manage User
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                    } else {
                        ?>

                        <li class="nav-item">
                            <a href="/recruitment"
                                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment' || $_SERVER['REQUEST_URI'] == '/recruitment/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                <i class="bi bi-house-fill me-2"></i><span>Home</span>
                            </a>
                        </li>

                        <?php
                        if ($_SESSION['user_role'] !== 'user' && $_SESSION['user_role'] !== 'Operations') {
                            $adminDashboardUrl = "/recruitment/admin/home.php";
                            $href = $adminDashboardUrl;
                            $isActive = ($_SERVER['REQUEST_URI'] == $adminDashboardUrl || $_SERVER['REQUEST_URI'] == $adminDashboardUrl . '/') ? ' border-end border-danger border-5 bg-danger text-white' : ' text-danger';
                            echo '
                            <li class="nav-item">
                                <a href="' . $href . '" class="nav-link p-2 ps-4' . $isActive . '">
                                    <i class="bi bi-house-fill me-2"></i><span>Dashboard</span>
                                </a>
                            </li>
                        ';
                        } else if ($_SESSION['user_role'] == 'Operations') {
                            $mrfUrl = "/recruitment/admin/add_mrf.php";
                            $href = $mrfUrl;
                            $isActive = ($_SERVER['REQUEST_URI'] == $mrfUrl || $_SERVER['REQUEST_URI'] == $mrfUrl . '/') ? ' border-end border-danger border-5 bg-danger text-white' : ' text-danger';
                            echo '
                            <li class="nav-item">
                                <a href="' . $href . '" class="nav-link p-2 ps-4' . $isActive . '">
                                    <i class="bi bi-briefcase-fill me-2"></i>MRF
                                </a>
                            </li>
                        ';
                        }

                        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'user') {
                            echo '
                            <li class="nav-item">
                                <a href="/recruitment/my_jobs.php" class="nav-link p-2 ps-4 ' . ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs/' ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger') . '">
                                    <i class="bi bi-briefcase-fill me-2"></i>My Jobs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/recruitment/my_resume.php" class="nav-link p-2 ps-4 ' . ($_SERVER['REQUEST_URI'] == '/recruitment/my_resume' || $_SERVER['REQUEST_URI'] == '/recruitment/my_resume/' ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger') . '">
                                    <i class="bi bi-briefcase-fill me-2"></i>My Resume
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/recruitment/submit_application.php" class="nav-link p-2 ps-4 ' . ($_SERVER['REQUEST_URI'] == '/recruitment/submit_application' || $_SERVER['REQUEST_URI'] == '/recruitment/submit_application/' ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger') . '">
                                    <i class="bi bi-briefcase-fill me-2"></i>Submit Application
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/recruitment/verify_phone.php" class="nav-link p-2 ps-4 ' . ($_SERVER['REQUEST_URI'] == '/recruitment/verify_phone' || $_SERVER['REQUEST_URI'] == '/recruitment/verify_phone/' ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger') . '">
                                    <i class="bi bi-briefcase-fill me-2"></i>Verify Phone Number
                                </a>
                            </li>
                        ';
                        }
                        ?>
                        <?php
                    }
                    ?>
                </ul>
            </div>

            <div class="offcanvas-footer d-flex justify-content-end border-top-5">
                <div class="dropup">
                    <?php
                    $user = $_SESSION["user_name"];
                    ?>
                    <div class="row">
                        <div class="col-sm-1 dropdown d-flex justify-content-start">
                            <a href="#" class="d-block link-danger text-decoration-none dropdown-toggle text-dark"
                                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $user; ?>
                            </a>
                            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                <li>
                                    <a class="dropdown-item" href="/recruitment/profile.php">
                                        <i class="bi bi-person-circle"></i> Profile
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item" href="/recruitment/logout.php">
                                        <i class="bi bi-box-arrow-right"></i> Sign out</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                <ul class="nav flex-column mt-5">
                    <li class="nav-item">
                        <a href="/recruitment"
                            class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment' || $_SERVER['REQUEST_URI'] == '/recruitment/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                            <i class="bi bi-house-fill me-2"></i><span>Home</span>
                        </a>
                    </li>

                    <a href="login.php" class="btn btn-outline-danger me-2 mt-5" style="border-radius: 0;">Login</a>

                    <a href="register.php" class="btn btn-danger mt-5" style="border-radius: 0;">Sign-up</a>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>



    <div class="container-fluid">
        <div class="row">
            <?php
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && $_SESSION['user_role'] != "user") {
                $current_page = basename($_SERVER['PHP_SELF']);
                if (($current_page !== 'index.php' && $current_page !== 'profile.php') || rtrim($current_page, '/') === '/recruitment') {
                    ?>
                    <!-- Sidebar -->
                    <nav class="col-md-2 col-lg-2 col-xl-2 bg-white  p-1 m-0 d-none d-lg-block sidebarMenu shadow-sm"
                        style="min-height: 100vh;">
                        <div class="list-group list-group-flush  mt-4">
                            <!-- Sidebar -->
                            <nav class="d-lg-block sidebar bg-white">
                                <ul class="nav flex-column mt-5">
                                    <div class="text-center mt-5">
                                        <img src="../img/images/topserveLogo.jpg" alt="Topserve Logo" width="150" height="50">
                                    </div>
                                    <li class="mt-5">
                                        <a href="/recruitment/admin/home.php"
                                            class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/home.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            <i class="bi bi-house-fill me-2"></i><span>Dashboard</span>
                                        </a>
                                    </li>
                                    <!-- Manage Applicants -->
                                    <li>
                                        <a class="nav-link  bg-opacity-25 p-2 ps-4 text-danger <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/placed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/failed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/backout_applicant.php') ? 'bg-danger ' : ''; ?>"
                                            data-bs-toggle="collapse" href="#manageApplicantCollapse" role="button"
                                            aria-expanded="false" aria-controls="manageApplicantCollapse">
                                            <i class="bi bi-person-vcard-fill me-2"></i>Manage Applicants
                                            <i class="bi bi-chevron-down me-2 float-end"></i>
                                        </a>
                                        <div class=" collapse  <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/placed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/failed_applicant.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/backout_applicant.php') ? 'show' : ''; ?>"
                                            id="manageApplicantCollapse">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal m-0 mb-2 p-0">
                                                <li class="my-1  bg-container text-white">
                                                    <a href="../admin/pooling_applicant.php"
                                                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/pooling_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                        Pooling
                                                    </a>
                                                </li>
                                                <li class="my-1 menu_">
                                                    <a href="../admin/shortlisted_applicant.php"
                                                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/shortlisted_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                        Shortlisted
                                                    </a>
                                                </li>
                                                <li class="my-1 ">
                                                    <a href="../admin/identified_applicant.php"
                                                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/identified_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                        Identified
                                                    </a>
                                                </li>
                                                <li class="my-1 ">
                                                    <a href="../admin/placed_applicant.php"
                                                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/placed_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                        Placed
                                                    </a>
                                                </li>
                                                <li class="my-1 ">
                                                    <a href="../admin/failed_applicant.php"
                                                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/failed_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                        Failed
                                                    </a>
                                                </li>
                                                <li class="my-1 ">
                                                    <a href="../admin/backout_applicant.php"
                                                        class="nav-link p-2 ps-4 ps-5 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/backout_applicant.php') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                        Backout
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li>
                                        <a href="../admin/mrf_list.php"
                                            class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/mrf_list.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/mrf_list.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            <i class="bi bi-briefcase-fill me-2"></i>MRF List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../admin/interview_calendar.php"
                                            class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/interview_calendar.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/interview_calendar.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                            <i class="bi bi-calendar-fill me-2"></i>Interview Calendar
                                        </a>
                                    </li>
                                    <?php
                                    if ($_SESSION['user_role'] == 'Super Admin') {
                                        ?>
                                        <li>
                                            <a href="../admin/manage_user.php"
                                                class="nav-link p-2 ps-4 <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php' || $_SERVER['REQUEST_URI'] == '/recruitment/admin/manage_user.php/') ? 'border-end border-danger border-5 bg-danger text-white' : 'text-danger'; ?>">
                                                <i class="bi bi-person-fill-gear me-2"></i>Manage User
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </nav>

                            <!-- Sidebar -->
                        </div>
                    </nav>
                    <!-- Sidebar -->
                    <?php
                }
            }
            ?>

            <!-- Main content -->
            <main class="<?php
            $currentPage = basename($_SERVER['PHP_SELF']); // Get the current script's filename
            if ($currentPage == 'index.php' || $currentPage == 'profile.php') {
                echo 'col-md-12 col-lg-12';
            } else {
                echo (empty($_SESSION['user_role']) || $_SESSION['user_role'] == 'user') ? 'col-md-12 col-lg-12' : 'col-md-12 col-lg-10';
            }
            ?>" style="margin-top: 100px">
                <!-- Main content goes here -->