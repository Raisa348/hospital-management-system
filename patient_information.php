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

// Fetch patient information from the relevant table
$query = "SELECT * FROM users"; // Adjust the table name if necessary
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
    <style>
        body {
            background-image: url('Admin-background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .heading {
            color: grey;
            font-size: 4rem;
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
            color: rgba(0, 0, 0, 0.7);
            font-weight: bold;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
        }

        h2 {
            color: rgba(0, 0, 0, 0.7);
            margin-bottom: 20px;
        }

        .edit-button {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            padding: 5px 10px; /* Some padding */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 0.9rem; /* Slightly smaller font */
            transition: background-color 0.3s; /* Transition for hover effect */
        }

        .edit-button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="heading">Patient Information</div>
    <table>
        <tr>
            <th>Patient ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Phone Number</th>
            <th>City</th>
            <th>Actions</th> <!-- New column for actions -->
        </tr>
        <?php if (count($patients) > 0): ?>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?php echo htmlspecialchars($patient['ID']); ?></td>
                    <td><?php echo htmlspecialchars($patient['Full_Name']); ?></td>
                    <td><?php echo htmlspecialchars($patient['Email']); ?></td>
                    <td><?php echo htmlspecialchars($patient['Gender']); ?></td>
                    <td><?php echo htmlspecialchars($patient['Phone_No']); ?></td>
                    <td><?php echo htmlspecialchars($patient['City']); ?></td>
                    <td>
                        <a href="edit_patient.php?id=<?php echo htmlspecialchars($patient['ID']); ?>" class="edit-button">Edit</a>
                    </td> <!-- Edit button -->
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No patient information available.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
