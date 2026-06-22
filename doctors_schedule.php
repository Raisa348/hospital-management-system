<?php
// Include the database connection
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
    $doctor_name = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : '';
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : '';
    $saturday = isset($_POST['saturday']) ? $_POST['saturday'] : '';
    $sunday = isset($_POST['sunday']) ? $_POST['sunday'] : '';
    $monday = isset($_POST['monday']) ? $_POST['monday'] : '';
    $tuesday = isset($_POST['tuesday']) ? $_POST['tuesday'] : '';
    $wednesday = isset($_POST['wednesday']) ? $_POST['wednesday'] : '';
    $thursday = isset($_POST['thursday']) ? $_POST['thursday'] : '';
    $friday = isset($_POST['friday']) ? $_POST['friday'] : '';

    // Check if updating or inserting
    if (isset($_POST['schedule_id']) && !empty($_POST['schedule_id'])) {
        $schedule_id = $_POST['schedule_id'];
        $sql = "UPDATE doctors_schedule SET Doctor_ID='$doctor_id', Doctor_Name='$doctor_name', Specialization='$specialization', Saturday='$saturday', Sunday='$sunday', Monday='$monday', Tuesday='$tuesday', Wednesday='$wednesday', Thursday='$thursday', Friday='$friday' WHERE Schedule_ID='$schedule_id'";
    } else {
        $sql = "INSERT INTO doctors_schedule (Doctor_ID, Doctor_Name, Specialization, Saturday, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday) VALUES ('$doctor_id', '$doctor_name', '$specialization', '$saturday', '$sunday', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>Record updated successfully</div>";
    } else {
        echo "<div class='error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Fetch existing schedules
$sql = "SELECT * FROM doctors_schedule";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            flex-wrap: wrap;
            margin: 10px 0;
        }
        .form-group div {
            width: 45%; /* Each input occupies 45% of the row */
            margin-right: 5%; /* Space between the two inputs */
        }
        .form-group div:last-child {
            margin-right: 0; /* Remove margin for the last input */
        }
        .form-group label {
            display: block; /* Ensure labels are on top of inputs */
            margin-bottom: 5px; /* Space between label and input */
        }
        input[type="text"] {
            width: 100%; /* Make inputs take full width of their container */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        h3 {
            color: #333;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Doctors Schedule</h2>
    <form method="post" action="doctors_schedule.php">
        <input type="hidden" name="schedule_id" id="schedule_id">
        <div class="form-group">
            <div>
                <label for="doctor_id">Doctor ID:</label>
                <input type="text" name="doctor_id" id="doctor_id" required>
            </div>
            <div>
                <label for="doctor_name">Doctor Name:</label>
                <input type="text" name="doctor_name" id="doctor_name" required>
            </div>
        </div>
        <div class="form-group">
            <div>
                <label for="specialization">Specialization:</label>
                <input type="text" name="specialization" id="specialization" required>
            </div>
            <div>
                <label for="saturday">Saturday:</label>
                <input type="text" name="saturday" id="saturday">
            </div>
        </div>
        <div class="form-group">
            <div>
                <label for="sunday">Sunday:</label>
                <input type="text" name="sunday" id="sunday">
            </div>
            <div>
                <label for="monday">Monday:</label>
                <input type="text" name="monday" id="monday">
            </div>
        </div>
        <div class="form-group">
            <div>
                <label for="tuesday">Tuesday:</label>
                <input type="text" name="tuesday" id="tuesday">
            </div>
            <div>
                <label for="wednesday">Wednesday:</label>
                <input type="text" name="wednesday" id="wednesday">
            </div>
        </div>
        <div class="form-group">
            <div>
                <label for="thursday">Thursday:</label>
                <input type="text" name="thursday" id="thursday">
            </div>
            <div>
                <label for="friday">Friday:</label>
                <input type="text" name="friday" id="friday">
            </div>
        </div>
        <input type="submit" value="Submit">
    </form>

    <h3>Existing Schedules</h3>
    <table>
        <tr>
            <th>Schedule ID</th>
            <th>Doctor ID</th>
            <th>Doctor Name</th>
            <th>Specialization</th>
            <th>Saturday</th>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["Schedule_ID"]."</td>";
                echo "<td>".$row["Doctor_ID"]."</td>";
                echo "<td>".$row["Doctor_Name"]."</td>";
                echo "<td>".$row["Specialization"]."</td>";
                echo "<td>".$row["Saturday"]."</td>";
                echo "<td>".$row["Sunday"]."</td>";
                echo "<td>".$row["Monday"]."</td>";
                echo "<td>".$row["Tuesday"]."</td>";
                echo "<td>".$row["Wednesday"]."</td>";
                echo "<td>".$row["Thursday"]."</td>";
                echo "<td>".$row["Friday"]."</td>";
                echo "<td><a href='javascript:void(0);' onclick='editSchedule(".json_encode($row).")'>Edit</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No schedules found</td></tr>";
        }
        ?>
    </table>

    <script>
        function editSchedule(data) {
            document.getElementById('schedule_id').value = data.Schedule_ID;
            document.getElementById('doctor_id').value = data.Doctor_ID;
            document.getElementById('doctor_name').value = data.Doctor_Name;
            document.getElementById('specialization').value = data.Specialization;
            document.getElementById('saturday').value = data.Saturday;
            document.getElementById('sunday').value = data.Sunday;
            document.getElementById('monday').value = data.Monday;
            document.getElementById('tuesday').value = data.Tuesday;
            document.getElementById('wednesday').value = data.Wednesday;
            document.getElementById('thursday').value = data.Thursday;
            document.getElementById('friday').value = data.Friday;
        }
    </script>
</body>
</html>
