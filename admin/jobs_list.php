<?php
include ('../admin/jobs_list_process.php');

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] == 'user' || $_SESSION['user_role'] == 'Operations') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}
//Display all jobs
$query = "SELECT * FROM jobs ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();


//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../components/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs/MRF List</title>
    <!-- DataTable JS - CDN Link -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

</head>

<body style="background-color: #F4F4F4; ">

    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow" style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Jobs/MRF List</h4>


                <div class="table-responsive">
                    <table id="jobsTable" class="table text-center table-hover table-bordered bg-white border">
                        <thead class="bg-danger">
                            <tr>
                                <th class="bg-danger text-white">Industry</th>
                                <th class="bg-danger text-white">MRF Status</th>
                                <th class="bg-danger text-white">Closed/Cancel Date</th>
                                <th class="bg-danger text-white">Request Date</th>
                                <th class="bg-danger text-white">Account/Client</th>
                                <th class="bg-danger text-white">Aging Days</th>
                                <th class="bg-danger text-white">MRF Number</th>
                                <th class="bg-danger text-white">New Request</th>
                                <th class="bg-danger text-white">HC</th>
                                <th class="bg-danger text-white">Position</th>
                                <th class="bg-danger text-white">Contract Type</th>
                                <th class="bg-danger text-white">Classification</th>
                                <th class="bg-danger text-white">Placed</th>
                                <th class="bg-danger text-white">Variance</th>
                                <th class="bg-danger text-white">Cancel</th>
                                <th class="bg-danger text-white">Hold</th>
                                <th class="bg-danger text-white">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Retail</td>
                                <td>Hold</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0032</td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td>Skilled</td>
                                <td>1</td>
                                <td>1</td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Logistics</td>
                                <td>Closed</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>0025</td>
                                <td></td>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td>Skilled</td>
                                <td>7</td>
                                <td>1</td>
                                <td></td>
                                <td>1</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>


    <script>
        $('#jobsTable').DataTable({
            scrollX: true,
            language: {
                "search": "_INPUT_",
                "searchPlaceholder": "Search"
            }
        });

    </script>

</body>

</html>

<?php include ('../components/footer.php'); ?>