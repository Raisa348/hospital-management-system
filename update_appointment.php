<?php
// filename: update_appointment.php
include 'db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['patient_id'])) {
    echo "Unauthorized access.";
    exit;
}

// Get the doctor ID and user ID from the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $user_id = $_POST['user_id'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT Full_Name, Email, Gender, City, Phone_No FROM users WHERE ID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    if (!$user) {
        echo "User not found.";
        exit;
    }

    // Insert the appointment into the appointments_status table
    $stmt = $conn->prepare("INSERT INTO appointments_status (Patient_ID, Full_Name, Email, Gender, City, Phone_No, Doctor_ID, Doctor_Name, Specialization, Status, Appointment_Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    if ($stmt) {
        $doctor_query = $conn->prepare("SELECT Doctor_Name, Specialization FROM doctors WHERE ID = ?");
        $doctor_query->bind_param("i", $doctor_id);
        $doctor_query->execute();
        $doctor_result = $doctor_query->get_result();
        $doctor = $doctor_result->fetch_assoc();
        $doctor_query->close();

        if ($doctor) {
            $stmt->bind_param("isssssssss", $user_id, $user['Full_Name'], $user['Email'], $user['Gender'], $user['City'], $user['Phone_No'], $doctor_id, $doctor['Doctor_Name'], $doctor['Specialization'], $status);
            $status = "Pending"; // Set initial status
            if ($stmt->execute()) {
                echo "Appointment confirmed successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Doctor not found.";
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
