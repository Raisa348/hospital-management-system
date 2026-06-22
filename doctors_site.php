<?php
// filename: doctors_site.php
include 'db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['doctor_id']) || !isset($_SESSION['doctor_name'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: index.php');
    exit;
}

// Fetch the logged-in doctor's information from the database
$doctor_id = $_SESSION['doctor_id']; // Use the doctor ID from the session
$doctor_name = $_SESSION['doctor_name']; // Use the doctor name from the session

$stmt = $conn->prepare("SELECT * FROM doctors WHERE ID = ?");
if ($stmt) {
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();
    $stmt->close();
} else {
    // Handle query error
    echo "Error preparing statement: " . $conn->error;
    exit;
}

if (!$doctor) {
    // If doctor data is not found, log out the user and redirect to the login page
    session_destroy();
    header('Location: index.php');
    exit;
}

// Fetch confirmed appointments for the logged-in doctor
$appointments_query = "SELECT a.Appointment_ID, a.Patient_ID, a.Patient_Name, a.Gender, a.Age, a.Appointment_date, a.Appointment_time
                       FROM booked_appointments a
                       WHERE a.Doctor_ID = ? AND a.Status = 'Confirmed'"; // Filter for confirmed appointments
$stmt = $conn->prepare($appointments_query);
if (!$stmt) {
    // Output the error and exit if the statement preparation fails
    echo "Error preparing statement: " . $conn->error;
    exit;
}

// Bind the doctor ID parameter and execute the statement
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments_result = $stmt->get_result();

// Fetch the doctor's schedule (only fetch row corresponding to this doctor)
$schedule_query = "SELECT * FROM doctors_schedule WHERE Doctor_ID = ?"; // Use Doctor_ID for filtering
$stmt_schedule = $conn->prepare($schedule_query);
if (!$stmt_schedule) {
    echo "Error preparing statement for schedule: " . $conn->error;
    exit;
}

// Bind the doctor ID parameter and execute the statement
$stmt_schedule->bind_param("i", $doctor_id); // Bind doctor ID
$stmt_schedule->execute();
$schedule_result = $stmt_schedule->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <style>
        body {
            background-image: url('doctors_background.jpg'); /* Add your background image path here */
            background-size: cover; /* Make background cover the entire body */
            background-repeat: no-repeat; /* Prevent the background from repeating */
            color: white; /* Text color */
            font-family: Arial, sans-serif; /* Font style */
            height: 100vh; /* Full height */
            margin: 0; /* Remove default margin */
            display: flex; /* Flexbox for centering */
            flex-direction: column; /* Arrange children in a column */
            justify-content: flex-start; /* Align children to the top */
            align-items: center; /* Center children horizontally */
        }

        .header {
            text-align: center; /* Center text */
            background-color: rgba(0, 0, 0, 0.5); /* Black background with 50% transparency */
            padding: 20px; /* Padding around content */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Shadow effect */
            width: 100%; /* Full width */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .container {
            text-align: center; /* Center text */
            padding: 20px; /* Padding around content */
            margin-top: 20px; /* Space from the top */
            width: 80%; /* Adjust width as needed */
        }

        h1, h2 {
            margin: 0; /* Remove default margin */
        }

        .doctor-info, .appointments-table, .schedule-table {
            background-color: rgba(0, 0, 0, 0.5); /* Black background with 50% transparency */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Shadow effect */
            padding: 20px; /* Padding around content */
            margin-top: 20px; /* Space above sections */
        }

        .doctor-info p {
            margin: 5px 0; /* Adjust spacing between paragraphs */
        }

        table {
            width: 100%; /* Full width of the table */
            border-collapse: collapse; /* Remove spacing between cells */
            margin-top: 20px; /* Space above the table */
        }

        th, td {
            border: 1px solid white; /* White border for table cells */
            padding: 10px; /* Padding in table cells */
            text-align: left; /* Left align text */
        }

        th {
            background-color: rgba(0, 0, 0, 0.7); /* Dark background for header */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Profile</h1>
    </div>
    <div class="container">
        <div class="doctor-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor['Doctor_Name']); ?></p>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['Specialization']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($doctor['Address']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($doctor['Contact_No']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['Doctor_Email']); ?></p>
        </div>

        <div class="appointments-table">
            <h2>Your Appointments</h2>
            <table>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                </tr>
                <?php if ($appointments_result->num_rows > 0): ?>
                    <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['Appointment_ID']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Patient_ID']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Patient_Name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Gender']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Age']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['Appointment_time']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No confirmed appointments found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="schedule-table">
            <h2>Your Schedule</h2>
            <table>
                <tr>
                    <th>Schedule ID</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
                <?php if ($schedule_result->num_rows > 0): ?>
                    <?php while ($schedule = $schedule_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($schedule['Schedule_ID']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Saturday']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Sunday']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Monday']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Tuesday']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Wednesday']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Thursday']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['Friday']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No schedule found for this doctor.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
