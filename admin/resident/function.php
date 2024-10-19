<?php
// Start session
session_start();

// Including the database connection file
require '../DbConnection.php';
include_once('../../include/Crud.php');

// Instantiate DbConnection
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

// Create CRUD object
$crud = new Crud();

// Add function
function add($crud, $conn)
{
    if (isset($_POST['add'])) {
        // Validate and sanitize inputs
        $Res_Fname = $crud->escape_string($_POST['firstname']);
        $Res_Lname = $crud->escape_string($_POST['lastname']);
        $Res_Mname = $crud->escape_string($_POST['middleinitial']);
        $Res_Age = (int) $_POST['age'];
        $Res_Birth = $crud->escape_string($_POST['birth']);
        $Res_MarStatus = $crud->escape_string($_POST['status']);
        $Res_Sex = $crud->escape_string($_POST['sex']);
        $Res_Contacts = $crud->escape_string($_POST['contact']);
        $Res_Address = $crud->escape_string($_POST['address']);
        $Res_Years = (int) $_POST['year'];
        $Res_Education = $crud->escape_string($_POST['educ']);
        $Res_Religion = $crud->escape_string($_POST['religion']);
        $Res_Nationality = $crud->escape_string($_POST['nationality']);
        $Res_VitalStatus = $crud->escape_string($_POST['health']);
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $password = $crud->escape_string($_POST['password']);
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Check if file is uploaded and process the image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];

            // Define the maximum file size and allowed image types
            $max_file_size = 2048000; // 2MB
            $allowed_types = ['image/jpeg', 'image/png', 'image/bmp'];

            // Check if the uploaded file is of allowed type and size
            if (in_array($image_type, $allowed_types) && $image_size <= $max_file_size) {
                // Generate a unique filename to prevent overwriting existing files
                $milliseconds = round(microtime(true) * 1000);
                $image_name = $milliseconds . '_' . $image_name;

                // Move the uploaded file to the desired directory
                $destination = '../../resImg/' . $image_name;
                if (move_uploaded_file($image_tmp, $destination)) {
                    $Res_Img = $image_name;

                    $stmt = $conn->prepare("INSERT INTO residents_tb (Res_Fname, Res_Lname, Res_Mname, Res_Age, Res_Birth, Res_MarStatus, Res_Sex, Res_Contacts, 
                    Res_Address, Res_Years, Res_Education, Res_Religion, Res_Nationality, Res_VitalStatus, Res_Img, email, password_hash) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param(
                        "sssisssssisssssss",
                        $Res_Fname,
                        $Res_Lname,
                        $Res_Mname,
                        $Res_Age,
                        $Res_Birth,
                        $Res_MarStatus,
                        $Res_Sex,
                        $Res_Contacts,
                        $Res_Address,
                        $Res_Years,
                        $Res_Education,
                        $Res_Religion,
                        $Res_Nationality,
                        $Res_VitalStatus,
                        $Res_Img,
                        $email,
                        $password_hash
                    );

                    if ($stmt->execute()) {
                        // Log action
                        logAction($_SESSION['admin_role'], 'Added Resident named ' . $Res_Lname . ', ' . $Res_Fname . ' ' . $Res_Mname);

                        $_SESSION['message'] = 'Resident added successfully';
                    } else {
                        $_SESSION['message'] = 'Cannot add resident';
                    }

                    $stmt->close();
                } else {
                    // Handle file upload failure
                    $_SESSION['message'] = 'Failed to upload image.';
                }
            } else {
                // Handle invalid file type or size
                $_SESSION['message'] = 'Invalid file type or size. Please upload a JPEG, PNG, or BMP image (max 2MB).';
            }
        } else {
            // Handle file upload error
            $_SESSION['message'] = 'Error uploading file.';
        }

        header('location: resident.php');
        exit();
    } else {
        $_SESSION['message'] = 'Fill up add form first';
        header('location: resident.php');
        exit();
    }
}

// Edit function
function edit($crud, $conn)
{
    if (isset($_POST['edit']) && isset($_GET['id'])) {
        // Validate and sanitize inputs
        $id = $crud->escape_string($_GET['id']);
        $Res_Fname = $crud->escape_string($_POST['firstname']);
        $Res_Lname = $crud->escape_string($_POST['lastname']);
        $Res_Mname = $crud->escape_string($_POST['middleinitial']);
        $Res_Age = (int) $_POST['age'];
        $Res_Birth = $crud->escape_string($_POST['birth']);
        $Res_MarStatus = $crud->escape_string($_POST['status']);
        $Res_Sex = $crud->escape_string($_POST['sex']);
        $Res_Contacts = $crud->escape_string($_POST['contact']);
        $Res_Address = $crud->escape_string($_POST['address']);
        $Res_Years = (int) $_POST['year'];
        $Res_Education = $crud->escape_string($_POST['educ']);
        $Res_Religion = $crud->escape_string($_POST['religion']);
        $Res_Nationality = $crud->escape_string($_POST['nationality']);
        $Res_VitalStatus = $crud->escape_string($_POST['health']);
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $password = $crud->escape_string($_POST['password']);
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Check if file is uploaded and process the image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];
            $image_size = $_FILES['image']['size'];

            // Define the maximum file size and allowed image types
            $max_file_size = 2048000; // 2MB
            $allowed_types = ['image/jpeg', 'image/png', 'image/bmp'];

            // Check if the uploaded file is of allowed type and size
            if (in_array($image_type, $allowed_types) && $image_size <= $max_file_size) {
                // Generate a unique filename to prevent overwriting existing files
                $milliseconds = round(microtime(true) * 1000);
                $image_name = $milliseconds . '_' . $image_name;

                // Move the uploaded file to the desired directory
                $destination = '../../resImg/' . $image_name;
                if (move_uploaded_file($image_tmp, $destination)) {
                    $Res_Img = $image_name;

                    // Use prepared statements to prevent SQL injection
                    $stmt = $conn->prepare("UPDATE residents_tb SET Res_Fname = ?, Res_Lname = ?, Res_Mname = ?, Res_Age = ?, Res_Birth = ?, 
                        Res_MarStatus = ?, Res_Sex = ?, Res_Contacts = ?, Res_Address = ?, Res_Years = ?, Res_Education = ?, Res_Religion = ?, 
                        Res_Nationality = ?, Res_VitalStatus = ?, Res_Img = ?, email = ?, password_hash = ? WHERE id = ?");
                    $stmt->bind_param(
                        "sssisssssisssssssi",
                        $Res_Fname,
                        $Res_Lname,
                        $Res_Mname,
                        $Res_Age,
                        $Res_Birth,
                        $Res_MarStatus,
                        $Res_Sex,
                        $Res_Contacts,
                        $Res_Address,
                        $Res_Years,
                        $Res_Education,
                        $Res_Religion,
                        $Res_Nationality,
                        $Res_VitalStatus,
                        $Res_Img,
                        $email,
                        $password_hash,
                        $id
                    );

                    if ($stmt->execute()) {
                        // Log action
                        logAction($_SESSION['admin_role'], 'Updated Resident named ' . $Res_Lname . ', ' . $Res_Fname . ' ' . $Res_Mname);

                        $_SESSION['message'] = 'Resident updated successfully';
                    } else {
                        $_SESSION['message'] = 'Cannot update Resident';
                    }

                    $stmt->close();
                } else {
                    // Handle file upload failure
                    $_SESSION['message'] = 'Failed to upload image.';
                }
            } else {
                // Handle invalid file type or size
                $_SESSION['message'] = 'Invalid file type or size. Please upload a JPEG, PNG, or BMP image (max 2MB).';
            }
        } else {
            // Handle file upload error
            $_SESSION['message'] = 'Error uploading file.';
        }

        header('location: resident.php');
        exit();
    } else {
        $_SESSION['message'] = 'Select user to edit first';
        header('location: resident.php');
        exit();
    }
}

// Log action function
function logAction($role, $action)
{
    global $conn;
    $log_query = "INSERT INTO logs (user, logdate, action) VALUES (?, NOW(), ?)";
    $stmt = $conn->prepare($log_query);
    $stmt->bind_param("ss", $role, $action);
    $stmt->execute();
    $stmt->close();
}

// Execute appropriate function based on form submission or URL parameter
if (isset($_POST['add'])) {
    add($crud, $conn);
} else if (isset($_POST['edit'])) {
    edit($crud, $conn);
}
