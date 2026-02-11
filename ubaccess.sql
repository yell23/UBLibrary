-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 03:34 AM
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
-- Database: `ubaccess`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetStudentByRFID` (IN `p_RFID` VARCHAR(100))   BEGIN
    SELECT 
        StudentID,
        RFID,
        FullName,
        Department,
        Course,
        PhotoUrl
    FROM Students
    WHERE RFID = p_RFID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ProcessAttendance` (IN `p_RFID` VARCHAR(100), IN `p_Area` VARCHAR(100), OUT `p_Action` VARCHAR(20), OUT `p_ActionTime` DATETIME)   BEGIN
    DECLARE v_StudentID VARCHAR(50);
    DECLARE v_ExistingAttendanceID INT;
    
    -- Get student ID from RFID
    SELECT StudentID INTO v_StudentID
    FROM Students 
    WHERE RFID = p_RFID
    LIMIT 1;
    
    -- If student not found
    IF v_StudentID IS NULL THEN
        SET p_Action = 'ERROR';
        SET p_ActionTime = NULL;
    ELSE
        -- Check for existing attendance record today without time out
        SELECT AttendanceID INTO v_ExistingAttendanceID
        FROM Attendance
        WHERE StudentID = v_StudentID
            AND Area = p_Area
            AND DATE(TimeIn) = CURDATE()
            AND TimeOut IS NULL
        ORDER BY TimeIn DESC
        LIMIT 1;
        
        IF v_ExistingAttendanceID IS NOT NULL THEN
            -- TIME OUT - Update existing record
            UPDATE Attendance
            SET TimeOut = NOW()
            WHERE AttendanceID = v_ExistingAttendanceID;
            
            SET p_Action = 'TIME_OUT';
            SET p_ActionTime = NOW();
        ELSE
            -- TIME IN - Create new record
            INSERT INTO Attendance (StudentID, RFID, Area, TimeIn)
            VALUES (v_StudentID, p_RFID, p_Area, NOW());
            
            SET p_Action = 'TIME_IN';
            SET p_ActionTime = NOW();
        END IF;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `activesessions`
-- (See below for the actual view)
--
CREATE TABLE `activesessions` (
`AttendanceID` int(11)
,`StudentID` varchar(50)
,`FullName` varchar(200)
,`Department` varchar(100)
,`Course` varchar(100)
,`PhotoUrl` varchar(500)
,`Area` varchar(100)
,`TimeIn` datetime
,`MinutesInside` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceID` int(11) NOT NULL,
  `StudentID` varchar(50) NOT NULL,
  `RFID` varchar(100) NOT NULL,
  `Area` varchar(100) NOT NULL DEFAULT 'Library',
  `TimeIn` datetime NOT NULL DEFAULT current_timestamp(),
  `TimeOut` datetime DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `StudentID`, `RFID`, `Area`, `TimeIn`, `TimeOut`, `CreatedAt`) VALUES
(10, '2024-001', '117069905', 'Library', '2026-02-11 08:58:38', '2026-02-11 09:16:36', '2026-02-11 08:58:38'),
(11, '2024-001', '117069905', 'Library', '2026-02-11 09:16:42', '2026-02-11 09:25:13', '2026-02-11 09:16:42'),
(13, '2024-001', '117069905', 'Library', '2026-02-11 09:37:19', '2026-02-11 09:50:29', '2026-02-11 09:37:19'),
(15, '2024-001', '117069905', 'Library', '2026-02-11 10:05:39', '2026-02-11 10:06:39', '2026-02-11 10:05:39'),
(16, '2024-002', '695335994', 'Library', '2026-02-11 10:06:10', '2026-02-11 10:07:00', '2026-02-11 10:06:10'),
(17, '2024-001', '117069905', 'Library', '2026-02-11 10:09:25', '2026-02-11 10:29:35', '2026-02-11 10:09:25'),
(18, '2024-002', '695335994', 'Library', '2026-02-11 10:27:50', '2026-02-11 10:29:59', '2026-02-11 10:27:50'),
(19, '2024-001', '117069905', 'Library', '2026-02-11 10:30:20', NULL, '2026-02-11 10:30:20');

-- --------------------------------------------------------

--
-- Stand-in structure for view `dailysummary`
-- (See below for the actual view)
--
CREATE TABLE `dailysummary` (
`Area` varchar(100)
,`UniqueVisitors` bigint(21)
,`TotalVisits` bigint(21)
,`CurrentlyInside` decimal(22,0)
,`CompletedSessions` decimal(22,0)
,`AvgDurationMinutes` decimal(24,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentID` varchar(50) NOT NULL,
  `RFID` varchar(100) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Course` varchar(100) DEFAULT NULL,
  `PhotoUrl` varchar(500) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentID`, `RFID`, `FullName`, `Department`, `Course`, `PhotoUrl`, `CreatedAt`, `UpdatedAt`) VALUES
('2024-001', '117069905', 'Noriel\r\n', 'CICT', 'BSIT', 'default.jpg', '2026-02-11 08:25:40', '2026-02-11 09:00:14'),
('2024-002', '695335994', 'Rich', 'CCS', 'BSIT', 'default.jpg', '2026-02-11 09:56:19', '2026-02-11 09:56:19');

-- --------------------------------------------------------

--
-- Structure for view `activesessions`
--
DROP TABLE IF EXISTS `activesessions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `activesessions`  AS SELECT `a`.`AttendanceID` AS `AttendanceID`, `a`.`StudentID` AS `StudentID`, `s`.`FullName` AS `FullName`, `s`.`Department` AS `Department`, `s`.`Course` AS `Course`, `s`.`PhotoUrl` AS `PhotoUrl`, `a`.`Area` AS `Area`, `a`.`TimeIn` AS `TimeIn`, timestampdiff(MINUTE,`a`.`TimeIn`,current_timestamp()) AS `MinutesInside` FROM (`attendance` `a` join `students` `s` on(`a`.`StudentID` = `s`.`StudentID`)) WHERE `a`.`TimeOut` is null AND cast(`a`.`TimeIn` as date) = curdate() ;

-- --------------------------------------------------------

--
-- Structure for view `dailysummary`
--
DROP TABLE IF EXISTS `dailysummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dailysummary`  AS SELECT `attendance`.`Area` AS `Area`, count(distinct `attendance`.`StudentID`) AS `UniqueVisitors`, count(0) AS `TotalVisits`, sum(case when `attendance`.`TimeOut` is null then 1 else 0 end) AS `CurrentlyInside`, sum(case when `attendance`.`TimeOut` is not null then 1 else 0 end) AS `CompletedSessions`, avg(case when `attendance`.`TimeOut` is not null then timestampdiff(MINUTE,`attendance`.`TimeIn`,`attendance`.`TimeOut`) else NULL end) AS `AvgDurationMinutes` FROM `attendance` WHERE cast(`attendance`.`TimeIn` as date) = curdate() GROUP BY `attendance`.`Area` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `idx_attendance_student` (`StudentID`),
  ADD KEY `idx_attendance_timein` (`TimeIn`),
  ADD KEY `idx_attendance_area` (`Area`),
  ADD KEY `idx_attendance_timeout` (`TimeOut`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `RFID` (`RFID`),
  ADD KEY `idx_students_rfid` (`RFID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `FK_Attendance_Students` FOREIGN KEY (`StudentID`) REFERENCES `students` (`StudentID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
