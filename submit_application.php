<?php
include ('submit_application_process.php');

$pageTitle = "Submit Application";
//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ("components/header.php");
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="border-0 shadow bg-white" style="width: 30em; position: relative;">

        <div class="card border-0 bg-transparent">
            <div class="rounded-circle bg-danger mx-2 mt-2  d-flex justify-content-center align-items-center shadow"
                style="width: 50px; height: 50px;">
                <i class="bi bi-exclamation-lg text-light" style="font-size: 24px;"></i>
            </div>


            <div class="card-body">
                <h2 class="card-title">Submit Application</h2>

                <div class="text-justify">
                    <p>
                        By submitting application, you can express interest in working with us by
                        submitting
                        your
                        resume, even if there are no specific job openings. We'll review your information for future
                        opportunities.
                    </p>
                </div>
                <?php
                if ($resumeResult['user_id']) {
                    ?>
                    <div>
                        <span class="badge text-bg-success">
                            Resume is created. You can now submit.</a>
                        </span>
                    </div>
                    <form action="/recruitment/submit_application_process.php" method="post">
                        <div class="mb-1 float-start mt-3">

                            <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light" type="submit"
                                name="submitApplicationBtn">
                                Submit
                            </button>

                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <div>
                        <span class="badge text-bg-warning">
                            Resume is required. Please fill the form <a href="/recruitment/my_resume.php">here</a>
                        </span>
                    </div>
                    <div class="mb-1 float-start mt-3">
                        <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light" disabled>
                            Submit
                        </button>
                    </div>
                    <?php
                }
                ?>


            </div>
        </div>
    </div>
</div>

<?php include ("components/footer.php"); ?>