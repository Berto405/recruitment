<?php
session_start();
include ("../dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addUserBtn'])) {
        addUser($conn);
    }

    if (isset($_POST['editUserBtn'])) {
        editUser($conn);
    }

    if (isset($_POST['delete_emp_id'])) {
        deleteUser($conn);
    }
}

//FUNCTIONS HERE


function addUser($conn)
{
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST["email"];
    $branch = $_POST["branch"];
    $role = $_POST['role'];
    $password = $_POST["password"];
    $confirm_password = $_POST['confirmPass'];

    if ($password != $confirm_password) {

        header("Location: ../admin/manage_user.php");
        exit();

    } else {
        //Checks if there an industry access is checked
        if (isset($_POST['industry_access'])) {
            $industryAccess = implode(', ', $_POST['industry_access']);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, role, branch, industry_access) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $fName, $lName, $email, $hashedPassword, $role, $branch, $industryAccess);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Added User.";
                header("Location: ../admin/manage_user.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to Add User.";
                header("Location: ../admin/manage_user.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "No intustry selected. Try again.";
            header("Location: ../admin/manage_user.php");
            exit();
        }
    }

}

function editUser($conn)
{
    $emp_id = $_POST["emp_id"];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST["email"];
    $branch = $_POST["branch"];
    $password = $_POST["password"];
    $confirm_password = $_POST['confirmPass'];

    //If user does not want to edit password
    if (empty($password) || empty($confirm_password)) {
        //Checks if there an industry access is checked
        if (isset($_POST['industry_access'])) {
            $industryAccess = implode(', ', $_POST['industry_access']);

            $query = "UPDATE user 
            SET first_name = ?,
            last_name = ?,
            email = ?,
            branch = ?,
            industry_access = ?
            WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssi", $fName, $lName, $email, $branch, $industryAccess, $emp_id);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Updated Employee.";
                header("Location: ../admin/manage_user.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to Edit Employee.";
                header("Location: ../admin/manage_user.php");
                exit();
            }
        }

    } else {
        //If user wants to edit password

        if ($password != $confirm_password) {

            $_SESSION['error_message'] = "The passwords you've entered don't match. Try again.";
            header("Location: ../admin/manage_user.php");
            exit();

        } else {
            //Checks if there an industry access is checked
            if (isset($_POST['industry_access'])) {
                $industryAccess = implode(', ', $_POST['industry_access']);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $query = "UPDATE user 
                    SET first_name = ?,
                    last_name = ?,
                    email = ?,
                    branch = ?,
                    industry_access = ?,
                    password = ?
                    WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssssi", $fName, $lName, $email, $branch, $industryAccess, $hashedPassword, $emp_id);

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Updated Employee Account.";
                    header("Location: ../admin/manage_user.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Failed to Edit Employee Account.";
                    header("Location: ../admin/manage_user.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "No intustry selected. Try again.";
                header("Location: ../admin/manage_user.php");
                exit();
            }
        }
    }

}

function deleteUser($conn)
{
    $emp_id = $_POST['delete_emp_id'];

    $query = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $emp_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Deleted Employee Account.";
        header("Location: ../admin/manage_user.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to Delete Employee Account.";
        header("Location: ../admin/manage_user.php");
        exit();
    }
}

?>