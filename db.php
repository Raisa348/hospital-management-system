

<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local XAMPP
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hospital_management";
} else {
    // Online server
    $servername = "sqlXXX.infinityfree.com";
    $username = "if0_XXXX";
    $password = "your_password";
    $dbname = "if0_XXXX_hospital_management";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
