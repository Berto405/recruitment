<?php
include("dbconn.php");
include("header.php");
$query = "SELECT * FROM jobs";
$result = mysqli_query($conn, $query);

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
    <?php
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        ?>
        <script>
            swal({
                title: "Success!",
                icon: "success",
                text: "<?php echo $message; ?>"

            });
        </script>

        <?php
    }
    ?>
    <div class="container">
        <div class="container-fluid bg-white shadow mb-3 mt-5">
            <h4 class=" mt-1 mb-1">Available Job Openings</h4>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 ">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="card shadow mb-3">
                        <div class="card-body">
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
                                    <button class="btn btn-primary" onclick="showDetails(<?php echo $row['id'] ?>)">
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
                                    <a href="login.php" class="btn btn-primary">
                                        Apply now
                                    </a>
                                    ';
                                } else {

                                    echo '
                                    <form action="" method="post">
                                        <button type="submit" class="btn btn-primary">Apply now</button>
                                    </form>

                                    ';
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