<?php
include("dbconn.php");
$query = "SELECT * FROM jobs";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-6 mx-1">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="card shadow mb-3">
                        <div class="card-body">
                            <a href="job_details.php?id=<?php echo $row['id'] ?>" class="text-decoration-none">
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
                                    <!-- <span class="mt-4 text-secondary small">
                                </span> -->
                                    <a href="job_details.php?id=<?php echo $row['id'] ?>" class="btn btn-primary ">
                                        See Details
                                    </a>
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


</body>

</html>