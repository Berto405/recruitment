<?php
include('dbconn.php');
include('header.php');
//User wont be able to access login page when logged in
// Check if user is not logged in
if (isset($_SESSION['user_id']) || isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: /recruitment/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4">
                    <h2>LOGIN</h2>
                </div>
                <div class="card-body">
                    <form action="login_process.php" method="POST">
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <label for="email" class="form-label mt-3">Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email" required>
                            </div>
                        </div>
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-1 border rounded">
                            <input type="password" id="password" class="form-control bg-transparent border-0"
                                placeholder="Password" name="password" required>
                        </div>
                        <!-- Error message -->
                        <?php if (isset($_GET['error'])) { ?>
                            <p class="text-danger">
                                <?php echo $_GET['error']; ?>
                            </p>
                        <?php } ?>
                        <div class="mb-1 d-flex justify-content-center mt-3">
                            <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light"
                                style="background-color: #8b0000; border-color: #8b0000;" type="submit">
                                Login
                            </button>
                        </div>
                        <div class="text-center">
                            <small>Don't have account? <a href="register.php" class="text-decoration-none">Sign
                                    up</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php include('footer.php'); ?>