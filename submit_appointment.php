<?php
// filename: submit_appointment.php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['patient_id']) || !isset($_SESSION['full_name'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: index.php');
    exit;
}

// Database connection
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "hospital_management"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$patient_id = $_SESSION['patient_id'];
$patient_name = $_POST['name'];
$age = (int)$_POST['age']; // Ensure age is treated as an integer
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$area = $_POST['area'];
$city = $_POST['city'];
$post_code = $_POST['post-code'];
$doctor_id = (int)$_POST['doctor_id']; // Ensure doctor_id is treated as an integer
$doctor_name = $_POST['doctor_name'];
$specialization = $_POST['specialization'];
$appointment_date = $_POST['date'];
$appointment_time = $_POST['time'];

// Use area and city to form the address
$address = $area . ' ' . $city; // Concatenate area and city into a single address

// Insert into booked_appointments
$sql = "INSERT INTO booked_appointments (Patient_ID, Patient_Name, Age, Gender, Email, Patient_No, Address, Doctor_ID, Doctor_Name, Specialization, Appointment_date, Appointment_time)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters to booked_appointments (12 in total)
// The correct types: iissssssssss
$stmt->bind_param("isissssissss", $patient_id, $patient_name, $age, $gender, $email, $phone, $address, $doctor_id, $doctor_name, $specialization, $appointment_date, $appointment_time);

if ($stmt->execute()) {
    // Redirect to patient_info.php after successful booking
    header('Location: patient_info.php');
    exit;
} else {
    echo "Error inserting into booked_appointments: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
