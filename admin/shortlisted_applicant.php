<?php
session_start();
include ('../dbconn.php');

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

$emp_id = $_SESSION['user_id'];
$query =
    "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status IN ('Passed', 'For Initial Interview', 'For Final Interview', 'Waiting for Feedback') AND job_applicants.employee_id = $emp_id
    ";

$result = mysqli_query($conn, $query);

//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../components/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortlisted Applicants</title>
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
                <h4 class=" mt-1 mb-5 ">Shortlisted Applicants</h4>


                <div class="row">
                    <div class="col-md-6 col-lg-9">
                        <div class="float-start mb-2">
                            <form action="../components/export_to_excel.php" method="post">
                                <button type="submit" class="btn btn-success" name="shortlistedExportBtn"
                                    style="border-radius: 0;">
                                    <i class="bi bi-file-earmark-arrow-down"></i> Export
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Makes the table as component so that in can be reuse on Pooling, Shortlisted and Identified Applicants Sidebar -->
                <div class="table-responsive">
                    <form action="../admin/applicant_process.php" method="post">

                        <table id="applicantTable" class="table text-center table-hover table-bordered bg-white border">
                            <thead class="bg-danger ">
                                <tr>
                                    <th class="bg-danger text-white text-center">
                                        <div class="dropdown">
                                            <a href="#"
                                                class="link-dark text-decoration-none dropdown-toggle text-white"
                                                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-list"></i>
                                            </a>

                                            <ul class="dropdown-menu text-center shadow"
                                                aria-labelledby="dropdownUser2">
                                                <li class="mb-1">
                                                    <button type="submit" name="multi_initial_interviewBtn"
                                                        class="dropdown-item text-info mb-1">
                                                        <i class="bi bi-calendar-check-fill me-1"></i> For Initial
                                                        Interview
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="multi_final_interviewBtn"
                                                        class="dropdown-item text-dark mb-1">
                                                        <i class="bi bi-calendar-check me-1"></i> For Final Interview
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="multiFeedbackBtn"
                                                        class="dropdown-item text-primary mb-1">
                                                        <i class="bi bi-clock me-1"></i> Waiting for Feedback
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="multiHiredBtn"
                                                        class="dropdown-item text-success mb-1">
                                                        <i class="bi bi-check-square me-1"></i> Hired
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="button" id="backBtn"
                                                        class="dropdown-item text-warning mb-1" data-bs-toggle="modal"
                                                        data-bs-target="#remarkModal">
                                                        <i class="bi bi-exclamation-diamond-fill me-1"></i> Back to
                                                        Pooling
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="button" id="failedBtn"
                                                        class="dropdown-item text-danger mb-1" data-bs-toggle="modal"
                                                        data-bs-target="#remarkModal">
                                                        <i class="bi bi-x-square"></i> Failed
                                                    </button>
                                                </li>


                                            </ul>
                                        </div>
                                    </th>

                                    <th class="bg-danger text-white text-center">Applicant Name</th>
                                    <th class="bg-danger text-white text-center">Job Position</th>
                                    <th class="bg-danger text-white text-center">Location</th>
                                    <th class="bg-danger text-white text-center">Status</th>
                                    <th class="bg-danger text-white text-center">Automated Resume</th>
                                    <th class="bg-danger text-white text-center">Remarks</th>
                                    <th class="bg-danger text-white text-center">Logs</th>
                                    <th class="bg-danger text-white text-center">Action</th>

                                </tr>
                            </thead>
                            <!-- Makes the table as component so that in can be reuse on Pooling, Shortlisted and Identified Applicants Sidebar -->
                            <?php include ('../components/applicants_table.php'); ?>
                        </table>
                        <!-- Remark Modal -->
                        <div class="modal fade" tabindex="-1" role="dialog" id="remarkModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header p-5 pb-4 border-bottom-0">
                                        <h4 class="modal-title fw-bold" id="exampleModalLabel">
                                            Remark
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-5 pt-0">

                                        <div class="mb-3">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="text" id="remark" class="form-control"
                                                            placeholder="rekamr" name="remark">
                                                        <label class=" form-label fw-bold">Remark</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" id="action"
                                            type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // JavaScript to update the action of the form based on the button clicked and put required on input in modal 
                            document.getElementById('backBtn').addEventListener('click', function () {
                                document.getElementById('action').setAttribute('name', 'multiBackToPoolingBtn');
                                document.getElementById('remark').setAttribute('required', 'required');
                            });

                            document.getElementById('failedBtn').addEventListener('click', function () {
                                document.getElementById('action').setAttribute('name', 'multiFailBtn');
                                document.getElementById('remark').setAttribute('required', 'required');
                            });
                        </script>

                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>

<?php include ('../components/footer.php'); ?>