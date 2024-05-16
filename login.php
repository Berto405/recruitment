<?php
include ("login_process.php");
$pageTitle = "Login";
include ('components/header.php');

?>

<section class="py-3 py-md-5">
    <div class="container ">
        <div class="row justify-content-center ">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="text-center mb-3">
                            <img src="img/images/topserveLogo.jpg" alt="Topserve Logo" width="150" height="50">
                        </div>
                        <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign in to your account</h2>
                        <form action="" method="POST">
                            <div class="row gy-2 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email"
                                            class="form-control bg-transparent <?php echo isset($errors['email']) ? 'border border-danger' : ''; ?>"
                                            id="email" placeholder="Email" name="email"
                                            value="<?php echo isset($inputs['email']) ? $inputs['email'] : '' ?>">

                                        <label for="email" class="form-label">Email</label>
                                        <div class="text-danger">
                                            <small>
                                                <?php
                                                echo isset($errors['email']) ? $errors['email'] : '';
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" id="password "
                                            class="form-control bg-transparent <?php echo isset($errors['password']) ? 'border border-danger' : ''; ?>"
                                            placeholder="Password" name="password">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="text-danger">
                                            <small>
                                                <?php
                                                echo isset($errors['password']) ? $errors['password'] : '';
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid my-3">
                                        <button class="btn btn-danger btn-lg" name="loginBtn" type="submit">
                                            Login
                                        </button>
                                    </div>
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

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include ('components/footer.php'); ?>