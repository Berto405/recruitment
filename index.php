<?php
include("dbconn.php");
include("header.php");
//For Showing the Jobs

if (isset($_SESSION['user_id'])) {
    //Showing only the jobs that the currently logged in user has not applied
    $userId = $_SESSION['user_id'];
    $query =
        "SELECT jobs.* 
        FROM jobs
        LEFT JOIN job_applicants ON jobs.id = job_applicants.job_id AND job_applicants.user_id = '$userId'
        WHERE job_applicants.user_id is NULL
        ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
    $result = mysqli_query($conn, $query);

    //Getting the currently logged in user's resume to know if its empty
    $query2 = "SELECT resume FROM user WHERE id='$userId'";
    $result2 = mysqli_query($conn, $query2);
    $row = mysqli_fetch_assoc($result2);
    $resume = $row['resume'];
} else {
    //Showing all jobs for not logged in user
    $query = "SELECT * FROM jobs ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
    $result = mysqli_query($conn, $query);
}

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

    </script>

</head>

<body style="background-color: #F4F4F4; ">

    <div class="container">
        <div class="container-fluid bg-white shadow mb-3 mt-5">
            <h4 class=" mt-1 mb-1 fw-bold">Available Job Openings</h4>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 ">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="card shadow mb-3 ">
                        <div class="card-body rounded-1 border-2 border-top border-danger">
                            <!-- Priority - Urgent or Not -->
                            <?php
                            if ($row['priority'] == 'Urgent Hiring') {
                                ?>
                                <span class="badge bg-danger">Urgent Hiring!</span>
                                <?php

                            }
                            ?>

                            <a href="javascript:void(0)" onclick="showDetails(<?php echo $row['id'] ?>)"
                                class="text-decoration-none">
                                <!-- Job Name -->
                                <h4 class="text-black mt-3">
                                    <?php echo $row['job_name']; ?>
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
                                    <!-- Job Type -->
                                    <span
                                        class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                        <?php echo $row['job_type']; ?>
                                    </span>
                                    <!-- Shift & Schedule -->
                                    <span
                                        class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                        <?php echo $row['shift_and_schedule']; ?>
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
                                    <?php echo $row['job_name']; ?>
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
                                    if (empty($resume)) {

                                        echo '
                                            <a href="upload_resume.php" class="btn btn-danger" style="border-radius: 0;">
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
                                            <?php echo $row['job_type']; ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <!-- Shift and Schedule -->
                                        <i class="bi bi-clock-fill"></i>
                                        <span
                                            class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                            <?php echo $row['shift_and_schedule']; ?>
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
                                <h4>Benefits</h4>
                                <p>
                                    <?php echo $row['benefits']; ?>
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