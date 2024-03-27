<?php
session_start();
include ("dbconn.php");

if (!isset ($_SESSION["user_id"])) {
    header('Location: login.php');
    exit();
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        personalInfo($conn);
        educationAttainment($conn);
        employmentBackground($conn);
        lecturesAndSeminar($conn);
        characterReference($conn);


        $_SESSION['success_message'] = "Resume Submitted.";
        header('Location: my_resume.php');
        exit();
    }

}


function personalInfo($conn)
{
    $userId = $_SESSION['user_id'];

    //Personal Info Inputs
    $last_name = $_POST['lName'];
    $first_name = $_POST['fName'];
    $mid_name = $_POST['mName'];
    $email = $_POST['emailAddress'];
    $presentAddress = $_POST['presentAddress'];
    $permanentAddress = $_POST['permanentAddress'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $birthDate = $_POST['birthDate'];
    $gender = $_POST['gender'];
    $sssNumber = $_POST['sssNumber'];
    $philhealthNumber = $_POST['philhealthNumber'];
    $pagibigNumber = $_POST['pagibigNumber'];
    $tinNumber = $_POST['tinNumber'];
    $contactNumber = $_POST['contactNumber'];
    $civilStatus = $_POST['civilStatus'];


    $stmt = $conn->prepare('SELECT * FROM user_resumes WHERE user_id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if there's an uploaded image
    if (isset ($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Generate a unique filename for the new image
        $uniqueFilename = uniqid() . '_' . $_FILES["image"]["name"];
        $targetFile = "./img/applicant/" . $uniqueFilename;

        // Delete previous image file if it exists
        if (!empty ($row['picture'])) {
            $previousImage = "./img/applicant/" . $row['picture'];
            if (file_exists($previousImage)) {
                unlink($previousImage);
            }
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imageData = $uniqueFilename; // Store the unique filename in the database
        } else {
            echo "Sorry, there was an error uploading your file.";
            return; // Stop execution if file upload fails
        }
    } else {
        $imageData = ""; // No image uploaded
    }

    if ($result->num_rows > 0) {

        if (empty ($imageData)) {
            //If image input is empty or user did not want to change his picture
            $stmt = $conn->prepare("UPDATE user_resumes SET 
                email = ?,
                last_name = ?,
                first_name = ?,
                middle_name = ?,
                present_address = ?,
                permanent_address = ?,
                birthdate = ?,
                gender = ?,
                height = ?,
                weight = ?,
                nationality = ?,
                religion = ?,
                civil_status = ?,
                sss_number = ?,
                pagibig_number = ?,
                philhealth_number = ?,
                tin_number = ?,
                contact_number = ?
                WHERE user_id = ?"
            );

            // Bind parameters
            $stmt->bind_param(
                'ssssssssssssssssssi',
                $email,
                $last_name,
                $first_name,
                $mid_name,
                $presentAddress,
                $permanentAddress,
                $birthDate,
                $gender,
                $height,
                $weight,
                $nationality,
                $religion,
                $civilStatus,
                $sssNumber,
                $pagibigNumber,
                $philhealthNumber,
                $tinNumber,
                $contactNumber,
                $userId
            );
        } else {
            //Update if it already exist on user_resumes table and update the picture
            $stmt = $conn->prepare("UPDATE user_resumes SET 
            picture = ?,
            email = ?,
            last_name = ?,
            first_name = ?,
            middle_name = ?,
            present_address = ?,
            permanent_address = ?,
            birthdate = ?,
            gender = ?,
            height = ?,
            weight = ?,
            nationality = ?,
            religion = ?,
            civil_status = ?,
            sss_number = ?,
            pagibig_number = ?,
            philhealth_number = ?,
            tin_number = ?,
            contact_number = ?
            WHERE user_id = ?"
            );
            $stmt->bind_param(
                'sssssssssssssssssssi',
                $imageData,
                $email,
                $last_name,
                $first_name,
                $mid_name,
                $presentAddress,
                $permanentAddress,
                $birthDate,
                $gender,
                $height,
                $weight,
                $nationality,
                $religion,
                $civilStatus,
                $sssNumber,
                $pagibigNumber,
                $philhealthNumber,
                $tinNumber,
                $contactNumber,
                $userId
            );
        }

    } else {
        // Insert personal info into the user_resumes table if user still not have uploaded a resume
        $stmt = $conn->prepare('INSERT INTO user_resumes (user_id, picture, email, last_name, first_name, middle_name,  present_address, permanent_address, birthdate, gender, height, weight, nationality, religion, civil_status,  sss_number, pagibig_number, philhealth_number,  tin_number, contact_number) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'isssssssssssssssssss',
            $userId,
            $imageData,
            $email,
            $last_name,
            $first_name,
            $mid_name,
            $presentAddress,
            $permanentAddress,
            $birthDate,
            $gender,
            $height,
            $weight,
            $nationality,
            $religion,
            $civilStatus,
            $sssNumber,
            $pagibigNumber,
            $philhealthNumber,
            $tinNumber,
            $contactNumber
        );

    }

    $stmt->execute();

    // Prepare a SQL statement to update the reference column for the user's resume
    if (isset ($_POST['source']) && !empty ($_POST['source'])) {
        // Concatenate the selected checkboxes and referral name (if provided)
        $reference = implode(', ', $_POST['source']);
        if (isset ($_POST['referralName'])) {
            $reference .= ': ' . $_POST['referralName'];
        }

        // Update the reference column
        $stmt = $conn->prepare('UPDATE user_resumes SET reference = ? WHERE user_id = ?');
        $stmt->bind_param('si', $reference, $userId);
        $stmt->execute();
        $stmt->close();
    }

    //Additional Info Inputs
    $addInfoFirstQuestion = $_POST['addInfoFirstQuestion'];
    $addInfoSecondQuestion = $_POST['addInfoSecondQuestion'];

    //Declaration checkbox
    $declaration = $_POST['declaration'];

    //Authority to Process and Disclosure of Information Input


    if (isset ($_FILES["applicantSignature"]) && $_FILES["applicantSignature"]["error"] == 0) {
        // Generate a unique filename
        $uniqueFilename = uniqid() . '_' . $_FILES["applicantSignature"]["name"];
        $targetFile = "./img/esignature/" . $uniqueFilename;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["applicantSignature"]["tmp_name"], $targetFile)) {
            $applicantSignature = $uniqueFilename; // Store the unique filename in the database
        } else {
            echo "Sorry, there was an error uploading your file.";
            return; // Stop execution if file upload fails
        }
    } else {
        $applicantSignature = ""; // No image uploaded
    }

    $stmt = $conn->prepare('UPDATE user_resumes SET additional_info_q1 = ?, additional_info_q2 = ?, declaration = ?, authorization = ? WHERE user_id = ?');
    $stmt->bind_param('ssssi', $addInfoFirstQuestion, $addInfoSecondQuestion, $declaration, $applicantSignature, $userId);
    $stmt->execute();
}

function educationAttainment($conn)
{
    $userId = $_SESSION['user_id'];

    //Educational Attainment Inputs
    $college = $_POST['college'];
    $degree = $_POST['degree'];
    $eduCollegeFromDate = $_POST['eduCollegeFromDate'];
    $eduCollegeToDate = $_POST['eduCollegeToDate'];

    $vocational = $_POST['vocational'];
    $diploma = $_POST['diploma'];
    $eduVocationalFromDate = $_POST['eduVocationalFromDate'];
    $eduVocationalToDate = $_POST['eduVocationalToDate'];

    $highSchool = $_POST['highSchool'];
    $highSchoolLevel = $_POST['highSchoolLevel'];
    $eduHighSchoolFromDate = $_POST['eduHighSchoolFromDate'];
    $eduHighSchoolToDate = $_POST['eduHighSchoolToDate'];

    $elementary = $_POST['elementary'];
    $elementaryLevel = $_POST['elementaryLevel'];
    $eduElementaryFromDate = $_POST['eduElementaryFromDate'];
    $eduElementaryToDate = $_POST['eduElementaryToDate'];


    $stmt = $conn->prepare('SELECT * FROM educational_attainment WHERE user_id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update if user already has data in the educational_attainment table
        $stmt = $conn->prepare("UPDATE educational_attainment SET 
            college = ?,
            college_from = ?,
            college_to = ?,
            college_degree = ?,
            vocational = ?,
            vocational_from = ?,
            vocational_to = ?,
            vocational_diploma = ?,
            high_school = ?,
            high_school_from = ?,
            high_school_to = ?,
            high_school_level = ?,
            elementary = ?,
            elementary_from = ?,
            elementary_to = ?,
            elementary_level = ?
            WHERE user_id = ?"
        );
        $stmt->bind_param(
            'ssssssssssssssssi',
            $college,
            $eduCollegeFromDate,
            $eduCollegeToDate,
            $degree,
            $vocational,
            $eduVocationalFromDate,
            $eduVocationalToDate,
            $diploma,
            $highSchool,
            $eduHighSchoolFromDate,
            $eduHighSchoolToDate,
            $highSchoolLevel,
            $elementary,
            $eduElementaryFromDate,
            $eduElementaryToDate,
            $elementaryLevel,
            $userId
        );
    } else {
        $stmt = $conn->prepare('INSERT INTO educational_attainment (user_id, college, college_from, college_to, college_degree, vocational, vocational_from, vocational_to, vocational_diploma, high_school, high_school_from, high_school_to, high_school_level, elementary, elementary_from, elementary_to, elementary_level) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issssssssssssssss', $userId, $college, $eduCollegeFromDate, $eduCollegeToDate, $degree, $vocational, $eduVocationalFromDate, $eduVocationalToDate, $diploma, $highSchool, $eduHighSchoolFromDate, $eduHighSchoolToDate, $highSchoolLevel, $elementary, $eduElementaryFromDate, $eduElementaryToDate, $elementaryLevel);

    }

    $stmt->execute();
}

function employmentBackground($conn)
{
    $userId = $_SESSION['user_id'];
    $default = null;

    // Employment Background Inputs
    $company1 = isset ($_POST['company1']) ? $_POST['company1'] : $default;
    $position1 = isset ($_POST['position1']) ? $_POST['position1'] : $default;
    $empBgFromDate1 = isset ($_POST['empBgFromDate1']) ? $_POST['empBgFromDate1'] : $default;
    $empBgToDate1 = isset ($_POST['empBgToDate1']) ? $_POST['empBgToDate1'] : $default;
    $status1 = isset ($_POST['status1']) ? $_POST['status1'] : $default;
    $responsibilities1 = isset ($_POST['responsibilities1']) ? $_POST['responsibilities1'] : $default;
    $reason1 = isset ($_POST['reason1']) ? $_POST['reason1'] : $default;
    $lastSalary1 = isset ($_POST['lastSalary1']) ? $_POST['lastSalary1'] : $default;

    $company2 = isset ($_POST['company2']) ? $_POST['company2'] : $default;
    $position2 = isset ($_POST['position2']) ? $_POST['position2'] : $default;
    $empBgFromDate2 = isset ($_POST['empBgFromDate2']) ? $_POST['empBgFromDate2'] : $default;
    $empBgToDate2 = isset ($_POST['empBgToDate2']) ? $_POST['empBgToDate2'] : $default;
    $status2 = isset ($_POST['status2']) ? $_POST['status2'] : $default;
    $responsibilities2 = isset ($_POST['responsibilities2']) ? $_POST['responsibilities2'] : $default;
    $reason2 = isset ($_POST['reason2']) ? $_POST['reason2'] : $default;
    $lastSalary2 = isset ($_POST['lastSalary2']) ? $_POST['lastSalary2'] : $default;

    $company3 = isset ($_POST['company3']) ? $_POST['company3'] : $default;
    $position3 = isset ($_POST['position3']) ? $_POST['position3'] : $default;
    $empBgFromDate3 = isset ($_POST['empBgFromDate3']) ? $_POST['empBgFromDate3'] : $default;
    $empBgToDate3 = isset ($_POST['empBgToDate3']) ? $_POST['empBgToDate3'] : $default;
    $status3 = isset ($_POST['status3']) ? $_POST['status3'] : $default;
    $responsibilities3 = isset ($_POST['responsibilities3']) ? $_POST['responsibilities3'] : $default;
    $reason3 = isset ($_POST['reason3']) ? $_POST['reason3'] : $default;
    $lastSalary3 = isset ($_POST['lastSalary3']) ? $_POST['lastSalary3'] : $default;

    //Recent Employment Inputs
    $recentEmpContactPerson = isset ($_POST['recentEmpContactPerson']) ? $_POST['recentEmpContactPerson'] : $default;
    $recentEmpPosition = isset ($_POST['recentEmpPosition']) ? $_POST['recentEmpPosition'] : $default;
    $recentEmpContactNum = isset ($_POST['recentEmpContactNum']) ? $_POST['recentEmpContactNum'] : $default;

    $stmt = $conn->prepare('SELECT * FROM employment_background WHERE user_id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update if user already has data in the employment_background table
        $stmt = $conn->prepare("UPDATE employment_background SET 
            company_one = ?,
            company_one_position = ?,
            company_one_from = ?,
            company_one_to = ?,
            company_one_status = ?,
            company_one_responsibilities = ?,
            company_one_reason_for_leaving = ?,
            company_one_last_salary = ?,
            company_two = ?,
            company_two_position = ?,
            company_two_from = ?,
            company_two_to = ?,
            company_two_status = ?,
            company_two_responsibilities = ?,
            company_two_reason_for_leaving = ?,
            company_two_last_salary = ?,
            company_three = ?,
            company_three_position = ?,
            company_three_from = ?,
            company_three_to = ?,
            company_three_status = ?,
            company_three_responsibilities = ?,
            company_three_reason_for_leaving = ?,
            company_three_last_salary = ?,
            recent_employment_contact_person = ?,
            recent_employment_position = ?,
            recent_employment_contact_number = ?
            WHERE user_id = ?"
        );
        $stmt->bind_param(
            'sssssssssssssssssssssssssssi',
            $company1,
            $position1,
            $empBgFromDate1,
            $empBgToDate1,
            $status1,
            $responsibilities1,
            $reason1,
            $lastSalary1,
            $company2,
            $position2,
            $empBgFromDate2,
            $empBgToDate2,
            $status2,
            $responsibilities2,
            $reason2,
            $lastSalary2,
            $company3,
            $position3,
            $empBgFromDate3,
            $empBgToDate3,
            $status3,
            $responsibilities3,
            $reason3,
            $lastSalary3,
            $recentEmpContactPerson,
            $recentEmpPosition,
            $recentEmpContactNum,
            $userId
        );
    } else {
        // Insert new record if user doesn't have data in employment_background table
        $stmt = $conn->prepare('INSERT INTO employment_background (user_id, company_one, company_one_position, company_one_from, company_one_to, company_one_status, company_one_responsibilities, company_one_reason_for_leaving, company_one_last_salary, company_two, company_two_position, company_two_from, company_two_to, company_two_status, company_two_responsibilities, company_two_reason_for_leaving, company_two_last_salary, company_three, company_three_position, company_three_from, company_three_to, company_three_status, company_three_responsibilities, company_three_reason_for_leaving, company_three_last_salary, recent_employment_contact_person, recent_employment_position, recent_employment_contact_number) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'isssssssssssssssssssssssssss',
            $userId,
            $company1,
            $position1,
            $empBgFromDate1,
            $empBgToDate1,
            $status1,
            $responsibilities1,
            $reason1,
            $lastSalary1,
            $company2,
            $position2,
            $empBgFromDate2,
            $empBgToDate2,
            $status2,
            $responsibilities2,
            $reason2,
            $lastSalary2,
            $company3,
            $position3,
            $empBgFromDate3,
            $empBgToDate3,
            $status3,
            $responsibilities3,
            $reason3,
            $lastSalary3,
            $recentEmpContactPerson,
            $recentEmpPosition,
            $recentEmpContactNum
        );
    }

    $stmt->execute();
}

function lecturesAndSeminar($conn)
{
    $userId = $_SESSION['user_id'];
    $default = null;


    $seminarTitle1 = isset ($_POST['seminarTitle1']) ? $_POST['seminarTitle1'] : $default;
    $seminarVenue1 = isset ($_POST['seminarVenue1']) ? $_POST['seminarVenue1'] : $default;
    $seminarFromDate1 = isset ($_POST['seminarFromDate1']) ? $_POST['seminarFromDate1'] : $default;
    $seminarToDate1 = isset ($_POST['seminarToDate1']) ? $_POST['seminarToDate1'] : $default;


    $seminarTitle2 = isset ($_POST['seminarTitle2']) ? $_POST['seminarTitle2'] : $default;
    $seminarVenue2 = isset ($_POST['seminarVenue2']) ? $_POST['seminarVenue2'] : $default;
    $seminarFromDate2 = isset ($_POST['seminarFromDate2']) ? $_POST['seminarFromDate2'] : $default;
    $seminarToDate2 = isset ($_POST['seminarToDate2']) ? $_POST['seminarToDate2'] : $default;

    $seminarTitle3 = isset ($_POST['seminarTitle3']) ? $_POST['seminarTitle3'] : $default;
    $seminarVenue3 = isset ($_POST['seminarVenue3']) ? $_POST['seminarVenue3'] : $default;
    $seminarFromDate3 = isset ($_POST['seminarFromDate2']) ? $_POST['seminarFromDate3'] : $default;
    $seminarToDate3 = isset ($_POST['seminarToDate2']) ? $_POST['seminarToDate3'] : $default;

    $stmt = $conn->prepare('SELECT * FROM lectures_and_seminars_attended WHERE user_id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update if user already has data in the lectures_and_seminars_attended table
        $stmt = $conn->prepare("UPDATE lectures_and_seminars_attended SET 
            title_one = ?,
            title_one_from = ?,
            title_one_to = ?,
            title_one_venue = ?,
            title_two = ?,
            title_two_from = ?,
            title_two_to = ?,
            title_two_venue = ?,
            title_three = ?,
            title_three_from = ?,
            title_three_to = ?,
            title_three_venue = ?
            WHERE user_id = ?"
        );
        $stmt->bind_param(
            'ssssssssssssi',
            $seminarTitle1,
            $seminarFromDate1,
            $seminarToDate1,
            $seminarVenue1,
            $seminarTitle2,
            $seminarFromDate2,
            $seminarToDate2,
            $seminarVenue2,
            $seminarTitle3,
            $seminarFromDate3,
            $seminarToDate3,
            $seminarVenue3,
            $userId
        );
    } else {
        $stmt = $conn->prepare('INSERT INTO lectures_and_seminars_attended (
            user_id,	
            title_one,
            title_one_from,
            title_one_to,	
            title_one_venue,	
            title_two,	
            title_two_from,	
            title_two_to,	
            title_two_venue,	
            title_three,	
            title_three_from,	
            title_three_to,	
            title_three_venue
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'issssssssssss',
            $userId,
            $seminarTitle1,
            $seminarVenue1,
            $seminarFromDate1,
            $seminarToDate1,
            $seminarTitle2,
            $seminarVenue2,
            $seminarFromDate2,
            $seminarToDate2,
            $seminarTitle3,
            $seminarVenue3,
            $seminarFromDate3,
            $seminarToDate3
        );

    }


    $stmt->execute();


}

function characterReference($conn)
{
    $userId = $_SESSION['user_id'];
    $default = null;


    $charRefName1 = isset ($_POST['charRefName1']) ? $_POST['charRefName1'] : $default;
    $charRefPosition1 = isset ($_POST['charRefPosition1']) ? $_POST['charRefPosition1'] : $default;
    $charRefCompany1 = isset ($_POST['charRefCompany1']) ? $_POST['charRefCompany1'] : $default;
    $charRefContactNum1 = isset ($_POST['charRefContactNum1']) ? $_POST['charRefContactNum1'] : $default;

    $charRefName2 = isset ($_POST['charRefName2']) ? $_POST['charRefName2'] : $default;
    $charRefPosition2 = isset ($_POST['charRefPosition2']) ? $_POST['charRefPosition2'] : $default;
    $charRefCompany2 = isset ($_POST['charRefCompany2']) ? $_POST['charRefCompany2'] : $default;
    $charRefContactNum2 = isset ($_POST['charRefContactNum2']) ? $_POST['charRefContactNum2'] : $default;


    $stmt = $conn->prepare('SELECT * FROM character_references WHERE user_id = ?');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update if user already has data in the character_references table
        $stmt = $conn->prepare("UPDATE character_references SET 
            name_one = ?,
            name_one_position = ?,
            name_one_company = ?,
            name_one_contact_number = ?,
            name_two = ?,
            name_two_position = ?,
            name_two_company = ?,
            name_two_contact_number = ?
            WHERE user_id = ?"
        );

        $stmt->bind_param(
            "ssssssssi",
            $charRefName1,
            $charRefPosition1,
            $charRefCompany1,
            $charRefContactNum1,
            $charRefName2,
            $charRefPosition2,
            $charRefCompany2,
            $charRefContactNum2,
            $userId
        );
    } else {
        // Insert new record if user doesn't have data in character_references table
        $stmt = $conn->prepare("INSERT INTO character_references (
            user_id, 
            name_one, 
            name_one_position, 
            name_one_company, 
            name_one_contact_number, 
            name_two, 
            name_two_position, 
            name_two_company, 
            name_two_contact_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "isssssssi",
            $userId,
            $charRefName1,
            $charRefPosition1,
            $charRefCompany1,
            $charRefContactNum1,
            $charRefName2,
            $charRefPosition2,
            $charRefCompany2,
            $charRefContactNum2
        );
    }

    $stmt->execute();
}


?>