<?php
session_start();
include ("dbconn.php");

$emailInput = null;
$passwordInput = null;
$errors[] = null;

//User wont be able to access login page when logged in
// Check if user is not logged in
if (isset($_SESSION['user_id']) || isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: /recruitment/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"];

    $query = "SELECT * FROM user WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($row['verify_status'] == 1) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['user_resume'] = $row['resume'];

                // Redirect based on user role
                if ($_SESSION['user_role'] !== 'user') {
                    header("Location: /recruitment/admin/home.php");
                    exit();
                } else {
                    header("Location: /recruitment/index.php");
                    exit();
                }
            } else {
                $errors['password'] = "Wrong password.";
                $emailInput = $email;
            }
        } else {
            $errors['email'] = "Email is not verified. Please verify your email.";
        }

    } else {
        $errors['email'] = "Wrong email input.";
    }
}

?>