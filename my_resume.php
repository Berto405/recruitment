<?php
include ('my_resume_process.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
} else if ($_SESSION['user_role'] !== 'user') {

    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: index.php");
    exit();
} else {
    $userId = $_SESSION['user_id'];

    //Showing current resume    
    $query = "SELECT *
        FROM user_resumes
        LEFT JOIN educational_attainment ON user_resumes.user_id = educational_attainment.user_id
        LEFT JOIN employment_background ON user_resumes.user_id = employment_background.user_id
        LEFT JOIN lectures_and_seminars_attended ON user_resumes.user_id = lectures_and_seminars_attended.user_id
        LEFT JOIN character_references ON user_resumes.user_id = character_references.user_id
        WHERE user_resumes.user_id = ?;
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there is any result
    if ($result->num_rows > 0) {
        // Fetch the row from the result set
        $row = $result->fetch_assoc();
    }

}


//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ("components/header.php");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
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
    <div class="container mt-5 bg-white">

        <form action="my_resume_process.php" method="post" enctype="multipart/form-data">
            <hr style="border-width: 3px;">
            <h4 class="fw-bold text-center">Personal Information</h4>
            <hr style="border-width: 3px;">
            <div class="row">
                <!-- For Uploading Photo -->
                <div class="col-sm-12 col-lg-2">
                    <div class="row ">
                        <div class="col-auto" id="imagePreviewContainer">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <img id="imagePreview" src="./img/applicant/<?php echo $row['picture']; ?>"
                                        alt="No Image">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-auto">
                                    <label id="formFileContainer" for="formFile"
                                        class="btn btn-danger text-white rounded-1">
                                        Upload Photo
                                    </label>
                                    <input id="formFile" name="image" class="form-control" type="file"
                                        accept=".png, .jpg, .jpeg" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- For Name Inputs -->
                <div class="col-sm-12 col-lg-10 order-last">
                    <div class="container-fluid mt-5">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3 fw-bold" placeholder="Juan"
                                        name="lName"
                                        value="<?php echo !empty($row['last_name']) ? $row['last_name'] : ''; ?>"
                                        required>
                                    <label for="floatingInput" class="fw-bold">Last Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3 fw-bold" placeholder="Juan"
                                        name="fName"
                                        value="<?php echo !empty($row['first_name']) ? $row['first_name'] : ''; ?>"
                                        required>
                                    <label for="floatingInput" class="fw-bold">FIrst Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3 fw-bold" placeholder="Juan"
                                        name="mName"
                                        value="<?php echo !empty($row['middle_name']) ? $row['middle_name'] : ''; ?>"
                                        required>
                                    <label for="floatingInput" class="fw-bold">Middle Name</label>
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
                        <input type="email" class="form-control rounded-3 fw-bold" placeholder="12" name="emailAddress"
                            value="<?php echo !empty($row['email']) ? $row['email'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">Email Address</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="presentAddress"
                            value="<?php echo !empty($row['present_address']) ? $row['present_address'] : ''; ?>"
                            required>
                        <label for="floatingInput" class="fw-bold">Present Address</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="permanentAddress"
                            value="<?php echo !empty($row['permanent_address']) ? $row['permanent_address'] : ''; ?>"
                            required>
                        <label for="floatingInput" class="fw-bold">Permanent Address</label>
                    </div>
                </div>
            </div>

            <div class="row mt-2">

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="height"
                            value="<?php echo !empty($row['height']) ? $row['height'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">Height</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="weight"
                            value="<?php echo !empty($row['weight']) ? $row['weight'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">Weight</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="nationality"
                            value="<?php echo !empty($row['nationality']) ? $row['nationality'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">Nationality</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="religion"
                            value="<?php echo !empty($row['religion']) ? $row['religion'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">Religion</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg">
                    <div class="form-group">
                        <label for="birthDate" class="fw-bold">Birth Date:</label>
                        <input class="form-control fw-bold" type="date" id="birthDate" name="birthDate"
                            value="<?php echo !empty($row['birthdate']) ? $row['birthdate'] : ''; ?>">
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg">
                    <div class="form-group">
                        <label for="genderSelect" class="fw-bold">Gender:</label>
                        <select class="form-control fw-bold" id="genderSelect" name="gender" required>
                            <option <?php echo (empty($row['civil_status']) ? 'selected' : ''); ?> disabled>
                                Choose...</option>
                            <option value="Male" <?php echo (!empty($row['gender']) && $row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (!empty($row['gender']) && $row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="row mt-2">

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12" name="sssNumber"
                            value="<?php echo !empty($row['sss_number']) ? $row['sss_number'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">SSS Number</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="philhealthNumber"
                            value="<?php echo !empty($row['philhealth_number']) ? $row['philhealth_number'] : ''; ?>"
                            required>
                        <label for="floatingInput" class="fw-bold">PhilHealth Number</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="pagibigNumber"
                            value="<?php echo !empty($row['pagibig_number']) ? $row['pagibig_number'] : ''; ?>"
                            required>
                        <label for="floatingInput" class="fw-bold">Pagibig Number</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12" name="tinNumber"
                            value="<?php echo !empty($row['tin_number']) ? $row['tin_number'] : ''; ?>" required>
                        <label for="floatingInput" class="fw-bold">TIN Number</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="contactNumber"
                            value="<?php echo !empty($row['contact_number']) ? $row['contact_number'] : ''; ?>"
                            required>
                        <label for="floatingInput" class="fw-bold">Contact Number</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg">
                    <div class="form-group">
                        <label for="civilStatusSelect" class="fw-bold ">Civil Status:</label>
                        <select class="form-control fw-bold " id="civilStatusSelect" name="civilStatus" required>
                            <option <?php echo (empty($row['civil_status']) ? 'selected' : ''); ?> disabled>
                                Choose...</option>
                            <option value="Single" <?php echo (!empty($row['civil_status']) && $row['civil_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                            <option value="Married" <?php echo (!empty($row['civil_status']) && $row['civil_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                            <option value="Widowed" <?php echo (!empty($row['civil_status']) && $row['civil_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                            <option value="Separated" <?php echo (!empty($row['civil_status']) && $row['civil_status'] == 'Separated') ? 'selected' : ''; ?>>Separated</option>
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
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="college"
                                    value="<?php echo !empty($row['college']) ? $row['college'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">College</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="degree"
                                    value="<?php echo !empty($row['college_degree']) ? $row['college_degree'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Degree</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate" name="eduCollegeFromDate"
                                    value="<?php echo !empty($row['college_from']) ? $row['college_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="eduCollegeToDate"
                                    value="<?php echo !empty($row['college_to']) ? $row['college_to'] : ''; ?>">
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
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="vocational"
                                    value="<?php echo !empty($row['vocational']) ? $row['vocational'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Vocational</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="diploma"
                                    value="<?php echo !empty($row['vocational_diploma']) ? $row['vocational_diploma'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Diploma</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate"
                                    name="eduVocationalFromDate"
                                    value="<?php echo !empty($row['vocational_from']) ? $row['vocational_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="eduVocationalToDate"
                                    value="<?php echo !empty($row['vocational_to']) ? $row['vocational_to'] : ''; ?>">
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
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="highSchool"
                                    value="<?php echo !empty($row['high_school']) ? $row['high_school'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">High School</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="highSchoolLevel"
                                    value="<?php echo !empty($row['high_school_level']) ? $row['high_school_level'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Level</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate"
                                    name="eduHighSchoolFromDate"
                                    value="<?php echo !empty($row['high_school_from']) ? $row['high_school_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="eduHighSchoolToDate"
                                    value="<?php echo !empty($row['high_school_to']) ? $row['high_school_to'] : ''; ?>">>
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
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="elementary"
                                    value="<?php echo !empty($row['elementary']) ? $row['elementary'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Elementary</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="elementaryLevel"
                                    value="<?php echo !empty($row['elementary_level']) ? $row['elementary_level'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Level</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate"
                                    name="eduElementaryFromDate"
                                    value="<?php echo !empty($row['	elementary_from']) ? $row['	elementary_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="eduElementaryToDate"
                                    value="<?php echo !empty($row['elementary_to']) ? $row['elementary_to'] : ''; ?>">
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
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="company1"
                                    value="<?php echo !empty($row['company_one']) ? $row['company_one'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Company 1</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="position1"
                                    value="<?php echo !empty($row['company_one_position']) ? $row['company_one_position'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Position</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate" name="empBgFromDate1"
                                    value="<?php echo !empty($row['company_one_from']) ? $row['company_one_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="empBgToDate1"
                                    value="<?php echo !empty($row['company_one_to']) ? $row['company_one_to'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mt-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="status1"
                                    value="<?php echo !empty($row['company_one_status']) ? $row['company_one_status'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Status</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="responsibilities1"
                            value="<?php echo !empty($row['company_one_responsibilities']) ? $row['company_one_responsibilities'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Responsibilities</label>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-sm-12 col-md-9 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="reason1"
                            value="<?php echo !empty($row['company_one_reason_for_leaving']) ? $row['company_one_reason_for_leaving'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Reason for Leaving</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12" name="lastSalary1"
                            value="<?php echo !empty($row['company_one_last_salary']) ? $row['company_one_last_salary'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Last Salary</label>
                    </div>
                </div>
            </div>

            <hr style="border-width: 2px;">


            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="company2"
                                    value="<?php echo !empty($row['company_two']) ? $row['company_two'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Company 2</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="position2"
                                    value="<?php echo !empty($row['company_two_position']) ? $row['company_two_position'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Position</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate" name="empBgFromDate2"
                                    value="<?php echo !empty($row['company_two_from']) ? $row['company_two_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="empBgToDate2"
                                    value="<?php echo !empty($row['company_two_to']) ? $row['company_two_to'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mt-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="status2"
                                    value="<?php echo !empty($row['company_two_status']) ? $row['company_two_status'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Status</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="responsibilities2"
                            value="<?php echo !empty($row['company_two_responsibilities']) ? $row['company_two_responsibilities'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Responsibilities</label>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-sm-12 col-md-9 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="reason2"
                            value="<?php echo !empty($row['company_two_reason_for_leaving']) ? $row['company_two_reason_for_leaving'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Reason for Leaving</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12" name="lastSalary2"
                            value="<?php echo !empty($row['company_two_last_salary']) ? $row['company_two_last_salary'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Last Salary</label>
                    </div>
                </div>
            </div>

            <hr style="border-width: 2px;">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="company3"
                                    value="<?php echo !empty($row['company_three']) ? $row['company_three'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Company 3</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 mt-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="position3"
                                    value="<?php echo !empty($row['company_three_position']) ? $row['company_three_position'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Position</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="fromDate" class="fw-bold">From:</label>
                                <input class="form-control fw-bold" type="date" id="fromDate" name="empBgFromDate3"
                                    value="<?php echo !empty($row['company_three_from']) ? $row['company_three_from'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mt-2">
                            <div class="form-group">
                                <label for="toDate" class="fw-bold">To:</label>
                                <input class="form-control fw-bold" type="date" id="toDate" name="empBgToDate3"
                                    value="<?php echo !empty($row['company_three_to']) ? $row['company_three_to'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mt-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                                    name="status3"
                                    value="<?php echo !empty($row['company_three_status']) ? $row['company_three_status'] : ''; ?>">
                                <label for="floatingInput" class="fw-bold">Status</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="responsibilities3"
                            value="<?php echo !empty($row['company_three_responsibilities']) ? $row['company_three_responsibilities'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Responsibilities</label>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-sm-12 col-md-9 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="reason3"
                            value="<?php echo !empty($row['company_three_reason_for_leaving']) ? $row['company_three_reason_for_leaving'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Reason for Leaving</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12" name="lastSalary3"
                            value="<?php echo !empty($row['company_three_last_salary']) ? $row['company_three_last_salary'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Last Salary</label>
                    </div>
                </div>
            </div>

            <hr style="border-width: 3px;">
            <h4 class="fw-bold text-center">Recent Employment</h4>
            <hr style="border-width: 3px;">


            <div class="row">

                <div class="col-sm-12 col-md-4 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="recentEmpContactPerson"
                            value="<?php echo !empty($row['recent_employment_contact_person']) ? $row['recent_employment_contact_person'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Contact Person</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="recentEmpPosition"
                            value="<?php echo !empty($row['recent_employment_position']) ? $row['recent_employment_position'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Position</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="recentEmpContactNum"
                            value="<?php echo !empty($row['recent_employment_contact_number']) ? $row['recent_employment_contact_number'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Contact Number</label>
                    </div>
                </div>

            </div>

            <hr style="border-width: 3px;">
            <h4 class="fw-bold text-center">Lectures and Seminars Attended</h4>
            <hr style="border-width: 3px;">

            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="seminarTitle1"
                            value="<?php echo !empty($row['title_one']) ? $row['title_one'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Title 1</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="seminarVenue1"
                            value="<?php echo !empty($row['title_one_venue']) ? $row['title_one_venue'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Venue</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="fromDate" class="fw-bold">From:</label>
                        <input class="form-control fw-bold" type="date" id="fromDate" name="seminarFromDate1"
                            value="<?php echo !empty($row['title_one_from']) ? $row['title_one_from'] : ''; ?>">
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-group">
                        <label for="toDate" class="fw-bold">To:</label>
                        <input class="form-control fw-bold" type="date" id="toDate" name="seminarToDate1"
                            value="<?php echo !empty($row['title_one_to']) ? $row['title_one_to'] : ''; ?>">
                    </div>
                </div>


            </div>

            <hr style="border-width: 2px;">

            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="seminarTitle2"
                            value="<?php echo !empty($row['title_two']) ? $row['title_two'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Title 2</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="seminarVenue2"
                            value="<?php echo !empty($row['title_two_venue']) ? $row['title_two_venue'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Venue</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="fromDate" class="fw-bold">From:</label>
                        <input class="form-control fw-bold" type="date" id="fromDate" name="seminarFromDate2"
                            value="<?php echo !empty($row['title_two_from']) ? $row['title_two_from'] : ''; ?>">
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-group">
                        <label for="toDate" class="fw-bold">To:</label>
                        <input class="form-control fw-bold" type="date" id="toDate" name="seminarToDate2"
                            value="<?php echo !empty($row['title_two_to']) ? $row['title_two_to'] : ''; ?>">
                    </div>
                </div>


            </div>

            <hr style="border-width: 2px;">

            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="seminarTitle3"
                            value="<?php echo !empty($row['title_three']) ? $row['title_three'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Title 3</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="seminarVenue3"
                            value="<?php echo !empty($row['title_three_venue']) ? $row['title_three_venue'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Venue</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="fromDate" class="fw-bold">From:</label>
                        <input class="form-control fw-bold" type="date" id="fromDate" name="seminarFromDate3"
                            value="<?php echo !empty($row['title_three_from']) ? $row['title_three_from'] : ''; ?>">
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-group">
                        <label for="toDate" class="fw-bold">To:</label>
                        <input class="form-control fw-bold" type="date" id="toDate" name="seminarToDate3"
                            value="<?php echo !empty($row['title_three_to']) ? $row['title_three_to'] : ''; ?>">
                    </div>
                </div>

            </div>

            <hr style="border-width: 3px;">
            <h4 class="fw-bold text-center">Character References</h4>
            <hr style="border-width: 3px;">

            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="charRefName1"
                            value="<?php echo !empty($row['name_one']) ? $row['name_one'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Name 1</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="charRefPosition1"
                            value="<?php echo !empty($row['name_one_position']) ? $row['name_one_position'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Position</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="charRefCompany1"
                            value="<?php echo !empty($row['name_one_company']) ? $row['name_one_company'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Company</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="charRefContactNum1"
                            value="<?php echo !empty($row['name_one_contact_number']) ? $row['name_one_contact_number'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Contact Number</label>
                    </div>
                </div>
            </div>

            <hr style="border-width: 2px;">

            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12" name="charRefName2"
                            value="<?php echo !empty($row['name_two']) ? $row['name_two'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Name 2</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="charRefPosition2"
                            value="<?php echo !empty($row['name_two_position']) ? $row['name_two_position'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Position</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="charRefCompany2"
                            value="<?php echo !empty($row['name_two_company']) ? $row['name_two_company'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Company</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3 fw-bold" placeholder="12"
                            name="charRefContactNum2"
                            value="<?php echo !empty($row['name_three_contact_number']) ? $row['name_three_contact_number'] : ''; ?>">
                        <label for="floatingInput" class="fw-bold">Contact Number</label>
                    </div>
                </div>
            </div>

            <hr style="border-width: 3px;">
            <h5 class="fw-bold text-center">How did you know about ___________?</h5>
            <hr style="border-width: 3px;">


            <div class="row">

                <div class="col-sm-12 col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Job Fair">
                        <label class="form-check-label" for="inlineCheckbox1">Job Fair</label>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Online Advertisement">
                        <label class="form-check-label" for="inlineCheckbox1">Online Advertisement</label>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Newspaper / Magazines">
                        <label class="form-check-label" for="inlineCheckbox1">Newspaper / Magazines</label>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-sm-12 col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Brochures / Flyers">
                        <label class="form-check-label" for="inlineCheckbox1">Brochures / Flyers</label>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Walk-in">
                        <label class="form-check-label" for="inlineCheckbox1">Walk-in</label>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Others">
                        <label class="form-check-label" for="inlineCheckbox1">Others</label>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="source[]"
                            value="Referral">
                        <label class="form-check-label" for="inlineCheckbox1">Referral (Please specify name)</label>
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
                        1. Do you have any relative/s working for___________? if yes, please state name/s:
                    </p>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="addInfoFirstQuestion" placeholder="12"
                            name="addInfoFirstQuestion" value="" required>
                        <label for="addInfoFirstQuestion" class="fw-bold">
                            Answer:
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p>
                        2. Do you have any relative/s working for a company who is in direct competition
                        with___________? If yes, please state the name/s and company:
                    </p>
                    <div class="form-floating mb-3">

                        <input type="text" class="form-control rounded-3" id="addInfoSecondQuestion" placeholder="12"
                            name="addInfoSecondQuestion" value="" required>
                        <label for="addInfoSecondQuestion" class="fw-bold">
                            Answer:
                        </label>
                    </div>
                </div>
            </div>



            <hr style="border-width: 3px;">
            <h4 class="fw-bold text-center">Declaration</h4>
            <hr style="border-width: 3px;">


            <div class="row">
                <div class="col">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="declaration"
                            value="agreed">
                        <label class="form-check-label" for="inlineCheckbox1" style="text-align: justify;">
                            I hereby certify that the above information as
                            provided by me is all true and correct. If employment is obtained under this application I
                            will
                            abide by all rules, regulations and policies of the company. I further understand that any
                            false
                            statement on this subject application is in itself sufficient ground for
                            termination/cancellation of the subject application and/or employment
                        </label>
                    </div>
                </div>
            </div>


            <hr style="border-width: 3px;">
            <h4 class="fw-bold text-center">AUTHORITY TO PROCESS and DISCLOSURE OF INFORMATION</h4>
            <hr style="border-width: 3px;">


            <div class="row">
                <div class="col" style="text-align: justify;">
                    <p>
                        I hereby agree/authorize and consent ______________ to process and update of all my personal
                        and
                        sensitive information relative to my application or employment. This authorization is given in
                        compliance o Republic Act 10173 or the Data Privacy Act of 2012.
                    </p>
                    <p>
                        I also hereby authorize and consent ______________ to disclose my personal and sensitve
                        information
                        relative to my application or employment to its clients. This authorization is given in
                        compliance
                        of Republic Act 10173 or the Data Privacy Act of 2012.
                    </p>
                    <div class="float-end">
                        <label for="applicantSignature" class="fw-bold">Upload your e-Signature:</label>
                        <input type="file" id="applicantSignature" name="applicantSignature" class="form-control mt-2">
                    </div>

                </div>
            </div>

            <hr style="border-width: 3px;">

            <div class="mb-1 d-flex justify-content-center mt-3 ">
                <button class="btn btn-danger w-25 text-light" type="submit">
                    Submit
                </button>
            </div>

        </form>
    </div>


    <script>
        // JavaScript to handle image preview
        function previewImage() {
            var preview = document.querySelector('#imagePreview');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }

        // Trigger image preview when file input changes
        document.querySelector('#formFile').addEventListener('change', previewImage);
    </script>

    <!-- <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4">
                    <h2>Add your resume</h2>
                </div>
                <div class="card-body">

                    <div class="col w-100 ">
                        <div class="mb-2">
                            <?php
                            // if ($row['resume']) {
                            //     echo '
                            //             <h5>Current Resume:</h5>
                            //             <input type="text" class="form-control" value="' . $row['resume'] . '" readonly>
                            //             <h5 class="mt-2">Update Resume:</h5>
                            //             <input type="hidden" class="form-control" name="name" required>
                            //             <input type="file" class="form-control" name="resume_file" accept=".pdf" required>
                            //        ';
                            // } else {
                            //     echo '
                            
                            //             <input type="hidden" class="form-control" name="name" required>
                            //             <input type="file" class="form-control" name="resume_file" accept=".pdf" required>
                            //         ';
                            // }
                            ?>
                        </div>
                    </div>


                    <div class="text-center">
                        <small>
                            *Please note that only PDF file are accepted for resume. Ensure that your resume is in
                            PDF format before submitting.
                        </small>
                    </div>

                    <div class="mb-1 d-flex justify-content-center mt-3">
                        <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light" type="submit" name="submit">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div> -->
</body>

</html>
<?php include ('components/footer.php'); ?>