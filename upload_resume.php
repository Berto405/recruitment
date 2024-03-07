<?php
include("header.php");
include("dbconn.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
} else {
    if (isset($_POST['submit'])) {
        $userId = $_SESSION['user_id'];

        // Check if a file is selected
        if (isset($_FILES['resume_file']['name']) && !empty($_FILES['resume_file']['name'])) {
            // Get file details
            $file_name = basename($_FILES['resume_file']['name']);
            $file_tmp = $_FILES['resume_file']['tmp_name'];
            $file_size = $_FILES['resume_file']['size'];

            // Check if the uploaded file is a PDF and the size is within limits (adjust as needed)
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_extensions = array("pdf");
            $max_file_size = 5 * 1024 * 1024; // 5 MB

            if (in_array($file_ext, $allowed_extensions) && $file_size <= $max_file_size) {
                // Move the uploaded file to the desired directory
                $upload_path = "./resume/";
                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                $file_destination = $upload_path . $file_name;
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    // Update the user's resume in the database
                    $query = "UPDATE `user` SET `resume`='$file_name' WHERE `id`='$userId'";
                    $result = mysqli_query($conn, $query);

                    header("Location: /recruitment/index.php?message=Resume Uploaded.");
                    exit();
                } else {
                    echo '<div class="alert alert-danger">Error uploading the file. Please try again.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">File must be uploaded in PDF format and should not exceed 5MB.</div>';
            }
        } else {
            // If no file is selected
            echo '<div class="alert alert-danger">Please select a file.</div>';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4">
                    <h2>Add your resume</h2>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <input type="hidden" class="form-control" name="name" required>
                                <input type="file" class="form-control" name="resume_file" accept=".pdf" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <small>
                                *Please note that only PDF file are accepted for resume. Ensure that your resume is in
                                PDF format before submitting.
                            </small>
                        </div>

                        <div class="mb-1 d-flex justify-content-center mt-3">
                            <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light"
                                style="background-color: #8b0000; border-color: #8b0000;" type="submit" name="submit">
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>