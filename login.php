<?php
include ("login_process.php");
include ('components/header.php');

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
                    <form action="" method="POST">
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <label for="email" class="form-label mt-3">Email</label>
                                <input type="email"
                                    class="form-control bg-transparent <?php echo isset($errors['email']) ? 'border border-danger' : ''; ?>"
                                    id="email" placeholder="Email" name="email"
                                    value="<?php echo isset($inputs['email']) ? $inputs['email'] : '' ?>">
                                <div class="text-danger">
                                    <small>
                                        <?php
                                        echo isset($errors['email']) ? $errors['email'] : '';
                                        ?>
                                    </small>
                                </div>
                            </div>

                        </div>
                        <div class="col w-100 ">
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password "
                                    class="form-control bg-transparent <?php echo isset($errors['password']) ? 'border border-danger' : ''; ?>"
                                    placeholder="Password" name="password">
                                <div class="text-danger">
                                    <small>
                                        <?php
                                        echo isset($errors['password']) ? $errors['password'] : '';
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </div>


                        <div class="mb-2 d-flex justify-content-center mt-3">
                            <button class="btn btn-danger btn-fluid rounded-1 w-100 text-light" type="submit">
                                Login
                            </button>
                        </div>
                        <div class="text-center mb-2">
                            <small>
                                Don't have account?
                                <a href="register.php" class="text-decoration-none">
                                    Sign up
                                </a>
                            </small>
                        </div>
                        <div class="text-center">
                            <small>
                                Doesn't received email verification?
                                <a href="resend_verify_email.php" class="text-decoration-none">
                                    Resend
                                </a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php include ('components/footer.php'); ?>