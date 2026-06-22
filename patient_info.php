<?php
// filename: patient_info.php
include 'db.php'; // Include the database connection
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['patient_id']) || !isset($_SESSION['full_name'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: index.php');
    exit;
}

// Fetch the logged-in user's information from the database
$user_id = $_SESSION['patient_id']; // Use the patient ID from the session
$stmt = $conn->prepare("SELECT * FROM users WHERE ID = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    // Handle query error
    echo "Error preparing statement: " . $conn->error;
    exit;
}

if (!$user) {
    // If user data is not found, log out the user and redirect to the login page
    session_destroy();
    header('Location: index.php');
    exit;
}

// Fetch all doctors
$doctors = [];
$doctor_query = "SELECT * FROM doctors";
$result = $conn->query($doctor_query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}



// Fetch booked appointments made by the user
$booked_appointments = [];
$booked_query = "SELECT Doctor_ID, Doctor_Name, Specialization, Appointment_date, Appointment_time, Status 
                 FROM booked_appointments 
                 WHERE Patient_ID = ?";
$stmt = $conn->prepare($booked_query);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $booked_appointments[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <style>
        /* Existing CSS styles */
        body {
            background-image: url('Patient-profile-background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }
        .header {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            box-sizing: border-box;
        }
        .container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
            width: 80%;
        }
        h1, h2 {
            margin: 0;
        }
        .user-info {
            margin-top: 20px;
        }
        .user-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid white;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: rgba(0, 0, 0, 0.7);
        }
        td {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .appointment-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .appointment-button:hover {
            background-color: #45a049;
        }
        .sent-button {
            background-color: grey;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: default;
        }
    </style>
    <script>
        function showConfirmButton(button, doctorId, doctorName, specialization) {
            button.innerHTML = 'Are you sure?';
            button.onclick = function() {
                // Redirect to the appointment form page with parameters
                window.location.href = 'book_appointment.php?doctor_id=' + encodeURIComponent(doctorId) + '&doctor_name=' + encodeURIComponent(doctorName) + '&specialization=' + encodeURIComponent(specialization);
            };
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>Your Profile</h1>
    </div>
    <div class="container">
        <div class="user-info">
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['Full_Name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['Gender']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['City']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['Phone_No']); ?></p>
        </div>
    </div>


    <div class="container">
        <h2>Booked Appointments</h2>
        <table>
            <tr>
                <th>Doctor ID</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
            </tr>
            <?php foreach ($booked_appointments as $appointment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['Doctor_ID']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['Doctor_Name']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['Specialization']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['Appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['Appointment_time']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['Status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="container">
        <h2>Doctors List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Doctor Fee</th>
                <th>Action</th>
            </tr>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?php echo $doctor['ID']; ?></td>
                    <td><?php echo htmlspecialchars($doctor['Doctor_Name']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['Specialization']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['Doctor_Fees']); ?></td>
                    <td>
                        <button type="button" class="appointment-button" onclick="showConfirmButton(this, <?php echo htmlspecialchars(json_encode($doctor['ID'])); ?>, <?php echo htmlspecialchars(json_encode($doctor['Doctor_Name'])); ?>, <?php echo htmlspecialchars(json_encode($doctor['Specialization'])); ?>)">
                            Book Appointment
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
