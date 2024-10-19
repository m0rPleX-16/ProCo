<?php
session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
    $fname = htmlspecialchars(trim($_POST["fname"]));
    $lname = htmlspecialchars(trim($_POST["lname"]));
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $phnum = $_POST["phnum"];
    $password = $_POST["password"];
    $confirmPass = $_POST["confirmPass"];

    if (empty($fname) || empty($lname)) {
        $errors[] = "First name and last name are required";
    }

    if (!$email) {
        $errors[] = "Invalid email format";
    }

    if (!preg_match('/^[0-9]{11}+$/', $phnum)) {
        $errors[] = "Phone number must contain 11 digits";
    }

    if (strlen($password) < 8 || !preg_match("/[a-z]/i", $password) || !preg_match("/[0-9]/i", $password)) {
        $errors[] = "Password must be at least 8 characters long and contain at least one letter and one number";
    }

    if ($password !== $confirmPass) {
        $errors[] = "Passwords do not match";
    }

    // If there are errors, display them and stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
        }
        exit;
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Connect to database
    require_once __DIR__ . "/pages/DbConnection.php";
    $connection = new DbConnection();
    $mysqli = $connection->getConnection();

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Insert user data into database
    $sql = "INSERT INTO user_signin (fname, lname, phnum, email, password_hash) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sssss", $fname, $lname, $phnum, $email, $password_hash);
    if (!$stmt->execute()) {
        if ($mysqli->errno === 1062) {
            echo '<div class="alert alert-danger">Email already taken</div>';
        } else {
            die("SQL error: " . $mysqli->error);
        }
        exit;
    }

    // Set success message and redirect
    $_SESSION['added'] = true;
    header("Location: signin.php");
    exit;
}
?>
