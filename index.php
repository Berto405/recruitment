<?php include('header.php'); ?>
<?php include('dbconn.php'); ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="border-0 shadow bg-white" style="width: 30em;">
        <div class="card border-0 bg-transparent card_login">
            <div class="text-center mt-4">
                <h2>LOGIN</h2>
            </div>
            <div class="card-body">
                <form action="login.php" method="POST">
                    <div class="col w-100">
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
                        <button class="btn btn-fluid rounded-1 w-100 btn-primary text-light"
                            type="submit">Login</button>
                    </div>
                    <div class="text-center">
                        <small>Don't have account? <a href="register.php">Sign up</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>