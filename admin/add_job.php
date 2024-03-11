<?php
include('../header.php');
include('../dbconn.php');

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect non-admin users to index.php
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow">
                <?php include("../admin/admin_sidebar.php"); ?>
            </div>

            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Add Job</h4>
            </div>
        </div>
    </div>
</body>

</html>

<?php include('../footer.php'); ?>