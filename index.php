<?php
include ("index_process.php");
include ("components/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>

    <script>

        function searchJobs() {
            var input, filter, cards, card, i, jobName;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            cards = document.getElementsByClassName("card");

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                jobName = card.getElementsByClassName("job-name")[0].textContent.toLowerCase();

                if (jobName.includes(filter)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }


    </script>

</head>

<body style="background-color: #F4F4F4; ">

    <div class="container">
        <div class="container-fluid bg-white shadow mb-3 mt-5">
            <h4 class=" mt-1 mb-1 fw-bold">Available Job Openings</h4>
        </div>
        <div class="container bg-transparent  mb-3 ">


            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <div class="job_search">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6 col-lg-3 my-1">
                                    <div class="dropdown mb-2">
                                        <button class="btn btn-outline-danger dropdown-toggle form-control"
                                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <?php
                                            if (isset($_GET["loc"])) {
                                                $loc = $_GET["loc"];
                                                echo $loc;
                                            } else {
                                                ?>
                                                Location
                                                <?php
                                            }
                                            ?>
                                        </button>
                                        <div class="dropdown-menu"
                                            style="max-height: 300px; overflow-y: auto; width: 100%;"
                                            aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item" href="index.php?loc=Bacolod">Bacolod</a>
                                            <a class="dropdown-item" href="index.php?loc=Bicol">Bicol</a>
                                            <a class="dropdown-item" href="index.php?loc=Cagayan de Oro">Cagayan de
                                                Oro</a>
                                            <a class="dropdown-item" href="index.php?loc=Cavite">Cavite</a>
                                            <a class="dropdown-item" href="index.php?loc=Cebu">Cebu</a>
                                            <a class="dropdown-item" href="index.php?loc=Davao">Davao</a>
                                            <a class="dropdown-item" href="index.php?loc=General Santos">General
                                                Santos</a>
                                            <a class="dropdown-item" href="index.php?loc=Iloilo">Iloilo</a>
                                            <a class="dropdown-item" href="index.php?loc=Kalibo">Kalibo</a>
                                            <a class="dropdown-item" href="index.php?loc=Laguna">Laguna</a>
                                            <a class="dropdown-item" href="index.php?loc=Makati">Makati</a>
                                            <a class="dropdown-item" href="index.php?loc=Pampanga">Pampanga</a>
                                            <a class="dropdown-item" href="index.php?loc=Parañaque">Parañaque</a>
                                            <a class="dropdown-item" href="index.php?loc=Subic">Subic</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 my-1">
                                    <div class="dropdown mb-2">
                                        <button class="btn btn-outline-danger dropdown-toggle form-control"
                                            type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <?php
                                            if (isset($_GET["industry"])) {
                                                $industry = $_GET["industry"];
                                                echo $industry;
                                            } else {
                                                ?>
                                                Industry
                                                <?php
                                            }
                                            ?>
                                        </button>
                                        <div class="dropdown-menu" style="width: 100%;"
                                            aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="index.php?industry=Retail">Retail</a>
                                            <a class="dropdown-item" href="index.php?industry=Logistics">Logistics</a>
                                            <a class="dropdown-item" href="index.php?industry=Maintenance">
                                                Maintenance & Services
                                            </a>
                                            <a class="dropdown-item" href="index.php?industry=Food Services">
                                                Food Services
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 my-1">
                                    <div class="dropdown mb-2">
                                        <button class="btn btn-outline-danger dropdown-toggle form-control"
                                            type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <?php
                                            if (isset($_GET["type"])) {
                                                $type = $_GET["type"];
                                                echo $type;
                                            } else {
                                                ?>
                                                Contract Type
                                                <?php
                                            }
                                            ?>
                                        </button>
                                        <div class="dropdown-menu" style="width: 100%;"
                                            aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item" href="index.php?type=Probationary">Probationary</a>
                                            <a class=" dropdown-item"
                                                href="index.php?type=Project-based">Project-based</a>
                                            <a class="dropdown-item" href="index.php?type=Fixed Term">Fixed Term</a>
                                            <a class="dropdown-item" href="index.php?type=Regular On-call">Regular
                                                On-call</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 my-1">
                                    <div class="float-end input-group mb-2">
                                        <input id="searchInput" type="search" class="form-control" placeholder="Search"
                                            aria-label="Search" name="search" oninput="searchJobs()">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="search_result">

                            <div class="row">
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="col-md-6 ">
                                        <div class="card mb-2 ">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="card-text job-name">
                                                            <?php echo $row['job_position']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" class="btn btn-danger badge float-end"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewJobDetails<?php echo $row['id']; ?>">
                                                            See Details
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Job Details Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog"
                                        id="viewJobDetails<?php echo $row['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header p-5 pb-4 border-bottom-0">
                                                    <h1 class=" mb-0 fs-2">Job Details</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body p-5 pt-0">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h1>
                                                                <?php echo $row['job_position']; ?>
                                                            </h1>


                                                            <!-- Contract Type -->
                                                            <i class="bi bi-briefcase-fill"></i>
                                                            <span
                                                                class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                                                <?php echo $row['contract_type']; ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <h4 class="mt-4">Location</h4>

                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Location -->
                                                            <i class="bi bi-geo-alt-fill"></i><span>
                                                                <?php echo $row['location']; ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <h4 class="mt-4">Job Description</h4>

                                                    <p>
                                                        <?php echo $row['job_description']; ?>
                                                    </p>
                                                    <h4>Qualifications</h4>
                                                    <p>
                                                        <?php echo $row['qualification']; ?>
                                                    </p>
                                                    <!-- Checks if user is logged or not -->
                                                    <?php
                                                    if (!isset($_SESSION['user_id'])) {
                                                        echo '
                                                            <a href="login.php" class="btn btn-danger">
                                                                Apply now
                                                            </a>
                                                        ';
                                                    } else {
                                                        //If user does not have a resume
                                                        if ($result2->num_rows === 0) {

                                                            echo '
                                                                <a href="my_resume.php" class="w-100 mb-2 btn btn-lg rounded-3 btn-danger">
                                                                    Apply now
                                                                </a>
                                                            ';
                                                        } else {
                                                            echo '
                                                                <form action="apply_job_process.php" method="post">
                                                                    <input type="hidden" name="job_id" value="' . $row['id'] . '">
                                                                    <button type="submit" class="w-100 mb-2 btn btn-lg rounded-3 btn-danger">Apply now</button>
                                                                </form>
                            
                                                            ';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>
<?php include ('components/footer.php'); ?>