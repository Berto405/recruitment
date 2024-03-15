<?php
session_start();
include("dbconn.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
} else {
    $userId = $_SESSION['user_id'];

    //Showing current resume    
    $query = "SELECT resume FROM user WHERE id='$userId'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);

    //Uploading Resume
    if (isset($_POST['submit'])) {
        $userId = $_SESSION['user_id'];

        // Check if a file is selected
        if (isset($_FILES['resume_file']['name']) && !empty($_FILES['resume_file']['name'])) {
            // Get file details
            $file_name = basename($_FILES['resume_file']['name']);
            $file_tmp = $_FILES['resume_file']['tmp_name'];
            $file_size = $_FILES['resume_file']['size'];

            // Check if the uploaded file is a PDF and the size is within limits
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_extensions = array("pdf");
            $max_file_size = 5 * 1024 * 1024; // 5 MB

            if (in_array($file_ext, $allowed_extensions) && $file_size <= $max_file_size) {

                //Gets the previous resume and delete it.
                $delete_previous_resume_query = "SELECT resume FROM user WHERE id = '$userId'";
                $delete_result = mysqli_query($conn, $delete_previous_resume_query);
                $row = mysqli_fetch_assoc($delete_result);
                $previous_name = $row["resume"];
                if (!empty($previous_name)) {
                    $previous_resume_path = "./resume/" . $previous_name;
                    if (file_exists($previous_resume_path)) {
                        unlink($previous_resume_path);
                    }
                }
                //Generate a unique file name
                $unique_file_name = uniqid() . '_' . $file_name;

                // Move the uploaded file to the desired directory
                $upload_path = "./resume/";
                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                $file_destination = $upload_path . $unique_file_name;
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    // Update the user's resume in the database
                    $query = "UPDATE `user` SET `resume`='$unique_file_name' WHERE `id`='$userId'";
                    $result = mysqli_query($conn, $query);

                    $_SESSION['success_message'] = "Resume Uploaded";
                    header("Location: /recruitment/index.php");
                    exit();

                } else {
                    $_SESSION['error_message'] = "Resume Not Uploaded";
                    header("Location: /recruitment/index.php");
                    exit();
                }
            } else {

                $_SESSION['error_message'] = "File must be uploaded in PDF format and should not exceed 5MB.";
                header("Location: /recruitment/index.php");
                exit();
            }
        } else {
            // If no file is selected
            echo '<div class="alert alert-danger">Please select a file.</div>';
        }
    }
}
?>