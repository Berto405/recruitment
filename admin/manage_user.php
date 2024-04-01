<?php
include ('../admin/manage_user_process.php');

// Check if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: ../login.php");
    exit();
}

// Check if user is not super admin
if ($_SESSION['user_role'] !== 'Super Admin') {
    // Redirect non-super admin users to index.php
    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: ../index.php");
    exit();
}
$query = "SELECT * FROM user WHERE role != ?";
$role = "user";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $role);
$stmt->execute();
$result = $stmt->get_result();




//Puts here to prevent ERROR: Cannot modify header information - headers already sent by..
include ('../components/header.php');
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
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-2 bg-white  p-0 m-0 d-lg-block shadow" style="min-height: 91vh;">
                <?php include ("../admin/admin_sidebar.php"); ?>
            </div>
            <div class="col-md-10 col-lg-9 col-xl-10  mt-3 ">
                <h4 class=" mt-1 mb-5 ">Manage Users</h4>
                <div class="row">
                    <div class="col-md-6 col-lg-9">
                        <div class="float-start mb-2">
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                data-bs-target="#addUserModal" style="border-radius: 0;">
                                <i class="bi bi-person-plus"></i> Add Employee
                            </button>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table id="employeeTable" class="table text-center table-hover bg-white border">
                        <thead class="table-danger">
                            <tr>
                                <th class="bg-danger text-white">Name</th>
                                <th class="bg-danger text-white">Email</th>
                                <th class="bg-danger text-white">Role</th>
                                <th class="bg-danger text-white">Branch</th>
                                <th class="bg-danger text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody style="margin-bottom: 10px;">
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                // Check if the row corresponds to the currently logged-in user
                                $loggedInUserId = $_SESSION['user_id'];
                                $highlightClass = ($loggedInUserId == $row['id']) ? 'table-danger' : '';
                                $disableAction = ($loggedInUserId == $row['id']) ? 'disabled' : '';
                                ?>
                                <tr>
                                    <td class="<?php echo $highlightClass; ?>">
                                        <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                    </td>
                                    <td class="<?php echo $highlightClass; ?>">
                                        <?php echo $row['email']; ?>
                                    </td>
                                    <td class="<?php echo $highlightClass; ?>">
                                        <?php echo $row['role']; ?>
                                    </td>
                                    <td class="<?php echo $highlightClass; ?>">
                                        <?php echo $row['branch']; ?>
                                    </td>
                                    <td class="<?php echo $highlightClass; ?>">
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <!-- Edit button -->
                                            <form>
                                                <button type="button" class="btn text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal<?php echo $row['id'] ?>" <?php echo $disableAction; ?>>
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </form>
                                            <!-- Delete button -->
                                            <form id="deleteEmpForm<?php echo $row['id'] ?>"
                                                action="manage_user_process.php" method="post">
                                                <input type="hidden" name="delete_emp_id" value="<?php echo $row['id']; ?>">
                                                <button type="button" class="btn text-danger"
                                                    onclick="confirmDelete(<?php echo $row['id']; ?>)" <?php echo $disableAction; ?>>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>


                                </tr>

                                <!-- Edit User Modal -->
                                <div class="modal fade" tabindex="-1" role="dialog"
                                    id="editUserModal<?php echo $row['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded-4 shadow">
                                            <div class="modal-header p-5 pb-4 border-bottom-0">
                                                <h1 class="fw-bold mb-0 fs-2">Edit Employee</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-5 pt-0">
                                                <form action="manage_user_process.php" method="POST" class="">
                                                    <div class="row">
                                                        <input type="hidden" class="form-control rounded-3"
                                                            placeholder="Juan" name="emp_id"
                                                            value="<?php echo $row['id'] ?>">
                                                        <div class="col">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3"
                                                                    placeholder="Juan" name="fName"
                                                                    value="<?php echo $row['first_name'] ?>" required>
                                                                <label for="floatingInput">First Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control rounded-3"
                                                                    placeholder="Cruz" name="lName"
                                                                    value="<?php echo $row['last_name'] ?>" required>
                                                                <label for="floatingInput">Last Name</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="email" class="form-control rounded-3"
                                                            placeholder="name@example.com" name="email"
                                                            value="<?php echo $row['email'] ?>" required>
                                                        <label for="floatingInput">Email address</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control rounded-3"
                                                            placeholder="Makati" name="branch"
                                                            value="<?php echo $row['branch'] ?>" required>
                                                        <label for="floatingInput">
                                                            Branch <span class="text-secondary">(City)</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" name="role" id="role" required>
                                                            <option <?php echo (empty($row['role']) ? 'selected' : ''); ?>
                                                                disabled>
                                                                Choose Role...
                                                            </option>
                                                            <option value="Super Admin" <?php echo (!empty($row['role']) && $row['role'] == 'Super Admin') ? 'selected' : ''; ?>>
                                                                Super Admin
                                                            </option>
                                                            <option value="Admin" <?php echo (!empty($row['role']) && $row['role'] == 'Admin') ? 'selected' : ''; ?>>
                                                                Admin
                                                            </option>
                                                            <option value="Employee" <?php echo (!empty($row['role']) && $row['role'] == 'Employee') ? 'selected' : ''; ?>>
                                                                Employee
                                                            </option>
                                                            <option value="Operations" <?php echo (!empty($row['role']) && $row['role'] == 'Operations') ? 'selected' : ''; ?>>
                                                                Operations
                                                            </option>
                                                        </select>
                                                        <label for="priority" class="form-label fw-bold">Role</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control rounded-3"
                                                            placeholder="Password" name="password">
                                                        <label for="floatingPassword">Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control rounded-3"
                                                            placeholder="Password" name="confirmPass">
                                                        <label for="floatingPassword">Confirm Password</label>
                                                    </div>
                                                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger"
                                                        name="editUserBtn" type="submit">
                                                        Submit
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>



            </div>


        </div>
    </div>


    <!-- Add User Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addUserModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Add Employee</h1>
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
                            <select class="form-select" name="role" id="role" required>
                                <option selected disabled>Choose Role...</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                                <option value="Employee">Employee</option>
                                <option value="Operations">Operations</option>
                            </select>
                            <label for="priority" class="form-label fw-bold">Role</label>
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
    <!-- DataTable JS - CDN Link -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>


    <script>
        $('#employeeTable').DataTable({
            language: {
                "search": "_INPUT_",
                "searchPlaceholder": "Search"
            }
        });


        function confirmDelete(emp_id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this account.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //If user clicked "Ok" button.
                        document.getElementById("deleteEmpForm" + emp_id).submit();
                    } else {
                        //If user clicked "Cancel" button.
                        return false;
                    }
                });
        }


    </script>


</body>

</html>

<?php include ('../components/footer.php'); ?>