<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['patient_username'];
    $password = $_POST['patient_password'];

    $stmt = $conn->prepare("SELECT ID, Password, Full_Name FROM users WHERE Full_Name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['Password'])) {
            $_SESSION['patient_id'] = $user['ID']; // Store user ID in session
            $_SESSION['full_name'] = $user['Full_Name']; // Store full name in session
            header("Location: patient_info.php"); // Redirect to patient_info.php
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid username or password.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: index.php");
        exit();
    }
}
?>
