<?php
include ('register_process.php');
$pageTitle = "Register";
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
                        <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Register an account</h2>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- First Name -->
                                    <div class="mb-2 form-floating">
                                        <input type="text" id="first_name"
                                            class="form-control <?php echo isset($errors['fName']) ? 'border border-danger' : ''; ?>"
                                            placeholder="First Name" name="fName"
                                            value="<?php echo isset($inputs['fName']) ? $inputs['fName'] : ''; ?>">
                                        <label for="first_name">First Name</label>
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
                                    <div class="mb-2 form-floating">
                                        <input type="text" id="last_name"
                                            class="form-control <?php echo isset($errors['lName']) ? 'border border-danger' : ''; ?>"
                                            placeholder="Last Name" name="lName"
                                            value="<?php echo isset($inputs['lName']) ? $inputs['lName'] : '' ?>">
                                        <label for="last_name">Last Name</label>
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
                                <!-- Address -->
                                <div class="mb-2 form-floating">
                                    <textarea id="address"
                                        class="form-control <?php echo isset($errors['address']) ? 'border border-danger' : ''; ?>"
                                        placeholder="Address" name="address"
                                        style="height: 100px"><?php echo isset($inputs['address']) ? $inputs['address'] : '' ?></textarea>
                                    <label for="address">Address</label>
                                    <div class="text-danger">
                                        <small>
                                            <?php echo isset($errors['address']) ? $errors['address'] : ''; ?>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col w-100">
                                <!-- Email -->
                                <div class="mb-2 form-floating">
                                    <input type="email" id="email"
                                        class="form-control  <?php echo isset($errors['email']) ? 'border border-danger' : ''; ?>"
                                        placeholder="Email" name="email"
                                        value="<?php echo isset($inputs['email']) ? $inputs['email'] : '' ?>">
                                    <label for="email">Email</label>
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
                                <div class="mb-2 form-floating">
                                    <input type="password" id="password"
                                        class="form-control <?php echo isset($errors['password']) ? 'border border-danger' : ''; ?>"
                                        placeholder="Password" name="password"
                                        value="<?php echo isset($inputs['password']) ? $inputs['password'] : '' ?>">
                                    <label for="password">Password</label>
                                    <div class="text-danger">
                                        <small>
                                            <?php echo isset($errors['password']) ? $errors['password'] : ''; ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col w-100">
                                <!-- Confirm Password -->
                                <div class="mb-2 form-floating">
                                    <input type="password" id="confirmPassword"
                                        class="form-control <?php echo isset($errors['confirmPassword']) ? 'border border-danger' : ''; ?>"
                                        placeholder="Confirm Password" name="confirmPassword"
                                        value="<?php echo isset($inputs['confirmPassword']) ? $inputs['confirmPassword'] : '' ?>">
                                    <label for="confirmPassword">Confirm Password</label>
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
                                <small>Have an account? <a href="login.php" class="text-decoration-none">Sign
                                        in</a>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include ('components/footer.php'); ?>