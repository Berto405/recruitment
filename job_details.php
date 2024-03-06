<?php
include("dbconn.php");

if (isset($_GET["id"])) {
    $job_id = mysqli_real_escape_string($conn, $_GET["id"]);

    $query = "SELECT * FROM jobs WHERE id = '$job_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
    } else {
        echo "Job Not Found.";
        exit();
    }

} else {
    echo "No Job ID Provided.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-6 mx-1">
                <a href="/recruitment" class="text-muted"><i class="bi bi-backspace-fill"></i></a>
                <h1>
                    <?php echo $row['job_name']; ?>
                </h1>

                <button type="button" class="btn btn-primary">
                    Apply now
                </button>

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
</body>

</html>