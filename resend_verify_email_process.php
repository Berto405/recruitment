<?php
session_start();
include ('dbconn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//User wont be able to access login page when logged in
// Check if user is not logged in
if (isset($_SESSION['user_id']) || isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: /recruitment/index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['resendEmailBtn'])) {
        resendVerification($conn);
    }
}

function resendVerification($conn)
{
    $email = $_POST['email'];

    $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        //Checks if email is already verified or not
        if ($row['verify_status'] == 0) {

            $name = $row['first_name'] . ' ' . $row['last_name'];
            $email = $row['email'];
            $verify_token = $row['verify_token'];

            resendEmail($name, $email, $verify_token);

            $_SESSION['success_message'] = "Email Verification Link Sent.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error_message'] = "This email is already verified. Please login.";
            header("Location: login.php");
            exit();
        }

    } else {
        $_SESSION['error_message'] = "Email not found. Try again.";
        header("Location: resend_verify_email.php");
        exit();
    }
}

function resendEmail($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'recruittest2001@gmail.com';                     //SMTP username
    $mail->Password = 'cqog tevm ynnz fjim';                               //SMTP App password

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('recruittest2001@gmail.com', 'Topserve Recruitment');
    $mail->addAddress($email, $name);     //Add a recipient          


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Resend - Email Verification from Topserve Recruitment';

    $email_template = "
        <h2>You have registered with Topserve Recruitment</h2>
        <h5>Verify your email address to login with the below given link</h5>
        <br>
        <br>
        <a href='http://localhost/recruitment/verify_email.php?token=$verify_token'> Click Me </a>
        ";

    $mail->Body = $email_template;

    $mail->send();
}
?>