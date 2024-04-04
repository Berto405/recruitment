<?php
include ('../admin/mrf_list_process.php');

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
                    <table id="jobsTable" class="table table-hover table-bordered bg-white border">
                        <thead class="bg-danger ">
                            <tr>
                                <th class="bg-danger text-white nowrap">Action</th>
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
                                    <td class="text-center">
                                        <a href="#" class="link-danger text-decoration-none dropdown-toggle text-dark"
                                            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-list"></i>
                                        </a>
                                        <form action="../admin/mrf_list_process.php" method="post">
                                            <input type="hidden" name="mrf_id" value="<?php echo $row['id']; ?>">


                                            <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                                <li class="mb-1">

                                                    <button type="submit" name="holdBtn" class="btn btn-success badge">
                                                        <i class="bi bi-check-square"></i> Hold
                                                    </button>

                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="cancelBtn" class="btn btn-primary badge">
                                                        <i class="bi bi-x-square"></i> Cancel
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="closeBtn" class="btn btn-danger badge">
                                                        <i class="bi bi-file-earmark-break"></i> Close
                                                    </button>
                                                </li>
                                            </ul>
                                        </form>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['industry']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php
                                        $status = $row['mrf_status'];

                                        switch ($status) {
                                            case 'Hold':
                                                ?>
                                                <span class=" badge badge border border-success text-success ">
                                                    Hold
                                                </span>
                                                <?php
                                                break;
                                            case 'Cancel':
                                                ?>
                                                <span class=" badge badge border border-primary text-primary ">
                                                    Cancel
                                                </span>
                                                <?php
                                                break;
                                            case 'Close':
                                                ?>
                                                <span class=" badge badge border border-danger text-danger ">
                                                    Close
                                                </span>
                                                <?php
                                                break;
                                            default:
                                                ?>
                                                <span class=" badge badge border border-secondary text-secondary ">
                                                    Unknown Status
                                                </span>
                                                <?php
                                                break;
                                        }

                                        ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php
                                        if ($row['closed_date'] != "0000-00-00") {
                                            //Format date to soimething like Jan. 23, 2024
                                            $formattedClosedDate = date("M. d, Y", strtotime($row['closed_date']));
                                            ?>
                                            <span class="badge text-bg-danger">
                                                <?php echo $formattedClosedDate; ?>
                                            </span>
                                            <?php

                                        } else {
                                            ?>
                                            <span class="badge text-bg-secondary">
                                                <?php echo "Not Closed"; ?>
                                            </span>
                                            <?php

                                        }
                                        ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <span class="badge text-bg-success">
                                            <?php
                                            $formattedClosedDate = date("M. d, Y", strtotime($row['request_date']));
                                            echo $formattedClosedDate;
                                            ?>
                                        </span>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['client']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php
                                        if ($row['aging_days'] == 0) {
                                            echo "Today";
                                        } else {
                                            $agingDays = $row['aging_days'];
                                            $suffix = $agingDays == 1 ? "day" : "days";
                                            echo "$agingDays $suffix";
                                        }
                                        ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['mrf_number']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['new_request']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['head_count']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['job_position']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['contract_type']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['classification']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['placed']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['variance']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php echo $row['cancel']; ?>
                                    </td>
                                    <td class="nowrap text-center">
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