<?php
include ('src/user/backend/my_jobs_process.php');


$pageTitle = "My Jobs";
include ("components/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="container">
        <div class="container-fluid bg-white shadow mb-5 mt-5 ">
            <h4 class=" mt-1 mb-1 fw-bold">My Jobs</h4>
        </div>


        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row">
                <div class="col-sm-12 col-md-12 ">
                    <div class="container-fluid bg-white shadow mb-3 mt-4 border-2 border-top border-danger">
                        <div class="row p-2">
                            <h4 class="fw-bold">
                                <a href="" data-bs-toggle="modal"
                                    data-bs-target="#viewJobDetails<?php echo $row['mrf_id']; ?>"
                                    class="text-decoration-none text-dark"><?php echo $row['job_position'] ?></a>
                            </h4>

                            <!-- Job Details Modal -->
                            <div class="modal fade" tabindex="-1" role="dialog"
                                id="viewJobDetails<?php echo $row['mrf_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-header p-5 pb-4 border-bottom-0">
                                            <h1 class=" mb-0 fs-2">Job Details</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-5 pt-0">
                                            <div class="row">
                                                <div class="col">
                                                    <h1>
                                                        <?php echo $row['job_position']; ?>
                                                    </h1>


                                                    <!-- Contract Type -->
                                                    <i class="bi bi-briefcase-fill"></i>
                                                    <span
                                                        class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                                        <?php echo $row['contract_type']; ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <h4 class="mt-4">Location</h4>

                                            <div class="row">
                                                <div class="col">
                                                    <!-- Location -->
                                                    <i class="bi bi-geo-alt-fill"></i><span>
                                                        <?php echo $row['location']; ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <h4 class="mt-4">Job Description</h4>

                                            <p>
                                                <?php echo $row['job_description']; ?>
                                            </p>
                                            <h4>Qualifications</h4>
                                            <p>
                                                <?php echo $row['qualification']; ?>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Location -->
                                    <i class="bi bi-geo-alt-fill"></i><span>
                                        <?php echo $row['location']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Contract Type -->
                                    <i class="bi bi-briefcase-fill"></i>
                                    <span
                                        class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill mt-3">
                                        <?php echo $row['contract_type']; ?>
                                    </span>

                                </div>
                            </div>

                            <div class="row mt-3">
                                <?php
                                if ($row['application_status'] == 'Pending') {
                                    ?>
                                    <div class="col d-flex justify-content-start">
                                        <form id="cancelAppForm<?php echo $row['applicant_id']; ?>" action="" method="post">

                                            <input type="hidden" name="applicantId" value="<?php echo $row['applicant_id']; ?>">
                                            <button type="button" class=" btn btn-danger " name="cancelApplicationBtn"
                                                onclick="confirmCancel(<?php echo $row['applicant_id']; ?>)">
                                                Cancel Application
                                            </button>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="col d-flex justify-content-end">
                                    <div
                                        class="fw-bold rounded-1 <?php echo getStatusClass($row['application_status']); ?>">
                                        <?php echo $row['application_status']; ?>
                                    </div>
                                </div>
                            </div>

                            <div>

                            </div>


                        </div>


                    </div>
                </div>
            </div>
            <?php
        }

        ?>

    </div>

    <script>

        function confirmCancel(applicant_id) {
            swal({
                title: "Are you sure?",
                icon: "warning",
                content: {
                    element: "p",
                    attributes: {
                        innerHTML: "Once you cancel your application, the employee won't be able to process you.",
                        style: "text-align: center;"
                    }
                },
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //If user clicked "Ok" button.
                        document.getElementById("cancelAppForm" + applicant_id).submit();
                    } else {
                        //If user clicked "Cancel" button.
                        return false;
                    }
                });
        }


    </script>
</body>

</html>
<?php include ('components/footer.php'); ?>