-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 08:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmanagerdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `GroupID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Productivity_Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`GroupID`, `Name`, `Productivity_Score`) VALUES
(1, 'Group Lee', 100);

-- --------------------------------------------------------

--
-- Table structure for table `grouptasks`
--

CREATE TABLE `grouptasks` (
  `GroupTaskID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `TaskID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grouptasks`
--

INSERT INTO `grouptasks` (`GroupTaskID`, `GroupID`, `TaskID`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `groupusers`
--

CREATE TABLE `groupusers` (
  `GroupUserID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groupusers`
--

INSERT INTO `groupusers` (`GroupUserID`, `GroupID`, `UserID`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `TaskID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `DifficultyLevel` varchar(6) DEFAULT NULL,
  `CompletionStatus` varchar(12) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `GroupID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`TaskID`, `Name`, `Description`, `DifficultyLevel`, `CompletionStatus`, `UserID`, `GroupID`) VALUES
(1, 'Create database tables', 'Create database tables on PhpMySQL in local server.', 'Easy', 'Planned', 1, NULL),
(2, 'Complete Planning and Documentation', 'Create UML Diagrams with UI prototypes', 'Easy', 'Planned', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(1000) DEFAULT NULL,
  `Productivity_Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`, `Productivity_Score`) VALUES
(1, 'Deniz', 'Acikbas', 'dacikbas@umich.edu', 'karya99DA', 100);

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `UserGroupID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `GroupID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`UserGroupID`, `UserID`, `GroupID`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usertasks`
--

CREATE TABLE `usertasks` (
  `UserTaskID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TaskID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertasks`
--

INSERT INTO `usertasks` (`UserTaskID`, `UserID`, `TaskID`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `grouptasks`
--
ALTER TABLE `grouptasks`
  ADD PRIMARY KEY (`GroupTaskID`),
  ADD KEY `GroupID` (`GroupID`),
  ADD KEY `TaskID` (`TaskID`);

--
-- Indexes for table `groupusers`
--
ALTER TABLE `groupusers`
  ADD PRIMARY KEY (`GroupUserID`),
  ADD KEY `GroupID` (`GroupID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`TaskID`),
  ADD KEY `FK_UserID` (`UserID`),
  ADD KEY `FK_GroupID` (`GroupID`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`UserGroupID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `usertasks`
--
ALTER TABLE `usertasks`
  ADD PRIMARY KEY (`UserTaskID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `TaskID` (`TaskID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grouptasks`
--
ALTER TABLE `grouptasks`
  MODIFY `GroupTaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groupusers`
--
ALTER TABLE `groupusers`
  MODIFY `GroupUserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `TaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `UserGroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usertasks`
--
ALTER TABLE `usertasks`
  MODIFY `UserTaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouptasks`
--
ALTER TABLE `grouptasks`
  ADD CONSTRAINT `grouptasks_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `group` (`GroupID`),
  ADD CONSTRAINT `grouptasks_ibfk_2` FOREIGN KEY (`TaskID`) REFERENCES `task` (`TaskID`);

--
-- Constraints for table `groupusers`
--
ALTER TABLE `groupusers`
  ADD CONSTRAINT `groupusers_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `group` (`GroupID`),
  ADD CONSTRAINT `groupusers_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `useraccount` (`UserID`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_GroupID` FOREIGN KEY (`GroupID`) REFERENCES `group` (`GroupID`),
  ADD CONSTRAINT `FK_UserID` FOREIGN KEY (`UserID`) REFERENCES `useraccount` (`UserID`);

--
-- Constraints for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD CONSTRAINT `usergroups_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `useraccount` (`UserID`),
  ADD CONSTRAINT `usergroups_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `group` (`GroupID`);

--
-- Constraints for table `usertasks`
--
ALTER TABLE `usertasks`
  ADD CONSTRAINT `usertasks_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `useraccount` (`UserID`),
  ADD CONSTRAINT `usertasks_ibfk_2` FOREIGN KEY (`TaskID`) REFERENCES `task` (`TaskID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
