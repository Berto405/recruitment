<?php
include ("../admin/applicant_process.php");
$pageTitle = "Placed Applicants";

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

$empId = $_SESSION['user_id'];
$empQuery = "SELECT industry_access FROM user WHERE id = ?";
$stmt = $conn->prepare($empQuery);
$stmt->bind_param("i", $empId);
$stmt->execute();
$empResult = $stmt->get_result();
$empRow = $empResult->fetch_assoc();

//$industryAccessArray contains the array of industry access values
$industryAccessArray = explode(', ', $empRow['industry_access']);

// Convert the array into a comma-separated string
$industryAccessString = "'" . implode("', '", $industryAccessArray) . "'";

$query =
    "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status IN ('Placed', 'Placed with Ongoing Req.', 'Placed with Onboarding')
    AND (mrfs.industry IN ($industryAccessString) OR mrfs.industry IS NULL)
    ";

$result = mysqli_query($conn, $query);

//For showing Assessment
$assessQuery = "SELECT * FROM initial_interview_assessments WHERE job_applicant_id = ?";
$assessStmt = $conn->prepare($assessQuery);

//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../components/header.php');
?>

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

<h4 class=" mt-1 mb-5 ">Placed Applicants</h4>

<div class="row">
    <div class="col-md-6 col-lg-9">
        <div class="float-start ">
            <form action="../components/export_to_excel.php" method="post">
                <button type="submit" class="btn btn-success" name="placedExportBtn" style="border-radius: 0;">
                    <i class="bi bi-file-earmark-arrow-down"></i> Export
                </button>
            </form>
        </div>
    </div>
</div>

<div class="card border-light shadow-sm">
    <div class="card-body">
        <div class="table-responsive">

            <form action="../admin/applicant_process.php" method="post">

                <table id="applicantTable" class="table text-center table-hover table-bordered bg-white border">
                    <thead class="bg-danger ">

                        <tr>
                            <th class="bg-danger text-white text-center">
                                <a href="#" class="link-dark text-decoration-none dropdown-toggle text-white"
                                    id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-list"></i>
                                </a>

                                <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                    <li class="mb-1">

                                        <button type="submit" name="multiPassBtn" class="btn btn-success badge">
                                            <i class="bi bi-check-square"></i> Passed
                                        </button>

                                    </li>
                                    <li class="mb-1">
                                        <button type="submit" name="multiFailBtn" class="btn btn-danger badge">
                                            <i class="bi bi-x-square"></i> Failed
                                        </button>
                                    </li>
                                    <li class="mb-1">
                                        <button type="submit" name="multiPoolBtn" class="btn btn-primary badge">
                                            <i class="bi bi-file-earmark-break"></i> Pooling
                                        </button>
                                    </li>
                                </ul>
                            </th>
                            <th class="bg-danger text-white text-center">Applicant Name</th>
                            <th class="bg-danger text-white text-center">Job Position</th>
                            <th class="bg-danger text-white text-center">Location</th>
                            <th class="bg-danger text-white text-center">Status</th>
                            <th class="bg-danger text-white text-center">Automated Resume</th>
                            <th class="bg-danger text-white text-center">Assessment</th>
                            <th class="bg-danger text-white text-center">Remarks</th>
                            <th class="bg-danger text-white text-center">Logs</th>
                            <th class="bg-danger text-white text-center">Action</th>
                        </tr>
                    </thead>
                    <!-- Makes the table as component so that in can be reuse on Pooling, Shortlisted and Identified Applicants Sidebar -->
                    <?php include ('../components/applicants_table.php'); ?>
                </table>
            </form>
        </div>
    </div>
</div>



<?php include ('../components/footer.php'); ?>