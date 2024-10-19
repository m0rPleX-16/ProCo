<?php
// Start session
session_start();

// Including the database connection file
include_once ('../../include/Crud.php');

$crud = new Crud();

// Add function
function add($crud)
{
    if (isset($_POST['add'])) {
        $Res_ID = $crud->escape_string($_POST['Res_ID']);
        $Staff_Name = $crud->escape_string($_POST['Staff_Name']);
        $email = $crud->escape_string($_POST['email']);
        $password = $crud->escape_string($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $status = 'On Going Term';
        $type = 'Staff';

        // Insert data into database
        $sql = "INSERT INTO staff_tb (Res_ID, Staff_Name, email, password_hash, status, type) VALUES ('$Res_ID','$Staff_Name', '$email', '$hashedPassword', '$status', '$type')";

        try {
            if ($crud->execute($sql)) {
                if (isset($_SESSION['role'])) {
                    $action = 'Added Staff named ' . $Staff_Name . ', with ' . $status . '';
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                    $crud->execute($log_query);
                }
                $_SESSION['message'] = 'Staff added successfully';
            } else {
                throw new Exception('Cannot add Staff');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
        }

        header('location: staff.php');
    } else {
        $_SESSION['message'] = 'Fill up add form first';
        header('location: staff.php');
    }
}

// Edit function
function edit($crud)
{
    if (isset($_POST['edit'])) {
        $staffID = $_GET['staffID'];

        $Res_ID = $crud->escape_string($_POST['Res_ID']);
        $Staff_Name = $crud->escape_string($_POST['Staff_Name']);
        $email = $crud->escape_string($_POST['email']);
        $password = $crud->escape_string($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $status = $crud->escape_string($_POST['status']);

        // Update data
        $sql = "UPDATE staff_tb SET Res_ID = '$Res_ID', Staff_Name = '$Staff_Name', email = '$email', password_hash = '$hashedPassword', status = '$status' WHERE staffID = '$staffID'";

        try {
            if ($crud->execute($sql)) {
                if (isset($_SESSION['role'])) {
                    $action = 'Updated Staff named ' . $Staff_Name . ', with ' . $status . '';
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                    $crud->execute($log_query);
                }
                $_SESSION['message'] = 'Staff updated successfully';
            } else {
                throw new Exception('Cannot update staff');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
        }

        header('location: staff.php');
    } else {
        $_SESSION['message'] = 'Select staff to edit first';
        header('location: staff.php');
    }
}

// To specify the functions
if (isset($_POST['add'])) {
    add($crud);
} elseif (isset($_POST['edit'])) {
    edit($crud);
}
?>
