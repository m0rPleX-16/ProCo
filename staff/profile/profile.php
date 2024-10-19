<?php
session_start();

if (!isset($_SESSION["staff_email"]) || $_SESSION["staff_role"] !== 'Staff' || $_SESSION["status"] !== 'On Going Term') {
    header("Location: ../../login.php");
    exit(); // Ensure that the script stops executing after redirection
} else {
    ob_start();

    // Include the database connection and CRUD classes
    include_once('../DBConnection.php');
    include_once('../../include/Crud.php');
    $dbConnection = new DbConnection();
    $conn = $dbConnection->getConnection();

    // Initialize the CRUD object
    $crud = new Crud();

    // Check if user ID is in the session
    if (isset($_SESSION['staff_user_id'])) {
        // Fetch data based on the session user ID
        $userID = $_SESSION['staff_user_id'];

        // Sanitize the userID
        $userID = intval($userID);

        // Use prepared statements to avoid SQL injection
        $stmt = $conn->prepare("SELECT staff_tb.*, residents_tb.Res_Img FROM staff_tb JOIN residents_tb ON staff_tb.Res_ID = residents_tb.id WHERE staff_tb.staffID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $userData = $result->fetch_assoc();
            if ($userData) {
                $email = $userData['email'];
                $profileImage = $userData['Res_Img'] ?? 'blankAvatar.png';
            } else {
                // Handle case where user data is not found
                echo "User data not found!";
            }
        } else {
            // Handle the case where the query failed
            echo "Error executing the SQL query.";
        }

        $stmt->close();
    } else {
        // Handle case where user ID is not found in session
        echo "User ID not found in session!";
    }

    // Handle Profile Picture Update
    if (isset($_POST['update-picture'])) {
        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profilePicture']['tmp_name'];
            $fileName = $_FILES['profilePicture']['name'];
            $fileSize = $_FILES['profilePicture']['size'];
            $fileType = $_FILES['profilePicture']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Directory where files are saved
            $uploadFileDir = '../../resImg/';
            $dest_path = $uploadFileDir . $newFileName;

            // Check if directory exists, if not create it
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            // Allowed file extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Move the file to the desired location
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Update the database with the new profile picture
                    $stmt = $conn->prepare("UPDATE residents_tb SET Res_Img = ? WHERE id = (SELECT Res_ID FROM staff_tb WHERE staffID = ?)");
                    $stmt->bind_param("si", $newFileName, $userID);
                    $stmt->execute();
                    $stmt->close();

                    // Redirect to the profile page after updating the picture
                    header("Location: profile.php");
                    exit();
                } else {
                    echo 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.';
                }
            } else {
                echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            echo 'There is some error in the file upload. Please check the following error.<br>';
            echo 'Error:' . $_FILES['profilePicture']['error'];
        }
    }

    // Update Email and Password Logic
    if (isset($_POST['update-profile'])) {
        $newEmail = $_POST['email'];
        $newPassword = $_POST['new-password'];

        if (!empty($newPassword)) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            // Update the password in the database
            $stmt = $conn->prepare("UPDATE staff_tb SET password_hash = ? WHERE staffID = ?");
            $stmt->bind_param("si", $hashedPassword, $userID);
            $stmt->execute();
            $stmt->close();
        }

        // Update the email in the database
        $stmt = $conn->prepare("UPDATE staff_tb SET email = ? WHERE staffID = ?");
        $stmt->bind_param("si", $newEmail, $userID);
        $stmt->execute();
        $stmt->close();

        // Redirect to the profile page after updating the email and/or password
        header("Location: profile.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
    <!-- CSS -->
    <link rel="stylesheet" href="css/pfp-style.css">

    <!-- lineicons -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper">
        <?php include '../sidebar.php'; ?>
        <!-- Navigation Bar -->
        <div class="main">
            <?php include '../navbar.php'; ?>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <h3 class="fw-bold fs-4 mb-4">Profile Settings</h3>
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-3 mx-auto text-center">
                            <?php if (isset($profileImage) && !empty($profileImage)): ?>
                                <img id="userPFP" class="image-container" src="../../resImg/<?php echo $profileImage; ?>" alt="Profile Picture">
                            <?php else: ?>
                                <img id="userPFP" class="image-container" src="images/blankAvatar.png" alt="Profile Picture">
                            <?php endif; ?>
                            <div>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editPictureModal"><i class="lni lni-pencil"></i>Edit Picture</button>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <form method="POST">
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 form-label text-start">Email:</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="new-password" class="col-sm-2 form-label text-start">New Password:</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="new-password" name="new-password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="update-profile">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "../../include/footer.php" ?>
        </div>
    </div>

    <!-- Modal for Editing Picture -->
    <div class="modal fade" id="editPictureModal" tabindex="-1" aria-labelledby="editPictureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPictureModalLabel">Edit Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="profilePicture" class="form-label">Choose a new profile picture</label>
                            <input class="form-control" type="file" id="profilePicture" name="profilePicture" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update-picture">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-qZWf26V7I6Yw1TfKNH5XpAUNwXxO2+mA7t1c9f0MD5dI9fbbd2HVlnE5VJ4iA7Jm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-cuUKCpqJqhaqOUvFC/lrD+aLpbFRFSs+U5Bhtn3yR3F4sV5LA8kVN8H9prym0DzK" crossorigin="anonymous"></script>
</body>

</html>
<?php }
?>
