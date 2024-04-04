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
$query = "SELECT * FROM mrfs";
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

    <style>
        .nowrap {
            white-space: nowrap;
        }
    </style>
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
                                <th class="bg-danger text-white nowrap">Industry</th>
                                <th class="bg-danger text-white nowrap">MRF Status</th>
                                <th class="bg-danger text-white nowrap">Closed/Cancel Date</th>
                                <th class="bg-danger text-white nowrap">Request Date</th>
                                <th class="bg-danger text-white nowrap">Account/Client</th>
                                <th class="bg-danger text-white nowrap">Aging Days</th>
                                <th class="bg-danger text-white nowrap">MRF Number</th>
                                <th class="bg-danger text-white nowrap">New Request</th>
                                <th class="bg-danger text-white nowrap">HC</th>
                                <th class="bg-danger text-white nowrap">Position</th>
                                <th class="bg-danger text-white nowrap">Contract Type</th>
                                <th class="bg-danger text-white nowrap">Classification</th>
                                <th class="bg-danger text-white nowrap">Placed</th>
                                <th class="bg-danger text-white nowrap">Variance</th>
                                <th class="bg-danger text-white nowrap">Cancel</th>
                                <th class="bg-danger text-white nowrap">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td class="nowrap">
                                        <?php echo $row['industry']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['mrf_status']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['closed_date']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['request_date']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['client']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['aging_days']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['mrf_number']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['new_request']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['head_count']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['job_position']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['contract_type']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['classification']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['placed']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['variance']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['cancel']; ?>
                                    </td>
                                    <td class="nowrap">
                                        <?php echo $row['remarks']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>


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