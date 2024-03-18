<?php
include ('../header.php');
include ('../dbconn.php');
// Check if user is not logged in
if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role'])) {
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


$query = "SELECT * FROM user WHERE role = ?";

$role = "admin";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $role);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

</head>

<body style="background-color: #F4F4F4; ">
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3">
                <h4 class=" mt-1 mb-5 ">Manage Users</h4>

                <div class="float-end mb-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"
                        style="border-radius: 0;">
                        <i class="bi bi-person-plus"></i> Add User
                    </button>

                </div>

                <table class="table text-center table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="margin-bottom: 10px;">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr class="rounded-1 left-border-danger ">
                                <td>
                                    <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['branch']; ?>
                                </td>
                                <td>
                                    <a href="#" class="text-decoration-none text-primary" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="" class="text-decoration-none text-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>


                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>


            </div>


        </div>
    </div>


    <!-- Add User Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addUserModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form action="manage_user_process.php" method="POST" class="">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" placeholder="Juan" name="fName">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" placeholder="Cruz" name="lName">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" placeholder="name@example.com"
                                name="email">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="Makati" name="branch">
                            <label for="floatingInput">Branch <span class="text-secondary">(City)</span></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" placeholder="Password"
                                name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" placeholder="Password"
                                name="confirmPass">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="addUserBtn"
                            type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editUserModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form action="manage_user_process.php" method="POST" class="">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" placeholder="Juan" name="fName">
                                    <label for="floatingInput">First Name</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" placeholder="Cruz" name="lName">
                                    <label for="floatingInput">Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" placeholder="name@example.com"
                                name="email">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" placeholder="Makati" name="branch">
                            <label for="floatingInput">Branch <span class="text-secondary">(City)</span></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" placeholder="Password"
                                name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" placeholder="Password"
                                name="confirmPass">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" name="addUserBtn"
                            type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php include ('../footer.php'); ?>