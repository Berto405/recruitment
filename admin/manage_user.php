<?php
include ('../admin/admin_header.php');
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
                    <div class="col-md-6 col-lg-3">
                        <div class="float-end input-group mb-2">
                            <input id="searchInput" type="search" class="form-control" placeholder="Search Employee"
                                aria-label="Search" name="search" oninput="searchEmployees()">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table id="employeeTable" class="table text-center table-hover bg-white border">
                        <thead class="table-danger">
                            <tr>
                                <th class="bg-danger text-white">Name</th>
                                <th class="bg-danger text-white">Email</th>
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

    <script>
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

        //For search
        function searchEmployees() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("employeeTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>


</body>

</html>

<?php include ('../footer.php'); ?>