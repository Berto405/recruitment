<?php
session_start();
include ("dbconn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST['confirmPassword'];
    $verify_token = md5(rand());


    $checkQuery = "SELECT email FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['error_message'] = "Email already exist. Pick another.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();

    } else if ($password != $confirm_password) {

        $_SESSION['error_message'] = "Password does not match. Try again.";
        header("Location: register.php");
        exit();

    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role = "user";
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, role, verify_token) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fName, $lName, $email, $hashedPassword, $role, $verify_token);
        $result = $stmt->execute();

        if ($result) {
            $name = $fName . ' ' . $lName;
            send_email_verification($name, $email, $verify_token);


            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            unset($_SESSION['email']);
            unset($_SESSION['error']);

            $_SESSION['success_message'] = "Registration Success. Please verify your email address.";
            header("Location: login.php");
            exit();
        } else {
            header("Location: register.php?error=Invalid email or password");
            exit();
        }

    }
}

function send_email_verification($name, $email, $verify_token)
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
    $mail->Subject = 'Email Verification from Topserve Recruitment';

    $email_template = "
        <h2>You have registered with Topserve Recruitment</h2>
        <h5>Verify your email address to login with the below given link</h5>
        <br>
        <br>
        <a href='http://localhost/recruitment/verify_email.php?token=$verify_token'> Click Me </a>
        ";

    $mail->Body = $email_template;

    $mail->send();
    echo 'Message has been sent';

}
?>