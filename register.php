<?php include('header.php'); ?>
<?php include('dbconn.php'); ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
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
                                <input type="text" class="form-control" placeholder="First Name" name="fName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Last Name -->
                            <div class="mb-2">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" placeholder="Last Name" name="lName" required>
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
                        <button class="btn btn-fluid rounded-1 w-100 btn-primary text-light"
                            type="submit">Register</button>
                    </div>
                    <div class="text-start my-2 ms-1">
                        <small>Have an account? <a href="index.php" class="text-decoration-none">Sign in</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>