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
                            <a href="login.php" class="btn btn-outline-danger me-2" style="border-radius: 0;">Login</a>
                            <a href="register.php" class="btn btn-danger" style="border-radius: 0;">Sign-up</a>
                                
                        ';
                }
                ?>
            </div>


        </div>
    </div>
</nav>