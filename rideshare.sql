-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2026 at 03:09 PM
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
-- Database: `rideshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `announcement_id` int(11) NOT NULL,
  `announcement_title` varchar(100) NOT NULL,
  `announcement_description` text NOT NULL,
  `announcement_content` varchar(255) DEFAULT NULL,
  `announcement_applicable_to` varchar(20) NOT NULL,
  `announcement_created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `announcement_last_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `announcement_status` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_announcement`
--

INSERT INTO `tbl_announcement` (`announcement_id`, `announcement_title`, `announcement_description`, `announcement_content`, `announcement_applicable_to`, `announcement_created_at`, `announcement_last_updated`, `announcement_status`) VALUES
(1, '🚗 EcoRide App Version 3.0 Launch!', 'We are excited to announce the launch of EcoRide App Version 3.0 with amazing new features:\r\n\r\n1. **Real-time Carpool Matching** - Find rides instantly\r\n2. **Enhanced Safety Features** - Emergency contact integration\r\n3. **Carbon Tracker** - Monitor your environmental impact\r\n4. **In-app Chat** - Communicate with drivers/passengers easily\r\n5. **Reward Dashboard** - Track your green points in real-time\r\n\r\nUpdate now from your app store to enjoy these features!', NULL, 'ALL', '2026-01-10 09:00:00', '2026-02-08 15:21:42', 'ACTIVE'),
(3, '🏆 Driver of the Month Awards', 'Congratulations to our top performing drivers for January 2026:\r\n\r\n🥇 **1st Place:** Ahmad Jamil - RM500 + Gold Badge\r\n🥈 **2nd Place:** Siti Rahman - RM300 + Silver Badge  \r\n🥉 **3rd Place:** Raj Kumar - RM200 + Bronze Badge\r\n\r\n**Selection Criteria:**\r\n1. Highest passenger rating (4.8+)\r\n2. Most rides completed (50+)\r\n3. Zero cancellation rate\r\n4. Excellent passenger feedback\r\n\r\nKeep up the great work! Next month could be YOU!', '../upload/announcement/ann_1770528197_c242d8c0.png', 'DRIVER,STAFF', '2026-01-28 11:00:00', '2026-02-08 23:58:11', 'INACTIVE'),
(4, '⚠️ System Maintenance Notice', 'Important: EcoRide platform will undergo scheduled maintenance:\r\n\r\n**Date:** February 5, 2026\r\n**Time:** 2:00 AM - 6:00 AM (GMT+8)\r\n**Affected Services:**\r\n1. Booking system (temporary unavailable)\r\n2. Payment processing (delays expected)\r\n3. Real-time tracking (limited functionality)\r\n\r\n**What to do:**\r\n• Complete rides before maintenance window\r\n• Schedule rides after 6:00 AM\r\n• Contact support for urgent matters\r\n\r\nWe apologize for any inconvenience caused.', NULL, 'ALL', '2026-01-20 16:45:00', '2026-01-30 12:26:16', 'ACTIVE'),
(5, '🌱 New Sustainability Partnership', 'Exciting News! EcoRide has partnered with GreenMalaysia Initiative:\r\n\r\n**Partnership Benefits:**\r\n1. **Tree Planting Program** - Each 100 rides = 1 tree planted\r\n2. **Carbon Offset Certification** - Get official recognition\r\n3. **Eco Workshops** - Free sessions for top contributors\r\n4. **Green Merchandise** - Exclusive eco-friendly products\r\n\r\n**Launch Event:** February 15, 2026 @ APU Auditorium\r\n**RSVP Required:** Limited seats available\r\n\r\nJoin us in making Malaysia greener!', NULL, 'ALL', '2026-01-18 10:15:00', '2026-01-30 12:26:11', 'ACTIVE'),
(6, '📱 Staff Training: New Admin Dashboard', 'Attention all staff members:\r\n\r\nNew admin dashboard training sessions have been scheduled:\r\n\r\n**Session 1:** February 2, 2026 (10:00 AM - 12:00 PM)\r\n**Session 2:** February 3, 2026 (2:00 PM - 4:00 PM)\r\n**Session 3:** February 4, 2026 (3:00 PM - 5:00 PM)\r\n\r\n**Training Topics:**\r\n1. User management system\r\n2. Driver verification process  \r\n3. Report generation tools\r\n4. Support ticket handling\r\n5. Analytics dashboard\r\n\r\n**Location:** EcoRide HQ, Training Room 3\r\n**Mandatory:** All staff must attend one session', NULL, 'STAFF', '2026-01-22 13:20:00', '2026-01-30 12:26:28', 'ACTIVE'),
(7, '🚘 Electric Vehicle Promotion Program', 'Drivers! Upgrade to electric vehicles with our EV Promotion:\r\n\r\n**Special Benefits for EcoRide Drivers:**\r\n1. **15% Discount** on selected EV models\r\n2. **Free Installation** of home charging station\r\n3. **Priority Access** to public charging stations\r\n4. **Reduced Commission** rate for EV drivers\r\n\r\n**Participating Brands:**\r\n• Tesla • Nissan • BYD • Hyundai • BMW\r\n\r\n**Eligibility Requirements:**\r\n• Minimum 100 completed rides\r\n• 4.5+ passenger rating\r\n• Valid driving license\r\n\r\nApply before March 31, 2026!', '../upload/announcement/ann_1770528206_6fc14692.png', 'DRIVER', '2026-01-25 15:10:00', '2026-02-08 15:07:49', 'ACTIVE'),
(8, '🎁 Referral Program Update', 'Enhanced Referral Program Now Live!\r\n\r\n**New Bonus Structure:**\r\n1. Refer a friend (both get RM10 credit)\r\n2. Refer 5 friends (get RM100 + 500 points)\r\n3. Refer 10 friends (get RM250 + 1000 points)\r\n4. Top referrer monthly (get RM500 bonus)\r\n\r\n**How to Refer:**\r\n1. Go to Profile → Referral\r\n2. Share your unique code/link\r\n3. Friend signs up with your code\r\n4. Both get rewards instantly\r\n\r\n**Terms:** Friend must complete 3 rides to qualify\r\n\r\nStart referring today!', NULL, 'USER', '2026-01-30 09:45:00', '2026-02-09 00:08:09', 'INACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `booking_id` int(11) NOT NULL,
  `booking_offer_id` int(11) NOT NULL,
  `booking_passenger_username` varchar(50) NOT NULL,
  `booking_status` varchar(20) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`booking_id`, `booking_offer_id`, `booking_passenger_username`, `booking_status`) VALUES
(1, 1, 'alice.smith', 'ACCEPTED'),
(2, 1, 'bob.johnson', 'ACCEPTED'),
(3, 1, 'charlie.brown', 'ACCEPTED'),
(4, 2, 'diana.ross', 'ACCEPTED'),
(5, 2, 'edward.miller', 'ACCEPTED'),
(6, 3, 'fiona.clark', 'ACCEPTED'),
(7, 3, 'george.white', 'ACCEPTED'),
(8, 3, 'hannah.martin', 'ACCEPTED'),
(9, 3, 'ian.thompson', 'ACCEPTED'),
(10, 4, 'jessica.davis', 'ACCEPTED'),
(11, 4, 'kevin.walker', 'ACCEPTED'),
(12, 4, 'lily.adams', 'ACCEPTED'),
(13, 5, 'mohammed.hassan', 'ACCEPTED'),
(14, 5, 'nora.james', 'ACCEPTED'),
(15, 8, 'oscar.king', 'ACCEPTED'),
(16, 8, 'alice.smith', 'ACCEPTED'),
(17, 9, 'bob.johnson', 'ACCEPTED'),
(18, 9, 'charlie.brown', 'ACCEPTED'),
(19, 9, 'diana.ross', 'ACCEPTED'),
(20, 9, 'edward.miller', 'ACCEPTED'),
(21, 10, 'fiona.clark', 'ACCEPTED'),
(22, 10, 'george.white', 'ACCEPTED'),
(23, 10, 'hannah.martin', 'ACCEPTED'),
(24, 11, 'ian.thompson', 'PENDING'),
(25, 11, 'jessica.davis', 'ACCEPTED'),
(26, 12, 'kevin.walker', 'ACCEPTED'),
(27, 12, 'lily.adams', 'DECLINED'),
(28, 13, 'mohammed.hassan', 'ACCEPTED'),
(29, 13, 'nora.james', 'PENDING'),
(30, 13, 'oscar.king', 'ACCEPTED'),
(31, 14, 'alice.smith', 'PENDING'),
(32, 14, 'bob.johnson', 'ACCEPTED'),
(33, 15, 'charlie.brown', 'ACCEPTED'),
(34, 16, 'diana.ross', 'ACCEPTED'),
(35, 16, 'edward.miller', 'PENDING'),
(36, 16, 'fiona.clark', 'DECLINED'),
(37, 17, 'george.white', 'PENDING'),
(38, 18, 'hannah.martin', 'ACCEPTED'),
(39, 19, 'ian.thompson', 'ACCEPTED'),
(40, 19, 'jessica.davis', 'PENDING'),
(41, 20, 'kevin.walker', 'PENDING'),
(42, 20, 'lily.adams', 'DECLINED'),
(43, 21, 'mohammed.hassan', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_service`
--

CREATE TABLE `tbl_customer_service` (
  `service_id` int(11) NOT NULL,
  `service_username` varchar(50) NOT NULL,
  `service_reason` varchar(100) NOT NULL,
  `service_description` text NOT NULL,
  `service_response` text DEFAULT NULL,
  `service_status` varchar(10) NOT NULL DEFAULT 'INCOMPLETE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_service`
--

INSERT INTO `tbl_customer_service` (`service_id`, `service_username`, `service_reason`, `service_description`, `service_response`, `service_status`) VALUES
(6, 'alice.smith', 'Payment Issue', 'I was charged twice for my ride on Jan 20. Can you refund the duplicate charge? Transaction ID: PAY789012', NULL, 'INCOMPLETE'),
(7, 'bob.johnson', 'Account Problem', 'I cannot log into my account. It says \"Invalid credentials\" even though I\'m sure my password is correct.', NULL, 'INCOMPLETE'),
(8, 'ahmad.jamil', 'Technical Issue', 'The app crashes every time I try to update my vehicle information. Using Android version 3.0.', NULL, 'INCOMPLETE'),
(9, 'charlie.brown', 'Booking Problem', 'I booked a ride but the driver cancelled last minute. My points were deducted but ride didn\'t happen.', NULL, 'INCOMPLETE'),
(10, 'siti.rahman', 'Document Verification', 'I uploaded my new road tax 3 days ago but it\'s still showing as \"pending verification\".', NULL, 'INCOMPLETE'),
(11, 'diana.ross', 'Reward Issue', 'I redeemed 300 points for fuel discount but didn\'t receive the voucher code in my email.', NULL, 'INCOMPLETE'),
(12, 'wei.chen', 'Rating Problem', 'A passenger gave me 1 star without reason. Can this be reviewed? It\'s affecting my overall rating unfairly.', NULL, 'INCOMPLETE'),
(13, 'edward.miller', 'App Bug', 'The map shows wrong pickup location. My actual location is 500m away from what the app shows.', NULL, 'INCOMPLETE'),
(14, 'fatimah.ali', 'Payment Delay', 'My earnings from last week haven\'t been transferred to my bank account yet. Usually it comes within 2 days.', 'ok check again ur bank account we have issue this problem', 'COMPLETE'),
(15, 'raj.kumar', 'Safety Concern', 'A passenger was smoking in my car despite clear no-smoking policy. What should I do in such situations?', 'Dear Raj, we apologize for this experience. Please report such passengers immediately through the app. We will issue them a warning. For smoke smell, you may claim cleaning fee. - Support Team', 'COMPLETE'),
(16, 'fiona.clark', 'Refund Request', 'My ride was cancelled by driver 5 minutes before pickup. I need a refund as I had to book a more expensive taxi.', 'Hi Fiona, we have processed a full refund of RM12.50 to your account. The amount will appear within 3-5 business days. Sorry for the inconvenience. - Sarah Jones', 'COMPLETE'),
(17, 'john.doe', 'Feature Request', 'Can you add an option for drivers to set preferred pickup/dropoff radius? Some locations are hard to access.', 'Thank you for the suggestion! We\'ve forwarded this to our development team. This feature is planned for Q2 2026 release. - David Chen', 'COMPLETE'),
(18, 'george.white', 'Account Security', 'I think someone else accessed my account. I see rides I didn\'t book. Please secure my account.', 'Hi George, we have reset your password and logged out all devices. Please check your email for password reset link. We also recommend enabling 2FA. - Lisa Wong', 'COMPLETE'),
(19, 'maria.garcia', 'Policy Clarification', 'What is the policy for passengers who are consistently late? Can we charge extra waiting time?', 'Dear Maria, drivers can charge waiting fee after 5 minutes (RM0.50/min). Please use the \"Passenger late\" option in the app. Repeated late passengers may face restrictions. - Michael Tan', 'COMPLETE'),
(20, 'james.wilson', 'Account Issues', 'aaa', NULL, 'INCOMPLETE'),
(21, 'james.wilson', 'Ride/Booking Issues', 'aaa', NULL, 'INCOMPLETE'),
(22, 'alice.smith', 'Payment and Refund Issues', 'aaa', NULL, 'INCOMPLETE'),
(23, 'alice.smith', 'Ride/Booking Issues', 'aaa', 'okok', 'COMPLETE'),
(24, 'alice.smith', 'Ride/Booking Issues', 'aaa', NULL, 'INCOMPLETE'),
(25, 'james.wilson', 'Ride/Booking Issues', 'aaa', NULL, 'INCOMPLETE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_driver_info`
--

CREATE TABLE `tbl_driver_info` (
  `driver_username` varchar(50) NOT NULL,
  `driver_profile_image` varchar(255) NOT NULL,
  `driver_plate_no` varchar(15) NOT NULL,
  `driver_vehicle_model` varchar(50) NOT NULL,
  `driver_vehicle_color` varchar(20) NOT NULL,
  `driver_vehicle_image` varchar(255) NOT NULL,
  `driver_license_image` varchar(255) NOT NULL,
  `driver_license_expiry` date NOT NULL,
  `driver_road_tax_image` varchar(255) NOT NULL,
  `driver_road_tax_expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_driver_info`
--

INSERT INTO `tbl_driver_info` (`driver_username`, `driver_profile_image`, `driver_plate_no`, `driver_vehicle_model`, `driver_vehicle_color`, `driver_vehicle_image`, `driver_license_image`, `driver_license_expiry`, `driver_road_tax_image`, `driver_road_tax_expiry`) VALUES
('ahmad.jamil', '../upload/driverInfo/driver_profile_1769744331_697c27cb9efb7.png', 'ABC1234', 'Proton Saga 2020', 'White', '../upload/driverInfo/driver_vehicle_1769744894_697c29feee9dd.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e6e927.png', '2025-12-31', '../upload/driverInfo/driver_road_tax_1769745193_697c2b298cb24.png', '2024-06-30'),
('fatimah.ali', '../upload/driverInfo/driver_profile_1769744331_697c27cba180b.png', 'EFG7890', 'Perodua Axia 2023', 'Black', '../upload/driverInfo/driver_vehicle_1769744894_697c29feeff41.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e701dd.png', '2025-06-30', '../upload/driverInfo/driver_road_tax_1769745193_697c2b298de84.png', '2024-12-31'),
('james.wilson', '../upload/driverInfo/driver_profile_1769744331_697c27cba38a4.png', 'HIJ9012', 'Proton Persona 2018', 'Red', '../upload/driverInfo/driver_vehicle_1769744894_697c29fef10ce.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e715f6.png', '2024-05-31', '../upload/driverInfo/driver_road_tax_1769745193_697c2b298f5b2.png', '2024-02-29'),
('john.doe', '../upload/driverInfo/driver_profile_1769744331_697c27cba548e.png', 'FGH1234', 'Proton X50 2022', 'Red', '../upload/driverInfo/driver_vehicle_1769744894_697c29fef25f3.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e727fd.png', '2027-01-31', '../upload/driverInfo/driver_road_tax_1769745193_697c2b2990d9b.png', '2025-08-31'),
('maria.garcia', '../upload/driverInfo/driver_profile_1769744331_697c27cba637d.png', 'GHI5678', 'Perodua Bezza 2020', 'Gray', '../upload/driverInfo/driver_vehicle_1769744894_697c29fef3cdd.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e738df.png', '2025-09-30', '../upload/driverInfo/driver_road_tax_1769745193_697c2b2991a9c.png', '2024-03-31'),
('nurul.hassan', '../upload/driverInfo/driver_profile_1769744331_697c27cba789e.png', 'IJK3456', 'Honda HR-V 2021', 'White', '../upload/driverInfo/driver_vehicle_1769744895_697c29ff01483.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e746de.png', '2026-07-31', '../upload/driverInfo/driver_road_tax_1769745193_697c2b299295b.png', '2025-05-31'),
('raj.kumar', '../upload/driverInfo/driver_profile_1769744331_697c27cba8d6b.png', 'DEF3456', 'Toyota Vios 2019', 'Blue', '../upload/driverInfo/driver_vehicle_1769744895_697c29ff02b17.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e756f4.png', '2024-11-30', '../upload/driverInfo/driver_road_tax_1769745193_697c2b2993803.png', '2024-01-31'),
('raviraj871212-08-7890', '../upload/driverInfo/driver_profile_1769746229_697c2f35cae66.png', 'EFG7890', 'Proton X70 2023', 'Gray', '../upload/driverInfo/driver_vehicle_1769746229_697c2f35cc0eb.png', '../upload/driverInfo/driver_license_1769746229_697c2f35cdb66.png', '2026-06-30', '../upload/driverInfo/driver_road_tax_1769746458_697c301a12708.png', '2026-02-28'),
('samuel.tan', '../upload/driverInfo/driver_profile_1769744331_697c27cba9d2c.png', 'VDT8111', 'Toyota Corolla 2020', 'Red', '../upload/driverInfo/driver_vehicle_1769744895_697c29ff0476c.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e7664a.png', '2025-04-30', '../upload/driverInfo/driver_road_tax_1769745193_697c2b2994920.png', '2024-11-30'),
('siti.rahman', '../upload/driverInfo/driver_profile_1769744331_697c27cbaaeca.png', 'VGX4207', 'Perodua Myvi 2022', 'Red', '../upload/driverInfo/driver_vehicle_1769744895_697c29ff05a46.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e772f3.png', '2024-08-15', '../upload/driverInfo/driver_road_tax_1769745193_697c2b2995846.png', '2024-04-30'),
('wei.chen', '../upload/driverInfo/driver_profile_1769744331_697c27cbac2a1.png', 'VFM8037', 'Honda City 2021', 'White', '../upload/driverInfo/driver_vehicle_1769744895_697c29ff06f60.png', '../upload/driverInfo/driver_license_1769745054_697c2a9e77f79.png', '2026-03-31', '../upload/driverInfo/driver_road_tax_1769745193_697c2b2996586.png', '2025-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_driver_request`
--

CREATE TABLE `tbl_driver_request` (
  `request_id` int(11) NOT NULL,
  `request_profile_image` varchar(255) NOT NULL,
  `request_name` varchar(100) NOT NULL,
  `request_ic_passport` varchar(20) NOT NULL,
  `request_gender` varchar(10) NOT NULL,
  `request_dob` date NOT NULL,
  `request_contact` varchar(20) NOT NULL,
  `request_email` varchar(255) NOT NULL,
  `request_plate_no` varchar(15) NOT NULL,
  `request_vehicle_model` varchar(50) NOT NULL,
  `request_vehicle_color` varchar(20) NOT NULL,
  `request_vehicle_image` varchar(255) NOT NULL,
  `request_license_image` varchar(255) NOT NULL,
  `request_license_expiry` date NOT NULL,
  `request_road_tax_image` varchar(255) NOT NULL,
  `request_road_tax_expiry` date NOT NULL,
  `request_submitted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_driver_request`
--

INSERT INTO `tbl_driver_request` (`request_id`, `request_profile_image`, `request_name`, `request_ic_passport`, `request_gender`, `request_dob`, `request_contact`, `request_email`, `request_plate_no`, `request_vehicle_model`, `request_vehicle_color`, `request_vehicle_image`, `request_license_image`, `request_license_expiry`, `request_road_tax_image`, `request_road_tax_expiry`, `request_submitted_at`) VALUES
(1, '../upload/driverRequest/request_profile_1769746229_697c2f35badf5.png', 'Mohd Ali bin Hassan', '910505-10-1234', 'MALE', '1991-05-05', '016-11223344', 'mohd.ali91@gmail.com', 'MCD1234', 'Proton Iriz 2023', 'Blue', '../upload/driverRequest/request_vehicle_1769746229_697c2f35bc06a.png', '../upload/driverRequest/request_license_1769746229_697c2f35bcec0.png', '2025-08-31', '../upload/driverRequest/request_road_tax_1769746458_697c301a0b6df.png', '2026-07-31', '2026-01-15 14:30:00'),
(2, '../upload/driverRequest/request_profile_1769746229_697c2f35beb6a.png', 'Lim Siew Mei', '950812-08-5678', 'FEMALE', '1995-08-12', '017-22334455', 'lim.siew.mei@outlook.com', 'PDN5678', 'Perodua Ativa 2024', 'Red', '../upload/driverRequest/request_vehicle_1769746229_697c2f35bfa8c.png', '../upload/driverRequest/request_license_1769746229_697c2f35c08ef.png', '2028-03-31', '../upload/driverRequest/request_road_tax_1769746458_697c301a0e9a8.png', '2026-11-30', '2026-01-20 10:15:00'),
(3, '../upload/driverRequest/request_profile_1769746229_697c2f35c237b.png', 'Suresh Kumar', '881111-08-9012', 'MALE', '1988-11-11', '018-33445566', 'suresh.kumar88@yahoo.com', 'WXY9012', 'Toyota Camry 2022', 'White', '../upload/driverRequest/request_vehicle_1769746229_697c2f35c31eb.png', '../upload/driverRequest/request_license_1769746229_697c2f35c4107.png', '2026-10-31', '../upload/driverRequest/request_road_tax_1769746458_697c301a0fdf4.png', '2026-04-30', '2026-01-25 16:45:00'),
(4, '../upload/driverRequest/request_profile_1769746229_697c2f35c65b5.png', 'Amina Binti Zainal', '930303-14-3456', 'FEMALE', '1993-03-03', '019-44556677', 'amina.zainal93@gmail.com', 'BCD3456', 'Honda Civic 2021', 'White', '../upload/driverRequest/request_vehicle_1769746229_697c2f35c7423.png', '../upload/driverRequest/request_license_1769746229_697c2f35c86bc.png', '2027-12-31', '../upload/driverRequest/request_road_tax_1769746458_697c301a11436.png', '2026-09-30', '2026-01-28 09:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_driver_update`
--

CREATE TABLE `tbl_driver_update` (
  `update_id` int(11) NOT NULL,
  `update_driver_username` varchar(50) NOT NULL,
  `update_plate_no` varchar(15) NOT NULL,
  `update_vehicle_model` varchar(50) NOT NULL,
  `update_vehicle_color` varchar(20) NOT NULL,
  `update_vehicle_image` varchar(255) NOT NULL,
  `update_road_tax_image` varchar(255) NOT NULL,
  `update_road_tax_expiry` date NOT NULL,
  `update_submitted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_driver_update`
--

INSERT INTO `tbl_driver_update` (`update_id`, `update_driver_username`, `update_plate_no`, `update_vehicle_model`, `update_vehicle_color`, `update_vehicle_image`, `update_road_tax_image`, `update_road_tax_expiry`, `update_submitted_at`) VALUES
(1, 'ahmad.jamil', 'ABC5678', 'Proton X70 2024', 'Gray', '../upload/driverUpdate/update_vehicle_1769746744_697c3138ac152.png', '../upload/driverUpdate/update_road_tax_1769746744_697c3138ad92f.png', '2026-12-31', '2026-01-28 14:30:00'),
(2, 'siti.rahman', 'BCC9999', 'Perodua Ativa 2025', 'Blue', '../upload/driverUpdate/update_vehicle_1769746744_697c3138aef39.png', '../upload/driverUpdate/update_road_tax_1769746744_697c3138b5829.png', '2027-06-30', '2026-01-25 10:15:00'),
(3, 'raj.kumar', 'VKE5804', 'Toyota Hilux 2023', 'White', '../upload/driverUpdate/update_vehicle_1769746744_697c3138b0b1a.png', '../upload/driverUpdate/update_road_tax_1769746744_697c3138b3749.png', '2026-01-31', '2026-01-29 16:45:00'),
(4, 'john.doe', 'SMK3457', 'Tesla Model 3 2024', 'Gray', '../upload/driverUpdate/update_vehicle_1769746744_697c3138b294f.png', '../upload/driverUpdate/update_road_tax_1769746744_697c3138afd4c.png', '2027-03-31', '2026-01-27 11:20:00'),
(5, 'nurul.hassan', 'VJU697', 'Honda Civic 2024', 'Black', '../upload/driverUpdate/update_vehicle_1769746744_697c3138b4625.png', '../upload/driverUpdate/update_road_tax_1769746744_697c3138b1bc3.png', '2026-11-30', '2026-01-30 09:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `faq_id` int(11) NOT NULL,
  `faq_question` varchar(225) NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_applicable_to` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`faq_id`, `faq_question`, `faq_answer`, `faq_applicable_to`) VALUES
(1, 'How do I earn Green Points?', 'You can earn Green Points by: 1) Choosing eco-friendly rides, 2) Carpooling with other users, 3) Using electric or hybrid vehicles, 4) Maintaining a high eco-driving score, 5) Participating in sustainability events, and 6) Referring friends to the platform.', 'BOTH'),
(2, 'What can I redeem with my Green Points?', 'Green Points can be redeemed for various rewards including: fuel discounts, EV charging sessions, eco-car washes, sustainable products, carbon offset certificates, and exclusive sustainability workshops. Check the Rewards section for current offers.', 'BOTH'),
(3, 'How is CO2 savings calculated for each trip?', 'Our system calculates CO2 savings based on: distance traveled, vehicle type (electric/hybrid/petrol), number of passengers, and fuel efficiency. Each completed eco-ride shows your personal carbon reduction in kilograms.', 'BOTH'),
(4, 'Do electric vehicle drivers earn more Green Points?', 'Yes! Electric vehicle (EV) drivers earn 50% more Green Points per trip compared to petrol vehicles. Hybrid vehicle drivers earn 25% more. This incentive encourages cleaner transportation options.', 'DRIVER'),
(5, 'How do I become an EV Elite driver?', 'To join the EV Elite program: 1) Register your electric vehicle, 2) Complete 20 successful EV trips, 3) Maintain a 4.5+ star rating, 4) Complete the eco-driving course. Benefits include priority matching and exclusive rewards.', 'DRIVER'),
(6, 'What makes a ride \"eco-friendly\"?', 'Eco-friendly rides are those that: 1) Use electric or hybrid vehicles, 2) Maintain optimal fuel efficiency, 3) Follow efficient routes, 4) Have multiple passengers (carpooling), 5) Use our recommended eco-driving techniques.', 'BOTH'),
(7, 'Can I track my cumulative environmental impact?', 'Yes! Go to your Profile → Sustainability Dashboard to see: total CO2 saved, trees equivalent planted, total green points earned, and your environmental impact score compared to other users.', 'USER'),
(8, 'What is the carpool matching algorithm?', 'Our algorithm matches passengers going to similar destinations based on: location proximity, destination similarity, schedule compatibility, and user preferences. The system prioritizes matches that maximize carbon reduction.', 'USER'),
(9, 'How do I report a non-eco-friendly driver?', 'After your trip, rate the driver and select \"Report Sustainability Issues\". You can flag: excessive idling, aggressive acceleration/braking, or non-compliance with eco-driving guidelines. Reports are reviewed by our green team.', 'USER'),
(10, 'Are there discounts for frequent carpool users?', 'Yes! Users who carpool regularly receive: 1) 10% discount on every 5th carpool ride, 2) Bonus Green Points for consistent carpooling, 3) Priority matching with preferred carpool partners.', 'USER'),
(11, 'What vehicle requirements exist for eco-drivers?', 'Eco-drivers must: 1) Maintain road tax and insurance validity, 2) Keep vehicle well-maintained for optimal efficiency, 3) Pass emission standards test annually, 4) Have valid eco-driving certification (free course provided).', 'DRIVER'),
(12, 'How do I claim my reward after redemption?', 'After redeeming Green Points: 1) Receive a digital voucher in your account, 2) Show the QR code at participating partners, 3) For online rewards, use the provided promo code, 4) Physical items are shipped within 5-7 business days.', 'BOTH'),
(13, 'What happens if my reward voucher expires?', 'Expired vouchers cannot be extended. However, you can contact support within 7 days of expiration for a one-time 50% Green Points refund. We recommend using rewards before their validity period ends.', 'BOTH'),
(14, 'Can I transfer my Green Points to another user?', 'No, Green Points are non-transferable and tied to your account. They cannot be sold, traded, or gifted to other users to maintain platform integrity and prevent misuse.', 'BOTH'),
(15, 'How often are new rewards added?', 'New rewards are added monthly! We partner with sustainable businesses to bring you exciting offers. Subscribe to notifications and check the Rewards section regularly for latest additions.', 'BOTH'),
(16, 'What is the eco-driving score and how is it calculated?', 'Your eco-driving score (0-100) is based on: smooth acceleration/braking, optimal speed maintenance, efficient route following, minimal idling time, and proper vehicle maintenance. Scores above 80 earn bonus Green Points.', 'DRIVER'),
(17, 'Do I need special insurance for ride-sharing?', 'Yes, all drivers must have valid ride-sharing endorsement on their insurance policy. We partner with insurers offering special rates for eco-vehicle drivers. Contact support for recommended providers.', 'DRIVER'),
(18, 'How can I maximize my carbon savings?', 'Maximize savings by: 1) Always choosing carpool options, 2) Selecting electric/hybrid vehicles, 3) Traveling during off-peak hours, 4) Combining multiple errands in one trip, 5) Maintaining good eco-driving habits.', 'USER'),
(19, 'What happens if my driver cancels an eco-ride?', 'If a driver cancels after acceptance: 1) You receive priority rematching, 2) Get 20 bonus Green Points as compensation, 3) Driver\'s cancellation rate affects their eco-driver status, 4) Frequent cancellations may lead to suspension.', 'USER');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_status` varchar(20) NOT NULL DEFAULT 'INACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`location_id`, `location_name`, `location_status`) VALUES
(1, 'Technology Park Malaysia', 'ACTIVE'),
(2, 'Parkhill Resort Condominium', 'INACTIVE'),
(3, 'Bukit Jalil LRT Station', 'ACTIVE'),
(4, 'Sunway Geo Residence', 'ACTIVE'),
(5, 'Sri Petaling', 'ACTIVE'),
(6, 'LRT - BK5', 'INACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `login_username` varchar(50) NOT NULL,
  `login_password` varchar(225) NOT NULL,
  `login_role` varchar(20) NOT NULL,
  `login_status` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`login_username`, `login_password`, `login_role`, `login_status`) VALUES
('admin.carol', '$2y$10$4hDTbF9/fV3lG/sfs6Lnnul2d.5n4djcBvl6emHKwJtrhv2O7ED.u', 'ADMIN', 'ACTIVE'),
('admin.maya', '$2y$10$4hDTbF9/fV3lG/sfs6Lnnul2d.5n4djcBvl6emHKwJtrhv2O7ED.u', 'ADMIN', 'ACTIVE'),
('admin.raju', '$2y$10$4hDTbF9/fV3lG/sfs6Lnnul2d.5n4djcBvl6emHKwJtrhv2O7ED.u', 'ADMIN', 'ACTIVE'),
('ahmad.jamil', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('alice.smith', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('amelia.kumar', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('bob.johnson', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'BLOCKED'),
('charlie.brown', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('daniel.lee', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'BLOCKED'),
('david.chen', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('diana.ross', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('edward.miller', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('fatimah.ali', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('fiona.clark', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('george.white', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('hannah.martin', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'BLOCKED'),
('ian.thompson', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('james.wilson', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'BLOCKED'),
('jessica.davis', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('john.doe', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('kevin.ng', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('kevin.walker', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('lily.adams', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('lisa.wong', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('maria.garcia', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('michael.tan', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('mohammed.hassan', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('nora.james', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('nurul.hassan', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('oscar.king', '$2y$10$gf.bAYbTpnGiLd51EOaPuuvRgsCaC9tqX3aiXWl3OFdBT3wsQyUI.', 'USER', 'ACTIVE'),
('priya.sharma', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('raj.kumar', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('raviraj871212-08-7890', '$2y$10$Dk91blM4apcf63OkyHpYL.HI8lgJwMs7oLq0f7MdoAznlJxAUNlqq', 'DRIVER', 'ACTIVE'),
('ryan.lim', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('samuel.tan', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('sarah.jones', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('siti.rahman', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE'),
('sofia.ahmad', '$2y$10$eNiBDBGSAI2lCbKBbPv4b.1u59vSabS3BR1VjAD8Je1cOaKWkurQ2', 'STAFF', 'ACTIVE'),
('wei.chen', '$2y$10$T17kAwmWL/Ou0JDnJf/K6OuLl1u6hILvOoHFOyRuKHkyV5qvBISu6', 'DRIVER', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_message`
--

CREATE TABLE `tbl_message` (
  `message_id` int(11) NOT NULL,
  `message_sender` varchar(50) NOT NULL,
  `message_receiver` varchar(50) NOT NULL,
  `message_content` text NOT NULL,
  `message_created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `message_status` varchar(10) NOT NULL DEFAULT 'UNSEEN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_message`
--

INSERT INTO `tbl_message` (`message_id`, `message_sender`, `message_receiver`, `message_content`, `message_created_at`, `message_status`) VALUES
(1, 'alice.smith', 'ahmad.jamil', 'Hi, I\'ve booked your ride for tomorrow at 7:30 AM. Where exactly will you be waiting?', '2026-01-30 15:30:00', 'SEEN'),
(2, 'ahmad.jamil', 'alice.smith', 'I\'ll be at the main entrance of Parkhill Condo. Silver Proton Saga with plate ABC1234.', '2026-01-30 15:32:00', 'SEEN'),
(3, 'bob.johnson', 'siti.rahman', 'Can you wait an extra 5 minutes? Running slightly late from my class.', '2026-01-25 16:45:00', 'SEEN'),
(4, 'siti.rahman', 'bob.johnson', 'Sure, no problem. I\'ll wait at the usual spot.', '2026-01-25 16:46:00', 'SEEN'),
(5, 'wei.chen', 'charlie.brown', 'Just confirming our ride tomorrow at 8 AM. See you at Bukit Jalil LRT!', '2026-01-20 20:15:00', 'SEEN'),
(6, 'raj.kumar', 'diana.ross', 'My car is in the workshop today. Need to cancel our ride, sorry!', '2026-01-21 10:30:00', 'SEEN'),
(7, 'edward.miller', 'fiona.clark', 'Want to share a ride to campus tomorrow? I found a good offer.', '2026-01-24 19:20:00', 'UNSEEN'),
(8, 'george.white', 'hannah.martin', 'Are you taking the 5 PM ride from APU today?', '2026-01-25 14:15:00', 'SEEN'),
(9, 'sarah.jones', 'alice.smith', 'Hi Alice, we noticed an issue with your reward redemption. Can you check your email?', '2026-01-28 11:00:00', 'SEEN'),
(10, 'david.chen', 'bob.johnson', 'Your driver verification is complete. You can now start offering rides.', '2026-01-15 09:30:00', 'SEEN'),
(11, 'lisa.wong', 'charlie.brown', 'Your reported issue has been resolved. Thank you for your patience.', '2026-01-22 16:45:00', 'UNSEEN'),
(12, 'admin.carol', 'sarah.jones', 'Please review the driver applications submitted this week.', '2026-01-29 10:00:00', 'SEEN'),
(13, 'admin.maya', 'david.chen', 'The monthly report is due tomorrow. Please submit by 5 PM.', '2026-01-30 14:30:00', 'UNSEEN'),
(14, 'admin.raju', 'lisa.wong', 'We need to discuss the new safety features implementation.', '2026-01-28 15:20:00', 'SEEN'),
(15, 'hannah.martin', 'ian.thompson', 'Did you get the ride confirmation for tomorrow?', '2026-01-29 18:30:00', 'SEEN'),
(16, 'ian.thompson', 'jessica.davis', 'The driver just messaged - he\'s running 10 minutes late.', '2026-01-26 07:50:00', 'SEEN'),
(17, 'jessica.davis', 'kevin.walker', 'Want to split a ride to Sri Petaling after class?', '2026-01-27 15:40:00', 'UNSEEN'),
(18, 'kevin.walker', 'lily.adams', 'My usual driver isn\'t available. Any recommendations?', '2026-01-28 19:15:00', 'SEEN'),
(19, 'lily.adams', 'mohammed.hassan', 'Thanks for sharing the ride yesterday!', '2026-01-24 09:20:00', 'SEEN'),
(20, 'mohammed.hassan', 'nora.james', 'Are you taking the morning ride tomorrow?', '2026-01-29 21:10:00', 'UNSEEN'),
(21, 'nora.james', 'oscar.king', 'The carpool kit reward is really useful!', '2026-01-23 12:30:00', 'SEEN'),
(22, 'oscar.king', 'fatimah.ali', 'Can you pick me up from Sunway Geo instead?', '2026-01-22 08:45:00', 'SEEN'),
(23, 'fatimah.ali', 'john.doe', 'Thanks for the 5-star review! Really appreciate it.', '2026-01-27 10:20:00', 'SEEN'),
(24, 'michael.tan', 'maria.garcia', 'Your road tax document needs to be updated in the system.', '2026-01-25 11:15:00', 'SEEN'),
(25, 'priya.sharma', 'james.wilson', 'A passenger has filed a complaint. Please check your dashboard.', '2026-01-24 14:50:00', 'SEEN'),
(26, 'kevin.ng', 'nurul.hassan', 'Congratulations on being Driver of the Month!', '2026-01-29 16:30:00', 'UNSEEN'),
(27, 'sofia.ahmad', 'samuel.tan', 'Your vehicle inspection is scheduled for next Monday.', '2026-01-26 10:40:00', 'SEEN'),
(28, 'ryan.lim', 'ahmad.jamil', 'Great job maintaining a 5-star rating!', '2026-01-23 13:25:00', 'SEEN'),
(29, 'amelia.kumar', 'siti.rahman', 'Please submit your updated license before it expires.', '2026-01-20 09:55:00', 'SEEN'),
(30, 'daniel.lee', 'wei.chen', 'Your reward points have been credited. Check your account.', '2026-01-21 17:10:00', 'SEEN'),
(31, 'maria.garcia', 'admin.carol', 'I\'m having trouble with the new app update.', '2026-01-27 08:30:00', 'SEEN'),
(32, 'james.wilson', 'admin.maya', 'Can you approve my vehicle update request?', '2026-01-26 15:45:00', 'UNSEEN'),
(33, 'nurul.hassan', 'admin.raju', 'Thanks for the EV promotion information!', '2026-01-25 12:20:00', 'SEEN'),
(34, 'samuel.tan', 'sarah.jones', 'My profile picture isn\'t updating. Can you help?', '2026-01-24 10:15:00', 'SEEN'),
(35, 'john.doe', 'david.chen', 'When will the double points campaign start?', '2026-01-23 14:30:00', 'SEEN'),
(36, 'raj.kumar', 'lisa.wong', 'I want to report a passenger for no-show.', '2026-01-22 19:40:00', 'SEEN'),
(37, 'charlie.brown', 'michael.tan', 'How do I redeem my carbon certificate?', '2026-01-21 11:25:00', 'SEEN'),
(38, 'diana.ross', 'priya.sharma', 'My account was charged twice for a ride.', '2026-01-20 16:50:00', 'UNSEEN'),
(39, 'edward.miller', 'kevin.ng', 'The app keeps crashing on my phone.', '2026-01-19 09:35:00', 'SEEN'),
(40, 'fiona.clark', 'sofia.ahmad', 'Can I change my pickup location for an upcoming ride?', '2026-01-18 13:20:00', 'SEEN'),
(41, 'george.white', 'ryan.lim', 'I haven\'t received my referral bonus.', '2026-01-17 15:45:00', 'UNSEEN'),
(42, 'hannah.martin', 'amelia.kumar', 'My green points seem incorrect.', '2026-01-16 10:30:00', 'SEEN'),
(43, 'ian.thompson', 'daniel.lee', 'The EV test drive reward - how do I book it?', '2026-01-15 14:15:00', 'SEEN'),
(44, 'oscar.king', 'admin.carol', 'Urgent: My account was hacked! Someone booked rides using my credit card. Need immediate assistance.', '2026-01-30 08:15:00', 'SEEN'),
(45, 'james.wilson', 'admin.carol', 'Regarding the driver incentive program - can we discuss increasing the commission rates for top-rated drivers?', '2026-01-30 10:30:00', 'SEEN'),
(46, 'lily.adams', 'admin.carol', 'I want to report inappropriate behavior from a driver during my ride yesterday. This needs immediate attention.', '2026-01-30 11:45:00', 'UNSEEN'),
(47, 'daniel.lee', 'admin.carol', 'The analytics dashboard is showing incorrect data for January. Revenue figures seem inflated by 15%.', '2026-01-30 13:20:00', 'SEEN'),
(48, 'nora.james', 'admin.carol', 'Media inquiry from The Star newspaper about our sustainability initiatives. They want an interview next week.', '2026-01-30 15:40:00', 'UNSEEN'),
(49, 'michael.tan', 'admin.carol', 'Monthly staff performance reviews are ready for your approval. Please review by Friday.', '2026-01-29 09:00:00', 'SEEN'),
(50, 'kevin.walker', 'admin.carol', 'Suggestion: Could we implement a premium carpool service for corporate clients? I have potential leads.', '2026-01-29 14:25:00', 'SEEN'),
(51, 'sofia.ahmad', 'admin.carol', 'Budget approval needed for Q2 marketing campaign. Proposal document attached in email.', '2026-01-29 16:50:00', 'UNSEEN'),
(52, 'amelia.kumar', 'admin.carol', 'Username: hannah.martin\nReason: Scam or suspicious request\nDetails: aaaa', '2026-01-31 15:45:38', 'UNSEEN');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_poll`
--

CREATE TABLE `tbl_poll` (
  `poll_id` int(11) NOT NULL,
  `poll_title` varchar(100) NOT NULL,
  `poll_description` varchar(255) NOT NULL,
  `poll_created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_poll`
--

INSERT INTO `tbl_poll` (`poll_id`, `poll_title`, `poll_description`, `poll_created_at`) VALUES
(1, 'Should APU provide more EV charging stations on campus?', 'Vote on whether Asia Pacific University should install more electric vehicle charging stations to encourage sustainable transportation.', '2026-01-07 08:43:24'),
(3, 'Is RM0.50 per minute a fair price for eco-friendly rides?', 'Given the environmental benefits and fuel savings, do you think the current pricing for green rides is reasonable?', '2026-01-11 02:34:03'),
(4, 'Should drivers with electric vehicles get priority in ride matching?', 'Should the app prioritize matching passengers with electric vehicle drivers to promote cleaner transportation?', '2026-01-17 23:00:35'),
(5, 'Should there be a carbon tax on solo rides to encourage carpooling?', 'Should solo rides incur a small additional \"carbon tax\" to incentivize carpooling and reduce emissions?', '2026-01-05 06:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_redeem`
--

CREATE TABLE `tbl_redeem` (
  `redeem_id` int(11) NOT NULL,
  `redeem_reward_id` int(11) NOT NULL,
  `redeem_username` varchar(50) NOT NULL,
  `redeem_status` varchar(10) NOT NULL DEFAULT 'UNUSED',
  `redeem_redeemed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_redeem`
--

INSERT INTO `tbl_redeem` (`redeem_id`, `redeem_reward_id`, `redeem_username`, `redeem_status`, `redeem_redeemed_at`) VALUES
(1, 1, 'alice.smith', 'USED', '2026-01-05 10:30:00'),
(2, 2, 'bob.johnson', 'UNUSED', '2026-01-10 14:15:00'),
(3, 3, 'charlie.brown', 'USED', '2026-01-15 09:45:00'),
(4, 6, 'diana.ross', 'UNUSED', '2026-01-18 16:20:00'),
(5, 5, 'edward.miller', 'USED', '2026-01-20 11:10:00'),
(6, 1, 'fiona.clark', 'UNUSED', '2026-01-22 13:25:00'),
(7, 2, 'george.white', 'USED', '2026-01-25 15:40:00'),
(8, 6, 'hannah.martin', 'USED', '2026-01-28 10:05:00'),
(9, 8, 'ian.thompson', 'UNUSED', '2026-01-29 14:50:00'),
(10, 3, 'jessica.davis', 'USED', '2026-01-30 09:15:00'),
(11, 1, 'kevin.walker', 'UNUSED', '2026-01-12 11:30:00'),
(12, 2, 'lily.adams', 'USED', '2026-01-14 16:45:00'),
(13, 5, 'mohammed.hassan', 'USED', '2026-01-17 13:20:00'),
(14, 6, 'nora.james', 'UNUSED', '2026-01-21 10:55:00'),
(15, 8, 'oscar.king', 'USED', '2026-01-24 14:10:00'),
(16, 1, 'ahmad.jamil', 'USED', '2026-01-02 08:30:00'),
(17, 2, 'siti.rahman', 'UNUSED', '2026-01-07 12:15:00'),
(18, 4, 'wei.chen', 'USED', '2026-01-11 15:40:00'),
(19, 7, 'raj.kumar', 'UNUSED', '2026-01-16 09:25:00'),
(20, 5, 'fatimah.ali', 'USED', '2026-01-19 14:50:00'),
(21, 1, 'john.doe', 'USED', '2026-01-23 11:05:00'),
(22, 2, 'maria.garcia', 'UNUSED', '2026-01-26 16:20:00'),
(23, 4, 'james.wilson', 'USED', '2026-01-27 10:35:00'),
(24, 7, 'nurul.hassan', 'UNUSED', '2026-01-28 13:40:00'),
(25, 8, 'samuel.tan', 'USED', '2026-01-29 15:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `review_id` int(11) NOT NULL,
  `review_offer_id` int(11) NOT NULL,
  `review_passenger_username` varchar(50) NOT NULL,
  `review_rating` int(11) NOT NULL,
  `review_comment` text DEFAULT NULL,
  `review_created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `review_status` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_review`
--

INSERT INTO `tbl_review` (`review_id`, `review_offer_id`, `review_passenger_username`, `review_rating`, `review_comment`, `review_created_at`, `review_status`) VALUES
(1, 1, 'alice.smith', 5, 'Excellent driver! Very punctual and safe driving. Car was clean and comfortable.', '2026-01-20 09:15:00', 'ACTIVE'),
(2, 1, 'bob.johnson', 4, 'Good ride overall. Driver was friendly but a bit quiet. Arrived on time.', '2026-01-20 09:30:00', 'ACTIVE'),
(3, 1, 'charlie.brown', 5, 'Perfect carpool experience. Would definitely ride with Ahmad again!', '2026-01-20 10:00:00', 'ACTIVE'),
(4, 2, 'diana.ross', 5, 'Siti is a wonderful driver! Very polite and the car smells nice too.', '2026-01-20 18:45:00', 'ACTIVE'),
(5, 2, 'edward.miller', 4, 'Comfortable ride home. Slightly longer route taken but still good.', '2026-01-20 19:00:00', 'ACTIVE'),
(6, 3, 'fiona.clark', 3, 'Driver was okay but played music too loud. Arrived on time though.', '2026-01-21 09:20:00', 'ACTIVE'),
(7, 3, 'george.white', 4, 'Good conversation and safe driving. Car was a bit cramped with 4 people.', '2026-01-21 09:30:00', 'ACTIVE'),
(8, 3, 'hannah.martin', 5, 'Wei is very professional! Will book again for sure.', '2026-01-21 10:00:00', 'ACTIVE'),
(9, 3, 'ian.thompson', 4, 'Reliable service. Got me to class on time.', '2026-01-21 10:15:00', 'ACTIVE'),
(10, 4, 'jessica.davis', 5, 'Raj is amazing! Very friendly and even offered water bottles.', '2026-01-21 19:15:00', 'ACTIVE'),
(11, 4, 'kevin.walker', 2, 'Driver was 10 minutes late picking up. Otherwise okay.', '2026-01-21 19:30:00', 'ACTIVE'),
(12, 4, 'lily.adams', 4, 'Good ride home. Comfortable seats and smooth driving.', '2026-01-21 20:00:00', 'ACTIVE'),
(13, 5, 'mohammed.hassan', 5, 'Fatimah is a very safe driver. Perfect for morning commutes.', '2026-01-22 08:30:00', 'ACTIVE'),
(14, 5, 'nora.james', 4, 'Nice car and driver. Would recommend to friends.', '2026-01-22 08:45:00', 'ACTIVE'),
(15, 8, 'oscar.king', 1, 'Terrible experience. Car was dirty and driver was rude. Would not recommend.', '2026-01-25 08:30:00', 'ACTIVE'),
(16, 8, 'alice.smith', 3, 'Got me to campus but the ride was bumpy and uncomfortable.', '2026-01-25 09:00:00', 'ACTIVE'),
(17, 9, 'bob.johnson', 5, 'Nurul is the best! Very professional and the car is always spotless.', '2026-01-25 18:30:00', 'ACTIVE'),
(18, 9, 'charlie.brown', 4, 'Good ride home. Traffic was heavy but driver handled it well.', '2026-01-25 19:00:00', 'ACTIVE'),
(19, 9, 'diana.ross', 5, 'Perfect as always! My favorite driver on the platform.', '2026-01-25 19:15:00', 'ACTIVE'),
(20, 9, 'edward.miller', 4, 'Reliable service. Will book again next week.', '2026-01-25 19:30:00', 'ACTIVE'),
(21, 10, 'fiona.clark', 5, 'Samuel is excellent! Very punctual and the car is luxurious.', '2026-01-26 09:30:00', 'ACTIVE'),
(22, 10, 'george.white', 4, 'Good ride. A bit expensive but worth it for the comfort.', '2026-01-26 10:00:00', 'ACTIVE'),
(23, 10, 'hannah.martin', 5, 'Best carpool experience so far! Five stars!', '2026-01-26 10:15:00', 'ACTIVE'),
(24, 3, 'ian.thompson', 1, 'WORST DRIVER EVER! Almost got into an accident!', '2026-01-21 10:30:00', 'INACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reward`
--

CREATE TABLE `tbl_reward` (
  `reward_id` int(11) NOT NULL,
  `reward_title` varchar(100) NOT NULL,
  `reward_description` text NOT NULL,
  `reward_content` varchar(255) DEFAULT NULL,
  `reward_required_point` int(11) NOT NULL,
  `reward_quantity` int(11) NOT NULL,
  `reward_valid_days` int(11) NOT NULL,
  `reward_applicable_to` varchar(20) NOT NULL,
  `reward_status` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reward`
--

INSERT INTO `tbl_reward` (`reward_id`, `reward_title`, `reward_description`, `reward_content`, `reward_required_point`, `reward_quantity`, `reward_valid_days`, `reward_applicable_to`, `reward_status`) VALUES
(1, 'Petronas Fuel Discount Voucher', 'Enjoy 20% discount on fuel purchases at any Petronas station nationwide. Valid for one-time use with minimum purchase of RM30. Not combinable with other promotions. Redeemable during station operating hours (6:00 AM - 12:00 AM).', '../upload/reward/rwd_1769746982_be2c356c.png', 300, 45, 30, 'BOTH', 'ACTIVE'),
(2, 'Eco-Friendly Car Wash Service', 'Free premium eco-friendly car wash at GreenWash outlets. Uses biodegradable cleaning agents and water-saving technology. Valid at all GreenWash branches (check website for locations). Appointment required via their mobile app. Service available daily from 8:00 AM to 8:00 PM.', '../upload/reward/rwd_1769746874_7d55f17b.png', 300, 75, 14, 'BOTH', 'ACTIVE'),
(3, 'EV Test Drive Experience', 'Exclusive 2-hour test drive of the latest Nissan Leaf electric vehicle at authorized dealerships. Includes guided tour of EV features and charging demonstration. Must have valid driving license and be above 21 years old. Prior appointment required (Mon-Sat, 9:00 AM - 5:00 PM).', '../upload/reward/rwd_1769746940_025bc685.png', 800, 18, 60, 'USER', 'ACTIVE'),
(4, 'Premium Eco Car Tires (20% Off)', 'Get 20% discount on Continental EcoContact tires at participating outlets. Tires feature reduced rolling resistance for better fuel efficiency. Installation charges not included. Valid at authorized Continental dealers. Present voucher during purchase.', '../upload/reward/rwd_1769746913_ca5f0c82.png', 1000, 28, 90, 'DRIVER', 'ACTIVE'),
(5, 'Solar Panel Consultation Package', 'Free professional consultation for home solar panel installation worth RM500. Includes energy audit, roof assessment, and customized quotation. Consultation lasts approximately 2 hours. Available at EcoSolar branches by appointment only (Mon-Fri, 9:00 AM - 6:00 PM).', '../upload/reward/rwd_1769747020_a21ab729.png', 500, 37, 365, 'BOTH', 'ACTIVE'),
(6, 'Public Transportation Monthly Pass', 'Complimentary MyRapid monthly pass for unlimited travel on RapidKL buses and trains. Physical card will be mailed within 5 working days after redemption. Valid from first use date. Replacement fee applies for lost cards.', NULL, 100, 97, 30, 'USER', 'INACTIVE'),
(7, 'Car Pool Accessories', 'Premium carpooling kit including \"Carpool\" windshield sign, eco-friendly air freshener, and phone mount. Perfect for dedicated carpool drivers. Kit will be shipped to your registered address within 7-14 working days after redemption.', '../upload/reward/rwd_1770630837_90fb5934.png', 50, 148, 90, 'DRIVER', 'ACTIVE'),
(8, 'Carbon Offset Certificate', 'Official certificate recognizing your contribution to carbon reduction through carpooling. Includes plantation of one tree in your name at the National Greening Project. Certificate will be emailed in PDF format. Makes a great eco-conscious gift or office display.', '../upload/reward/rwd_1769747114_3917c2e1.png', 800, 197, 365, 'BOTH', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ride_offer`
--

CREATE TABLE `tbl_ride_offer` (
  `offer_id` int(11) NOT NULL,
  `offer_driver_username` varchar(50) NOT NULL,
  `offer_type_of_ride` varchar(20) NOT NULL,
  `offer_location_id` int(11) NOT NULL,
  `offer_date` date NOT NULL,
  `offer_time` time NOT NULL,
  `offer_price_per_minute` decimal(10,2) NOT NULL,
  `offer_seat_available` int(11) NOT NULL,
  `offer_status` varchar(20) NOT NULL DEFAULT 'INCOMPLETE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ride_offer`
--

INSERT INTO `tbl_ride_offer` (`offer_id`, `offer_driver_username`, `offer_type_of_ride`, `offer_location_id`, `offer_date`, `offer_time`, `offer_price_per_minute`, `offer_seat_available`, `offer_status`) VALUES
(1, 'ahmad.jamil', 'TO APU', 3, '2026-01-20', '07:30:00', 0.50, 3, 'COMPLETE'),
(2, 'siti.rahman', 'FROM APU', 1, '2026-01-20', '17:00:00', 0.45, 2, 'COMPLETE'),
(3, 'wei.chen', 'TO APU', 4, '2026-01-21', '08:00:00', 0.60, 4, 'COMPLETE'),
(4, 'raj.kumar', 'FROM APU', 1, '2026-01-21', '18:30:00', 0.55, 3, 'COMPLETE'),
(5, 'fatimah.ali', 'TO APU', 5, '2026-01-22', '07:45:00', 0.40, 2, 'COMPLETE'),
(6, 'john.doe', 'TO APU', 2, '2026-01-22', '08:30:00', 0.70, 4, 'INCOMPLETE'),
(7, 'maria.garcia', 'FROM APU', 1, '2026-01-23', '16:00:00', 0.65, 3, 'INCOMPLETE'),
(8, 'james.wilson', 'TO APU', 6, '2026-01-25', '07:15:00', 0.80, 2, 'COMPLETE'),
(9, 'nurul.hassan', 'FROM APU', 1, '2026-01-25', '17:45:00', 0.35, 4, 'COMPLETE'),
(10, 'samuel.tan', 'TO APU', 3, '2026-01-26', '08:45:00', 0.90, 3, 'COMPLETE'),
(11, 'ahmad.jamil', 'TO APU', 4, '2026-01-31', '07:30:00', 0.50, 3, 'INCOMPLETE'),
(12, 'siti.rahman', 'FROM APU', 1, '2026-01-31', '12:00:00', 0.45, 2, 'INCOMPLETE'),
(13, 'wei.chen', 'TO APU', 5, '2026-02-01', '08:00:00', 0.60, 4, 'INCOMPLETE'),
(14, 'raj.kumar', 'FROM APU', 1, '2026-02-01', '13:00:00', 0.75, 3, 'INCOMPLETE'),
(15, 'fatimah.ali', 'TO APU', 6, '2026-02-02', '09:30:00', 0.40, 2, 'INCOMPLETE'),
(16, 'john.doe', 'FROM APU', 1, '2026-02-02', '14:00:00', 1.20, 4, 'INCOMPLETE'),
(17, 'maria.garcia', 'TO APU', 2, '2026-02-03', '10:00:00', 0.85, 3, 'INCOMPLETE'),
(18, 'james.wilson', 'FROM APU', 1, '2026-02-03', '15:30:00', 0.95, 2, 'INCOMPLETE'),
(19, 'nurul.hassan', 'TO APU', 3, '2026-02-04', '11:00:00', 0.30, 4, 'INCOMPLETE'),
(20, 'samuel.tan', 'FROM APU', 1, '2026-02-04', '16:45:00', 1.10, 3, 'INCOMPLETE'),
(21, 'ahmad.jamil', 'FROM APU', 1, '2026-02-05', '18:00:00', 2.00, 2, 'INCOMPLETE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_info`
--

CREATE TABLE `tbl_staff_info` (
  `staff_username` varchar(50) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_ic_passport` varchar(20) NOT NULL,
  `staff_dob` date NOT NULL,
  `staff_gender` varchar(10) NOT NULL,
  `staff_contact` varchar(20) NOT NULL,
  `staff_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff_info`
--

INSERT INTO `tbl_staff_info` (`staff_username`, `staff_name`, `staff_ic_passport`, `staff_dob`, `staff_gender`, `staff_contact`, `staff_email`) VALUES
('admin.carol', 'Carol Max', '850512-08-1234', '2000-01-01', 'FEMALE', '012-2234455', 'carol.max@email.com'),
('admin.maya', 'Maya Devi', '880707-05-5678', '1988-07-07', 'FEMALE', '012-3344556', 'maya.devi@ecoride.com'),
('admin.raju', 'Raju Pillai', '830101-01-9012', '1983-01-01', 'MALE', '013-4455667', 'raju.pillai@ecoride.com'),
('amelia.kumar', 'Amelia Kumar', '950101-06-5678', '1995-01-01', 'FEMALE', '013-3344556', 'amelia.kumar@ecoride.com'),
('daniel.lee', 'Daniel Lee', '871010-08-9012', '1987-10-10', 'MALE', '014-4455677', 'daniel.lee@ecoride.com'),
('david.chen', 'David Chen', '910212-08-7890', '1991-02-12', 'MALE', '015-6677899', 'david.chen@ecoride.com'),
('kevin.ng', 'Kevin Ng', '951212-08-3456', '1995-12-12', 'MALE', '019-0011223', 'kevin.ng@ecoride.com'),
('lisa.wong', 'Lisa Wong', '931111-06-1234', '1993-11-11', 'FEMALE', '016-7788990', 'lisa.wong@ecoride.com'),
('michael.tan', 'Michael Tan', '890909-08-5678', '1989-09-09', 'MALE', '017-8899001', 'michael.tan@ecoride.com'),
('priya.sharma', 'Priya Sharma', '940404-10-9012', '1994-04-04', 'FEMALE', '018-9900112', 'priya.sharma@ecoride.com'),
('ryan.lim', 'Ryan Lim', '880606-08-1234', '1988-06-06', 'MALE', '012-2233445', 'ryan.lim@ecoride.com'),
('sarah.jones', 'Sarah Jones', '920303-14-3456', '1992-03-03', 'FEMALE', '014-5566778', 'sarah.jones@ecoride.com'),
('sofia.ahmad', 'Sofia Ahmad', '900808-05-7890', '1990-08-08', 'FEMALE', '011-11223344', 'sofia.ahmad@ecoride.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trip_history`
--

CREATE TABLE `tbl_trip_history` (
  `trip_id` int(11) NOT NULL,
  `trip_offer_id` int(11) NOT NULL,
  `trip_duration` decimal(10,2) NOT NULL,
  `trip_price_per_passenger` decimal(10,2) NOT NULL,
  `trip_co2_kg` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trip_history`
--

INSERT INTO `tbl_trip_history` (`trip_id`, `trip_offer_id`, `trip_duration`, `trip_price_per_passenger`, `trip_co2_kg`) VALUES
(1, 1, 25.50, 12.75, 3.25),
(2, 2, 18.25, 8.21, 2.15),
(3, 3, 32.75, 19.65, 4.85),
(4, 4, 22.50, 12.38, 2.75),
(5, 5, 28.00, 11.20, 3.10),
(6, 8, 35.25, 28.20, 5.40),
(7, 9, 20.75, 7.26, 2.50),
(8, 10, 30.50, 27.45, 4.75);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trip_passenger`
--

CREATE TABLE `tbl_trip_passenger` (
  `trip_passenger_id` int(11) NOT NULL,
  `trip_passenger_trip_id` int(11) NOT NULL,
  `trip_passenger_passenger_username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trip_passenger`
--

INSERT INTO `tbl_trip_passenger` (`trip_passenger_id`, `trip_passenger_trip_id`, `trip_passenger_passenger_username`) VALUES
(1, 1, 'alice.smith'),
(2, 1, 'bob.johnson'),
(3, 1, 'charlie.brown'),
(4, 2, 'diana.ross'),
(5, 2, 'edward.miller'),
(6, 3, 'fiona.clark'),
(7, 3, 'george.white'),
(8, 3, 'hannah.martin'),
(9, 3, 'ian.thompson'),
(10, 4, 'jessica.davis'),
(11, 4, 'kevin.walker'),
(12, 4, 'lily.adams'),
(13, 5, 'mohammed.hassan'),
(14, 5, 'nora.james'),
(15, 6, 'oscar.king'),
(16, 6, 'alice.smith'),
(17, 7, 'bob.johnson'),
(18, 7, 'charlie.brown'),
(19, 7, 'diana.ross'),
(20, 7, 'edward.miller'),
(21, 8, 'fiona.clark'),
(22, 8, 'george.white'),
(23, 8, 'hannah.martin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
  `user_username` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_ic_passport` varchar(20) NOT NULL,
  `user_gender` varchar(10) NOT NULL,
  `user_dob` date NOT NULL,
  `user_contact` varchar(20) NOT NULL,
  `user_email` varchar(225) NOT NULL,
  `user_green_point` int(11) NOT NULL DEFAULT 0,
  `user_co2_kg` decimal(10,2) NOT NULL DEFAULT 0.00,
  `user_balance` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`user_username`, `user_name`, `user_ic_passport`, `user_gender`, `user_dob`, `user_contact`, `user_email`, `user_green_point`, `user_co2_kg`, `user_balance`) VALUES
('ahmad.jamil', 'Ahmad Jamil', '890101-01-1111', 'MALE', '1989-01-01', '017-1111222', 'ahmad.jamil@hotmail.com', 450, 75.30, 150.25),
('alice.smith', 'Alice Smith', '990101-14-5678', 'FEMALE', '1999-01-01', '011-12345678', 'alice.smith@gmail.com', 150, 25.50, 50.00),
('bob.johnson', 'Bob Johnson', '981212-08-9123', 'MALE', '1998-12-12', '012-2345678', 'bobjohnson98@yahoo.com', 85, 12.75, 25.50),
('charlie.brown', 'Charlie Brown', '000525-10-3456', 'MALE', '2000-05-25', '013-3456789', 'charliebrown00@hotmail.com', 210, 35.25, 75.00),
('diana.ross', 'Diana Ross', '991030-06-7890', 'FEMALE', '1999-10-30', '014-4567890', 'diana.ross99@outlook.com', 45, 7.80, 15.25),
('edward.miller', 'Edward Miller', '980815-12-1234', 'MALE', '1998-08-15', '015-5678901', 'edward.miller@student.apu.edu.my', 300, 48.90, 120.75),
('fatimah.ali', 'Fatimah Ali', '940303-06-4444', 'FEMALE', '1994-03-03', '012-5555666', 'fatimah.ali@gmail.com', 290, 48.20, 95.75),
('fiona.clark', 'Fiona Clark', '010202-14-5678', 'FEMALE', '2001-02-02', '016-6789012', 'fiona.clark01@gmail.com', 120, 18.45, 35.00),
('george.white', 'George White', '971119-08-9012', 'MALE', '1997-11-19', '017-7890134', 'george.white@yahoo.com', 65, 9.75, 18.50),
('hannah.martin', 'Hannah Martin', '990707-06-3456', 'FEMALE', '1999-07-07', '018-8901234', 'hannah.martin99@gmail.com', 180, 28.60, 65.25),
('ian.thompson', 'Ian Thompson', '000909-10-7890', 'MALE', '2000-09-09', '019-9012345', 'ian.thompson@student.apu.edu.my', 95, 14.25, 28.75),
('james.wilson', 'James Wilson', 'PASSPORT101', 'MALE', '1987-04-12', '015-8888999', 'james.wilson87@yahoo.com', 330, 54.80, 115.00),
('jessica.davis', 'Jessica Davis', '010424-14-1234', 'FEMALE', '2001-04-24', '011-11223344', 'jessica.davis01@outlook.com', 240, 37.80, 90.50),
('john.doe', 'John Doe', 'PASSPORT456', 'MALE', '1985-11-10', '013-6666777', 'john.doe85@gmail.com', 700, 118.90, 275.50),
('kevin.walker', 'Kevin Walker', '981212-08-5678', 'MALE', '1998-12-12', '012-2233445', 'kevin.walker98@gmail.com', 50, 6.90, 12.00),
('lily.adams', 'Lily Adams', '991212-06-9012', 'FEMALE', '1999-12-12', '013-3344556', 'lily.adams@yahoo.com', 160, 24.30, 55.75),
('maria.garcia', 'Maria Garcia', 'PASSPORT789', 'FEMALE', '1993-07-25', '014-7777888', 'maria.garcia@outlook.com', 410, 67.35, 140.25),
('mohammed.hassan', 'Mohammed Hassan', '000808-10-3456', 'MALE', '2000-08-08', '014-4455667', 'mohammed.hassan@student.apu.edu.my', 275, 42.15, 110.25),
('nora.james', 'Nora James', '010101-14-7890', 'FEMALE', '2001-01-01', '015-5566778', 'nora.james@hotmail.com', 75, 11.25, 22.50),
('nurul.hassan', 'Nurul Hassan', '910909-10-5555', 'FEMALE', '1991-09-09', '016-9999000', 'nurul.hassan91@gmail.com', 480, 79.60, 165.75),
('oscar.king', 'Oscar King', '990303-08-1234', 'MALE', '1999-03-03', '016-6677889', 'oscar.king99@gmail.com', 190, 29.40, 70.00),
('raj.kumar', 'Raj Kumar', '881212-08-3333', 'MALE', '1988-12-12', '011-44445550', 'raj.kumar88@yahoo.com', 600, 102.75, 225.00),
('raviraj871212-08-7890', 'Ravi Raj', '871212-08-7890', 'MALE', '1987-12-12', '011-55667788', 'ravi.raj87@hotmail.com', 0, 0.00, 0.00),
('samuel.tan', 'Samuel Tan', '930606-08-6666', 'MALE', '1993-06-06', '017-0000111', 'samuel.tan93@hotmail.com', 550, 92.25, 195.50),
('siti.rahman', 'Siti Rahman', '920515-05-2222', 'FEMALE', '1992-05-15', '018-2222333', 'siti.rahman92@gmail.com', 520, 88.45, 185.75),
('wei.chen', 'Wei Chen', 'PASSPORT123', 'MALE', '1990-08-20', '019-3333444', 'wei.chen90@outlook.com', 380, 62.10, 125.50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vote`
--

CREATE TABLE `tbl_vote` (
  `vote_id` int(11) NOT NULL,
  `vote_poll_id` int(11) NOT NULL,
  `vote_username` varchar(50) NOT NULL,
  `vote_response` varchar(10) NOT NULL,
  `vote_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vote`
--

INSERT INTO `tbl_vote` (`vote_id`, `vote_poll_id`, `vote_username`, `vote_response`, `vote_reason`) VALUES
(1, 1, 'alice.smith', 'AGREE', 'As an EV owner, more charging stations would make commuting much more convenient and encourage others to switch to electric vehicles.'),
(2, 1, 'bob.johnson', 'AGREE', 'This supports sustainability goals and prepares the campus for future transportation trends.'),
(3, 1, 'charlie.brown', 'AGREE', 'With the growing number of EVs, infrastructure needs to keep up. This is a necessary investment.'),
(4, 1, 'diana.ross', 'DISAGREE', 'Funds might be better spent on improving public transportation access for all students first.'),
(9, 3, 'ian.thompson', 'AGREE', 'Fair price considering fuel, maintenance, and the environmental benefit of reducing cars on the road.'),
(10, 3, 'jessica.davis', 'DISAGREE', 'RM0.30 would be more affordable for students on tight budgets while still being fair to drivers.'),
(11, 3, 'kevin.walker', 'AGREE', 'Drivers deserve fair compensation for providing a service that saves passengers money compared to Grab/taxi.'),
(12, 3, 'lily.adams', 'AGREE', 'The price is reasonable when you consider the convenience and time saved versus public transport.'),
(13, 4, 'mohammed.hassan', 'AGREE', 'This would incentivize more drivers to switch to EVs, accelerating our carbon reduction goals.'),
(14, 4, 'nora.james', 'DISAGREE', 'All drivers providing eco-friendly rides should be treated equally regardless of vehicle type.'),
(15, 4, 'oscar.king', 'AGREE', 'EV drivers have higher upfront costs - they deserve some priority to make their investment worthwhile.'),
(16, 4, 'alice.smith', 'AGREE', 'As an EV owner, this recognition would encourage me to drive more often on the platform.'),
(17, 5, 'bob.johnson', 'AGREE', 'Solo rides are the least efficient. A small tax would encourage carpooling and fund sustainability projects.'),
(18, 5, 'charlie.brown', 'DISAGREE', 'Additional fees might discourage people from using the service altogether. Positive incentives work better.'),
(19, 5, 'diana.ross', 'AGREE', 'People should pay the true environmental cost of their transportation choices. This promotes responsibility.'),
(20, 5, 'edward.miller', 'DISAGREE', 'Some solo rides are necessary (late nights, safety concerns). A blanket tax is unfair.'),
(21, 1, 'mohammed.hassan', 'AGREE', 'Future-proofing the campus is essential. EV adoption will only increase.'),
(23, 3, 'nora.james', 'DISAGREE', 'Prices should vary based on distance, not just time.'),
(24, 4, 'fiona.clark', 'DISAGREE', 'Fairness should come before incentives.'),
(25, 5, 'george.white', 'AGREE', 'The tax revenue could subsidize lower prices for carpoolers.'),
(26, 1, 'jessica.davis', 'AGREE', 'Even though I don\'t own an EV, it\'s good for the environment and campus image.'),
(28, 3, 'lily.adams', 'DISAGREE', 'The price should be lower during off-peak hours to encourage more rides.'),
(29, 4, 'oscar.king', 'DISAGREE', 'Maybe a small priority boost, but not significant advantage over regular drivers.'),
(30, 5, 'hannah.martin', 'AGREE', 'If the tax is small and funds go to green initiatives, I support it.'),
(31, 1, 'fiona.clark', 'AGREE', 'After thinking about it, EV infrastructure benefits everyone in the long run.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `offer_id` (`booking_offer_id`),
  ADD KEY `tbl_booking_ibfk_2` (`booking_passenger_username`);

--
-- Indexes for table `tbl_customer_service`
--
ALTER TABLE `tbl_customer_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `service_username` (`service_username`);

--
-- Indexes for table `tbl_driver_info`
--
ALTER TABLE `tbl_driver_info`
  ADD PRIMARY KEY (`driver_username`);

--
-- Indexes for table `tbl_driver_request`
--
ALTER TABLE `tbl_driver_request`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `contact` (`request_contact`),
  ADD UNIQUE KEY `email` (`request_email`),
  ADD UNIQUE KEY `ic_passport` (`request_ic_passport`,`request_contact`,`request_email`);

--
-- Indexes for table `tbl_driver_update`
--
ALTER TABLE `tbl_driver_update`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `update_driver_ username` (`update_driver_username`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`login_username`);

--
-- Indexes for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender` (`message_sender`),
  ADD KEY `receiver` (`message_receiver`);

--
-- Indexes for table `tbl_poll`
--
ALTER TABLE `tbl_poll`
  ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `tbl_redeem`
--
ALTER TABLE `tbl_redeem`
  ADD PRIMARY KEY (`redeem_id`),
  ADD KEY `username` (`redeem_username`),
  ADD KEY `reward_id` (`redeem_reward_id`);

--
-- Indexes for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `offer_id` (`review_offer_id`),
  ADD KEY `passenger_username` (`review_passenger_username`);

--
-- Indexes for table `tbl_reward`
--
ALTER TABLE `tbl_reward`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `tbl_ride_offer`
--
ALTER TABLE `tbl_ride_offer`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `driver_username` (`offer_driver_username`),
  ADD KEY `location_id` (`offer_location_id`);

--
-- Indexes for table `tbl_staff_info`
--
ALTER TABLE `tbl_staff_info`
  ADD PRIMARY KEY (`staff_username`),
  ADD UNIQUE KEY `ic_passport` (`staff_ic_passport`,`staff_contact`,`staff_email`);

--
-- Indexes for table `tbl_trip_history`
--
ALTER TABLE `tbl_trip_history`
  ADD PRIMARY KEY (`trip_id`),
  ADD UNIQUE KEY `offer_id` (`trip_offer_id`);

--
-- Indexes for table `tbl_trip_passenger`
--
ALTER TABLE `tbl_trip_passenger`
  ADD PRIMARY KEY (`trip_passenger_id`),
  ADD KEY `trip_id` (`trip_passenger_trip_id`),
  ADD KEY `tbl_trip_passenger_ibfk_2` (`trip_passenger_passenger_username`);

--
-- Indexes for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD PRIMARY KEY (`user_username`),
  ADD UNIQUE KEY `ic_passport` (`user_ic_passport`,`user_contact`,`user_email`);

--
-- Indexes for table `tbl_vote`
--
ALTER TABLE `tbl_vote`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `poll_id` (`vote_poll_id`),
  ADD KEY `username` (`vote_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_customer_service`
--
ALTER TABLE `tbl_customer_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_driver_request`
--
ALTER TABLE `tbl_driver_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_driver_update`
--
ALTER TABLE `tbl_driver_update`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_message`
--
ALTER TABLE `tbl_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_poll`
--
ALTER TABLE `tbl_poll`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_redeem`
--
ALTER TABLE `tbl_redeem`
  MODIFY `redeem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_reward`
--
ALTER TABLE `tbl_reward`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_ride_offer`
--
ALTER TABLE `tbl_ride_offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_trip_history`
--
ALTER TABLE `tbl_trip_history`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_trip_passenger`
--
ALTER TABLE `tbl_trip_passenger`
  MODIFY `trip_passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_vote`
--
ALTER TABLE `tbl_vote`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD CONSTRAINT `tbl_booking_ibfk_1` FOREIGN KEY (`booking_offer_id`) REFERENCES `tbl_ride_offer` (`offer_id`),
  ADD CONSTRAINT `tbl_booking_ibfk_2` FOREIGN KEY (`booking_passenger_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_customer_service`
--
ALTER TABLE `tbl_customer_service`
  ADD CONSTRAINT `tbl_customer_service_ibfk_1` FOREIGN KEY (`service_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_driver_info`
--
ALTER TABLE `tbl_driver_info`
  ADD CONSTRAINT `tbl_driver_info_ibfk_1` FOREIGN KEY (`driver_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_driver_update`
--
ALTER TABLE `tbl_driver_update`
  ADD CONSTRAINT `tbl_driver_update_ibfk_1` FOREIGN KEY (`update_driver_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD CONSTRAINT `tbl_message_ibfk_1` FOREIGN KEY (`message_sender`) REFERENCES `tbl_login` (`login_username`),
  ADD CONSTRAINT `tbl_message_ibfk_2` FOREIGN KEY (`message_receiver`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_redeem`
--
ALTER TABLE `tbl_redeem`
  ADD CONSTRAINT `tbl_redeem_ibfk_1` FOREIGN KEY (`redeem_username`) REFERENCES `tbl_login` (`login_username`),
  ADD CONSTRAINT `tbl_redeem_ibfk_2` FOREIGN KEY (`redeem_reward_id`) REFERENCES `tbl_reward` (`reward_id`);

--
-- Constraints for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD CONSTRAINT `tbl_review_ibfk_1` FOREIGN KEY (`review_offer_id`) REFERENCES `tbl_ride_offer` (`offer_id`),
  ADD CONSTRAINT `tbl_review_ibfk_2` FOREIGN KEY (`review_passenger_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_ride_offer`
--
ALTER TABLE `tbl_ride_offer`
  ADD CONSTRAINT `tbl_ride_offer_ibfk_1` FOREIGN KEY (`offer_driver_username`) REFERENCES `tbl_login` (`login_username`),
  ADD CONSTRAINT `tbl_ride_offer_ibfk_2` FOREIGN KEY (`offer_location_id`) REFERENCES `tbl_location` (`location_id`);

--
-- Constraints for table `tbl_staff_info`
--
ALTER TABLE `tbl_staff_info`
  ADD CONSTRAINT `tbl_staff_info_ibfk_1` FOREIGN KEY (`staff_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_trip_history`
--
ALTER TABLE `tbl_trip_history`
  ADD CONSTRAINT `tbl_trip_history_ibfk_1` FOREIGN KEY (`trip_offer_id`) REFERENCES `tbl_ride_offer` (`offer_id`);

--
-- Constraints for table `tbl_trip_passenger`
--
ALTER TABLE `tbl_trip_passenger`
  ADD CONSTRAINT `tbl_trip_passenger_ibfk_1` FOREIGN KEY (`trip_passenger_trip_id`) REFERENCES `tbl_trip_history` (`trip_id`),
  ADD CONSTRAINT `tbl_trip_passenger_ibfk_2` FOREIGN KEY (`trip_passenger_passenger_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD CONSTRAINT `tbl_user_info_ibfk_1` FOREIGN KEY (`user_username`) REFERENCES `tbl_login` (`login_username`);

--
-- Constraints for table `tbl_vote`
--
ALTER TABLE `tbl_vote`
  ADD CONSTRAINT `tbl_vote_ibfk_2` FOREIGN KEY (`vote_poll_id`) REFERENCES `tbl_poll` (`poll_id`),
  ADD CONSTRAINT `tbl_vote_ibfk_3` FOREIGN KEY (`vote_username`) REFERENCES `tbl_login` (`login_username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
