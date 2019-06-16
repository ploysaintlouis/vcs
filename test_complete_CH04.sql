-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2019 at 08:47 AM
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
(1, 2, 'CH01', 25, 'OS_FR_03', 1, 'delete'),
(2, 2, 'CH01', 36, 'OS_FR_04', 1, 'edit'),
(3, 2, 'CH02', 27, 'OS_FR_02', 1, 'delete'),
(5, 4, 'CH04', 40, 'ST_FR_01', 1, 'delete');

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
(1, 'CH01', 25, 'OS_FR_03', 1, 16, 'OS_TC_03', 1),
(2, 'CH01', 36, 'OS_FR_04', 1, 23, 'OS_TC_04', 1),
(3, 'CH02', 27, 'OS_FR_02', 1, 18, 'OS_TC_02', 1),
(5, 'CH04', 40, 'ST_FR_01', 1, 27, 'ST_TC_01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `aff_schema`
--

CREATE TABLE `aff_schema` (
  `id` int(11) NOT NULL,
  `ChangeRequestNo` varchar(10) NOT NULL,
  `schemaVersionId` int(10) NOT NULL,
  `tableName` varchar(20) NOT NULL,
  `columnName` varchar(20) NOT NULL,
  `Version` int(11) NOT NULL,
  `changeType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aff_schema`
--

INSERT INTO `aff_schema` (`id`, `ChangeRequestNo`, `schemaVersionId`, `tableName`, `columnName`, `Version`, `changeType`) VALUES
(1, 'CH01', 5, 'ORDER_DETAILS', 'UNIT_PRICE', 1, 'edit'),
(2, 'CH01', 5, 'ORDER_DETAILS', 'DISCOUNT', 1, 'edit'),
(3, 'CH02', 4, 'ORDERS', 'SHIP_ADDRESS', 1, 'edit'),
(6, 'CH04', 7, 'CUSTOMER', 'ADDRESS', 1, 'edit'),
(7, 'CH04', 7, 'CUSTOMER', 'PHONE', 1, 'delete'),
(8, 'CH04', 7, 'CUSTOMER', 'EMAIL', 0, 'add');

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
(1, 'CH01', 16, 'OS_TC_03', 1, 'delete'),
(2, 'CH01', 23, 'OS_TC_04', 1, 'edit'),
(3, 'CH02', 18, 'OS_TC_02', 1, 'delete'),
(5, 'CH04', 27, 'ST_TC_01', 1, 'delete');

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
(1, 2, 25, 'OS_FR_03', 1, 37, 'OS_FR_05', 1),
(2, 2, 36, 'OS_FR_04', 1, 36, 'OS_FR_04', 2),
(3, 2, 27, 'OS_FR_02', 1, 38, 'OS_FR_06', 1),
(5, 4, 40, 'ST_FR_01', 1, 44, 'ST_FR_05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `map_schema_version`
--

CREATE TABLE `map_schema_version` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `Old_schemaVersionId` int(10) NOT NULL,
  `Old_TableName` varchar(20) NOT NULL,
  `Old_Schema_Version` int(11) NOT NULL,
  `New_schemaVersionId` int(11) NOT NULL,
  `New_TableName` varchar(20) NOT NULL,
  `New_Schema_Version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_schema_version`
--

INSERT INTO `map_schema_version` (`id`, `projectId`, `Old_schemaVersionId`, `Old_TableName`, `Old_Schema_Version`, `New_schemaVersionId`, `New_TableName`, `New_Schema_Version`) VALUES
(7, 2, 5, 'ORDER_DETAILS', 1, 5, 'ORDER_DETAILS', 2),
(8, 2, 4, 'ORDERS', 1, 4, 'ORDERS', 2),
(10, 4, 7, 'CUSTOMER', 1, 7, 'CUSTOMER', 2);

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
(1, 2, 16, 'OS_TC_03', 1, 24, 'OS_TC_05', 1),
(2, 2, 23, 'OS_TC_04', 1, 23, 'OS_TC_04', 2),
(3, 2, 18, 'OS_TC_02', 1, 25, 'OS_TC_06', 1),
(5, 4, 27, 'ST_TC_01', 1, 31, 'ST_TC_05', 1);

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
  `dataLength` char(10) DEFAULT NULL,
  `decimalPoint` char(10) DEFAULT NULL,
  `constraintPrimaryKey` char(1) DEFAULT NULL,
  `constraintUnique` char(1) DEFAULT NULL,
  `constraintDefault` char(10) DEFAULT NULL,
  `constraintNull` char(1) DEFAULT NULL,
  `constraintMinValue` char(10) DEFAULT NULL,
  `constraintMaxValue` char(10) DEFAULT NULL,
  `activeflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_database_schema_info`
--

INSERT INTO `m_database_schema_info` (`projectId`, `tableName`, `columnName`, `Id`, `schemaVersionId`, `Version`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`, `activeflag`) VALUES
(2, 'PRODUCTS', 'PRODUCT_ID', 25, 1, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'PRODUCTS', 'PRODUCT_NAME', 26, 1, 1, 'varchar', '50', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'PRODUCTS', 'CATEGORY_ID', 27, 1, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'PRODUCTS', 'QUANLITY_PER_UNIT', 28, 1, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'PRODUCTS', 'UNIT_PRICE', 29, 1, 1, 'decimal', '18', '6', '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'PRODUCTS', 'UNIT_INSTOCK', 30, 1, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'PRODUCTS', 'UNIT_ONORDER', 31, 1, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CATEGORIES', 'CATEGORY_ID', 32, 2, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CATEGORIES', 'CATEGORY_NAME', 33, 2, 1, 'varchar', '100', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CATEGORIES', 'DESCRIPTION', 34, 2, 1, 'varchar', '255', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CUSTOMERS', 'CUSTORMER_ID', 35, 3, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CUSTOMERS', 'COMPANY_NAME', 36, 3, 1, 'varchar', '255', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CUSTOMERS', 'CONTACT_NAME', 37, 3, 1, 'varchar', '50', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CUSTOMERS', 'CONTACT_TITLE', 38, 3, 1, 'char', '2', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'CUSTOMERS', 'PHONE_NO', 39, 3, 1, 'varchar', '10', NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDERS', 'ORDER_ID', 40, 4, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDERS', 'CUSTOMER_ID', 41, 4, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDERS', 'ORDER_DATE', 42, 4, 1, 'date', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDERS', 'SHIP_ADDRESS', 43, 4, 1, 'varchar', '255', NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDER_DETAILS', 'ORDER_ID', 44, 5, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDER_DETAILS', 'PRODUCT_ID', 45, 5, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDER_DETAILS', 'UNIT_PRICE', 46, 5, 1, 'decimal', '18', '6', '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDER_DETAILS', 'QUANLITY', 47, 5, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDER_DETAILS', 'DISCOUNT', 48, 5, 1, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDER_DETAILS', 'ORDER_ID', 49, 5, 2, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDER_DETAILS', 'PRODUCT_ID', 50, 5, 2, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDER_DETAILS', 'UNIT_PRICE', 51, 5, 2, 'DECIMAL', '18', '2', '', 'N', NULL, 'N', NULL, NULL, 0),
(2, 'ORDER_DETAILS', 'QUANLITY', 52, 5, 2, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 0),
(2, 'ORDER_DETAILS', 'DISCOUNT', 53, 5, 2, 'int', NULL, NULL, '', 'N', NULL, 'N', NULL, '100', 0),
(2, 'ORDERS', 'ORDER_ID', 54, 4, 2, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDERS', 'CUSTOMER_ID', 55, 4, 2, 'int', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDERS', 'ORDER_DATE', 56, 4, 2, 'date', NULL, NULL, '', '', NULL, 'Y', NULL, NULL, 1),
(2, 'ORDERS', 'SHIP_ADDRESS', 57, 4, 2, 'VARCHAR', '50', NULL, '', 'N', NULL, 'N', NULL, NULL, 1),
(3, 'PRODUCT', 'PRODUCT_ID', 61, 6, 1, 'int', NULL, NULL, 'Y', 'N', NULL, 'Y', NULL, NULL, 1),
(3, 'PRODUCT', 'PRODUCT_NAME', 62, 6, 1, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(3, 'PRODUCT', 'DESCRIPTION', 63, 6, 1, 'varchar', '255', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'ACCOUNT', 64, 7, 1, 'varchar', '10', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'CUSTOMER_NAME', 65, 7, 1, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'BIRTHDATE', 66, 7, 1, 'date', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'ADDRESS', 67, 7, 1, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'PHONE', 68, 7, 1, 'varchar', '10', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'STOCK', 'SHARE_ID', 69, 8, 1, 'int', NULL, NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'STOCK', 'SHARECODE', 70, 8, 1, 'varchar', '20', NULL, 'N', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'STOCK', 'SHARENAME', 71, 8, 1, 'varchar', '50', NULL, 'N', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'ACCOUNT', 86, 7, 2, 'varchar', '10', NULL, 'Y', 'Y', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'CUSTOMER_NAME', 87, 7, 2, 'varchar', '100', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'BIRTHDATE', 88, 7, 2, 'date', NULL, NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'ADDRESS', 89, 7, 2, 'VARCHAR', '150', NULL, 'N', 'N', NULL, 'Y', NULL, NULL, 1),
(4, 'CUSTOMER', 'EMAIL', 93, 7, 2, 'VARCHAR', '30', NULL, 'N', 'N', NULL, 'N', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_database_schema_version`
--

CREATE TABLE `m_database_schema_version` (
  `projectId` int(11) NOT NULL,
  `Id` int(10) NOT NULL,
  `schemaVersionId` int(10) NOT NULL,
  `schemaVersionNumber` char(10) NOT NULL,
  `tableName` varchar(50) NOT NULL,
  `columnName` varchar(50) NOT NULL,
  `effectiveStartDate` date NOT NULL,
  `effectiveEndDate` date DEFAULT NULL,
  `createDate` date NOT NULL,
  `createUser` varchar(50) NOT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `activeFlag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_database_schema_version`
--

INSERT INTO `m_database_schema_version` (`projectId`, `Id`, `schemaVersionId`, `schemaVersionNumber`, `tableName`, `columnName`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(2, 25, 1, '1', 'PRODUCTS', 'PRODUCT_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 26, 1, '1', 'PRODUCTS', 'PRODUCT_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 27, 1, '1', 'PRODUCTS', 'CATEGORY_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 28, 1, '1', 'PRODUCTS', 'QUANLITY_PER_UNIT', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 29, 1, '1', 'PRODUCTS', 'UNIT_PRICE', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 30, 1, '1', 'PRODUCTS', 'UNIT_INSTOCK', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 31, 1, '1', 'PRODUCTS', 'UNIT_ONORDER', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 32, 2, '1', 'CATEGORIES', 'CATEGORY_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 33, 2, '1', 'CATEGORIES', 'CATEGORY_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 34, 2, '1', 'CATEGORIES', 'DESCRIPTIO', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 35, 3, '1', 'CUSTOMERS', 'CUSTORMER_ID', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 36, 3, '1', 'CUSTOMERS', 'COMPANY_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 37, 3, '1', 'CUSTOMERS', 'CONTACT_NAME', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 38, 3, '1', 'CUSTOMERS', 'CONTACT_TITLE', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 39, 3, '1', 'CUSTOMERS', 'PHONE_NO', '2019-01-07', NULL, '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 40, 4, '1', 'ORDERS', 'ORDER_ID', '2019-01-07', '2019-05-23', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 0),
(2, 41, 4, '1', 'ORDERS', 'CUSTOMER_ID', '2019-01-07', '2019-05-23', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 0),
(2, 42, 4, '1', 'ORDERS', 'ORDER_DATE', '2019-01-07', '2019-05-23', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 0),
(2, 43, 4, '1', 'ORDERS', 'SHIP_ADDRESS', '2019-01-07', '2019-05-23', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 0),
(2, 44, 5, '1', 'ORDER_DETAILS', 'ORDER_ID', '2019-01-07', '2019-06-01', '2019-01-07', 'ploy', '2019-06-01', '', 1),
(2, 45, 5, '1', 'ORDER_DETAILS', 'PRODUCT_ID', '2019-01-07', '2019-06-01', '2019-01-07', 'ploy', '2019-06-01', '', 1),
(2, 46, 5, '1', 'ORDER_DETAILS', 'UNIT_PRICE', '2019-01-07', '2019-06-01', '2019-01-07', 'ploy', '2019-06-01', '', 1),
(2, 47, 5, '1', 'ORDER_DETAILS', 'QUANLITY', '2019-01-07', '2019-06-01', '2019-01-07', 'ploy', '2019-06-01', '', 1),
(2, 48, 5, '1', 'ORDER_DETAILS', 'DISCOUNT', '2019-01-07', '2019-06-01', '2019-01-07', 'ploy', '2019-06-01', '', 1),
(2, 49, 5, '2', 'ORDER_DETAILS', 'ORDER_ID', '2019-05-22', '2019-06-01', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 50, 5, '2', 'ORDER_DETAILS', 'PRODUCT_ID', '2019-05-22', '2019-06-01', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 51, 5, '2', 'ORDER_DETAILS', 'UNIT_PRICE', '2019-05-22', '2019-06-01', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 52, 5, '2', 'ORDER_DETAILS', 'QUANLITY', '2019-05-22', '2019-06-01', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 53, 5, '2', 'ORDER_DETAILS', 'DISCOUNT', '2019-05-22', '2019-06-01', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 54, 4, '2', 'ORDERS', 'ORDER_ID', '2019-05-23', NULL, '2019-05-23', 'ploy', '2019-05-23', 'ploy', 1),
(2, 55, 4, '2', 'ORDERS', 'CUSTOMER_ID', '2019-05-23', NULL, '2019-05-23', 'ploy', '2019-05-23', 'ploy', 1),
(2, 56, 4, '2', 'ORDERS', 'ORDER_DATE', '2019-05-23', NULL, '2019-05-23', 'ploy', '2019-05-23', 'ploy', 1),
(2, 57, 4, '2', 'ORDERS', 'SHIP_ADDRESS', '2019-05-23', NULL, '2019-05-23', 'ploy', '2019-05-23', 'ploy', 1),
(3, 67, 6, '1', 'PRODUCT', 'PRODUCT_ID', '2019-06-02', NULL, '2019-06-02', 'ploy', '2019-06-02', 'ploy', 1),
(3, 68, 6, '1', 'PRODUCT', 'PRODUCT_NAME', '2019-06-02', NULL, '2019-06-02', 'ploy', '2019-06-02', 'ploy', 1),
(3, 69, 6, '1', 'PRODUCT', 'DESCRIPTION', '2019-06-02', NULL, '2019-06-02', 'ploy', '2019-06-02', 'ploy', 1),
(4, 70, 7, '1', 'CUSTOMER', 'ACCOUNT', '2019-06-14', '2019-06-16', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 0),
(4, 71, 7, '1', 'CUSTOMER', 'CUSTOMER_NAME', '2019-06-14', '2019-06-16', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 0),
(4, 72, 7, '1', 'CUSTOMER', 'BIRTHDATE', '2019-06-14', '2019-06-16', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 0),
(4, 73, 7, '1', 'CUSTOMER', 'ADDRESS', '2019-06-14', '2019-06-16', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 0),
(4, 74, 7, '1', 'CUSTOMER', 'PHONE', '2019-06-14', '2019-06-16', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 0),
(4, 75, 8, '1', 'STOCK', 'SHARE_ID', '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(4, 76, 8, '1', 'STOCK', 'SHARECODE', '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(4, 77, 8, '1', 'STOCK', 'SHARENAME', '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(4, 92, 7, '2', 'CUSTOMER', 'ACCOUNT', '2019-06-16', NULL, '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1),
(4, 93, 7, '2', 'CUSTOMER', 'CUSTOMER_NAME', '2019-06-16', NULL, '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1),
(4, 94, 7, '2', 'CUSTOMER', 'BIRTHDATE', '2019-06-16', NULL, '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1),
(4, 95, 7, '2', 'CUSTOMER', 'ADDRESS', '2019-06-16', NULL, '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1),
(4, 99, 7, '2', 'CUSTOMER', 'EMAIL', '2019-06-16', NULL, '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_fn_req_detail`
--

CREATE TABLE `m_fn_req_detail` (
  `projectid` int(11) NOT NULL,
  `functionId` int(11) NOT NULL,
  `functionNo` char(10) NOT NULL,
  `functionVersion` int(11) NOT NULL,
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

INSERT INTO `m_fn_req_detail` (`projectid`, `functionId`, `functionNo`, `functionVersion`, `typeData`, `dataId`, `dataName`, `schemaVersionId`, `refTableName`, `refColumnName`, `dataType`, `dataLength`, `decimalPoint`, `constraintPrimaryKey`, `constraintUnique`, `constraintDefault`, `constraintNull`, `constraintMinValue`, `constraintMaxValue`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`) VALUES
(2, 25, 'OS_FR_03', 1, '1', 36, 'dOrder Id', '44', 'ORDER_DETAILS', 'ORDER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-06-01', 1, '2019-01-07', 'ploy', '2019-06-01', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 37, 'dProduct Id', '45', 'ORDER_DETAILS', 'PRODUCT_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-06-01', 1, '2019-01-07', 'ploy', '2019-06-01', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 38, 'dUnit Price', '46', 'ORDER_DETAILS', 'UNIT_PRICE', 'decimal', '18', '6', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-06-01', 1, '2019-01-07', 'ploy', '2019-06-01', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 39, 'dQty', '47', 'ORDER_DETAILS', 'QUANLITY', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-06-01', 1, '2019-01-07', 'ploy', '2019-06-01', 'ploy'),
(2, 25, 'OS_FR_03', 1, '1', 40, 'dDiscount', '48', 'ORDER_DETAILS', 'DISCOUNT', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-06-01', 1, '2019-01-07', 'ploy', '2019-06-01', 'ploy'),
(2, 25, 'OS_FR_03', 1, '2', 41, 'dPrice', NULL, '', '', 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-07', '2019-06-01', 1, '2019-01-07', 'ploy', '2019-06-01', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 42, 'Product Id', '25', 'PRODUCTS', 'PRODUCT_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 43, 'Product Name', '26', 'PRODUCTS', 'PRODUCT_NAME', 'varchar', '50', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 44, 'Category Id', '27', 'PRODUCTS', 'CATEGORY_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 45, 'Qty Per Unit', '28', 'PRODUCTS', 'QUANLITY_PER_UNIT', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 46, 'unit Price', '29', 'PRODUCTS', 'UNIT_PRICE', 'decimal', '18', '6', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 47, 'Unit in Stock', '30', 'PRODUCTS', 'UNIT_INSTOCK', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 26, 'OS_FR_01', 1, '1', 48, 'Unit in Order', '31', 'PRODUCTS', 'UNIT_ONORDER', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', NULL, 1, '2019-01-07', 'ploy', '2019-01-07', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 49, 'Order Id', '40', 'ORDERS', 'ORDER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-05-23', 0, '2019-01-07', 'ploy', '2019-05-23', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 50, 'Order Customer Id', '41', 'ORDERS', 'CUSTOMER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-05-23', 0, '2019-01-07', 'ploy', '2019-05-23', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 51, 'Order DATE', '42', 'ORDERS', 'ORDER_DATE', 'DATE', '', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-05-23', 0, '2019-01-07', 'ploy', '2019-05-23', 'ploy'),
(2, 27, 'OS_FR_02', 1, '1', 52, 'Ship Address', '43', 'ORDERS', 'SHIP_ADDRESS', 'varchar', '255', '', 'N', 'N', '', 'Y', '', '', '2019-01-07', '2019-05-23', 0, '2019-01-07', 'ploy', '2019-05-23', 'ploy'),
(2, 36, 'OS_FR_04', 1, '1', 57, 'dDiscount', '48', 'ORDER_DETAILS', 'DISCOUNT', 'int', '', '', '', '', '', 'Y', '', '', '2019-04-30', '2019-06-01', 1, '2019-04-30', 'ploy', '2019-06-01', ''),
(2, 36, 'OS_FR_04', 1, '1', 58, 'dUnit Price', '46', 'ORDER_DETAILS', 'UNIT_PRICE', 'decimal', '18', '6', '', '', '', 'Y', '', '', '2019-04-30', '2019-06-01', 1, '2019-04-30', 'ploy', '2019-06-01', ''),
(2, 36, 'OS_FR_04', 1, '2', 59, 'dPrice', NULL, '', '', 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-30', '2019-06-01', 1, '2019-04-30', 'ploy', '2019-06-01', ''),
(2, 36, 'OS_FR_04', 1, '1', 60, 'dName', NULL, '', '', 'char', '20', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-30', '2019-06-01', 1, '2019-04-30', 'ploy', '2019-06-01', ''),
(2, 37, 'OS_FR_05', 1, '1', 75, 'dOrder Id', '44', 'ORDER_DETAILS', 'ORDER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', 'ploy'),
(2, 37, 'OS_FR_05', 1, '1', 76, 'dProduct Id', '45', 'ORDER_DETAILS', 'PRODUCT_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', 'ploy'),
(2, 37, 'OS_FR_05', 1, '1', 77, 'dUnit Price', '46', 'ORDER_DETAILS', 'UNIT_PRICE', 'decimal', '18', '6', 'N', 'N', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', 'ploy'),
(2, 37, 'OS_FR_05', 1, '1', 78, 'dQty', '47', 'ORDER_DETAILS', 'QUANLITY', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', 'ploy'),
(2, 37, 'OS_FR_05', 1, '1', 79, 'dDiscount', '48', 'ORDER_DETAILS', 'DISCOUNT', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', 'ploy'),
(2, 37, 'OS_FR_05', 1, '2', 80, 'dPrice', NULL, '', '', 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', 'ploy'),
(2, 38, 'OS_FR_05', 1, '1', 82, 'dId', NULL, '', '', 'VARCHAR', '20', '', 'N', 'N', '', 'N', '', '', '2019-05-22', NULL, 1, '2019-05-22', 'ploy', '2019-05-22', 'ploy'),
(2, 36, 'OS_FR_04', 2, '1', 83, 'dDiscount', '48', 'ORDER_DETAILS', 'DISCOUNT', 'int', '', '', '', '', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', ''),
(2, 36, 'OS_FR_04', 2, '1', 84, 'dUnit Price', '46', 'ORDER_DETAILS', 'UNIT_PRICE', 'decimal', '18', '6', '', '', '', 'Y', '', '', '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', ''),
(2, 36, 'OS_FR_04', 2, '2', 85, 'dPrice', NULL, '', '', 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', ''),
(2, 36, 'OS_FR_04', 2, '1', 86, 'dName', NULL, '', '', 'char', '20', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, '2019-05-22', '2019-06-01', 0, '2019-05-22', 'ploy', '2019-06-01', ''),
(2, 38, 'OS_FR_06', 1, '1', 87, 'Order Id', '40', 'ORDERS', 'ORDER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-23', NULL, 1, '2019-05-23', 'ploy', '2019-05-23', 'ploy'),
(2, 38, 'OS_FR_06', 1, '1', 88, 'Order Customer Id', '41', 'ORDERS', 'CUSTOMER_ID', 'int', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-23', NULL, 1, '2019-05-23', 'ploy', '2019-05-23', 'ploy'),
(2, 38, 'OS_FR_06', 1, '1', 89, 'Order DATE', '42', 'ORDERS', 'ORDER_DATE', 'DATE', '', '', 'N', 'N', '', 'Y', '', '', '2019-05-23', NULL, 1, '2019-05-23', 'ploy', '2019-05-23', 'ploy'),
(2, 38, 'OS_FR_06', 1, '1', 90, 'Ship Address', '43', 'ORDERS', 'SHIP_ADDRESS', 'varchar', '255', '', 'N', 'N', '', 'Y', '', '', '2019-05-23', NULL, 1, '2019-05-23', 'ploy', '2019-05-23', 'ploy'),
(2, 38, 'OS_FR_06', 1, '1', 94, 'dId', NULL, '', '', 'VARCHAR', '20', '', 'N', 'N', '', 'N', '', '', '2019-05-23', NULL, 1, '2019-05-23', 'ploy', '2019-05-23', 'ploy'),
(3, 39, 'BK_FR_01', 1, '1', 101, 'PRODUCT_ID', '61', 'PRODUCT', 'PRODUCT_ID', 'int', '', '', 'Y', 'N', '', 'Y', '', '', '2019-06-02', NULL, 1, '2019-06-02', 'ploy', '2019-06-02', 'ploy'),
(3, 39, 'BK_FR_01', 1, '1', 102, 'PRODUCT_NAME', '62', 'PRODUCT', 'PRODUCT_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-02', NULL, 1, '2019-06-02', 'ploy', '2019-06-02', 'ploy'),
(3, 39, 'BK_FR_01', 1, '1', 103, 'DESCRIPTION', '63', 'PRODUCT', 'DESCRIPTION', 'varchar', '255', '', 'N', 'N', '', 'Y', '', '', '2019-06-02', NULL, 1, '2019-06-02', 'ploy', '2019-06-02', 'ploy'),
(4, 40, 'ST_FR_01', 1, '1', 104, 'ACCOUNT', '64', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-14', '2019-06-16', 0, '2019-06-14', 'sa_test', '2019-06-16', 'ploy'),
(4, 40, 'ST_FR_01', 1, '1', 105, 'CUSTOMER_NAME', '65', 'CUSTOMER', 'CUSTOMER_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-14', '2019-06-16', 0, '2019-06-14', 'sa_test', '2019-06-16', 'ploy'),
(4, 40, 'ST_FR_01', 1, '1', 106, 'BIRTHDATE', '66', 'CUSTOMER', 'BIRTHDATE', 'date', '', '', 'N', 'N', '', 'Y', '', '', '2019-06-14', '2019-06-16', 0, '2019-06-14', 'sa_test', '2019-06-16', 'ploy'),
(4, 40, 'ST_FR_01', 1, '1', 107, 'ADDRESS', '67', 'CUSTOMER', 'ADDRESS', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-14', '2019-06-16', 0, '2019-06-14', 'sa_test', '2019-06-16', 'ploy'),
(4, 40, 'ST_FR_01', 1, '1', 108, 'PHONE', '68', 'CUSTOMER', 'PHONE', 'varchar', '10', '', 'N', 'N', '', 'Y', '', '', '2019-06-14', '2019-06-16', 0, '2019-06-14', 'sa_test', '2019-06-16', 'ploy'),
(4, 41, 'ST_FR_02', 1, '1', 109, 'ACCOUNT', '64', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 41, 'ST_FR_02', 1, '2', 110, 'CUSTOMER_NAME', '65', 'CUSTOMER', 'CUSTOMER_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 41, 'ST_FR_02', 1, '2', 111, 'BIRTHDATE', '66', 'CUSTOMER', 'BIRTHDATE', 'date', '', '', 'N', 'N', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 41, 'ST_FR_02', 1, '2', 112, 'AGE', NULL, '', '', 'INT', '', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 42, 'ST_FR_03', 1, '1', 113, 'SHARE_ID', '69', 'STOCK', 'SHARE_ID', 'int', '', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 42, 'ST_FR_03', 1, '1', 114, 'SHARECODE', '70', 'STOCK', 'SHARECODE', 'varchar', '20', '', 'N', 'Y', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 42, 'ST_FR_03', 1, '1', 115, 'SHARENAME', '71', 'STOCK', 'SHARENAME', 'varchar', '50', '', 'N', 'Y', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 43, 'ST_FR_04', 1, '1', 116, 'ACCOUNT', '64', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 43, 'ST_FR_04', 1, '1', 117, 'SHARECODE', '70', 'STOCK', 'SHARECODE', 'varchar', '20', '', 'N', 'Y', '', 'Y', '', '', '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 43, 'ST_FR_04', 1, '1', 118, 'UNIT', NULL, '', '', 'INT', '', 'NULL', NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 43, 'ST_FR_04', 1, '2', 119, 'AMOUNT', NULL, '', '', 'DECIMAL', '8', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-14', NULL, 1, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test'),
(4, 44, 'ST_FR_05', 1, '1', 128, 'ACCOUNT', '86', 'CUSTOMER', 'ACCOUNT', 'varchar', '10', '', 'Y', 'Y', '', 'Y', '', '', '2019-06-16', NULL, 1, '2019-06-16', 'ploy', '2019-06-16', 'ploy'),
(4, 44, 'ST_FR_05', 1, '1', 129, 'CUSTOMER_NAME', '87', 'CUSTOMER', 'CUSTOMER_NAME', 'varchar', '100', '', 'N', 'N', '', 'Y', '', '', '2019-06-16', NULL, 1, '2019-06-16', 'ploy', '2019-06-16', 'ploy'),
(4, 44, 'ST_FR_05', 1, '1', 130, 'BIRTHDATE', '88', 'CUSTOMER', 'BIRTHDATE', 'date', '', '', 'N', 'N', '', 'Y', '', '', '2019-06-16', NULL, 1, '2019-06-16', 'ploy', '2019-06-16', 'ploy'),
(4, 44, 'ST_FR_05', 1, '1', 131, 'ADDRESS', '89', 'CUSTOMER', 'ADDRESS', 'VARCHAR', '150', '', 'N', 'N', '', 'Y', '', '', '2019-06-16', NULL, 1, '2019-06-16', 'ploy', '2019-06-16', 'ploy'),
(4, 44, 'ST_FR_05', 1, '1', 135, 'EMAIL', '93', 'CUSTOMER', 'EMAIL', 'VARCHAR', '30', '', 'N', 'N', '', 'N', '', '', '2019-06-16', NULL, 1, '2019-06-16', 'ploy', '2019-06-16', 'ploy');

-- --------------------------------------------------------

--
-- Table structure for table `m_fn_req_header`
--

CREATE TABLE `m_fn_req_header` (
  `Id` int(11) NOT NULL,
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

INSERT INTO `m_fn_req_header` (`Id`, `functionId`, `functionNo`, `functionversion`, `functionDescription`, `createDate`, `createUser`, `updateDate`, `updateUser`, `projectid`, `activeflag`) VALUES
(1, 25, 'OS_FR_03', '1', 'Create Order List', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 2, 1),
(2, 26, 'OS_FR_01', '1', 'Add A New Product Information', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 2, 1),
(3, 27, 'OS_FR_02', '1', 'Create a New Order', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 2, 0),
(4, 36, 'OS_FR_04', '1', 'Create Order Discount', '2019-04-30', 'ploy', '2019-06-01', '', 2, 1),
(38, 37, 'OS_FR_05', '1', 'Create Order List', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 2, 0),
(39, 36, 'OS_FR_04', '2', 'Create Order Discount', '2019-05-22', 'ploy', '2019-06-01', '', 2, 0),
(40, 38, 'OS_FR_06', '1', 'Create a New Order', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 2, 1),
(44, 39, 'BK_FR_01', '1', 'Add A Product Information', '2019-06-02', 'ploy', '2019-06-02', 'ploy', 3, 1),
(45, 40, 'ST_FR_01', '1', 'Add Customer Information', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 4, 0),
(46, 41, 'ST_FR_02', '1', 'View Customer Information', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 4, 1),
(47, 42, 'ST_FR_03', '1', 'Add ecurities Information', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 4, 1),
(48, 43, 'ST_FR_04', '1', 'Buy/Sell', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 4, 1),
(50, 44, 'ST_FR_05', '1', 'Add Customer Information', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 4, 1);

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
  `createUser` char(10) NOT NULL,
  `updateDate` date NOT NULL,
  `updateUser` char(10) NOT NULL,
  `activeFlag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_rtm_version`
--

INSERT INTO `m_rtm_version` (`Id`, `projectId`, `testCaseId`, `testCaseversion`, `functionId`, `functionVersion`, `effectiveStartDate`, `effectiveEndDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeFlag`) VALUES
(1, 2, 16, 1, 25, 1, '2019-01-08', NULL, '2019-01-08', 'ploy', '2019-06-01', 'ploy', 1),
(2, 2, 17, 1, 26, 1, '2019-01-08', NULL, '2019-01-08', 'ploy', '2019-01-08', 'ploy', 1),
(3, 2, 18, 1, 27, 1, '2019-01-08', NULL, '2019-01-08', 'ploy', '2019-05-23', 'ploy', 0),
(4, 2, 23, 1, 36, 1, '2019-04-30', NULL, '2019-04-30', 'ploy', '2019-06-01', 'ploy', 0),
(5, 2, 24, 1, 37, 1, '2019-05-22', NULL, '2019-05-22', 'ploy', '2019-05-22', 'ploy', 1),
(6, 2, 23, 2, 36, 2, '2019-05-22', NULL, '2019-05-22', 'ploy', '2019-05-22', 'ploy', 1),
(7, 2, 25, 1, 38, 1, '2019-05-23', NULL, '2019-05-23', 'ploy', '2019-05-23', 'ploy', 1),
(8, 3, 26, 1, 0, 1, '2019-06-02', NULL, '2019-06-02', 'ploy', '2019-06-02', 'ploy', 1),
(41, 4, 27, 1, 40, 1, '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-15', 'ploy', 0),
(42, 4, 28, 1, 41, 1, '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(43, 4, 29, 1, 42, 1, '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(44, 4, 30, 1, 43, 1, '2019-06-14', NULL, '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(46, 4, 31, 1, 44, 1, '2019-06-16', NULL, '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1);

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
(2, 'CH', 5);

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

INSERT INTO `m_testcase_detail` (`projectId`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `typeData`, `refdataId`, `refdataName`, `testData`, `effectiveStartDate`, `effectiveEndDate`, `activeFlag`, `createDate`, `createUser`, `updateDate`, `updateUser`, `sequenceNo`) VALUES
(2, 16, 'OS_TC_03', '1', 1, 36, 'dOrder Id', '34', '2019-01-07', '2019-06-01', '1', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 11),
(2, 16, 'OS_TC_03', '1', 1, 37, 'dProduct Id', '1', '2019-01-07', '2019-06-01', '1', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 12),
(2, 16, 'OS_TC_03', '1', 1, 38, 'dUnit Price', '28900', '2019-01-07', '2019-06-01', '1', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 13),
(2, 16, 'OS_TC_03', '1', 1, 39, 'dQty', '1', '2019-01-07', '2019-06-01', '1', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 14),
(2, 16, 'OS_TC_03', '1', 1, 40, 'dDiscount', '2000', '2019-01-07', '2019-06-01', '1', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 15),
(2, 16, 'OS_TC_03', '1', 2, 41, 'dPrice', '1000', '2019-01-07', '2019-06-01', '1', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 16),
(2, 17, 'OS_TC_01', '1', 1, 42, 'Product id', 'xx', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 17),
(2, 17, 'OS_TC_01', '1', 1, 43, 'Product Name', 'iPhone 7+', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 18),
(2, 17, 'OS_TC_01', '1', 1, 44, 'Category Id', '17', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 19),
(2, 17, 'OS_TC_01', '1', 1, 46, 'Unit Price', '28900', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 20),
(2, 17, 'OS_TC_01', '1', 1, 47, 'Unit in Stock', '500', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 21),
(2, 17, 'OS_TC_01', '1', 1, 48, 'Unit in Order', '20', '2019-01-07', NULL, '1', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 22),
(2, 18, 'OS_TC_02', '1', 1, 49, 'Order Id', '34', '2019-01-07', '2019-05-23', '0', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 23),
(2, 18, 'OS_TC_02', '1', 1, 50, 'Order Customer Id', '89', '2019-01-07', '2019-05-23', '0', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 24),
(2, 18, 'OS_TC_02', '1', 1, 51, 'Order Date', '19-Jul-2017', '2019-01-07', '2019-05-23', '0', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 25),
(2, 18, 'OS_TC_02', '1', 1, 52, 'Ship Address', '59 Moo.1, Thanthan Uthaithani Thailand', '2019-01-07', '2019-05-23', '0', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 26),
(2, 23, 'OS_TC_04', '1', 1, 58, 'dUnit Price', '28900', '2019-04-30', '2019-06-01', '1', '2019-04-30', 'ploy', '2019-06-01', 'ploy', 31),
(2, 23, 'OS_TC_04', '1', 1, 57, 'dDiscount', '2000', '2019-04-30', '2019-06-01', '1', '2019-04-30', 'ploy', '2019-06-01', 'ploy', 32),
(2, 23, 'OS_TC_04', '1', 2, 59, 'dPrice', '100.5', '2019-04-30', '2019-06-01', '1', '2019-04-30', 'ploy', '2019-06-01', 'ploy', 33),
(2, 23, 'OS_TC_04', '1', 1, 60, 'dName', 'jlkgjdkdfj45', '2019-04-30', '2019-06-01', '1', '2019-04-30', 'ploy', '2019-06-01', 'ploy', 34),
(2, 24, 'OS_TC_05', '1', 1, 36, 'dOrder Id', '34', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 35),
(2, 24, 'OS_TC_05', '1', 1, 37, 'dProduct Id', '1', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 36),
(2, 24, 'OS_TC_05', '1', 1, 38, 'dUnit Price', '.58', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 37),
(2, 24, 'OS_TC_05', '1', 1, 39, 'dQty', '1', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 38),
(2, 24, 'OS_TC_05', '1', 1, 40, 'dDiscount', '79', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 39),
(2, 24, 'OS_TC_05', '1', 1, 287, 'dId', 'l7sFb5nTtKVKJ6ahYahX', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 42),
(2, 23, 'OS_TC_04', '2', 1, 58, 'dUnit Price', '.25', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 43),
(2, 23, 'OS_TC_04', '2', 1, 57, 'dDiscount', '62', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 44),
(2, 23, 'OS_TC_04', '2', 2, 59, 'dPrice', '100.5', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 45),
(2, 23, 'OS_TC_04', '2', 1, 60, 'dName', 'jlkgjdkdfj45', '2019-05-22', '2019-06-01', '0', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 46),
(2, 25, 'OS_TC_06', '1', 1, 49, 'Order Id', '34', '2019-05-23', NULL, '1', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 47),
(2, 25, 'OS_TC_06', '1', 1, 50, 'Order Customer Id', '89', '2019-05-23', NULL, '1', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 48),
(2, 25, 'OS_TC_06', '1', 1, 51, 'Order Date', '19-Jul-2017', '2019-05-23', NULL, '1', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 49),
(2, 25, 'OS_TC_06', '1', 1, 52, 'Ship Address', '9IcRIna2TutoTn2IbvLICwBq655wsh6DW4bekqeUp55AReFeSa', '2019-05-23', NULL, '1', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 50),
(2, 25, 'OS_TC_06', '1', 1, 53, 'dId', 'qVTmWiHZNJyWjxwe7RrN', '2019-05-23', NULL, '1', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 54),
(3, 26, 'BK_TC_01', '1', 1, 98, 'PRODUCT_ID', '1', '2019-06-02', NULL, '1', '2019-06-02', 'ploy', '2019-06-02', 'ploy', 65),
(3, 26, 'BK_TC_01', '1', 1, 99, 'PRODUCT_NAME', 'Deposit Cash', '2019-06-02', NULL, '1', '2019-06-02', 'ploy', '2019-06-02', 'ploy', 66),
(3, 26, 'BK_TC_01', '1', 1, 100, 'DESCRIPTION', 'Deposit Cash Only', '2019-06-02', NULL, '1', '2019-06-02', 'ploy', '2019-06-02', 'ploy', 67),
(4, 27, 'ST_TC_01', '1', 1, 104, 'ACCOUNT', '123456', '2019-06-14', '2019-06-16', '0', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 68),
(4, 27, 'ST_TC_01', '1', 1, 105, 'CUSTOMER_NAME', 'Nannaphat', '2019-06-14', '2019-06-16', '0', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 69),
(4, 27, 'ST_TC_01', '1', 1, 106, 'BIRTHDATE', '05/09/1989', '2019-06-14', '2019-06-16', '0', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 70),
(4, 27, 'ST_TC_01', '1', 1, 107, 'ADDRESS', '123 test road', '2019-06-14', '2019-06-16', '0', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 71),
(4, 27, 'ST_TC_01', '1', 1, 108, 'PHONE', '869637133', '2019-06-14', '2019-06-16', '0', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 72),
(4, 28, 'ST_TC_02', '1', 1, 104, 'ACCOUNT', '126868', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 73),
(4, 28, 'ST_TC_02', '1', 1, 105, 'CUSTOMER_NAME', 'AbcTed', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 74),
(4, 28, 'ST_TC_02', '1', 1, 106, 'BIRTHDATE', '05/06/1991', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 75),
(4, 28, 'ST_TC_02', '1', 2, 112, 'AGE', '28', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 76),
(4, 29, 'ST_TC_03', '1', 1, 113, 'SHARE_ID', '101', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 77),
(4, 29, 'ST_TC_03', '1', 1, 114, 'SHARECODE', 'HMPRO', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 78),
(4, 29, 'ST_TC_03', '1', 1, 115, 'SHARENAME', 'Home Product Center Public Co Ltd', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 79),
(4, 30, 'ST_TC_04', '1', 1, 104, 'ACCOUNT', '123456', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 80),
(4, 30, 'ST_TC_04', '1', 1, 114, 'SHARECODE', 'HMPRO', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 81),
(4, 30, 'ST_TC_04', '1', 1, 118, 'UNIT', '17.5', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 82),
(4, 30, 'ST_TC_04', '1', 2, 119, 'AMOUNT', '20000', '2019-06-14', NULL, '1', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 83),
(4, 31, 'ST_TC_05', '1', 1, 104, 'ACCOUNT', '123456', '2019-06-16', NULL, '1', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 92),
(4, 31, 'ST_TC_05', '1', 1, 105, 'CUSTOMER_NAME', 'Nannaphat', '2019-06-16', NULL, '1', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 93),
(4, 31, 'ST_TC_05', '1', 1, 106, 'BIRTHDATE', '05/09/1989', '2019-06-16', NULL, '1', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 94),
(4, 31, 'ST_TC_05', '1', 1, 107, 'ADDRESS', '6WL1xeUt21pgOPRmi2nt1A5AMLRSXCyWMLP8ZFTjPQwo2n8J31', '2019-06-16', NULL, '1', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 95),
(4, 31, 'ST_TC_05', '1', 1, 999999, 'EMAIL', 'Y34mCfHlgcWl9PGwgYIfydkiWz5BbG', '2019-06-16', NULL, '1', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 99);

-- --------------------------------------------------------

--
-- Table structure for table `m_testcase_header`
--

CREATE TABLE `m_testcase_header` (
  `projectId` int(10) NOT NULL,
  `Id` int(11) NOT NULL,
  `testCaseId` int(11) NOT NULL,
  `testCaseNo` char(10) NOT NULL,
  `testcaseVersion` char(10) NOT NULL,
  `testCaseDescription` varchar(50) DEFAULT NULL,
  `expectedResult` varchar(50) NOT NULL,
  `createDate` date DEFAULT NULL,
  `createUser` char(10) DEFAULT NULL,
  `updateDate` date DEFAULT NULL,
  `updateUser` char(10) DEFAULT NULL,
  `activeflag` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_testcase_header`
--

INSERT INTO `m_testcase_header` (`projectId`, `Id`, `testCaseId`, `testCaseNo`, `testcaseVersion`, `testCaseDescription`, `expectedResult`, `createDate`, `createUser`, `updateDate`, `updateUser`, `activeflag`) VALUES
(2, 1, 16, 'OS_TC_03', '1', '', 'Valid', '2019-01-07', 'ploy', '2019-06-01', 'ploy', 1),
(2, 2, 17, 'OS_TC_01', '1', '', 'Valid', '2019-01-07', 'ploy', '2019-01-07', 'ploy', 1),
(2, 3, 18, 'OS_TC_02', '1', '', 'Valid', '2019-01-07', 'ploy', '2019-05-23', 'ploy', 0),
(2, 4, 23, 'OS_TC_04', '1', '', 'Valid', '2019-04-30', 'ploy', '2019-06-01', 'ploy', 1),
(2, 24, 24, 'OS_TC_05', '1', '', 'Valid', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 25, 23, 'OS_TC_04', '2', '', 'Valid', '2019-05-22', 'ploy', '2019-06-01', 'ploy', 0),
(2, 26, 25, 'OS_TC_06', '1', '', 'Valid', '2019-05-23', 'ploy', '2019-05-23', 'ploy', 1),
(3, 30, 26, 'BK_TC_01', '1', 'Test Add A Product Information ', 'Valid', '2019-06-02', 'ploy', '2019-06-02', 'ploy', 1),
(4, 31, 27, 'ST_TC_01', '1', 'Test Add Customer Information', 'Valid', '2019-06-14', 'sa_test', '2019-06-16', 'ploy', 0),
(4, 32, 28, 'ST_TC_02', '1', 'Test View Customer Information', 'Valid', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(4, 33, 29, 'ST_TC_03', '1', 'Test Add securities Information', 'Valid', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(4, 34, 30, 'ST_TC_04', '1', 'Test Buy/Sell', 'Valid', '2019-06-14', 'sa_test', '2019-06-14', 'sa_test', 1),
(4, 36, 31, 'ST_TC_05', '1', 'Test Add Customer Information', 'Valid', '2019-06-16', 'ploy', '2019-06-16', 'ploy', 1);

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
  `ChangeRequestNo` char(10) NOT NULL,
  `status` smallint(1) NOT NULL,
  `userId` char(10) NOT NULL,
  `requestDate` date NOT NULL,
  `reason` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temp_rollback`
--

INSERT INTO `temp_rollback` (`id`, `projectId`, `ChangeRequestNo`, `status`, `userId`, `requestDate`, `reason`) VALUES
(1, 2, 'CH01', 1, '2', '2019-05-31', 'test');

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
('CH01', '1', 'edit', '1', '40', NULL, '5', 'dDiscount', NULL, NULL, NULL, 'N', 'N', NULL, NULL, '100', 'ORDER_DETA', 'DISCOUNT'),
('CH01', '2', 'edit', '1', '38', NULL, '5', 'dUnit Pric', 'DECIMAL', NULL, '2', 'N', 'N', NULL, NULL, NULL, 'ORDER_DETA', 'UNIT_PRICE'),
('CH01', '3', 'delete', '2', '41', NULL, NULL, 'dPrice', 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('CH01', '4', 'add', '1', '287', NULL, NULL, 'dId', 'VARCHAR', '20', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL),
('CH02', '1', 'edit', '1', '52', NULL, '4', 'Ship Addre', 'VARCHAR', '50', NULL, 'N', 'N', NULL, NULL, NULL, 'ORDERS', 'SHIP_ADDRE'),
('CH02', '2', 'add', '1', '53', NULL, NULL, 'dId', 'VARCHAR', '20', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL),
('CH04', '1', 'add', '1', '999999', NULL, '7', 'EMAIL', 'VARCHAR', '30', NULL, 'N', 'N', NULL, NULL, NULL, 'CUSTOMER', 'EMAIL'),
('CH04', '2', 'delete', '1', '108', NULL, '7', 'PHONE', 'varchar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CUSTOMER', 'PHONE'),
('CH04', '3', 'edit', '1', '107', NULL, '7', 'ADDRESS', 'VARCHAR', '150', NULL, 'N', 'Y', NULL, NULL, NULL, 'CUSTOMER', 'ADDRESS');

-- --------------------------------------------------------

--
-- Table structure for table `t_change_request_header`
--

CREATE TABLE `t_change_request_header` (
  `projectId` char(10) DEFAULT NULL,
  `changeRequestNo` char(10) DEFAULT NULL,
  `changeUserId` char(10) NOT NULL,
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

--
-- Dumping data for table `t_change_request_header`
--

INSERT INTO `t_change_request_header` (`projectId`, `changeRequestNo`, `changeUserId`, `changeDate`, `changeFunctionId`, `changeFunctionNo`, `changeFunctionVersion`, `changeStatus`, `createUser`, `createDate`, `updateUser`, `updateDate`, `reason`) VALUES
('2', 'CH01', '1', '2019-05-22', '25', 'OS_FR_03', '1', '1', 'ploy', '2019-05-22', 'ploy', '2019-05-22', NULL),
('4', 'CH04', '1', '2019-06-16', '40', 'ST_FR_01', '1', '1', 'ploy', '2019-06-16', 'ploy', '2019-06-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_temp_change_list`
--

CREATE TABLE `t_temp_change_list` (
  `lineNumber` int(11) NOT NULL,
  `userId` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `functionId` int(11) NOT NULL,
  `functionVersion` varchar(20) CHARACTER SET utf8 NOT NULL,
  `typeData` int(11) NOT NULL,
  `dataName` varchar(20) CHARACTER SET utf8 NOT NULL,
  `schemaId` int(10) DEFAULT NULL,
  `schemaVersionId` int(10) DEFAULT NULL,
  `newDataType` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `newDataLength` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `newScaleLength` char(20) DEFAULT NULL,
  `newUnique` char(20) DEFAULT NULL,
  `newNotNull` char(20) DEFAULT NULL,
  `newDefaultValue` char(20) DEFAULT NULL,
  `newMinValue` char(20) DEFAULT NULL,
  `newMaxValue` char(20) DEFAULT NULL,
  `tableName` varchar(20) DEFAULT NULL,
  `columnName` varchar(20) DEFAULT NULL,
  `changeType` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `createUser` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `createDate` date DEFAULT NULL,
  `dataId` int(11) NOT NULL,
  `confirmflag` int(11) DEFAULT NULL,
  `approveflag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_temp_change_list`
--

INSERT INTO `t_temp_change_list` (`lineNumber`, `userId`, `functionId`, `functionVersion`, `typeData`, `dataName`, `schemaId`, `schemaVersionId`, `newDataType`, `newDataLength`, `newScaleLength`, `newUnique`, `newNotNull`, `newDefaultValue`, `newMinValue`, `newMaxValue`, `tableName`, `columnName`, `changeType`, `createUser`, `createDate`, `dataId`, `confirmflag`, `approveflag`) VALUES
(20, '1', 25, '1', 1, 'dDiscount', 48, 5, NULL, NULL, NULL, 'N', 'N', NULL, NULL, '100', 'ORDER_DETAILS', 'DISCOUNT', 'edit', 'ploy', '2019-04-08', 40, 1, NULL),
(23, '2', 27, '1', 1, 'dId', NULL, NULL, 'VARCHAR', '20', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, 'add', 'ploy', '2019-04-13', 53, 1, NULL),
(24, '2', 27, '1', 1, 'Ship Address', 43, 4, 'VARCHAR', '50', NULL, 'N', 'N', NULL, NULL, NULL, 'ORDERS', 'SHIP_ADDRESS', 'edit', 'ploy', '2019-04-14', 52, 1, NULL),
(25, '1', 25, '1', 2, 'dPrice', NULL, NULL, 'decimal', '18', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'delete', 'ploy', '2019-04-14', 41, 1, NULL),
(26, '1', 25, '1', 1, 'dId', NULL, NULL, 'VARCHAR', '20', NULL, 'N', 'N', NULL, NULL, NULL, NULL, NULL, 'add', 'ploy', '2019-04-14', 287, 1, NULL),
(27, '1', 25, '1', 1, 'dUnit Price', 46, 5, 'DECIMAL', NULL, '2', 'N', 'N', NULL, NULL, NULL, 'ORDER_DETAILS', 'UNIT_PRICE', 'edit', 'ploy', '2019-04-15', 38, 1, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `aff_rtm`
--
ALTER TABLE `aff_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `aff_schema`
--
ALTER TABLE `aff_schema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `aff_testcase`
--
ALTER TABLE `aff_testcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `map_fr_version`
--
ALTER TABLE `map_fr_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `map_schema_version`
--
ALTER TABLE `map_schema_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `map_tc_version`
--
ALTER TABLE `map_tc_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `m_database_schema_info`
--
ALTER TABLE `m_database_schema_info`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `m_database_schema_version`
--
ALTER TABLE `m_database_schema_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `m_fn_req_detail`
--
ALTER TABLE `m_fn_req_detail`
  MODIFY `dataId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `m_fn_req_header`
--
ALTER TABLE `m_fn_req_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `m_project`
--
ALTER TABLE `m_project`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `m_rtm_version`
--
ALTER TABLE `m_rtm_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `m_testcase_detail`
--
ALTER TABLE `m_testcase_detail`
  MODIFY `sequenceNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `m_testcase_header`
--
ALTER TABLE `m_testcase_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `temp_rollback`
--
ALTER TABLE `temp_rollback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_temp_change_list`
--
ALTER TABLE `t_temp_change_list`
  MODIFY `lineNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
