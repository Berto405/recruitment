<?php
include ('../admin/applicants_process.php');

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

//Fetching job applicants
$query =
    "SELECT job_applicants.*, jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, jobs.priority, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status != 'Not Selected' AND job_applicants.application_status != 'Selected'
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
    <title>Applicants</title>
</head>

<body style="background-color: #F4F4F4; ">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow" style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>

            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Applicants</h4>

                <div class="container-fluid table-responsive">
                    <span class="float-end">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i> = Urgent
                        Hiring
                    </span>
                    <table id="applTable" class="table text-center table-hover table-bordered">
                        <thead class="table-danger">
                            <tr>
                                <th>Name</th>
                                <th>Job Name</th>
                                <th>Job Type</th>
                                <th>Shift</th>
                                <th>Location</th>
                                <th>Application Status</th>
                                <th>Resume</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr>
                                    <th>
                                        <?php echo $row['first_name'] . ' ' . $row['first_name']; ?>
                                    </th>
                                    <td>
                                        <?php
                                        if ($row['priority'] == 'Urgent Hiring') {
                                            ?>
                                            <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                            <?php
                                            echo $row['job_name'];
                                        } else {
                                            echo $row['job_name'];
                                        }
                                        ?>

                                    </td>
                                    <td>
                                        <?php echo $row['job_type']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['shift_and_schedule']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['location']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['application_status'] == 'Pending') {
                                            ?>
                                            <span class="badge border border-secondary text-secondary">
                                                Pending
                                            </span>

                                            <?php
                                        } elseif ($row['application_status'] == 'Reviewed') {
                                            ?>
                                            <span class="badge border border-primary text-primary">
                                                Reviewed
                                            </span>
                                            <?php
                                        } elseif ($row['application_status'] == 'Interview') {
                                            ?>
                                            <span class="badge border border-danger text-danger"">
                                                To be Interview
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href=" /recruitment/resume/<?php echo $row['resume']; ?>" target="_blank"
                                            class="text-decoration-none btn btn-success badge view-resume"
                                            data-application-id="<?php echo $row['id']; ?>">
                                            View Resume
                                            </a>
                                    </td>
                                    <td>
                                        <a href="#" class="d-block text-dark text-decoration-none dropdown-toggle"
                                            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-list"></i>
                                        </a>

                                        <div class="row dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <?php
                                                if ($row['application_status'] == 'Pending') {

                                                } else if ($row['application_status'] == 'Reviewed') {
                                                    ?>
                                                        <button type="button" class="btn btn-primary badge" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal<?php echo $row['id'] ?>">
                                                            Setup Interview
                                                        </button>
                                                    <?php
                                                } else if ($row['application_status'] == 'Interview') {
                                                    ?>
                                                            <form action="../admin/applicants_process.php" method="post">
                                                                <input type="hidden" name="hire_applicant"
                                                                    value="<?php echo $row['id']; ?>">
                                                                <input type="hidden" name="applicant_user_id"
                                                                    value="<?php echo $row['user_id']; ?>">
                                                                <button type="submit" class="btn btn-primary badge">Hire</button>
                                                            </form>

                                                    <?php
                                                } else {

                                                }
                                                ?>
                                                <form action="../admin/applicants_process.php" method="post">
                                                    <input type="hidden" class="form-control" name="reject_applicant"
                                                        value="<?php echo $row['id'] ?>">
                                                    <input type="hidden" name="applicant_user_id"
                                                        value="<?php echo $row['user_id']; ?>">
                                                    <button type="submit" class="btn btn-danger badge">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="exampleModal<?php echo $row['id'] ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="exampleModalLabel">
                                                    Schedule Interview
                                                </h5>
                                            </div>
                                            <form action="../admin/applicants_process.php" method="post">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <input type="hidden" class="form-control"
                                                                    name="applicant_id" value="<?php echo $row['id'] ?>">
                                                                <input type="datetime-local" class="form-control"
                                                                    name="interview_date" id="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
    <!-- DataTable JS - CDN Link -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script>
        $('#applTable').DataTable({
            language: {
                "search": "_INPUT_",
                "searchPlaceholder": "Search"
            }
        });

        $(document).ready(function () {
            $(".view-resume").click(function (e) {
                e.preventDefault();
                var applicationId = $(this).data("application-id");

                // Send AJAX request to update the application status
                $.ajax({
                    type: "POST",
                    url: "applicants_process.php",
                    data: { application_id: applicationId },
                    success: function (response) {
                        // Handle the response if needed
                        console.log(response);

                        // Open the resume link in a new tab
                        var resumeUrl = $(e.target).attr('href');
                        window.open(resumeUrl, '_blank');

                        // Reload the current page
                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors here
                        console.error(error);
                    }
                });
            });
        });


    </script>
</body>

</html>

<?php include ('../components/footer.php'); ?>