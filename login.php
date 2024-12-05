<?php
session_start();
require_once __DIR__ . "/include/DbConnection.php";

$is_invalid = false;

// Set the default timezone for PHP
date_default_timezone_set('UTC');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dbConnection = new DbConnection();
    $mysqli = $dbConnection->getConnection();

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $email = $mysqli->real_escape_string($_POST["email"]);
    $password = $mysqli->real_escape_string($_POST["password"]);

    // Check admin
    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = $mysqli->query($sql);

    if ($result === false) {
        die("Admin Query failed: " . $mysqli->error);
    }

    $admin = $result->fetch_assoc();

    if ($admin) {
        $_SESSION["admin_id"] = $admin["admin_id"];
        $_SESSION["admin_role"] = $admin["type"];
        
        if ($_SESSION["admin_role"] === "Captain" || $_SESSION["admin_role"] === "Kagawad" || $_SESSION["admin_role"] === "Administrator") {
            $user = $admin["type"];
            $action = $_SESSION["admin_role"] . " logged in";
            logAction($mysqli, $user, $action);
        }

        switch ($_SESSION["admin_role"]) {
            case "Captain":
                header("Location: admin/dashboard/dashboard.php");
                exit;
            case "Kagawad":
                header("Location: admin/dashboard/dashboard.php");
                exit;
            case "Administrator":
                header("Location: admin/dashboard/dashboard.php");
                exit;
            default:
                header("Location: logout.php");
                break;
        }
    }

    $sql = "SELECT * FROM staff_tb WHERE email = '$email'";
    $result = $mysqli->query($sql);

    if ($result === false) {
        die("Staff Query failed: " . $mysqli->error);
    }

    $staff = $result->fetch_assoc();

    if ($staff && password_verify($password, $staff["password_hash"]) && $staff["status"] === "On Going Term") {
        $_SESSION["staff_email"] = $staff["email"];
        $_SESSION["staff_username"] = $staff["Staff_Name"];
        $_SESSION["staff_user_id"] = $staff["staffID"];
        $_SESSION["staff_role"] = $staff["type"];
        $_SESSION["status"] = $staff["status"];

        if ($_SESSION["staff_role"] === "Staff") {
            $user = $staff["Staff_Name"];
            $role = $_SESSION["staff_role"];
            $action = "Logged in as $role $user"; 
            logAction($mysqli, $user, $action);
        }

        header("Location: staff/dashboard/dashboard.php");
        exit;
    }

    // Set $is_invalid to true if login fails
    $is_invalid = true;
}

// Function to log user actions
function logAction($mysqli, $user, $action)
{
    // Set the timezone for the current database session
    $mysqli->query("SET time_zone = '+08:00'"); // Adjust the time zone offset according to your server's timezone
    $sql = "INSERT INTO logs (user, logdate, action) VALUES ('$user', NOW(), '$action')";
    $result = $mysqli->query($sql);

    if ($result === false) {
        die("Logging failed: " . $mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="images/pcLogo.png">
    <title>Log In | Profile Connect</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/login-style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6oIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <!-- boxicon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .alert-message {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            display: <?php echo ($is_invalid || isset($_SESSION["login_failed"])) ? 'block' : 'none'; ?>;
        }
        @media only screen and (max-width: 992px) {
            .bg-holder {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="row vh-100 vw-100 g-0">
        <!-- img -->
        <div class="col-sm-4 col-lg-4 position-relative d-none d-lg-block d-md-block d-sm-block ">
            <div class="bg-holder" style="background-image: url(images/login-background.jpg)">
                <a href="index.php">
                    <img src="images/pcLogo.png" class="img-fluid position-absolute top-50 start-50 translate-middle" alt="profile connect logo">
                </a>
            </div>
        </div>
        <!-- right -->
        <div class="col-sm-5 col-lg-8">
            <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0">
                <div class="col col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="text-center mb-5 pb-5 pt-5 mt-5">
                        <h1 class="fw-bold">
                            Welcome Back!
                        </h1>
                        <p class="text-secondary">
                            Log in to continue
                        </p>
                        <br>
                        <!-- forms -->
                        <form method="POST" id="loginForm">
                            <div class="row input-group mb-3">
                                <div class="col text-start">
                                    <label for="email" class="col-form-label text-start mb-2">E-mail or Username:</label>
                                </div>
                                <div class="col-md-12">
                                    <input name="email" type="text" class="form-control form-control-lg fs-6 custom-input" placeholder="E-mail or Username" required>
                                </div>
                            </div>
                            <div class="row input-group mb-5">
                                <div class="col text-start">
                                    <label for="pass" class="col-form-label text-start mb-2">Password:</label>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control form-control-lg fs-6 custom-input" placeholder="Password" id="password" required>
                                        <button type="button" class="btn btn-outline-secondary" id="showPassword">
                                            <i class='bx bx-show'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-lg w-50" id="loginBtn" type="submit" name="btn_login">
                                <span class="log">
                                    Log in
                                </span>
                            </button>
                        </form>
                    </div>
                    <div class="row ">
                        <div class="additional-info">
                            <hr>
                            <div class="text-start">
                                <p>Don't have an account?
                                    <a href="about.php" id="signUpLink">Please read!</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Alert message for invalid login -->
    <div class="alert alert-danger alert-message" role="alert" style="display: <?php echo ($is_invalid || isset($_SESSION["login_failed"])) ? 'block' : 'none'; ?>;">
        Invalid email or password.
    </div>
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzS5iQ1U6YOp5Hb12mBZT6vmKlg7EDU5OEU5vzZDYx" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-qhXatvuq41LtJGD2Stk8QNkPOfHhjEu3e2dN2AbGYmYHeEwZ2LllFLflAWT7HSFa" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>
