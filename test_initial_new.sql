-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2019 at 05:41 PM
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
('inputDataType', 'CHAR', 'Strings', '', 1),
('inputDatatype', 'VARCHAR', 'Strings', '', 1),
('inputDatatype', 'DATE', 'Date', '', 1),
('inputDatatype', 'INT', 'Numerics', '', 1),
('inputDatatype', 'FLOAT', 'Numerics', '', 1),
('inputDatatype', 'DOUBLE', 'Numerics', '', 1),
('inputDatatype', 'DECIMAL', 'Numerics', '', 1);

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
(1, 'CH', 1),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aff_rtm`
--
ALTER TABLE `aff_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aff_schema`
--
ALTER TABLE `aff_schema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aff_testcase`
--
ALTER TABLE `aff_testcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `map_fr_version`
--
ALTER TABLE `map_fr_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `map_rtm`
--
ALTER TABLE `map_rtm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `map_schema`
--
ALTER TABLE `map_schema`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `map_schema_version`
--
ALTER TABLE `map_schema_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `map_tc_version`
--
ALTER TABLE `map_tc_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_database_schema_info`
--
ALTER TABLE `m_database_schema_info`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_database_schema_version`
--
ALTER TABLE `m_database_schema_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_fn_req_detail`
--
ALTER TABLE `m_fn_req_detail`
  MODIFY `dataId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_fn_req_header`
--
ALTER TABLE `m_fn_req_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_project`
--
ALTER TABLE `m_project`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `m_rtm_version`
--
ALTER TABLE `m_rtm_version`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_testcase_detail`
--
ALTER TABLE `m_testcase_detail`
  MODIFY `sequenceNo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_testcase_header`
--
ALTER TABLE `m_testcase_header`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `temp_rollback`
--
ALTER TABLE `temp_rollback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_temp_change_list`
--
ALTER TABLE `t_temp_change_list`
  MODIFY `lineNumber` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
