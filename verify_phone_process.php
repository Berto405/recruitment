<?php
session_start();
include ("dbconn.php");

date_default_timezone_set('Asia/Manila');

if ($_SESSION['user_role'] !== 'user') {

    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM user_resumes WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['sentOtpBtn'])) {
        $phone = $row['contact_number'];
        $generateOtp = rand(100000, 999999);
        $timestamp = date('Y-m-d H:i:s'); // Get current datetime in the format required by DATETIME column

        $query = "UPDATE user_resumes SET otp = ?, otp_timestamp = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isi", $generateOtp, $timestamp, $userId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            //sendOTP($phone, $generateOtp);

            $_SESSION['success_message'] = "OTP Sent.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $_SESSION['error_message'] = "Phone number not found. Try again.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

    } else if (isset($_POST['validateBtn'])) {
        verifyOTP($conn);
    }

}

function sendOTP($phoneNumber, $otp)
{
    $ch = curl_init();
    $parameters = array(
        'apikey' => '915677606adb184be28e959a2f3dcfed', //API KEY
        'number' => $phoneNumber,
        'message' => 'Welcome to Topserve Recruitment. Your One Time Password is: {otp}. Please use it within 5 minutes.',
        'code' => $otp,
        'sendername' => 'Aquahub'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/otp');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    echo $output;
}


function verifyOTP($conn)
{
    $userId = $_SESSION['user_id'];
    $num1 = $_POST['firstNum'];
    $num2 = $_POST['secondNum'];
    $num3 = $_POST['thirdNum'];
    $num4 = $_POST['fourthNum'];
    $num5 = $_POST['fifthNum'];
    $num6 = $_POST['sixthNum'];

    $otpInputs = $num1 . $num2 . $num3 . $num4 . $num5 . $num6;

    $query = "SELECT otp FROM user_resumes WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['otp'] == $otpInputs) {
        $verified = 1;
        $otp = 0;
        $updateQuery = "UPDATE user_resumes SET phone_verified = ?, otp = ? WHERE user_id =?";
        $udpateStmt = $conn->prepare($updateQuery);
        $udpateStmt->bind_param("iii", $verified, $otp, $userId);
        $udpateStmt->execute();

        if ($udpateStmt->affected_rows > 0) {
            $_SESSION['success_message'] = "Phone number has been verified.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to verify phone number.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        $_SESSION['error_message'] = "OTP not match. Try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>