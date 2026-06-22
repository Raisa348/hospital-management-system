<?php
include 'db.php'; // Include your database connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $doctor_username = $_POST['doctor_username'];
    $doctor_password = $_POST['doctor_password'];

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE `Doctor_Name` = ? AND `Password` = ?");
    $stmt->bind_param("ss", $doctor_username, $doctor_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful, fetch doctor data
        $doctor = $result->fetch_assoc();

        // Set session variables
        $_SESSION['doctor_logged_in'] = true;
        $_SESSION['doctor_id'] = $doctor['ID']; // Store doctor ID for later use
        $_SESSION['doctor_name'] = $doctor_username;

        // Redirect to doctors_site.php
        header("Location: doctors_site.php");
        exit(); // Stop further script execution
    } else {
        // Invalid credentials
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: index.php"); // Redirect back to index.php
        exit();
    }
}
?>
