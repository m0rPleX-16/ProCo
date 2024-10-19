<?php
// Including the database connection file
include_once('../../include/Crud.php');

$crud = new Crud();

// Add function for officials
function add($crud)
{
    if (isset($_POST['add'])) {
        $Res_ID = $crud->escape_string($_POST['Res_ID']);
        $Off_Pos = $crud->escape_string($_POST['Off_Pos']);
        $Off_CName = $crud->escape_string($_POST['Off_CName']);
        $Off_Contact = $crud->escape_string($_POST['Off_Contact']);
        $Off_Address = $crud->escape_string($_POST['Off_Address']);
        $Off_TermStart = $crud->escape_string($_POST['Off_TermStart']);
        $Off_TermEnd = $crud->escape_string($_POST['Off_TermEnd']);

        // Set the default status to 'Ongoing Term'
        $Off_Status = 'Ongoing Term';

        // Check for existing official
        $existing_query = "SELECT * FROM officials_tb WHERE Off_Pos = '$Off_Pos' AND Off_TermStart = '$Off_TermStart' AND Off_TermEnd = '$Off_TermEnd'";
        $existing_result = $crud->read($existing_query);
        if ($existing_result->num_rows > 0) {
            $_SESSION['duplicate'] = true;
            header('location: officials.php');
            exit();
        }

        // Handle image upload
        $Off_Img = handleImageUpload();

        // Insert data into database
        $sql = "INSERT INTO officials_tb (Res_ID, Off_Pos, Off_CName, Off_Contact, Off_Address, Off_TermStart, Off_TermEnd, Off_Status, Off_Img) VALUES ('$Res_ID','$Off_Pos','$Off_CName','$Off_Contact','$Off_Address', '$Off_TermStart', '$Off_TermEnd', '$Off_Status', '$Off_Img')";

        if ($crud->execute($sql)) {
            // Logging action
            if (isset($_SESSION['role'])) {
                $action = 'Added Official named ' . $Off_CName;
                $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                $crud->execute($log_query);
            }

            $_SESSION['message'] = 'Official added!';
            header('location: officials.php');
            exit();
        } else {
            $_SESSION['message'] = 'Cannot add official';
            header('location: officials.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Fill up add form first';
        header('location: officials.php');
        exit();
    }
}

// Edit function for officials
function edit($crud)
{
    if (isset($_POST['edit'])) {
        // Check if all required fields are present in the $_POST array
        if (isset($_POST['hidden_id'], $_POST['Res_ID'], $_POST['Off_CName'], $_POST['Off_Contact'], $_POST['Off_Address'], $_POST['Off_TermStart'], $_POST['Off_TermEnd'])) {
            // Retrieve data from $_POST array
            $offID = $_POST['hidden_id'];
            $Res_ID = $crud->escape_string($_POST['Res_ID']);
            $Off_CName = $crud->escape_string($_POST['Off_CName']);
            $Off_Contact = $crud->escape_string($_POST['Off_Contact']);
            $Off_Address = $crud->escape_string($_POST['Off_Address']);
            $Off_TermStart = $crud->escape_string($_POST['Off_TermStart']);
            $Off_TermEnd = $crud->escape_string($_POST['Off_TermEnd']);

            // Check if a new image is uploaded
            $Off_Img = $_POST['Off_Img']; // Assume current image is already set in the form

            if (isset($_FILES['Off_Img']) && $_FILES['Off_Img']['error'] === UPLOAD_ERR_OK) {
                $Off_Img = handleImageUpload(); // Call the handleImageUpload function to upload the new image
            }

            // Update data
            $sql = "UPDATE officials_tb SET Res_ID = '$Res_ID', Off_CName = '$Off_CName', Off_Contact = '$Off_Contact', Off_Address = '$Off_Address', Off_TermStart = '$Off_TermStart', Off_TermEnd = '$Off_TermEnd', Off_Img = '$Off_Img' WHERE offID = '$offID'";

            if ($crud->execute($sql)) {
                // Logging action
                if (isset($_SESSION['role'])) {
                    $action = 'Updated Official with ID ' . $offID;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                    $crud->execute($log_query);
                }

                $_SESSION['message'] = 'Official updated successfully';
            } else {
                $_SESSION['message'] = 'Cannot update official';
            }
        } else {
            $_SESSION['message'] = 'Missing data in the form';
        }
        // Redirect back to the officials.php page
        header('Location: officials.php');
        exit();
    } else {
        $_SESSION['message'] = 'Select user to edit first';
        // Redirect back to the officials.php page
        header('Location: officials.php');
        exit();
    }
}


// Function to handle image upload
function handleImageUpload()
{
    if (isset($_FILES['Off_Img']) && $_FILES['Off_Img']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['Off_Img']['name'];
        $image_tmp = $_FILES['Off_Img']['tmp_name'];
        $image_type = $_FILES['Off_Img']['type'];
        $image_size = $_FILES['Off_Img']['size'];

        // Define the maximum file size and allowed image types
        $max_file_size = 2048000; // 2MB
        $allowed_types = ['image/jpeg', 'image/png', 'image/bmp'];

        // Check if the uploaded file is of allowed type and size
        if (in_array($image_type, $allowed_types) && $image_size <= $max_file_size) {
            // Generate a unique filename to prevent overwriting existing files
            $milliseconds = round(microtime(true) * 1000);
            $image_name = $milliseconds . '_' . $image_name;

            // Move the uploaded file to the desired directory
            $destination = '../../offImg/' . $image_name;
            if (move_uploaded_file($image_tmp, $destination)) {
                return $image_name;
            } else {
                $_SESSION['message'] = 'Failed to upload image.';
            }
        } else {
            $_SESSION['message'] = 'Invalid file type or size. Please upload a JPEG, PNG, or BMP image (max 2MB).';
        }
    } else {
        $_SESSION['message'] = 'Error uploading file.';
    }

    return ''; // Return an empty string if image upload fails
}

// Start term function
function startT($crud)
{
    if (isset($_POST['btn_start'])) {
        $txt_id = $_POST['hidden_id'];
        $start_query = "UPDATE officials_tb SET Off_Status = 'Ongoing Term' WHERE offID = '$txt_id' ";

        if ($crud->execute($start_query)) {
            $_SESSION['start'] = 1;
            header("location: officials.php");
            exit();
        }
    }
}

// End term function
function endT($crud)
{
    if (isset($_POST['btn_end'])) {
        $txt_id = $_POST['hidden_id'];
        $end_query = "UPDATE officials_tb SET Off_Status = 'Term Ended' WHERE offID = '$txt_id' ";

        if ($crud->execute($end_query)) {
            $_SESSION['end'] = 1;
            header("location: officials.php");
            exit();
        }
    }
}

// Check if the delete button is clicked
if (isset($_POST['btn_delete']) && isset($_POST['chk_delete'])) {
    $selectedIds = $_POST['chk_delete']; // Array of selected IDs

    // Convert array of IDs to comma-separated string
    $idsString = implode(',', $selectedIds);

    // Check for associated rows in events_tb
    $checkAssociatedRowsQuery = "SELECT COUNT(*) AS total FROM events_tb WHERE Off_ID IN ($idsString)";
    $checkResult = $crud->read($checkAssociatedRowsQuery);
    $row = mysqli_fetch_assoc($checkResult);
    $totalAssociatedRows = (int) $row['total'];

    // If there are associated rows, display an error message
    if ($totalAssociatedRows > 0) {
        $_SESSION['message'] = "Error: Cannot delete official(s) with associated event(s).";
        header("Location: officials.php");
        exit();
    }

    // Fetch the names of the officials being deleted
    $namesQuery = "SELECT Off_CName FROM officials_tb WHERE offID IN ($idsString)";
    $namesResult = $crud->read($namesQuery);
    $deletedOfficialNames = [];

    // Extract names from the result
    while ($row = mysqli_fetch_array($namesResult)) {
        $deletedOfficialNames[] = $row['Off_CName'];
    }

    // Delete officials with the selected IDs
    $deleteQuery = "DELETE FROM officials_tb WHERE offID IN ($idsString)";
    $result = $crud->execute($deleteQuery);

    // Check if deletion was successful
    if ($result) {
        // Log the deletion action
        $action = 'Deleted official(s): ' . implode(', ', $deletedOfficialNames);
        $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
        $crud->execute($log_query);

        $_SESSION['message'] = "Official(s) deleted!";
    } else {
        $_SESSION['message'] = "Error deleting officials";
        // Log the error
        $error_message = "Error deleting officials with IDs: " . $idsString;
        $error_log_query = "INSERT INTO error_logs (error_message, logdate) VALUES ('" . $error_message . "', NOW())";
        $crud->execute($error_log_query);
    }

    header("Location: officials.php");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        add($crud);
    } elseif (isset($_POST['edit'])) {
        edit($crud);
    } elseif (isset($_POST['btn_start'])) {
        startT($crud);
    } elseif (isset($_POST['btn_end'])) {
        endT($crud);
    }
}
