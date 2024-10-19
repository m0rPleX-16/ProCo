<?php
// Start session
session_start();

// Including the database connection file
include_once('../../include/Crud.php');

// Get the ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Create a CRUD object
$crud = new Crud();

// Add function
function add($crud)
{
    if (isset($_POST['add'])) {
        // Escape user inputs for security
        $famID = $crud->escape_string($_POST['famID']);
        $ownership = $crud->escape_string($_POST['ownership']);
        $type = $crud->escape_string($_POST['type']);

        // Check if all fields are filled
        if (empty($famID) || empty($ownership) || empty($type)) {
            $_SESSION['error'] = 'All fields are required.';
            header('location: household.php');
            exit();
        }

        // Check if family ID exists
        $stmt = $crud->getConnection()->prepare("SELECT * FROM families_tb WHERE id = ?");
        $stmt->bind_param("i", $famID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Family ID exists, proceed with adding household
            // Check for existing official
            $existing_query = "SELECT * FROM household_tb WHERE Fam_ID = ? AND Household_Ownership = ? AND Household_Type = ?";
            $existing_stmt = $crud->getConnection()->prepare($existing_query);
            $existing_stmt->bind_param("iss", $famID, $ownership, $type);
            $existing_stmt->execute();
            $existing_result = $existing_stmt->get_result();

            if ($existing_result->num_rows > 0) {
                $_SESSION['duplicate'] = true;
                header('location: household.php');
                exit();
            }

            // Insert data into database
            $sql = "INSERT INTO household_tb (Fam_ID, Household_Ownership, Household_Type) VALUES (?, ?, ?)";
            $insert_stmt = $crud->getConnection()->prepare($sql);
            $insert_stmt->bind_param("iss", $famID, $ownership, $type);

            if ($insert_stmt->execute()) {
                if (isset($_SESSION['role'])) {
                    $action = 'Added Household with Family ID #' . $famID;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
                    $log_stmt = $crud->getConnection()->prepare($log_query);
                    $log_stmt->bind_param("ss", $_SESSION['role'], $action);
                    $log_stmt->execute();
                }

                $_SESSION['message'] = 'Household added successfully';
            } else {
                $_SESSION['message'] = 'Cannot add household';
            }

            header('location: household.php');
            exit();
        } else {
            // Family ID not found, display error message
            $_SESSION['message'] = 'Cannot add household, Family ID not found';
            header('location: household.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Fill up add form first';
        header('location: household.php');
        exit();
    }
}

// Edit function
function edit($crud)
{
    if (isset($_POST['edit'])) {
        // Check if famID is set
        if (isset($_GET['id'])) {
            $id = $crud->escape_string($_GET['id']);

            $famID = $crud->escape_string($_POST['famID']);
            $ownership = $crud->escape_string($_POST['ownership']);
            $type = $crud->escape_string($_POST['type']);

            // Check if all fields are filled
            if (empty($famID) || empty($ownership) || empty($type)) {
                $_SESSION['error'] = 'All fields are required.';
                header('location: household.php');
                exit();
            }

            // Check if family ID exists
            $stmt = $crud->getConnection()->prepare("SELECT * FROM families_tb WHERE id = ?");
            $stmt->bind_param("i", $famID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Family ID exists, proceed with editing household
                // Update data
                $sql = "UPDATE household_tb SET Fam_ID = ?, Household_Ownership = ?, Household_Type = ? WHERE id = ?";
                $update_stmt = $crud->getConnection()->prepare($sql);
                $update_stmt->bind_param("issi", $famID, $ownership, $type, $id);

                if ($update_stmt->execute()) {
                    if (isset($_SESSION['role'])) {
                        $action = 'Updated Household with Familiy ID #' . $famID;
                        $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
                        $log_stmt = $crud->getConnection()->prepare($log_query);
                        $log_stmt->bind_param("ss", $_SESSION['role'], $action);
                        $log_stmt->execute();
                    }
                    $_SESSION['message'] = 'Household updated successfully';
                } else {
                    $_SESSION['message'] = 'Cannot update household';
                }

                header('location: household.php');
                exit();
            } else {
                // Family ID not found, display error message
                $_SESSION['message'] = 'Cannot edit household, Family ID not found';
                header('location: household.php');
                exit();
            }
        } else {
            $_SESSION['message'] = 'Select household to edit first';
            header('location: household.php');
            exit();
        }
    }
}

// Execute appropriate function based on form submission or URL parameter
if (isset($_POST['add'])) {
    add($crud);
} elseif (isset($_POST['edit'])) {
    edit($crud);
}
?>
