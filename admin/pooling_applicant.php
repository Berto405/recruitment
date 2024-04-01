<?php
include ("../admin/applicant_process.php");

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] == 'user' || $_SESSION['user_role'] == 'Operations') {
    // Redirect non-admin users to index.php
    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: ../index.php");
    exit();
}

$query =
    "SELECT job_applicants.*, jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, jobs.priority, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status = 'Pending' OR  job_applicants.application_status = 'Pooling'
    ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";

$result = mysqli_query($conn, $query);

//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../components/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pooling Applicants</title>
    <style>
        #imagePreview {
            width: 1in;
            height: 1in;
            border: 1px solid #ccc;
            margin-top: 10px;
        }

        #imagePreview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>

</head>

<body style="background-color: #F4F4F4; ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow " style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Pooling Applicants</h4>

                <!-- Makes the table as component so that in can be reuse on Pooling, Shortlisted and Identified Applicants Sidebar -->
                <div class="table-responsive">
                    <?php include ('../components/applicants_table.php'); ?>
                </div>
            </div>
        </div>
    </div>



</body>

</html>

<?php include ('../components/footer.php'); ?>