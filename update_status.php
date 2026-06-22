<?php
// Start the session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Include the database connection file
include('db.php');

// Check if appointment_id and status are set in the POST request
if (isset($_POST['appointment_id']) && isset($_POST['status'])) {
    $appointmentId = intval($_POST['appointment_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status in the booked_appointments table
    $query = "UPDATE booked_appointments SET Status = '$status' WHERE Appointment_ID = $appointmentId";
    if (mysqli_query($conn, $query)) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
