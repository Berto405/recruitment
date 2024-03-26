<?php
include ('../admin/admin_header.php');
include ('../dbconn.php');

// Check if user is not logged in
if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role'])) {
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
$query =
    "SELECT *
    FROM ((job_applicants
    INNER JOIN jobs ON job_applicants.job_id = jobs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status = 'Pending' OR  job_applicants.application_status = 'Pooling'
    ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";

$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pooling Applicants</title>
    <style>
        #imagePreview {
            width: 1in;
            height: 1in;
            border: 1px solid #ccc;
            margin-top: 10px;
        }

        #imagePreview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow " style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Pooling Applicants</h4>


                <div class="table-responsive">
                    <table class="table text-center table-hover bg-white border">
                        <thead class="bg-danger">
                            <tr>
                                <th class="bg-danger text-white">Applicant Name</th>
                                <th class="bg-danger text-white">Job Position</th>
                                <th class="bg-danger text-white">Location</th>
                                <th class="bg-danger text-white">Status</th>
                                <th class="bg-danger text-white">Automated Resume</th>
                                <th class="bg-danger text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                //For showing the users resume
                                $resumeQuery = "SELECT *
                                    FROM user_resumes
                                    LEFT JOIN educational_attainment ON user_resumes.user_id = educational_attainment.user_id
                                    LEFT JOIN employment_background ON user_resumes.user_id = employment_background.user_id
                                    LEFT JOIN lectures_and_seminars_attended ON user_resumes.user_id = lectures_and_seminars_attended.user_id
                                    LEFT JOIN character_references ON user_resumes.user_id = character_references.user_id
                                    WHERE user_resumes.user_id = ?
                                ";
                                $resumeStmt = $conn->prepare($resumeQuery);
                                $resumeStmt->bind_param("i", $row["user_id"]);
                                $resumeStmt->execute();
                                $resumeResult = $resumeStmt->get_result();
                                $resumeRow = $resumeResult->fetch_assoc();

                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row['first_name'] . ' ' . $row['first_name']; ?>
                                    </td>
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
                                        <?php echo $row['location']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['application_status'] == 'Pending') {
                                            ?>
                                            <span class=" badge badge border border-secondary text-secondary ">
                                                <i class="bi bi-clock-history me-1"></i>Pending
                                            </span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class=" badge badge border border-primary text-primary ">
                                                <i class="bi bi-file-earmark-break me-1"></i>Pooling
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success badge " data-bs-toggle="modal"
                                            data-bs-target="#viewResumeModal<?php echo $row['id'] ?>">
                                            View Resume
                                        </button>
                                    </td>
                                    <td>
                                        <a href="#" class="link-danger text-decoration-none dropdown-toggle text-dark"
                                            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-list"></i>
                                        </a>
                                        <ul class="dropdown-menu text-center shadow" aria-labelledby="dropdownUser2">
                                            <li class="mb-1">
                                                <button type="button" class="btn btn-success badge ">
                                                    <i class="bi bi-check-square"></i> Passed
                                                </button>
                                            </li>
                                            <li class="mb-1">
                                                <button type="button" class="btn btn-danger badge ">
                                                    <i class="bi bi-x-square"></i> Failed
                                                </button>
                                            </li>
                                            <li class="mb-1">
                                                <button type="button" class="btn btn-primary badge ">
                                                    <i class="bi bi-exclamation-square"></i> Pooling
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <div class="modal fade" id="viewResumeModal<?php echo $row['id'] ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header  p-5 pb-4 border-bottom-0">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>'s Resume
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <form action="my_resume_process.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Personal Information</h4>
                                                    <hr style="border-width: 3px;">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-lg-2">
                                                            <div class="row ">
                                                                <div class="col-auto" id="imagePreviewContainer">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-auto">
                                                                            <img id="imagePreview"
                                                                                src="/recruitment/img/applicant/<?php echo $resumeRow['picture']; ?>"
                                                                                alt="No Image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-12 col-lg-10 order-last">
                                                            <div class="container-fluid mt-5">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text"
                                                                                class="form-control rounded-3 fw-bold"
                                                                                placeholder="Juan" name="lName"
                                                                                value="<?php echo !empty ($resumeRow['last_name']) ? $resumeRow['last_name'] : ''; ?>"
                                                                                required disabled>
                                                                            <label for="floatingInput" class="fw-bold">Last
                                                                                Name</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text"
                                                                                class="form-control rounded-3 fw-bold"
                                                                                placeholder="Juan" name="fName"
                                                                                value="<?php echo !empty ($resumeRow['first_name']) ? $resumeRow['first_name'] : ''; ?>"
                                                                                required disabled>
                                                                            <label for="floatingInput" class="fw-bold">FIrst
                                                                                Name</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text"
                                                                                class="form-control rounded-3 fw-bold"
                                                                                placeholder="Juan" name="mName"
                                                                                value="<?php echo !empty ($resumeRow['middle_name']) ? $resumeRow['middle_name'] : ''; ?>"
                                                                                required disabled>
                                                                            <label for="floatingInput"
                                                                                class="fw-bold">Middle Name</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- For Addresses -->
                                                    <div class="row mt-3">

                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-floating mb-3">
                                                                <input type="email" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="emailAddress"
                                                                    value="<?php echo !empty ($resumeRow['email']) ? $resumeRow['email'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Email
                                                                    Address</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="presentAddress"
                                                                    value="<?php echo !empty ($resumeRow['present_address']) ? $resumeRow['present_address'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Present
                                                                    Address</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="permanentAddress"
                                                                    value="<?php echo !empty ($resumeRow['permanent_address']) ? $resumeRow['permanent_address'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Permanent
                                                                    Address</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="height"
                                                                    value="<?php echo !empty ($resumeRow['height']) ? $resumeRow['height'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Height</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="weight"
                                                                    value="<?php echo !empty ($resumeRow['weight']) ? $resumeRow['weight'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Weight</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="nationality"
                                                                    value="<?php echo !empty ($resumeRow['nationality']) ? $resumeRow['nationality'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput"
                                                                    class="fw-bold">Nationality</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="religion"
                                                                    value="<?php echo !empty ($resumeRow['religion']) ? $resumeRow['religion'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Religion</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg">
                                                            <div class="form-group">
                                                                <label for="birthDate" class="fw-bold">Birth
                                                                    Date:</label>
                                                                <input class="form-control fw-bold" type="date"
                                                                    id="birthDate" name="birthDate"
                                                                    value="<?php echo !empty ($resumeRow['birthdate']) ? $resumeRow['birthdate'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg">
                                                            <div class="form-group">
                                                                <label for="genderSelect" class="fw-bold">Gender:</label>
                                                                <select class="form-control fw-bold" id="genderSelect"
                                                                    name="gender" required disabled>
                                                                    <option <?php echo (empty ($resumeRow['gender']) ? 'selected' : ''); ?> disabled>
                                                                        Choose...</option>
                                                                    <option value="Male" <?php echo (!empty ($resumeRow['gender']) && $resumeRow['gender'] == 'Male') ? 'selected' : ''; ?>>
                                                                        Male</option>
                                                                    <option value="Female" <?php echo (!empty ($resumeRow['gender']) && $resumeRow['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="row mt-2">

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="sssNumber"
                                                                    value="<?php echo !empty ($resumeRow['sss_number']) ? $resumeRow['sss_number'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">SSS
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="philhealthNumber"
                                                                    value="<?php echo !empty ($resumeRow['philhealth_number']) ? $resumeRow['philhealth_number'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">PhilHealth
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="pagibigNumber"
                                                                    value="<?php echo !empty ($resumeRow['pagibig_number']) ? $resumeRow['pagibig_number'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Pagibig
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="tinNumber"
                                                                    value="<?php echo !empty ($resumeRow['tin_number']) ? $resumeRow['tin_number'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">TIN
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="contactNumber"
                                                                    value="<?php echo !empty ($resumeRow['contact_number']) ? $resumeRow['contact_number'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="floatingInput" class="fw-bold">Contact
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg">
                                                            <div class="form-group">
                                                                <label for="civilStatusSelect" class="fw-bold ">Civil
                                                                    Status:</label>
                                                                <select class="form-control fw-bold " id="civilStatusSelect"
                                                                    name="civilStatus" required disabled>
                                                                    <option <?php echo (empty ($resumeRow['civil_status']) ? 'selected' : ''); ?> disabled>
                                                                        Choose...</option>
                                                                    <option value="Single" <?php echo (!empty ($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                                                                    <option value="Married" <?php echo (!empty ($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                                                                    <option value="Widowed" <?php echo (!empty ($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                                                                    <option value="Separated" <?php echo (!empty ($resumeRow['civil_status']) && $resumeRow['civil_status'] == 'Separated') ? 'selected' : ''; ?>>Separated</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Educational Attainment</h4>
                                                    <hr style="border-width: 3px;">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="college"
                                                                            value="<?php echo !empty ($resumeRow['college']) ? $resumeRow['college'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">College</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="degree"
                                                                            value="<?php echo !empty ($resumeRow['college_degree']) ? $resumeRow['college_degree'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Degree</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="eduCollegeFromDate"
                                                                            value="<?php echo !empty ($resumeRow['college_from']) ? $resumeRow['college_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="eduCollegeToDate"
                                                                            value="<?php echo !empty ($resumeRow['college_to']) ? $resumeRow['college_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="vocational"
                                                                            value="<?php echo !empty ($resumeRow['vocational']) ? $resumeRow['vocational'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Vocational</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="diploma"
                                                                            value="<?php echo !empty ($resumeRow['vocational_diploma']) ? $resumeRow['vocational_diploma'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Diploma</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="eduVocationalFromDate"
                                                                            value="<?php echo !empty ($resumeRow['vocational_from']) ? $resumeRow['vocational_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="eduVocationalToDate"
                                                                            value="<?php echo !empty ($resumeRow['vocational_to']) ? $resumeRow['vocational_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="highSchool"
                                                                            value="<?php echo !empty ($resumeRow['high_school']) ? $resumeRow['high_school'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput" class="fw-bold">High
                                                                            School</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="highSchoolLevel"
                                                                            value="<?php echo !empty ($resumeRow['high_school_level']) ? $resumeRow['high_school_level'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Level</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="eduHighSchoolFromDate"
                                                                            value="<?php echo !empty ($resumeRow['high_school_from']) ? $resumeRow['high_school_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="eduHighSchoolToDate"
                                                                            value="<?php echo !empty ($resumeRow['high_school_to']) ? $resumeRow['high_school_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="elementary"
                                                                            value="<?php echo !empty ($resumeRow['elementary']) ? $resumeRow['elementary'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Elementary</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="elementaryLevel"
                                                                            value="<?php echo !empty ($resumeRow['elementary_level']) ? $resumeRow['elementary_level'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Level</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="eduElementaryFromDate"
                                                                            value="<?php echo !empty ($resumeRow['	elementary_from']) ? $resumeRow['	elementary_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="eduElementaryToDate"
                                                                            value="<?php echo !empty ($resumeRow['elementary_to']) ? $resumeRow['elementary_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Employment Background</h4>
                                                    <hr style="border-width: 3px;">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="company1"
                                                                            value="<?php echo !empty ($resumeRow['company_one']) ? $resumeRow['company_one'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput" class="fw-bold">Company
                                                                            1</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="position1"
                                                                            value="<?php echo !empty ($resumeRow['company_one_position']) ? $resumeRow['company_one_position'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Position</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="empBgFromDate1"
                                                                            value="<?php echo !empty ($resumeRow['company_one_from']) ? $resumeRow['company_one_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-4 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="empBgToDate1"
                                                                            value="<?php echo !empty ($resumeRow['company_one_to']) ? $resumeRow['company_one_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="status1"
                                                                            value="<?php echo !empty ($resumeRow['company_one_status']) ? $resumeRow['company_one_status'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Status</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="responsibilities1"
                                                                    value="<?php echo !empty ($resumeRow['company_one_responsibilities']) ? $resumeRow['company_one_responsibilities'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput"
                                                                    class="fw-bold">Responsibilities</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-9 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="reason1"
                                                                    value="<?php echo !empty ($resumeRow['company_one_reason_for_leaving']) ? $resumeRow['company_one_reason_for_leaving'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Reason for
                                                                    Leaving</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="lastSalary1"
                                                                    value="<?php echo !empty ($resumeRow['company_one_last_salary']) ? $resumeRow['company_one_last_salary'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Last
                                                                    Salary</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr style="border-width: 2px;">


                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="company2"
                                                                            value="<?php echo !empty ($resumeRow['company_two']) ? $resumeRow['company_two'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput" class="fw-bold">Company
                                                                            2</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="position2"
                                                                            value="<?php echo !empty ($resumeRow['company_two_position']) ? $resumeRow['company_two_position'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Position</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="empBgFromDate2"
                                                                            value="<?php echo !empty ($resumeRow['company_two_from']) ? $resumeRow['company_two_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-4 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="empBgToDate2"
                                                                            value="<?php echo !empty ($resumeRow['company_two_to']) ? $resumeRow['company_two_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="status2"
                                                                            value="<?php echo !empty ($resumeRow['company_two_status']) ? $resumeRow['company_two_status'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Status</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="responsibilities2"
                                                                    value="<?php echo !empty ($resumeRow['company_two_responsibilities']) ? $resumeRow['company_two_responsibilities'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput"
                                                                    class="fw-bold">Responsibilities</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-9 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="reason2"
                                                                    value="<?php echo !empty ($resumeRow['company_two_reason_for_leaving']) ? $resumeRow['company_two_reason_for_leaving'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Reason for
                                                                    Leaving</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="lastSalary2"
                                                                    value="<?php echo !empty ($resumeRow['company_two_last_salary']) ? $resumeRow['company_two_last_salary'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Last
                                                                    Salary</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="company3"
                                                                            value="<?php echo !empty ($resumeRow['company_three']) ? $resumeRow['company_three'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput" class="fw-bold">Company
                                                                            3</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 mt-2">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="position3"
                                                                            value="<?php echo !empty ($resumeRow['company_three_position']) ? $resumeRow['company_three_position'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Position</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="fromDate" class="fw-bold">From:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="fromDate" name="empBgFromDate3"
                                                                            value="<?php echo !empty ($resumeRow['company_three_from']) ? $resumeRow['company_three_from'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-4 mt-2">
                                                                    <div class="form-group">
                                                                        <label for="toDate" class="fw-bold">To:</label>
                                                                        <input class="form-control fw-bold" type="date"
                                                                            id="toDate" name="empBgToDate3"
                                                                            value="<?php echo !empty ($resumeRow['company_three_to']) ? $resumeRow['company_three_to'] : ''; ?>"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-md-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text"
                                                                            class="form-control rounded-3 fw-bold"
                                                                            placeholder="12" name="status3"
                                                                            value="<?php echo !empty ($resumeRow['company_three_status']) ? $resumeRow['company_three_status'] : ''; ?>"
                                                                            disabled>
                                                                        <label for="floatingInput"
                                                                            class="fw-bold">Status</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="responsibilities3"
                                                                    value="<?php echo !empty ($resumeRow['company_three_responsibilities']) ? $resumeRow['company_three_responsibilities'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput"
                                                                    class="fw-bold">Responsibilities</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-9 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="reason3"
                                                                    value="<?php echo !empty ($resumeRow['company_three_reason_for_leaving']) ? $resumeRow['company_three_reason_for_leaving'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Reason for
                                                                    Leaving</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="lastSalary3"
                                                                    value="<?php echo !empty ($resumeRow['company_three_last_salary']) ? $resumeRow['company_three_last_salary'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Last
                                                                    Salary</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Recent Employment</h4>
                                                    <hr style="border-width: 3px;">


                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-4 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="recentEmpContactPerson"
                                                                    value="<?php echo !empty ($resumeRow['recent_employment_contact_person']) ? $resumeRow['recent_employment_contact_person'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Contact
                                                                    Person</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="recentEmpPosition"
                                                                    value="<?php echo !empty ($resumeRow['recent_employment_position']) ? $resumeRow['recent_employment_position'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Position</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="recentEmpContactNum"
                                                                    value="<?php echo !empty ($resumeRow['recent_employment_contact_number']) ? $resumeRow['recent_employment_contact_number'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Contact
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Lectures and Seminars Attended</h4>
                                                    <hr style="border-width: 3px;">

                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="seminarTitle1"
                                                                    value="<?php echo !empty ($resumeRow['title_one']) ? $resumeRow['title_one'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Title
                                                                    1</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="seminarVenue1"
                                                                    value="<?php echo !empty ($resumeRow['title_one_venue']) ? $resumeRow['title_one_venue'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Venue</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label for="fromDate" class="fw-bold">From:</label>
                                                                <input class="form-control fw-bold" type="date"
                                                                    id="fromDate" name="seminarFromDate1"
                                                                    value="<?php echo !empty ($resumeRow['title_one_from']) ? $resumeRow['title_one_from'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-group">
                                                                <label for="toDate" class="fw-bold">To:</label>
                                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                                    name="seminarToDate1"
                                                                    value="<?php echo !empty ($resumeRow['title_one_to']) ? $resumeRow['title_one_to'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="seminarTitle2"
                                                                    value="<?php echo !empty ($resumeRow['title_two']) ? $resumeRow['title_two'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Title
                                                                    2</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="seminarVenue2"
                                                                    value="<?php echo !empty ($resumeRow['title_two_venue']) ? $resumeRow['title_two_venue'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Venue</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label for="fromDate" class="fw-bold">From:</label>
                                                                <input class="form-control fw-bold" type="date"
                                                                    id="fromDate" name="seminarFromDate2"
                                                                    value="<?php echo !empty ($resumeRow['title_two_from']) ? $resumeRow['title_two_from'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-group">
                                                                <label for="toDate" class="fw-bold">To:</label>
                                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                                    name="seminarToDate2"
                                                                    value="<?php echo !empty ($resumeRow['title_two_to']) ? $resumeRow['title_two_to'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="seminarTitle3"
                                                                    value="<?php echo !empty ($resumeRow['title_three']) ? $resumeRow['title_three'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Title
                                                                    3</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="seminarVenue3"
                                                                    value="<?php echo !empty ($resumeRow['title_three_venue']) ? $resumeRow['title_three_venue'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Venue</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label for="fromDate" class="fw-bold">From:</label>
                                                                <input class="form-control fw-bold" type="date"
                                                                    id="fromDate" name="seminarFromDate3"
                                                                    value="<?php echo !empty ($resumeRow['title_three_from']) ? $resumeRow['title_three_from'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-group">
                                                                <label for="toDate" class="fw-bold">To:</label>
                                                                <input class="form-control fw-bold" type="date" id="toDate"
                                                                    name="seminarToDate3"
                                                                    value="<?php echo !empty ($resumeRow['title_three_to']) ? $resumeRow['title_three_to'] : ''; ?>"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Character References</h4>
                                                    <hr style="border-width: 3px;">

                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefName1"
                                                                    value="<?php echo !empty ($resumeRow['name_one']) ? $resumeRow['name_one'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Name
                                                                    1</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefPosition1"
                                                                    value="<?php echo !empty ($resumeRow['name_one_position']) ? $resumeRow['name_one_position'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Position</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefCompany1"
                                                                    value="<?php echo !empty ($resumeRow['name_one_company']) ? $resumeRow['name_one_company'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Company</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefContactNum1"
                                                                    value="<?php echo !empty ($resumeRow['name_one_contact_number']) ? $resumeRow['name_one_contact_number'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Contact
                                                                    Number</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr style="border-width: 2px;">

                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefName2"
                                                                    value="<?php echo !empty ($resumeRow['name_two']) ? $resumeRow['name_two'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Name
                                                                    2</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefPosition2"
                                                                    value="<?php echo !empty ($resumeRow['name_two_position']) ? $resumeRow['name_two_position'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Position</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefCompany2"
                                                                    value="<?php echo !empty ($resumeRow['name_two_company']) ? $resumeRow['name_two_company'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Company</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control rounded-3 fw-bold"
                                                                    placeholder="12" name="charRefContactNum2"
                                                                    value="<?php echo !empty ($resumeRow['name_three_contact_number']) ? $resumeRow['name_three_contact_number'] : ''; ?>"
                                                                    disabled>
                                                                <label for="floatingInput" class="fw-bold">Contact
                                                                    Number</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h5 class="fw-bold text-center">How did you know about ___________?
                                                    </h5>
                                                    <hr style="border-width: 3px;">


                                                    <div class="row">

                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]" value="Job Fair">
                                                                <label class="form-check-label" for="inlineCheckbox1">Job
                                                                    Fair</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]"
                                                                    value="Online Advertisement">
                                                                <label class="form-check-label" for="inlineCheckbox1">Online
                                                                    Advertisement</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]"
                                                                    value="Newspaper / Magazines">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox1">Newspaper / Magazines</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]"
                                                                    value="Brochures / Flyers">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox1">Brochures / Flyers</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]" value="Walk-in">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox1">Walk-in</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]" value="Others">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox1">Others</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="inlineCheckbox1" name="source[]" value="Others">
                                                                <label class="form-check-label"
                                                                    for="inlineCheckbox1">Referral (Please specify
                                                                    name)</label>
                                                                <input class="" type="text" name="referralName">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="border-width: 3px;">
                                                    <h4 class="fw-bold text-center">Additional Information</h4>
                                                    <hr style="border-width: 3px;">

                                                    <div class="row">
                                                        <div class="col">
                                                            <p>
                                                                1. Do you have any relative/s working for___________? if
                                                                yes, please state name/s:
                                                            </p>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    id="addInfoFirstQuestion" placeholder="12"
                                                                    name="addInfoFirstQuestion"
                                                                    value="<?php echo !empty ($resumeRow['additional_info_q1']) ? $resumeRow['additional_info_q1'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="addInfoFirstQuestion" class="fw-bold">
                                                                    Answer:
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col">
                                                            <p>
                                                                2. Do you have any relative/s working for a company who
                                                                is in direct competition
                                                                with___________? If yes, please state the name/s and
                                                                company:
                                                            </p>
                                                            <div class="form-floating mb-3">

                                                                <input type="text" class="form-control rounded-3 fw-bold"
                                                                    id="addInfoSecondQuestion" placeholder="12"
                                                                    name="addInfoSecondQuestion"
                                                                    value="<?php echo !empty ($resumeRow['additional_info_q2']) ? $resumeRow['additional_info_q2'] : ''; ?>"
                                                                    required disabled>
                                                                <label for="addInfoSecondQuestion" class="fw-bold">
                                                                    Answer:
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>
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

<?php include ('../footer.php'); ?>