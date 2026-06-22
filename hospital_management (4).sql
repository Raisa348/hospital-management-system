-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 11:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updationDate`) VALUES
(1, 'admin', 'password12345', '07-10-2024 11:42:05 AM');

-- --------------------------------------------------------

--
-- Table structure for table `booked_appointments`
--

CREATE TABLE `booked_appointments` (
  `Appointment_ID` int(11) NOT NULL,
  `Patient_ID` int(11) NOT NULL,
  `Patient_Name` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Patient_No` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(100) NOT NULL,
  `Specialization` varchar(100) NOT NULL,
  `Status` enum('Pending','Confirmed','Cancelled') NOT NULL,
  `Appointment_date` date NOT NULL,
  `Appointment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_appointments`
--

INSERT INTO `booked_appointments` (`Appointment_ID`, `Patient_ID`, `Patient_Name`, `Age`, `Gender`, `Email`, `Patient_No`, `Address`, `Doctor_ID`, `Doctor_Name`, `Specialization`, `Status`, `Appointment_date`, `Appointment_time`) VALUES
(3, 7, 'Rezaul Karim', 40, 'Male', 'rezaulkarim123@gmail.com', '01516060433', 'Kachpur Narayanganj', 4, 'Nirjon Islam', 'Orthopedics', 'Cancelled', '2024-10-05', '16:00:00'),
(4, 10, 'Mithila Rahman', 24, 'Female', 'mithila33@gmail.com', '01693909132', 'Abdullahpur Keraniganj', 3, 'Priyanka Saha', 'Pediatrics', 'Cancelled', '2024-10-05', '14:00:00'),
(5, 8, 'Farzana Akter', 25, 'Female', 'farzana34@gmail.com', '01833654782', 'Fatulla Narayanganj', 6, 'Bristi Akter', 'Obstetrics and Gynecology', 'Confirmed', '2024-10-06', '16:00:00'),
(6, 9, 'Mrinmoy Saha', 30, 'Male', 'mrinmoy23@gmail.com', '1993659782', 'Kapasia Gazipur', 4, 'Nirjon Islam', 'Orthopedics', 'Cancelled', '2024-10-07', '17:00:00'),
(7, 11, 'Parvin Akter', 40, 'Female', 'parvinakter456@gmail.com', '01816942678', 'Fazelpur Narayanganj', 3, 'Priyanka Saha', 'Pediatrics', 'Confirmed', '2024-10-08', '17:00:00'),
(8, 12, 'Sanjoy', 24, 'Male', 'sanjoy56@gmail.com', '1816942453', 'Chasara Narayanganj', 2, 'Charu Dia', 'Endocrinologists', 'Confirmed', '2024-10-07', '15:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `ID` int(11) NOT NULL,
  `Specialization` varchar(255) DEFAULT NULL,
  `Doctor_Name` varchar(255) DEFAULT NULL,
  `Address` longtext DEFAULT NULL,
  `Doctor_Fees` varchar(255) DEFAULT NULL,
  `Contact_No` bigint(11) DEFAULT NULL,
  `Doctor_Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Creation_Date` timestamp NULL DEFAULT current_timestamp(),
  `Update_Date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`ID`, `Specialization`, `Doctor_Name`, `Address`, `Doctor_Fees`, `Contact_No`, `Doctor_Email`, `Password`, `Creation_Date`, `Update_Date`) VALUES
(1, 'ENT', 'Sifat Ahmed', 'A 123 XYZ Apartment, Nur Nagar', '500', 142536250, 'sifatahmed123@test.com', 'Abcd15555', '2024-04-10 12:16:52', '2024-05-14 03:26:17'),
(2, 'Endocrinologists', 'Charu Dia', 'X 1212 ABC Apartment Gazipur', '800', 1231231230, 'charudia12@gmail.com', 'Abcd14444', '2024-04-10 19:06:41', '2024-05-14 03:26:28'),
(3, 'Pediatrics', 'Priyanka Saha', 'A 123 Xyz Apartment Mohammadpur', '700', 74561235, 'p12@t.com', 'Abcd13333', '2024-05-16 03:12:23', NULL),
(4, 'Orthopedics', 'Nirjon Islam', 'Z 456 House Jatrabari', '1000', 95214563210, 'nirjon123@gmail.com', 'Abcd12222', '2024-05-16 03:13:11', NULL),
(5, 'Internal Medicine', 'Dr Romil', 'Boshundhara Dhaka', '1100', 98706523127, 'romil12@gmail.com', 'Abcd11111', '2024-05-16 03:14:11', NULL),
(6, 'Obstetrics and Gynecology', 'Bristi Akter', 'AB Coloni Gazipur', '800', 745621330, 'bristi12@tt.com', 'Abcd10000', '2024-05-16 03:15:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctorspecilization`
--

CREATE TABLE `doctorspecilization` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorspecilization`
--

INSERT INTO `doctorspecilization` (`id`, `specilization`, `creationDate`, `updationDate`) VALUES
(1, 'Orthopedics', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(2, 'Internal Medicine', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(3, 'Obstetrics and Gynecology', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(4, 'Dermatology', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(5, 'Pediatrics', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(6, 'Radiology', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(7, 'General Surgery', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(8, 'Ophthalmology', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(9, 'Anesthesia', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(10, 'Pathology', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(11, 'ENT', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(12, 'Dental Care', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(13, 'Dermatologists', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(14, 'Endocrinologists', '2024-10-07 15:27:35', '2024-10-07 15:27:35'),
(15, 'Neurologists', '2024-10-07 15:27:35', '2024-10-07 15:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `doctors_schedule`
--

CREATE TABLE `doctors_schedule` (
  `Schedule_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(255) DEFAULT NULL,
  `Specialization` varchar(255) DEFAULT NULL,
  `Saturday` varchar(255) DEFAULT NULL,
  `Sunday` varchar(255) DEFAULT NULL,
  `Monday` varchar(255) DEFAULT NULL,
  `Tuesday` varchar(255) DEFAULT NULL,
  `Wednesday` varchar(255) DEFAULT NULL,
  `Thursday` varchar(255) DEFAULT NULL,
  `Friday` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors_schedule`
--

INSERT INTO `doctors_schedule` (`Schedule_ID`, `Doctor_ID`, `Doctor_Name`, `Specialization`, `Saturday`, `Sunday`, `Monday`, `Tuesday`, `Wednesday`, `Thursday`, `Friday`) VALUES
(2, 1, 'Sifat Ahmed', 'ENT', '11:00 am - 4:00 pm', '', '2:00 pm - 6:pm', '', '12:00 pm - 5:00 pm', '12:00 pm - 6:pm', '11:00 am - 4:00 pm'),
(3, 4, 'Nirjon Islam', 'Orthopedics', '', '12:00 pm - 4:pm', '', '1:00 pm - 6:pm', '2:00 pm - 6:00 pm', '11:00 am - 4:00 pm', ''),
(4, 6, 'Bristi Akter', 'Obstetrics and Gynecology', '10:00 am - 2:00 pm', '2:00 pm - 6:pm', '', '12:00 pm - 3:00 pm', '', '11:00 am - 4:00 pm', ''),
(5, 3, 'Priyanka Saha', 'Pediatrics', '11:00 am - 4:00 pm', '', '', '1:00 pm - 6:pm', '12:00 pm - 6:00 pm', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Full_Name` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Phone_No` int(11) NOT NULL,
  `Reg_Date` timestamp NULL DEFAULT current_timestamp(),
  `Update_Date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Full_Name`, `Gender`, `Email`, `City`, `Password`, `Phone_No`, `Reg_Date`, `Update_Date`) VALUES
(7, 'Rezaul Karim', 'Male', 'rezaulkarim123@gmail.com', 'Narayanganj', '$2y$10$1Asjbudp7Pdhld2uTNDii.JDUBESB3sDL4rWZqFrUbeeWe7Lsp6Y.', 1516060443, '2024-09-26 21:04:54', '2024-10-05 21:03:11'),
(8, 'Farzana Akter', 'Female', 'farzana34@gmail.com', 'Narayanganj', '$2y$10$t97EdjCpW3EaA9yFOmJCQOSfod2KRpmrGQwOfykSSNYqefREOg6DO', 1833654782, '2024-09-27 13:01:38', NULL),
(9, 'Mrinmoy Saha', 'Male', 'mrinmoy23@gmail.com', 'Gazipur', '$2y$10$r22M5HAZT25ilVVSNW9yc.3NRPc6xfAWBGnyGazJSnq065QTwP/he', 1993659782, '2024-09-27 21:14:29', NULL),
(10, 'Mithila Rahman ', 'Female', 'mithila35@gmail.com', 'Keraniganj', '$2y$10$V3dQLiMplQPWnxQlxFUxZ.YQlt2K9zfclBcLLVobqC5BQ69vKhENO', 1693909132, '2024-10-03 16:23:35', '2024-10-05 22:11:02'),
(11, 'Parvin Akter', 'Female', 'parvinakter456@gmail.com', 'Narayanganj', '$2y$10$BQA4wA9Wna9zCOAetxubz.m68waMUEOA1v..mKhTwjCIfSIRNm/w6', 1816942678, '2024-10-05 22:16:34', NULL),
(12, 'Sanjoy', 'Male', 'sanjoy56@gmail.com', 'Narayanganj', '$2y$10$8l2dDEpvzU9KBgjzz5w3H.ke5yKysLaR7Qwmo7k3T9KScIhttS8t.', 1816942453, '2024-10-06 08:19:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booked_appointments`
--
ALTER TABLE `booked_appointments`
  ADD PRIMARY KEY (`Appointment_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Doctor_ID` (`Doctor_ID`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  ADD PRIMARY KEY (`Schedule_ID`),
  ADD KEY `Doctor_ID` (`Doctor_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booked_appointments`
--
ALTER TABLE `booked_appointments`
  MODIFY `Appointment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  MODIFY `Schedule_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_appointments`
--
ALTER TABLE `booked_appointments`
  ADD CONSTRAINT `booked_appointments_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `booked_appointments_ibfk_2` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctors` (`ID`);

--
-- Constraints for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  ADD CONSTRAINT `doctors_schedule_ibfk_1` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctors` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
