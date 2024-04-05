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
        function showDetails(jobID) {
            var jobDetails = document.getElementById("details_" + jobID).innerHTML;
            var cardBody = document.getElementById("job_details");
            cardBody.innerHTML = jobDetails;

            document.getElementById("hiddenContent").style.display = "block";

            //Scroll down to hiddentContent when screen is less than or equal to 780.
            if (window.innerWidth <= 780) {
                var hiddenContentTop = document.getElementById("hiddenContent").offsetTop;
                window.scrollTo({ top: hiddenContentTop, behavior: "smooth" });
            }
        }
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
                <div class="col-md-9">
                    <div class="container d-flex mb-2">
                        <div class="row ">
                            <div class="col-md col-sm">
                                <div class="dropdown mb-2">
                                    <button class="btn btn-outline-danger dropdown-toggle form-control" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
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
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
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
                            <div class="col-md col-sm ">
                                <div class="dropdown mb-2">
                                    <button class="btn btn-outline-danger dropdown-toggle form-control" type="button"
                                        id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <?php
                                        if (isset($_GET["dept"])) {
                                            $dept = $_GET["dept"];
                                            echo $dept;
                                        } else {
                                            ?>
                                            Department
                                            <?php
                                        }
                                        ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item" href="index.php?dept=IT">IT</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md col-sm">
                                <div class="dropdown mb-2">
                                    <button class="btn btn-outline-danger dropdown-toggle form-control" type="button"
                                        id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <?php
                                        if (isset($_GET["type"])) {
                                            $type = $_GET["type"];
                                            echo $type;
                                        } else {
                                            ?>
                                            Job Type
                                            <?php
                                        }
                                        ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item" href="index.php?type=Full-time">Full-time</a>
                                        <a class=" dropdown-item" href="index.php?type=Part-time">Part-time</a>
                                        <a class="dropdown-item" href="index.php?type=Intern">Intern</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-md-3">
                    <div class="float-end input-group mb-2">
                        <input id="searchInput" type="search" class="form-control" placeholder="Search"
                            aria-label="Search" name="search" oninput="searchJobs()">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>



        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 " id="searchResultsContainer">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="card shadow mb-3 ">
                        <div class="card-body rounded-1 border-2 border-top border-danger">

                            <a href="javascript:void(0)" onclick="showDetails(<?php echo $row['id'] ?>)"
                                class="text-decoration-none">
                                <!-- Job Position -->
                                <h4 class="text-black mt-3 job-name">
                                    <?php echo $row['job_position']; ?>
                                </h4>
                            </a>

                            <div class="row">
                                <div class="col">
                                    <!-- Location -->
                                    <i class="bi bi-geo-alt-fill"></i><span>
                                        <?php echo $row['location']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Contract Type -->
                                    <span
                                        class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                        <?php echo $row['contract_type']; ?>
                                    </span>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <!-- <span class="mt-4 text-secondary small"></span> -->
                                    <button class="btn btn-outline-danger" onclick="showDetails(<?php echo $row['id'] ?>)"
                                        style="border-radius: 0;">
                                        See Details
                                    </button>
                                </div>
                            </div>

                            <!-- Job Details - initially hidden -->
                            <div id="details_<?php echo $row['id']; ?>" class="d-none">
                                <a href="/recruitment" class="text-muted"><i class="bi bi-backspace-fill"></i></a>
                                <h1>
                                    <?php echo $row['job_position']; ?>
                                </h1>

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
                                            <a href="my_resume.php" class="btn btn-danger" style="border-radius: 0;">
                                                Apply now
                                            </a>
                                        ';
                                    } else {
                                        echo '
                                            <form action="apply_job_process.php" method="post">
                                                <input type="hidden" name="job_id" value="' . $row['id'] . '">
                                                <button type="submit" class="btn btn-danger" style="border-radius: 0;">Apply now</button>
                                            </form>
        
                                        ';
                                    }


                                }
                                ?>

                                <h4 class="mt-5">Job Details</h4>

                                <div class="row">
                                    <div class="col">
                                        <!-- Job Type -->
                                        <i class="bi bi-briefcase-fill"></i>
                                        <span
                                            class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                            <?php echo $row['contract_type']; ?>
                                        </span>
                                    </div>
                                </div>

                                <h4 class="mt-5">Location</h4>

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
                                <h4>Qualification</h4>
                                <p>
                                    <?php echo $row['qualification']; ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>


            <div class="col-sm-12 col-md-6" id="hiddenContent" style="display: none;">
                <div class="card shadow mb-3 d-flex">
                    <div class="card-body" id="job_details">

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<?php include ('components/footer.php'); ?>