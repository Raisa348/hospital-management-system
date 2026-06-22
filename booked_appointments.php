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

// Fetch appointments from the booked_appointments table
$query = "SELECT * FROM booked_appointments";
$result = mysqli_query($conn, $query);

// Check for query errors
if ($result === false) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch all appointments
$appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Appointments</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('Admin-background.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .heading {
            color: white;
            font-size: 4rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        section {
            width: 60%; /* Reduced the width */
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 100%;
            max-width: 800px; /* Set a maximum width for the table */
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid black;
            color: rgba(0, 0, 0, 0.7);
            font-weight: bold;
            font-size: 0.8rem; /* Further reduced font size */
        }

        th, td {
            padding: 5px; /* Further reduced padding */
            text-align: left;
            word-wrap: break-word; /* Allow text to wrap within cells */
        }

        th {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
        }

        h2 {
            color: rgba(0, 0, 0, 0.7);
            margin-bottom: 20px;
        }

        .status-button {
            background-color: #007bff; /* Blue color */
            color: white;
            border: none;
            padding: 5px 10px; /* Reduced padding */
            cursor: pointer;
            border-radius: 5px;
        }

        .cancel-button {
            background-color: #dc3545; /* Red color */
            color: white;
            border: none;
            padding: 5px 10px; /* Reduced padding */
            cursor: pointer;
            border-radius: 5px;
            margin-top: 5px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid black;
            padding: 20px;
            z-index: 100;
        }

        .popup button {
            margin: 5px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }
    </style>
    <script>
        function showPopup(appointmentId, type) {
            const popup = document.getElementById(`popup-${type}-${appointmentId}`);
            const overlay = document.getElementById('overlay');
            popup.style.display = 'block';
            overlay.style.display = 'block';
        }

        function hidePopup(type, appointmentId) {
            const popup = document.getElementById(`popup-${type}-${appointmentId}`);
            const overlay = document.getElementById('overlay');
            popup.style.display = 'none';
            overlay.style.display = 'none';
        }

        function confirmAction(appointmentId, action) {
            const statusCell = document.getElementById(`status-${appointmentId}`);
            
            let newStatus = '';
            if (action === 'pending') {
                newStatus = 'Confirmed';
            } else if (action === 'cancel') {
                newStatus = 'Cancelled';
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    statusCell.innerText = newStatus;
                    hidePopup(action, appointmentId);
                }
            };
            xhr.send("appointment_id=" + appointmentId + "&status=" + newStatus);
        }
    </script>
</head>
<body>
    <div class="heading">Booked Appointments</div>
    <section>
        <table>
            <tr>
                <th>Appointment ID</th>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Address</th>
                <th>Doctor ID</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Status</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
            </tr>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo $appointment['Appointment_ID']; ?></td>
                    <td><?php echo $appointment['Patient_ID']; ?></td>
                    <td><?php echo $appointment['Patient_Name']; ?></td>
                    <td><?php echo $appointment['Age']; ?></td>
                    <td><?php echo $appointment['Gender']; ?></td>
                    <td><?php echo $appointment['Email']; ?></td>
                    <td><?php echo $appointment['Patient_No']; ?></td>
                    <td><?php echo $appointment['Address']; ?></td>
                    <td><?php echo $appointment['Doctor_ID']; ?></td>
                    <td><?php echo $appointment['Doctor_Name']; ?></td>
                    <td><?php echo $appointment['Specialization']; ?></td>
                    <td id="status-<?php echo $appointment['Appointment_ID']; ?>">
                        <?php if ($appointment['Status'] === 'Pending'): ?>
                            <button class="status-button" onclick="showPopup(<?php echo $appointment['Appointment_ID']; ?>, 'pending')">Confirm</button>
                            <button class="cancel-button" onclick="showPopup(<?php echo $appointment['Appointment_ID']; ?>, 'cancel')">Cancel</button>
                            <div id="popup-pending-<?php echo $appointment['Appointment_ID']; ?>" class="popup">
                                <p>Are you sure you want to confirm this appointment?</p>
                                <button onclick="confirmAction(<?php echo $appointment['Appointment_ID']; ?>, 'pending')">OK</button>
                                <button onclick="hidePopup('pending', <?php echo $appointment['Appointment_ID']; ?>)">No</button>
                            </div>
                            <div id="popup-cancel-<?php echo $appointment['Appointment_ID']; ?>" class="popup">
                                <p>Are you sure you want to cancel this appointment?</p>
                                <button onclick="confirmAction(<?php echo $appointment['Appointment_ID']; ?>, 'cancel')">OK</button>
                                <button onclick="hidePopup('cancel', <?php echo $appointment['Appointment_ID']; ?>)">No</button>
                            </div>
                        <?php else: ?>
                            <span><?php echo $appointment['Status']; ?></span>
                            <?php if ($appointment['Status'] === 'Confirmed'): ?>
                                <button class="cancel-button" onclick="showPopup(<?php echo $appointment['Appointment_ID']; ?>, 'cancel')">Cancel</button>
                                <div id="popup-cancel-<?php echo $appointment['Appointment_ID']; ?>" class="popup">
                                    <p>Are you sure you want to cancel this appointment?</p>
                                    <button onclick="confirmAction(<?php echo $appointment['Appointment_ID']; ?>, 'cancel')">OK</button>
                                    <button onclick="hidePopup('cancel', <?php echo $appointment['Appointment_ID']; ?>)">No</button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $appointment['Appointment_date']; ?></td>
                    <td><?php echo $appointment['Appointment_time']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
    <div id="overlay" class="overlay" onclick="hidePopup()"></div>
</body>
</html>
