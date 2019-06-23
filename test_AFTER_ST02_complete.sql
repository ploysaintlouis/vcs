-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2019 at 09:37 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(1, 4, 'CH01', 2, 'ST_FR_02', 1, 'delete');

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
(1, 'CH01', 2, 'ST_FR_02', 1, 2, 'ST_TC_02', 1);

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
(1, 'CH01', 1, 'CUSTOMER', 'EMAIL', 1, 'add');

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
(1, 'CH01', 2, 'ST_TC_02', 1, 'delete');

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
(1, 4, 2, 'ST_FR_02', 1, 5, 'ST_FR_05', 1);

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
(1, 4, 1, 'CUSTOMER', 1, 1, 'CUSTOMER', 2);

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
(1, 4, 2, 'ST_TC_02', 1, 5, 'ST_TC_05', 1);

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
  `dataLength` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `decimalPoint` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `constraintPrimaryKey` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
  `constraintUnique` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
  `constraintDefault` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `constraintNull` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
  `constraintMinValue` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `constraintMaxValue` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `activeflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_database_schema_info`
--

INSERT INTO `m_database_schema_info` (`projectId`, `tableName`, `columnName`, `Id`, `schemaVersionId`, `Version`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`, `activeflag`) VALUES
(4, 'CUSTOMER', 'ACCOUNT', 110, 1, 1, 'varchar', '10', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'CUSTOMER_NAME', 111, 1, 1, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'BIRTHDATE', 112, 1, 1, 'date', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'ADDRESS', 113, 1, 1, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'PHONE', 114, 1, 1, 'varchar', '10', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'STOCK', 'SHARE_ID', 115, 2, 1, 'int', NULL, NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'STOCK', 'SHARECODE', 116, 2, 1, 'varchar', '20', NULL, 'N', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'STOCK', 'SHARENAME', 117, 2, 1, 'varchar', '50', NULL, 'N', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'ORDER', 'ORDERID', 118, 3, 1, 'int', NULL, NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'ORDER', 'ACCOUNT', 119, 3, 1, 'varchar', '10', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'ORDER', 'SHAREID', 120, 3, 1, 'int', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'ORDER', 'SHARECODE', 121, 3, 1, 'varchar', '10', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'ORDER', 'UNIT', 122, 3, 1, 'int', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'ORDER', 'PRICE', 123, 3, 1, 'decimal', '3', '2', 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CLOSEPRICE', 'SHARE_ID', 124, 4, 1, 'int', NULL, NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'CLOSEPRICE', 'CLOSEDATE', 125, 4, 1, 'date', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CLOSEPRICE', 'CLOSEPRICE', 126, 4, 1, 'decimal', '3', '2', 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'ACCOUNT', 127, 1, 2, 'varchar', '10', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 0),
(4, 'CUSTOMER', 'CUSTOMER_NAME', 128, 1, 2, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(4, 'CUSTOMER', 'BIRTHDATE', 129, 1, 2, 'date', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(4, 'CUSTOMER', 'ADDRESS', 130, 1, 2, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(4, 'CUSTOMER', 'PHONE', 131, 1, 2, 'varchar', '10', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 0),
(4, 'CUSTOMER', 'EMAIL', 134, 1, 2, 'VARCHAR ', '30', '', 'N', 'N', '', 'N', '', '', 0);

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
(4, 116, 1, '1', 'CUSTOMER', 'ACCOUNT', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 117, 1, '1', 'CUSTOMER', 'CUSTOMER_NAME', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 118, 1, '1', 'CUSTOMER', 'BIRTHDATE', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 119, 1, '1', 'CUSTOMER', 'ADDRESS', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 120, 1, '1', 'CUSTOMER', 'PHONE', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 121, 2, '1', 'STOCK', 'SHARE_ID', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 122, 2, '1', 'STOCK', 'SHARECODE', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 123, 2, '1', 'STOCK', 'SHARENAME', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 124, 3, '1', 'ORDER', 'ORDERID', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 125, 3, '1', 'ORDER', 'ACCOUNT', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 126, 3, '1', 'ORDER', 'SHAREID', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 127, 3, '1', 'ORDER', 'SHARECODE', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 128, 3, '1', 'ORDER', 'UNIT', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 129, 3, '1', 'ORDER', 'PRICE', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 130, 4, '1', 'CLOSEPRICE', 'SHARE_ID', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 131, 4, '1', 'CLOSEPRICE', 'CLOSEDATE', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 132, 4, '1', 'CLOSEPRICE', 'CLOSEPRICE', '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 133, 1, '2', 'CUSTOMER', 'ACCOUNT', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0),
(4, 134, 1, '2', 'CUSTOMER', 'CUSTOMER_NAME', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0),
(4, 135, 1, '2', 'CUSTOMER', 'BIRTHDATE', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0),
(4, 136, 1, '2', 'CUSTOMER', 'ADDRESS', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0),
(4, 137, 1, '2', 'CUSTOMER', 'PHONE', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0),
(4, 140, 1, '2', 'CUSTOMER', 'EMAIL', '2019-06-23', '2019-06-23', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0);

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
(4, 1, 'ST_FR_01', 1, '1', 1, 'ACCOUNT', '110', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 1, 'ST_FR_01', 1, '1', 2, 'CUSTOMER_NAME', '111', 'CUSTOMER', 'CUSTOMER_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 1, 'ST_FR_01', 1, '1', 3, 'BIRTHDATE', '112', 'CUSTOMER', 'BIRTHDATE', 'date', '', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 1, 'ST_FR_01', 1, '1', 4, 'ADDRESS', '113', 'CUSTOMER', 'ADDRESS', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 1, 'ST_FR_01', 1, '1', 5, 'PHONE', '114', 'CUSTOMER', 'PHONE', 'varchar', '10', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 2, 'ST_FR_02', 1, '1', 6, 'ACCOUNT', '110', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-23', '2019-06-23', 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 2, 'ST_FR_02', 1, '1', 7, 'CUSTOMER_NAME', '111', 'CUSTOMER', 'CUSTOMER_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', '2019-06-23', 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 2, 'ST_FR_02', 1, '1', 8, 'BIRTHDATE', '112', 'CUSTOMER', 'BIRTHDATE', 'date', '', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', '2019-06-23', 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 2, 'ST_FR_02', 1, '2', 9, 'AGE', NULL, NULL, NULL, 'INT', '', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-23', '2019-06-23', 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 3, 'ST_FR_03', 1, '1', 10, 'SHARE_ID', '115', 'STOCK', 'SHARE_ID', 'int', '', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 3, 'ST_FR_03', 1, '1', 11, 'SHARECODE', '116', 'STOCK', 'SHARECODE', 'varchar', '20', '', 'N', 'Y', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 3, 'ST_FR_03', 1, '1', 12, 'SHARENAME', '117', 'STOCK', 'SHARENAME', 'varchar', '50', '', 'N', 'Y', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 4, 'ST_FR_04', 1, '1', 13, 'ACCOUNT', '110', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 4, 'ST_FR_04', 1, '1', 14, 'SHARECODE', '116', 'STOCK', 'SHARECODE', 'varchar', '20', '', 'N', 'Y', '', 'Y', '', '', '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 4, 'ST_FR_04', 1, '1', 15, 'UNIT', NULL, NULL, NULL, 'INT', '', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 4, 'ST_FR_04', 1, '2', 16, 'AMOUNT', NULL, NULL, NULL, 'DECIMAL', '8', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-23', NULL, 1, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 5, 'ST_FR_05', 1, '1', 17, 'ACCOUNT', '127', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-23', '2019-06-23', 0, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 5, 'ST_FR_05', 1, '1', 18, 'CUSTOMER_NAME', '128', 'CUSTOMER', 'CUSTOMER_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', '2019-06-23', 0, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 5, 'ST_FR_05', 1, '1', 19, 'BIRTHDATE', '129', 'CUSTOMER', 'BIRTHDATE', 'date', '', '', 'N', 'N', '', 'Y', '', '', '2019-06-23', '2019-06-23', 0, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 5, 'ST_FR_05', 1, '2', 20, 'AGE', NULL, NULL, NULL, 'DECIMAL ', '3', '2', NULL, 'N', NULL, 'N', NULL, NULL, '2019-06-23', '2019-06-23', 0, '2019-06-23', 'ploy', '2019-06-23', 'ploy'),
(4, 5, 'ST_FR_05', 1, '2', 24, 'EMAIL', '134', 'CUSTOMER', 'EMAIL', 'VARCHAR ', '30', '', 'N', 'N', '', 'N', '', '', '2019-06-23', '2019-06-23', 0, '2019-06-23', 'ploy', '2019-06-23', 'ploy');

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
(65, 1, 'ST_FR_01', '1', 'Add Customer Information', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 4, 1),
(66, 2, 'ST_FR_02', '1', 'View Customer Information', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 4, 1),
(67, 3, 'ST_FR_03', '1', 'Add Securities Information', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 4, 1),
(68, 4, 'ST_FR_04', '1', 'Buy/Sell', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 4, 1),
(69, 5, 'ST_FR_05', '1', 'View Customer Information', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_miscellaneous`
--

CREATE TABLE `m_miscellaneous` (
  `miscData` char(30) NOT NULL,
  `miscValue1` char(20) NOT NULL,
  `miscValue2` char(20) DEFAULT NULL,
  `miscDescription` char(50) NOT NULL,
  `activeFlag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `projectName` varchar(50) NOT NULL,
  `projectNameAlias` varchar(50) NOT NULL,
  `effDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `customer` varchar(50) DEFAULT NULL,
  `databaseName` varchar(50) NOT NULL,
  `hostname` varchar(50) DEFAULT NULL,
  `port` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(10) NOT NULL,
  `startFlag` smallint(6) NOT NULL,
  `activeFlag` smallint(1) DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `createUser` char(10) DEFAULT NULL,
  `updateDate` datetime NOT NULL,
  `updateUser` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `createUser` varchar(10) CHARACTER SET utf8 NOT NULL,
  `updateDate` date NOT NULL,
  `updateUser` varchar(10) CHARACTER SET utf8 NOT NULL,
  `activeFlag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_rtm_version`
--

INSERT INTO `m_rtm_version` (`Id`, `projectId`, `testCaseId`, `testCaseversion`, `functionId`, `functionVersion`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(63, 4, 1, 1, 1, 1, '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(64, 4, 2, 1, 2, 1, '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0),
(65, 4, 3, 1, 3, 1, '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(66, 4, 4, 1, 4, 1, '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(67, 4, 5, 1, 5, 1, '2019-06-23', NULL, '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_running_ch`
--

CREATE TABLE `m_running_ch` (
  `projectId` int(11) NOT NULL,
  `changeRequestNo` varchar(20) NOT NULL,
  `changeRequestId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_running_ch`
--

INSERT INTO `m_running_ch` (`projectId`, `changeRequestNo`, `changeRequestId`) VALUES
(2, 'CH', 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_running_prefix`
--

CREATE TABLE `m_running_prefix` (
  `prefix` char(20) DEFAULT NULL,
  `affix` char(10) DEFAULT NULL,
  `length` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_detail`
--

CREATE TABLE `m_testcase_detail` (
  `projectId` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `testcaseVersion` varchar(10) CHARACTER SET utf8 NOT NULL,
  `typeData` int(11) NOT NULL,
  `refdataId` int(11) DEFAULT NULL,
  `refdataName` varchar(20) CHARACTER SET utf8 NOT NULL,
  `testData` varchar(50) CHARACTER SET utf8 NOT NULL,
  `effectiveStartDate` date DEFAULT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `activeFlag` varchar(1) CHARACTER SET utf8 NOT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `sequenceNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_testcase_detail`
--

INSERT INTO `m_testcase_detail` (`projectId`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `typeData`, `refdataId`, `refdataName`, `testData`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`, `sequenceNo`) VALUES
(4, 1, 'ST_TC_01', '1', 1, 173, 'ACCOUNT', '123456', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 137),
(4, 1, 'ST_TC_01', '1', 1, 174, 'CUSTOMER_NAME', 'Nannaphat', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 138),
(4, 1, 'ST_TC_01', '1', 1, 175, 'BIRTHDATE', '05/09/1989', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 139),
(4, 1, 'ST_TC_01', '1', 1, 176, 'ADDRESS', '123 test road', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 140),
(4, 1, 'ST_TC_01', '1', 1, 177, 'PHONE', '869637133', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 141),
(4, 2, 'ST_TC_02', '1', 1, 173, 'ACCOUNT', '126868', '2019-06-23', '2019-06-23', '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 142),
(4, 2, 'ST_TC_02', '1', 1, 174, 'CUSTOMER_NAME', 'AbcTed', '2019-06-23', '2019-06-23', '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 143),
(4, 2, 'ST_TC_02', '1', 1, 175, 'BIRTHDATE', '05/06/1991', '2019-06-23', '2019-06-23', '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 144),
(4, 2, 'ST_TC_02', '1', 2, 181, 'AGE', '28', '2019-06-23', '2019-06-23', '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 145),
(4, 3, 'ST_TC_03', '1', 1, 182, 'SHARE_ID', '101', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 146),
(4, 3, 'ST_TC_03', '1', 1, 183, 'SHARECODE', 'HMPRO', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 147),
(4, 3, 'ST_TC_03', '1', 1, 184, 'SHARENAME', 'Home Product Center Public Co Ltd', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 148),
(4, 4, 'ST_TC_04', '1', 1, 173, 'ACCOUNT', '123456', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 149),
(4, 4, 'ST_TC_04', '1', 1, 183, 'SHARECODE', 'HMPRO', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 150),
(4, 4, 'ST_TC_04', '1', 1, 187, 'UNIT', '17.5', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 151),
(4, 4, 'ST_TC_04', '1', 2, 188, 'AMOUNT', '20000', '2019-06-23', NULL, '1', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 152),
(4, 5, 'ST_TC_05', '1', 1, 173, 'ACCOUNT', '126868', '2019-06-23', '2019-06-23', '0', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 153),
(4, 5, 'ST_TC_05', '1', 1, 174, 'CUSTOMER_NAME', 'AbcTed', '2019-06-23', '2019-06-23', '0', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 154),
(4, 5, 'ST_TC_05', '1', 1, 175, 'BIRTHDATE', '05/06/1991', '2019-06-23', '2019-06-23', '0', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 155),
(4, 5, 'ST_TC_05', '1', 2, 181, 'AGE', '23', '2019-06-23', '2019-06-23', '0', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 156),
(4, 5, 'ST_TC_05', '1', 2, 999999, 'EMAIL', '56', '2019-06-23', '2019-06-23', '0', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 160);

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_header`
--

CREATE TABLE `m_testcase_header` (
  `projectId` int(10) NOT NULL,
  `Id` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `testcaseVersion` varchar(10) CHARACTER SET utf8 NOT NULL,
  `testCaseDescription` varchar(50) DEFAULT NULL,
  `expectedResult` varchar(50) NOT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `activeflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_testcase_header`
--

INSERT INTO `m_testcase_header` (`projectId`, `Id`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `testCaseDescription`, `expectedResult`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeflag`) VALUES
(4, 47, 1, 'ST_TC_01', '1', 'Test Add Customer Information', 'Valid', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 48, 2, 'ST_TC_02', '1', 'Test View Customer Information', 'Valid', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 49, 3, 'ST_TC_03', '1', 'Test Add securities Information', 'Valid', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 50, 4, 'ST_TC_04', '1', 'Test Buy/Sell', 'Valid', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 1),
(4, 51, 5, 'ST_TC_05', '1', 'Test View Customer Information', 'Valid', '2019-06-23', 'ploy', '2019-06-23', 'ploy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE `m_users` (
  `userId` char(10) NOT NULL,
  `Firstname` char(10) NOT NULL,
  `lastname` char(10) NOT NULL,
  `username` char(10) NOT NULL,
  `password` char(10) NOT NULL,
  `status` char(10) NOT NULL,
  `staffflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 4, 'CH01', 1, '2', '2019-06-23', 'TEST Rollback to ST_FR_02');

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_detail`
--

CREATE TABLE `t_change_request_detail` (
  `changeRequestNo` char(10) NOT NULL,
  `sequenceNo` char(10) NOT NULL,
  `changeType` char(10) NOT NULL,
  `typeData` char(10) NOT NULL,
  `refdataId` char(10) NOT NULL,
  `refschemaId` int(10) DEFAULT NULL,
  `refSchemaVersionId` char(10) DEFAULT NULL,
  `dataName` char(10) NOT NULL,
  `dataType` char(10) DEFAULT NULL,
  `dataLength` char(10) DEFAULT NULL,
  `scale` char(10) DEFAULT NULL,
  `constraintUnique` char(10) DEFAULT NULL,
  `constraintNotNull` char(10) DEFAULT NULL,
  `constraintDefault` char(10) DEFAULT NULL,
  `constraintMin` char(10) DEFAULT NULL,
  `constraintMax` char(10) DEFAULT NULL,
  `refTableName` char(10) DEFAULT NULL,
  `refColumnName` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_change_request_detail`
--

INSERT INTO `t_change_request_detail` (`changeRequestNo`, `sequenceNo`, `changeType`, `typeData`, `refdataId`, `refschemaId`, `refSchemaVersionId`, `dataName`, `dataType`, `dataLength`, `scale`, `constraintUnique`, `constraintNotNull`, `constraintDefault`, `constraintMin`, `constraintMax`, `refTableName`, `refColumnName`) VALUES
('CH01', '1', 'add', '2', '999999', NULL, '1', 'EMAIL', 'VARCHAR', '30', NULL, 'N', 'N', NULL, NULL, NULL, 'CUSTOMER', 'EMAIL'),
('CH01', '2', 'edit', '2', '9', NULL, NULL, 'AGE', 'DECIMAL', '3', '2', 'N', 'N', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_header`
--

CREATE TABLE `t_change_request_header` (
  `projectId` int(10) NOT NULL,
  `changeRequestNo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `changeUserId` varchar(10) CHARACTER SET utf8 NOT NULL,
  `changeDate` date NOT NULL,
  `changeFunctionId` varchar(10) CHARACTER SET utf8 NOT NULL,
  `changeFunctionNo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `changeFunctionVersion` varchar(10) CHARACTER SET utf8 NOT NULL,
  `changeStatus` int(11) DEFAULT NULL,
  `createUser` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `updateUser` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `updateDate` date NOT NULL,
  `reason` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_change_request_header`
--

INSERT INTO `t_change_request_header` (`projectId`, `changeRequestNo`, `changeUserId`, `changeDate`, `changeFunctionId`, `changeFunctionNo`, `changeFunctionVersion`, `changeStatus`, `createUser`, `createDate`, `updateUser`, `updateDate`, `reason`) VALUES
(4, 'CH01', '1', '2019-06-23', '2', 'ST_FR_02', '1 ', 1, 'ploy', '2019-06-23', 'ploy', '2019-06-23', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `aff_rtm`
--
ALTER TABLE `aff_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `aff_schema`
--
ALTER TABLE `aff_schema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `aff_testcase`
--
ALTER TABLE `aff_testcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `map_fr_version`
--
ALTER TABLE `map_fr_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `map_schema_version`
--
ALTER TABLE `map_schema_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `map_tc_version`
--
ALTER TABLE `map_tc_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m_database_schema_info`
--
ALTER TABLE `m_database_schema_info`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `m_database_schema_version`
--
ALTER TABLE `m_database_schema_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
--
-- AUTO_INCREMENT for table `m_fn_req_detail`
--
ALTER TABLE `m_fn_req_detail`
  MODIFY `dataId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `m_fn_req_header`
--
ALTER TABLE `m_fn_req_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `m_project`
--
ALTER TABLE `m_project`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `m_rtm_version`
--
ALTER TABLE `m_rtm_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `m_testcase_detail`
--
ALTER TABLE `m_testcase_detail`
  MODIFY `sequenceNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `m_testcase_header`
--
ALTER TABLE `m_testcase_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `temp_rollback`
--
ALTER TABLE `temp_rollback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_temp_change_list`
--
ALTER TABLE `t_temp_change_list`
  MODIFY `lineNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
