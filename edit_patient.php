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

// Get the patient ID from the query string
$patient_id = $_GET['id'];

// Fetch the patient information
$query = "SELECT * FROM users WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated information from the form
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone_no = $_POST['phone_no'];
    $city = $_POST['city'];

    // Update patient information in the database
    $update_query = "UPDATE users SET Full_Name=?, Email=?, Gender=?, Phone_No=?, City=? WHERE ID=?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssi", $full_name, $email, $gender, $phone_no, $city, $patient_id);
    $update_stmt->execute();

    // Redirect to patient information page after updating
    header("Location: patient_information.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Information</title>
    <style>
        body {
            background-color: #f4f4f4; /* Light grey background */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh; /* Full viewport height */
        }

        h2 {
            color: #333; /* Dark text color */
            margin-bottom: 20px; /* Space below heading */
        }

        form {
            background: white; /* White background for the form */
            padding: 20px; /* Padding inside the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            width: 300px; /* Fixed width */
            text-align: left; /* Align text to the left */
        }

        label {
            margin-top: 10px; /* Space above labels */
            display: block; /* Labels on separate lines */
            font-weight: bold; /* Bold labels */
            color: #555; /* Darker text for labels */
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%; /* Full width inputs */
            padding: 10px; /* Padding inside inputs */
            margin-top: 5px; /* Space above inputs */
            margin-bottom: 20px; /* Space below inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 5px; /* Rounded corners */
            font-size: 14px; /* Font size for inputs */
        }

        button {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            padding: 10px; /* Padding inside button */
            cursor: pointer; /* Pointer cursor */
            font-size: 16px; /* Larger font for button */
            transition: background-color 0.3s; /* Transition effect */
            width: 100%; /* Full width button */
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        .error {
            color: red; /* Red text for error messages */
            margin-bottom: 20px; /* Space below error messages */
        }
    </style>
</head>
<body>
    <h2>Edit Patient Information</h2>
    <form method="POST">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($patient['Full_Name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['Email']); ?>" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male" <?php if($patient['Gender'] == "Male") echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if($patient['Gender'] == "Female") echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if($patient['Gender'] == "Other") echo 'selected'; ?>>Other</option>
        </select>

        <label for="phone_no">Phone Number:</label>
        <input type="text" id="phone_no" name="phone_no" value="<?php echo htmlspecialchars($patient['Phone_No']); ?>" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($patient['City']); ?>" required>

        <button type="submit">Update</button>
    </form>
</body>
</html>
