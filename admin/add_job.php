<?php
include ('../admin/add_job_process.php');

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] == 'user') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}

//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../components/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>

</head>

<body style="background-color: #F4F4F4; ">
    <div class="container-fluid">
        <div class="row">
            <?php
            $columnClasses = "col-md-10 col-lg-9 col-xl-10";
            if ($_SESSION['user_role'] === 'Operations') {
                $columnClasses = "col-12";
            }
            if ($_SESSION['user_role'] !== 'Operations') {
                ?>
                <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow" style="min-height: 91vh;">
                    <?php include ("../admin/admin_sidebar.php"); ?>
                </div>
                <?php
            }
            ?>


            <div class="<?php echo $columnClasses; ?>  mt-3 ">
                <h4 class=" mt-1 mb-5 ">Add Job</h4>

                <div class="container-fluid bg-white rounded">
                    <form action="../admin/add_job_process.php" method="post">
                        <div class="row   d-flex align-items-center justify-content-center m-0"
                            style="padding-top:3em; padding-bottom:1.9em">

                            <div class="col-12 col-lg-5 col-xl-4 align-items-center ">
                                <div class="card border-0  bg-transparent  ">
                                    <div class="card-body m-0 p-0">

                                        <div class="col w-100">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="floatingInput"
                                                    placeholder="Ex. Tech Support" name="jobName" required>
                                                <label for="floatingInput" class="form-label">Position</label>
                                            </div>
                                        </div>

                                        <div class="col w-100">
                                            <div class="form-floating mb-2">
                                                <input type="number" class="form-control" id="numRequired"
                                                    placeholder="Ex. 15000" name="numRequired" required>
                                                <label for="numRequired" class="form-label">Number Required</label>
                                            </div>
                                        </div>


                                        <div class="col w-100">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="shift"
                                                    placeholder="Ex. 8 hours shift" name="shift" required>

                                                <label for="shift" class="form-label">Shift & Schedule</label>
                                            </div>
                                        </div>
                                        <div class="col w-100">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="location"
                                                    placeholder="Ex. Makati City" name="location" required>

                                                <label for="location" class="form-label">Location of Deployment</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-lg-5 col-xl-4 align-items-center mb-4 rounded-1  ">
                                <div class="col-12 p-0 mb-2">
                                    <div class="form-floating">
                                        <select class="form-select" name="priority" id="priority" required>
                                            <option value="Non-urgent Hiring">Non-urgent Hiring</option>
                                            <option value="Urgent Hiring">Urgent Hiring</option>
                                        </select>
                                        <label for="priority" class="form-label fw-bold">Priority</label>
                                    </div>
                                </div>

                                <div class="col-12 p-0 mb-2">
                                    <div class="form-floating">
                                        <select class="form-select" name="jobType" id="jobType" required>
                                            <option selected disabled>Choose...</option>
                                            <option value="Probationary">Probationary</option>
                                            <option value="Project-based">Project-based</option>
                                            <option value="Fixed Term">Fixed Term</option>
                                            <option value="Probationary On-call">Probationary On-call</option>
                                            <option value="Regular On-call">Regular On-call</option>
                                        </select>
                                        <label for="jobType" class="form-label fw-bold">Job Type</label>
                                    </div>
                                </div>

                                <div class="col-md-12 p-0 mb-2 ">
                                    <div class="form-floating">
                                        <select class="form-select" name="industry" id="industry" required>
                                            <option selected disabled>Choose...</option>
                                            <option value="Retail">Retail</option>
                                            <option value="Logistics">Logistics</option>
                                            <option value="Maintenance">Maintenance</option>
                                            <option value="Services">Services</option>
                                        </select>
                                        <label for="industry" class="form-label fw-bold">Industry</label>
                                    </div>
                                </div>

                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 mb-2">
                                    <label for="jobDescription" class="form-label fw-bold">Job Description</label>
                                    <textarea class="form-control summernote" id="jobDescription" name="jobDescription"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6 mb-2">
                                    <label for="benefits" class="form-label fw-bold">Qualifications</label>
                                    <textarea class="form-control summernote" id="qualification" name="qualification"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="row  d-flex justify-content-center mt-3">

                                <div class="col-12 col-md-4 col-xl-4 order-xl -2 order-1">
                                    <button class="btn btn-danger w-100 mb-2 form-control" type="submit">
                                        Post Job
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


</html>

<?php include ('../components/footer.php'); ?>