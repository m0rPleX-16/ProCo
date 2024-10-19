<?php
// Start session
session_start();

// Including the database connection file
include_once('../../include/Crud.php');

$crud = new Crud();

// Function to add event
function add($crud)
{
    try {
        if (isset($_POST['add'])) {
            // Validate input
            if (empty($_POST['Off_ID']) || empty($_POST['Event_Name']) || empty($_POST['Event_Date']) || empty($_POST['Event_Location']) || empty($_POST['Event_Description'])) {
                throw new Exception('All fields are required');
            }

            $Off_ID = $crud->escape_string($_POST['Off_ID']);
            $Event_Name = $crud->escape_string($_POST['Event_Name']);
            $Event_Date = $crud->escape_string($_POST['Event_Date']);
            $Event_Location = $crud->escape_string($_POST['Event_Location']);
            $Event_Description = $crud->escape_string($_POST['Event_Description']);
            $Event_Status = 'On Going';

            // Insert data into database
            $sql = "INSERT INTO events_tb (Off_ID, Event_Name, Event_Date, Event_Location, Event_Description, Event_Status) VALUES ('$Off_ID', '$Event_Name', '$Event_Date', '$Event_Location', '$Event_Description', '$Event_Status')";
            
            if ($crud->execute($sql)) {
                if (isset($_SESSION['role'])) {
                    $action = 'Added Event with Name ' . $Event_Name . ' on ' . $Event_Date;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                    $crud->execute($log_query);
                }
                $_SESSION['message'] = 'Event added successfully';
            } else {
                throw new Exception('Cannot add event');
            }

            header('location: events.php');
            exit();
        } else {
            throw new Exception('Fill up add form first');
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        header('location: events.php');
        exit();
    }
}

// Function to cancel event
function cancel($crud)
{
    try {
        if (isset($_GET['eventID'])) {
            // Getting the id
            $eventID = $_GET['eventID'];
            $Event_Status = 'Cancelled';

            // Update data
            $sql = "UPDATE events_tb SET Event_Status = '$Event_Status' WHERE eventID = '$eventID'";

            if ($crud->execute($sql)) {
                if (isset($_SESSION['role'])) {
                    $action = 'Cancelled Event with ID #' . $eventID;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                    $crud->execute($log_query);
                }
                $_SESSION['message'] = 'Event cancelled successfully';
            } else {
                throw new Exception('Cannot cancel event');
            }

            header('location: events.php');
            exit();
        } else {
            throw new Exception('Select event to cancel first');
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        header('location: events.php');
        exit();
    }
}

// Function to edit event
function edit($crud)
{
    try {
        if (isset($_POST['edit'])) {
            if (empty($_GET['eventID'])) {
                throw new Exception('Event ID is required');
            }

            // Validate input
            if (empty($_POST['Off_ID']) || empty($_POST['Event_Name']) || empty($_POST['Event_Date']) || empty($_POST['Event_Location']) || empty($_POST['Event_Description']) || empty($_POST['Event_Status'])) {
                throw new Exception('All fields are required');
            }

            $eventID = $_GET['eventID'];
            $Off_ID = $crud->escape_string($_POST['Off_ID']);
            $Event_Name = $crud->escape_string($_POST['Event_Name']);
            $Event_Date = $crud->escape_string($_POST['Event_Date']);
            $Event_Location = $crud->escape_string($_POST['Event_Location']);
            $Event_Description = $crud->escape_string($_POST['Event_Description']);
            $Event_Status = $crud->escape_string($_POST['Event_Status']);

            // Update data
            $sql = "UPDATE events_tb SET Off_ID = '$Off_ID', Event_Name = '$Event_Name', Event_Date = '$Event_Date', Event_Location = '$Event_Location', Event_Description = '$Event_Description', Event_Status = '$Event_Status' WHERE eventID = '$eventID'";

            if ($crud->execute($sql)) {
                if (isset($_SESSION['role'])) {
                    $action = 'Updated Event with Name ' . $Event_Name . ' on ' . $Event_Date;
                    $log_query = "INSERT INTO logs (user, logdate, action) VALUES ('" . $_SESSION['role'] . "', NOW(), '" . $action . "')";
                    $crud->execute($log_query);
                }
                $_SESSION['message'] = 'Event updated successfully';
            } else {
                throw new Exception('Cannot update event');
            }

            header('location: events.php');
            exit();
        } else {
            throw new Exception('Fill up edit form first');
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        header('location: events.php');
        exit();
    }
}

// To specify the functions
if (isset($_POST['add'])) {
    add($crud);
} elseif (isset($_POST['edit'])) {
    edit($crud);
} elseif (isset($_GET['eventID']) && isset($_GET['action']) && $_GET['action'] === 'cancel') {
    cancel($crud);
}
?>
