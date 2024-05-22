<?php
include ("src/shared/backend/profile_process.php");
$pageTitle = "My Profile";

include ("components/header.php");
?>

<div class="container d-flex justify-content-center mt-5">
    <div class="row " style=" min-height: 60vh;">
        <div id="profile" class="col-md-10 shadow" style=" background-color: #ff6666;">
            <div class="text-center mt-4 text-dark fw-bold">
                <h2 class="">Profile</h2>
            </div>
            <div>
                <h4>
                    <?php echo $row['first_name']; ?>
                    <?php echo $row['last_name']; ?>
                </h4>

                <i class="bi bi-envelope-fill">
                    <?php echo $row['email']; ?>
                </i>

                <div class="col w-100 mt-3">
                    <div class="mb-2">
                        <h4>Resume</h4>

                        <?php
                        if ($row['resume']) {
                            echo '<i class="bi bi-file-earmark-fill">' . $row['resume'] . '</i>
                                    <a href="/recruitment/my_resume.php" class="btn btn-outline-dark mb-2 form-control mt-3" style="border-radius: 0;">
                                        Update Resume
                                    </a>';
                        } else {
                            echo '
                                <div class="">
                                    <small class="mb-2">
                                        *Your resume is required to apply for jobs. Please upload it now to get started.
                                    </small>
                                    
                                </div>
                                    <a href="/recruitment/my_resume.php" class="btn btn-outline-dark mb-2 form-control mt-3" style="border-radius: 0;">
                                        Create Resume
                                    </a>
                                ';
                        }
                        ?>
                        <button type="button" class="btn btn-outline-dark mb-2 form-control" style="border-radius: 0;"
                            onclick="toggleProfileEdit()">
                            Edit Profile
                        </button>
                        <button type="button" class="btn btn-outline-dark mb-2  form-control" style="border-radius: 0;"
                            onclick="toggleChangePass()">
                            Change Password
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Edit Profile Section - Initially Hidden -->
        <div id="profileEdit" class="col-md-7 shadow bg-white" style="display: none;">
            <div class="text-start mt-4 text-dark fw-bold">
                <h2>Edit Profile</h2>
            </div>
            <div class="container mt-3">
                <form action="/recruitment/profile_process.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- First Name -->
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" placeholder="First Name" name="newFName"
                                    value="<?php echo $row['first_name']; ?>" required>
                                <label class="form-label fw-bold">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Last Name -->
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" placeholder="Last Name" name="newLName"
                                    value="<?php echo $row['last_name']; ?>" required>
                                <label class="form-label fw-bold">Last Name</label>
                            </div>
                        </div>
                    </div>

                    <div class="col w-100">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="Email" name="newEmail"
                                value="<?php echo $row['email']; ?>" required>
                            <label class="form-label fw-bold">Email</label>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-center mt-3">
                        <button class="btn btn-danger rounded-1 w-100 text-light" type="submit"
                            name="editProfileButton">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Section - Initially Hidden -->
        <div id="changePass" class="col-md-7 shadow bg-white" style="display: none;">
            <div class="text-start mt-4 text-dark fw-bold">
                <h2>Change Password</h2>

            </div>
            <div class="container mt-3">
                <form action="/recruitment/profile_process.php" method="post">
                    <!-- Current Password -->
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control bg-transparent" placeholder="Current Password"
                            name="currentPassword" required>
                        <label for="currentPassword" class="form-label">Current Password</label>
                    </div>

                    <!-- New Password -->
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control bg-transparent " placeholder="New Password"
                            name="newPassword" required>

                        <label class="form-label ">New Password</label>
                    </div>
                    <!-- Confirm Password -->
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control bg-transparent " placeholder="Confirm New Password"
                            name="confirmNewPassword" required>

                        <label class="form-label">Confirm Password</label>
                    </div>
                    <div class="mb-3 d-flex justify-content-center mt-3">
                        <button class="btn btn-danger rounded-1 w-100 text-light" type="submit" name="changePassButton">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Showing and Hiding of Edit Profile and Change Password Sections -->
<script>
    function toggleProfileEdit() {
        var profileEditSection = document.getElementById('profileEdit');
        var changePassSection = document.getElementById('changePass');
        var profileSection = document.getElementById('profile');

        // Hide changePassSection if it's currently displayed
        if (changePassSection.style.display === 'block') {
            changePassSection.style.display = 'none';
            profileSection.classList.remove('col-md-5');
            profileSection.classList.add('col-md-10');
        }

        // Toggle display of profileEditSection
        if (profileEditSection.style.display === 'none') {
            profileEditSection.style.display = 'block';
            profileSection.classList.remove('col-md-10');
            profileSection.classList.add('col-md-5');
        } else {
            profileEditSection.style.display = 'none';
            profileSection.classList.remove('col-md-5');
            profileSection.classList.add('col-md-10');
        }
    }

    function toggleChangePass() {
        var changePassSection = document.getElementById('changePass');
        var profileEditSection = document.getElementById('profileEdit');
        var profileSection = document.getElementById('profile');

        // Hide profileEditSection if it's currently displayed
        if (profileEditSection.style.display === 'block') {
            profileEditSection.style.display = 'none';
            profileSection.classList.remove('col-md-5');
            profileSection.classList.add('col-md-10');
        }

        // Toggle display of changePassSection
        if (changePassSection.style.display === 'none') {
            changePassSection.style.display = 'block';
            profileSection.classList.remove('col-md-10');
            profileSection.classList.add('col-md-5');
        } else {
            changePassSection.style.display = 'none';
            profileSection.classList.remove('col-md-5');
            profileSection.classList.add('col-md-10');
        }
    }

</script>

<?php include ('components/footer.php'); ?>