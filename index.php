<?php
include 'db.php';
session_start();

$doctors = [];
$doctor_query = "SELECT * FROM doctors";
$result = $conn->query($doctor_query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

$showPatientLoginForm = isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === true;
if ($showPatientLoginForm) {
    unset($_SESSION['registration_success']);
}

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
if ($error_message) {
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <style>
    body {
        background-image: url('homepage_background.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        flex-direction: column;
        font-family: Arial, sans-serif;
    }
   
     h1 {
        font-size: 48px;
        text-align: center;
        color: #ffffff;
        margin-top: 0;
        padding-top: 10px;
        margin-bottom: 20px;
    }
    nav {
        text-align: center;
        margin-bottom: 20px;
    }
    nav ul {
        list-style: none;
        padding: 0;
    }
    nav ul li {
        display: inline-block;
        margin: 0 15px;
    }
    nav ul li a {
        text-decoration: none;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    nav ul li a:hover {
        background-color: #45a049;
    }
    .form-container {
        background: rgba(255, 255, 255, 0.8);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        margin: 20px auto;
    }
    .patient-login-form {
        padding: 20px; /* Adjust padding as needed */
    }
    .patient-registration-form {
        padding: 30px; /* More padding for registration */
    }
    .form-container h2 {
        text-align: center;
        color: #333;
    }
    .form-container form {
        display: flex;
        flex-direction: column;
    }
    .form-container form label {
        margin: 10px 0 5px; /* Original margin */
    }
    .form-container form input,
    .form-container form select,
    .form-container form button {
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-container form button {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .form-container form button:hover {
        background-color: #45a049;
    }
    .registration-link {
        text-decoration: none;
        color: #4CAF50;
        display: block;
        text-align: center;
        margin-top: 10px;
    }
    .registration-link:hover {
        text-decoration: underline;
    }
    .error-message {
        color: red;
        text-align: center;
        margin-bottom: 20px;
    }
    .form-row {
        display: flex;
        justify-content: space-between;
    }
    .form-row label, .form-row input, .form-row select {
        flex: 1;
    }
    .form-row label {
        margin: 5px 0 5px; /* Reduces margin above the label */
    }
    .form-row input,
    .form-row select {
        margin-left: 8px;
    }
    .form-container form label[for="patient_phone"] {
        margin-top: 15px; /* Adds space before Phone label */
    }
    footer {
        text-align: left;
        width: 100%;
        padding: 10px 20px;
        background-color: rgba(255, 255, 255, 0.8);
        position: fixed;
        bottom: 0;
    }
</style>

    <script>
        function showLoginForm(formId) {
            const forms = document.querySelectorAll('.form-container');
            forms.forEach(form => form.style.display = 'none');

            const selectedForm = document.getElementById(formId);
            if (selectedForm) {
                selectedForm.style.display = 'block';
            }
        }

        function showRegistrationForm() {
            const forms = document.querySelectorAll('.form-container');
            forms.forEach(form => form.style.display = 'none');

            const registrationForm = document.getElementById('patientRegistrationForm');
            registrationForm.style.display = 'block';
        }
    </script>
</head>
<body>
   
        <h1>Harmony Wellness Hospital</h1>
    

    <nav>
        <ul>
            <li><a href="javascript:void(0);" onclick="showLoginForm('adminLoginForm')">Admin Log In</a></li>
            <li><a href="javascript:void(0);" onclick="showLoginForm('doctorLoginForm')">Doctor Log In</a></li>
            <li><a href="javascript:void(0);" onclick="showLoginForm('patientLoginForm')">Patient Log In</a></li>
        </ul>
    </nav>

    <?php if ($error_message): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div id="adminLoginForm" class="form-container" style="display:none;">
        <h2>Admin Login</h2>
        <form action="admin_login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>

<!---- Doctor Log in ---->

    <div id="doctorLoginForm" class="form-container" style="display:none;">
        <h2>Doctor Login</h2>
        <form action="doctor_login.php" method="post">
            <label for="doctor_username">Username:</label>
            <input type="text" id="doctor_username" name="doctor_username" required>
            <label for="doctor_password">Password:</label>
            <input type="password" id="doctor_password" name="doctor_password" required>
            <button type="submit">Login</button>
        </form>
    </div>
<!---- Patient Log in ---->
    <div id="patientLoginForm" class="form-container patient-login-form" style="<?php echo $showPatientLoginForm ? 'display: block;' : 'display: none;'; ?>">
        <h2>Patient Login</h2>
        <form action="patient_login.php" method="post">
            <label for="patient_username">Username:</label>
            <input type="text" id="patient_username" name="patient_username" required>
            <label for="patient_password">Password:</label>
            <input type="password" id="patient_password" name="patient_password" required>
            <button type="submit">Login</button>
        </form>
        <a class="registration-link" href="javascript:void(0);" onclick="showRegistrationForm()">New patient? Register Here</a>
    </div>

<!---- Patient Registration ---->    
    <div id="patientRegistrationForm" class="form-container patient-registration-form" style="display:none;">
    <h2>Patient Registration</h2>
    <form action="patient_register.php" method="post">
        <label for="patient_name">Patient Name:</label>
        <input type="text" id="patient_name" name="patient_name" required>

        <label for="patient_email">Email:</label>
        <input type="email" id="patient_email" name="patient_email" required>

        <div class="form-row">
            <label for="patient_password">Password:</label>
            <input type="password" id="patient_password" name="patient_password" required>

            <label for="patient_gender">Gender:</label>
            <select id="patient_gender" name="patient_gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <label for="patient_phone">Phone:</label>
        <input type="text" id="patient_phone" name="patient_phone" required>
        <label for="patient_city">City:</label>
        <input type="text" id="patient_city" name="patient_city" required>

        <button type="submit">Register</button>
    </form>
</div>

    <section>
        <h2>Doctors List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Specialization</th>
                <th>Doctor Name</th>
                <th>Doctor Fees</th>
            </tr>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?php echo $doctor['ID']; ?></td>
                    <td><?php echo $doctor['Specialization']; ?></td>
                    <td><?php echo $doctor['Doctor_Name']; ?></td>
                    <td><?php echo $doctor['Doctor_Fees']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>


    <footer>
        <p>For any queries or support, please contact us at <a href="mailto:support@harmonywellnesshospital.com">support@harmonywellnesshospital.com</a>.</p>
    </footer>
</body>
</html>
