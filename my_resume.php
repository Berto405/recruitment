<?php
include ("header.php");
include ("dbconn.php");


if (!isset ($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
} else {
    $userId = $_SESSION['user_id'];

    //Showing current resume    
    $query = "SELECT resume FROM user WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = mysqli_fetch_array($result);
}
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
                                <img id="imagePreview" src="#" alt="No Image">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-auto">
                                <label id="formFileContainer" for="formFile"
                                    class="btn btn-danger text-white rounded-1">
                                    Upload Photo
                                </label>
                                <input id="formFile" name="notcropped" class="form-control" type="file"
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
                                <input type="text" class="form-control rounded-3" placeholder="Juan" name="fName"
                                    value="" required>
                                <label for="floatingInput" class="fw-bold">Last Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" placeholder="Juan" name="lName"
                                    value="" required>
                                <label for="floatingInput" class="fw-bold">FIrst Name</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" placeholder="Juan" name="mName"
                                    value="" required>
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
                    <input type="email" class="form-control rounded-3" placeholder="12" name="emailAddress" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Email Address</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="presentAddress" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Present Address</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="permanentAddress" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Permanent Address</label>
                </div>
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="height" value="" required>
                    <label for="floatingInput" class="fw-bold">Height</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="weight" value="" required>
                    <label for="floatingInput" class="fw-bold">Weight</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="nationality" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Nationality</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="religion" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Religion</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg">
                <div class="form-group">
                    <label for="birthDate" class="fw-bold">Birth Date:</label>
                    <input class="form-control" type="date" id="birthDate" name="birthDate">
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg">
                <div class="form-group">
                    <label for="genderSelect" class="fw-bold">Gender:</label>
                    <select class="form-control" id="genderSelect">
                        <option selected disabled>Choose...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="row mt-2">

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="sssNumber" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">SSS Number</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="philhealthNumber"
                        value="" required>
                    <label for="floatingInput" class="fw-bold">PhilHealth Number</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="pagibigNumber" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Pagibig Number</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="tinNumber" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">TIN Number</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="contactNumber" value=""
                        required>
                    <label for="floatingInput" class="fw-bold">Contact Number</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg">
                <div class="form-group">
                    <label for="civilStatusSelect" class="fw-bold">Civil Status:</label>
                    <select class="form-control" id="civilStatusSelect">
                        <option selected disabled>Choose...</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                    </select>
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
                            <input type="text" class="form-control rounded-3" placeholder="12" name="company1" value="">
                            <label for="floatingInput" class="fw-bold">Company 1</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="12" name="position1"
                                value="">
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
                            <input class="form-control" type="date" id="fromDate" name="empBgFromDate1">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-2">
                        <div class="form-group">
                            <label for="toDate" class="fw-bold">To:</label>
                            <input class="form-control" type="date" id="toDate" name="empBgToDate1">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="12" name="status1" value="">
                            <label for="floatingInput" class="fw-bold">Status</label>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row">

            <div class="col mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="responsibilities1"
                        value="">
                    <label for="floatingInput" class="fw-bold">Responsibilities</label>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-sm-12 col-md-9 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="reason1" value="">
                    <label for="floatingInput" class="fw-bold">Reason for Leaving</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="lastSalary1" value="">
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
                            <input type="text" class="form-control rounded-3" placeholder="12" name="company2" value="">
                            <label for="floatingInput" class="fw-bold">Company 2</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="12" name="position2"
                                value="">
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
                            <input class="form-control" type="date" id="fromDate" name="empBgFromDate2">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-2">
                        <div class="form-group">
                            <label for="toDate" class="fw-bold">To:</label>
                            <input class="form-control" type="date" id="toDate" name="empBgToDate2">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="12" name="status2" value="">
                            <label for="floatingInput" class="fw-bold">Status</label>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row">

            <div class="col mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="responsibilities2"
                        value="">
                    <label for="floatingInput" class="fw-bold">Responsibilities</label>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-sm-12 col-md-9 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="reason2" value="">
                    <label for="floatingInput" class="fw-bold">Reason for Leaving</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="lastSalary2" value="">
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
                            <input type="text" class="form-control rounded-3" placeholder="12" name="company3" value="">
                            <label for="floatingInput" class="fw-bold">Company 3</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="12" name="position3"
                                value="">
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
                            <input class="form-control" type="date" id="fromDate" name="empBgFromDate3">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-2">
                        <div class="form-group">
                            <label for="toDate" class="fw-bold">To:</label>
                            <input class="form-control" type="date" id="toDate" name="empBgToDate3">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="12" name="status3" value="">
                            <label for="floatingInput" class="fw-bold">Status</label>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row">

            <div class="col mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="responsibilities3"
                        value="">
                    <label for="floatingInput" class="fw-bold">Responsibilities</label>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-sm-12 col-md-9 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="reason3" value="">
                    <label for="floatingInput" class="fw-bold">Reason for Leaving</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="lastSalary3" value="">
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
                    <input type="text" class="form-control rounded-3" placeholder="12" name="recentEmpContactPerson"
                        value="">
                    <label for="floatingInput" class="fw-bold">Contact Person</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="recentEmpPosition"
                        value="">
                    <label for="floatingInput" class="fw-bold">Position</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="recentEmpContactNum"
                        value="">
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
                    <input type="text" class="form-control rounded-3" placeholder="12" name="seminarTitle1" value="">
                    <label for="floatingInput" class="fw-bold">Title 1</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="seminarVenue1" value="">
                    <label for="floatingInput" class="fw-bold">Venue</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="fromDate" class="fw-bold">From:</label>
                    <input class="form-control" type="date" id="fromDate" name="seminarFromDate1">
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-group">
                    <label for="toDate" class="fw-bold">To:</label>
                    <input class="form-control" type="date" id="toDate" name="seminarToDate1">
                </div>
            </div>


        </div>

        <hr style="border-width: 2px;">

        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="seminarTitle2" value="">
                    <label for="floatingInput" class="fw-bold">Title 2</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="seminarVenue2" value="">
                    <label for="floatingInput" class="fw-bold">Venue</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="fromDate" class="fw-bold">From:</label>
                    <input class="form-control" type="date" id="fromDate" name="seminarFromDate2">
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-group">
                    <label for="toDate" class="fw-bold">To:</label>
                    <input class="form-control" type="date" id="toDate" name="seminarToDate2">
                </div>
            </div>


        </div>

        <hr style="border-width: 2px;">

        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="seminarTitle3" value="">
                    <label for="floatingInput" class="fw-bold">Title 3</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="seminarVenue3" value="">
                    <label for="floatingInput" class="fw-bold">Venue</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="fromDate" class="fw-bold">From:</label>
                    <input class="form-control" type="date" id="fromDate" name="seminarFromDate3">
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-group">
                    <label for="toDate" class="fw-bold">To:</label>
                    <input class="form-control" type="date" id="toDate" name="seminarToDate3">
                </div>
            </div>

        </div>

        <hr style="border-width: 3px;">
        <h4 class="fw-bold text-center">Character References</h4>
        <hr style="border-width: 3px;">

        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="charRefName1" value="">
                    <label for="floatingInput" class="fw-bold">Name 1</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="charRefPosition1" value="">
                    <label for="floatingInput" class="fw-bold">Position</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="charRefCompany1" value="">
                    <label for="floatingInput" class="fw-bold">Company</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="charRefContactNum1"
                        value="">
                    <label for="floatingInput" class="fw-bold">Contact Number</label>
                </div>
            </div>
        </div>

        <hr style="border-width: 2px;">

        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="charRefName2" value="">
                    <label for="floatingInput" class="fw-bold">Name 2</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="charRefPosition2" value="">
                    <label for="floatingInput" class="fw-bold">Position</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control rounded-3" placeholder="12" name="charRefCompany2" value="">
                    <label for="floatingInput" class="fw-bold">Company</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3 mt-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control rounded-3" placeholder="12" name="charRefContactNum2"
                        value="">
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
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Job Fair">
                    <label class="form-check-label" for="inlineCheckbox1">Job Fair</label>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Online Advertisement">
                    <label class="form-check-label" for="inlineCheckbox1">Online Advertisement</label>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Newspaper / Magazines">
                    <label class="form-check-label" for="inlineCheckbox1">Newspaper / Magazines</label>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-sm-12 col-lg-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Brochures / Flyers">
                    <label class="form-check-label" for="inlineCheckbox1">Brochures / Flyers</label>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Walk-in">
                    <label class="form-check-label" for="inlineCheckbox1">Walk-in</label>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Others">
                    <label class="form-check-label" for="inlineCheckbox1">Others</label>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Others">
                    <label class="form-check-label" for="inlineCheckbox1">Referral (Please specify name)</label>
                    <input class="" type="text">
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
                        name="addInfoFirstQuestion" value="">
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
                        name="addInfoSecondQuestion" value="">
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
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Others">
                    <label class="form-check-label" for="inlineCheckbox1" style="text-align: justify;">
                        I hereby certify that the above information as
                        provided by me is all true and correct. If employment is obtained under this application I will
                        abide by all rules, regulations and policies of the company. I further understand that any false
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
                    I hereby agrees/authorizes and consent ______________ to process and update of all my personal and
                    sensitive information relative to my application or employment. This authorization is given in
                    compliance o Republic Act 10173 or the Data Privacy Act of 2012.
                </p>
                <p>
                    I also hereby authorize and consent ______________ to disclose my personal and sensitve information
                    relative to my application or employment to its clients. This authorization is given in compliance
                    of Republic Act 10173 or the Data Privacy Act of 2012.
                </p>
                <div class="float-end">
                    <label for="applicantSignature" class="fw-bold">Upload ypur e-Signature:</label>
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
<?php include ('footer.php'); ?>