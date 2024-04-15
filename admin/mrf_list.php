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


                <div class="row">
                    <div class="col-md-6 col-lg-9">
                        <div class="float-start mb-2">
                            <form action="../components/export_to_excel.php" method="post">
                                <button type="submit" class="btn btn-success" name="mrfListExportBtn"
                                    style="border-radius: 0;">
                                    <i class="bi bi-file-earmark-arrow-down"></i> Export
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

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


                                        <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                            <li class="mb-1">

                                                <button type="button" class="btn btn-success badge" data-bs-toggle="modal"
                                                    data-bs-target="#postJobModal<?php echo $row['id'] ?>">
                                                    <i class="bi bi-file-earmark-plus"></i> Post Job
                                                </button>

                                            </li>
                                            <form action="../admin/mrf_list_process.php" method="post">
                                                <input type="hidden" name="mrf_id" value="<?php echo $row['id']; ?>">

                                                <li class="mb-1">

                                                    <button type="submit" name="holdBtn" class="btn btn-primary badge">
                                                        <i class="bi bi-stop-circle"></i> Hold
                                                    </button>

                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="cancelBtn" class="btn btn-warning badge">
                                                        <i class="bi bi-dash-square"></i> Cancel
                                                    </button>
                                                </li>
                                                <li class="mb-1">
                                                    <button type="submit" name="closeBtn" class="btn btn-danger badge">
                                                        <i class="bi bi-x-square"></i> Close
                                                    </button>
                                                </li>

                                            </form>
                                        </ul>
                                    </td>


                                    <!-- Post Job Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog"
                                        id="postJobModal<?php echo $row['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog " role="document" style="max-width: 60vw;">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header p-5 pb-4 border-bottom-0">
                                                    <h1 class="fw-bold mb-0 fs-2">Post Job</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body p-5 pt-0">
                                                    <form action="../admin/mrf_list_process.php" method="post">
                                                        <input type="hidden" name="mrf_id"
                                                            value="<?php echo $row['id']; ?>">

                                                        <hr style="border-width: 3px;">
                                                        <h4 class="fw-bold text-center">MANPOWER REQUEST FORM H.O</h4>
                                                        <hr style="border-width: 3px;">

                                                        <div class="row mt-3">

                                                            <div class="col-sm-12 col-md-3 ">
                                                                <div class="form-floating">
                                                                    <select class="form-select fw-bold mb-sm-3"
                                                                        name="industry" id="industry" required>
                                                                        <option disabled>Choose...</option>
                                                                        <option value="Retail" <?php if ($row['industry'] == 'Retail')
                                                                            echo 'selected'; ?>>
                                                                            Retail
                                                                        </option>
                                                                        <option value="Logistics" <?php if ($row['industry'] == 'Logistics')
                                                                            echo 'selected'; ?>>
                                                                            Logistics
                                                                        </option>
                                                                        <option value="Maintenance" <?php if ($row['industry'] == 'Maintenance')
                                                                            echo 'selected'; ?>>
                                                                            Gen. Maintenance & Services
                                                                        </option>
                                                                        <option value="Food Services" <?php if ($row['industry'] == 'Food Services')
                                                                            echo 'selected'; ?>>
                                                                            Food Services
                                                                        </option>
                                                                    </select>
                                                                    <label for="industry"
                                                                        class="form-label fw-bold">Industry</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3 ">
                                                                <div class="form-floating">
                                                                    <select class="form-select fw-bold mb-sm-3"
                                                                        name="location" id="location" required>
                                                                        <option disabled>Choose...</option>
                                                                        <option value="Makati" <?php if ($row['location'] == 'Makati')
                                                                            echo 'selected'; ?>>
                                                                            Makati
                                                                        </option>
                                                                        <option value="Logistics" <?php if ($row['location'] == 'Logistics')
                                                                            echo 'selected'; ?>>
                                                                            Logistics
                                                                        </option>
                                                                        <option value="Maintenance" <?php if ($row['location'] == 'Maintenance')
                                                                            echo 'selected'; ?>>
                                                                            Gen. Maintenance & Services
                                                                        </option>
                                                                        <option value="Food Services" <?php if ($row['location'] == 'Food Services')
                                                                            echo 'selected'; ?>>
                                                                            Food Services
                                                                        </option>
                                                                    </select>
                                                                    <label for="location"
                                                                        class="form-label fw-bold">Location of
                                                                        Deployment</label>

                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3 ">
                                                                <div class="form-floating">
                                                                    <select class="form-select fw-bold mb-sm-3"
                                                                        name="newRequest" id="newRequest" required>
                                                                        <option selected disabled>Choose...</option>
                                                                        <option value="Additional" <?php if ($row['new_request'] == 'Additional')
                                                                            echo 'selected'; ?>>
                                                                            Additional
                                                                        </option>
                                                                        <option value="Replacement" <?php if ($row['new_request'] == 'Replacement')
                                                                            echo 'selected'; ?>>
                                                                            Replacement
                                                                        </option>
                                                                    </select>
                                                                    <label for="newRequest" class="form-label fw-bold">
                                                                        New Request
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3 ">
                                                                <div class="form-floating mb-sm-3">
                                                                    <select class="form-select fw-bold "
                                                                        name="classification" id="classification" required>
                                                                        <option selected disabled>Choose...</option>
                                                                        <option value="Non-skilled" <?php if ($row['classification'] == 'Non-skilled')
                                                                            echo 'selected'; ?>>
                                                                            Non-skilled
                                                                        </option>
                                                                        <option value="Skilled" <?php if ($row['classification'] == 'Skilled')
                                                                            echo 'selected'; ?>>
                                                                            Skilled
                                                                        </option>
                                                                        <option value="Professional" <?php if ($row['classification'] == 'Professional')
                                                                            echo 'selected'; ?>>
                                                                            Professional
                                                                        </option>
                                                                    </select>
                                                                    <label for="classification" class="form-label fw-bold">
                                                                        Classification Type
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <hr style="border-width: 2px;">

                                                        <div class="row mt-3">

                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text"
                                                                        class="form-control rounded-3 fw-bold"
                                                                        placeholder="12" name="client"
                                                                        value="<?php echo $row['client']; ?>" required>
                                                                    <label for="floatingInput"
                                                                        class="fw-bold">Account/Client</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text"
                                                                        class="form-control rounded-3 fw-bold"
                                                                        placeholder="12" name="jobPosition"
                                                                        value="<?php echo $row['job_position']; ?>"
                                                                        required>
                                                                    <label for="floatingInput" class="fw-bold">
                                                                        Job Position
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number"
                                                                        class="form-control rounded-3 fw-bold"
                                                                        placeholder="12" name="numberRequired"
                                                                        value="<?php echo $row['head_count']; ?>" required>
                                                                    <label for="floatingInput" class="fw-bold">Number
                                                                        Required</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3">
                                                                <div class="form-floating mb-sm-3">
                                                                    <select class="form-select fw-bold " name="contractType"
                                                                        id="contractType" required>
                                                                        <option selected disabled>Choose...</option>
                                                                        <option value="Probationary" <?php if ($row['contract_type'] == 'Probationary')
                                                                            echo 'selected'; ?>>
                                                                            Probationary
                                                                        </option>
                                                                        <option value="Project-based" <?php if ($row['contract_type'] == 'Project-based')
                                                                            echo 'selected'; ?>>
                                                                            Project-based
                                                                        </option>
                                                                        <option value="Fixed Term" <?php if ($row['contract_type'] == 'Fixed Term')
                                                                            echo 'selected'; ?>>
                                                                            Fixed Term
                                                                        </option>
                                                                        <option value="Regular On-call" <?php if ($row['contract_type'] == 'Regular On-call')
                                                                            echo 'selected'; ?>>
                                                                            Regular On-call
                                                                        </option>
                                                                    </select>
                                                                    <label for="contractType"
                                                                        class="form-label fw-bold">Contract Type</label>
                                                                </div>
                                                            </div>



                                                        </div>

                                                        <hr style="border-width: 2px;">

                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <label for="jobDescription" class="form-label fw-bold">Job
                                                                    Description</label>
                                                                <textarea class="form-control summernote"
                                                                    id="jobDescription" name="jobDescription" required>
                                                                                        <?php echo $row['job_description']; ?>
                                                                                    </textarea>

                                                            </div>
                                                        </div>

                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-12">
                                                                <label for="benefits"
                                                                    class="form-label fw-bold">Qualifications</label>
                                                                <textarea class="form-control summernote" id="qualification"
                                                                    name="qualification" required>
                                                                                        <?php echo $row['qualification']; ?>
                                                                                    </textarea>
                                                            </div>
                                                        </div>

                                                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger"
                                                            name="postBtn" type="submit">
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <td class="nowrap text-center">
                                        <?php echo $row['industry']; ?>
                                    </td>
                                    <td class="nowrap text-center">
                                        <?php
                                        $status = $row['mrf_status'];

                                        switch ($status) {
                                            case 'Post':
                                                ?>
                                                <span class=" badge badge border border-success text-success ">
                                                    Posted
                                                </span>
                                                <?php
                                                break;
                                            case 'Hold':
                                                ?>
                                                <span class=" badge badge border border-primary text-primary ">
                                                    Hold
                                                </span>
                                                <?php
                                                break;
                                            case 'Cancel':
                                                ?>
                                                <span class=" badge badge border border-primary text-primary ">
                                                    Cancelled
                                                </span>
                                                <?php
                                                break;
                                            case 'Close':
                                                ?>
                                                <span class=" badge badge border border-danger text-danger ">
                                                    Closed
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