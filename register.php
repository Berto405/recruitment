<?php
session_start();
include ('header.php');
include ('dbconn.php');

//User wont be able to access register page when logged in
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
    <title>Register</title>
</head>

<body style="background-color: #F4F4F4; ">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="border-0 shadow bg-white" style="width: 30em;">
            <div class="card border-0 bg-transparent card_login">
                <div class="text-center mt-4">
                    <h2>REGISTER</h2>
                </div>
                <div class="card-body">
                    <form action="register_process.php" method="POST">

                        <div class="row">
                            <div class="col-md-6">
                                <!-- First Name -->
                                <div class="mb-2">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name" name="fName"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Last Name -->
                                <div class="mb-2">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name" name="lName"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col w-100">
                            <!-- Email -->
                            <div class="mb-2">
                                <label for="email" class="form-label mt-3">Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email" required>
                            </div>
                        </div>
                        <!-- Password -->
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-1 border rounded">
                            <input type="password" id="password" class="form-control bg-transparent border-0"
                                placeholder="Password" name="password" required>
                        </div>
                        <!-- Confirm Password -->
                        <label for="password" class="form-label">Confirm Password</label>
                        <div class="input-group mb-1 border rounded">
                            <input type="password" id="confirmPassword" class="form-control bg-transparent border-0"
                                placeholder="Confirm Password" name="confirmPassword" required>
                        </div>
                        <!-- Error message -->
                        <?php if (isset($_GET['error'])) { ?>
                            <p class="text-danger">
                                <?php echo $_GET['error']; ?>
                            </p>
                        <?php } ?>
                        <div class="mb-1 d-flex justify-content-center mt-3">
                            <button class="btn btn-danger rounded-1 w-100 text-light" type="submit">
                                Register
                            </button>
                        </div>
                        <div class="text-start my-2 ms-1">
                            <small>Have an account? <a href="login.php" class="text-decoration-none">Sign in</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>



<?php include ('footer.php'); ?>