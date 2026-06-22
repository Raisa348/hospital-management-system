<?php
// Include the database connection file
include 'db.php';
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['patient_name'];
    $email = $_POST['patient_email'];
    $password = $_POST['patient_password'];
    $gender = $_POST['patient_gender'];
    $phone = $_POST['patient_phone'];
    $city = $_POST['patient_city'];

    // Check if email already exists
    $email_check_query = "SELECT * FROM users WHERE Email = ?";
    $stmt = $conn->prepare($email_check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $email_result = $stmt->get_result();

    // Check if phone number already exists
    $phone_check_query = "SELECT * FROM users WHERE Phone_No = ?";
    $stmt = $conn->prepare($phone_check_query);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $phone_result = $stmt->get_result();

    if ($email_result->num_rows > 0) {
        $_SESSION['error_message'] = 'Account already exists with this email.';
        header("Location: index.php");
        exit;
    }

    if ($phone_result->num_rows > 0) {
        $_SESSION['error_message'] = 'Number already exists.';
        header("Location: index.php");
        exit;
    }

    // Encrypt the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare an SQL statement to insert the new patient data
    $sql = "INSERT INTO users (Full_Name, Email, Password, Gender, Phone_No, City) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $gender, $phone, $city);

        // Execute the statement
        if ($stmt->execute()) {
            // Set session variable to indicate registration success
            $_SESSION['registration_success'] = true;
            // Redirect to index.php
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error_message'] = 'Error: ' . $stmt->error;
            header("Location: index.php");
            exit;
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'Error: ' . $conn->error;
        header("Location: index.php");
        exit;
    }

    // Close the database connection
    $conn->close();
}
?>
