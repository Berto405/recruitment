<?php
include('../header.php');
include('../dbconn.php');

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}

//Fetching job applicants
$query =
    "SELECT job_applicants.*, jobs.job_name, jobs.job_type, jobs.shift_and_schedule, jobs.location, user.name, user.resume
    FROM ((job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants</title>
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
    } else if (isset($_GET['error'])) {
        $error = $_GET['error'];
        ?>
            <script>
                swal({
                    title: "Oops!",
                    icon: "error",
                    text: "<?php echo $error; ?>"

                });
            </script>

        <?php
    }
    ?>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow">
                <?php include("../admin/admin_sidebar.php"); ?>
            </div>

            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Applicants</h4>

                <div class="container-fluid table-responsive-sm">
                    <table class="table text-center table-hover table-bordered">
                        <thead class="table-danger">
                            <tr>
                                <th>Name</th>
                                <th>Job Name</th>
                                <th>Job Type</th>
                                <th>Shift</th>
                                <th>Location</th>
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
                                        <?php echo $row['name']; ?>
                                    </th>
                                    <td>
                                        <?php echo $row['job_name']; ?>
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
                                        <a href="/recruitment/resume/<?php echo $row['resume']; ?>" target="_blank"
                                            class="text-decoration-none btn btn-success badge">
                                            View Resume
                                        </a>
                                    </td>
                                    <td>
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
                                                    <button type="button" class="btn btn-primary badge">
                                                        Hire
                                                    </button>
                                            <?php
                                        } else {

                                        }
                                        ?>

                                        <button type="button" class="btn btn-danger badge">Reject</button>
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
</body>

</html>

<?php include('../footer.php'); ?>