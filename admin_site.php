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

// Fetch appointments from the appointments_status table
$query = "SELECT * FROM booked_appointments";
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Site</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        section {
            width: 80%;
            margin-top: 20px;
            display: flex;
            justify-content: space-between; /* Ensure buttons are side by side */
            align-items: center;
        }

        .button {
            background-color: #ffcc00; /* A softer yellow color */
            color: black;
            border: 2px solid #e6b800; /* Slightly darker border */
            border-radius: 5px; /* Rounded corners */
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease; /* Smooth transition for hover effect */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Slight shadow */
            flex: 1; /* Make buttons take equal space */
            text-align: center; /* Center text inside button */
            margin: 0 10px; /* Add margin between buttons */
        }

        .button:hover {
            opacity: 0.8;
            transform: translateY(-2px); /* Slight lift on hover */
        }

        table {
            width: 100%;
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
    </style>
</head>
<body>
    <div class="heading">Admin Site</div>
    <section>
        <button class="button" onclick="window.location.href='booked_appointments.php'">Booked Appointments</button>
        <button class="button" onclick="window.location.href='doctors_schedule.php'">Doctors Schedule</button>
        <button class="button" onclick="window.location.href='patient_information.php'">Patient Information</button> <!-- New button added -->
    </section>
</body>
</html>
