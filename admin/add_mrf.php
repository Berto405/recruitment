<?php
include ('../admin/add_mrf_process.php');

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
    <title>Add MRF</title>

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


            <div class="<?php echo $columnClasses; ?>   ">

                <div class="container mt-5 bg-white">
                    <form action="../admin/add_mrf_process.php" method="post">

                        <hr style="border-width: 3px;">
                        <h4 class="fw-bold text-center">MANPOWER REQUEST FORM H.O</h4>
                        <hr style="border-width: 3px;">

                        <div class="row mt-3">

                            <div class="col-sm-12 col-md-3 ">
                                <div class="form-floating">
                                    <select class="form-select fw-bold mb-sm-3" name="industry" id="industry" required>
                                        <option selected disabled>Choose...</option>
                                        <option value="Retail">Retail</option>
                                        <option value="Logistics">Logistics</option>
                                        <option value="Maintenance">Maintenance & Services</option>
                                        <option value="Food Services">Food Services</option>
                                    </select>
                                    <label for="industry" class="form-label fw-bold">Industry</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 ">
                                <div class="form-floating">
                                    <select class="form-select fw-bold mb-sm-3" name="location" id="location" required>
                                        <option selected disabled>Choose...</option>
                                        <option value="Makati">Makati</option>
                                        <option value="Logistics">Logistics</option>
                                        <option value="Maintenance">Gen. Maintenance & Services</option>
                                        <option value="Food Services">Food Services</option>
                                    </select>
                                    <label for="location" class="form-label fw-bold">Location of Deployment</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 ">
                                <div class="form-floating">
                                    <select class="form-select fw-bold mb-sm-3" name="newRequest" id="newRequest"
                                        required>
                                        <option selected disabled>Choose...</option>
                                        <option value="Additional">Additional</option>
                                        <option value="Replacement">Replacement</option>
                                    </select>
                                    <label for="newRequest" class="form-label fw-bold">New Request</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 ">
                                <div class="form-floating mb-sm-3">
                                    <select class="form-select fw-bold " name="classification" id="classification"
                                        required>
                                        <option selected disabled>Choose...</option>
                                        <option value="Non-skilled">Non-skilled</option>
                                        <option value="Skilled">Skilled</option>
                                        <option value="Professional">Professional</option>
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
                                    <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                        name="client" required>
                                    <label for="floatingInput" class="fw-bold">Account/Client</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                        name="jobPosition" required>
                                    <label for="floatingInput" class="fw-bold">Job Position</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                                        name="numberRequired" required>
                                    <label for="floatingInput" class="fw-bold">Number Required</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <div class="form-floating mb-sm-3">
                                    <select class="form-select fw-bold " name="contractType" id="contractType" required>
                                        <option selected disabled>Choose...</option>
                                        <option value="Probationary">Probationary</option>
                                        <option value="Project-based">Project-based</option>
                                        <option value="Fixed Term">Fixed Term</option>
                                        <option value="Regular On-call">Regular On-call</option>
                                    </select>
                                    <label for="contractType" class="form-label fw-bold">Contract Type</label>
                                </div>
                            </div>



                        </div>

                        <hr style="border-width: 2px;">

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="jobDescription" class="form-label fw-bold">Job Description</label>
                                <textarea class="form-control summernote" id="jobDescription" name="jobDescription"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="benefits" class="form-label fw-bold">Qualifications</label>
                                <textarea class="form-control summernote" id="qualification" name="qualification"
                                    required></textarea>
                            </div>
                        </div>

                        <div class="row  d-flex justify-content-center mt-3">

                            <div class="col-12 col-md-4 col-xl-4 order-xl -2 order-1">
                                <button class="btn btn-danger w-100 mb-2 form-control" type="submit">
                                    Submit
                                </button>
                            </div>

                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>


    <?php include ('../components/footer.php'); ?>
</body>

</html>