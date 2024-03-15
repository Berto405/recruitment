<?php
include("header.php");
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
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4">
                    <h2>Add your resume</h2>
                </div>
                <div class="card-body">
                    <form action="upload_resume_process.php" method="POST" enctype="multipart/form-data">
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <?php
                                if ($row['resume']) {
                                    echo '
                                        <h5>Current Resume:</h5>
                                        <input type="text" class="form-control" value="' . $row['resume'] . '" readonly>
                                        <h5 class="mt-2">Update Resume:</h5>
                                        <input type="hidden" class="form-control" name="name" required>
                                        <input type="file" class="form-control" name="resume_file" accept=".pdf" required>
                                   ';
                                } else {
                                    echo '
                                        
                                        <input type="hidden" class="form-control" name="name" required>
                                        <input type="file" class="form-control" name="resume_file" accept=".pdf" required>
                                    ';
                                }
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
                            <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light" type="submit"
                                name="submit">
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
<?php include('footer.php'); ?>