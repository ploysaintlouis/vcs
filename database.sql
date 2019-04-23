-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2019 at 09:32 PM
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
-- Table structure for table `m_database_schema_info`
--

CREATE TABLE `M_DATABASE_SCHEMA_INFO` (
  `projectId` int(11) NOT NULL,
  `tableName` char(50) NOT NULL,
  `columnName` char(50) NOT NULL,
  `schemaVersionId` int(11) NOT NULL,
  `dataType` char(20) NOT NULL,
  `dataLength` char(10) DEFAULT NULL,
  `decimalPoint` char(10) DEFAULT NULL,
  `constraintPrimaryKey` char(1) DEFAULT NULL,
  `constraintUnique` char(1) DEFAULT NULL,
  `constraintDefault` char(10) DEFAULT NULL,
  `constraintNull` char(1) DEFAULT NULL,
  `constraintMinValue` char(10) DEFAULT NULL,
  `constraintMaxValue` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_database_schema_info`
--

INSERT INTO `M_DATABASE_SCHEMA_INFO` (`projectId`, `tableName`, `columnName`, `schemaVersionId`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`) VALUES
(2, 'PRODUCTS', 'PRODUCT_ID', 25, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'PRODUCTS', 'PRODUCT_NAME', 26, 'varchar', '50', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'PRODUCTS', 'CATEGORY_ID', 27, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'PRODUCTS', 'QUANLITY_PER_UNIT', 28, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'PRODUCTS', 'UNIT_PRICE', 29, 'decimal', '18', '6', '', '', NULL, 'Y', NULL, NULL),
(2, 'PRODUCTS', 'UNIT_INSTOCK', 30, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'PRODUCTS', 'UNIT_ONORDER', 31, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CATEGORIES', 'CATEGORY_ID', 32, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CATEGORIES', 'CATEGORY_NAME', 33, 'varchar', '100', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CATEGORIES', 'DESCRIPTION', 34, 'varchar', '255', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CUSTOMERS', 'CUSTORMER_ID', 35, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CUSTOMERS', 'COMPANY_NAME', 36, 'varchar', '255', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CUSTOMERS', 'CONTACT_NAME', 37, 'varchar', '50', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CUSTOMERS', 'CONTACT_TITLE', 38, 'char', '2', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'CUSTOMERS', 'PHONE_NO', 39, 'varchar', '10', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDERS', 'ORDER_ID', 40, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDERS', 'CUSTOMER_ID', 41, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDERS', 'ORDER_DATE', 42, 'date', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDERS', 'SHIP_ADDRESS', 43, 'varchar', '255', NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDER_DETAILS', 'ORDER_ID', 44, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDER_DETAILS', 'PRODUCT_ID', 45, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDER_DETAILS', 'UNIT_PRICE', 46, 'decimal', '18', '6', '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDER_DETAILS', 'QUANLITY', 47, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL),
(2, 'ORDER_DETAILS', 'DISCOUNT', 48, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_database_schema_version`
--

CREATE TABLE `M_DATABASE_SCHEMA_VERSION` (
  `projectId` int(11) NOT NULL,
  `schemaVersionId` int(11) NOT NULL,
  `schemaVersionNumber` char(10) DEFAULT NULL,
  `tableName` varchar(50) NOT NULL,
  `columnName` varchar(50) NOT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `createDate` date NOT NULL,
  `createUser` varchar(50) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `activeFlag` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_database_schema_version`
--

INSERT INTO `M_DATABASE_SCHEMA_VERSION` (`projectId`, `schemaVersionId`, `schemaVersionNumber`, `tableName`, `columnName`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(2, 25, '1', 'PRODUCTS', 'PRODUCT_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 26, '1', 'PRODUCTS', 'PRODUCT_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 27, '1', 'PRODUCTS', 'CATEGORY_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 28, '1', 'PRODUCTS', 'QUANLITY_PER_UNIT', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 29, '1', 'PRODUCTS', 'UNIT_PRICE', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 30, '1', 'PRODUCTS', 'UNIT_INSTOCK', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 31, '1', 'PRODUCTS', 'UNIT_ONORDER', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 32, '1', 'CATEGORIES', 'CATEGORY_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 33, '1', 'CATEGORIES', 'CATEGORY_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 34, '1', 'CATEGORIES', 'DESCRIPTIO', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 35, '1', 'CUSTOMERS', 'CUSTORMER_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 36, '1', 'CUSTOMERS', 'COMPANY_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 37, '1', 'CUSTOMERS', 'CONTACT_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 38, '1', 'CUSTOMERS', 'CONTACT_TITLE', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 39, '1', 'CUSTOMERS', 'PHONE_NO', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 40, '1', 'ORDERS', 'ORDER_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 41, '1', 'ORDERS', 'CUSTOMER_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 42, '1', 'ORDERS', 'ORDER_DATE', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 43, '1', 'ORDERS', 'SHIP_ADDRESS', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 44, '1', 'ORDER_DETAILS', 'ORDER_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 45, '1', 'ORDER_DETAILS', 'PRODUCT_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 46, '1', 'ORDER_DETAILS', 'UNIT_PRICE', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 47, '1', 'ORDER_DETAILS', 'QUANLITY', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 48, '1', 'ORDER_DETAILS', 'DISCOUNT', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_fn_req_detail`
--

CREATE TABLE `M_FN_REQ_DETAIL` (
  `projectid` int(11) DEFAULT NULL,
  `functionId` int(11) NOT NULL,
  `functionNo` char(10) NOT NULL,
  `functionVersion` int(11) DEFAULT NULL,
  `typeData` char(10) NOT NULL,
  `dataId` int(11) NOT NULL,
  `dataName` char(20) NOT NULL,
  `schemaVersionId` char(10) DEFAULT NULL,
  `refTableName` varchar(50) DEFAULT NULL,
  `refColumnName` varchar(50) DEFAULT NULL,
  `dataType` char(20) NOT NULL,
  `dataLength` char(10) DEFAULT NULL,
  `decimalPoint` char(10) DEFAULT NULL,
  `constraintPrimaryKey` char(10) DEFAULT NULL,
  `constraintUnique` char(10) DEFAULT NULL,
  `constraintDefault` char(10) DEFAULT NULL,
  `constraintNull` char(10) DEFAULT NULL,
  `constraintMinValue` char(10) DEFAULT NULL,
  `constraintMaxValue` char(10) DEFAULT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `activeFlag` smallint(6) NOT NULL,
  `createDate` date NOT NULL,
  `createUser` char(10) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_fn_req_detail`
--

INSERT INTO `M_FN_REQ_DETAIL` (`projectid`, `functionId`, `functionNo`, `functionVersion`, `typeData`, `dataId`, `dataName`, `schemaVersionId`, `refTableName`, `refColumnName`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`) VALUES
(2, 25, 'OS_FR_03', 1, '1', 36, 'dOrder Id', '44', 'ORDER_DETAILS', 'ORDER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-20', 1, '2019-01-07', 'ploy', '2019-04-20', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 37, 'dProduct Id', '45', 'ORDER_DETAILS', 'PRODUCT_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-20', 1, '2019-01-07', 'ploy', '2019-04-20', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 38, 'dUnit Price', '46', 'ORDER_DETAILS', 'UNIT_PRICE', 'decimal', '18', '6', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-20', 1, '2019-01-07', 'ploy', '2019-04-20', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 39, 'dQty', '47', 'ORDER_DETAILS', 'QUANLITY', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-20', 1, '2019-01-07', 'ploy', '2019-04-20', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 40, 'dDiscount', '48', 'ORDER_DETAILS', 'DISCOUNT', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-20', 1, '2019-01-07', 'ploy', '2019-04-20', 'ploy'),
(2, 25, 'OS_FR_03', 1, '2', 41, 'dPrice', NULL, '', '', 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-07', '2019-04-20', 1, '2019-01-07', 'ploy', '2019-04-20', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 42, 'Product Id', '25', 'PRODUCTS', 'PRODUCT_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 43, 'Product Name', '26', 'PRODUCTS', 'PRODUCT_NAME', 'varchar', '50', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 44, 'Category Id', '27', 'PRODUCTS', 'CATEGORY_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 45, 'Qty Per Unit', '28', 'PRODUCTS', 'QUANLITY_PER_UNIT', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 46, 'unit Price', '29', 'PRODUCTS', 'UNIT_PRICE', 'decimal', '18', '6', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 47, 'Unit in Stock', '30', 'PRODUCTS', 'UNIT_INSTOCK', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 48, 'Unit in Order', '31', 'PRODUCTS', 'UNIT_ONORDER', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 49, 'Order Id', '40', 'ORDERS', 'ORDER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-15', 1, '2019-01-07', 'ploy', '2019-04-15', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 50, 'Order Customer Id', '41', 'ORDERS', 'CUSTOMER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-15', 1, '2019-01-07', 'ploy', '2019-04-15', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 51, 'Order DATE', '42', 'ORDERS', 'ORDER_DATE', 'DATE', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-15', 1, '2019-01-07', 'ploy', '2019-04-15', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 52, 'Ship Address', '43', 'ORDERS', 'SHIP_ADDRESS', 'varchar', '255', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-04-15', 1, '2019-01-07', 'ploy', '2019-04-15', 'ploy');

-- --------------------------------------------------------

--
-- Table structure for table `m_fn_req_header`
--

CREATE TABLE `M_FN_REQ_HEADER` (
  `functionId` int(11) NOT NULL,
  `functionNo` char(10) NOT NULL,
  `functionversion` char(10) DEFAULT NULL,
  `functionDescription` char(50) NOT NULL,
  `createDate` date NOT NULL,
  `createUser` char(10) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `projectid` int(11) NOT NULL,
  `activeflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_fn_req_header`
--

INSERT INTO `M_FN_REQ_HEADER` (`functionId`, `functionNo`, `functionversion`, `functionDescription`, `createDate`, `createUser`, `updateDate`, `updateUser`, `projectid`, `activeflag`) VALUES
(25, 'OS_FR_03', '1', 'Create Order List', '2019-01-07', 'ploy', '2019-04-20', 'ploy', 2, 1),
(26, 'OS_FR_01', '1', 'Add A New Product Information', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 2, 1),
(27, 'OS_FR_02', '1', 'Create a New Order', '2019-01-07', 'ploy', '2019-04-15', 'ploy', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_miscellaneous`
--

CREATE TABLE `M_MISCELLANEOUS` (
  `miscData` char(30) NOT NULL,
  `miscValue1` char(20) NOT NULL,
  `miscValue2` char(20) DEFAULT NULL,
  `miscDescription` char(50) NOT NULL,
  `activeFlag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_miscellaneous`
--

INSERT INTO `M_MISCELLANEOUS` (`miscData`, `miscValue1`, `miscValue2`, `miscDescription`, `activeFlag`) VALUES
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

CREATE TABLE `M_PROJECT` (
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
  `startFlag` smallint(6) DEFAULT NULL,
  `activeFlag` smallint(6) DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `createUser` char(10) DEFAULT NULL,
  `updateDate` datetime NOT NULL,
  `updateUser` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_project`
--

INSERT INTO `M_PROJECT` (`projectId`, `projectName`, `projectNameAlias`, `effDate`, `endDate`, `customer`, `databaseName`, `hostname`, `port`, `username`, `password`, `startFlag`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`) VALUES
(1, 'Hospital', 'Hospital', '2018-11-29 00:00:00', '2018-12-28 00:00:00', 'test1', 'Hospital', 'localhost', '81', 'ploy', '1234', 1, 1, '2018-11-29 17:59:26', 'ploy', '2018-11-29 17:59:26', 'ploy'),
(2, 'products', 'products', '2019-01-06 00:00:00', '2019-03-08 00:00:00', 'test2', 'products', 'localhost:81', '81', 'ploy ploy', '1234', 1, 1, '2019-01-06 18:31:30', 'ploy', '2019-01-06 18:44:52', 'ploy');

-- --------------------------------------------------------

--
-- Table structure for table `m_rtm_version`
--

CREATE TABLE `M_RTM_VERSION` (
  `projectId` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseversion` int(11) NOT NULL,
  `functionId` int(11) NOT NULL,
  `functionVersion` int(11) NOT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `createDate` date NOT NULL,
  `createUser` char(10) NOT NULL,
  `updateDate` date NOT NULL,
  `updateUser` char(10) NOT NULL,
  `activeFlag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_rtm_version`
--

INSERT INTO `M_RTM_VERSION` (`projectId`, `testCaseId`, `testCaseversion`, `functionId`, `functionVersion`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(2, 17, 1, 26, 1, '2019-01-08', NULL, '2019-01-08', 'ploy', '2019-01-08', 'ploy', 1),
(2, 18, 1, 27, 1, '2019-01-08', NULL, '2019-01-08', 'ploy', '2019-01-08', 'ploy', 1),
(2, 16, 1, 25, 1, '2019-01-08', NULL, '2019-01-08', 'ploy', '2019-01-08', 'ploy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_running_ch`
--

CREATE TABLE `M_RUNNING_CH` (
  `projectId` int(11) NOT NULL,
  `changeRequestNo` varchar(20) NOT NULL,
  `changeRequestId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_running_ch`
--

INSERT INTO `M_RUNNING_CH` (`projectId`, `changeRequestNo`, `changeRequestId`) VALUES
(2, 'CH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_running_prefix`
--

CREATE TABLE `M_RUNNING_PREFIX` (
  `prefix` char(20) DEFAULT NULL,
  `affix` char(10) DEFAULT NULL,
  `length` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_detail`
--

CREATE TABLE `M_TESTCASE_DETAIL` (
  `projectId` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` char(10) NOT NULL,
  `testcaseVersion` char(10) NOT NULL,
  `typeData` int(11) NOT NULL,
  `refdataId` int(11) DEFAULT NULL,
  `refdataName` char(20) NOT NULL,
  `testData` char(50) NOT NULL,
  `effectiveStartDate` date DEFAULT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `activeFlag` char(1) NOT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` char(10) DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `sequenceNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_testcase_detail`
--

INSERT INTO `M_TESTCASE_DETAIL` (`projectId`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `typeData`, `refdataId`, `refdataName`, `testData`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`, `sequenceNo`) VALUES
(2, 16, 'OS_TC_03', '1', 1, 36, 'dOrder Id', '34', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 11),
(2, 16, 'OS_TC_03', '1', 1, 37, 'dProduct Id', '1', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 12),
(2, 16, 'OS_TC_03', '1', 1, 38, 'dUnit Price', '28900', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 13),
(2, 16, 'OS_TC_03', '1', 1, 39, 'dQty', '1', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 14),
(2, 16, 'OS_TC_03', '1', 1, 40, 'dDiscount', '2000', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 15),
(2, 16, 'OS_TC_03', '1', 2, 41, 'dPrice', '1000', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 16),
(2, 17, 'OS_TC_01', '1', 1, 42, 'Product id', 'xx', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 17),
(2, 17, 'OS_TC_01', '1', 1, 43, 'Product Name', 'iPhone 7+', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 18),
(2, 17, 'OS_TC_01', '1', 1, 44, 'Category Id', '17', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 19),
(2, 17, 'OS_TC_01', '1', 1, 46, 'Unit Price', '28900', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 20),
(2, 17, 'OS_TC_01', '1', 1, 47, 'Unit in Stock', '500', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 21),
(2, 17, 'OS_TC_01', '1', 1, 48, 'Unit in Order', '20', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 22),
(2, 18, 'OS_TC_02', '1', 1, 49, 'Order Id', '34', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 23),
(2, 18, 'OS_TC_02', '1', 1, 50, 'Order Customer Id', '89', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 24),
(2, 18, 'OS_TC_02', '1', 1, 51, 'Order Date', '19-Jul-2017', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 25),
(2, 18, 'OS_TC_02', '1', 1, 52, 'Ship Address', '59 Moo.1, Thanthan Uthaithani Thailand', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 26),
(2, 17, 'OS_TC_01', '1', 1, 42, 'Product id', 'xx', '2019-01-08', NULL, '1', '2019-01-08', 'ploy', '2019-01-08', 'ploy', 27),
(2, 17, 'OS_TC_01', '1', 1, 43, 'Product Name', 'iPhone 7+', '2019-01-08', NULL, '1', '2019-01-08', 'ploy', '2019-01-08', 'ploy', 28),
(2, 17, 'OS_TC_01', '1', 1, 44, 'Category Id', '17', '2019-01-08', NULL, '1', '2019-01-08', 'ploy', '2019-01-08', 'ploy', 29),
(2, 17, 'OS_TC_01', '1', 1, 46, 'Unit Price', '28900', '2019-01-08', NULL, '1', '2019-01-08', 'ploy', '2019-01-08', 'ploy', 30),
(2, 17, 'OS_TC_01', '1', 1, 47, 'Unit in Stock', '500', '2019-01-08', NULL, '1', '2019-01-08', 'ploy', '2019-01-08', 'ploy', 31),
(2, 17, 'OS_TC_01', '1', 1, 48, 'Unit in Order', '20', '2019-01-08', NULL, '1', '2019-01-08', 'ploy', '2019-01-08', 'ploy', 32);

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_header`
--

CREATE TABLE `M_TESTCASE_HEADER` (
  `projectId` int(11) DEFAULT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` char(10) DEFAULT NULL,
  `testcaseVersion` char(10) DEFAULT NULL,
  `testCaseDescription` varchar(50) DEFAULT NULL,
  `expectedResult` varchar(50) DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` char(10) DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `activeflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_testcase_header`
--

INSERT INTO `M_TESTCASE_HEADER` (`projectId`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `testCaseDescription`, `expectedResult`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeflag`) VALUES
(2, 16, 'OS_TC_03', '1', '', 'Valid', '2019-01-07', 'ploy', '2019-04-17', 'ploy', 1),
(2, 17, 'OS_TC_01', '1', '', 'Valid', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 18, 'OS_TC_02', '1', '', 'Valid', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE `M_USERS` (
  `userId` char(10) NOT NULL,
  `Firstname` char(10) DEFAULT NULL,
  `lastname` char(10) DEFAULT NULL,
  `username` char(10) NOT NULL,
  `password` char(10) DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `staffflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_users`
--

INSERT INTO `M_USERS` (`userId`, `Firstname`, `lastname`, `username`, `password`, `status`, `staffflag`) VALUES
('0001', 'ploy', 'ploy', 'ploy', '1234', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_detail`
--

CREATE TABLE `T_CHANGE_REQUEST_DETAIL` (
  `changeRequestNo` char(10) DEFAULT NULL,
  `sequenceNo` char(10) DEFAULT NULL,
  `changeType` char(10) DEFAULT NULL,
  `typeData` char(10) DEFAULT NULL,
  `refdataId` char(10) DEFAULT NULL,
  `refSchemaVersionId` char(10) DEFAULT NULL,
  `dataName` char(10) DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_header`
--

CREATE TABLE `T_CHANGE_REQUEST_HEADER` (
  `projectId` char(10) DEFAULT NULL,
  `changeRequestNo` char(10) DEFAULT NULL,
  `changeUserId` char(10) DEFAULT NULL,
  `changeDate` char(10) DEFAULT NULL,
  `changeFunctionId` char(10) DEFAULT NULL,
  `changeFunctionNo` char(10) DEFAULT NULL,
  `changeFunctionVersion` char(10) DEFAULT NULL,
  `changeStatus` char(10) DEFAULT NULL,
  `createUser` char(10) DEFAULT NULL,
  `createDate` char(10) DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `updateDate` char(10) DEFAULT NULL,
  `reason` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_temp_change_list`
--

CREATE TABLE `T_TEMP_CHANGE_LIST` (
  `lineNumber` int(11) NOT NULL,
  `userId` char(20) DEFAULT NULL,
  `functionId` int(11) NOT NULL,
  `functionVersion` char(20) NOT NULL,
  `typeData` int(11) NOT NULL,
  `dataName` char(20) NOT NULL,
  `schemaVersionId` int(11) DEFAULT NULL,
  `newDataType` char(20) DEFAULT NULL,
  `newDataLength` char(10) DEFAULT NULL,
  `newScaleLength` char(20) DEFAULT NULL,
  `newUnique` char(20) DEFAULT NULL,
  `newNotNull` char(20) DEFAULT NULL,
  `newDefaultValue` char(20) DEFAULT NULL,
  `newMinValue` char(20) DEFAULT NULL,
  `newMaxValue` char(20) DEFAULT NULL,
  `tableName` char(20) DEFAULT NULL,
  `columnName` char(20) DEFAULT NULL,
  `changeType` char(20) DEFAULT NULL,
  `createUser` char(20) DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `dataId` int(11) NOT NULL,
  `confirmflag` int(11) DEFAULT NULL,
  `approveflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_temp_change_list`
--

INSERT INTO `T_TEMP_CHANGE_LIST` (`lineNumber`, `userId`, `functionId`, `functionVersion`, `typeData`, `dataName`, `schemaVersionId`, `newDataType`, `newDataLength`, `newScaleLength`, `newUnique`, `newNotNull`, `newDefaultValue`, `newMinValue`, `newMaxValue`, `tableName`, `columnName`, `changeType`, `createUser`, `createDate`, `dataId`, `confirmflag`, `approveflag`) VALUES
(20, '0001', 25, '1', 1, 'dDiscount', 48, NULL, NULL, NULL, 'N', 'N', NULL, NULL, '100', 'ORDER_DETAILS', 'DISCOUNT', 'edit', 'ploy', '2019-04-08', 40, 1, NULL),
(23, '0001', 27, '1', 1, 'dId', 1, 'VARCHAR', '20', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, 'add', 'ploy', '2019-04-13', 53, 1, NULL),
(24, '0001', 27, '1', 1, 'Ship Address', 43, 'VARCHAR', '50', NULL, 'N', 'N', NULL, NULL, NULL, 'ORDERS', 'SHIP_ADDRESS', 'edit', 'ploy', '2019-04-14', 52, 1, NULL),
(25, '0001', 25, '1', 2, 'dPrice', NULL, 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'delete', 'ploy', '2019-04-14', 41, 1, NULL),
(26, '0001', 25, '1', 1, 'dId', 1, 'VARCHAR', '20', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, 'add', 'ploy', '2019-04-14', 287, 1, NULL),
(27, '0001', 25, '1', 1, 'dUnit Price', 46, 'DECIMAL', NULL, '2', 'N', 'N', NULL, NULL, NULL, 'ORDER_DETAILS', 'UNIT_PRICE', 'edit', 'ploy', '2019-04-15', 38, 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
