<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

// Including the database connection file and Crud class
require_once('../DbConnection.php');
require_once('../../include/Crud.php');

// Create database connection
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

// Create Crud object
$crud = new Crud($conn);

// Approve Certificate Function
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btn_approve'])) {
    try {
        if (empty($_POST['hidden_id'])) {
            throw new Exception('Certificate ID is required.');
        }

        $txt_id = $crud->escape_string($_POST['hidden_id']);
        $approved = 'Approved';

        // Construct the SQL query string
        $approve_query = "UPDATE certificate_tb SET Issuance_Status = ? WHERE certID = ?";

        // Execute the SQL query using a prepared statement
        $result = $crud->execute($approve_query, [$approved, $txt_id]);

        if ($result) {
            // Log the action
            $action = "Approved certificate with ID: $txt_id";
            $crud->execute("INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)", [$_SESSION['role'], $action]);

            // Set success message
            $_SESSION['message'] = "Certificate approved successfully.";
        } else {
            throw new Exception("Certificate approval failed.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirect back to the previous page
    header("Location: certificates.php");
    exit();
}

// Disapprove Certificate Function
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btn_disapprove'])) {
    try {
        if (empty($_POST['hidden_id']) || empty($_POST['txt_remarks'])) {
            throw new Exception('Certificate ID and remarks are required.');
        }

        $txt_id = $crud->escape_string($_POST['hidden_id']);
        $txt_remarks = $crud->escape_string($_POST['txt_remarks']);
        $disapproved = 'Disapproved';

        // Construct the SQL query string
        $disapprove_query = "UPDATE certificate_tb SET Remarks = ?, Issuance_Status = ? WHERE certID = ?";

        // Execute the SQL query using a prepared statement
        $result = $crud->execute($disapprove_query, [$txt_remarks, $disapproved, $txt_id]);

        if ($result) {
            // Log the action
            $action = "Disapproved certificate with ID: $txt_id";
            $crud->execute("INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)", [$_SESSION['role'], $action]);

            // Set success message
            $_SESSION['message'] = "Certificate disapproved successfully.";
        } else {
            throw new Exception("Certificate disapproval failed.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirect back to the previous page
    header("Location: certificates.php");
    exit();
}

// Handle form submission for editing docs
if (isset($_POST['btn_save'])) {
    try {
        if (empty($_POST['hidden_id']) || empty($_POST['txt_edit_purpose'])) {
            throw new Exception('Certificate ID and purpose are required.');
        }

        // Retrieve form data
        $clearanceId = $crud->escape_string($_POST['hidden_id']);
        $newPurpose = $crud->escape_string($_POST['txt_edit_purpose']);

        // Update the database with new data
        $stmt_update_clearance = $conn->prepare("UPDATE certificate_tb SET Purpose = ? WHERE certID = ?");
        $stmt_update_clearance->bind_param("si", $newPurpose, $clearanceId);
        $stmt_update_clearance->execute();

        // Check for successful update
        if ($stmt_update_clearance->affected_rows > 0) {
            $_SESSION['message'] = "Certificate purpose updated successfully.";
        } else {
            throw new Exception("Error updating certificate purpose.");
        }

        // Close the statement
        $stmt_update_clearance->close();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Check if the delete button is clicked
if (isset($_POST['btn_delete']) && isset($_POST['chk_delete'])) {
    try {
        if (empty($_POST['chk_delete'])) {
            throw new Exception('No certificates selected for deletion.');
        }

        $selectedIds = $_POST['chk_delete']; // Array of selected IDs

        // Convert array of IDs to comma-separated string
        $idsString = implode(',', array_map('intval', $selectedIds));

        // Fetch the names of the requests being deleted
        $namesQuery = "SELECT Document_Type FROM certificate_tb WHERE certID IN ($idsString)";
        $namesResult = $crud->read($namesQuery);
        $deletedRequestNames = [];

        // Extract names from the result
        while ($row = mysqli_fetch_array($namesResult)) {
            $deletedRequestNames[] = $row['Document_Type'];
        }

        // Delete requests with the selected IDs
        $deleteQuery = "DELETE FROM certificate_tb WHERE certID IN ($idsString)";
        $result = $crud->execute($deleteQuery);

        // Check if deletion was successful
        if ($result) {
            // Log the deletion action
            $action = 'Deleted request(s): ' . implode(', ', $deletedRequestNames);
            $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
            $crud->execute($log_query, [$_SESSION['role'], $action]);

            $_SESSION['message'] = "Request(s) deleted successfully.";
        } else {
            throw new Exception("Error deleting request(s).");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: certificates.php");
    exit();
}
?>
