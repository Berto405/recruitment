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

$query =
    "SELECT job_applicants.*, jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, jobs.priority, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status IN ('Hired', 'Ongoing Requirements', 'Onboarding', 'Waiting for Start Date', 'Placed with Ongoing Req.', 'Placed with Onboarding')
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
    <title>Identified Applicants</title>
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
                <h4 class=" mt-1 mb-5 ">Identified Applicants</h4>


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
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser2">
                                                <li>
                                                    <button type="submit" name="multiOngoingBtn"
                                                        class="dropdown-item bg-warning text-dark mb-1">
                                                        <i class="bi bi-arrow-clockwise me-1"></i>Ongoing Requirements
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="multiOnbaordingBtn"
                                                        class="dropdown-item bg-info text-dark mb-1">
                                                        <i class="bi bi-hand-thumbs-up me-1"></i> Onboarding
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="multiStartDateBtn"
                                                        class="dropdown-item bg-primary text-light mb-1">
                                                        <i class="bi bi-clock me-1"></i> Waiting for Start Date
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="multiPlacedBtn"
                                                        class="dropdown-item bg-success text-light mb-1">
                                                        <i class="bi bi-check-square me-1"></i> Placed
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="multiPlacedWithOngoingBtn"
                                                        class="dropdown-item bg-success text-light mb-1">
                                                        <i class="bi bi-arrow-clockwise me-1"></i> Placed with Ongoing
                                                        Req
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="multiPlacedWithOnboardingBtn"
                                                        class="dropdown-item  bg-success text-light mb-1">
                                                        <i class="bi bi-hand-thumbs-up me-1"></i> Placed with Onboarding
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" id="failedBtn"
                                                        class="dropdown-item bg-danger text-light mb-1"
                                                        data-bs-toggle="modal" data-bs-target="#remarkModal">
                                                        <i class="bi bi-x-square"></i> Failed
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="multiBackoutBtn"
                                                        class="dropdown-item  bg-danger text-light  mb-1">
                                                        <i class="bi bi-back me-1"></i> Backout
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
                                                    <input type="hidden" class="form-control" name="applicant_id"
                                                        value="<?php echo $row['id'] ?>">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" placeholder="rekamr"
                                                            id="remark" name="remark">
                                                        <label class=" form-label fw-bold">Remark</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="multiFailBtn"
                                            type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // JavaScript to the put required on input in modal 
                            document.getElementById('failedBtn').addEventListener('click', function () {
                                document.getElementById('remark').setAttribute('required', 'required');
                            });

                            // Add event listeners to other buttons to remove the "required" attribute
                            var otherButtons = document.querySelectorAll('.dropdown-item:not(#failedBtn)');
                            otherButtons.forEach(function (button) {
                                button.addEventListener('click', function () {
                                    document.getElementById('remark').removeAttribute('required');
                                });
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