<?php
session_start();
include ("dbconn.php");
include ("header.php");

if ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php') {
    header("Location: index.php");
    exit();
}
if ($_SESSION['user_role'] !== 'user') {

    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: index.php");
    exit();
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $userId = $_SESSION['user_id'];

    if ($status === 'Result') {
        // Include 'Selected' and 'Not Selected' statuses
        $query =
            "SELECT jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, job_applicants.application_status 
            FROM jobs 
            INNER JOIN job_applicants ON jobs.id = job_applicants.job_id
            WHERE job_applicants.user_id = ? AND (job_applicants.application_status = ? OR job_applicants.application_status = ?)
            ORDER BY 
                CASE WHEN job_applicants.application_status = 'Selected' THEN 0 ELSE 1 END";

        $stmt = $conn->prepare($query);
        $status1 = 'Selected';
        $status2 = 'Not Selected';
        $stmt->bind_param("iss", $userId, $status1, $status2);
        $stmt->execute();
    } else {
        // Exclude 'Selected' and 'Not Selected' statuses
        $query =
            "SELECT jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, job_applicants.application_status 
            FROM jobs 
            INNER JOIN job_applicants ON jobs.id = job_applicants.job_id
            WHERE job_applicants.user_id = ? AND job_applicants.application_status = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $userId, $status);
        $stmt->execute();
    }
    $result = $stmt->get_result();

    //Determine the text color of application status
    function getStatusClass($status)
    {
        switch ($status) {
            case 'Pending':
                return 'text-secondary';
            case 'Reviewed':
                return 'text-primary';
            case 'Interview':
                return 'text-warning';
            case 'Selected':
                return 'text-success';
            case 'Not Selected':
                return 'text-danger';
            default:
                return ' ';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="container">
        <div class="container-fluid bg-white shadow mb-5 mt-5 ">
            <h4 class=" mt-1 mb-1 fw-bold">My Jobs</h4>
        </div>

        <div class="d-flex flex-row mb-2 overflow-x-auto w-100 bg-white px-2 shadow" style="overflow: hidden;">
            <div class="nav-item mx-2 text-dark px-3  py-2 mx-auto ">
                <a href="my_jobs.php?status=Pending"
                    class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Pending' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Pending/') ? 'text-dark fw-bold' : 'text-secondary'; ?>">
                    Pending
                </a>
            </div>

            <div class="nav-item mx-2 text-dark px-3  py-2 mx-auto">
                <a href="my_jobs.php?status=Reviewed"
                    class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Reviewed' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Reviewed/') ? 'text-dark fw-bold' : 'text-secondary'; ?>">
                    Reviewed
                </a>
            </div>

            <div class="nav-item mx-2 text-dark px-3  py-2 mx-auto">
                <a href="my_jobs.php?status=Interview"
                    class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Interview' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Interview/') ? 'text-dark fw-bold' : 'text-secondary'; ?>">
                    Interview
                </a>
            </div>

            <div class="nav-item mx-2 text-dark px-3  py-2 mx-auto">
                <a href="my_jobs.php?status=Result"
                    class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Result' || $_SERVER['REQUEST_URI'] == '/recruitment/my_jobs.php?status=Result/') ? 'text-dark fw-bold' : 'text-secondary'; ?>">
                    Result
                </a>
            </div>

        </div>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row">
                <div class="col-sm-12 col-md-12 ">
                    <div class="container-fluid bg-white shadow mb-3 mt-4 border-2 border-top border-danger">
                        <div class="row p-2">
                            <h4 class="fw-bold">
                                <?php echo $row['job_name'] ?>
                            </h4>

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
                                    <div
                                        class="fw-bold rounded-1 <?php echo getStatusClass($row['application_status']); ?>">
                                        <?php echo $row['application_status']; ?>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
            <?php
        }

        ?>

    </div>
</body>

</html>
<?php include ('footer.php'); ?>