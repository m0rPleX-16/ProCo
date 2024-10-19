<?php
// Start session
session_start();

// Including the database connection file
include_once('../../include/Crud.php');

// Create a CRUD object
$crud = new Crud();

// Add function
function add($crud)
{
    if (isset($_POST['add'])) {
        try {
            // Validate and escape user inputs
            if (empty($_POST['Res_ID']) || empty($_POST['Fam_LName']) || empty($_POST['Fam_Address']) || empty($_POST['Fam_Income']) || empty($_POST['Fam_Contact']) || empty($_POST['Fam_MCount'])) {
                throw new Exception('All fields are required.');
            }

            $Res_ID = $crud->escape_string($_POST['Res_ID']);
            $Fam_LastName = $crud->escape_string($_POST['Fam_LName']);
            $Fam_Address = $crud->escape_string($_POST['Fam_Address']);
            $Fam_Income = $crud->escape_string($_POST['Fam_Income']);
            $Fam_Contact = $crud->escape_string($_POST['Fam_Contact']);
            $Fam_MembersCount = $crud->escape_string($_POST['Fam_MCount']);

            // Check if resident ID exists
            $stmt = $crud->getConnection()->prepare("SELECT * FROM residents_tb WHERE id = ?");
            $stmt->bind_param("i", $Res_ID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Resident ID exists, proceed with adding family
                // Insert data into database
                $sql = "INSERT INTO families_tb (Res_ID, Fam_LName, Fam_Address, Fam_Income, Fam_Contact, Fam_MCount) VALUES (?, ?, ?, ?, ?, ?)";
                $insert_stmt = $crud->getConnection()->prepare($sql);
                $insert_stmt->bind_param("issssi", $Res_ID, $Fam_LastName, $Fam_Address, $Fam_Income, $Fam_Contact, $Fam_MembersCount);

                if ($insert_stmt->execute()) {
                    // Logging action
                    if (isset($_SESSION['role'])) {
                        $action = 'Added Family Head with Lastname ' . $Fam_LastName;
                        $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
                        $log_stmt = $crud->getConnection()->prepare($log_query);
                        $log_stmt->bind_param("ss", $_SESSION['role'], $action);
                        $log_stmt->execute();
                    }
                    $_SESSION['message'] = 'Family added successfully';
                } else {
                    throw new Exception('Error: Cannot add family.');
                }

                header('Location: families.php');
                exit();
            } else {
                // Resident ID not found, display error message
                throw new Exception('Cannot add family, Resident ID not found');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            header('Location: families.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Fill up add form first';
        header('Location: families.php');
        exit();
    }
}

// Edit function
function edit($crud)
{
    if (isset($_POST['edit'])) {
        try {
            // Validate and escape user inputs
            if (empty($_POST['Res_ID']) || empty($_POST['Fam_LName']) || empty($_POST['Fam_Address']) || empty($_POST['Fam_Income']) || empty($_POST['Fam_Contact']) || empty($_POST['Fam_MCount']) || empty($_GET['id'])) {
                throw new Exception('All fields and ID are required.');
            }

            $id = $crud->escape_string($_GET['id']);
            $Res_ID = $crud->escape_string($_POST['Res_ID']);
            $Fam_LName = $crud->escape_string($_POST['Fam_LName']);
            $Fam_Address = $crud->escape_string($_POST['Fam_Address']);
            $Fam_Income = $crud->escape_string($_POST['Fam_Income']);
            $Fam_Contact = $crud->escape_string($_POST['Fam_Contact']);
            $Fam_MCount = $crud->escape_string($_POST['Fam_MCount']);

            // Check if resident ID exists
            $stmt = $crud->getConnection()->prepare("SELECT * FROM residents_tb WHERE id = ?");
            $stmt->bind_param("i", $Res_ID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Resident ID exists, proceed with editing family
                // Update data
                $sql = "UPDATE families_tb SET Res_ID = ?, Fam_LName = ?, Fam_Address = ?, Fam_Income = ?, Fam_Contact = ?, Fam_MCount = ? WHERE id = ?";
                $update_stmt = $crud->getConnection()->prepare($sql);
                $update_stmt->bind_param("issssii", $Res_ID, $Fam_LName, $Fam_Address, $Fam_Income, $Fam_Contact, $Fam_MCount, $id);

                if ($update_stmt->execute()) {
                    // Logging action
                    if (isset($_SESSION['role'])) {
                        $action = 'Updated Family Head with Lastname ' . $Fam_LName;
                        $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
                        $log_stmt = $crud->getConnection()->prepare($log_query);
                        $log_stmt->bind_param("ss", $_SESSION['role'], $action);
                        $log_stmt->execute();
                    }
                    $_SESSION['message'] = 'Family updated successfully';
                } else {
                    throw new Exception('Error: Cannot update family.');
                }

                header('Location: families.php');
                exit();
            } else {
                // Resident ID not found, display error message
                throw new Exception('Cannot edit family, Resident ID not found');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            header('Location: families.php');
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
