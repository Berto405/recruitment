<?php
include("dbconn.php");
include("header.php");

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
} else {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4 text-dark fw-bold">
                    <h2>Profile</h2>
                </div>
                <div class="card-body">
                    <h2>
                        <?php echo $row['name']; ?>
                    </h2>

                    <i class="bi bi-envelope-fill">
                        <?php echo $row['email']; ?>
                    </i>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="col w-100 mt-3">
                            <div class="mb-2">
                                <h4>Resume</h4>
                                <?php
                                if ($row['resume']) {
                                    echo $row['resume'];
                                } else {
                                    echo '
                                    <div class="">
                                        <small>
                                            *Your resume is required to apply for jobs. Please upload it now to get started.
                                        </small>
                                    </div>
                                    <div>
                                        <a href="/recruitment/upload_resume.php" class="btn btn-outline-danger">
                                            Upload Resume
                                        </a>
                                    </div>
                                    ';
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>