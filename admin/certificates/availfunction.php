<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

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
            if (empty($_POST['Document_Type']) || empty($_POST['amount'])) {
                throw new Exception('Document Type and Amount are required.');
            }

            $Document_Type = $crud->escape_string($_POST['Document_Type']);
            $amount = $crud->escape_string($_POST['amount']);
            $status = 'Available';

            // Insert data into database
            $sql = "INSERT INTO avail_cert (Document_Type, amount, status) VALUES ('$Document_Type', $amount, '$status')";

            if ($crud->execute($sql)) {
                // Logging action
                if (isset($_SESSION['role'])) {
                    $action = 'Added new available document type: ' . $Document_Type . ', with amount of ' . $amount;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
                    $crud->execute($log_query, [$_SESSION['role'], $action]);
                }
                $_SESSION['message'] = 'Document added successfully';
            } else {
                throw new Exception('Error: Cannot add document.');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
        }

        header('Location: certificates.php');
        exit();
    } else {
        $_SESSION['message'] = 'Fill up add form first.';
        header('Location: certificates.php');
        exit();
    }
}

// Edit function
function edit($crud)
{
    if (isset($_POST['edit'])) {
        try {
            // Validate and escape user inputs
            if (empty($_POST['availID']) || empty($_POST['Document_Type']) || empty($_POST['amount']) || empty($_POST['status'])) {
                throw new Exception('All fields are required.');
            }

            $id = $crud->escape_string($_POST['availID']);
            $Document_Type = $crud->escape_string($_POST['Document_Type']);
            $amount = $crud->escape_string($_POST['amount']);
            $status = $crud->escape_string($_POST['status']);

            // Update data
            $sql = "UPDATE avail_cert SET Document_Type = '$Document_Type', amount = '$amount', status = '$status' WHERE availID = '$id'";

            if ($crud->execute($sql)) {
                // Logging action
                if (isset($_SESSION['role'])) {
                    $action = 'Updated available document ' . $Document_Type . ' with amount ' . $amount;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
                    $crud->execute($log_query, [$_SESSION['role'], $action]);
                }
                $_SESSION['message'] = 'Document updated successfully';
            } else {
                throw new Exception('Error: Cannot update document.');
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
        }

        header('Location: certificates.php');
        exit();
    } else {
        $_SESSION['message'] = 'Select document to edit first.';
        header('Location: certificates.php');
        exit();
    }
}

// Execute appropriate function based on form submission or URL parameter
if (isset($_POST['add'])) {
    add($crud);
} elseif (isset($_POST['edit'])) {
    edit($crud);
}
?>
