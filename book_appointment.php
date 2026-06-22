<?php 
// filename: book_appointment.php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['patient_id']) || !isset($_SESSION['full_name'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: index.php');
    exit;
}

// Get doctor information from URL parameters
$doctor_id = $_GET['doctor_id'];
$doctor_name = $_GET['doctor_name'];
$specialization = $_GET['specialization'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Inter", Arial, Helvetica, sans-serif;
            background-image: url('Patient-profile-background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #07074d;
        }
        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-top: 50px;
        }
        .formbold-form-label {
            display: block;
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 12px;
        }
        .formbold-form-input {
            width: 100%;
            padding: 12px 24px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: white;
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            outline: none;
        }
        .formbold-btn {
            text-align: center;
            font-size: 16px;
            border-radius: 6px;
            padding: 14px 32px;
            border: none;
            font-weight: 600;
            background-color: #6a64f1;
            color: white;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }
        .formbold-btn:hover {
            background-color: #5a54f1;
        }
    </style>
</head>
<body>
    <div class="formbold-form-wrapper">
        <h1>Book Appointment</h1>
        <form action="submit_appointment.php" method="POST">
            <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($doctor_id); ?>">
            <input type="hidden" name="doctor_name" value="<?php echo htmlspecialchars($doctor_name); ?>">
            <input type="hidden" name="specialization" value="<?php echo htmlspecialchars($specialization); ?>">
            <div class="formbold-mb-5">
                <label for="name" class="formbold-form-label">Patient Name</label>
                <input type="text" name="name" id="name" placeholder="Full Name" class="formbold-form-input" required />
            </div>
            <div class="formbold-mb-5">
                <label for="age" class="formbold-form-label">Age</label>
                <input type="number" name="age" id="age" placeholder="Enter your age" class="formbold-form-input" required />
            </div>
            <div class="formbold-mb-5">
                <label for="gender" class="formbold-form-label">Gender</label>
                <select name="gender" id="gender" class="formbold-form-input" required>
                    <option value="" disabled selected>Select your gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="formbold-mb-5">
                <label for="phone" class="formbold-form-label">Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="Enter your phone number" class="formbold-form-input" required />
            </div>
            <div class="formbold-mb-5">
                <label for="email" class="formbold-form-label">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" class="formbold-form-input" required />
            </div>
            <div class="flex flex-wrap formbold--mx-3">
                <div class="w-full sm:w-half formbold-px-3">
                    <div class="formbold-mb-5 w-full">
                        <label for="date" class="formbold-form-label">Date</label>
                        <input type="date" name="date" id="date" class="formbold-form-input" required />
                    </div>
                </div>
                <div class="w-full sm:w-half formbold-px-3">
                    <div class="formbold-mb-5">
                        <label for="time" class="formbold-form-label">Time</label>
                        <input type="time" name="time" id="time" class="formbold-form-input" required />
                    </div>
                </div>
            </div>
            <div class="formbold-mb-5 formbold-pt-3">
                <label class="formbold-form-label formbold-form-label-2">Address Details</label>
                <div class="flex flex-wrap formbold--mx-3">
                    <div class="w-full sm:w-half formbold-px-3">
                        <div class="formbold-mb-5">
                            <input type="text" name="area" id="area" placeholder="Enter area" class="formbold-form-input" required />
                        </div>
                    </div>
                    <div class="w-full sm:w-half formbold-px-3">
                        <div class="formbold-mb-5">
                            <input type="text" name="city" id="city" placeholder="Enter city" class="formbold-form-input" required />
                        </div>
                    </div>
                    <div class="w-full sm:w-half formbold-px-3">
                        <div class="formbold-mb-5">
                            <input type="text" name="post-code" id="post-code" placeholder="Post Code" class="formbold-form-input" required />
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="formbold-btn">Book Appointment</button>
            </div>
        </form>
    </div>
</body>
</html>
