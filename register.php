<?php
include ('register_process.php');
include ('components/header.php');

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
                    <form action="" method="POST">

                        <div class="row">
                            <div class="col-md-6">
                                <!-- First Name -->
                                <div class="mb-2">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text"
                                        class="form-control <?php echo isset($errors['fName']) ? 'border border-danger' : ''; ?>"
                                        placeholder="First Name" name="fName"
                                        value="<?php echo isset($inputs['fName']) ? $inputs['fName'] : ''; ?>">

                                    <div class="text-danger">
                                        <small>
                                            <?php
                                            echo isset($errors['fName']) ? $errors['fName'] : '';
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Last Name -->
                                <div class="mb-2">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text"
                                        class="form-control <?php echo isset($errors['lName']) ? 'border border-danger' : ''; ?>"
                                        placeholder="Last Name" name="lName"
                                        value="<?php echo isset($inputs['lName']) ? $inputs['lName'] : '' ?>">

                                    <div class="text-danger">
                                        <small>
                                            <?php
                                            echo isset($errors['lName']) ? $errors['lName'] : '';
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col w-100">
                            <!-- Email -->
                            <div class="mb-2">
                                <label for="email" class="form-label mt-3">Email</label>
                                <input type="email"
                                    class="form-control  <?php echo isset($errors['email']) ? 'border border-danger' : ''; ?>"
                                    placeholder="Email" name="email"
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
                        <div class="col w-100">
                            <!-- Password -->
                            <div class="mb-2">
                                <label for="password" class="form-label mt-3">Password</label>

                                <input type="password" id="password"
                                    class="form-control <?php echo isset($errors['password']) ? 'border border-danger' : ''; ?>"
                                    placeholder="Password" name="password"
                                    value="<?php echo isset($inputs['password']) ? $inputs['password'] : '' ?>">

                                <div class="text-danger">
                                    <small>
                                        <?php echo isset($errors['password']) ? $errors['password'] : ''; ?>
                                    </small>
                                </div>

                            </div>
                        </div>

                        <div class="col w-100">
                            <!-- Confirm Password -->
                            <div class="mb-2">
                                <label for="password" class="form-label">Confirm Password</label>

                                <input type="password" id="confirmPassword"
                                    class="form-control <?php echo isset($errors['confirmPassword']) ? 'border border-danger' : ''; ?>"
                                    placeholder="Confirm Password" name="confirmPassword"
                                    value="<?php echo isset($inputs['confirmPassword']) ? $inputs['confirmPassword'] : '' ?>">

                                <div class="text-danger">
                                    <small>
                                        <?php echo isset($errors['confirmPassword']) ? $errors['confirmPassword'] : ''; ?>
                                    </small>
                                </div>

                            </div>
                        </div>


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



<?php include ('components/footer.php'); ?>