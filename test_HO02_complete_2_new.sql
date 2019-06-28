-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2019 at 03:24 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `aff_fr`
--

CREATE TABLE `aff_fr` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `ChangeRequestNo` varchar(10) NOT NULL,
  `FR_Id` int(10) NOT NULL,
  `FR_No` char(10) NOT NULL,
  `FR_Version` int(11) NOT NULL,
  `changeType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aff_fr`
--

INSERT INTO `aff_fr` (`id`, `projectId`, `ChangeRequestNo`, `FR_Id`, `FR_No`, `FR_Version`, `changeType`) VALUES
(1, 1, 'CH01', 2, 'HO_FR_02', 1, 'delete'),
(2, 1, 'CH01', 1, 'HO_FR_01', 1, 'edit'),
(3, 1, 'CH02', 5, 'HO_FR_05', 1, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `aff_rtm`
--

CREATE TABLE `aff_rtm` (
  `id` int(11) NOT NULL,
  `ChangeRequestNo` char(10) NOT NULL,
  `functionId` int(10) NOT NULL,
  `functionNo` char(10) NOT NULL,
  `functionVersion` int(11) NOT NULL,
  `testcaseId` int(10) NOT NULL,
  `testcaseNo` char(10) NOT NULL,
  `testcaseVersion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aff_rtm`
--

INSERT INTO `aff_rtm` (`id`, `ChangeRequestNo`, `functionId`, `functionNo`, `functionVersion`, `testcaseId`, `testcaseNo`, `testcaseVersion`) VALUES
(1, 'CH01', 2, 'HO_FR_02', 1, 2, 'HO_TC_02', 1),
(2, 'CH01', 2, 'HO_FR_02', 1, 5, 'HO_TC_05', 1),
(3, 'CH01', 1, 'HO_FR_01', 1, 1, 'HO_TC_01', 1),
(4, 'CH02', 5, 'HO_FR_05', 1, 6, 'HO_TC_06', 1),
(5, 'CH02', 5, 'HO_FR_05', 1, 7, 'HO_TC_07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `aff_schema`
--

CREATE TABLE `aff_schema` (
  `id` int(11) NOT NULL,
  `ChangeRequestNo` varchar(10) NOT NULL,
  `schemaVersionId` int(10) DEFAULT NULL,
  `tableName` varchar(20) NOT NULL,
  `columnName` varchar(20) NOT NULL,
  `Version` int(11) DEFAULT NULL,
  `changeType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aff_schema`
--

INSERT INTO `aff_schema` (`id`, `ChangeRequestNo`, `schemaVersionId`, `tableName`, `columnName`, `Version`, `changeType`) VALUES
(1, 'CH01', 1, 'PATIENT', 'FIRSTNAME', 1, 'edit');

-- --------------------------------------------------------

--
-- Table structure for table `aff_testcase`
--

CREATE TABLE `aff_testcase` (
  `id` int(11) NOT NULL,
  `ChangeRequestNo` varchar(10) NOT NULL,
  `testcaseId` int(10) NOT NULL,
  `testcaseNo` varchar(10) NOT NULL,
  `testcaseVersion` int(11) NOT NULL,
  `changeType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aff_testcase`
--

INSERT INTO `aff_testcase` (`id`, `ChangeRequestNo`, `testcaseId`, `testcaseNo`, `testcaseVersion`, `changeType`) VALUES
(1, 'CH01', 2, 'HO_TC_02', 1, 'delete'),
(2, 'CH01', 5, 'HO_TC_05', 1, 'delete'),
(3, 'CH01', 1, 'HO_TC_01', 1, 'edit'),
(4, 'CH02', 6, 'HO_TC_06', 1, 'delete'),
(5, 'CH02', 7, 'HO_TC_07', 1, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `map_fr_version`
--

CREATE TABLE `map_fr_version` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `Old_FR_Id` int(10) NOT NULL,
  `Old_FR_No` char(20) NOT NULL,
  `Old_FR_Version` int(11) NOT NULL,
  `New_FR_Id` int(10) NOT NULL,
  `New_FR_No` char(20) NOT NULL,
  `New_FR_Version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_fr_version`
--

INSERT INTO `map_fr_version` (`id`, `projectId`, `Old_FR_Id`, `Old_FR_No`, `Old_FR_Version`, `New_FR_Id`, `New_FR_No`, `New_FR_Version`) VALUES
(1, 1, 2, 'HO_FR_02', 1, 5, 'HO_FR_05', 1),
(2, 1, 1, 'HO_FR_01', 1, 1, 'HO_FR_01', 2),
(3, 1, 5, 'HO_FR_05', 1, 6, 'HO_FR_06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `map_rtm`
--

CREATE TABLE `map_rtm` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `changeRequestNo` varchar(10) DEFAULT NULL,
  `functionId` int(10) NOT NULL,
  `functionVersion` int(10) NOT NULL,
  `testcaseId` int(10) NOT NULL,
  `testcaseVersion` int(10) NOT NULL,
  `activeflag` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_rtm`
--

INSERT INTO `map_rtm` (`id`, `projectId`, `changeRequestNo`, `functionId`, `functionVersion`, `testcaseId`, `testcaseVersion`, `activeflag`) VALUES
(1, 1, 'CH01', 1, 1, 1, 1, 0),
(2, 1, 'CH01', 2, 1, 2, 1, 0),
(3, 1, 'CH01', 3, 1, 3, 1, 0),
(4, 1, 'CH01', 4, 1, 4, 1, 0),
(5, 1, 'CH01', 2, 1, 5, 1, 0),
(6, 1, 'CH02', 3, 1, 3, 1, 0),
(7, 1, 'CH02', 4, 1, 4, 1, 0),
(8, 1, 'CH02', 5, 1, 6, 1, 0),
(9, 1, 'CH02', 5, 1, 7, 1, 0),
(10, 1, 'CH02', 1, 2, 1, 2, 0),
(13, 1, NULL, 3, 1, 3, 1, 1),
(14, 1, NULL, 4, 1, 4, 1, 1),
(15, 1, NULL, 1, 2, 1, 2, 1),
(16, 1, NULL, 6, 1, 8, 1, 1),
(17, 1, NULL, 6, 1, 9, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `map_schema`
--

CREATE TABLE `map_schema` (
  `id` int(10) NOT NULL,
  `projectId` int(10) NOT NULL,
  `changeRequestNo` varchar(10) DEFAULT NULL,
  `schemaVersionId` int(10) NOT NULL,
  `schemaVersion` int(10) NOT NULL,
  `tableName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_schema`
--

INSERT INTO `map_schema` (`id`, `projectId`, `changeRequestNo`, `schemaVersionId`, `schemaVersion`, `tableName`) VALUES
(1, 1, 'CH01', 1, 1, 'PATIENT'),
(2, 1, 'CH01', 2, 1, 'DOCTORS'),
(3, 1, 'CH01', 3, 1, 'DEPARTMENTS'),
(4, 1, 'CH01', 4, 1, 'APPOINTMENTS'),
(5, 1, 'CH02', 2, 1, 'DOCTORS'),
(6, 1, 'CH02', 3, 1, 'DEPARTMENTS'),
(7, 1, 'CH02', 4, 1, 'APPOINTMENTS'),
(8, 1, 'CH02', 1, 2, 'PATIENT'),
(12, 1, NULL, 2, 1, 'DOCTORS'),
(13, 1, NULL, 3, 1, 'DEPARTMENTS'),
(14, 1, NULL, 4, 1, 'APPOINTMENTS'),
(15, 1, NULL, 1, 2, 'PATIENT');

-- --------------------------------------------------------

--
-- Table structure for table `map_schema_version`
--

CREATE TABLE `map_schema_version` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `Old_schemaVersionId` int(10) DEFAULT NULL,
  `Old_TableName` varchar(20) DEFAULT NULL,
  `Old_Schema_Version` int(11) DEFAULT NULL,
  `New_schemaVersionId` int(11) NOT NULL,
  `New_TableName` varchar(20) NOT NULL,
  `New_Schema_Version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_schema_version`
--

INSERT INTO `map_schema_version` (`id`, `projectId`, `Old_schemaVersionId`, `Old_TableName`, `Old_Schema_Version`, `New_schemaVersionId`, `New_TableName`, `New_Schema_Version`) VALUES
(1, 1, 1, 'PATIENT', 1, 1, 'PATIENT', 2);

-- --------------------------------------------------------

--
-- Table structure for table `map_tc_version`
--

CREATE TABLE `map_tc_version` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `Old_TC_Id` int(10) NOT NULL,
  `Old_TC_No` char(10) NOT NULL,
  `Old_TC_Version` int(11) NOT NULL,
  `New_TC_Id` int(11) NOT NULL,
  `New_TC_No` char(10) NOT NULL,
  `New_TC_Version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_tc_version`
--

INSERT INTO `map_tc_version` (`id`, `projectId`, `Old_TC_Id`, `Old_TC_No`, `Old_TC_Version`, `New_TC_Id`, `New_TC_No`, `New_TC_Version`) VALUES
(1, 1, 2, 'HO_TC_02', 1, 6, 'HO_TC_06', 1),
(2, 1, 5, 'HO_TC_05', 1, 7, 'HO_TC_07', 1),
(3, 1, 1, 'HO_TC_01', 1, 1, 'HO_TC_01', 2),
(4, 1, 6, 'HO_TC_06', 1, 8, 'HO_TC_08', 1),
(5, 1, 7, 'HO_TC_07', 1, 9, 'HO_TC_09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_database_schema_info`
--

CREATE TABLE `m_database_schema_info` (
  `projectId` int(10) NOT NULL,
  `tableName` varchar(50) NOT NULL,
  `columnName` varchar(50) NOT NULL,
  `Id` int(10) NOT NULL,
  `schemaVersionId` int(10) NOT NULL,
  `Version` int(11) NOT NULL,
  `dataType` varchar(20) NOT NULL,
  `dataLength` varchar(10) DEFAULT NULL,
  `decimalPoint` varchar(10) DEFAULT NULL,
  `constraintPrimaryKey` varchar(1) DEFAULT NULL,
  `constraintUnique` varchar(1) DEFAULT NULL,
  `constraintDefault` varchar(10) DEFAULT NULL,
  `constraintNull` varchar(1) DEFAULT NULL,
  `constraintMinValue` varchar(10) DEFAULT NULL,
  `constraintMaxValue` varchar(10) DEFAULT NULL,
  `activeflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_database_schema_info`
--

INSERT INTO `m_database_schema_info` (`projectId`, `tableName`, `columnName`, `Id`, `schemaVersionId`, `Version`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`, `activeflag`) VALUES
(1, 'PATIENT', 'SSN', 1, 1, 1, 'VARCHAR', '10', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(1, 'PATIENT', 'FIRSTNAME', 2, 1, 1, 'VARCHAR', '50', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'PATIENT', 'LASTNAME', 3, 1, 1, 'VARCHAR', '50', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'PATIENT', 'BIRTHDATE', 4, 1, 1, 'DATE', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'PATIENT', 'ADDRESS', 5, 1, 1, 'VARCHAR', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'DOCTORS', 'DOCTOR_ID', 6, 2, 1, 'INT', NULL, NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(1, 'DOCTORS', 'DEP_ID', 7, 2, 1, 'INT', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'DOCTORS', 'D_FIRSTNAME', 8, 2, 1, 'VARCHAR', '45', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'DOCTORS', 'D_SURNAME', 9, 2, 1, 'VARCHAR', '45', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'DOCTORS', 'D_BIRTHDATE', 10, 2, 1, 'DATE', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'DOCTORS', 'D_SALARY', 11, 2, 1, 'DECIMAL', '8', '2', 'N', 'N', NULL, 'N', NULL, NULL, 1),
(1, 'DEPARTMENTS', 'DEP_ID', 12, 3, 1, 'INT', NULL, NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(1, 'DEPARTMENTS', 'DEPT_NAME', 13, 3, 1, 'VARCHAR', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'APPOINTMENTS', 'APP_ID', 14, 4, 1, 'VARCHAR', '12', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(1, 'APPOINTMENTS', 'SSN', 15, 4, 1, 'VARCHAR', '10', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'APPOINTMENTS', 'DOCTORS_ID', 16, 4, 1, 'INT', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'APPOINTMENTS', 'APP_DATE', 17, 4, 1, 'DATE', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(1, 'PATIENT', 'SSN', 18, 1, 2, 'VARCHAR', '10', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 0),
(1, 'PATIENT', 'FIRSTNAME', 19, 1, 2, 'VARCHAR ', '30', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(1, 'PATIENT', 'LASTNAME', 20, 1, 2, 'VARCHAR', '50', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(1, 'PATIENT', 'BIRTHDATE', 21, 1, 2, 'DATE', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(1, 'PATIENT', 'ADDRESS', 22, 1, 2, 'VARCHAR', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_database_schema_version`
--

CREATE TABLE `m_database_schema_version` (
  `projectId` int(11) NOT NULL,
  `Id` int(10) NOT NULL,
  `schemaVersionId` int(10) NOT NULL,
  `schemaVersionNumber` varchar(10) NOT NULL,
  `tableName` varchar(50) NOT NULL,
  `columnName` varchar(50) NOT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `createDate` date NOT NULL,
  `createUser` varchar(50) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) DEFAULT NULL,
  `activeFlag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_database_schema_version`
--

INSERT INTO `m_database_schema_version` (`projectId`, `Id`, `schemaVersionId`, `schemaVersionNumber`, `tableName`, `columnName`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(1, 1, 1, '1', 'PATIENT', 'SSN', '2019-06-28', '2019-06-28', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 2, 1, '1', 'PATIENT', 'FIRSTNAME', '2019-06-28', '2019-06-28', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 3, 1, '1', 'PATIENT', 'LASTNAME', '2019-06-28', '2019-06-28', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 4, 1, '1', 'PATIENT', 'BIRTHDATE', '2019-06-28', '2019-06-28', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 5, 1, '1', 'PATIENT', 'ADDRESS', '2019-06-28', '2019-06-28', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 6, 2, '1', 'DOCTORS', 'DOCTOR_ID', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 7, 2, '1', 'DOCTORS', 'DEP_ID', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 8, 2, '1', 'DOCTORS', 'D_FIRSTNAME', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 9, 2, '1', 'DOCTORS', 'D_SURNAME', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 10, 2, '1', 'DOCTORS', 'D_BIRTHDATE', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 11, 2, '1', 'DOCTORS', 'D_SALARY', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 12, 3, '1', 'DEPARTMENTS', 'DEP_ID', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 13, 3, '1', 'DEPARTMENTS', 'DEPT_NAME', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 14, 4, '1', 'APPOINTMENTS', 'APP_ID', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 15, 4, '1', 'APPOINTMENTS', 'SSN', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 16, 4, '1', 'APPOINTMENTS', 'DOCTORS_ID', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 17, 4, '1', 'APPOINTMENTS', 'APP_DATE', '2019-06-28', NULL, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 18, 1, '2', 'PATIENT', 'SSN', '2019-06-28', '2019-06-28', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 19, 1, '2', 'PATIENT', 'FIRSTNAME', '2019-06-28', '2019-06-28', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 20, 1, '2', 'PATIENT', 'LASTNAME', '2019-06-28', '2019-06-28', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 21, 1, '2', 'PATIENT', 'BIRTHDATE', '2019-06-28', '2019-06-28', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 22, 1, '2', 'PATIENT', 'ADDRESS', '2019-06-28', '2019-06-28', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_fn_req_detail`
--

CREATE TABLE `m_fn_req_detail` (
  `projectid` int(11) NOT NULL,
  `functionId` int(11) NOT NULL,
  `functionNo` varchar(10) NOT NULL,
  `functionVersion` int(11) NOT NULL,
  `typeData` varchar(10) NOT NULL,
  `dataId` int(11) NOT NULL,
  `dataName` varchar(20) NOT NULL,
  `schemaVersionId` varchar(10) DEFAULT NULL,
  `refTableName` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `refColumnName` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `dataType` varchar(20) NOT NULL,
  `dataLength` varchar(10) DEFAULT NULL,
  `decimalPoint` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintPrimaryKey` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintUnique` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintDefault` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintNull` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintMinValue` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintMaxValue` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `activeFlag` smallint(6) NOT NULL,
  `createDate` date NOT NULL,
  `createUser` varchar(10) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_fn_req_detail`
--

INSERT INTO `m_fn_req_detail` (`projectid`, `functionId`, `functionNo`, `functionVersion`, `typeData`, `dataId`, `dataName`, `schemaVersionId`, `refTableName`, `refColumnName`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`) VALUES
(1, 1, 'HO_FR_01', 1, '1', 1, 'SSN', '1', 'PATIENT', 'SSN', 'VARCHAR', '10', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 1, '1', 2, 'FIRSTNAME', '2', 'PATIENT', 'FIRSTNAME', 'VARCHAR', '50', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 1, '1', 3, 'LASTNAME', '3', 'PATIENT', 'LASTNAME', 'VARCHAR', '50', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 1, '1', 4, 'BIRTHDATE', '4', 'PATIENT', 'BIRTHDATE', 'DATE', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 1, '1', 5, 'ADDRESS', '5', 'PATIENT', 'ADDRESS', 'VARCHAR', '100', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 2, 'HO_FR_02', 1, '1', 6, 'SSN', '1', 'PATIENT', 'SSN', 'VARCHAR', '10', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 2, 'HO_FR_02', 1, '2', 7, 'FIRSTNAME', '2', 'PATIENT', 'FIRSTNAME', 'VARCHAR', '50', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 2, 'HO_FR_02', 1, '2', 8, 'BIRTHDATE', '4', 'PATIENT', 'BIRTHDATE', 'DATE', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 1, '2019-06-28', 'sa_test', '2019-06-28', 'ploy'),
(1, 3, 'HO_FR_03', 1, '1', 9, 'APP_ID', '14', 'APPOINTMENTS', 'APP_ID', 'VARCHAR', '12', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 3, 'HO_FR_03', 1, '1', 10, 'APP_DATE', '17', 'APPOINTMENTS', 'APP_DATE', 'DATE', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 3, 'HO_FR_03', 1, '1', 11, 'SSN', '18', 'PATIENT', 'SSN', 'VARCHAR', '10', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 3, 'HO_FR_03', 1, '1', 12, 'DOCTORS_ID', '6', 'DOCTORS', 'DOCTOR_ID', 'INT', '', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 4, 'HO_FR_04', 1, '1', 13, 'DOCTOR_ID', '6', 'DOCTORS', 'DOCTOR_ID', 'INT', '', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 4, 'HO_FR_04', 1, '1', 14, 'DEP_ID', '7', 'DOCTORS', 'DEP_ID', 'INT', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 4, 'HO_FR_04', 1, '1', 15, 'D_Firstname', '8', 'DOCTORS', 'D_FIRSTNAME', 'VARCHAR', '45', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 4, 'HO_FR_04', 1, '1', 16, 'D_Surname', '9', 'DOCTORS', 'D_SURNAME', 'VARCHAR', '45', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 4, 'HO_FR_04', 1, '1', 17, 'D_Salary', '11', 'DOCTORS', 'D_SALARY', 'DECIMAL', '8', '2', 'N', 'N', 'NULL', 'N', 'NULL', 'NULL', '2019-06-28', NULL, 1, '2019-06-28', 'sa_test', '2019-06-28', 'sa_test'),
(1, 5, 'HO_FR_05', 1, '1', 18, 'SSN', '18', 'PATIENT', 'SSN', 'VARCHAR', '10', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 5, 'HO_FR_05', 1, '2', 19, 'FIRSTNAME', '19', 'PATIENT', 'FIRSTNAME', 'VARCHAR ', '30', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 5, 'HO_FR_05', 1, '2', 20, 'BIRTHDATE', '21', 'PATIENT', 'BIRTHDATE', 'DATE', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 5, 'HO_FR_05', 1, '2', 21, 'AGE', NULL, NULL, NULL, 'INT ', '3', '', 'N', 'N', NULL, 'N', NULL, NULL, '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 2, '1', 22, 'SSN', '18', 'PATIENT', 'SSN', 'VARCHAR', '10', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 2, '1', 23, 'FIRSTNAME', '19', 'PATIENT', 'FIRSTNAME', 'VARCHAR ', '30', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 2, '1', 24, 'LASTNAME', '20', 'PATIENT', 'LASTNAME', 'VARCHAR', '50', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 2, '1', 25, 'BIRTHDATE', '21', 'PATIENT', 'BIRTHDATE', 'DATE', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 1, 'HO_FR_01', 2, '1', 26, 'ADDRESS', '22', 'PATIENT', 'ADDRESS', 'VARCHAR', '100', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 6, 'HO_FR_06', 1, '1', 29, 'SSN', '18', 'PATIENT', 'SSN', 'VARCHAR', '10', NULL, 'Y', 'Y', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 6, 'HO_FR_06', 1, '2', 30, 'FIRSTNAME', '19', 'PATIENT', 'FIRSTNAME', 'VARCHAR ', '30', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy'),
(1, 6, 'HO_FR_06', 1, '2', 31, 'BIRTHDATE', '21', 'PATIENT', 'BIRTHDATE', 'DATE', '', NULL, 'N', 'N', 'NULL', 'Y', 'NULL', 'NULL', '2019-06-28', '2019-06-28', 0, '2019-06-28', 'ploy', '2019-06-28', 'ploy');

-- --------------------------------------------------------

--
-- Table structure for table `m_fn_req_header`
--

CREATE TABLE `m_fn_req_header` (
  `Id` int(11) NOT NULL,
  `functionId` int(11) NOT NULL,
  `functionNo` varchar(10) NOT NULL,
  `functionversion` varchar(10) DEFAULT NULL,
  `functionDescription` varchar(50) NOT NULL,
  `createDate` date NOT NULL,
  `createUser` varchar(10) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) DEFAULT NULL,
  `projectid` int(11) NOT NULL,
  `activeflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_fn_req_header`
--

INSERT INTO `m_fn_req_header` (`Id`, `functionId`, `functionNo`, `functionversion`, `functionDescription`, `createDate`, `createUser`, `updateDate`, `updateUser`, `projectid`, `activeflag`) VALUES
(1, 1, 'HO_FR_01', '1', 'Add Patient Information', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1, 1),
(2, 2, 'HO_FR_02', '1', 'View Patient Information', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1, 1),
(3, 3, 'HO_FR_03', '1', 'Make an appointment', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1, 1),
(4, 4, 'HO_FR_04', '1', 'Add New Doctor Information', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1, 1),
(5, 5, 'HO_FR_05', '1', 'View Patient Information', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1, 0),
(6, 1, 'HO_FR_01', '2', 'Add Patient Information', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1, 0),
(7, 6, 'HO_FR_06', '1', 'View Patient Information', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_miscellaneous`
--

CREATE TABLE `m_miscellaneous` (
  `miscData` char(30) CHARACTER SET latin1 NOT NULL,
  `miscValue1` char(20) CHARACTER SET latin1 NOT NULL,
  `miscValue2` char(20) CHARACTER SET latin1 DEFAULT NULL,
  `miscDescription` char(50) CHARACTER SET latin1 NOT NULL,
  `activeFlag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_miscellaneous`
--

INSERT INTO `m_miscellaneous` (`miscData`, `miscValue1`, `miscValue2`, `miscDescription`, `activeFlag`) VALUES
('inputDataType', 'CHAR', 'char', '', 1),
('inputDatatype', 'VARCHAR', 'varchar', '', 1),
('inputDatatype', 'DATE', 'date', '', 1),
('inputDatatype', 'INT', 'int', '', 1),
('inputDatatype', 'FLOAT', 'float', '', 1),
('inputDatatype', 'DOUBLE', 'double', '', 1),
('inputDatatype', 'DECIMAL', 'decimal', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_project`
--

CREATE TABLE `m_project` (
  `projectId` int(11) NOT NULL,
  `projectName` varchar(50) CHARACTER SET latin1 NOT NULL,
  `projectNameAlias` varchar(50) CHARACTER SET latin1 NOT NULL,
  `effDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `customer` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `databaseName` varchar(50) CHARACTER SET latin1 NOT NULL,
  `hostname` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `port` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` char(10) CHARACTER SET latin1 NOT NULL,
  `startFlag` smallint(6) NOT NULL,
  `activeFlag` smallint(1) DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `createUser` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `updateDate` datetime NOT NULL,
  `updateUser` char(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_project`
--

INSERT INTO `m_project` (`projectId`, `projectName`, `projectNameAlias`, `effDate`, `endDate`, `customer`, `databaseName`, `hostname`, `port`, `username`, `password`, `startFlag`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`) VALUES
(1, 'Hospital', 'Hospital', '2018-11-29 00:00:00', '2018-12-28 00:00:00', 'test1', 'Hospital', 'localhost', '81', 'ploy', '1234', 1, 1, '2018-11-29 17:59:26', 'ploy', '2018-11-29 17:59:26', 'ploy'),
(2, 'products', 'products', '2019-01-06 00:00:00', '2019-03-08 00:00:00', 'test2', 'products', 'localhost:81', '81', 'ploy ploy', '1234', 1, 1, '2019-01-06 18:31:30', 'ploy', '2019-01-06 18:44:52', 'ploy'),
(3, 'Banking', 'Bank', '2019-06-02 00:00:00', '2019-07-31 00:00:00', 'customer01', 'test', 'localhost:81', '22', 'ploy', '1234', 1, 1, '2019-06-01 19:52:19', 'ploy', '2019-06-01 19:52:33', 'ploy'),
(4, 'Securities Trading System', 'STS', '2019-06-14 00:00:00', '2019-07-31 00:00:00', 'TEST_001', 'DB_STS', 'localhost:81', '81', 'sa_test', 'qwerty123', 1, 1, '2019-06-14 10:54:41', 'sa_test', '2019-06-14 10:54:46', 'sa_test');

-- --------------------------------------------------------

--
-- Table structure for table `m_rtm_version`
--

CREATE TABLE `m_rtm_version` (
  `Id` int(10) NOT NULL,
  `projectId` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseversion` int(11) NOT NULL,
  `functionId` int(11) NOT NULL,
  `functionVersion` int(11) NOT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `createDate` date NOT NULL,
  `createUser` varchar(10) NOT NULL,
  `updateDate` date NOT NULL,
  `updateUser` varchar(10) NOT NULL,
  `activeFlag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_rtm_version`
--

INSERT INTO `m_rtm_version` (`Id`, `projectId`, `testCaseId`, `testCaseversion`, `functionId`, `functionVersion`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(1, 1, 1, 1, 1, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1),
(2, 1, 2, 1, 2, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1),
(3, 1, 3, 1, 3, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1),
(4, 1, 4, 1, 4, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1),
(5, 1, 5, 1, 2, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 1),
(6, 1, 6, 1, 5, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(7, 1, 7, 1, 5, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(8, 1, 1, 2, 1, 2, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(9, 1, 8, 1, 6, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(10, 1, 9, 1, 6, 1, '2019-06-28', NULL, '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_running_ch`
--

CREATE TABLE `m_running_ch` (
  `projectId` int(11) NOT NULL,
  `changeRequestNo` varchar(20) CHARACTER SET latin1 NOT NULL,
  `changeRequestId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_running_ch`
--

INSERT INTO `m_running_ch` (`projectId`, `changeRequestNo`, `changeRequestId`) VALUES
(2, 'CH', 1),
(1, 'CH', 3),
(3, 'CH', 1),
(4, 'CH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_running_prefix`
--

CREATE TABLE `m_running_prefix` (
  `prefix` char(20) CHARACTER SET latin1 DEFAULT NULL,
  `affix` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `length` char(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_detail`
--

CREATE TABLE `m_testcase_detail` (
  `projectId` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` varchar(10) NOT NULL,
  `testcaseVersion` varchar(10) NOT NULL,
  `typeData` int(11) NOT NULL,
  `refdataId` int(11) DEFAULT NULL,
  `refdataName` varchar(20) NOT NULL,
  `testData` varchar(50) NOT NULL,
  `effectiveStartDate` date DEFAULT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `activeFlag` varchar(1) NOT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` varchar(10) DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) DEFAULT NULL,
  `sequenceNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_testcase_detail`
--

INSERT INTO `m_testcase_detail` (`projectId`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `typeData`, `refdataId`, `refdataName`, `testData`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`, `sequenceNo`) VALUES
(1, 1, 'HO_TC_01', '1', 1, 1, 'SSN', '123456', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 1, 'HO_TC_01', '1', 1, 2, 'FIRSTNAME', 'Nannaphat', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 2),
(1, 1, 'HO_TC_01', '1', 1, 3, 'LASTNAME', 'Cherdsakulwong', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 3),
(1, 1, 'HO_TC_01', '1', 1, 4, 'BIRTHDATE', '5/9/1989', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 4),
(1, 1, 'HO_TC_01', '1', 1, 5, 'ADDRESS', '123 test Road', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 5),
(1, 2, 'HO_TC_02', '1', 1, 1, 'SSN', 'HN-001268', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 6),
(1, 2, 'HO_TC_02', '1', 2, 2, 'FIRSTNAME', 'Peter', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 7),
(1, 2, 'HO_TC_02', '1', 2, 4, 'BIRTHDATE', '02/08/1989', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 8),
(1, 3, 'HO_TC_03', '1', 1, 9, 'App_id', 'AP-00123', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 9),
(1, 3, 'HO_TC_03', '1', 1, 10, 'App_Date', '09/05/2019', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 10),
(1, 3, 'HO_TC_03', '1', 1, 1, 'SSN', 'HN-0001', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 11),
(1, 3, 'HO_TC_03', '1', 1, 13, 'Doctor_Id', '1', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 12),
(1, 4, 'HO_TC_04', '1', 1, 13, 'DOCTOR_ID', '1', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 13),
(1, 4, 'HO_TC_04', '1', 1, 14, 'DEP_ID', '1', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 14),
(1, 4, 'HO_TC_04', '1', 1, 15, 'D_Firstname', 'Jason', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 15),
(1, 4, 'HO_TC_04', '1', 1, 16, 'D_Surname', 'Johnson', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 16),
(1, 4, 'HO_TC_04', '1', 1, 17, 'D_Salary', '50000.00', '2019-06-28', NULL, '1', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 17),
(1, 5, 'HO_TC_05', '1', 1, 1, 'SSN', 'HN-00111', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 18),
(1, 5, 'HO_TC_05', '1', 2, 2, 'FIRSTNAME', 'Paul', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 19),
(1, 5, 'HO_TC_05', '1', 2, 4, 'BIRTHDATE', '28/02/1990', '2019-06-28', '2019-06-28', '1', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 20),
(1, 6, 'HO_TC_06', '1', 1, 1, 'SSN', 'HN-001268', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 21),
(1, 6, 'HO_TC_06', '1', 2, 2, 'FIRSTNAME', 'FAs3XDulrUDkwDhdtpecg34LrI2wu4', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 22),
(1, 6, 'HO_TC_06', '1', 2, 4, 'BIRTHDATE', '02/08/1989', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 23),
(1, 6, 'HO_TC_06', '1', 2, 999999, 'AGE', '67', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 24),
(1, 7, 'HO_TC_07', '1', 1, 1, 'SSN', 'HN-00111', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 25),
(1, 7, 'HO_TC_07', '1', 2, 2, 'FIRSTNAME', 'mdyMVlLgpu6paAC24OBaCxoBPLDubL', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 26),
(1, 7, 'HO_TC_07', '1', 2, 4, 'BIRTHDATE', '28/02/1990', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 27),
(1, 7, 'HO_TC_07', '1', 2, 999999, 'AGE', '56', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 28),
(1, 1, 'HO_TC_01', '2', 1, 1, 'SSN', '123456', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 29),
(1, 1, 'HO_TC_01', '2', 1, 2, 'FIRSTNAME', 'd0WJGPXFaJkabtzlFBRpQUUwxvG7i1', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 30),
(1, 1, 'HO_TC_01', '2', 1, 3, 'LASTNAME', 'Cherdsakulwong', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 31),
(1, 1, 'HO_TC_01', '2', 1, 4, 'BIRTHDATE', '5/9/1989', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 32),
(1, 1, 'HO_TC_01', '2', 1, 5, 'ADDRESS', '123 test Road', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 33),
(1, 8, 'HO_TC_08', '1', 1, 1, 'SSN', 'HN-001268', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 36),
(1, 8, 'HO_TC_08', '1', 2, 2, 'FIRSTNAME', 'FAs3XDulrUDkwDhdtpecg34LrI2wu4', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 37),
(1, 8, 'HO_TC_08', '1', 2, 4, 'BIRTHDATE', '02/08/1989', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 38),
(1, 9, 'HO_TC_09', '1', 1, 1, 'SSN', 'HN-00111', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 43),
(1, 9, 'HO_TC_09', '1', 2, 2, 'FIRSTNAME', 'mdyMVlLgpu6paAC24OBaCxoBPLDubL', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 44),
(1, 9, 'HO_TC_09', '1', 2, 4, 'BIRTHDATE', '28/02/1990', '2019-06-28', '2019-06-28', '0', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 45);

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_header`
--

CREATE TABLE `m_testcase_header` (
  `projectId` int(10) NOT NULL,
  `Id` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` varchar(10) NOT NULL,
  `testcaseVersion` varchar(10) NOT NULL,
  `testCaseDescription` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `expectedResult` varchar(50) CHARACTER SET latin1 NOT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` varchar(10) DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) DEFAULT NULL,
  `activeflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_testcase_header`
--

INSERT INTO `m_testcase_header` (`projectId`, `Id`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `testCaseDescription`, `expectedResult`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeflag`) VALUES
(1, 1, 1, 'HO_TC_01', '1', 'Test Add Patient Information', 'Valid', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 2, 2, 'HO_TC_02', '1', 'Test View Patient Information', 'Valid', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 3, 3, 'HO_TC_03', '1', 'Test Make an appointment', 'Valid', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 4, 4, 'HO_TC_04', '1', 'Test Add New Doctor Information', 'Valid', '2019-06-28', 'sa_test', '2019-06-28', 'sa_test', 1),
(1, 5, 5, 'HO_TC_05', '1', 'Test View Patient Information', 'Valid', '2019-06-28', 'sa_test', '2019-06-28', 'ploy', 1),
(1, 6, 6, 'HO_TC_06', '1', 'Test View Patient Information', 'Valid', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 7, 7, 'HO_TC_07', '1', 'Test View Patient Information', 'Valid', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 8, 1, 'HO_TC_01', '2', 'Test Add Patient Information', 'Valid', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 9, 8, 'HO_TC_08', '1', 'Test View Patient Information', 'Valid', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0),
(1, 10, 9, 'HO_TC_09', '1', 'Test View Patient Information', 'Valid', '2019-06-28', 'ploy', '2019-06-28', 'ploy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE `m_users` (
  `userId` char(10) CHARACTER SET latin1 NOT NULL,
  `Firstname` char(10) CHARACTER SET latin1 NOT NULL,
  `lastname` char(10) CHARACTER SET latin1 NOT NULL,
  `username` char(10) CHARACTER SET latin1 NOT NULL,
  `password` char(10) CHARACTER SET latin1 NOT NULL,
  `status` char(10) CHARACTER SET latin1 NOT NULL,
  `staffflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_users`
--

INSERT INTO `m_users` (`userId`, `Firstname`, `lastname`, `username`, `password`, `status`, `staffflag`) VALUES
('1', 'ploy', 'ploy', 'ploy', '1234', '1', 3),
('2', 'sa', 'test', 'sa_test', 'qwerty123', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `temp_rollback`
--

CREATE TABLE `temp_rollback` (
  `id` int(10) NOT NULL,
  `projectId` int(10) NOT NULL,
  `ChangeRequestNo` varchar(10) NOT NULL,
  `status` smallint(1) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `requestDate` date NOT NULL,
  `reason` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temp_rollback`
--

INSERT INTO `temp_rollback` (`id`, `projectId`, `ChangeRequestNo`, `status`, `userId`, `requestDate`, `reason`) VALUES
(1, 1, 'CH01', 1, '2', '2019-06-28', 'TEST Rollback to HO_FR_02 Version 1');

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_detail`
--

CREATE TABLE `t_change_request_detail` (
  `changeRequestNo` char(10) CHARACTER SET latin1 NOT NULL,
  `sequenceNo` char(10) CHARACTER SET latin1 NOT NULL,
  `changeType` char(10) CHARACTER SET latin1 NOT NULL,
  `typeData` char(10) CHARACTER SET latin1 NOT NULL,
  `refdataId` char(10) CHARACTER SET latin1 NOT NULL,
  `refschemaId` int(10) DEFAULT NULL,
  `refSchemaVersionId` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `dataName` char(10) CHARACTER SET latin1 NOT NULL,
  `dataType` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `dataLength` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `scale` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintUnique` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintNotNull` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintDefault` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintMin` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `constraintMax` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `refTableName` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `refColumnName` char(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_change_request_detail`
--

INSERT INTO `t_change_request_detail` (`changeRequestNo`, `sequenceNo`, `changeType`, `typeData`, `refdataId`, `refschemaId`, `refSchemaVersionId`, `dataName`, `dataType`, `dataLength`, `scale`, `constraintUnique`, `constraintNotNull`, `constraintDefault`, `constraintMin`, `constraintMax`, `refTableName`, `refColumnName`) VALUES
('CH01', '1', 'edit', '2', '7', NULL, '1', 'FIRSTNAME', 'VARCHAR', '30', NULL, 'N', 'Y', NULL, NULL, NULL, 'PATIENT', 'FIRSTNAME'),
('CH01', '2', 'add', '2', '999999', NULL, NULL, 'AGE', 'INT', '3', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL),
('CH02', '1', 'delete', '2', '21', NULL, NULL, 'AGE', 'INT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_header`
--

CREATE TABLE `t_change_request_header` (
  `projectId` int(10) NOT NULL,
  `changeRequestNo` varchar(10) NOT NULL,
  `changeUserId` varchar(10) NOT NULL,
  `changeDate` date NOT NULL,
  `changeFunctionId` varchar(10) NOT NULL,
  `changeFunctionNo` varchar(10) NOT NULL,
  `changeFunctionVersion` varchar(10) NOT NULL,
  `changeStatus` int(11) DEFAULT NULL,
  `createUser` varchar(10) DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `updateUser` varchar(10) DEFAULT NULL,
  `updateDate` date NOT NULL,
  `reason` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_change_request_header`
--

INSERT INTO `t_change_request_header` (`projectId`, `changeRequestNo`, `changeUserId`, `changeDate`, `changeFunctionId`, `changeFunctionNo`, `changeFunctionVersion`, `changeStatus`, `createUser`, `createDate`, `updateUser`, `updateDate`, `reason`) VALUES
(1, 'CH01', '1', '2019-06-28', '2', 'HO_FR_02', '1 ', 1, 'ploy', '2019-06-28', 'ploy', '2019-06-28', NULL),
(1, 'CH02', '1', '2019-06-28', '5', 'HO_FR_05', '1', 1, 'ploy', '2019-06-28', 'ploy', '2019-06-28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_temp_change_list`
--

CREATE TABLE `t_temp_change_list` (
  `lineNumber` int(11) NOT NULL,
  `userId` varchar(20) DEFAULT NULL,
  `functionId` int(11) NOT NULL,
  `functionVersion` varchar(20) NOT NULL,
  `typeData` int(11) NOT NULL,
  `dataName` varchar(20) NOT NULL,
  `schemaId` int(10) DEFAULT NULL,
  `schemaVersionId` int(10) DEFAULT NULL,
  `newDataType` varchar(20) DEFAULT NULL,
  `newDataLength` varchar(10) DEFAULT NULL,
  `newScaleLength` varchar(20) DEFAULT NULL,
  `newUnique` varchar(20) DEFAULT NULL,
  `newNotNull` varchar(20) DEFAULT NULL,
  `newDefaultValue` varchar(20) DEFAULT NULL,
  `newMinValue` varchar(20) DEFAULT NULL,
  `newMaxValue` varchar(20) DEFAULT NULL,
  `tableName` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `columnName` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `changeType` varchar(20) DEFAULT NULL,
  `createUser` varchar(20) DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `dataId` int(11) NOT NULL,
  `confirmflag` int(11) DEFAULT NULL,
  `approveflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aff_fr`
--
ALTER TABLE `aff_fr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aff_rtm`
--
ALTER TABLE `aff_rtm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aff_schema`
--
ALTER TABLE `aff_schema`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aff_testcase`
--
ALTER TABLE `aff_testcase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_fr_version`
--
ALTER TABLE `map_fr_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_rtm`
--
ALTER TABLE `map_rtm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_schema`
--
ALTER TABLE `map_schema`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_schema_version`
--
ALTER TABLE `map_schema_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_tc_version`
--
ALTER TABLE `map_tc_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_database_schema_info`
--
ALTER TABLE `m_database_schema_info`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `m_database_schema_version`
--
ALTER TABLE `m_database_schema_version`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `m_fn_req_detail`
--
ALTER TABLE `m_fn_req_detail`
  ADD PRIMARY KEY (`dataId`);

--
-- Indexes for table `m_fn_req_header`
--
ALTER TABLE `m_fn_req_header`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `m_project`
--
ALTER TABLE `m_project`
  ADD PRIMARY KEY (`projectId`);

--
-- Indexes for table `m_rtm_version`
--
ALTER TABLE `m_rtm_version`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `m_testcase_detail`
--
ALTER TABLE `m_testcase_detail`
  ADD PRIMARY KEY (`sequenceNo`);

--
-- Indexes for table `m_testcase_header`
--
ALTER TABLE `m_testcase_header`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `m_users`
--
ALTER TABLE `m_users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `temp_rollback`
--
ALTER TABLE `temp_rollback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_temp_change_list`
--
ALTER TABLE `t_temp_change_list`
  ADD PRIMARY KEY (`lineNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aff_fr`
--
ALTER TABLE `aff_fr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `aff_rtm`
--
ALTER TABLE `aff_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `aff_schema`
--
ALTER TABLE `aff_schema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `aff_testcase`
--
ALTER TABLE `aff_testcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `map_fr_version`
--
ALTER TABLE `map_fr_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `map_rtm`
--
ALTER TABLE `map_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `map_schema`
--
ALTER TABLE `map_schema`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `map_schema_version`
--
ALTER TABLE `map_schema_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `map_tc_version`
--
ALTER TABLE `map_tc_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_database_schema_info`
--
ALTER TABLE `m_database_schema_info`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `m_database_schema_version`
--
ALTER TABLE `m_database_schema_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `m_fn_req_detail`
--
ALTER TABLE `m_fn_req_detail`
  MODIFY `dataId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `m_fn_req_header`
--
ALTER TABLE `m_fn_req_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_project`
--
ALTER TABLE `m_project`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_rtm_version`
--
ALTER TABLE `m_rtm_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `m_testcase_detail`
--
ALTER TABLE `m_testcase_detail`
  MODIFY `sequenceNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `m_testcase_header`
--
ALTER TABLE `m_testcase_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `temp_rollback`
--
ALTER TABLE `temp_rollback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_temp_change_list`
--
ALTER TABLE `t_temp_change_list`
  MODIFY `lineNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
