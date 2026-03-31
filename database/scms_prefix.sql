-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2022 at 02:11 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scms_prefix`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_banks`
--

CREATE TABLE `acc_banks` (
  `bank_id` int(11) UNSIGNED NOT NULL,
  `bank_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_branch` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_acc_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_banks`
--

INSERT INTO `acc_banks` (`bank_id`, `bank_code`, `bank_name`, `bank_branch`, `bank_acc_no`, `bank_address`, `deleted`, `created_by`, `deleted_by`) VALUES
(1, 'BK0001', 'Cash', '', '', NULL, 0, NULL, NULL),
(2, 'BK0000', 'Others', '', '', NULL, 0, NULL, NULL),
(4, '123456', 'Rupali Bank Ltd.', 'Dinajpur', '9155465897150631', 'Nimtola, Goneshtola, Dinajpur-5200', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acc_purposes`
--

CREATE TABLE `acc_purposes` (
  `purpose_id` int(11) UNSIGNED NOT NULL,
  `purpose_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `deleted_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 COLLATE=utf8_unicode_ci DELAY_KEY_WRITE=1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `acc_purposes`
--

INSERT INTO `acc_purposes` (`purpose_id`, `purpose_name`, `reason`, `group_name`, `parent`, `lft`, `rght`, `deleted`, `deleted_by`, `created_by`) VALUES
(1, 'Fees', 'Credit', NULL, 0, 1, 2, 0, NULL, NULL),
(3, 'College Fees', 'Credit', NULL, 1, 5, 6, 0, NULL, NULL),
(5, 'Monthly Fees', 'Credit', NULL, 3, 9, 10, 0, NULL, NULL),
(6, 'Admission Form', 'Credit', NULL, 3, 11, 12, 0, NULL, NULL),
(7, 'Admission Fees', 'Credit', NULL, 3, 13, 14, 0, NULL, NULL),
(9, 'Brake of Study', 'Credit', NULL, 0, 15, 16, 0, NULL, NULL),
(10, 'TC', 'Credit', NULL, 0, 17, 18, 0, NULL, NULL),
(11, 'Late TC Fee', 'Credit', NULL, 0, 19, 20, 0, NULL, NULL),
(12, 'Session Charge', 'Credit', NULL, 3, 21, 22, 0, NULL, NULL),
(13, 'Registration Fee', 'Credit', NULL, 3, 23, 24, 0, NULL, NULL),
(14, 'Subject/Group Transfer', 'Credit', NULL, 0, 25, 26, 0, NULL, NULL),
(15, 'Security Money', 'Credit', NULL, 0, 27, 28, 0, NULL, NULL),
(16, 'Exam Fee', 'Credit', NULL, 3, 29, 30, 0, NULL, NULL),
(17, 'Practical Exam (College)', 'Credit', NULL, 3, 31, 32, 0, NULL, NULL),
(18, 'Practical Exam (Board/University)', 'Credit', NULL, 3, 33, 34, 0, NULL, NULL),
(19, 'Library Fee/Card', 'Credit', NULL, 3, 35, 36, 0, NULL, NULL),
(20, 'Religion & Social Welfare', 'Credit', NULL, 3, 37, 38, 0, NULL, NULL),
(22, 'Culture & Sports', 'Credit', NULL, 3, 39, 40, 0, NULL, NULL),
(23, 'Science & Computer Lab', 'Credit', NULL, 3, 41, 42, 0, NULL, NULL),
(24, 'Poor Fund', 'Credit', NULL, 3, 43, 44, 0, NULL, NULL),
(25, 'Electricity', 'Credit', NULL, 3, 45, 46, 0, NULL, NULL),
(26, 'ID Card', 'Credit', NULL, 3, 47, 48, 0, NULL, NULL),
(27, 'Rover Scout', 'Credit', NULL, 3, 49, 50, 0, NULL, NULL),
(28, 'BNCC', 'Credit', NULL, 3, 51, 52, 0, NULL, NULL),
(29, 'Red Crescent', 'Credit', NULL, 3, 53, 54, 0, NULL, NULL),
(30, 'College Uniform', 'Credit', NULL, 3, 55, 56, 0, NULL, NULL),
(31, 'Prospectus and Syllabus', 'Credit', NULL, 3, 57, 58, 0, NULL, NULL),
(32, 'Website', 'Credit', NULL, 3, 59, 60, 0, NULL, NULL),
(33, 'Affiliation Fees', 'Credit', NULL, 3, 61, 62, 0, NULL, NULL),
(34, 'Non MPO', 'Credit', NULL, 3, 63, 64, 0, NULL, NULL),
(35, 'Cycle Stand', 'Credit', NULL, 3, 65, 66, 0, NULL, NULL),
(36, 'College Computer Lab', 'Credit', NULL, 3, 67, 68, 0, NULL, NULL),
(38, 'Testimonial/Certificate/Mark-sheet (College)', 'Credit', NULL, 0, 69, 70, 0, NULL, NULL),
(39, 'Late Exam Fee', 'Credit', NULL, 0, 71, 72, 0, NULL, NULL),
(40, 'Advance Received', 'Credit', NULL, 0, 73, 74, 0, NULL, NULL),
(41, 'Late Registration Fee', 'Credit', NULL, 0, 75, 76, 0, NULL, NULL),
(42, 'Miscellaneous', 'Credit', NULL, 3, 77, 78, 0, NULL, NULL),
(43, 'Board Fees', 'Credit', NULL, 3, 79, 80, 0, NULL, NULL),
(44, 'Infrastructure Development', 'Credit', NULL, 3, 81, 82, 0, NULL, NULL),
(45, 'Surplus Return', 'Credit', NULL, 0, 83, 84, 0, NULL, NULL),
(46, 'Receive Loan', 'Credit', NULL, 0, 85, 86, 0, NULL, NULL),
(47, 'Payment Receive from Staff Loan', 'Credit', NULL, 0, 87, 88, 0, NULL, NULL),
(48, 'Salary Receive from Govt', 'Credit', NULL, 0, 89, 90, 0, NULL, NULL),
(49, 'Infrastructure Development', 'Credit', NULL, 0, 91, 92, 0, NULL, NULL),
(50, 'Provident Fund', 'Credit', NULL, 0, 93, 94, 0, NULL, NULL),
(51, 'Sports & Cultural Fund', 'Credit', NULL, 0, 95, 96, 0, NULL, NULL),
(52, 'Public Donation', 'Credit', NULL, 0, 97, 98, 0, NULL, NULL),
(53, 'Scholarship Fund', 'Credit', NULL, 0, 99, 100, 0, NULL, NULL),
(54, 'Library Fund', 'Credit', NULL, 0, 101, 102, 0, NULL, NULL),
(55, 'Interest Receive', 'Credit', NULL, 0, 103, 104, 0, NULL, NULL),
(56, 'Admission Fee', 'Credit', NULL, 0, 105, 106, 0, NULL, NULL),
(57, 'Exam Fees', 'Credit', NULL, 0, 107, 108, 0, NULL, NULL),
(58, 'Center Fee Receive', 'Credit', NULL, 0, 109, 110, 0, NULL, NULL),
(59, 'FDR Receive', 'Credit', NULL, 0, 111, 112, 0, NULL, NULL),
(60, 'Miscellaneous', 'Credit', NULL, 0, 113, 114, 0, NULL, NULL),
(61, 'General fund', 'Debit', NULL, 0, 115, 116, 0, NULL, NULL),
(62, 'Giving Loan', 'Debit', NULL, 0, 117, 118, 0, NULL, NULL),
(63, 'Loan Payment', 'Debit', NULL, 0, 119, 120, 0, NULL, NULL),
(64, 'Salary Paid from Govt', 'Debit', NULL, 0, 121, 122, 0, NULL, NULL),
(65, 'Infrastructure Development', 'Debit', NULL, 0, 123, 124, 0, NULL, NULL),
(67, 'Provident Fund', 'Debit', NULL, 0, 127, 128, 0, NULL, NULL),
(68, 'Sports & Cultural Fund', 'Debit', NULL, 0, 129, 130, 0, NULL, NULL),
(69, 'Giving Poor Fund', 'Debit', NULL, 0, 131, 132, 0, NULL, NULL),
(70, 'Scholarship Payment', 'Debit', NULL, 0, 133, 134, 0, NULL, NULL),
(71, 'Library Fund', 'Debit', NULL, 0, 135, 136, 0, NULL, NULL),
(72, 'Salary (College)', 'Debit', NULL, 0, 137, 138, 0, NULL, NULL),
(73, 'Examination Expense', 'Debit', NULL, 0, 139, 140, 0, NULL, NULL),
(74, 'Board Fees Payment', 'Debit', NULL, 0, 141, 142, 0, NULL, NULL),
(75, 'BNCC Transfer', 'Debit', NULL, 0, 143, 144, 0, NULL, NULL),
(76, 'Rover Transfer', 'Debit', NULL, 0, 161, 162, 0, NULL, NULL),
(77, 'Red crescent Transfer', 'Debit', NULL, 0, 163, 164, 0, NULL, NULL),
(78, 'Bank Charge & Vat', 'Debit', NULL, 0, 149, 150, 0, NULL, NULL),
(79, 'FDR Payment', 'Debit', NULL, 0, 151, 152, 0, NULL, NULL),
(80, 'Furniture buy', 'Debit', NULL, 0, 145, 146, 0, NULL, NULL),
(81, 'Agriculture & Others', 'Credit', NULL, 0, 155, 156, 0, NULL, NULL),
(82, 'Science & Tech', 'Credit', NULL, 3, 157, 158, 0, NULL, NULL),
(83, 'Penalty', 'Credit', NULL, 3, 159, 160, 0, NULL, NULL),
(84, 'Center Fee Paid', 'Debit', NULL, 0, 147, 148, 0, NULL, NULL),
(85, 'Miscellaneous', 'Debit', NULL, 0, 153, 154, 0, NULL, NULL),
(86, 'Opening Balance', 'Credit', NULL, 0, 165, 166, 0, NULL, NULL),
(2000, 'Balance Transfer', 'Credit', NULL, 0, 167, 168, 0, NULL, NULL),
(2500, 'Balance Transfer', 'Debit', NULL, 0, 169, 170, 0, NULL, NULL),
(2501, 'Board Fee', 'Credit', NULL, 0, 171, 172, 0, NULL, NULL),
(2502, 'Cycle Stand', 'Credit', NULL, 3, 173, 174, 0, NULL, NULL),
(2503, 'Laboratory', 'Credit', NULL, 3, 175, 176, 0, NULL, NULL),
(2504, 'Seminar', 'Credit', NULL, 3, 177, 178, 0, NULL, NULL),
(2506, 'Discount', 'Credit', NULL, 3, 179, 180, 0, NULL, NULL),
(3000, 'Salary', 'Debit', NULL, NULL, 181, 182, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acc_transactions`
--

CREATE TABLE `acc_transactions` (
  `transaction_id` int(11) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_cycle_id` int(11) UNSIGNED DEFAULT NULL,
  `sid` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `month` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `year` year(4) DEFAULT NULL,
  `school_session_id` year(4) DEFAULT NULL,
  `purpose_id` int(11) UNSIGNED NOT NULL,
  `reason` varchar(10) NOT NULL,
  `amount` float DEFAULT NULL,
  `status` tinyint(3) DEFAULT 1,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp(),
  `money_receipt` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cheque_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `level_id` tinyint(3) DEFAULT NULL,
  `cheque_date` int(11) DEFAULT NULL,
  `from_bank` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_id` int(11) UNSIGNED NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `other` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acc_transactions`
--

INSERT INTO `acc_transactions` (`transaction_id`, `voucher_no`, `student_cycle_id`, `sid`, `month`, `year`, `school_session_id`, `purpose_id`, `reason`, `amount`, `status`, `transaction_date`, `money_receipt`, `cheque_no`, `level_id`, `cheque_date`, `from_bank`, `bank_id`, `employee_id`, `other`, `type`, `transaction_type`, `user_id`, `note`, `deleted`, `deleted_by`) VALUES
(1, '24913579246', NULL, NULL, '', NULL, NULL, 1, 'treat', 1205600, 1, '2022-10-03 18:18:05', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 'asfasfa', 0, NULL),
(3, NULL, NULL, NULL, 'October', NULL, NULL, 3000, 'Debit', NULL, 1, '2022-10-08 10:55:27', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'Debit', 1, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE `acos` (
  `id` int(11) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 764),
(2, 1, NULL, NULL, 'Error', 2, 3),
(3, 1, NULL, NULL, 'Pages', 4, 7),
(4, 3, NULL, NULL, 'display', 5, 6),
(5, 1, NULL, NULL, 'Acl', 8, 9),
(6, 1, NULL, NULL, 'BootstrapUI', 10, 11),
(7, 1, NULL, NULL, 'Croogo\\Acl', 12, 45),
(8, 7, NULL, NULL, 'Admin', 13, 44),
(9, 8, NULL, NULL, 'Actions', 14, 29),
(10, 9, NULL, NULL, 'index', 15, 16),
(11, 9, NULL, NULL, 'add', 17, 18),
(12, 9, NULL, NULL, 'edit', 19, 20),
(13, 9, NULL, NULL, 'delete', 21, 22),
(14, 9, NULL, NULL, 'move', 23, 24),
(15, 9, NULL, NULL, 'generate', 25, 26),
(16, 9, NULL, NULL, 'view', 27, 28),
(17, 8, NULL, NULL, 'Permissions', 30, 43),
(18, 17, NULL, NULL, 'index', 31, 32),
(19, 17, NULL, NULL, 'toggle', 33, 34),
(20, 17, NULL, NULL, 'view', 35, 36),
(21, 17, NULL, NULL, 'add', 37, 38),
(22, 17, NULL, NULL, 'edit', 39, 40),
(23, 17, NULL, NULL, 'delete', 41, 42),
(24, 1, NULL, NULL, 'Croogo\\Blocks', 46, 85),
(25, 24, NULL, NULL, 'Admin', 47, 76),
(26, 25, NULL, NULL, 'Blocks', 48, 63),
(27, 26, NULL, NULL, 'process', 49, 50),
(28, 26, NULL, NULL, 'toggle', 51, 52),
(29, 26, NULL, NULL, 'index', 53, 54),
(30, 26, NULL, NULL, 'view', 55, 56),
(31, 26, NULL, NULL, 'add', 57, 58),
(32, 26, NULL, NULL, 'edit', 59, 60),
(33, 26, NULL, NULL, 'delete', 61, 62),
(34, 25, NULL, NULL, 'Regions', 64, 75),
(35, 34, NULL, NULL, 'index', 65, 66),
(36, 34, NULL, NULL, 'view', 67, 68),
(37, 34, NULL, NULL, 'add', 69, 70),
(38, 34, NULL, NULL, 'edit', 71, 72),
(39, 34, NULL, NULL, 'delete', 73, 74),
(40, 24, NULL, NULL, 'Api', 77, 84),
(41, 40, NULL, NULL, 'V10', 78, 83),
(42, 41, NULL, NULL, 'Blocks', 79, 82),
(43, 42, NULL, NULL, 'index', 80, 81),
(44, 1, NULL, NULL, 'Croogo\\Contacts', 86, 119),
(45, 44, NULL, NULL, 'Contacts', 87, 90),
(46, 45, NULL, NULL, 'view', 88, 89),
(47, 44, NULL, NULL, 'Admin', 91, 118),
(48, 47, NULL, NULL, 'Contacts', 92, 103),
(49, 48, NULL, NULL, 'index', 93, 94),
(50, 48, NULL, NULL, 'view', 95, 96),
(51, 48, NULL, NULL, 'add', 97, 98),
(52, 48, NULL, NULL, 'edit', 99, 100),
(53, 48, NULL, NULL, 'delete', 101, 102),
(54, 47, NULL, NULL, 'Messages', 104, 117),
(55, 54, NULL, NULL, 'process', 105, 106),
(56, 54, NULL, NULL, 'index', 107, 108),
(57, 54, NULL, NULL, 'view', 109, 110),
(58, 54, NULL, NULL, 'add', 111, 112),
(59, 54, NULL, NULL, 'edit', 113, 114),
(60, 54, NULL, NULL, 'delete', 115, 116),
(61, 1, NULL, NULL, 'Croogo\\Core', 120, 275),
(62, 61, NULL, NULL, 'Error', 121, 122),
(63, 61, NULL, NULL, 'Admin', 123, 274),
(64, 63, NULL, NULL, 'LinkChooser', 124, 137),
(65, 64, NULL, NULL, 'linkChooser', 125, 126),
(66, 64, NULL, NULL, 'index', 127, 128),
(67, 64, NULL, NULL, 'view', 129, 130),
(68, 64, NULL, NULL, 'add', 131, 132),
(69, 64, NULL, NULL, 'edit', 133, 134),
(70, 64, NULL, NULL, 'delete', 135, 136),
(71, 1, NULL, NULL, 'Croogo\\Dashboards', 276, 301),
(72, 71, NULL, NULL, 'Admin', 277, 300),
(73, 72, NULL, NULL, 'Dashboards', 278, 299),
(74, 73, NULL, NULL, 'index', 279, 280),
(75, 73, NULL, NULL, 'dashboard', 281, 282),
(76, 73, NULL, NULL, 'save', 283, 284),
(77, 73, NULL, NULL, 'delete', 285, 286),
(78, 73, NULL, NULL, 'toggle', 287, 288),
(79, 73, NULL, NULL, 'moveup', 289, 290),
(80, 73, NULL, NULL, 'movedown', 291, 292),
(81, 73, NULL, NULL, 'view', 293, 294),
(82, 73, NULL, NULL, 'add', 295, 296),
(83, 73, NULL, NULL, 'edit', 297, 298),
(84, 1, NULL, NULL, 'Croogo\\Extensions', 302, 359),
(85, 84, NULL, NULL, 'Admin', 303, 358),
(86, 85, NULL, NULL, 'Locales', 304, 319),
(87, 86, NULL, NULL, 'index', 305, 306),
(88, 86, NULL, NULL, 'activate', 307, 308),
(89, 86, NULL, NULL, 'deactivate', 309, 310),
(90, 86, NULL, NULL, 'add', 311, 312),
(91, 86, NULL, NULL, 'edit', 313, 314),
(92, 86, NULL, NULL, 'delete', 315, 316),
(93, 86, NULL, NULL, 'view', 317, 318),
(94, 85, NULL, NULL, 'Plugins', 320, 339),
(95, 94, NULL, NULL, 'index', 321, 322),
(96, 94, NULL, NULL, 'add', 323, 324),
(97, 94, NULL, NULL, 'delete', 325, 326),
(98, 94, NULL, NULL, 'toggle', 327, 328),
(99, 94, NULL, NULL, 'migrate', 329, 330),
(100, 94, NULL, NULL, 'moveup', 331, 332),
(101, 94, NULL, NULL, 'movedown', 333, 334),
(102, 94, NULL, NULL, 'view', 335, 336),
(103, 94, NULL, NULL, 'edit', 337, 338),
(104, 85, NULL, NULL, 'Themes', 340, 357),
(105, 104, NULL, NULL, 'index', 341, 342),
(106, 104, NULL, NULL, 'activate', 343, 344),
(107, 104, NULL, NULL, 'add', 345, 346),
(108, 104, NULL, NULL, 'editor', 347, 348),
(109, 104, NULL, NULL, 'save', 349, 350),
(110, 104, NULL, NULL, 'delete', 351, 352),
(111, 104, NULL, NULL, 'view', 353, 354),
(112, 104, NULL, NULL, 'edit', 355, 356),
(113, 1, NULL, NULL, 'Croogo\\FileManager', 360, 429),
(114, 113, NULL, NULL, 'Admin', 361, 428),
(115, 114, NULL, NULL, 'AssetUsages', 362, 377),
(116, 115, NULL, NULL, 'add', 363, 364),
(117, 115, NULL, NULL, 'changeType', 365, 366),
(118, 115, NULL, NULL, 'unregister', 367, 368),
(119, 115, NULL, NULL, 'index', 369, 370),
(120, 115, NULL, NULL, 'view', 371, 372),
(121, 115, NULL, NULL, 'edit', 373, 374),
(122, 115, NULL, NULL, 'delete', 375, 376),
(123, 114, NULL, NULL, 'Attachments', 378, 397),
(124, 123, NULL, NULL, 'index', 379, 380),
(125, 123, NULL, NULL, 'add', 381, 382),
(126, 123, NULL, NULL, 'edit', 383, 384),
(127, 123, NULL, NULL, 'delete', 385, 386),
(128, 123, NULL, NULL, 'browse', 387, 388),
(129, 123, NULL, NULL, 'listing', 389, 390),
(130, 123, NULL, NULL, 'resize', 391, 392),
(131, 123, NULL, NULL, 'process', 393, 394),
(132, 123, NULL, NULL, 'view', 395, 396),
(133, 114, NULL, NULL, 'FileManager', 398, 427),
(134, 133, NULL, NULL, 'index', 399, 400),
(135, 133, NULL, NULL, 'browse', 401, 402),
(136, 133, NULL, NULL, 'editFile', 403, 404),
(137, 133, NULL, NULL, 'upload', 405, 406),
(138, 133, NULL, NULL, 'deleteFile', 407, 408),
(139, 133, NULL, NULL, 'deleteDirectory', 409, 410),
(140, 133, NULL, NULL, 'rename', 411, 412),
(141, 133, NULL, NULL, 'createDirectory', 413, 414),
(142, 133, NULL, NULL, 'createFile', 415, 416),
(143, 133, NULL, NULL, 'chmod', 417, 418),
(144, 133, NULL, NULL, 'view', 419, 420),
(145, 133, NULL, NULL, 'add', 421, 422),
(146, 133, NULL, NULL, 'edit', 423, 424),
(147, 133, NULL, NULL, 'delete', 425, 426),
(157, 1, NULL, NULL, 'Croogo\\Menus', 430, 475),
(158, 157, NULL, NULL, 'Admin', 431, 462),
(159, 158, NULL, NULL, 'Links', 432, 449),
(160, 159, NULL, NULL, 'index', 433, 434),
(161, 159, NULL, NULL, 'delete', 435, 436),
(162, 159, NULL, NULL, 'moveup', 437, 438),
(163, 159, NULL, NULL, 'movedown', 439, 440),
(164, 159, NULL, NULL, 'process', 441, 442),
(165, 159, NULL, NULL, 'view', 443, 444),
(166, 159, NULL, NULL, 'add', 445, 446),
(167, 159, NULL, NULL, 'edit', 447, 448),
(168, 158, NULL, NULL, 'Menus', 450, 461),
(169, 168, NULL, NULL, 'index', 451, 452),
(170, 168, NULL, NULL, 'view', 453, 454),
(171, 168, NULL, NULL, 'add', 455, 456),
(172, 168, NULL, NULL, 'edit', 457, 458),
(173, 168, NULL, NULL, 'delete', 459, 460),
(174, 157, NULL, NULL, 'Api', 463, 474),
(175, 174, NULL, NULL, 'V10', 464, 473),
(176, 175, NULL, NULL, 'Links', 465, 468),
(177, 176, NULL, NULL, 'index', 466, 467),
(178, 175, NULL, NULL, 'Menus', 469, 472),
(179, 178, NULL, NULL, 'index', 470, 471),
(180, 1, NULL, NULL, 'Croogo\\Meta', 476, 503),
(181, 180, NULL, NULL, 'Admin', 477, 494),
(182, 181, NULL, NULL, 'Meta', 478, 493),
(183, 182, NULL, NULL, 'deleteMeta', 479, 480),
(184, 182, NULL, NULL, 'addMeta', 481, 482),
(185, 182, NULL, NULL, 'index', 483, 484),
(186, 182, NULL, NULL, 'view', 485, 486),
(187, 182, NULL, NULL, 'add', 487, 488),
(188, 182, NULL, NULL, 'edit', 489, 490),
(189, 182, NULL, NULL, 'delete', 491, 492),
(190, 180, NULL, NULL, 'Api', 495, 502),
(191, 190, NULL, NULL, 'V10', 496, 501),
(192, 191, NULL, NULL, 'Meta', 497, 500),
(193, 192, NULL, NULL, 'index', 498, 499),
(194, 1, NULL, NULL, 'Croogo\\Nodes', 504, 555),
(195, 194, NULL, NULL, 'Nodes', 505, 518),
(196, 195, NULL, NULL, 'index', 506, 507),
(197, 195, NULL, NULL, 'term', 508, 509),
(198, 195, NULL, NULL, 'promoted', 510, 511),
(199, 195, NULL, NULL, 'feed', 512, 513),
(200, 195, NULL, NULL, 'search', 514, 515),
(201, 195, NULL, NULL, 'view', 516, 517),
(202, 194, NULL, NULL, 'Admin', 519, 544),
(203, 202, NULL, NULL, 'Nodes', 520, 543),
(204, 203, NULL, NULL, 'create', 521, 522),
(205, 203, NULL, NULL, 'updatePaths', 523, 524),
(206, 203, NULL, NULL, 'process', 525, 526),
(207, 203, NULL, NULL, 'toggle', 527, 528),
(208, 203, NULL, NULL, 'move', 529, 530),
(209, 203, NULL, NULL, 'hierarchy', 531, 532),
(210, 203, NULL, NULL, 'index', 533, 534),
(211, 203, NULL, NULL, 'view', 535, 536),
(212, 203, NULL, NULL, 'add', 537, 538),
(213, 203, NULL, NULL, 'edit', 539, 540),
(214, 203, NULL, NULL, 'delete', 541, 542),
(215, 194, NULL, NULL, 'Api', 545, 554),
(216, 215, NULL, NULL, 'V10', 546, 553),
(217, 216, NULL, NULL, 'Nodes', 547, 552),
(218, 217, NULL, NULL, 'index', 548, 549),
(219, 217, NULL, NULL, 'lookup', 550, 551),
(220, 1, NULL, NULL, 'Croogo\\Settings', 556, 605),
(221, 220, NULL, NULL, 'Admin', 557, 604),
(222, 221, NULL, NULL, 'Caches', 558, 571),
(223, 222, NULL, NULL, 'index', 559, 560),
(224, 222, NULL, NULL, 'clear', 561, 562),
(225, 222, NULL, NULL, 'view', 563, 564),
(226, 222, NULL, NULL, 'add', 565, 566),
(227, 222, NULL, NULL, 'edit', 567, 568),
(228, 222, NULL, NULL, 'delete', 569, 570),
(229, 221, NULL, NULL, 'Languages', 572, 585),
(230, 229, NULL, NULL, 'select', 573, 574),
(231, 229, NULL, NULL, 'index', 575, 576),
(232, 229, NULL, NULL, 'view', 577, 578),
(233, 229, NULL, NULL, 'add', 579, 580),
(234, 229, NULL, NULL, 'edit', 581, 582),
(235, 229, NULL, NULL, 'delete', 583, 584),
(236, 221, NULL, NULL, 'Settings', 586, 603),
(237, 236, NULL, NULL, 'prefix', 587, 588),
(238, 236, NULL, NULL, 'moveup', 589, 590),
(239, 236, NULL, NULL, 'movedown', 591, 592),
(240, 236, NULL, NULL, 'index', 593, 594),
(241, 236, NULL, NULL, 'view', 595, 596),
(242, 236, NULL, NULL, 'add', 597, 598),
(243, 236, NULL, NULL, 'edit', 599, 600),
(244, 236, NULL, NULL, 'delete', 601, 602),
(245, 1, NULL, NULL, 'Croogo\\Taxonomy', 606, 681),
(246, 245, NULL, NULL, 'Admin', 607, 660),
(247, 246, NULL, NULL, 'Taxonomies', 608, 623),
(248, 247, NULL, NULL, 'index', 609, 610),
(249, 247, NULL, NULL, 'moveUp', 611, 612),
(250, 247, NULL, NULL, 'moveDown', 613, 614),
(251, 247, NULL, NULL, 'delete', 615, 616),
(252, 247, NULL, NULL, 'view', 617, 618),
(253, 247, NULL, NULL, 'add', 619, 620),
(254, 247, NULL, NULL, 'edit', 621, 622),
(255, 246, NULL, NULL, 'Terms', 624, 635),
(256, 255, NULL, NULL, 'index', 625, 626),
(257, 255, NULL, NULL, 'delete', 627, 628),
(258, 255, NULL, NULL, 'edit', 629, 630),
(259, 255, NULL, NULL, 'add', 631, 632),
(260, 255, NULL, NULL, 'view', 633, 634),
(261, 246, NULL, NULL, 'Types', 636, 647),
(262, 261, NULL, NULL, 'index', 637, 638),
(263, 261, NULL, NULL, 'view', 639, 640),
(264, 261, NULL, NULL, 'add', 641, 642),
(265, 261, NULL, NULL, 'edit', 643, 644),
(266, 261, NULL, NULL, 'delete', 645, 646),
(267, 246, NULL, NULL, 'Vocabularies', 648, 659),
(268, 267, NULL, NULL, 'index', 649, 650),
(269, 267, NULL, NULL, 'view', 651, 652),
(270, 267, NULL, NULL, 'add', 653, 654),
(271, 267, NULL, NULL, 'edit', 655, 656),
(272, 267, NULL, NULL, 'delete', 657, 658),
(273, 245, NULL, NULL, 'Api', 661, 680),
(274, 273, NULL, NULL, 'V10', 662, 679),
(275, 274, NULL, NULL, 'Taxonomies', 663, 666),
(276, 275, NULL, NULL, 'index', 664, 665),
(277, 274, NULL, NULL, 'Terms', 667, 670),
(278, 277, NULL, NULL, 'index', 668, 669),
(279, 274, NULL, NULL, 'Types', 671, 674),
(280, 279, NULL, NULL, 'index', 672, 673),
(281, 274, NULL, NULL, 'Vocabularies', 675, 678),
(282, 281, NULL, NULL, 'index', 676, 677),
(283, 1, NULL, NULL, 'Croogo\\Users', 682, 757),
(284, 283, NULL, NULL, 'Users', 683, 702),
(285, 284, NULL, NULL, 'index', 684, 685),
(286, 284, NULL, NULL, 'add', 686, 687),
(287, 284, NULL, NULL, 'activate', 688, 689),
(288, 284, NULL, NULL, 'edit', 690, 691),
(289, 284, NULL, NULL, 'forgot', 692, 693),
(290, 284, NULL, NULL, 'reset', 694, 695),
(291, 284, NULL, NULL, 'login', 696, 697),
(292, 284, NULL, NULL, 'logout', 698, 699),
(293, 284, NULL, NULL, 'view', 700, 701),
(294, 283, NULL, NULL, 'Admin', 703, 740),
(295, 294, NULL, NULL, 'Roles', 704, 715),
(296, 295, NULL, NULL, 'index', 705, 706),
(297, 295, NULL, NULL, 'view', 707, 708),
(298, 295, NULL, NULL, 'add', 709, 710),
(299, 295, NULL, NULL, 'edit', 711, 712),
(300, 295, NULL, NULL, 'delete', 713, 714),
(301, 294, NULL, NULL, 'Users', 716, 739),
(302, 301, NULL, NULL, 'resetPassword', 717, 718),
(303, 301, NULL, NULL, 'login', 719, 720),
(304, 301, NULL, NULL, 'logout', 721, 722),
(305, 301, NULL, NULL, 'register', 723, 724),
(306, 301, NULL, NULL, 'forgot', 725, 726),
(307, 301, NULL, NULL, 'reset', 727, 728),
(308, 301, NULL, NULL, 'index', 729, 730),
(309, 301, NULL, NULL, 'view', 731, 732),
(310, 301, NULL, NULL, 'add', 733, 734),
(311, 301, NULL, NULL, 'edit', 735, 736),
(312, 301, NULL, NULL, 'delete', 737, 738),
(313, 283, NULL, NULL, 'Api', 741, 756),
(314, 313, NULL, NULL, 'V10', 742, 755),
(315, 314, NULL, NULL, 'Roles', 743, 746),
(316, 315, NULL, NULL, 'index', 744, 745),
(317, 314, NULL, NULL, 'Users', 747, 754),
(318, 317, NULL, NULL, 'lookup', 748, 749),
(319, 317, NULL, NULL, 'index', 750, 751),
(320, 317, NULL, NULL, 'token', 752, 753),
(321, 1, NULL, NULL, 'Croogo\\Wysiwyg', 758, 759),
(340, 1, NULL, NULL, 'Migrations', 760, 761),
(341, 1, NULL, NULL, 'Search', 762, 763),
(342, 63, NULL, NULL, 'Students', 138, 159),
(343, 342, NULL, NULL, 'process', 139, 140),
(344, 342, NULL, NULL, 'toggle', 141, 142),
(345, 342, NULL, NULL, 'index', 143, 144),
(346, 342, NULL, NULL, 'employee', 145, 146),
(347, 342, NULL, NULL, 'add', 147, 148),
(348, 342, NULL, NULL, 'edit', 149, 150),
(349, 342, NULL, NULL, 'delete', 151, 152),
(350, 342, NULL, NULL, 'search', 153, 154),
(351, 342, NULL, NULL, 'promote', 155, 156),
(352, 342, NULL, NULL, 'view', 157, 158),
(353, 63, NULL, NULL, 'Teachers', 160, 185),
(354, 353, NULL, NULL, 'process', 161, 162),
(355, 353, NULL, NULL, 'toggle', 163, 164),
(356, 353, NULL, NULL, 'index', 165, 166),
(357, 353, NULL, NULL, 'employee', 167, 168),
(358, 353, NULL, NULL, 'add', 169, 170),
(359, 353, NULL, NULL, 'edit', 171, 172),
(361, 353, NULL, NULL, 'delete', 173, 174),
(362, 353, NULL, NULL, 'search', 175, 176),
(363, 353, NULL, NULL, 'promote', 177, 178),
(364, 353, NULL, NULL, 'view', 179, 180),
(366, 63, NULL, NULL, 'Attandance', 186, 205),
(367, 366, NULL, NULL, 'process', 187, 188),
(368, 366, NULL, NULL, 'toggle', 189, 190),
(369, 366, NULL, NULL, 'index', 191, 192),
(370, 366, NULL, NULL, 'edit', 193, 194),
(371, 366, NULL, NULL, 'delete', 195, 196),
(372, 366, NULL, NULL, 'search', 197, 198),
(373, 366, NULL, NULL, 'promote', 199, 200),
(374, 366, NULL, NULL, 'view', 201, 202),
(375, 366, NULL, NULL, 'add', 203, 204),
(376, 63, NULL, NULL, 'Setup', 206, 273),
(377, 376, NULL, NULL, 'process', 207, 208),
(378, 376, NULL, NULL, 'toggle', 209, 210),
(379, 376, NULL, NULL, 'index', 211, 212),
(380, 376, NULL, NULL, 'edit', 213, 214),
(382, 376, NULL, NULL, 'Faculty', 215, 216),
(383, 376, NULL, NULL, 'addFaculty', 217, 218),
(384, 376, NULL, NULL, 'editFaculty', 219, 220),
(385, 376, NULL, NULL, 'Department', 221, 222),
(386, 376, NULL, NULL, 'addDepartment', 223, 224),
(387, 376, NULL, NULL, 'editDepartment', 225, 226),
(388, 376, NULL, NULL, 'Course', 227, 228),
(389, 376, NULL, NULL, 'addCourse', 229, 230),
(390, 376, NULL, NULL, 'editCourse', 231, 232),
(391, 376, NULL, NULL, 'Batch', 233, 234),
(392, 376, NULL, NULL, 'addBatch', 235, 236),
(393, 376, NULL, NULL, 'editBatch', 237, 238),
(394, 376, NULL, NULL, 'Session', 239, 240),
(395, 376, NULL, NULL, 'addSession', 241, 242),
(396, 376, NULL, NULL, 'editSession', 243, 244),
(397, 376, NULL, NULL, 'Level', 245, 246),
(398, 376, NULL, NULL, 'addLevel', 247, 248),
(399, 376, NULL, NULL, 'editLevel', 249, 250),
(400, 376, NULL, NULL, 'Shift', 251, 252),
(401, 376, NULL, NULL, 'addShift', 253, 254),
(402, 376, NULL, NULL, 'editShift', 255, 256),
(403, 376, NULL, NULL, 'Section', 257, 258),
(404, 376, NULL, NULL, 'addSection', 259, 260),
(405, 376, NULL, NULL, 'editSection', 261, 262),
(406, 376, NULL, NULL, 'assignCourses', 263, 264),
(407, 376, NULL, NULL, 'assignCoursesAdd', 265, 266),
(408, 376, NULL, NULL, 'view', 267, 268),
(409, 376, NULL, NULL, 'add', 269, 270),
(410, 376, NULL, NULL, 'delete', 271, 272),
(411, 353, NULL, NULL, 'assignTeacher', 181, 182),
(412, 353, NULL, NULL, 'assignTeacherAdd', 183, 184);

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE `aros` (
  `id` int(11) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Roles', 1, 'Role-superadmin', 1, 4),
(2, NULL, 'Roles', 2, 'Role-public', 5, 266),
(3, 2, 'Roles', 3, 'Role-registered', 6, 7),
(4, 2, 'Roles', 4, 'Role-admin', 8, 261),
(5, 4, 'Roles', 5, 'Role-publisher', 9, 10),
(6, 1, 'Users', 1, 'shihab', 2, 3),
(7, 4, 'Roles', 6, 'Role-teacher', 11, 254),
(8, 7, 'Users', 2, 'akash', 12, 13),
(9, 7, 'Users', 3, 'shovon', 14, 15),
(10, 7, 'Users', 4, 'shovon1', 16, 17),
(11, 7, 'Users', 5, '1111', 18, 19),
(12, 7, 'Users', 6, 'shovon', 20, 21),
(13, 7, 'Users', 7, 'MomenulHaque', 22, 23),
(14, 7, 'Users', 8, 'nadirhossion', 24, 25),
(15, 7, 'Users', 9, 'gghyy', 26, 27),
(18, 7, 'Users', 12, 'MdMomenulHaque', 28, 29),
(19, 7, 'Users', 13, 'ShibeshSarker', 30, 31),
(20, 7, 'Users', 14, 'KantaRoyRimi', 32, 33),
(21, 7, 'Users', 15, 'AFMNurullah', 34, 35),
(22, 7, 'Users', 16, 'JogendraNathSarker', 36, 37),
(23, 7, 'Users', 17, 'MdAbdusSalam', 38, 39),
(24, 7, 'Users', 18, 'DrMdNuruzzaman', 40, 41),
(25, 7, 'Users', 19, 'MdHabibulHaqueChowdury', 42, 43),
(26, 7, 'Users', 20, 'MuhammadWalyAhad', 44, 45),
(27, 7, 'Users', 21, 'PallabKumarDas', 46, 47),
(28, 7, 'Users', 22, 'ShamimaYasmin', 48, 49),
(29, 7, 'Users', 23, 'MdAtiarRahman', 50, 51),
(30, 7, 'Users', 24, 'MdNurulIslam', 52, 53),
(31, 7, 'Users', 25, 'MdMashiurRahman', 54, 55),
(32, 7, 'Users', 26, 'ShahabAhmed', 56, 57),
(33, 7, 'Users', 27, 'MdSarawarulIslam', 58, 59),
(34, 7, 'Users', 28, 'DrMdAynulIslam', 60, 61),
(35, 7, 'Users', 29, 'MdZillurRahamanSiddique', 62, 63),
(36, 7, 'Users', 30, 'MohdAminulIslam', 64, 65),
(37, 7, 'Users', 31, 'MdAbdulKader', 66, 67),
(38, 7, 'Users', 32, 'MdShamiulHossain', 68, 69),
(39, 7, 'Users', 33, 'MesbahUddinNoman', 70, 71),
(40, 7, 'Users', 34, 'MdAsaduzzaman', 72, 73),
(41, 7, 'Users', 35, 'MdSarwarMurshedAlam', 74, 75),
(42, 7, 'Users', 36, 'TapasKumarPaul', 76, 77),
(43, 7, 'Users', 37, 'NibeditaPaul', 78, 79),
(44, 7, 'Users', 38, 'ZeenatRehana', 80, 81),
(45, 7, 'Users', 39, 'MdFazlaElahi', 82, 83),
(46, 7, 'Users', 40, 'NureJannatFerdousiAra', 84, 85),
(47, 7, 'Users', 41, 'SheikhFaridAhmed', 86, 87),
(48, 7, 'Users', 42, 'MdManjurulIslam', 88, 89),
(49, 7, 'Users', 43, 'MohammadObaidulIslam', 90, 91),
(50, 7, 'Users', 44, 'MostIsratJahan', 92, 93),
(51, 7, 'Users', 45, 'LailaFardaus', 94, 95),
(52, 7, 'Users', 46, 'NazninSultana', 96, 97),
(53, 7, 'Users', 47, 'MstMerinaAkter', 98, 99),
(54, 7, 'Users', 48, 'marmc037', 100, 101),
(55, 7, 'Users', 49, 'marmc038', 102, 103),
(56, 7, 'Users', 50, 'marmc039', 104, 105),
(57, 7, 'Users', 51, 'marmc040', 106, 107),
(58, 7, 'Users', 52, 'marmc041', 108, 109),
(59, 7, 'Users', 53, 'marmc042', 110, 111),
(60, 7, 'Users', 54, 'marmc043', 112, 113),
(61, 7, 'Users', 55, 'marmc044', 114, 115),
(62, 7, 'Users', 56, 'marmc045', 116, 117),
(63, 7, 'Users', 57, 'marmc046', 118, 119),
(64, 7, 'Users', 58, 'marmc047', 120, 121),
(65, 7, 'Users', 59, 'marmc048', 122, 123),
(66, 7, 'Users', 60, 'marmc049', 124, 125),
(67, 7, 'Users', 61, 'marmc050', 126, 127),
(68, 7, 'Users', 62, 'marmc051', 128, 129),
(69, 7, 'Users', 63, 'marmc052', 130, 131),
(70, 7, 'Users', 64, 'marmc053', 132, 133),
(71, 7, 'Users', 65, 'marmc054', 134, 135),
(72, 7, 'Users', 66, 'marmc055', 136, 137),
(73, 7, 'Users', 67, 'marmc056', 138, 139),
(74, 7, 'Users', 68, 'marmc057', 140, 141),
(75, 7, 'Users', 69, 'marmc058', 142, 143),
(76, 7, 'Users', 70, 'marmc059', 144, 145),
(77, 7, 'Users', 71, 'marmc060', 146, 147),
(78, 7, 'Users', 72, 'marmc061', 148, 149),
(79, 7, 'Users', 73, 'marmc062', 150, 151),
(80, 7, 'Users', 74, 'marmc063', 152, 153),
(81, 7, 'Users', 75, 'marmc064', 154, 155),
(82, 7, 'Users', 76, 'marmc065', 156, 157),
(83, 7, 'Users', 77, 'marmc066', 158, 159),
(84, 7, 'Users', 78, 'marmc067', 160, 161),
(85, 7, 'Users', 79, 'marmc068', 162, 163),
(86, 7, 'Users', 80, 'marmc069', 164, 165),
(87, 7, 'Users', 81, 'marmc070', 166, 167),
(88, 7, 'Users', 82, 'marmc071', 168, 169),
(89, 7, 'Users', 83, 'marmc072', 170, 171),
(90, 7, 'Users', 84, 'marmc073', 172, 173),
(91, 7, 'Users', 85, 'marmc074', 174, 175),
(92, 7, 'Users', 86, 'marmc075', 176, 177),
(93, 7, 'Users', 87, 'marmc076', 178, 179),
(94, 7, 'Users', 88, 'marmc077', 180, 181),
(95, 7, 'Users', 89, 'marmc078', 182, 183),
(96, 7, 'Users', 90, 'marmc079', 184, 185),
(97, 7, 'Users', 91, 'marmc080', 186, 187),
(98, 7, 'Users', 92, 'marmc081', 188, 189),
(99, 7, 'Users', 93, 'marmc082', 190, 191),
(100, 7, 'Users', 94, 'marmc083', 192, 193),
(101, 7, 'Users', 95, 'marmc084', 194, 195),
(102, 7, 'Users', 96, 'marmc085', 196, 197),
(103, 7, 'Users', 97, 'marmc086', 198, 199),
(104, 7, 'Users', 98, 'marmc087', 200, 201),
(105, 7, 'Users', 99, 'marmc088', 202, 203),
(106, 7, 'Users', 100, 'marmc089', 204, 205),
(107, 7, 'Users', 101, 'marmc090', 206, 207),
(108, 7, 'Users', 102, 'marmc091', 208, 209),
(109, 7, 'Users', 103, 'marmc092', 210, 211),
(110, 7, 'Users', 104, 'marmc093', 212, 213),
(111, 7, 'Users', 105, 'marmc094', 214, 215),
(112, 7, 'Users', 106, 'marmc095', 216, 217),
(113, 7, 'Users', 107, 'marmc096', 218, 219),
(114, 7, 'Users', 108, 'marmc097', 220, 221),
(115, 7, 'Users', 109, 'marmc098', 222, 223),
(116, 2, 'Roles', 7, 'Role-staffs', 262, 265),
(117, 7, 'Users', 110, 'marmc099', 224, 225),
(118, 116, 'Users', 111, 'Mohim', 263, 264),
(119, 7, 'Users', 112, 'marmc100', 226, 227),
(120, 7, 'Users', 113, 'marmc101', 228, 229),
(121, 7, 'Users', 114, 'marmc102', 230, 231),
(122, 7, 'Users', 115, 'marmc103', 232, 233),
(123, 7, 'Users', 116, 'marmc104', 234, 235),
(124, 7, 'Users', 117, 'marmc105', 236, 237),
(125, 7, 'Users', 118, 'marmc106', 238, 239),
(126, 7, 'Users', 119, 'marmc107', 240, 241),
(127, 7, 'Users', 120, 'marmc108', 242, 243),
(128, 7, 'Users', 121, 'marmc109', 244, 245),
(129, 7, 'Users', 122, 'marmc110', 246, 247),
(130, 7, 'Users', 123, 'marmc111', 248, 249),
(131, 7, 'Users', 124, 'marmc112', 250, 251),
(132, 7, 'Users', 125, 'marmc113', 252, 253),
(137, 4, 'Users', 6, 'kamrul', 255, 256),
(138, 4, 'Users', 7, 'akash', 257, 258),
(139, 4, 'Users', 8, 'shovon', 259, 260);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE `aros_acos` (
  `id` int(11) NOT NULL,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 2, 46, '1', '1', '1', '1'),
(2, 2, 196, '1', '1', '1', '1'),
(3, 2, 199, '1', '1', '1', '1'),
(4, 2, 197, '1', '1', '1', '1'),
(5, 2, 198, '1', '1', '1', '1'),
(6, 2, 200, '1', '1', '1', '1'),
(7, 2, 201, '1', '1', '1', '1'),
(8, 3, 285, '1', '1', '1', '1'),
(9, 2, 286, '1', '1', '1', '1'),
(10, 2, 287, '1', '1', '1', '1'),
(11, 3, 288, '1', '1', '1', '1'),
(12, 2, 289, '1', '1', '1', '1'),
(13, 2, 290, '1', '1', '1', '1'),
(14, 2, 291, '1', '1', '1', '1'),
(15, 2, 292, '1', '1', '1', '1'),
(16, 3, 292, '1', '1', '1', '1'),
(17, 2, 304, '1', '1', '1', '1'),
(18, 3, 304, '1', '1', '1', '1'),
(19, 3, 293, '1', '1', '1', '1'),
(20, 4, 73, '1', '1', '1', '1'),
(21, 5, 203, '1', '1', '1', '1'),
(22, 5, 168, '1', '1', '1', '1'),
(23, 5, 159, '1', '1', '1', '1'),
(24, 5, 26, '1', '1', '1', '1'),
(25, 5, 123, '1', '1', '1', '1'),
(26, 5, 133, '1', '1', '1', '1'),
(27, 5, 48, '1', '1', '1', '1'),
(28, 5, 54, '1', '1', '1', '1'),
(29, 4, 309, '1', '1', '1', '1'),
(31, 7, 354, '-1', '-1', '-1', '-1'),
(32, 7, 355, '-1', '-1', '-1', '-1'),
(33, 7, 356, '1', '1', '1', '1'),
(34, 7, 357, '-1', '-1', '-1', '-1'),
(35, 7, 358, '1', '1', '1', '1'),
(36, 7, 359, '-1', '-1', '-1', '-1'),
(37, 7, 361, '-1', '-1', '-1', '-1'),
(38, 7, 362, '1', '1', '1', '1'),
(39, 7, 363, '-1', '-1', '-1', '-1'),
(40, 7, 364, '1', '1', '1', '1'),
(41, 7, 369, '1', '1', '1', '1'),
(42, 7, 374, '1', '1', '1', '1'),
(44, 7, 375, '1', '1', '1', '1'),
(45, 7, 372, '1', '1', '1', '1'),
(46, 7, 373, '1', '1', '1', '1'),
(47, 7, 371, '1', '1', '1', '1'),
(48, 7, 368, '1', '1', '1', '1'),
(49, 7, 367, '1', '1', '1', '1'),
(50, 7, 370, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `parent_asset_id` int(11) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `model` varchar(64) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `mime_type` varchar(32) DEFAULT NULL,
  `extension` varchar(5) DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `adapter` varchar(32) DEFAULT NULL COMMENT 'Gaufrette Storage Adapter Class',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asset_usages`
--

CREATE TABLE `asset_usages` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `model` varchar(64) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `params` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `sticky` tinyint(1) NOT NULL DEFAULT 0,
  `visibility_roles` text DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `plugin` varchar(255) DEFAULT NULL,
  `import_path` varchar(512) DEFAULT NULL,
  `asset_count` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `region_id` int(20) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `body` text NOT NULL,
  `show_title` tinyint(1) NOT NULL DEFAULT 1,
  `class` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `element` varchar(255) DEFAULT NULL,
  `visibility_roles` text DEFAULT NULL,
  `visibility_paths` text DEFAULT NULL,
  `visibility_php` text DEFAULT NULL,
  `params` text DEFAULT NULL,
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `region_id`, `title`, `alias`, `body`, `show_title`, `class`, `status`, `weight`, `element`, `visibility_roles`, `visibility_paths`, `visibility_php`, `params`, `publish_start`, `publish_end`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(3, 4, 'About', 'about', 'This is the content of your block. Can be modified in admin panel.', 1, '', 1, 2, '', '', '', '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(5, 4, 'Meta', 'meta', '[menu:meta]', 1, '', 1, 6, '', '', '', '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(6, 4, 'Blogroll', 'blogroll', '[menu:blogroll]', 1, '', 1, 4, '', '', '', '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(7, 4, 'Categories', 'categories', '[vocabulary:categories type=\"blog\"]', 1, '', 1, 3, '', '', '', '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(8, 4, 'Search', 'search', '', 0, '', 1, 1, 'Croogo/Nodes.search', '', '', '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(9, 4, 'Recent Posts', 'recent_posts', '[node:recent_posts order=\"Nodes.id DESC\" limit=\"5\"]', 1, '', 1, 5, '', '', '', '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(20) DEFAULT NULL,
  `model` varchar(50) NOT NULL DEFAULT 'Node',
  `foreign_key` int(20) NOT NULL,
  `user_id` int(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `notify` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(100) NOT NULL,
  `comment_type` varchar(100) NOT NULL DEFAULT 'comment',
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `model`, `foreign_key`, `user_id`, `name`, `email`, `website`, `ip`, `title`, `body`, `rating`, `status`, `notify`, `type`, `comment_type`, `lft`, `rght`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, NULL, 'Croogo/Nodes.Nodes', 1, NULL, 'Mr Croogo', 'email@example.com', 'http://www.croogo.org', '127.0.0.1', '', 'Hi, this is the first comment.', NULL, 1, 0, 'blog', 'comment', 1, 2, '2022-08-23 06:11:21', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message_status` tinyint(1) NOT NULL DEFAULT 1,
  `message_archive` tinyint(1) NOT NULL DEFAULT 1,
  `message_count` int(11) NOT NULL DEFAULT 0,
  `message_spam_protection` tinyint(1) NOT NULL DEFAULT 0,
  `message_captcha` tinyint(1) NOT NULL DEFAULT 0,
  `message_notify` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `title`, `alias`, `body`, `name`, `position`, `address`, `address2`, `state`, `country`, `postcode`, `phone`, `fax`, `email`, `message_status`, `message_archive`, `message_count`, `message_spam_protection`, `message_captcha`, `message_notify`, `status`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Contact', 'contact', '', '', '', '', '', '', '', '', '', '', 'you@your-site.com', 1, 0, 0, 0, 0, 1, 1, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_acl_phinxlog`
--

CREATE TABLE `croogo_acl_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_acl_phinxlog`
--

INSERT INTO `croogo_acl_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807104926, 'AclInitialMigration', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_blocks_phinxlog`
--

CREATE TABLE `croogo_blocks_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_blocks_phinxlog`
--

INSERT INTO `croogo_blocks_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807104952, 'BlocksInitialMigration', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0),
(20171210054951, 'BlocksAddForeignKeys', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0),
(20191120012124, 'BlocksSyncTimestampFields', '2022-08-23 00:11:18', '2022-08-23 00:11:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_ckeditor_phinxlog`
--

CREATE TABLE `croogo_ckeditor_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `croogo_comments_phinxlog`
--

CREATE TABLE `croogo_comments_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_comments_phinxlog`
--

INSERT INTO `croogo_comments_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105013, 'CommentsInitialMigration', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20171218081825, 'CommentsAddForeignKeys', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20191120012457, 'CommentsSyncTimestampFields', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_contacts_phinxlog`
--

CREATE TABLE `croogo_contacts_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_contacts_phinxlog`
--

INSERT INTO `croogo_contacts_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105032, 'ContactsInitialMigration', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20171218082143, 'ContactsAddForeignKeys', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20191120012527, 'ContactsSyncTimestampFields', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_dashboards_phinxlog`
--

CREATE TABLE `croogo_dashboards_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_dashboards_phinxlog`
--

INSERT INTO `croogo_dashboards_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105058, 'DashboardsInitialMigration', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20171218082515, 'DashboardsAddForeignKeys', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20191120012626, 'DashboardsSyncTimestampFields', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_extensions_phinxlog`
--

CREATE TABLE `croogo_extensions_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `croogo_file_manager_phinxlog`
--

CREATE TABLE `croogo_file_manager_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_file_manager_phinxlog`
--

INSERT INTO `croogo_file_manager_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20191115050000, 'FileManagerInitialMigration', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0),
(20191120012700, 'FileManagerSyncTimestampFields', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_menus_phinxlog`
--

CREATE TABLE `croogo_menus_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_menus_phinxlog`
--

INSERT INTO `croogo_menus_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105149, 'MenusInitialMigration', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20160807131950, 'UpgradeMenus', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20171218082635, 'MenusAddForeignKeys', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0),
(20191120012729, 'MenusSyncTimestampFields', '2022-08-23 00:11:20', '2022-08-23 00:11:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_meta_phinxlog`
--

CREATE TABLE `croogo_meta_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_meta_phinxlog`
--

INSERT INTO `croogo_meta_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105202, 'MetaInitialMigration', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0),
(20191120012807, 'MetaSyncTimestampFields', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_nodes_phinxlog`
--

CREATE TABLE `croogo_nodes_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_nodes_phinxlog`
--

INSERT INTO `croogo_nodes_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105214, 'NodesInitialMigration', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0),
(20171210054111, 'NodesAddForeignKeys', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0),
(20191120012834, 'NodesSyncTimestampFields', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_settings_phinxlog`
--

CREATE TABLE `croogo_settings_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_settings_phinxlog`
--

INSERT INTO `croogo_settings_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105227, 'SettingsInitialMigration', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0),
(20171206045454, 'EnlargeLanguagesFields', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0),
(20191120012902, 'SettingsSyncTimestampFields', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_taxonomy_phinxlog`
--

CREATE TABLE `croogo_taxonomy_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_taxonomy_phinxlog`
--

INSERT INTO `croogo_taxonomy_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105245, 'TaxonomyInitialMigration', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0),
(20171218083005, 'TaxonomyAddForeignKeys', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0),
(20191120012924, 'TaxonomySyncTimestampFields', '2022-08-23 00:11:19', '2022-08-23 00:11:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_users_phinxlog`
--

CREATE TABLE `croogo_users_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `croogo_users_phinxlog`
--

INSERT INTO `croogo_users_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20160807105314, 'UsersInitialMigration', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0),
(20171210044550, 'UsersAddForeignKeys', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0),
(20191120014021, 'UsersSyncTimestampFields', '2022-08-23 00:11:18', '2022-08-23 00:11:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `croogo_wysiwyg_phinxlog`
--

CREATE TABLE `croogo_wysiwyg_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dashboards`
--

CREATE TABLE `dashboards` (
  `id` int(11) NOT NULL,
  `alias` varchar(50) NOT NULL DEFAULT '',
  `user_id` int(20) NOT NULL DEFAULT 0,
  `column` int(20) NOT NULL DEFAULT 0,
  `weight` int(20) NOT NULL DEFAULT 0,
  `collapsed` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dashboards`
--

INSERT INTO `dashboards` (`id`, `alias`, `user_id`, `column`, `weight`, `collapsed`, `status`, `created`, `modified`) VALUES
(1, 'dashboards-blogfeed', 1, 1, 0, 1, 1, '2022-08-30 08:19:52', '2022-09-12 05:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `employees_designation_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `user_id`, `shift_id`, `employees_designation_id`, `image_name`) VALUES
(1, 1, 1, NULL, '1664272518_588471.jpg'),
(3, 7, 1, 3, '1664194683_789877.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `employees_designation`
--

CREATE TABLE `employees_designation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees_designation`
--

INSERT INTO `employees_designation` (`id`, `name`, `created_date`) VALUES
(1, 'Manager', '2022-04-04 10:17:48'),
(3, 'Software Developer', '2022-09-26 07:49:29'),
(4, 'Support', '2022-09-27 06:39:03'),
(5, 'Hardware Support', '2022-09-27 09:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance`
--

CREATE TABLE `employee_attendance` (
  `employee_attendance_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `in_time` varchar(20) DEFAULT NULL,
  `out_time` varchar(20) DEFAULT NULL,
  `break_out_time` varchar(99) DEFAULT NULL,
  `break_in_time` varchar(99) DEFAULT NULL,
  `minute_late` int(11) NOT NULL DEFAULT 0,
  `status` varchar(11) NOT NULL,
  `total_in` int(11) DEFAULT NULL,
  `total_out` int(11) DEFAULT NULL,
  `overtime_hours` decimal(23,10) DEFAULT NULL,
  `overtime_amount` decimal(23,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_attendance`
--

INSERT INTO `employee_attendance` (`employee_attendance_id`, `employee_id`, `user_id`, `date`, `in_time`, `out_time`, `break_out_time`, `break_in_time`, `minute_late`, `status`, `total_in`, `total_out`, `overtime_hours`, `overtime_amount`) VALUES
(1, 1, 1, '2022-09-25', '11:00', '16:00', NULL, NULL, 60, 'out', 1, 1, '2.0000000000', '600.0000000000'),
(2, 3, 7, '2022-09-25', '10:30', '16:00', NULL, NULL, 30, 'out', 1, 1, '4.0000000000', '1200.0000000000'),
(6, NULL, 8, '2022-09-25', '11:30', '17:00', NULL, NULL, 30, 'out', 1, 1, NULL, NULL),
(7, 1, 1, '2022-10-08', '10:00', '16:00', NULL, NULL, 0, 'out', 1, 1, NULL, NULL),
(8, 3, 7, '2022-10-08', '10:00', '16:00', NULL, NULL, 0, 'out', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance_count`
--

CREATE TABLE `employee_attendance_count` (
  `employee_attendance_count_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(99) NOT NULL,
  `time` time NOT NULL,
  `type` varchar(20) NOT NULL,
  `attendance_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_attendance_count`
--

INSERT INTO `employee_attendance_count` (`employee_attendance_count_id`, `employee_id`, `user_id`, `date`, `time`, `type`, `attendance_type`) VALUES
(1, 1, 1, '2022-09-25', '16:00:00', 'out', 'admin'),
(2, 3, 7, '2022-09-25', '16:00:00', 'out', 'admin'),
(3, NULL, 8, '2022-09-25', '17:00:00', 'out', 'admin'),
(4, 1, 1, '2022-09-25', '11:00:00', 'in', 'admin'),
(5, 3, 7, '2022-09-25', '10:30:00', 'in', 'admin'),
(6, NULL, 8, '2022-09-25', '11:30:00', 'in', 'admin'),
(7, 1, 1, '2022-10-08', '10:00:00', 'in', 'admin'),
(8, 1, 1, '2022-10-08', '16:00:00', 'out', 'admin'),
(9, 3, 7, '2022-10-08', '10:00:00', 'in', 'admin'),
(10, 3, 7, '2022-10-08', '16:00:00', 'out', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `hr_config`
--

CREATE TABLE `hr_config` (
  `config_id` int(11) NOT NULL,
  `config_name` varchar(255) NOT NULL,
  `config_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr_config`
--

INSERT INTO `hr_config` (`config_id`, `config_name`, `config_key`) VALUES
(1, 'Basic Salary', 'basic_salary'),
(2, 'Allowances', 'allowances'),
(3, 'Casual Leave', 'casual_leave'),
(4, 'Sick Leave', 'sick_leave'),
(5, 'Bonus', 'bonus'),
(6, 'Penalty', 'penalty');

-- --------------------------------------------------------

--
-- Table structure for table `hr_config_action`
--

CREATE TABLE `hr_config_action` (
  `config_action_id` int(11) NOT NULL,
  `config_action_name` varchar(255) NOT NULL,
  `config_key` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr_config_action`
--

INSERT INTO `hr_config_action` (`config_action_id`, `config_action_name`, `config_key`, `deleted`) VALUES
(1, 'Basic salary', 'basic_salary', 0),
(2, 'TA & TD', 'allowances', 0),
(3, 'Casual Leave', 'casual_leave', 0),
(4, 'Sick Leave', 'sick_leave', 0),
(5, 'Rent Allowance', 'allowances', 0),
(6, 'Medical', 'allowances', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hr_config_action_setup`
--

CREATE TABLE `hr_config_action_setup` (
  `config_action_setup_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `config_action_id` int(11) NOT NULL,
  `value` varchar(99) NOT NULL,
  `year` int(10) NOT NULL,
  `months` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr_config_action_setup`
--

INSERT INTO `hr_config_action_setup` (`config_action_setup_id`, `user_id`, `config_action_id`, `value`, `year`, `months`, `deleted`) VALUES
(1, 1, 1, '10000', 2022, '[\"September\",\"October\",\"November\",\"December\"]', 0),
(2, 1, 2, '2000', 2022, '[\"September\",\"October\",\"November\",\"December\"]', 0),
(3, 1, 5, '3000', 2022, '[\"September\",\"October\",\"November\",\"December\"]', 0),
(4, 1, 6, '1000', 2022, '[\"September\",\"October\",\"November\",\"December\"]', 0),
(5, 1, 4, '13.5', 2022, NULL, 0),
(6, 1, 3, '13.5', 2022, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hr_events`
--

CREATE TABLE `hr_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` varchar(255) NOT NULL,
  `end_event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hr_events`
--

INSERT INTO `hr_events` (`id`, `title`, `start_event`, `end_event`) VALUES
(1, 'General Leave', '2022-06-03', '2022-06-04'),
(2, 'General Leave', '2022-06-10', '2022-06-11'),
(3, 'General Leave', '2022-06-17', '2022-06-18'),
(4, 'General Leave', '2022-06-24', '2022-06-25'),
(5, 'General Leave', '2022-07-01', '2022-07-02'),
(6, 'General Leave', '2022-07-08', '2022-07-09'),
(7, 'General Leave for Sakhawat Sir Dead', '2022-06-11', '2022-06-12'),
(11, 'leave', '2022-08-29', '2022-08-30');

-- --------------------------------------------------------

--
-- Table structure for table `hr_leaves`
--

CREATE TABLE `hr_leaves` (
  `leave_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `config_action_setup_id` int(11) NOT NULL,
  `date_from` varchar(99) NOT NULL,
  `half_leave` int(1) DEFAULT NULL,
  `half_leave_type` varchar(255) DEFAULT NULL,
  `date_to` varchar(99) DEFAULT NULL,
  `count` varchar(99) NOT NULL,
  `submit_date` varchar(99) NOT NULL,
  `body` text DEFAULT NULL,
  `approval` varchar(99) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` varchar(99) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hr_shift`
--

CREATE TABLE `hr_shift` (
  `shift_id` int(111) NOT NULL,
  `shift_name` varchar(255) NOT NULL,
  `monday_in_time` varchar(222) DEFAULT NULL,
  `monday_out_time` varchar(222) DEFAULT NULL,
  `tuesday_in_time` varchar(222) DEFAULT NULL,
  `tuesday_out_time` varchar(222) DEFAULT NULL,
  `wednesday_in_time` varchar(222) DEFAULT NULL,
  `wednesday_out_time` varchar(222) DEFAULT NULL,
  `thursday_in_time` varchar(222) DEFAULT NULL,
  `thursday_out_time` varchar(222) DEFAULT NULL,
  `friday_in_time` varchar(222) DEFAULT NULL,
  `friday_out_time` varchar(222) DEFAULT NULL,
  `saturday_in_time` varchar(222) DEFAULT NULL,
  `saturday_out_time` varchar(222) DEFAULT NULL,
  `sunday_in_time` varchar(222) DEFAULT NULL,
  `sunday_out_time` varchar(222) DEFAULT NULL,
  `break_out_time` varchar(222) DEFAULT NULL,
  `break_in_time` varchar(222) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hr_shift`
--

INSERT INTO `hr_shift` (`shift_id`, `shift_name`, `monday_in_time`, `monday_out_time`, `tuesday_in_time`, `tuesday_out_time`, `wednesday_in_time`, `wednesday_out_time`, `thursday_in_time`, `thursday_out_time`, `friday_in_time`, `friday_out_time`, `saturday_in_time`, `saturday_out_time`, `sunday_in_time`, `sunday_out_time`, `break_out_time`, `break_in_time`, `created_at`) VALUES
(1, 'Day', '10:00', '16:00', '10:00', '16:00', '10:00', '16:00', '10:00', '16:00', '', '', '10:00', '16:00', '10:00', '16:00', '', '', '2022-09-21 11:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `native` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `locale` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `weight` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `title`, `native`, `alias`, `locale`, `status`, `weight`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Afrikaans', '', 'af', 'af', 0, 1, '2022-08-23 06:11:21', NULL, 1, NULL),
(2, 'Afrikaans (Namibia)', 'Namibië', 'af', 'af_NA', 0, 2, '2022-08-23 06:11:21', NULL, 1, NULL),
(3, 'Afrikaans (South Africa)', 'Suid-Afrika', 'af', 'af_ZA', 0, 3, '2022-08-23 06:11:21', NULL, 1, NULL),
(4, 'Aghem', '', 'agq', 'agq', 0, 4, '2022-08-23 06:11:21', NULL, 1, NULL),
(5, 'Aghem (Cameroon)', 'Kàmàlûŋ', 'agq', 'agq_CM', 0, 5, '2022-08-23 06:11:21', NULL, 1, NULL),
(6, 'Akan', '', 'ak', 'ak', 0, 6, '2022-08-23 06:11:21', NULL, 1, NULL),
(7, 'Akan (Ghana)', 'Gaana', 'ak', 'ak_GH', 0, 7, '2022-08-23 06:11:21', NULL, 1, NULL),
(8, 'Amharic', '', 'am', 'am', 0, 8, '2022-08-23 06:11:21', NULL, 1, NULL),
(9, 'Amharic (Ethiopia)', 'ኢትዮጵያ', 'am', 'am_ET', 0, 9, '2022-08-23 06:11:21', NULL, 1, NULL),
(10, 'Arabic', '', 'ar', 'ar', 1, 10, '2022-08-23 06:11:21', NULL, 1, NULL),
(11, 'Arabic (World)', 'العالم', 'ar', 'ar_001', 0, 11, '2022-08-23 06:11:21', NULL, 1, NULL),
(12, 'Arabic (United Arab Emirates)', 'الإمارات العربية المتحدة', 'ar', 'ar_AE', 0, 12, '2022-08-23 06:11:21', NULL, 1, NULL),
(13, 'Arabic (Bahrain)', 'البحرين', 'ar', 'ar_BH', 0, 13, '2022-08-23 06:11:21', NULL, 1, NULL),
(14, 'Arabic (Djibouti)', 'جيبوتي', 'ar', 'ar_DJ', 0, 14, '2022-08-23 06:11:21', NULL, 1, NULL),
(15, 'Arabic (Algeria)', 'الجزائر', 'ar', 'ar_DZ', 0, 15, '2022-08-23 06:11:21', NULL, 1, NULL),
(16, 'Arabic (Egypt)', 'مصر', 'ar', 'ar_EG', 0, 16, '2022-08-23 06:11:21', NULL, 1, NULL),
(17, 'Arabic (Western Sahara)', 'الصحراء الغربية', 'ar', 'ar_EH', 0, 17, '2022-08-23 06:11:21', NULL, 1, NULL),
(18, 'Arabic (Eritrea)', 'إريتريا', 'ar', 'ar_ER', 0, 18, '2022-08-23 06:11:21', NULL, 1, NULL),
(19, 'Arabic (Israel)', 'إسرائيل', 'ar', 'ar_IL', 0, 19, '2022-08-23 06:11:21', NULL, 1, NULL),
(20, 'Arabic (Iraq)', 'العراق', 'ar', 'ar_IQ', 0, 20, '2022-08-23 06:11:21', NULL, 1, NULL),
(21, 'Arabic (Jordan)', 'الأردن', 'ar', 'ar_JO', 0, 21, '2022-08-23 06:11:21', NULL, 1, NULL),
(22, 'Arabic (Comoros)', 'جزر القمر', 'ar', 'ar_KM', 0, 22, '2022-08-23 06:11:21', NULL, 1, NULL),
(23, 'Arabic (Kuwait)', 'الكويت', 'ar', 'ar_KW', 0, 23, '2022-08-23 06:11:21', NULL, 1, NULL),
(24, 'Arabic (Lebanon)', 'لبنان', 'ar', 'ar_LB', 0, 24, '2022-08-23 06:11:21', NULL, 1, NULL),
(25, 'Arabic (Libya)', 'ليبيا', 'ar', 'ar_LY', 0, 25, '2022-08-23 06:11:21', NULL, 1, NULL),
(26, 'Arabic (Morocco)', 'المغرب', 'ar', 'ar_MA', 0, 26, '2022-08-23 06:11:21', NULL, 1, NULL),
(27, 'Arabic (Mauritania)', 'موريتانيا', 'ar', 'ar_MR', 0, 27, '2022-08-23 06:11:21', NULL, 1, NULL),
(28, 'Arabic (Oman)', 'عُمان', 'ar', 'ar_OM', 0, 28, '2022-08-23 06:11:21', NULL, 1, NULL),
(29, 'Arabic (Palestinian Territories)', 'الأراضي الفلسطينية', 'ar', 'ar_PS', 0, 29, '2022-08-23 06:11:21', NULL, 1, NULL),
(30, 'Arabic (Qatar)', 'قطر', 'ar', 'ar_QA', 0, 30, '2022-08-23 06:11:21', NULL, 1, NULL),
(31, 'Arabic (Saudi Arabia)', 'المملكة العربية السعودية', 'ar', 'ar_SA', 0, 31, '2022-08-23 06:11:21', NULL, 1, NULL),
(32, 'Arabic (Sudan)', 'السودان', 'ar', 'ar_SD', 0, 32, '2022-08-23 06:11:21', NULL, 1, NULL),
(33, 'Arabic (Somalia)', 'الصومال', 'ar', 'ar_SO', 0, 33, '2022-08-23 06:11:21', NULL, 1, NULL),
(34, 'Arabic (South Sudan)', 'جنوب السودان', 'ar', 'ar_SS', 0, 34, '2022-08-23 06:11:21', NULL, 1, NULL),
(35, 'Arabic (Syria)', 'سوريا', 'ar', 'ar_SY', 0, 35, '2022-08-23 06:11:21', NULL, 1, NULL),
(36, 'Arabic (Chad)', 'تشاد', 'ar', 'ar_TD', 0, 36, '2022-08-23 06:11:21', NULL, 1, NULL),
(37, 'Arabic (Tunisia)', 'تونس', 'ar', 'ar_TN', 0, 37, '2022-08-23 06:11:21', NULL, 1, NULL),
(38, 'Arabic (Yemen)', 'اليمن', 'ar', 'ar_YE', 0, 38, '2022-08-23 06:11:21', NULL, 1, NULL),
(39, 'Assamese', '', 'as', 'as', 0, 39, '2022-08-23 06:11:21', NULL, 1, NULL),
(40, 'Assamese (India)', 'ভাৰত', 'as', 'as_IN', 0, 40, '2022-08-23 06:11:21', NULL, 1, NULL),
(41, 'Asu', '', 'asa', 'asa', 0, 41, '2022-08-23 06:11:21', NULL, 1, NULL),
(42, 'Asu (Tanzania)', 'Tadhania', 'asa', 'asa_TZ', 0, 42, '2022-08-23 06:11:21', NULL, 1, NULL),
(43, 'Asturian', '', 'ast', 'ast', 0, 43, '2022-08-23 06:11:21', NULL, 1, NULL),
(44, 'Asturian (Spain)', 'España', 'ast', 'ast_ES', 0, 44, '2022-08-23 06:11:21', NULL, 1, NULL),
(45, 'Azerbaijani', '', 'az', 'az', 0, 45, '2022-08-23 06:11:21', NULL, 1, NULL),
(46, 'Azerbaijani (Cyrillic)', '', 'az', 'az_Cyrl', 0, 46, '2022-08-23 06:11:21', NULL, 1, NULL),
(47, 'Azerbaijani (Cyrillic, Azerbaijan)', 'Азәрбајҹан', 'az', 'az_Cyrl_AZ', 0, 47, '2022-08-23 06:11:21', NULL, 1, NULL),
(48, 'Azerbaijani (Latin)', '', 'az', 'az_Latn', 0, 48, '2022-08-23 06:11:21', NULL, 1, NULL),
(49, 'Azerbaijani (Latin, Azerbaijan)', 'Azərbaycan', 'az', 'az_Latn_AZ', 0, 49, '2022-08-23 06:11:21', NULL, 1, NULL),
(50, 'Basaa', '', 'bas', 'bas', 0, 50, '2022-08-23 06:11:21', NULL, 1, NULL),
(51, 'Basaa (Cameroon)', 'Kàmɛ̀rûn', 'bas', 'bas_CM', 0, 51, '2022-08-23 06:11:21', NULL, 1, NULL),
(52, 'Belarusian', '', 'be', 'be', 0, 52, '2022-08-23 06:11:21', NULL, 1, NULL),
(53, 'Belarusian (Belarus)', 'Беларусь', 'be', 'be_BY', 0, 53, '2022-08-23 06:11:21', NULL, 1, NULL),
(54, 'Bemba', '', 'bem', 'bem', 0, 54, '2022-08-23 06:11:21', NULL, 1, NULL),
(55, 'Bemba (Zambia)', 'Zambia', 'bem', 'bem_ZM', 0, 55, '2022-08-23 06:11:21', NULL, 1, NULL),
(56, 'Bena', '', 'bez', 'bez', 0, 56, '2022-08-23 06:11:21', NULL, 1, NULL),
(57, 'Bena (Tanzania)', 'Hutanzania', 'bez', 'bez_TZ', 0, 57, '2022-08-23 06:11:21', NULL, 1, NULL),
(58, 'Bulgarian', '', 'bg', 'bg', 1, 58, '2022-08-23 06:11:21', NULL, 1, NULL),
(59, 'Bulgarian (Bulgaria)', 'България', 'bg', 'bg_BG', 0, 59, '2022-08-23 06:11:21', NULL, 1, NULL),
(60, 'Bambara', '', 'bm', 'bm', 0, 60, '2022-08-23 06:11:21', NULL, 1, NULL),
(61, 'Bambara (Mali)', 'Mali', 'bm', 'bm_ML', 0, 61, '2022-08-23 06:11:21', NULL, 1, NULL),
(62, 'Bangla', '', 'bn', 'bn', 0, 62, '2022-08-23 06:11:21', NULL, 1, NULL),
(63, 'Bangla (Bangladesh)', 'বাংলাদেশ', 'bn', 'bn_BD', 0, 63, '2022-08-23 06:11:21', NULL, 1, NULL),
(64, 'Bangla (India)', 'ভারত', 'bn', 'bn_IN', 0, 64, '2022-08-23 06:11:21', NULL, 1, NULL),
(65, 'Tibetan', '', 'bo', 'bo', 0, 65, '2022-08-23 06:11:21', NULL, 1, NULL),
(66, 'Tibetan (China)', 'རྒྱ་ནག', 'bo', 'bo_CN', 0, 66, '2022-08-23 06:11:21', NULL, 1, NULL),
(67, 'Tibetan (India)', 'རྒྱ་གར་', 'bo', 'bo_IN', 0, 67, '2022-08-23 06:11:21', NULL, 1, NULL),
(68, 'Breton', '', 'br', 'br', 0, 68, '2022-08-23 06:11:21', NULL, 1, NULL),
(69, 'Breton (France)', 'Frañs', 'br', 'br_FR', 0, 69, '2022-08-23 06:11:21', NULL, 1, NULL),
(70, 'Bodo', '', 'brx', 'brx', 0, 70, '2022-08-23 06:11:21', NULL, 1, NULL),
(71, 'Bodo (India)', 'भारत', 'brx', 'brx_IN', 0, 71, '2022-08-23 06:11:21', NULL, 1, NULL),
(72, 'Bosnian', '', 'bs', 'bs', 0, 72, '2022-08-23 06:11:21', NULL, 1, NULL),
(73, 'Bosnian (Cyrillic)', '', 'bs', 'bs_Cyrl', 0, 73, '2022-08-23 06:11:21', NULL, 1, NULL),
(74, 'Bosnian (Cyrillic, Bosnia & Herzegovina)', 'Босна и Херцеговина', 'bs', 'bs_Cyrl_BA', 0, 74, '2022-08-23 06:11:21', NULL, 1, NULL),
(75, 'Bosnian (Latin)', '', 'bs', 'bs_Latn', 0, 75, '2022-08-23 06:11:21', NULL, 1, NULL),
(76, 'Bosnian (Latin, Bosnia & Herzegovina)', 'Bosna i Hercegovina', 'bs', 'bs_Latn_BA', 0, 76, '2022-08-23 06:11:21', NULL, 1, NULL),
(77, 'Catalan', '', 'ca', 'ca', 0, 77, '2022-08-23 06:11:21', NULL, 1, NULL),
(78, 'Catalan (Andorra)', 'Andorra', 'ca', 'ca_AD', 0, 78, '2022-08-23 06:11:21', NULL, 1, NULL),
(79, 'Catalan (Spain)', 'Espanya', 'ca', 'ca_ES', 0, 79, '2022-08-23 06:11:21', NULL, 1, NULL),
(80, 'Catalan (France)', 'França', 'ca', 'ca_FR', 0, 80, '2022-08-23 06:11:21', NULL, 1, NULL),
(81, 'Catalan (Italy)', 'Itàlia', 'ca', 'ca_IT', 0, 81, '2022-08-23 06:11:21', NULL, 1, NULL),
(82, 'Chakma', '', 'ccp', 'ccp', 0, 82, '2022-08-23 06:11:21', NULL, 1, NULL),
(83, 'Chakma (Bangladesh)', '𑄝𑄁𑄣𑄘𑄬𑄌𑄴', 'ccp', 'ccp_BD', 0, 83, '2022-08-23 06:11:21', NULL, 1, NULL),
(84, 'Chakma (India)', '𑄞𑄢𑄧𑄖𑄴', 'ccp', 'ccp_IN', 0, 84, '2022-08-23 06:11:21', NULL, 1, NULL),
(85, 'Chechen', '', 'ce', 'ce', 0, 85, '2022-08-23 06:11:21', NULL, 1, NULL),
(86, 'Chechen (Russia)', 'Росси', 'ce', 'ce_RU', 0, 86, '2022-08-23 06:11:21', NULL, 1, NULL),
(87, 'Cebuano', '', 'ceb', 'ceb', 0, 87, '2022-08-23 06:11:21', NULL, 1, NULL),
(88, 'Cebuano (Philippines)', 'Pilipinas', 'ceb', 'ceb_PH', 0, 88, '2022-08-23 06:11:21', NULL, 1, NULL),
(89, 'Chiga', '', 'cgg', 'cgg', 0, 89, '2022-08-23 06:11:21', NULL, 1, NULL),
(90, 'Chiga (Uganda)', 'Uganda', 'cgg', 'cgg_UG', 0, 90, '2022-08-23 06:11:21', NULL, 1, NULL),
(91, 'Cherokee', '', 'chr', 'chr', 0, 91, '2022-08-23 06:11:21', NULL, 1, NULL),
(92, 'Cherokee (United States)', 'ᏌᏊ ᎢᏳᎾᎵᏍᏔᏅ ᏍᎦᏚᎩ', 'chr', 'chr_US', 0, 92, '2022-08-23 06:11:21', NULL, 1, NULL),
(93, 'Central Kurdish', '', 'ckb', 'ckb', 0, 93, '2022-08-23 06:11:21', NULL, 1, NULL),
(94, 'Central Kurdish (Iraq)', 'عێراق', 'ckb', 'ckb_IQ', 0, 94, '2022-08-23 06:11:21', NULL, 1, NULL),
(95, 'Central Kurdish (Iran)', 'ئێران', 'ckb', 'ckb_IR', 0, 95, '2022-08-23 06:11:21', NULL, 1, NULL),
(96, 'Czech', '', 'cs', 'cs', 1, 96, '2022-08-23 06:11:21', NULL, 1, NULL),
(97, 'Czech (Czechia)', 'Česko', 'cs', 'cs_CZ', 0, 97, '2022-08-23 06:11:21', NULL, 1, NULL),
(98, 'Welsh', '', 'cy', 'cy', 0, 98, '2022-08-23 06:11:21', NULL, 1, NULL),
(99, 'Welsh (United Kingdom)', 'Y Deyrnas Unedig', 'cy', 'cy_GB', 0, 99, '2022-08-23 06:11:21', NULL, 1, NULL),
(100, 'Danish', '', 'da', 'da', 0, 100, '2022-08-23 06:11:21', NULL, 1, NULL),
(101, 'Danish (Denmark)', 'Danmark', 'da', 'da_DK', 0, 101, '2022-08-23 06:11:21', NULL, 1, NULL),
(102, 'Danish (Greenland)', 'Grønland', 'da', 'da_GL', 0, 102, '2022-08-23 06:11:21', NULL, 1, NULL),
(103, 'Taita', '', 'dav', 'dav', 0, 103, '2022-08-23 06:11:21', NULL, 1, NULL),
(104, 'Taita (Kenya)', 'Kenya', 'dav', 'dav_KE', 0, 104, '2022-08-23 06:11:21', NULL, 1, NULL),
(105, 'German', '', 'de', 'de', 1, 105, '2022-08-23 06:11:21', NULL, 1, NULL),
(106, 'German (Austria)', 'Österreich', 'de', 'de_AT', 0, 106, '2022-08-23 06:11:21', NULL, 1, NULL),
(107, 'German (Belgium)', 'Belgien', 'de', 'de_BE', 0, 107, '2022-08-23 06:11:21', NULL, 1, NULL),
(108, 'German (Switzerland)', 'Schweiz', 'de', 'de_CH', 0, 108, '2022-08-23 06:11:21', NULL, 1, NULL),
(109, 'German (Germany)', 'Deutschland', 'de', 'de_DE', 0, 109, '2022-08-23 06:11:21', NULL, 1, NULL),
(110, 'German (Italy)', 'Italien', 'de', 'de_IT', 0, 110, '2022-08-23 06:11:21', NULL, 1, NULL),
(111, 'German (Liechtenstein)', 'Liechtenstein', 'de', 'de_LI', 0, 111, '2022-08-23 06:11:21', NULL, 1, NULL),
(112, 'German (Luxembourg)', 'Luxemburg', 'de', 'de_LU', 0, 112, '2022-08-23 06:11:21', NULL, 1, NULL),
(113, 'Zarma', '', 'dje', 'dje', 0, 113, '2022-08-23 06:11:21', NULL, 1, NULL),
(114, 'Zarma (Niger)', 'Nižer', 'dje', 'dje_NE', 0, 114, '2022-08-23 06:11:21', NULL, 1, NULL),
(115, 'Lower Sorbian', '', 'dsb', 'dsb', 0, 115, '2022-08-23 06:11:21', NULL, 1, NULL),
(116, 'Lower Sorbian (Germany)', 'Nimska', 'dsb', 'dsb_DE', 0, 116, '2022-08-23 06:11:21', NULL, 1, NULL),
(117, 'Duala', '', 'dua', 'dua', 0, 117, '2022-08-23 06:11:21', NULL, 1, NULL),
(118, 'Duala (Cameroon)', 'Cameroun', 'dua', 'dua_CM', 0, 118, '2022-08-23 06:11:21', NULL, 1, NULL),
(119, 'Jola-Fonyi', '', 'dyo', 'dyo', 0, 119, '2022-08-23 06:11:21', NULL, 1, NULL),
(120, 'Jola-Fonyi (Senegal)', 'Senegal', 'dyo', 'dyo_SN', 0, 120, '2022-08-23 06:11:21', NULL, 1, NULL),
(121, 'Dzongkha', '', 'dz', 'dz', 0, 121, '2022-08-23 06:11:21', NULL, 1, NULL),
(122, 'Dzongkha (Bhutan)', 'འབྲུག', 'dz', 'dz_BT', 0, 122, '2022-08-23 06:11:21', NULL, 1, NULL),
(123, 'Embu', '', 'ebu', 'ebu', 0, 123, '2022-08-23 06:11:21', NULL, 1, NULL),
(124, 'Embu (Kenya)', 'Kenya', 'ebu', 'ebu_KE', 0, 124, '2022-08-23 06:11:21', NULL, 1, NULL),
(125, 'Ewe', '', 'ee', 'ee', 0, 125, '2022-08-23 06:11:21', NULL, 1, NULL),
(126, 'Ewe (Ghana)', 'Ghana nutome', 'ee', 'ee_GH', 0, 126, '2022-08-23 06:11:21', NULL, 1, NULL),
(127, 'Ewe (Togo)', 'Togo nutome', 'ee', 'ee_TG', 0, 127, '2022-08-23 06:11:21', NULL, 1, NULL),
(128, 'Greek', '', 'el', 'el', 1, 128, '2022-08-23 06:11:21', NULL, 1, NULL),
(129, 'Greek (Cyprus)', 'Κύπρος', 'el', 'el_CY', 0, 129, '2022-08-23 06:11:21', NULL, 1, NULL),
(130, 'Greek (Greece)', 'Ελλάδα', 'el', 'el_GR', 0, 130, '2022-08-23 06:11:21', NULL, 1, NULL),
(131, 'English', '', 'en', 'en', 1, 131, '2022-08-23 06:11:21', NULL, 1, NULL),
(132, 'English (World)', 'World', 'en', 'en_001', 0, 132, '2022-08-23 06:11:21', NULL, 1, NULL),
(133, 'English (Europe)', 'Europe', 'en', 'en_150', 0, 133, '2022-08-23 06:11:21', NULL, 1, NULL),
(134, 'English (United Arab Emirates)', 'United Arab Emirates', 'en', 'en_AE', 0, 134, '2022-08-23 06:11:21', NULL, 1, NULL),
(135, 'English (Antigua & Barbuda)', 'Antigua & Barbuda', 'en', 'en_AG', 0, 135, '2022-08-23 06:11:21', NULL, 1, NULL),
(136, 'English (Anguilla)', 'Anguilla', 'en', 'en_AI', 0, 136, '2022-08-23 06:11:21', NULL, 1, NULL),
(137, 'English (American Samoa)', 'American Samoa', 'en', 'en_AS', 0, 137, '2022-08-23 06:11:21', NULL, 1, NULL),
(138, 'English (Austria)', 'Austria', 'en', 'en_AT', 0, 138, '2022-08-23 06:11:21', NULL, 1, NULL),
(139, 'English (Australia)', 'Australia', 'en', 'en_AU', 0, 139, '2022-08-23 06:11:21', NULL, 1, NULL),
(140, 'English (Barbados)', 'Barbados', 'en', 'en_BB', 0, 140, '2022-08-23 06:11:21', NULL, 1, NULL),
(141, 'English (Belgium)', 'Belgium', 'en', 'en_BE', 0, 141, '2022-08-23 06:11:21', NULL, 1, NULL),
(142, 'English (Burundi)', 'Burundi', 'en', 'en_BI', 0, 142, '2022-08-23 06:11:21', NULL, 1, NULL),
(143, 'English (Bermuda)', 'Bermuda', 'en', 'en_BM', 0, 143, '2022-08-23 06:11:21', NULL, 1, NULL),
(144, 'English (Bahamas)', 'Bahamas', 'en', 'en_BS', 0, 144, '2022-08-23 06:11:21', NULL, 1, NULL),
(145, 'English (Botswana)', 'Botswana', 'en', 'en_BW', 0, 145, '2022-08-23 06:11:21', NULL, 1, NULL),
(146, 'English (Belize)', 'Belize', 'en', 'en_BZ', 0, 146, '2022-08-23 06:11:21', NULL, 1, NULL),
(147, 'English (Canada)', 'Canada', 'en', 'en_CA', 0, 147, '2022-08-23 06:11:21', NULL, 1, NULL),
(148, 'English (Cocos [Keeling] Islands)', 'Cocos (Keeling) Islands', 'en', 'en_CC', 0, 148, '2022-08-23 06:11:21', NULL, 1, NULL),
(149, 'English (Switzerland)', 'Switzerland', 'en', 'en_CH', 0, 149, '2022-08-23 06:11:21', NULL, 1, NULL),
(150, 'English (Cook Islands)', 'Cook Islands', 'en', 'en_CK', 0, 150, '2022-08-23 06:11:21', NULL, 1, NULL),
(151, 'English (Cameroon)', 'Cameroon', 'en', 'en_CM', 0, 151, '2022-08-23 06:11:21', NULL, 1, NULL),
(152, 'English (Christmas Island)', 'Christmas Island', 'en', 'en_CX', 0, 152, '2022-08-23 06:11:21', NULL, 1, NULL),
(153, 'English (Cyprus)', 'Cyprus', 'en', 'en_CY', 0, 153, '2022-08-23 06:11:21', NULL, 1, NULL),
(154, 'English (Germany)', 'Germany', 'en', 'en_DE', 0, 154, '2022-08-23 06:11:21', NULL, 1, NULL),
(155, 'English (Diego Garcia)', 'Diego Garcia', 'en', 'en_DG', 0, 155, '2022-08-23 06:11:21', NULL, 1, NULL),
(156, 'English (Denmark)', 'Denmark', 'en', 'en_DK', 0, 156, '2022-08-23 06:11:21', NULL, 1, NULL),
(157, 'English (Dominica)', 'Dominica', 'en', 'en_DM', 0, 157, '2022-08-23 06:11:21', NULL, 1, NULL),
(158, 'English (Eritrea)', 'Eritrea', 'en', 'en_ER', 0, 158, '2022-08-23 06:11:21', NULL, 1, NULL),
(159, 'English (Finland)', 'Finland', 'en', 'en_FI', 0, 159, '2022-08-23 06:11:21', NULL, 1, NULL),
(160, 'English (Fiji)', 'Fiji', 'en', 'en_FJ', 0, 160, '2022-08-23 06:11:21', NULL, 1, NULL),
(161, 'English (Falkland Islands)', 'Falkland Islands', 'en', 'en_FK', 0, 161, '2022-08-23 06:11:21', NULL, 1, NULL),
(162, 'English (Micronesia)', 'Micronesia', 'en', 'en_FM', 0, 162, '2022-08-23 06:11:21', NULL, 1, NULL),
(163, 'English (United Kingdom)', 'United Kingdom', 'en', 'en_GB', 0, 163, '2022-08-23 06:11:21', NULL, 1, NULL),
(164, 'English (Grenada)', 'Grenada', 'en', 'en_GD', 0, 164, '2022-08-23 06:11:21', NULL, 1, NULL),
(165, 'English (Guernsey)', 'Guernsey', 'en', 'en_GG', 0, 165, '2022-08-23 06:11:21', NULL, 1, NULL),
(166, 'English (Ghana)', 'Ghana', 'en', 'en_GH', 0, 166, '2022-08-23 06:11:21', NULL, 1, NULL),
(167, 'English (Gibraltar)', 'Gibraltar', 'en', 'en_GI', 0, 167, '2022-08-23 06:11:21', NULL, 1, NULL),
(168, 'English (Gambia)', 'Gambia', 'en', 'en_GM', 0, 168, '2022-08-23 06:11:21', NULL, 1, NULL),
(169, 'English (Guam)', 'Guam', 'en', 'en_GU', 0, 169, '2022-08-23 06:11:21', NULL, 1, NULL),
(170, 'English (Guyana)', 'Guyana', 'en', 'en_GY', 0, 170, '2022-08-23 06:11:21', NULL, 1, NULL),
(171, 'English (Hong Kong SAR China)', 'Hong Kong SAR China', 'en', 'en_HK', 0, 171, '2022-08-23 06:11:21', NULL, 1, NULL),
(172, 'English (Ireland)', 'Ireland', 'en', 'en_IE', 0, 172, '2022-08-23 06:11:21', NULL, 1, NULL),
(173, 'English (Israel)', 'Israel', 'en', 'en_IL', 0, 173, '2022-08-23 06:11:21', NULL, 1, NULL),
(174, 'English (Isle of Man)', 'Isle of Man', 'en', 'en_IM', 0, 174, '2022-08-23 06:11:21', NULL, 1, NULL),
(175, 'English (India)', 'India', 'en', 'en_IN', 0, 175, '2022-08-23 06:11:21', NULL, 1, NULL),
(176, 'English (British Indian Ocean Territory)', 'British Indian Ocean Territory', 'en', 'en_IO', 0, 176, '2022-08-23 06:11:21', NULL, 1, NULL),
(177, 'English (Jersey)', 'Jersey', 'en', 'en_JE', 0, 177, '2022-08-23 06:11:21', NULL, 1, NULL),
(178, 'English (Jamaica)', 'Jamaica', 'en', 'en_JM', 0, 178, '2022-08-23 06:11:21', NULL, 1, NULL),
(179, 'English (Kenya)', 'Kenya', 'en', 'en_KE', 0, 179, '2022-08-23 06:11:21', NULL, 1, NULL),
(180, 'English (Kiribati)', 'Kiribati', 'en', 'en_KI', 0, 180, '2022-08-23 06:11:21', NULL, 1, NULL),
(181, 'English (St. Kitts & Nevis)', 'St. Kitts & Nevis', 'en', 'en_KN', 0, 181, '2022-08-23 06:11:21', NULL, 1, NULL),
(182, 'English (Cayman Islands)', 'Cayman Islands', 'en', 'en_KY', 0, 182, '2022-08-23 06:11:21', NULL, 1, NULL),
(183, 'English (St. Lucia)', 'St. Lucia', 'en', 'en_LC', 0, 183, '2022-08-23 06:11:21', NULL, 1, NULL),
(184, 'English (Liberia)', 'Liberia', 'en', 'en_LR', 0, 184, '2022-08-23 06:11:21', NULL, 1, NULL),
(185, 'English (Lesotho)', 'Lesotho', 'en', 'en_LS', 0, 185, '2022-08-23 06:11:21', NULL, 1, NULL),
(186, 'English (Madagascar)', 'Madagascar', 'en', 'en_MG', 0, 186, '2022-08-23 06:11:21', NULL, 1, NULL),
(187, 'English (Marshall Islands)', 'Marshall Islands', 'en', 'en_MH', 0, 187, '2022-08-23 06:11:21', NULL, 1, NULL),
(188, 'English (Macao SAR China)', 'Macao SAR China', 'en', 'en_MO', 0, 188, '2022-08-23 06:11:21', NULL, 1, NULL),
(189, 'English (Northern Mariana Islands)', 'Northern Mariana Islands', 'en', 'en_MP', 0, 189, '2022-08-23 06:11:21', NULL, 1, NULL),
(190, 'English (Montserrat)', 'Montserrat', 'en', 'en_MS', 0, 190, '2022-08-23 06:11:21', NULL, 1, NULL),
(191, 'English (Malta)', 'Malta', 'en', 'en_MT', 0, 191, '2022-08-23 06:11:21', NULL, 1, NULL),
(192, 'English (Mauritius)', 'Mauritius', 'en', 'en_MU', 0, 192, '2022-08-23 06:11:21', NULL, 1, NULL),
(193, 'English (Malawi)', 'Malawi', 'en', 'en_MW', 0, 193, '2022-08-23 06:11:21', NULL, 1, NULL),
(194, 'English (Malaysia)', 'Malaysia', 'en', 'en_MY', 0, 194, '2022-08-23 06:11:21', NULL, 1, NULL),
(195, 'English (Namibia)', 'Namibia', 'en', 'en_NA', 0, 195, '2022-08-23 06:11:21', NULL, 1, NULL),
(196, 'English (Norfolk Island)', 'Norfolk Island', 'en', 'en_NF', 0, 196, '2022-08-23 06:11:21', NULL, 1, NULL),
(197, 'English (Nigeria)', 'Nigeria', 'en', 'en_NG', 0, 197, '2022-08-23 06:11:21', NULL, 1, NULL),
(198, 'English (Netherlands)', 'Netherlands', 'en', 'en_NL', 0, 198, '2022-08-23 06:11:21', NULL, 1, NULL),
(199, 'English (Nauru)', 'Nauru', 'en', 'en_NR', 0, 199, '2022-08-23 06:11:21', NULL, 1, NULL),
(200, 'English (Niue)', 'Niue', 'en', 'en_NU', 0, 200, '2022-08-23 06:11:21', NULL, 1, NULL),
(201, 'English (New Zealand)', 'New Zealand', 'en', 'en_NZ', 0, 201, '2022-08-23 06:11:21', NULL, 1, NULL),
(202, 'English (Papua New Guinea)', 'Papua New Guinea', 'en', 'en_PG', 0, 202, '2022-08-23 06:11:21', NULL, 1, NULL),
(203, 'English (Philippines)', 'Philippines', 'en', 'en_PH', 0, 203, '2022-08-23 06:11:21', NULL, 1, NULL),
(204, 'English (Pakistan)', 'Pakistan', 'en', 'en_PK', 0, 204, '2022-08-23 06:11:21', NULL, 1, NULL),
(205, 'English (Pitcairn Islands)', 'Pitcairn Islands', 'en', 'en_PN', 0, 205, '2022-08-23 06:11:21', NULL, 1, NULL),
(206, 'English (Puerto Rico)', 'Puerto Rico', 'en', 'en_PR', 0, 206, '2022-08-23 06:11:21', NULL, 1, NULL),
(207, 'English (Palau)', 'Palau', 'en', 'en_PW', 0, 207, '2022-08-23 06:11:21', NULL, 1, NULL),
(208, 'English (Rwanda)', 'Rwanda', 'en', 'en_RW', 0, 208, '2022-08-23 06:11:21', NULL, 1, NULL),
(209, 'English (Solomon Islands)', 'Solomon Islands', 'en', 'en_SB', 0, 209, '2022-08-23 06:11:21', NULL, 1, NULL),
(210, 'English (Seychelles)', 'Seychelles', 'en', 'en_SC', 0, 210, '2022-08-23 06:11:21', NULL, 1, NULL),
(211, 'English (Sudan)', 'Sudan', 'en', 'en_SD', 0, 211, '2022-08-23 06:11:21', NULL, 1, NULL),
(212, 'English (Sweden)', 'Sweden', 'en', 'en_SE', 0, 212, '2022-08-23 06:11:21', NULL, 1, NULL),
(213, 'English (Singapore)', 'Singapore', 'en', 'en_SG', 0, 213, '2022-08-23 06:11:21', NULL, 1, NULL),
(214, 'English (St. Helena)', 'St. Helena', 'en', 'en_SH', 0, 214, '2022-08-23 06:11:21', NULL, 1, NULL),
(215, 'English (Slovenia)', 'Slovenia', 'en', 'en_SI', 0, 215, '2022-08-23 06:11:21', NULL, 1, NULL),
(216, 'English (Sierra Leone)', 'Sierra Leone', 'en', 'en_SL', 0, 216, '2022-08-23 06:11:21', NULL, 1, NULL),
(217, 'English (South Sudan)', 'South Sudan', 'en', 'en_SS', 0, 217, '2022-08-23 06:11:21', NULL, 1, NULL),
(218, 'English (Sint Maarten)', 'Sint Maarten', 'en', 'en_SX', 0, 218, '2022-08-23 06:11:21', NULL, 1, NULL),
(219, 'English (Eswatini)', 'Eswatini', 'en', 'en_SZ', 0, 219, '2022-08-23 06:11:21', NULL, 1, NULL),
(220, 'English (Turks & Caicos Islands)', 'Turks & Caicos Islands', 'en', 'en_TC', 0, 220, '2022-08-23 06:11:21', NULL, 1, NULL),
(221, 'English (Tokelau)', 'Tokelau', 'en', 'en_TK', 0, 221, '2022-08-23 06:11:21', NULL, 1, NULL),
(222, 'English (Tonga)', 'Tonga', 'en', 'en_TO', 0, 222, '2022-08-23 06:11:21', NULL, 1, NULL),
(223, 'English (Trinidad & Tobago)', 'Trinidad & Tobago', 'en', 'en_TT', 0, 223, '2022-08-23 06:11:21', NULL, 1, NULL),
(224, 'English (Tuvalu)', 'Tuvalu', 'en', 'en_TV', 0, 224, '2022-08-23 06:11:21', NULL, 1, NULL),
(225, 'English (Tanzania)', 'Tanzania', 'en', 'en_TZ', 0, 225, '2022-08-23 06:11:21', NULL, 1, NULL),
(226, 'English (Uganda)', 'Uganda', 'en', 'en_UG', 0, 226, '2022-08-23 06:11:21', NULL, 1, NULL),
(227, 'English (U.S. Outlying Islands)', 'U.S. Outlying Islands', 'en', 'en_UM', 0, 227, '2022-08-23 06:11:21', NULL, 1, NULL),
(228, 'English (United States)', 'United States', 'en', 'en_US', 0, 228, '2022-08-23 06:11:21', NULL, 1, NULL),
(229, 'English (United States, Computer)', 'United States', 'en', 'en_US_POSIX', 0, 229, '2022-08-23 06:11:21', NULL, 1, NULL),
(230, 'English (St. Vincent & Grenadines)', 'St. Vincent & Grenadines', 'en', 'en_VC', 0, 230, '2022-08-23 06:11:21', NULL, 1, NULL),
(231, 'English (British Virgin Islands)', 'British Virgin Islands', 'en', 'en_VG', 0, 231, '2022-08-23 06:11:21', NULL, 1, NULL),
(232, 'English (U.S. Virgin Islands)', 'U.S. Virgin Islands', 'en', 'en_VI', 0, 232, '2022-08-23 06:11:21', NULL, 1, NULL),
(233, 'English (Vanuatu)', 'Vanuatu', 'en', 'en_VU', 0, 233, '2022-08-23 06:11:21', NULL, 1, NULL),
(234, 'English (Samoa)', 'Samoa', 'en', 'en_WS', 0, 234, '2022-08-23 06:11:21', NULL, 1, NULL),
(235, 'English (South Africa)', 'South Africa', 'en', 'en_ZA', 0, 235, '2022-08-23 06:11:21', NULL, 1, NULL),
(236, 'English (Zambia)', 'Zambia', 'en', 'en_ZM', 0, 236, '2022-08-23 06:11:21', NULL, 1, NULL),
(237, 'English (Zimbabwe)', 'Zimbabwe', 'en', 'en_ZW', 0, 237, '2022-08-23 06:11:21', NULL, 1, NULL),
(238, 'Esperanto', '', 'eo', 'eo', 0, 238, '2022-08-23 06:11:21', NULL, 1, NULL),
(239, 'Esperanto (World)', 'Mondo', 'eo', 'eo_001', 0, 239, '2022-08-23 06:11:21', NULL, 1, NULL),
(240, 'Spanish', '', 'es', 'es', 1, 240, '2022-08-23 06:11:21', NULL, 1, NULL),
(241, 'Spanish (Latin America)', 'Latinoamérica', 'es', 'es_419', 0, 241, '2022-08-23 06:11:21', NULL, 1, NULL),
(242, 'Spanish (Argentina)', 'Argentina', 'es', 'es_AR', 0, 242, '2022-08-23 06:11:21', NULL, 1, NULL),
(243, 'Spanish (Bolivia)', 'Bolivia', 'es', 'es_BO', 0, 243, '2022-08-23 06:11:21', NULL, 1, NULL),
(244, 'Spanish (Brazil)', 'Brasil', 'es', 'es_BR', 0, 244, '2022-08-23 06:11:21', NULL, 1, NULL),
(245, 'Spanish (Belize)', 'Belice', 'es', 'es_BZ', 0, 245, '2022-08-23 06:11:21', NULL, 1, NULL),
(246, 'Spanish (Chile)', 'Chile', 'es', 'es_CL', 0, 246, '2022-08-23 06:11:21', NULL, 1, NULL),
(247, 'Spanish (Colombia)', 'Colombia', 'es', 'es_CO', 0, 247, '2022-08-23 06:11:21', NULL, 1, NULL),
(248, 'Spanish (Costa Rica)', 'Costa Rica', 'es', 'es_CR', 0, 248, '2022-08-23 06:11:21', NULL, 1, NULL),
(249, 'Spanish (Cuba)', 'Cuba', 'es', 'es_CU', 0, 249, '2022-08-23 06:11:21', NULL, 1, NULL),
(250, 'Spanish (Dominican Republic)', 'República Dominicana', 'es', 'es_DO', 0, 250, '2022-08-23 06:11:21', NULL, 1, NULL),
(251, 'Spanish (Ceuta & Melilla)', 'Ceuta y Melilla', 'es', 'es_EA', 0, 251, '2022-08-23 06:11:21', NULL, 1, NULL),
(252, 'Spanish (Ecuador)', 'Ecuador', 'es', 'es_EC', 0, 252, '2022-08-23 06:11:21', NULL, 1, NULL),
(253, 'Spanish (Spain)', 'España', 'es', 'es_ES', 0, 253, '2022-08-23 06:11:21', NULL, 1, NULL),
(254, 'Spanish (Equatorial Guinea)', 'Guinea Ecuatorial', 'es', 'es_GQ', 0, 254, '2022-08-23 06:11:21', NULL, 1, NULL),
(255, 'Spanish (Guatemala)', 'Guatemala', 'es', 'es_GT', 0, 255, '2022-08-23 06:11:21', NULL, 1, NULL),
(256, 'Spanish (Honduras)', 'Honduras', 'es', 'es_HN', 0, 256, '2022-08-23 06:11:21', NULL, 1, NULL),
(257, 'Spanish (Canary Islands)', 'Canarias', 'es', 'es_IC', 0, 257, '2022-08-23 06:11:21', NULL, 1, NULL),
(258, 'Spanish (Mexico)', 'México', 'es', 'es_MX', 0, 258, '2022-08-23 06:11:21', NULL, 1, NULL),
(259, 'Spanish (Nicaragua)', 'Nicaragua', 'es', 'es_NI', 0, 259, '2022-08-23 06:11:21', NULL, 1, NULL),
(260, 'Spanish (Panama)', 'Panamá', 'es', 'es_PA', 0, 260, '2022-08-23 06:11:21', NULL, 1, NULL),
(261, 'Spanish (Peru)', 'Perú', 'es', 'es_PE', 0, 261, '2022-08-23 06:11:21', NULL, 1, NULL),
(262, 'Spanish (Philippines)', 'Filipinas', 'es', 'es_PH', 0, 262, '2022-08-23 06:11:21', NULL, 1, NULL),
(263, 'Spanish (Puerto Rico)', 'Puerto Rico', 'es', 'es_PR', 0, 263, '2022-08-23 06:11:21', NULL, 1, NULL),
(264, 'Spanish (Paraguay)', 'Paraguay', 'es', 'es_PY', 0, 264, '2022-08-23 06:11:21', NULL, 1, NULL),
(265, 'Spanish (El Salvador)', 'El Salvador', 'es', 'es_SV', 0, 265, '2022-08-23 06:11:21', NULL, 1, NULL),
(266, 'Spanish (United States)', 'Estados Unidos', 'es', 'es_US', 0, 266, '2022-08-23 06:11:21', NULL, 1, NULL),
(267, 'Spanish (Uruguay)', 'Uruguay', 'es', 'es_UY', 0, 267, '2022-08-23 06:11:21', NULL, 1, NULL),
(268, 'Spanish (Venezuela)', 'Venezuela', 'es', 'es_VE', 0, 268, '2022-08-23 06:11:21', NULL, 1, NULL),
(269, 'Estonian', '', 'et', 'et', 0, 269, '2022-08-23 06:11:21', NULL, 1, NULL),
(270, 'Estonian (Estonia)', 'Eesti', 'et', 'et_EE', 0, 270, '2022-08-23 06:11:21', NULL, 1, NULL),
(271, 'Basque', '', 'eu', 'eu', 0, 271, '2022-08-23 06:11:21', NULL, 1, NULL),
(272, 'Basque (Spain)', 'Espainia', 'eu', 'eu_ES', 0, 272, '2022-08-23 06:11:21', NULL, 1, NULL),
(273, 'Ewondo', '', 'ewo', 'ewo', 0, 273, '2022-08-23 06:11:21', NULL, 1, NULL),
(274, 'Ewondo (Cameroon)', 'Kamərún', 'ewo', 'ewo_CM', 0, 274, '2022-08-23 06:11:21', NULL, 1, NULL),
(275, 'Persian', '', 'fa', 'fa', 1, 275, '2022-08-23 06:11:21', NULL, 1, NULL),
(276, 'Persian (Afghanistan)', 'افغانستان', 'fa', 'fa_AF', 0, 276, '2022-08-23 06:11:21', NULL, 1, NULL),
(277, 'Persian (Iran)', 'ایران', 'fa', 'fa_IR', 0, 277, '2022-08-23 06:11:21', NULL, 1, NULL),
(278, 'Fulah', '', 'ff', 'ff', 0, 278, '2022-08-23 06:11:21', NULL, 1, NULL),
(279, 'Fulah (Latin)', '', 'ff', 'ff_Latn', 0, 279, '2022-08-23 06:11:21', NULL, 1, NULL),
(280, 'Fulah (Latin, Burkina Faso)', 'Burkibaa Faaso', 'ff', 'ff_Latn_BF', 0, 280, '2022-08-23 06:11:21', NULL, 1, NULL),
(281, 'Fulah (Latin, Cameroon)', 'Kameruun', 'ff', 'ff_Latn_CM', 0, 281, '2022-08-23 06:11:21', NULL, 1, NULL),
(282, 'Fulah (Latin, Ghana)', 'Ganaa', 'ff', 'ff_Latn_GH', 0, 282, '2022-08-23 06:11:21', NULL, 1, NULL),
(283, 'Fulah (Latin, Gambia)', 'Gammbi', 'ff', 'ff_Latn_GM', 0, 283, '2022-08-23 06:11:21', NULL, 1, NULL),
(284, 'Fulah (Latin, Guinea)', 'Gine', 'ff', 'ff_Latn_GN', 0, 284, '2022-08-23 06:11:21', NULL, 1, NULL),
(285, 'Fulah (Latin, Guinea-Bissau)', 'Gine-Bisaawo', 'ff', 'ff_Latn_GW', 0, 285, '2022-08-23 06:11:21', NULL, 1, NULL),
(286, 'Fulah (Latin, Liberia)', 'Liberiyaa', 'ff', 'ff_Latn_LR', 0, 286, '2022-08-23 06:11:21', NULL, 1, NULL),
(287, 'Fulah (Latin, Mauritania)', 'Muritani', 'ff', 'ff_Latn_MR', 0, 287, '2022-08-23 06:11:21', NULL, 1, NULL),
(288, 'Fulah (Latin, Niger)', 'Nijeer', 'ff', 'ff_Latn_NE', 0, 288, '2022-08-23 06:11:21', NULL, 1, NULL),
(289, 'Fulah (Latin, Nigeria)', 'Nijeriyaa', 'ff', 'ff_Latn_NG', 0, 289, '2022-08-23 06:11:21', NULL, 1, NULL),
(290, 'Fulah (Latin, Sierra Leone)', 'Seraa liyon', 'ff', 'ff_Latn_SL', 0, 290, '2022-08-23 06:11:21', NULL, 1, NULL),
(291, 'Fulah (Latin, Senegal)', 'Senegaal', 'ff', 'ff_Latn_SN', 0, 291, '2022-08-23 06:11:21', NULL, 1, NULL),
(292, 'Finnish', '', 'fi', 'fi', 0, 292, '2022-08-23 06:11:21', NULL, 1, NULL),
(293, 'Finnish (Finland)', 'Suomi', 'fi', 'fi_FI', 0, 293, '2022-08-23 06:11:21', NULL, 1, NULL),
(294, 'Filipino', '', 'fil', 'fil', 0, 294, '2022-08-23 06:11:21', NULL, 1, NULL),
(295, 'Filipino (Philippines)', 'Pilipinas', 'fil', 'fil_PH', 0, 295, '2022-08-23 06:11:21', NULL, 1, NULL),
(296, 'Faroese', '', 'fo', 'fo', 0, 296, '2022-08-23 06:11:21', NULL, 1, NULL),
(297, 'Faroese (Denmark)', 'Danmark', 'fo', 'fo_DK', 0, 297, '2022-08-23 06:11:21', NULL, 1, NULL),
(298, 'Faroese (Faroe Islands)', 'Føroyar', 'fo', 'fo_FO', 0, 298, '2022-08-23 06:11:21', NULL, 1, NULL),
(299, 'French', '', 'fr', 'fr', 1, 299, '2022-08-23 06:11:21', NULL, 1, NULL),
(300, 'French (Belgium)', 'Belgique', 'fr', 'fr_BE', 0, 300, '2022-08-23 06:11:21', NULL, 1, NULL),
(301, 'French (Burkina Faso)', 'Burkina Faso', 'fr', 'fr_BF', 0, 301, '2022-08-23 06:11:21', NULL, 1, NULL),
(302, 'French (Burundi)', 'Burundi', 'fr', 'fr_BI', 0, 302, '2022-08-23 06:11:21', NULL, 1, NULL),
(303, 'French (Benin)', 'Bénin', 'fr', 'fr_BJ', 0, 303, '2022-08-23 06:11:21', NULL, 1, NULL),
(304, 'French (St. Barthélemy)', 'Saint-Barthélemy', 'fr', 'fr_BL', 0, 304, '2022-08-23 06:11:21', NULL, 1, NULL),
(305, 'French (Canada)', 'Canada', 'fr', 'fr_CA', 0, 305, '2022-08-23 06:11:21', NULL, 1, NULL),
(306, 'French (Congo - Kinshasa)', 'Congo-Kinshasa', 'fr', 'fr_CD', 0, 306, '2022-08-23 06:11:21', NULL, 1, NULL),
(307, 'French (Central African Republic)', 'République centrafricaine', 'fr', 'fr_CF', 0, 307, '2022-08-23 06:11:21', NULL, 1, NULL),
(308, 'French (Congo - Brazzaville)', 'Congo-Brazzaville', 'fr', 'fr_CG', 0, 308, '2022-08-23 06:11:21', NULL, 1, NULL),
(309, 'French (Switzerland)', 'Suisse', 'fr', 'fr_CH', 0, 309, '2022-08-23 06:11:21', NULL, 1, NULL),
(310, 'French (Côte d’Ivoire)', 'Côte d’Ivoire', 'fr', 'fr_CI', 0, 310, '2022-08-23 06:11:21', NULL, 1, NULL),
(311, 'French (Cameroon)', 'Cameroun', 'fr', 'fr_CM', 0, 311, '2022-08-23 06:11:21', NULL, 1, NULL),
(312, 'French (Djibouti)', 'Djibouti', 'fr', 'fr_DJ', 0, 312, '2022-08-23 06:11:21', NULL, 1, NULL),
(313, 'French (Algeria)', 'Algérie', 'fr', 'fr_DZ', 0, 313, '2022-08-23 06:11:21', NULL, 1, NULL),
(314, 'French (France)', 'France', 'fr', 'fr_FR', 0, 314, '2022-08-23 06:11:21', NULL, 1, NULL),
(315, 'French (Gabon)', 'Gabon', 'fr', 'fr_GA', 0, 315, '2022-08-23 06:11:21', NULL, 1, NULL),
(316, 'French (French Guiana)', 'Guyane française', 'fr', 'fr_GF', 0, 316, '2022-08-23 06:11:21', NULL, 1, NULL),
(317, 'French (Guinea)', 'Guinée', 'fr', 'fr_GN', 0, 317, '2022-08-23 06:11:21', NULL, 1, NULL),
(318, 'French (Guadeloupe)', 'Guadeloupe', 'fr', 'fr_GP', 0, 318, '2022-08-23 06:11:21', NULL, 1, NULL),
(319, 'French (Equatorial Guinea)', 'Guinée équatoriale', 'fr', 'fr_GQ', 0, 319, '2022-08-23 06:11:21', NULL, 1, NULL),
(320, 'French (Haiti)', 'Haïti', 'fr', 'fr_HT', 0, 320, '2022-08-23 06:11:21', NULL, 1, NULL),
(321, 'French (Comoros)', 'Comores', 'fr', 'fr_KM', 0, 321, '2022-08-23 06:11:21', NULL, 1, NULL),
(322, 'French (Luxembourg)', 'Luxembourg', 'fr', 'fr_LU', 0, 322, '2022-08-23 06:11:21', NULL, 1, NULL),
(323, 'French (Morocco)', 'Maroc', 'fr', 'fr_MA', 0, 323, '2022-08-23 06:11:21', NULL, 1, NULL),
(324, 'French (Monaco)', 'Monaco', 'fr', 'fr_MC', 0, 324, '2022-08-23 06:11:21', NULL, 1, NULL),
(325, 'French (St. Martin)', 'Saint-Martin', 'fr', 'fr_MF', 0, 325, '2022-08-23 06:11:21', NULL, 1, NULL),
(326, 'French (Madagascar)', 'Madagascar', 'fr', 'fr_MG', 0, 326, '2022-08-23 06:11:21', NULL, 1, NULL),
(327, 'French (Mali)', 'Mali', 'fr', 'fr_ML', 0, 327, '2022-08-23 06:11:21', NULL, 1, NULL),
(328, 'French (Martinique)', 'Martinique', 'fr', 'fr_MQ', 0, 328, '2022-08-23 06:11:21', NULL, 1, NULL),
(329, 'French (Mauritania)', 'Mauritanie', 'fr', 'fr_MR', 0, 329, '2022-08-23 06:11:21', NULL, 1, NULL),
(330, 'French (Mauritius)', 'Maurice', 'fr', 'fr_MU', 0, 330, '2022-08-23 06:11:21', NULL, 1, NULL),
(331, 'French (New Caledonia)', 'Nouvelle-Calédonie', 'fr', 'fr_NC', 0, 331, '2022-08-23 06:11:21', NULL, 1, NULL),
(332, 'French (Niger)', 'Niger', 'fr', 'fr_NE', 0, 332, '2022-08-23 06:11:21', NULL, 1, NULL),
(333, 'French (French Polynesia)', 'Polynésie française', 'fr', 'fr_PF', 0, 333, '2022-08-23 06:11:21', NULL, 1, NULL),
(334, 'French (St. Pierre & Miquelon)', 'Saint-Pierre-et-Miquelon', 'fr', 'fr_PM', 0, 334, '2022-08-23 06:11:21', NULL, 1, NULL),
(335, 'French (Réunion)', 'La Réunion', 'fr', 'fr_RE', 0, 335, '2022-08-23 06:11:21', NULL, 1, NULL),
(336, 'French (Rwanda)', 'Rwanda', 'fr', 'fr_RW', 0, 336, '2022-08-23 06:11:21', NULL, 1, NULL),
(337, 'French (Seychelles)', 'Seychelles', 'fr', 'fr_SC', 0, 337, '2022-08-23 06:11:21', NULL, 1, NULL),
(338, 'French (Senegal)', 'Sénégal', 'fr', 'fr_SN', 0, 338, '2022-08-23 06:11:21', NULL, 1, NULL),
(339, 'French (Syria)', 'Syrie', 'fr', 'fr_SY', 0, 339, '2022-08-23 06:11:21', NULL, 1, NULL),
(340, 'French (Chad)', 'Tchad', 'fr', 'fr_TD', 0, 340, '2022-08-23 06:11:21', NULL, 1, NULL),
(341, 'French (Togo)', 'Togo', 'fr', 'fr_TG', 0, 341, '2022-08-23 06:11:21', NULL, 1, NULL),
(342, 'French (Tunisia)', 'Tunisie', 'fr', 'fr_TN', 0, 342, '2022-08-23 06:11:21', NULL, 1, NULL),
(343, 'French (Vanuatu)', 'Vanuatu', 'fr', 'fr_VU', 0, 343, '2022-08-23 06:11:21', NULL, 1, NULL),
(344, 'French (Wallis & Futuna)', 'Wallis-et-Futuna', 'fr', 'fr_WF', 0, 344, '2022-08-23 06:11:21', NULL, 1, NULL),
(345, 'French (Mayotte)', 'Mayotte', 'fr', 'fr_YT', 0, 345, '2022-08-23 06:11:21', NULL, 1, NULL),
(346, 'Friulian', '', 'fur', 'fur', 0, 346, '2022-08-23 06:11:21', NULL, 1, NULL),
(347, 'Friulian (Italy)', 'Italie', 'fur', 'fur_IT', 0, 347, '2022-08-23 06:11:21', NULL, 1, NULL),
(348, 'Western Frisian', '', 'fy', 'fy', 0, 348, '2022-08-23 06:11:21', NULL, 1, NULL),
(349, 'Western Frisian (Netherlands)', 'Nederlân', 'fy', 'fy_NL', 0, 349, '2022-08-23 06:11:21', NULL, 1, NULL),
(350, 'Irish', '', 'ga', 'ga', 0, 350, '2022-08-23 06:11:21', NULL, 1, NULL),
(351, 'Irish (Ireland)', 'Éire', 'ga', 'ga_IE', 0, 351, '2022-08-23 06:11:21', NULL, 1, NULL),
(352, 'Scottish Gaelic', '', 'gd', 'gd', 0, 352, '2022-08-23 06:11:21', NULL, 1, NULL),
(353, 'Scottish Gaelic (United Kingdom)', 'An Rìoghachd Aonaichte', 'gd', 'gd_GB', 0, 353, '2022-08-23 06:11:21', NULL, 1, NULL),
(354, 'Galician', '', 'gl', 'gl', 0, 354, '2022-08-23 06:11:21', NULL, 1, NULL),
(355, 'Galician (Spain)', 'España', 'gl', 'gl_ES', 0, 355, '2022-08-23 06:11:21', NULL, 1, NULL),
(356, 'Swiss German', '', 'gsw', 'gsw', 0, 356, '2022-08-23 06:11:21', NULL, 1, NULL),
(357, 'Swiss German (Switzerland)', 'Schwiiz', 'gsw', 'gsw_CH', 0, 357, '2022-08-23 06:11:21', NULL, 1, NULL),
(358, 'Swiss German (France)', 'Frankriich', 'gsw', 'gsw_FR', 0, 358, '2022-08-23 06:11:21', NULL, 1, NULL),
(359, 'Swiss German (Liechtenstein)', 'Liächteschtäi', 'gsw', 'gsw_LI', 0, 359, '2022-08-23 06:11:21', NULL, 1, NULL),
(360, 'Gujarati', '', 'gu', 'gu', 0, 360, '2022-08-23 06:11:21', NULL, 1, NULL),
(361, 'Gujarati (India)', 'ભારત', 'gu', 'gu_IN', 0, 361, '2022-08-23 06:11:21', NULL, 1, NULL),
(362, 'Gusii', '', 'guz', 'guz', 0, 362, '2022-08-23 06:11:21', NULL, 1, NULL),
(363, 'Gusii (Kenya)', 'Kenya', 'guz', 'guz_KE', 0, 363, '2022-08-23 06:11:21', NULL, 1, NULL),
(364, 'Manx', '', 'gv', 'gv', 0, 364, '2022-08-23 06:11:21', NULL, 1, NULL),
(365, 'Manx (Isle of Man)', 'Ellan Vannin', 'gv', 'gv_IM', 0, 365, '2022-08-23 06:11:21', NULL, 1, NULL),
(366, 'Hausa', '', 'ha', 'ha', 0, 366, '2022-08-23 06:11:21', NULL, 1, NULL),
(367, 'Hausa (Ghana)', 'Gana', 'ha', 'ha_GH', 0, 367, '2022-08-23 06:11:21', NULL, 1, NULL),
(368, 'Hausa (Niger)', 'Nijar', 'ha', 'ha_NE', 0, 368, '2022-08-23 06:11:21', NULL, 1, NULL),
(369, 'Hausa (Nigeria)', 'Najeriya', 'ha', 'ha_NG', 0, 369, '2022-08-23 06:11:21', NULL, 1, NULL),
(370, 'Hawaiian', '', 'haw', 'haw', 0, 370, '2022-08-23 06:11:21', NULL, 1, NULL),
(371, 'Hawaiian (United States)', 'ʻAmelika Hui Pū ʻIa', 'haw', 'haw_US', 0, 371, '2022-08-23 06:11:21', NULL, 1, NULL),
(372, 'Hebrew', '', 'he', 'he', 0, 372, '2022-08-23 06:11:21', NULL, 1, NULL),
(373, 'Hebrew (Israel)', 'ישראל', 'he', 'he_IL', 0, 373, '2022-08-23 06:11:21', NULL, 1, NULL),
(374, 'Hindi', '', 'hi', 'hi', 0, 374, '2022-08-23 06:11:21', NULL, 1, NULL),
(375, 'Hindi (India)', 'भारत', 'hi', 'hi_IN', 0, 375, '2022-08-23 06:11:21', NULL, 1, NULL),
(376, 'Croatian', '', 'hr', 'hr', 0, 376, '2022-08-23 06:11:21', NULL, 1, NULL),
(377, 'Croatian (Bosnia & Herzegovina)', 'Bosna i Hercegovina', 'hr', 'hr_BA', 0, 377, '2022-08-23 06:11:21', NULL, 1, NULL),
(378, 'Croatian (Croatia)', 'Hrvatska', 'hr', 'hr_HR', 0, 378, '2022-08-23 06:11:21', NULL, 1, NULL),
(379, 'Upper Sorbian', '', 'hsb', 'hsb', 0, 379, '2022-08-23 06:11:21', NULL, 1, NULL),
(380, 'Upper Sorbian (Germany)', 'Němska', 'hsb', 'hsb_DE', 0, 380, '2022-08-23 06:11:21', NULL, 1, NULL),
(381, 'Hungarian', '', 'hu', 'hu', 1, 381, '2022-08-23 06:11:21', NULL, 1, NULL),
(382, 'Hungarian (Hungary)', 'Magyarország', 'hu', 'hu_HU', 0, 382, '2022-08-23 06:11:21', NULL, 1, NULL),
(383, 'Armenian', '', 'hy', 'hy', 0, 383, '2022-08-23 06:11:21', NULL, 1, NULL),
(384, 'Armenian (Armenia)', 'Հայաստան', 'hy', 'hy_AM', 0, 384, '2022-08-23 06:11:21', NULL, 1, NULL),
(385, 'Interlingua', '', 'ia', 'ia', 0, 385, '2022-08-23 06:11:21', NULL, 1, NULL),
(386, 'Interlingua (World)', 'Mundo', 'ia', 'ia_001', 0, 386, '2022-08-23 06:11:21', NULL, 1, NULL),
(387, 'Indonesian', '', 'id', 'id', 1, 387, '2022-08-23 06:11:21', NULL, 1, NULL),
(388, 'Indonesian (Indonesia)', 'Indonesia', 'id', 'id_ID', 0, 388, '2022-08-23 06:11:21', NULL, 1, NULL),
(389, 'Igbo', '', 'ig', 'ig', 0, 389, '2022-08-23 06:11:21', NULL, 1, NULL),
(390, 'Igbo (Nigeria)', 'Naịjịrịa', 'ig', 'ig_NG', 0, 390, '2022-08-23 06:11:21', NULL, 1, NULL),
(391, 'Sichuan Yi', '', 'ii', 'ii', 0, 391, '2022-08-23 06:11:21', NULL, 1, NULL),
(392, 'Sichuan Yi (China)', 'ꍏꇩ', 'ii', 'ii_CN', 0, 392, '2022-08-23 06:11:21', NULL, 1, NULL),
(393, 'Icelandic', '', 'is', 'is', 0, 393, '2022-08-23 06:11:21', NULL, 1, NULL),
(394, 'Icelandic (Iceland)', 'Ísland', 'is', 'is_IS', 0, 394, '2022-08-23 06:11:21', NULL, 1, NULL),
(395, 'Italian', '', 'it', 'it', 1, 395, '2022-08-23 06:11:21', NULL, 1, NULL),
(396, 'Italian (Switzerland)', 'Svizzera', 'it', 'it_CH', 0, 396, '2022-08-23 06:11:21', NULL, 1, NULL),
(397, 'Italian (Italy)', 'Italia', 'it', 'it_IT', 0, 397, '2022-08-23 06:11:21', NULL, 1, NULL),
(398, 'Italian (San Marino)', 'San Marino', 'it', 'it_SM', 0, 398, '2022-08-23 06:11:21', NULL, 1, NULL),
(399, 'Italian (Vatican City)', 'Città del Vaticano', 'it', 'it_VA', 0, 399, '2022-08-23 06:11:21', NULL, 1, NULL),
(400, 'Japanese', '', 'ja', 'ja', 1, 400, '2022-08-23 06:11:21', NULL, 1, NULL),
(401, 'Japanese (Japan)', '日本', 'ja', 'ja_JP', 0, 401, '2022-08-23 06:11:21', NULL, 1, NULL),
(402, 'Ngomba', '', 'jgo', 'jgo', 0, 402, '2022-08-23 06:11:21', NULL, 1, NULL),
(403, 'Ngomba (Cameroon)', 'Kamɛlûn', 'jgo', 'jgo_CM', 0, 403, '2022-08-23 06:11:21', NULL, 1, NULL),
(404, 'Machame', '', 'jmc', 'jmc', 0, 404, '2022-08-23 06:11:21', NULL, 1, NULL),
(405, 'Machame (Tanzania)', 'Tanzania', 'jmc', 'jmc_TZ', 0, 405, '2022-08-23 06:11:21', NULL, 1, NULL),
(406, 'Javanese', '', 'jv', 'jv', 0, 406, '2022-08-23 06:11:21', NULL, 1, NULL),
(407, 'Javanese (Indonesia)', 'Indonésia', 'jv', 'jv_ID', 0, 407, '2022-08-23 06:11:21', NULL, 1, NULL),
(408, 'Georgian', '', 'ka', 'ka', 0, 408, '2022-08-23 06:11:21', NULL, 1, NULL),
(409, 'Georgian (Georgia)', 'საქართველო', 'ka', 'ka_GE', 0, 409, '2022-08-23 06:11:21', NULL, 1, NULL),
(410, 'Kabyle', '', 'kab', 'kab', 0, 410, '2022-08-23 06:11:21', NULL, 1, NULL),
(411, 'Kabyle (Algeria)', 'Lezzayer', 'kab', 'kab_DZ', 0, 411, '2022-08-23 06:11:21', NULL, 1, NULL),
(412, 'Kamba', '', 'kam', 'kam', 0, 412, '2022-08-23 06:11:21', NULL, 1, NULL),
(413, 'Kamba (Kenya)', 'Kenya', 'kam', 'kam_KE', 0, 413, '2022-08-23 06:11:21', NULL, 1, NULL),
(414, 'Makonde', '', 'kde', 'kde', 0, 414, '2022-08-23 06:11:21', NULL, 1, NULL),
(415, 'Makonde (Tanzania)', 'Tanzania', 'kde', 'kde_TZ', 0, 415, '2022-08-23 06:11:21', NULL, 1, NULL),
(416, 'Kabuverdianu', '', 'kea', 'kea', 0, 416, '2022-08-23 06:11:21', NULL, 1, NULL),
(417, 'Kabuverdianu (Cape Verde)', 'Kabu Verdi', 'kea', 'kea_CV', 0, 417, '2022-08-23 06:11:21', NULL, 1, NULL),
(418, 'Koyra Chiini', '', 'khq', 'khq', 0, 418, '2022-08-23 06:11:21', NULL, 1, NULL),
(419, 'Koyra Chiini (Mali)', 'Maali', 'khq', 'khq_ML', 0, 419, '2022-08-23 06:11:21', NULL, 1, NULL),
(420, 'Kikuyu', '', 'ki', 'ki', 0, 420, '2022-08-23 06:11:21', NULL, 1, NULL),
(421, 'Kikuyu (Kenya)', 'Kenya', 'ki', 'ki_KE', 0, 421, '2022-08-23 06:11:21', NULL, 1, NULL),
(422, 'Kazakh', '', 'kk', 'kk', 0, 422, '2022-08-23 06:11:21', NULL, 1, NULL),
(423, 'Kazakh (Kazakhstan)', 'Қазақстан', 'kk', 'kk_KZ', 0, 423, '2022-08-23 06:11:21', NULL, 1, NULL),
(424, 'Kako', '', 'kkj', 'kkj', 0, 424, '2022-08-23 06:11:21', NULL, 1, NULL),
(425, 'Kako (Cameroon)', 'Kamɛrun', 'kkj', 'kkj_CM', 0, 425, '2022-08-23 06:11:21', NULL, 1, NULL),
(426, 'Kalaallisut', '', 'kl', 'kl', 0, 426, '2022-08-23 06:11:21', NULL, 1, NULL),
(427, 'Kalaallisut (Greenland)', 'Kalaallit Nunaat', 'kl', 'kl_GL', 0, 427, '2022-08-23 06:11:21', NULL, 1, NULL),
(428, 'Kalenjin', '', 'kln', 'kln', 0, 428, '2022-08-23 06:11:21', NULL, 1, NULL),
(429, 'Kalenjin (Kenya)', 'Emetab Kenya', 'kln', 'kln_KE', 0, 429, '2022-08-23 06:11:21', NULL, 1, NULL),
(430, 'Khmer', '', 'km', 'km', 0, 430, '2022-08-23 06:11:21', NULL, 1, NULL),
(431, 'Khmer (Cambodia)', 'កម្ពុជា', 'km', 'km_KH', 0, 431, '2022-08-23 06:11:21', NULL, 1, NULL),
(432, 'Kannada', '', 'kn', 'kn', 0, 432, '2022-08-23 06:11:21', NULL, 1, NULL),
(433, 'Kannada (India)', 'ಭಾರತ', 'kn', 'kn_IN', 0, 433, '2022-08-23 06:11:21', NULL, 1, NULL),
(434, 'Korean', '', 'ko', 'ko', 0, 434, '2022-08-23 06:11:21', NULL, 1, NULL),
(435, 'Korean (North Korea)', '조선민주주의인민공화국', 'ko', 'ko_KP', 0, 435, '2022-08-23 06:11:21', NULL, 1, NULL),
(436, 'Korean (South Korea)', '대한민국', 'ko', 'ko_KR', 0, 436, '2022-08-23 06:11:21', NULL, 1, NULL),
(437, 'Konkani', '', 'kok', 'kok', 0, 437, '2022-08-23 06:11:21', NULL, 1, NULL),
(438, 'Konkani (India)', 'भारत', 'kok', 'kok_IN', 0, 438, '2022-08-23 06:11:21', NULL, 1, NULL),
(439, 'Kashmiri', '', 'ks', 'ks', 0, 439, '2022-08-23 06:11:21', NULL, 1, NULL),
(440, 'Kashmiri (India)', 'ہِندوستان', 'ks', 'ks_IN', 0, 440, '2022-08-23 06:11:21', NULL, 1, NULL),
(441, 'Shambala', '', 'ksb', 'ksb', 0, 441, '2022-08-23 06:11:21', NULL, 1, NULL),
(442, 'Shambala (Tanzania)', 'Tanzania', 'ksb', 'ksb_TZ', 0, 442, '2022-08-23 06:11:21', NULL, 1, NULL),
(443, 'Bafia', '', 'ksf', 'ksf', 0, 443, '2022-08-23 06:11:21', NULL, 1, NULL),
(444, 'Bafia (Cameroon)', 'kamɛrún', 'ksf', 'ksf_CM', 0, 444, '2022-08-23 06:11:21', NULL, 1, NULL),
(445, 'Colognian', '', 'ksh', 'ksh', 0, 445, '2022-08-23 06:11:21', NULL, 1, NULL),
(446, 'Colognian (Germany)', 'Doütschland', 'ksh', 'ksh_DE', 0, 446, '2022-08-23 06:11:21', NULL, 1, NULL),
(447, 'Kurdish', '', 'ku', 'ku', 0, 447, '2022-08-23 06:11:21', NULL, 1, NULL),
(448, 'Kurdish (Turkey)', 'Tirkiye', 'ku', 'ku_TR', 0, 448, '2022-08-23 06:11:21', NULL, 1, NULL),
(449, 'Cornish', '', 'kw', 'kw', 0, 449, '2022-08-23 06:11:21', NULL, 1, NULL),
(450, 'Cornish (United Kingdom)', 'Rywvaneth Unys', 'kw', 'kw_GB', 0, 450, '2022-08-23 06:11:21', NULL, 1, NULL),
(451, 'Kyrgyz', '', 'ky', 'ky', 0, 451, '2022-08-23 06:11:21', NULL, 1, NULL),
(452, 'Kyrgyz (Kyrgyzstan)', 'Кыргызстан', 'ky', 'ky_KG', 0, 452, '2022-08-23 06:11:21', NULL, 1, NULL),
(453, 'Langi', '', 'lag', 'lag', 0, 453, '2022-08-23 06:11:21', NULL, 1, NULL),
(454, 'Langi (Tanzania)', 'Taansanía', 'lag', 'lag_TZ', 0, 454, '2022-08-23 06:11:21', NULL, 1, NULL),
(455, 'Luxembourgish', '', 'lb', 'lb', 0, 455, '2022-08-23 06:11:21', NULL, 1, NULL),
(456, 'Luxembourgish (Luxembourg)', 'Lëtzebuerg', 'lb', 'lb_LU', 0, 456, '2022-08-23 06:11:21', NULL, 1, NULL),
(457, 'Ganda', '', 'lg', 'lg', 0, 457, '2022-08-23 06:11:21', NULL, 1, NULL),
(458, 'Ganda (Uganda)', 'Yuganda', 'lg', 'lg_UG', 0, 458, '2022-08-23 06:11:21', NULL, 1, NULL),
(459, 'Lakota', '', 'lkt', 'lkt', 0, 459, '2022-08-23 06:11:21', NULL, 1, NULL),
(460, 'Lakota (United States)', 'Mílahaŋska Tȟamákȟočhe', 'lkt', 'lkt_US', 0, 460, '2022-08-23 06:11:21', NULL, 1, NULL),
(461, 'Lingala', '', 'ln', 'ln', 0, 461, '2022-08-23 06:11:21', NULL, 1, NULL),
(462, 'Lingala (Angola)', 'Angóla', 'ln', 'ln_AO', 0, 462, '2022-08-23 06:11:21', NULL, 1, NULL),
(463, 'Lingala (Congo - Kinshasa)', 'Republíki ya Kongó Demokratíki', 'ln', 'ln_CD', 0, 463, '2022-08-23 06:11:21', NULL, 1, NULL),
(464, 'Lingala (Central African Republic)', 'Repibiki ya Afríka ya Káti', 'ln', 'ln_CF', 0, 464, '2022-08-23 06:11:21', NULL, 1, NULL),
(465, 'Lingala (Congo - Brazzaville)', 'Kongo', 'ln', 'ln_CG', 0, 465, '2022-08-23 06:11:21', NULL, 1, NULL),
(466, 'Lao', '', 'lo', 'lo', 0, 466, '2022-08-23 06:11:21', NULL, 1, NULL),
(467, 'Lao (Laos)', 'ລາວ', 'lo', 'lo_LA', 0, 467, '2022-08-23 06:11:21', NULL, 1, NULL),
(468, 'Northern Luri', '', 'lrc', 'lrc', 0, 468, '2022-08-23 06:11:21', NULL, 1, NULL),
(469, 'Northern Luri (Iraq)', 'IQ', 'lrc', 'lrc_IQ', 0, 469, '2022-08-23 06:11:21', NULL, 1, NULL),
(470, 'Northern Luri (Iran)', 'IR', 'lrc', 'lrc_IR', 0, 470, '2022-08-23 06:11:21', NULL, 1, NULL),
(471, 'Lithuanian', '', 'lt', 'lt', 0, 471, '2022-08-23 06:11:21', NULL, 1, NULL),
(472, 'Lithuanian (Lithuania)', 'Lietuva', 'lt', 'lt_LT', 0, 472, '2022-08-23 06:11:21', NULL, 1, NULL),
(473, 'Luba-Katanga', '', 'lu', 'lu', 0, 473, '2022-08-23 06:11:21', NULL, 1, NULL),
(474, 'Luba-Katanga (Congo - Kinshasa)', 'Ditunga wa Kongu', 'lu', 'lu_CD', 0, 474, '2022-08-23 06:11:21', NULL, 1, NULL),
(475, 'Luo', '', 'luo', 'luo', 0, 475, '2022-08-23 06:11:21', NULL, 1, NULL),
(476, 'Luo (Kenya)', 'Kenya', 'luo', 'luo_KE', 0, 476, '2022-08-23 06:11:21', NULL, 1, NULL),
(477, 'Luyia', '', 'luy', 'luy', 0, 477, '2022-08-23 06:11:21', NULL, 1, NULL),
(478, 'Luyia (Kenya)', 'Kenya', 'luy', 'luy_KE', 0, 478, '2022-08-23 06:11:21', NULL, 1, NULL),
(479, 'Latvian', '', 'lv', 'lv', 0, 479, '2022-08-23 06:11:21', NULL, 1, NULL),
(480, 'Latvian (Latvia)', 'Latvija', 'lv', 'lv_LV', 0, 480, '2022-08-23 06:11:21', NULL, 1, NULL),
(481, 'Masai', '', 'mas', 'mas', 0, 481, '2022-08-23 06:11:21', NULL, 1, NULL),
(482, 'Masai (Kenya)', 'Kenya', 'mas', 'mas_KE', 0, 482, '2022-08-23 06:11:21', NULL, 1, NULL),
(483, 'Masai (Tanzania)', 'Tansania', 'mas', 'mas_TZ', 0, 483, '2022-08-23 06:11:21', NULL, 1, NULL),
(484, 'Meru', '', 'mer', 'mer', 0, 484, '2022-08-23 06:11:21', NULL, 1, NULL),
(485, 'Meru (Kenya)', 'Kenya', 'mer', 'mer_KE', 0, 485, '2022-08-23 06:11:21', NULL, 1, NULL),
(486, 'Morisyen', '', 'mfe', 'mfe', 0, 486, '2022-08-23 06:11:21', NULL, 1, NULL),
(487, 'Morisyen (Mauritius)', 'Moris', 'mfe', 'mfe_MU', 0, 487, '2022-08-23 06:11:21', NULL, 1, NULL),
(488, 'Malagasy', '', 'mg', 'mg', 0, 488, '2022-08-23 06:11:21', NULL, 1, NULL),
(489, 'Malagasy (Madagascar)', 'Madagasikara', 'mg', 'mg_MG', 0, 489, '2022-08-23 06:11:21', NULL, 1, NULL),
(490, 'Makhuwa-Meetto', '', 'mgh', 'mgh', 0, 490, '2022-08-23 06:11:21', NULL, 1, NULL),
(491, 'Makhuwa-Meetto (Mozambique)', 'Umozambiki', 'mgh', 'mgh_MZ', 0, 491, '2022-08-23 06:11:21', NULL, 1, NULL),
(492, 'Metaʼ', '', 'mgo', 'mgo', 0, 492, '2022-08-23 06:11:21', NULL, 1, NULL),
(493, 'Metaʼ (Cameroon)', 'Kamalun', 'mgo', 'mgo_CM', 0, 493, '2022-08-23 06:11:21', NULL, 1, NULL),
(494, 'Maori', '', 'mi', 'mi', 0, 494, '2022-08-23 06:11:21', NULL, 1, NULL),
(495, 'Maori (New Zealand)', 'Aotearoa', 'mi', 'mi_NZ', 0, 495, '2022-08-23 06:11:21', NULL, 1, NULL),
(496, 'Macedonian', '', 'mk', 'mk', 0, 496, '2022-08-23 06:11:21', NULL, 1, NULL),
(497, 'Macedonian (North Macedonia)', 'Северна Македонија', 'mk', 'mk_MK', 0, 497, '2022-08-23 06:11:21', NULL, 1, NULL),
(498, 'Malayalam', '', 'ml', 'ml', 0, 498, '2022-08-23 06:11:21', NULL, 1, NULL),
(499, 'Malayalam (India)', 'ഇന്ത്യ', 'ml', 'ml_IN', 0, 499, '2022-08-23 06:11:21', NULL, 1, NULL),
(500, 'Mongolian', '', 'mn', 'mn', 0, 500, '2022-08-23 06:11:21', NULL, 1, NULL),
(501, 'Mongolian (Mongolia)', 'Монгол', 'mn', 'mn_MN', 0, 501, '2022-08-23 06:11:21', NULL, 1, NULL),
(502, 'Marathi', '', 'mr', 'mr', 0, 502, '2022-08-23 06:11:21', NULL, 1, NULL),
(503, 'Marathi (India)', 'भारत', 'mr', 'mr_IN', 0, 503, '2022-08-23 06:11:21', NULL, 1, NULL),
(504, 'Malay', '', 'ms', 'ms', 0, 504, '2022-08-23 06:11:21', NULL, 1, NULL),
(505, 'Malay (Brunei)', 'Brunei', 'ms', 'ms_BN', 0, 505, '2022-08-23 06:11:21', NULL, 1, NULL),
(506, 'Malay (Malaysia)', 'Malaysia', 'ms', 'ms_MY', 0, 506, '2022-08-23 06:11:21', NULL, 1, NULL),
(507, 'Malay (Singapore)', 'Singapura', 'ms', 'ms_SG', 0, 507, '2022-08-23 06:11:21', NULL, 1, NULL),
(508, 'Maltese', '', 'mt', 'mt', 0, 508, '2022-08-23 06:11:21', NULL, 1, NULL),
(509, 'Maltese (Malta)', 'Malta', 'mt', 'mt_MT', 0, 509, '2022-08-23 06:11:21', NULL, 1, NULL),
(510, 'Mundang', '', 'mua', 'mua', 0, 510, '2022-08-23 06:11:21', NULL, 1, NULL),
(511, 'Mundang (Cameroon)', 'kameruŋ', 'mua', 'mua_CM', 0, 511, '2022-08-23 06:11:21', NULL, 1, NULL),
(512, 'Burmese', '', 'my', 'my', 0, 512, '2022-08-23 06:11:21', NULL, 1, NULL),
(513, 'Burmese (Myanmar [Burma])', 'မြန်မာ', 'my', 'my_MM', 0, 513, '2022-08-23 06:11:21', NULL, 1, NULL),
(514, 'Mazanderani', '', 'mzn', 'mzn', 0, 514, '2022-08-23 06:11:21', NULL, 1, NULL),
(515, 'Mazanderani (Iran)', 'ایران', 'mzn', 'mzn_IR', 0, 515, '2022-08-23 06:11:21', NULL, 1, NULL),
(516, 'Nama', '', 'naq', 'naq', 0, 516, '2022-08-23 06:11:21', NULL, 1, NULL),
(517, 'Nama (Namibia)', 'Namibiab', 'naq', 'naq_NA', 0, 517, '2022-08-23 06:11:21', NULL, 1, NULL),
(518, 'Norwegian Bokmål', '', 'nb', 'nb', 0, 518, '2022-08-23 06:11:21', NULL, 1, NULL);
INSERT INTO `languages` (`id`, `title`, `native`, `alias`, `locale`, `status`, `weight`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(519, 'Norwegian Bokmål (Norway)', 'Norge', 'nb', 'nb_NO', 0, 519, '2022-08-23 06:11:21', NULL, 1, NULL),
(520, 'Norwegian Bokmål (Svalbard & Jan Mayen)', 'Svalbard og Jan Mayen', 'nb', 'nb_SJ', 0, 520, '2022-08-23 06:11:21', NULL, 1, NULL),
(521, 'North Ndebele', '', 'nd', 'nd', 0, 521, '2022-08-23 06:11:21', NULL, 1, NULL),
(522, 'North Ndebele (Zimbabwe)', 'Zimbabwe', 'nd', 'nd_ZW', 0, 522, '2022-08-23 06:11:21', NULL, 1, NULL),
(523, 'Low German', '', 'nds', 'nds', 0, 523, '2022-08-23 06:11:21', NULL, 1, NULL),
(524, 'Low German (Germany)', 'DE', 'nds', 'nds_DE', 0, 524, '2022-08-23 06:11:21', NULL, 1, NULL),
(525, 'Low German (Netherlands)', 'NL', 'nds', 'nds_NL', 0, 525, '2022-08-23 06:11:21', NULL, 1, NULL),
(526, 'Nepali', '', 'ne', 'ne', 0, 526, '2022-08-23 06:11:21', NULL, 1, NULL),
(527, 'Nepali (India)', 'भारत', 'ne', 'ne_IN', 0, 527, '2022-08-23 06:11:21', NULL, 1, NULL),
(528, 'Nepali (Nepal)', 'नेपाल', 'ne', 'ne_NP', 0, 528, '2022-08-23 06:11:21', NULL, 1, NULL),
(529, 'Dutch', '', 'nl', 'nl', 1, 529, '2022-08-23 06:11:21', NULL, 1, NULL),
(530, 'Dutch (Aruba)', 'Aruba', 'nl', 'nl_AW', 0, 530, '2022-08-23 06:11:21', NULL, 1, NULL),
(531, 'Dutch (Belgium)', 'België', 'nl', 'nl_BE', 0, 531, '2022-08-23 06:11:21', NULL, 1, NULL),
(532, 'Dutch (Caribbean Netherlands)', 'Caribisch Nederland', 'nl', 'nl_BQ', 0, 532, '2022-08-23 06:11:21', NULL, 1, NULL),
(533, 'Dutch (Curaçao)', 'Curaçao', 'nl', 'nl_CW', 0, 533, '2022-08-23 06:11:21', NULL, 1, NULL),
(534, 'Dutch (Netherlands)', 'Nederland', 'nl', 'nl_NL', 0, 534, '2022-08-23 06:11:21', NULL, 1, NULL),
(535, 'Dutch (Suriname)', 'Suriname', 'nl', 'nl_SR', 0, 535, '2022-08-23 06:11:21', NULL, 1, NULL),
(536, 'Dutch (Sint Maarten)', 'Sint-Maarten', 'nl', 'nl_SX', 0, 536, '2022-08-23 06:11:21', NULL, 1, NULL),
(537, 'Kwasio', '', 'nmg', 'nmg', 0, 537, '2022-08-23 06:11:21', NULL, 1, NULL),
(538, 'Kwasio (Cameroon)', 'Kamerun', 'nmg', 'nmg_CM', 0, 538, '2022-08-23 06:11:21', NULL, 1, NULL),
(539, 'Norwegian Nynorsk', '', 'nn', 'nn', 0, 539, '2022-08-23 06:11:21', NULL, 1, NULL),
(540, 'Norwegian Nynorsk (Norway)', 'Noreg', 'nn', 'nn_NO', 0, 540, '2022-08-23 06:11:21', NULL, 1, NULL),
(541, 'Ngiemboon', '', 'nnh', 'nnh', 0, 541, '2022-08-23 06:11:21', NULL, 1, NULL),
(542, 'Ngiemboon (Cameroon)', 'Kàmalûm', 'nnh', 'nnh_CM', 0, 542, '2022-08-23 06:11:21', NULL, 1, NULL),
(543, 'Nuer', '', 'nus', 'nus', 0, 543, '2022-08-23 06:11:21', NULL, 1, NULL),
(544, 'Nuer (South Sudan)', 'SS', 'nus', 'nus_SS', 0, 544, '2022-08-23 06:11:21', NULL, 1, NULL),
(545, 'Nyankole', '', 'nyn', 'nyn', 0, 545, '2022-08-23 06:11:21', NULL, 1, NULL),
(546, 'Nyankole (Uganda)', 'Uganda', 'nyn', 'nyn_UG', 0, 546, '2022-08-23 06:11:21', NULL, 1, NULL),
(547, 'Oromo', '', 'om', 'om', 0, 547, '2022-08-23 06:11:21', NULL, 1, NULL),
(548, 'Oromo (Ethiopia)', 'Itoophiyaa', 'om', 'om_ET', 0, 548, '2022-08-23 06:11:21', NULL, 1, NULL),
(549, 'Oromo (Kenya)', 'Keeniyaa', 'om', 'om_KE', 0, 549, '2022-08-23 06:11:21', NULL, 1, NULL),
(550, 'Odia', '', 'or', 'or', 0, 550, '2022-08-23 06:11:21', NULL, 1, NULL),
(551, 'Odia (India)', 'ଭାରତ', 'or', 'or_IN', 0, 551, '2022-08-23 06:11:21', NULL, 1, NULL),
(552, 'Ossetic', '', 'os', 'os', 0, 552, '2022-08-23 06:11:21', NULL, 1, NULL),
(553, 'Ossetic (Georgia)', 'Гуырдзыстон', 'os', 'os_GE', 0, 553, '2022-08-23 06:11:21', NULL, 1, NULL),
(554, 'Ossetic (Russia)', 'Уӕрӕсе', 'os', 'os_RU', 0, 554, '2022-08-23 06:11:21', NULL, 1, NULL),
(555, 'Punjabi', '', 'pa', 'pa', 0, 555, '2022-08-23 06:11:21', NULL, 1, NULL),
(556, 'Punjabi (Arabic)', '', 'pa', 'pa_Arab', 0, 556, '2022-08-23 06:11:21', NULL, 1, NULL),
(557, 'Punjabi (Arabic, Pakistan)', 'پاکستان', 'pa', 'pa_Arab_PK', 0, 557, '2022-08-23 06:11:21', NULL, 1, NULL),
(558, 'Punjabi (Gurmukhi)', '', 'pa', 'pa_Guru', 0, 558, '2022-08-23 06:11:21', NULL, 1, NULL),
(559, 'Punjabi (Gurmukhi, India)', 'ਭਾਰਤ', 'pa', 'pa_Guru_IN', 0, 559, '2022-08-23 06:11:21', NULL, 1, NULL),
(560, 'Polish', '', 'pl', 'pl', 1, 560, '2022-08-23 06:11:21', NULL, 1, NULL),
(561, 'Polish (Poland)', 'Polska', 'pl', 'pl_PL', 0, 561, '2022-08-23 06:11:21', NULL, 1, NULL),
(562, 'Pashto', '', 'ps', 'ps', 0, 562, '2022-08-23 06:11:21', NULL, 1, NULL),
(563, 'Pashto (Afghanistan)', 'افغانستان', 'ps', 'ps_AF', 0, 563, '2022-08-23 06:11:21', NULL, 1, NULL),
(564, 'Pashto (Pakistan)', 'پاکستان', 'ps', 'ps_PK', 0, 564, '2022-08-23 06:11:21', NULL, 1, NULL),
(565, 'Portuguese', '', 'pt', 'pt', 1, 565, '2022-08-23 06:11:21', NULL, 1, NULL),
(566, 'Portuguese (Angola)', 'Angola', 'pt', 'pt_AO', 0, 566, '2022-08-23 06:11:21', NULL, 1, NULL),
(567, 'Portuguese (Brazil)', 'Brasil', 'pt', 'pt_BR', 0, 567, '2022-08-23 06:11:21', NULL, 1, NULL),
(568, 'Portuguese (Switzerland)', 'Suíça', 'pt', 'pt_CH', 0, 568, '2022-08-23 06:11:21', NULL, 1, NULL),
(569, 'Portuguese (Cape Verde)', 'Cabo Verde', 'pt', 'pt_CV', 0, 569, '2022-08-23 06:11:21', NULL, 1, NULL),
(570, 'Portuguese (Equatorial Guinea)', 'Guiné Equatorial', 'pt', 'pt_GQ', 0, 570, '2022-08-23 06:11:21', NULL, 1, NULL),
(571, 'Portuguese (Guinea-Bissau)', 'Guiné-Bissau', 'pt', 'pt_GW', 0, 571, '2022-08-23 06:11:21', NULL, 1, NULL),
(572, 'Portuguese (Luxembourg)', 'Luxemburgo', 'pt', 'pt_LU', 0, 572, '2022-08-23 06:11:21', NULL, 1, NULL),
(573, 'Portuguese (Macao SAR China)', 'Macau, RAE da China', 'pt', 'pt_MO', 0, 573, '2022-08-23 06:11:21', NULL, 1, NULL),
(574, 'Portuguese (Mozambique)', 'Moçambique', 'pt', 'pt_MZ', 0, 574, '2022-08-23 06:11:21', NULL, 1, NULL),
(575, 'Portuguese (Portugal)', 'Portugal', 'pt', 'pt_PT', 0, 575, '2022-08-23 06:11:21', NULL, 1, NULL),
(576, 'Portuguese (São Tomé & Príncipe)', 'São Tomé e Príncipe', 'pt', 'pt_ST', 0, 576, '2022-08-23 06:11:21', NULL, 1, NULL),
(577, 'Portuguese (Timor-Leste)', 'Timor-Leste', 'pt', 'pt_TL', 0, 577, '2022-08-23 06:11:21', NULL, 1, NULL),
(578, 'Quechua', '', 'qu', 'qu', 0, 578, '2022-08-23 06:11:21', NULL, 1, NULL),
(579, 'Quechua (Bolivia)', 'Bolivia', 'qu', 'qu_BO', 0, 579, '2022-08-23 06:11:21', NULL, 1, NULL),
(580, 'Quechua (Ecuador)', 'Ecuador', 'qu', 'qu_EC', 0, 580, '2022-08-23 06:11:21', NULL, 1, NULL),
(581, 'Quechua (Peru)', 'Perú', 'qu', 'qu_PE', 0, 581, '2022-08-23 06:11:21', NULL, 1, NULL),
(582, 'Romansh', '', 'rm', 'rm', 0, 582, '2022-08-23 06:11:21', NULL, 1, NULL),
(583, 'Romansh (Switzerland)', 'Svizra', 'rm', 'rm_CH', 0, 583, '2022-08-23 06:11:21', NULL, 1, NULL),
(584, 'Rundi', '', 'rn', 'rn', 0, 584, '2022-08-23 06:11:21', NULL, 1, NULL),
(585, 'Rundi (Burundi)', 'Uburundi', 'rn', 'rn_BI', 0, 585, '2022-08-23 06:11:21', NULL, 1, NULL),
(586, 'Romanian', '', 'ro', 'ro', 0, 586, '2022-08-23 06:11:21', NULL, 1, NULL),
(587, 'Romanian (Moldova)', 'Republica Moldova', 'ro', 'ro_MD', 0, 587, '2022-08-23 06:11:21', NULL, 1, NULL),
(588, 'Romanian (Romania)', 'România', 'ro', 'ro_RO', 0, 588, '2022-08-23 06:11:21', NULL, 1, NULL),
(589, 'Rombo', '', 'rof', 'rof', 0, 589, '2022-08-23 06:11:21', NULL, 1, NULL),
(590, 'Rombo (Tanzania)', 'Tanzania', 'rof', 'rof_TZ', 0, 590, '2022-08-23 06:11:21', NULL, 1, NULL),
(591, 'Russian', '', 'ru', 'ru', 1, 591, '2022-08-23 06:11:21', NULL, 1, NULL),
(592, 'Russian (Belarus)', 'Беларусь', 'ru', 'ru_BY', 0, 592, '2022-08-23 06:11:21', NULL, 1, NULL),
(593, 'Russian (Kyrgyzstan)', 'Киргизия', 'ru', 'ru_KG', 0, 593, '2022-08-23 06:11:21', NULL, 1, NULL),
(594, 'Russian (Kazakhstan)', 'Казахстан', 'ru', 'ru_KZ', 0, 594, '2022-08-23 06:11:21', NULL, 1, NULL),
(595, 'Russian (Moldova)', 'Молдова', 'ru', 'ru_MD', 0, 595, '2022-08-23 06:11:21', NULL, 1, NULL),
(596, 'Russian (Russia)', 'Россия', 'ru', 'ru_RU', 0, 596, '2022-08-23 06:11:21', NULL, 1, NULL),
(597, 'Russian (Ukraine)', 'Украина', 'ru', 'ru_UA', 0, 597, '2022-08-23 06:11:21', NULL, 1, NULL),
(598, 'Kinyarwanda', '', 'rw', 'rw', 0, 598, '2022-08-23 06:11:21', NULL, 1, NULL),
(599, 'Kinyarwanda (Rwanda)', 'U Rwanda', 'rw', 'rw_RW', 0, 599, '2022-08-23 06:11:21', NULL, 1, NULL),
(600, 'Rwa', '', 'rwk', 'rwk', 0, 600, '2022-08-23 06:11:21', NULL, 1, NULL),
(601, 'Rwa (Tanzania)', 'Tanzania', 'rwk', 'rwk_TZ', 0, 601, '2022-08-23 06:11:21', NULL, 1, NULL),
(602, 'Sakha', '', 'sah', 'sah', 0, 602, '2022-08-23 06:11:21', NULL, 1, NULL),
(603, 'Sakha (Russia)', 'Арассыыйа', 'sah', 'sah_RU', 0, 603, '2022-08-23 06:11:21', NULL, 1, NULL),
(604, 'Samburu', '', 'saq', 'saq', 0, 604, '2022-08-23 06:11:21', NULL, 1, NULL),
(605, 'Samburu (Kenya)', 'Kenya', 'saq', 'saq_KE', 0, 605, '2022-08-23 06:11:21', NULL, 1, NULL),
(606, 'Sangu', '', 'sbp', 'sbp', 0, 606, '2022-08-23 06:11:21', NULL, 1, NULL),
(607, 'Sangu (Tanzania)', 'Tansaniya', 'sbp', 'sbp_TZ', 0, 607, '2022-08-23 06:11:21', NULL, 1, NULL),
(608, 'Sindhi', '', 'sd', 'sd', 0, 608, '2022-08-23 06:11:21', NULL, 1, NULL),
(609, 'Sindhi (Pakistan)', 'پاڪستان', 'sd', 'sd_PK', 0, 609, '2022-08-23 06:11:21', NULL, 1, NULL),
(610, 'Northern Sami', '', 'se', 'se', 0, 610, '2022-08-23 06:11:21', NULL, 1, NULL),
(611, 'Northern Sami (Finland)', 'Suopma', 'se', 'se_FI', 0, 611, '2022-08-23 06:11:21', NULL, 1, NULL),
(612, 'Northern Sami (Norway)', 'Norga', 'se', 'se_NO', 0, 612, '2022-08-23 06:11:21', NULL, 1, NULL),
(613, 'Northern Sami (Sweden)', 'Ruoŧŧa', 'se', 'se_SE', 0, 613, '2022-08-23 06:11:21', NULL, 1, NULL),
(614, 'Sena', '', 'seh', 'seh', 0, 614, '2022-08-23 06:11:21', NULL, 1, NULL),
(615, 'Sena (Mozambique)', 'Moçambique', 'seh', 'seh_MZ', 0, 615, '2022-08-23 06:11:21', NULL, 1, NULL),
(616, 'Koyraboro Senni', '', 'ses', 'ses', 0, 616, '2022-08-23 06:11:21', NULL, 1, NULL),
(617, 'Koyraboro Senni (Mali)', 'Maali', 'ses', 'ses_ML', 0, 617, '2022-08-23 06:11:21', NULL, 1, NULL),
(618, 'Sango', '', 'sg', 'sg', 0, 618, '2022-08-23 06:11:21', NULL, 1, NULL),
(619, 'Sango (Central African Republic)', 'Ködörösêse tî Bêafrîka', 'sg', 'sg_CF', 0, 619, '2022-08-23 06:11:21', NULL, 1, NULL),
(620, 'Tachelhit', '', 'shi', 'shi', 0, 620, '2022-08-23 06:11:21', NULL, 1, NULL),
(621, 'Tachelhit (Latin)', '', 'shi', 'shi_Latn', 0, 621, '2022-08-23 06:11:21', NULL, 1, NULL),
(622, 'Tachelhit (Latin, Morocco)', 'lmɣrib', 'shi', 'shi_Latn_MA', 0, 622, '2022-08-23 06:11:21', NULL, 1, NULL),
(623, 'Tachelhit (Tifinagh)', '', 'shi', 'shi_Tfng', 0, 623, '2022-08-23 06:11:21', NULL, 1, NULL),
(624, 'Tachelhit (Tifinagh, Morocco)', 'ⵍⵎⵖⵔⵉⴱ', 'shi', 'shi_Tfng_MA', 0, 624, '2022-08-23 06:11:21', NULL, 1, NULL),
(625, 'Sinhala', '', 'si', 'si', 0, 625, '2022-08-23 06:11:21', NULL, 1, NULL),
(626, 'Sinhala (Sri Lanka)', 'ශ්‍රී ලංකාව', 'si', 'si_LK', 0, 626, '2022-08-23 06:11:21', NULL, 1, NULL),
(627, 'Slovak', '', 'sk', 'sk', 1, 627, '2022-08-23 06:11:21', NULL, 1, NULL),
(628, 'Slovak (Slovakia)', 'Slovensko', 'sk', 'sk_SK', 0, 628, '2022-08-23 06:11:21', NULL, 1, NULL),
(629, 'Slovenian', '', 'sl', 'sl', 0, 629, '2022-08-23 06:11:21', NULL, 1, NULL),
(630, 'Slovenian (Slovenia)', 'Slovenija', 'sl', 'sl_SI', 0, 630, '2022-08-23 06:11:21', NULL, 1, NULL),
(631, 'Inari Sami', '', 'smn', 'smn', 0, 631, '2022-08-23 06:11:21', NULL, 1, NULL),
(632, 'Inari Sami (Finland)', 'Suomâ', 'smn', 'smn_FI', 0, 632, '2022-08-23 06:11:21', NULL, 1, NULL),
(633, 'Shona', '', 'sn', 'sn', 0, 633, '2022-08-23 06:11:21', NULL, 1, NULL),
(634, 'Shona (Zimbabwe)', 'Zimbabwe', 'sn', 'sn_ZW', 0, 634, '2022-08-23 06:11:21', NULL, 1, NULL),
(635, 'Somali', '', 'so', 'so', 0, 635, '2022-08-23 06:11:21', NULL, 1, NULL),
(636, 'Somali (Djibouti)', 'Jabuuti', 'so', 'so_DJ', 0, 636, '2022-08-23 06:11:21', NULL, 1, NULL),
(637, 'Somali (Ethiopia)', 'Itoobiya', 'so', 'so_ET', 0, 637, '2022-08-23 06:11:21', NULL, 1, NULL),
(638, 'Somali (Kenya)', 'Kenya', 'so', 'so_KE', 0, 638, '2022-08-23 06:11:21', NULL, 1, NULL),
(639, 'Somali (Somalia)', 'Soomaaliya', 'so', 'so_SO', 0, 639, '2022-08-23 06:11:21', NULL, 1, NULL),
(640, 'Albanian', '', 'sq', 'sq', 0, 640, '2022-08-23 06:11:21', NULL, 1, NULL),
(641, 'Albanian (Albania)', 'Shqipëri', 'sq', 'sq_AL', 0, 641, '2022-08-23 06:11:21', NULL, 1, NULL),
(642, 'Albanian (North Macedonia)', 'Maqedonia e Veriut', 'sq', 'sq_MK', 0, 642, '2022-08-23 06:11:21', NULL, 1, NULL),
(643, 'Albanian (Kosovo)', 'Kosovë', 'sq', 'sq_XK', 0, 643, '2022-08-23 06:11:21', NULL, 1, NULL),
(644, 'Serbian', '', 'sr', 'sr', 0, 644, '2022-08-23 06:11:21', NULL, 1, NULL),
(645, 'Serbian (Cyrillic)', '', 'sr', 'sr_Cyrl', 0, 645, '2022-08-23 06:11:21', NULL, 1, NULL),
(646, 'Serbian (Cyrillic, Bosnia & Herzegovina)', 'Босна и Херцеговина', 'sr', 'sr_Cyrl_BA', 0, 646, '2022-08-23 06:11:21', NULL, 1, NULL),
(647, 'Serbian (Cyrillic, Montenegro)', 'Црна Гора', 'sr', 'sr_Cyrl_ME', 0, 647, '2022-08-23 06:11:21', NULL, 1, NULL),
(648, 'Serbian (Cyrillic, Serbia)', 'Србија', 'sr', 'sr_Cyrl_RS', 0, 648, '2022-08-23 06:11:21', NULL, 1, NULL),
(649, 'Serbian (Cyrillic, Kosovo)', 'Косово', 'sr', 'sr_Cyrl_XK', 0, 649, '2022-08-23 06:11:21', NULL, 1, NULL),
(650, 'Serbian (Latin)', '', 'sr', 'sr_Latn', 0, 650, '2022-08-23 06:11:21', NULL, 1, NULL),
(651, 'Serbian (Latin, Bosnia & Herzegovina)', 'Bosna i Hercegovina', 'sr', 'sr_Latn_BA', 0, 651, '2022-08-23 06:11:21', NULL, 1, NULL),
(652, 'Serbian (Latin, Montenegro)', 'Crna Gora', 'sr', 'sr_Latn_ME', 0, 652, '2022-08-23 06:11:21', NULL, 1, NULL),
(653, 'Serbian (Latin, Serbia)', 'Srbija', 'sr', 'sr_Latn_RS', 0, 653, '2022-08-23 06:11:21', NULL, 1, NULL),
(654, 'Serbian (Latin, Kosovo)', 'Kosovo', 'sr', 'sr_Latn_XK', 0, 654, '2022-08-23 06:11:21', NULL, 1, NULL),
(655, 'Swedish', '', 'sv', 'sv', 0, 655, '2022-08-23 06:11:21', NULL, 1, NULL),
(656, 'Swedish (Åland Islands)', 'Åland', 'sv', 'sv_AX', 0, 656, '2022-08-23 06:11:21', NULL, 1, NULL),
(657, 'Swedish (Finland)', 'Finland', 'sv', 'sv_FI', 0, 657, '2022-08-23 06:11:21', NULL, 1, NULL),
(658, 'Swedish (Sweden)', 'Sverige', 'sv', 'sv_SE', 0, 658, '2022-08-23 06:11:21', NULL, 1, NULL),
(659, 'Swahili', '', 'sw', 'sw', 0, 659, '2022-08-23 06:11:21', NULL, 1, NULL),
(660, 'Swahili (Congo - Kinshasa)', 'Jamhuri ya Kidemokrasia ya Kongo', 'sw', 'sw_CD', 0, 660, '2022-08-23 06:11:21', NULL, 1, NULL),
(661, 'Swahili (Kenya)', 'Kenya', 'sw', 'sw_KE', 0, 661, '2022-08-23 06:11:21', NULL, 1, NULL),
(662, 'Swahili (Tanzania)', 'Tanzania', 'sw', 'sw_TZ', 0, 662, '2022-08-23 06:11:21', NULL, 1, NULL),
(663, 'Swahili (Uganda)', 'Uganda', 'sw', 'sw_UG', 0, 663, '2022-08-23 06:11:21', NULL, 1, NULL),
(664, 'Tamil', '', 'ta', 'ta', 0, 664, '2022-08-23 06:11:21', NULL, 1, NULL),
(665, 'Tamil (India)', 'இந்தியா', 'ta', 'ta_IN', 0, 665, '2022-08-23 06:11:21', NULL, 1, NULL),
(666, 'Tamil (Sri Lanka)', 'இலங்கை', 'ta', 'ta_LK', 0, 666, '2022-08-23 06:11:21', NULL, 1, NULL),
(667, 'Tamil (Malaysia)', 'மலேசியா', 'ta', 'ta_MY', 0, 667, '2022-08-23 06:11:21', NULL, 1, NULL),
(668, 'Tamil (Singapore)', 'சிங்கப்பூர்', 'ta', 'ta_SG', 0, 668, '2022-08-23 06:11:21', NULL, 1, NULL),
(669, 'Telugu', '', 'te', 'te', 0, 669, '2022-08-23 06:11:21', NULL, 1, NULL),
(670, 'Telugu (India)', 'భారతదేశం', 'te', 'te_IN', 0, 670, '2022-08-23 06:11:21', NULL, 1, NULL),
(671, 'Teso', '', 'teo', 'teo', 0, 671, '2022-08-23 06:11:21', NULL, 1, NULL),
(672, 'Teso (Kenya)', 'Kenia', 'teo', 'teo_KE', 0, 672, '2022-08-23 06:11:21', NULL, 1, NULL),
(673, 'Teso (Uganda)', 'Uganda', 'teo', 'teo_UG', 0, 673, '2022-08-23 06:11:21', NULL, 1, NULL),
(674, 'Tajik', '', 'tg', 'tg', 0, 674, '2022-08-23 06:11:21', NULL, 1, NULL),
(675, 'Tajik (Tajikistan)', 'Тоҷикистон', 'tg', 'tg_TJ', 0, 675, '2022-08-23 06:11:21', NULL, 1, NULL),
(676, 'Thai', '', 'th', 'th', 0, 676, '2022-08-23 06:11:21', NULL, 1, NULL),
(677, 'Thai (Thailand)', 'ไทย', 'th', 'th_TH', 0, 677, '2022-08-23 06:11:21', NULL, 1, NULL),
(678, 'Tigrinya', '', 'ti', 'ti', 0, 678, '2022-08-23 06:11:21', NULL, 1, NULL),
(679, 'Tigrinya (Eritrea)', 'ኤርትራ', 'ti', 'ti_ER', 0, 679, '2022-08-23 06:11:21', NULL, 1, NULL),
(680, 'Tigrinya (Ethiopia)', 'ኢትዮጵያ', 'ti', 'ti_ET', 0, 680, '2022-08-23 06:11:21', NULL, 1, NULL),
(681, 'Turkmen', '', 'tk', 'tk', 0, 681, '2022-08-23 06:11:21', NULL, 1, NULL),
(682, 'Turkmen (Turkmenistan)', 'Türkmenistan', 'tk', 'tk_TM', 0, 682, '2022-08-23 06:11:21', NULL, 1, NULL),
(683, 'Tongan', '', 'to', 'to', 0, 683, '2022-08-23 06:11:21', NULL, 1, NULL),
(684, 'Tongan (Tonga)', 'Tonga', 'to', 'to_TO', 0, 684, '2022-08-23 06:11:21', NULL, 1, NULL),
(685, 'Turkish', '', 'tr', 'tr', 0, 685, '2022-08-23 06:11:21', NULL, 1, NULL),
(686, 'Turkish (Cyprus)', 'Kıbrıs', 'tr', 'tr_CY', 0, 686, '2022-08-23 06:11:21', NULL, 1, NULL),
(687, 'Turkish (Turkey)', 'Türkiye', 'tr', 'tr_TR', 0, 687, '2022-08-23 06:11:21', NULL, 1, NULL),
(688, 'Tatar', '', 'tt', 'tt', 0, 688, '2022-08-23 06:11:21', NULL, 1, NULL),
(689, 'Tatar (Russia)', 'Россия', 'tt', 'tt_RU', 0, 689, '2022-08-23 06:11:21', NULL, 1, NULL),
(690, 'Tasawaq', '', 'twq', 'twq', 0, 690, '2022-08-23 06:11:21', NULL, 1, NULL),
(691, 'Tasawaq (Niger)', 'Nižer', 'twq', 'twq_NE', 0, 691, '2022-08-23 06:11:21', NULL, 1, NULL),
(692, 'Central Atlas Tamazight', '', 'tzm', 'tzm', 0, 692, '2022-08-23 06:11:21', NULL, 1, NULL),
(693, 'Central Atlas Tamazight (Morocco)', 'Meṛṛuk', 'tzm', 'tzm_MA', 0, 693, '2022-08-23 06:11:21', NULL, 1, NULL),
(694, 'Uyghur', '', 'ug', 'ug', 0, 694, '2022-08-23 06:11:21', NULL, 1, NULL),
(695, 'Uyghur (China)', 'جۇڭگو', 'ug', 'ug_CN', 0, 695, '2022-08-23 06:11:21', NULL, 1, NULL),
(696, 'Ukrainian', '', 'uk', 'uk', 0, 696, '2022-08-23 06:11:21', NULL, 1, NULL),
(697, 'Ukrainian (Ukraine)', 'Україна', 'uk', 'uk_UA', 0, 697, '2022-08-23 06:11:21', NULL, 1, NULL),
(698, 'Urdu', '', 'ur', 'ur', 0, 698, '2022-08-23 06:11:21', NULL, 1, NULL),
(699, 'Urdu (India)', 'بھارت', 'ur', 'ur_IN', 0, 699, '2022-08-23 06:11:21', NULL, 1, NULL),
(700, 'Urdu (Pakistan)', 'پاکستان', 'ur', 'ur_PK', 0, 700, '2022-08-23 06:11:21', NULL, 1, NULL),
(701, 'Uzbek', '', 'uz', 'uz', 0, 701, '2022-08-23 06:11:21', NULL, 1, NULL),
(702, 'Uzbek (Arabic)', '', 'uz', 'uz_Arab', 0, 702, '2022-08-23 06:11:21', NULL, 1, NULL),
(703, 'Uzbek (Arabic, Afghanistan)', 'افغانستان', 'uz', 'uz_Arab_AF', 0, 703, '2022-08-23 06:11:21', NULL, 1, NULL),
(704, 'Uzbek (Cyrillic)', '', 'uz', 'uz_Cyrl', 0, 704, '2022-08-23 06:11:21', NULL, 1, NULL),
(705, 'Uzbek (Cyrillic, Uzbekistan)', 'Ўзбекистон', 'uz', 'uz_Cyrl_UZ', 0, 705, '2022-08-23 06:11:21', NULL, 1, NULL),
(706, 'Uzbek (Latin)', '', 'uz', 'uz_Latn', 0, 706, '2022-08-23 06:11:21', NULL, 1, NULL),
(707, 'Uzbek (Latin, Uzbekistan)', 'Oʻzbekiston', 'uz', 'uz_Latn_UZ', 0, 707, '2022-08-23 06:11:21', NULL, 1, NULL),
(708, 'Vai', '', 'vai', 'vai', 0, 708, '2022-08-23 06:11:21', NULL, 1, NULL),
(709, 'Vai (Latin)', '', 'vai', 'vai_Latn', 0, 709, '2022-08-23 06:11:21', NULL, 1, NULL),
(710, 'Vai (Latin, Liberia)', 'Laibhiya', 'vai', 'vai_Latn_LR', 0, 710, '2022-08-23 06:11:21', NULL, 1, NULL),
(711, 'Vai (Vai)', '', 'vai', 'vai_Vaii', 0, 711, '2022-08-23 06:11:21', NULL, 1, NULL),
(712, 'Vai (Vai, Liberia)', 'ꕞꔤꔫꕩ', 'vai', 'vai_Vaii_LR', 0, 712, '2022-08-23 06:11:21', NULL, 1, NULL),
(713, 'Vietnamese', '', 'vi', 'vi', 0, 713, '2022-08-23 06:11:21', NULL, 1, NULL),
(714, 'Vietnamese (Vietnam)', 'Việt Nam', 'vi', 'vi_VN', 0, 714, '2022-08-23 06:11:21', NULL, 1, NULL),
(715, 'Vunjo', '', 'vun', 'vun', 0, 715, '2022-08-23 06:11:21', NULL, 1, NULL),
(716, 'Vunjo (Tanzania)', 'Tanzania', 'vun', 'vun_TZ', 0, 716, '2022-08-23 06:11:21', NULL, 1, NULL),
(717, 'Walser', '', 'wae', 'wae', 0, 717, '2022-08-23 06:11:21', NULL, 1, NULL),
(718, 'Walser (Switzerland)', 'Schwiz', 'wae', 'wae_CH', 0, 718, '2022-08-23 06:11:21', NULL, 1, NULL),
(719, 'Wolof', '', 'wo', 'wo', 0, 719, '2022-08-23 06:11:21', NULL, 1, NULL),
(720, 'Wolof (Senegal)', 'Senegaal', 'wo', 'wo_SN', 0, 720, '2022-08-23 06:11:21', NULL, 1, NULL),
(721, 'Xhosa', '', 'xh', 'xh', 0, 721, '2022-08-23 06:11:21', NULL, 1, NULL),
(722, 'Xhosa (South Africa)', 'eMzantsi Afrika', 'xh', 'xh_ZA', 0, 722, '2022-08-23 06:11:21', NULL, 1, NULL),
(723, 'Soga', '', 'xog', 'xog', 0, 723, '2022-08-23 06:11:21', NULL, 1, NULL),
(724, 'Soga (Uganda)', 'Yuganda', 'xog', 'xog_UG', 0, 724, '2022-08-23 06:11:21', NULL, 1, NULL),
(725, 'Yangben', '', 'yav', 'yav', 0, 725, '2022-08-23 06:11:21', NULL, 1, NULL),
(726, 'Yangben (Cameroon)', 'Kemelún', 'yav', 'yav_CM', 0, 726, '2022-08-23 06:11:21', NULL, 1, NULL),
(727, 'Yiddish', '', 'yi', 'yi', 0, 727, '2022-08-23 06:11:21', NULL, 1, NULL),
(728, 'Yiddish (World)', 'וועלט', 'yi', 'yi_001', 0, 728, '2022-08-23 06:11:21', NULL, 1, NULL),
(729, 'Yoruba', '', 'yo', 'yo', 0, 729, '2022-08-23 06:11:21', NULL, 1, NULL),
(730, 'Yoruba (Benin)', 'Orílɛ́ède Bɛ̀nɛ̀', 'yo', 'yo_BJ', 0, 730, '2022-08-23 06:11:21', NULL, 1, NULL),
(731, 'Yoruba (Nigeria)', 'Orilẹ̀-èdè Nàìjíríà', 'yo', 'yo_NG', 0, 731, '2022-08-23 06:11:21', NULL, 1, NULL),
(732, 'Cantonese', '', 'yue', 'yue', 0, 732, '2022-08-23 06:11:21', NULL, 1, NULL),
(733, 'Cantonese (Simplified)', '', 'yue', 'yue_Hans', 0, 733, '2022-08-23 06:11:21', NULL, 1, NULL),
(734, 'Cantonese (Simplified, China)', '中华人民共和国', 'yue', 'yue_Hans_CN', 0, 734, '2022-08-23 06:11:21', NULL, 1, NULL),
(735, 'Cantonese (Traditional)', '', 'yue', 'yue_Hant', 0, 735, '2022-08-23 06:11:21', NULL, 1, NULL),
(736, 'Cantonese (Traditional, Hong Kong SAR China)', '中華人民共和國香港特別行政區', 'yue', 'yue_Hant_HK', 0, 736, '2022-08-23 06:11:21', NULL, 1, NULL),
(737, 'Standard Moroccan Tamazight', '', 'zgh', 'zgh', 0, 737, '2022-08-23 06:11:21', NULL, 1, NULL),
(738, 'Standard Moroccan Tamazight (Morocco)', 'ⵍⵎⵖⵔⵉⴱ', 'zgh', 'zgh_MA', 0, 738, '2022-08-23 06:11:21', NULL, 1, NULL),
(739, 'Chinese', '', 'zh', 'zh', 1, 739, '2022-08-23 06:11:21', NULL, 1, NULL),
(740, 'Chinese (Simplified)', '', 'zh', 'zh_Hans', 0, 740, '2022-08-23 06:11:21', NULL, 1, NULL),
(741, 'Chinese (Simplified, China)', '中国', 'zh', 'zh_Hans_CN', 0, 741, '2022-08-23 06:11:21', NULL, 1, NULL),
(742, 'Chinese (Simplified, Hong Kong SAR China)', '中国香港特别行政区', 'zh', 'zh_Hans_HK', 0, 742, '2022-08-23 06:11:21', NULL, 1, NULL),
(743, 'Chinese (Simplified, Macao SAR China)', '中国澳门特别行政区', 'zh', 'zh_Hans_MO', 0, 743, '2022-08-23 06:11:21', NULL, 1, NULL),
(744, 'Chinese (Simplified, Singapore)', '新加坡', 'zh', 'zh_Hans_SG', 0, 744, '2022-08-23 06:11:21', NULL, 1, NULL),
(745, 'Chinese (Traditional)', '', 'zh', 'zh_Hant', 0, 745, '2022-08-23 06:11:21', NULL, 1, NULL),
(746, 'Chinese (Traditional, Hong Kong SAR China)', '中國香港特別行政區', 'zh', 'zh_Hant_HK', 0, 746, '2022-08-23 06:11:21', NULL, 1, NULL),
(747, 'Chinese (Traditional, Macao SAR China)', '中國澳門特別行政區', 'zh', 'zh_Hant_MO', 0, 747, '2022-08-23 06:11:21', NULL, 1, NULL),
(748, 'Chinese (Traditional, Taiwan)', '台灣', 'zh', 'zh_Hant_TW', 0, 748, '2022-08-23 06:11:21', NULL, 1, NULL),
(749, 'Zulu', '', 'zu', 'zu', 0, 749, '2022-08-23 06:11:21', NULL, 1, NULL),
(750, 'Zulu (South Africa)', 'iNingizimu Afrika', 'zu', 'zu_ZA', 0, 750, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `parent_id` int(20) DEFAULT NULL,
  `menu_id` int(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `rel` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `visibility_roles` text DEFAULT NULL,
  `params` text DEFAULT NULL,
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `parent_id`, `menu_id`, `title`, `class`, `description`, `link`, `target`, `rel`, `status`, `lft`, `rght`, `visibility_roles`, `params`, `publish_start`, `publish_end`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(5, NULL, 4, 'About', 'about', '', 'plugin:Croogo%2fNodes/controller:Nodes/action:view/type:page/slug:about', '', '', 1, 3, 4, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(6, NULL, 4, 'Contact', 'contact', '', 'plugin:Croogo%2fContacts/controller:Contacts/action:view/contact', '', '', 1, 5, 6, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(7, NULL, 3, 'Home', 'home', '', 'plugin:Croogo%2fNodes/controller:Nodes/action:promoted', '', '', 1, 5, 6, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(8, NULL, 3, 'About', 'about', '', 'plugin:Croogo%2fNodes/controller:Nodes/action:view/type:page/slug:about', '', '', 1, 7, 10, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(9, 8, 3, 'Child link', 'child-link', '', '#', '', '', 0, 8, 9, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(10, NULL, 5, 'Site Admin', 'site-admin', '', '/admin', '', '', 1, 1, 2, '[\"2\",\"3\"]', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(11, NULL, 5, 'Log out', 'log-out', '', '/plugin:Croogo%2fUsers/controller:Users/action:logout', '', '', 1, 7, 8, '[\"1\",\"3\",\"4\",\"5\"]', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(12, NULL, 6, 'Croogo', 'croogo', '', 'http://www.croogo.org', '', '', 1, 3, 4, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(14, NULL, 6, 'CakePHP', 'cakephp', '', 'http://www.cakephp.org', '', '', 1, 1, 2, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(15, NULL, 3, 'Contact', 'contact', '', '/plugin:Croogo%2fContacts/controller:Contacts/action:view/contact', '', '', 1, 11, 12, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(16, NULL, 5, 'Entries (RSS)', 'entries-rss', '', 'plugin:Croogo%2fNodes/controller:Nodes/action:feed/_ext:rss', '', '', 1, 3, 4, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(17, NULL, 5, 'Comments (RSS)', 'comments-rss', '', 'plugin:Croogo%2fComments/controller:Comments/action:index/_ext:rss', '', '', 0, 5, 6, '', '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `link_count` int(11) NOT NULL DEFAULT 0,
  `params` text DEFAULT NULL,
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `alias`, `class`, `description`, `status`, `weight`, `link_count`, `params`, `publish_start`, `publish_end`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(3, 'Main Menu', 'main', '', '', 1, NULL, 4, '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(4, 'Footer', 'footer', '', '', 1, NULL, 2, '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(5, 'Meta', 'meta', '', '', 1, NULL, 4, '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(6, 'Blogroll', 'blogroll', '', '', 1, NULL, 2, '', NULL, NULL, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `message_type` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `modified_by` int(20) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE `meta` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL DEFAULT 'Node',
  `foreign_key` int(20) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meta`
--

INSERT INTO `meta` (`id`, `model`, `foreign_key`, `key`, `value`, `weight`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, '', NULL, 'meta_description', 'Croogo - A CakePHP powered Content Management System', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(2, '', NULL, 'meta_generator', 'Croogo - Content Management System', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(3, '', NULL, 'meta_robots', 'index, follow', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(4, 'Croogo/Nodes.Nodes', 1, 'meta_keywords', 'key1, key2', NULL, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `model_taxonomies`
--

CREATE TABLE `model_taxonomies` (
  `id` int(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `foreign_key` int(20) NOT NULL,
  `taxonomy_id` int(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `model_taxonomies`
--

INSERT INTO `model_taxonomies` (`id`, `model`, `foreign_key`, `taxonomy_id`, `created`, `modified`) VALUES
(1, 'Croogo/Nodes.Nodes', 1, 1, '2022-08-23 06:11:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE `nodes` (
  `id` int(11) NOT NULL,
  `parent_id` int(20) DEFAULT NULL,
  `user_id` int(20) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `excerpt` text DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `comment_status` int(1) NOT NULL DEFAULT 1,
  `comment_count` int(11) DEFAULT 0,
  `promote` tinyint(1) NOT NULL DEFAULT 0,
  `path` varchar(255) NOT NULL,
  `terms` text DEFAULT NULL,
  `sticky` tinyint(1) NOT NULL DEFAULT 0,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `visibility_roles` text DEFAULT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'post',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`id`, `parent_id`, `user_id`, `title`, `slug`, `body`, `excerpt`, `status`, `mime_type`, `comment_status`, `comment_count`, `promote`, `path`, `terms`, `sticky`, `lft`, `rght`, `visibility_roles`, `type`, `created_by`, `modified_by`, `publish_start`, `publish_end`, `created`, `modified`) VALUES
(1, NULL, 1, 'Hello World', 'hello-world', '<p>Welcome to Croogo. This is your first post. You can edit or delete it from the admin panel.</p>', '', 1, '', 2, 1, 1, '/blog/hello-world', '{\"1\":\"uncategorized\"}', 0, 1, 2, '', 'blog', 1, NULL, NULL, NULL, '2022-08-23 06:11:21', NULL),
(2, NULL, 1, 'About', 'about', '<p>This is an example of a Croogo page, you could edit this to put information about yourself or your site.</p>', '', 1, '', 0, 0, 0, '/about', '', 0, 1, 2, '', 'page', 1, NULL, NULL, NULL, '2022-08-23 06:11:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `payroll_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `user_ids` varchar(255) DEFAULT NULL,
  `employees_designation_ids` varchar(255) DEFAULT NULL,
  `config_action_id` varchar(255) NOT NULL,
  `attandance` int(1) DEFAULT NULL,
  `attandance_grace` varchar(255) DEFAULT NULL,
  `late_cut` varchar(255) DEFAULT NULL,
  `cut_from` varchar(255) DEFAULT NULL,
  `absent` int(1) DEFAULT NULL,
  `absent_cut` varchar(255) DEFAULT NULL,
  `absent_cut_from` varchar(255) DEFAULT NULL,
  `overtime` int(1) DEFAULT NULL,
  `payment` varchar(255) NOT NULL DEFAULT 'Not Paid',
  `created_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` int(1) NOT NULL DEFAULT 0,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`payroll_id`, `type`, `year`, `month`, `user_ids`, `employees_designation_ids`, `config_action_id`, `attandance`, `attandance_grace`, `late_cut`, `cut_from`, `absent`, `absent_cut`, `absent_cut_from`, `overtime`, `payment`, `created_by`, `create_date`, `deleted`, `deleted_by`) VALUES
(1, 'Full', '2022', 'january', NULL, NULL, '', NULL, '', '', 'basic', NULL, '', 'basic', NULL, 'Not Paid', 1, '2022-06-09 05:20:03', 0, NULL),
(2, 'Full', '2022', 'October', NULL, NULL, '[\"1\",\"2\",\"5\",\"6\"]', NULL, '', '', NULL, NULL, '', NULL, NULL, 'Not Paid', 1, '2022-10-08 10:44:34', 0, NULL),
(3, 'Full', '2022', 'October', NULL, NULL, '[\"1\",\"2\",\"5\",\"6\"]', NULL, '', '', NULL, NULL, '', NULL, NULL, 'Paid', 1, '2022-10-08 10:48:29', 0, NULL),
(4, 'Full', '2022', 'September', NULL, NULL, '[\"1\",\"2\",\"5\",\"6\"]', NULL, '', '', NULL, NULL, '', NULL, NULL, 'Not Paid', 1, '2022-10-08 11:56:44', 0, NULL),
(5, 'Full', '2022', 'October', NULL, NULL, '[\"1\",\"2\",\"5\",\"6\"]', NULL, '', '', NULL, NULL, '', NULL, NULL, 'Not Paid', 1, '2022-10-08 11:58:58', 0, NULL),
(6, 'Full', '2022', 'September', NULL, NULL, '[\"1\",\"2\",\"5\",\"6\"]', NULL, '', '', NULL, NULL, '', NULL, NULL, 'Not Paid', 1, '2022-10-08 12:11:10', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_config`
--

CREATE TABLE `payroll_config` (
  `id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `config_action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_config_employee`
--

CREATE TABLE `payroll_config_employee` (
  `payroll_config_employee_id` int(11) NOT NULL,
  `payroll_config_id` int(11) NOT NULL,
  `employee_person_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_employee`
--

CREATE TABLE `payroll_employee` (
  `payroll_employee_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `basic_salary` varchar(255) DEFAULT NULL,
  `total_allowances` varchar(255) DEFAULT NULL,
  `total_bonus` varchar(255) DEFAULT NULL,
  `total_penalty` varchar(255) DEFAULT NULL,
  `late` varchar(255) DEFAULT NULL,
  `late_cut` varchar(255) DEFAULT NULL,
  `absent` varchar(255) DEFAULT NULL,
  `absent_cut` varchar(255) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `leaves` varchar(255) DEFAULT NULL,
  `overtime_hours` varchar(11) DEFAULT NULL,
  `overtime_amount` varchar(11) DEFAULT NULL,
  `payment` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll_employee`
--

INSERT INTO `payroll_employee` (`payroll_employee_id`, `payroll_id`, `user_id`, `basic_salary`, `total_allowances`, `total_bonus`, `total_penalty`, `late`, `late_cut`, `absent`, `absent_cut`, `payment_id`, `leaves`, `overtime_hours`, `overtime_amount`, `payment`) VALUES
(1, 3, 1, '10000', '6000', '0', '0', '0', '0', '0', '0', 2, '0', '0', '0', 1),
(2, 3, 7, '0', '0', '0', '0', '0', '0', '0', '0', 2, '0', '0', '0', 1),
(3, 3, 8, '0', '0', '0', '0', '0', '0', '0', '0', 2, '0', '0', '0', 1),
(4, 4, 1, '10000', '6000', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(5, 4, 7, '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(6, 4, 8, '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(7, 5, 1, '10000', '6000', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(8, 5, 7, '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(9, 5, 8, '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(10, 6, 1, '10000', '6000', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(11, 6, 7, '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0),
(12, 6, 8, '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_payments`
--

CREATE TABLE `payroll_payments` (
  `payroll_payment_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `amount` decimal(23,10) NOT NULL,
  `date` varchar(255) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `payment_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll_payments`
--

INSERT INTO `payroll_payments` (`payroll_payment_id`, `payroll_id`, `amount`, `date`, `bank_id`, `comment`, `payment_by`, `created_date`) VALUES
(1, 3, '16000.0000000000', '2022-10-08', 1, '', 1, '2022-10-08 10:49:21'),
(2, 3, '16000.0000000000', '2022-10-08', 1, '', 1, '2022-10-08 10:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `block_count` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `modified_by` int(20) DEFAULT NULL,
  `created_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `title`, `alias`, `description`, `block_count`, `created`, `modified`, `modified_by`, `created_by`) VALUES
(3, 'none', 'none', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(4, 'right', 'right', '', 6, '2022-08-23 06:11:21', NULL, NULL, 1),
(6, 'left', 'left', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(7, 'header', 'header', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(8, 'footer', 'footer', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(9, 'region1', 'region1', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(10, 'region2', 'region2', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(11, 'region3', 'region3', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(12, 'region4', 'region4', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(13, 'region5', 'region5', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(14, 'region6', 'region6', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(15, 'region7', 'region7', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(16, 'region8', 'region8', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1),
(17, 'region9', 'region9', '', 0, '2022-08-23 06:11:21', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `alias`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'SuperAdmin', 'superadmin', '2022-08-23 06:11:21', NULL, 1, 1),
(2, 'Public', 'public', '2022-08-23 06:11:21', NULL, 1, 1),
(3, 'Registered', 'registered', '2022-08-23 06:11:21', NULL, 1, 1),
(4, 'Admin', 'admin', '2022-08-23 06:11:21', NULL, 1, 1),
(5, 'Publisher', 'publisher', '2022-08-23 06:11:21', NULL, 1, 1),
(6, 'Teacher', 'teacher', '2022-08-24 06:01:01', NULL, 1, 1),
(7, 'Staffs', 'staffs', '2022-09-05 07:06:29', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE `roles_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `granted_by` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_attendance`
--

CREATE TABLE `scms_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_cycle_id` int(11) DEFAULT NULL,
  `student_course_cycle_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_attendance_log`
--

CREATE TABLE `scms_attendance_log` (
  `attendance_log_id` int(11) NOT NULL,
  `courses_cycle_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_courses`
--

CREATE TABLE `scms_courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_courses_cycle`
--

CREATE TABLE `scms_courses_cycle` (
  `courses_cycle_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_course_type`
--

CREATE TABLE `scms_course_type` (
  `course_type_id` int(11) NOT NULL,
  `course_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scms_course_type`
--

INSERT INTO `scms_course_type` (`course_type_id`, `course_type_name`) VALUES
(1, 'Compulsory'),
(2, 'Extra'),
(3, 'optional');

-- --------------------------------------------------------

--
-- Table structure for table `scms_departments`
--

CREATE TABLE `scms_departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_faculty`
--

CREATE TABLE `scms_faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_groups`
--

CREATE TABLE `scms_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_guardians`
--

CREATE TABLE `scms_guardians` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('Male','Female','---') COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(20) CHARACTER SET utf8 NOT NULL,
  `occupation` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yearly_income` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rtype` enum('Father','Mother','Guardian','Other') COLLATE utf8_unicode_ci NOT NULL,
  `relation` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` enum('Islam','Hindu','Christian','Buddhist') COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 COLLATE=utf8_unicode_ci DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `scms_levels`
--

CREATE TABLE `scms_levels` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_sections`
--

CREATE TABLE `scms_sections` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_sessions`
--

CREATE TABLE `scms_sessions` (
  `session_id` int(11) NOT NULL,
  `session_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scms_sessions`
--

INSERT INTO `scms_sessions` (`session_id`, `session_name`) VALUES
(1, '2015-2016'),
(2, '2016-2017'),
(3, '2017-2018'),
(4, '2018-2019'),
(5, '2019-2020'),
(6, '2020-2021'),
(7, '2021-2022');

-- --------------------------------------------------------

--
-- Table structure for table `scms_shifts`
--

CREATE TABLE `scms_shifts` (
  `shift_id` int(11) NOT NULL,
  `shift_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scms_shifts`
--

INSERT INTO `scms_shifts` (`shift_id`, `shift_name`) VALUES
(1, 'Day');

-- --------------------------------------------------------

--
-- Table structure for table `scms_staffs`
--

CREATE TABLE `scms_staffs` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `phone_number` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_students`
--

CREATE TABLE `scms_students` (
  `id` int(11) NOT NULL,
  `sid` char(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Others') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` enum('Islam','Hindu','Christian','Buddhist') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `permanent_address` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_address` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `birth_registration` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(20) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `school_sessions` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `enrolled` date DEFAULT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_guardian_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scms_student_course_cycles`
--

CREATE TABLE `scms_student_course_cycles` (
  `student_course_cycles_id` int(11) NOT NULL,
  `student_cycle_id` int(11) NOT NULL,
  `courses_cycle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_student_cycles`
--

CREATE TABLE `scms_student_cycles` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `roll` int(10) NOT NULL,
  `start_fees_date` datetime DEFAULT NULL,
  `tuition_fee_status` varchar(20) DEFAULT NULL,
  `start_resident_fees_date` date DEFAULT NULL,
  `resedential` tinyint(1) DEFAULT NULL,
  `departmental` tinyint(1) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scms_teachers`
--

CREATE TABLE `scms_teachers` (
  `teacher_id` int(11) NOT NULL,
  `teachers_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(99) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_term`
--

CREATE TABLE `scms_term` (
  `term_id` int(11) NOT NULL,
  `term_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_term_course_cycle`
--

CREATE TABLE `scms_term_course_cycle` (
  `term_course_cycle_id` int(11) NOT NULL,
  `term_cycle_id` int(11) NOT NULL,
  `course_cycle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_term_course_cycle_part`
--

CREATE TABLE `scms_term_course_cycle_part` (
  `term_course_cycle_part_id` int(11) NOT NULL,
  `term_course_cycle_id` int(11) NOT NULL,
  `term_course_cycle_part_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scms_term_cycle`
--

CREATE TABLE `scms_term_cycle` (
  `term_cycle_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `input_type` varchar(255) NOT NULL DEFAULT 'text',
  `editable` tinyint(1) NOT NULL DEFAULT 1,
  `weight` int(11) DEFAULT NULL,
  `params` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `title`, `description`, `input_type`, `editable`, `weight`, `params`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Site.title', 'Croogo', '', '', '', 1, 1, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(2, 'Site.tagline', 'A CakePHP powered Content Management System.', '', '', 'textarea', 1, 2, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(3, 'Site.email', 'you@your-site.com', '', '', '', 1, 3, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(4, 'Site.status', '1', '', '', 'checkbox', 1, 6, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(5, 'Service.akismet_key', 'your-key', '', '', '', 1, 11, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(6, 'Service.recaptcha_public_key', 'your-public-key', '', '', '', 1, 12, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(7, 'Service.recaptcha_private_key', 'your-private-key', '', '', '', 1, 13, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(8, 'Service.akismet_url', 'http://your-blog.com', '', '', '', 1, 10, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(9, 'Site.theme', 'Croogo/Core', '', '', '', 0, 14, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(10, 'Site.feed_url', '', '', '', '', 0, 15, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(11, 'Reading.nodes_per_page', '5', '', '', '', 1, 16, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(12, 'Comment.level', '1', '', 'levels deep (threaded comments)', '', 1, 18, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(13, 'Comment.feed_limit', '10', '', 'number of comments to show in feed', '', 1, 19, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(14, 'Site.locale', 'en_US', '', '', 'text', 1, 20, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(15, 'Reading.date_time_format', 'EEE, MMM dd yyyy HH:mm:ss', '', '', '', 1, 21, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(16, 'Comment.date_time_format', 'MMM dd, yyyy', '', '', '', 1, 22, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(17, 'Site.timezone', 'UTC', '', 'Provide a valid timezone identifier as specified in https://php.net/manual/en/timezones.php', 'select', 1, 4, 'optionClass=Croogo/Settings.Timezones', '2022-08-23 06:11:21', NULL, 1, NULL),
(18, 'Hook.bootstraps', 'Croogo/Settings,Croogo/Contacts,Croogo/Nodes,Croogo/Meta,Croogo/Menus,Croogo/Users,Croogo/Blocks,Croogo/Taxonomy,Croogo/FileManager,Croogo/Wysiwyg,Croogo/Dashboards', '', '', '', 0, 23, '', '2022-08-23 06:11:21', NULL, 1, 1),
(19, 'Comment.email_notification', '1', 'Enable email notification', '', 'checkbox', 1, 24, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(20, 'Access Control.multiRole', '0', 'Enable Multiple Roles', '', 'checkbox', 1, 25, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(21, 'Access Control.rowLevel', '0', 'Row Level Access Control', '', 'checkbox', 1, 26, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(22, 'Access Control.autoLoginDuration', '+1 week', '\"Remember Me\" Duration', 'Eg: +1 day, +1 week. Leave empty to disable.', 'text', 1, 27, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(23, 'Access Control.models', '', 'Models with Row Level Acl', 'Select models to activate Row Level Access Control on', 'multiple', 1, 26, 'multiple=checkbox\noptions={\"Croogo/Nodes.Nodes\": \"Nodes\", \"Croogo/Blocks.Blocks\": \"Blocks\", \"Croogo/Menus.Menus\": \"Menus\", \"Croogo/Menus.Links\": \"Links\"}', '2022-08-23 06:11:21', NULL, 1, NULL),
(24, 'Site.ipWhitelist', '127.0.0.1', 'Whitelisted IP Addresses', 'Separate multiple IP addresses with comma', 'text', 1, 27, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(25, 'Site.asset_timestamp', 'force', 'Asset timestamp', 'Appends a timestamp which is last modified time of the particular file at the end of asset files URLs (CSS, JavaScript, Image). Useful to prevent visitors to visit the site with an outdated version of these files in their browser cache.', 'radio', 1, 28, 'options={\"0\": \"Disabled\", \"1\": \"Enabled in debug mode only\", \"force\": \"Always enabled\"}', '2022-08-23 06:11:21', NULL, 1, NULL),
(26, 'Site.admin_theme', 'Croogo/Core', 'Administration Theme', '', 'text', 1, 29, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(27, 'Site.home_url', '', 'Home Url', 'Default action for home page in link string format.', 'text', 1, 30, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(28, 'Croogo.version', '', 'Croogo Version', '', 'text', 0, 31, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(29, 'Croogo.appVersion', '', 'App Version', '', 'text', 0, 31, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(30, 'Theme.bgImagePath', '', 'Background Image', '', 'file', 1, 32, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(31, 'Access Control.splitSession', '', 'Separate front-end and admin session', '', 'checkbox', 1, 32, '', '2022-08-23 06:11:21', NULL, 1, NULL),
(32, 'Croogo.installed', '1', '', '', '', 0, 0, '', '2022-08-23 06:11:48', NULL, 1, 1),
(33, 'SMS', 'ON', '', '', 'text', 1, NULL, '', '2022-09-05 11:11:27', NULL, 1, 1),
(34, 'SMS Credit', '9971', '', '', 'text', 0, NULL, '', '2022-09-05 11:15:53', NULL, 1, 1),
(35, 'SMS Count', '4', '', '', 'text', 0, NULL, '', '2022-09-05 11:17:22', NULL, 1, 1),
(36, 'Attendance Sms Settings', 'both', '', '', 'text', 1, NULL, '', '2022-09-06 05:48:26', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_log`
--

CREATE TABLE `sms_log` (
  `sms_log_id` int(11) NOT NULL,
  `sms_count` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `sms` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `taxonomies`
--

CREATE TABLE `taxonomies` (
  `id` int(11) NOT NULL,
  `parent_id` int(20) DEFAULT NULL,
  `term_id` int(10) NOT NULL,
  `vocabulary_id` int(10) NOT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taxonomies`
--

INSERT INTO `taxonomies` (`id`, `parent_id`, `term_id`, `vocabulary_id`, `lft`, `rght`, `created`, `modified`) VALUES
(1, NULL, 1, 1, 1, 2, '2022-08-23 06:11:21', NULL),
(2, NULL, 2, 1, 3, 4, '2022-08-23 06:11:21', NULL),
(3, NULL, 3, 2, 1, 2, '2022-08-23 06:11:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `params` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `title`, `slug`, `description`, `params`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Uncategorized', 'uncategorized', '', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(2, 'Announcements', 'announcements', '', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(3, 'mytag', 'mytag', '', NULL, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `format_show_author` tinyint(1) NOT NULL DEFAULT 1,
  `format_show_date` tinyint(1) NOT NULL DEFAULT 1,
  `format_use_wysiwyg` tinyint(1) NOT NULL DEFAULT 1,
  `comment_status` int(1) NOT NULL DEFAULT 1,
  `comment_approve` tinyint(1) NOT NULL DEFAULT 1,
  `comment_spam_protection` tinyint(1) NOT NULL DEFAULT 0,
  `comment_captcha` tinyint(1) NOT NULL DEFAULT 0,
  `params` text DEFAULT NULL,
  `plugin` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `title`, `alias`, `description`, `format_show_author`, `format_show_date`, `format_use_wysiwyg`, `comment_status`, `comment_approve`, `comment_spam_protection`, `comment_captcha`, `params`, `plugin`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Page', 'page', 'A page is a simple method for creating and displaying information that rarely changes, such as an \"About us\" section of a website. By default, a page entry does not allow visitor comments.', 0, 0, 1, 0, 1, 0, 0, 'routes=true', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(2, 'Blog', 'blog', 'A blog entry is a single post to an online journal, or blog.', 1, 1, 1, 2, 1, 0, 0, 'routes=true', NULL, '2022-08-23 06:11:21', NULL, 1, NULL),
(4, 'Post', 'post', 'Default content type.', 1, 1, 1, 2, 1, 0, 0, 'routes=true', NULL, '2022-08-23 06:11:21', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types_vocabularies`
--

CREATE TABLE `types_vocabularies` (
  `id` int(11) NOT NULL,
  `type_id` int(20) NOT NULL,
  `vocabulary_id` int(20) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types_vocabularies`
--

INSERT INTO `types_vocabularies` (`id`, `type_id`, `vocabulary_id`, `weight`, `created`, `modified`) VALUES
(24, 4, 1, NULL, '2022-08-23 06:11:21', NULL),
(25, 4, 2, NULL, '2022-08-23 06:11:21', NULL),
(30, 2, 1, NULL, '2022-08-23 06:11:21', NULL),
(31, 2, 2, NULL, '2022-08-23 06:11:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `activation_key` varchar(60) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `timezone` varchar(40) NOT NULL DEFAULT 'UTC',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `name`, `email`, `website`, `activation_key`, `image`, `bio`, `status`, `timezone`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 1, 'shihab', '$2y$10$o2OEZFrZx2yfRCFLKZbaYuaaKDiKwkVGbPsZ1Zxf/OvPfQ6b7SiZ2', 'Aminul Islam Shihab', 'shihab.ph19205@gmail.com', NULL, NULL, NULL, NULL, 1, 'UTC', '2022-09-21 04:47:01', NULL, 1, 1),
(7, 4, 'akash', '$2y$10$AxaLU7bjnBSUeO8/OkNwUewYosak/ViCRVpW8fC9WHllabUzxlsyG', 'kamrul Hasan', 'hasanakash0215@gmail.com', '', '1b5e064af179de85ff6c98b88586bf7a88d3b3d0', NULL, NULL, 1, 'UTC', '2022-09-22 06:17:37', '2022-09-22 06:17:37', 1, 1),
(8, 4, 'shovon', '$2y$10$jIv5DSPTkQgLgsw8ZPIYduryevEBh.K4trIO2wNIdz9LUZ8SyK.ey', 'Mehedi Habib', 'mehedihabib@gmail.com', '', '4dcc4fc720968a72da7f11db1f64393dbf9739f8', NULL, NULL, 1, 'UTC', '2022-09-22 06:19:33', '2022-09-22 06:19:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vocabularies`
--

CREATE TABLE `vocabularies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `multiple` tinyint(1) NOT NULL DEFAULT 0,
  `tags` tinyint(1) NOT NULL DEFAULT 0,
  `plugin` varchar(255) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `created_by` int(20) NOT NULL,
  `modified_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vocabularies`
--

INSERT INTO `vocabularies` (`id`, `title`, `alias`, `description`, `required`, `multiple`, `tags`, `plugin`, `weight`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Categories', 'categories', '', 0, 1, 0, NULL, 1, '2022-08-23 06:11:21', NULL, 1, NULL),
(2, 'Tags', 'tags', '', 0, 1, 0, NULL, 2, '2022-08-23 06:11:21', NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_banks`
--
ALTER TABLE `acc_banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `acc_purposes`
--
ALTER TABLE `acc_purposes`
  ADD PRIMARY KEY (`purpose_id`);

--
-- Indexes for table `acc_transactions`
--
ALTER TABLE `acc_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `purpose_id` (`purpose_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `acos`
--
ALTER TABLE `acos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aros`
--
ALTER TABLE `aros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aros_acos`
--
ALTER TABLE `aros_acos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `un_assets_dimension` (`parent_asset_id`,`width`,`height`),
  ADD KEY `ix_assets_hash` (`hash`,`path`),
  ADD KEY `fk_assets` (`model`,`foreign_key`);

--
-- Indexes for table `asset_usages`
--
ALTER TABLE `asset_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_asset_usage` (`model`,`foreign_key`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_attachments_hash` (`hash`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `fk_blocks2regions` (`region_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model` (`model`,`foreign_key`),
  ADD KEY `fk_comments2users` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `croogo_acl_phinxlog`
--
ALTER TABLE `croogo_acl_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_blocks_phinxlog`
--
ALTER TABLE `croogo_blocks_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_ckeditor_phinxlog`
--
ALTER TABLE `croogo_ckeditor_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_comments_phinxlog`
--
ALTER TABLE `croogo_comments_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_contacts_phinxlog`
--
ALTER TABLE `croogo_contacts_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_dashboards_phinxlog`
--
ALTER TABLE `croogo_dashboards_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_extensions_phinxlog`
--
ALTER TABLE `croogo_extensions_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_file_manager_phinxlog`
--
ALTER TABLE `croogo_file_manager_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_menus_phinxlog`
--
ALTER TABLE `croogo_menus_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_meta_phinxlog`
--
ALTER TABLE `croogo_meta_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_nodes_phinxlog`
--
ALTER TABLE `croogo_nodes_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_settings_phinxlog`
--
ALTER TABLE `croogo_settings_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_taxonomy_phinxlog`
--
ALTER TABLE `croogo_taxonomy_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_users_phinxlog`
--
ALTER TABLE `croogo_users_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `croogo_wysiwyg_phinxlog`
--
ALTER TABLE `croogo_wysiwyg_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dashboards2users` (`user_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `shift_id` (`shift_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `employees_designation_id` (`employees_designation_id`);

--
-- Indexes for table `employees_designation`
--
ALTER TABLE `employees_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD PRIMARY KEY (`employee_attendance_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employee_attendance_count`
--
ALTER TABLE `employee_attendance_count`
  ADD PRIMARY KEY (`employee_attendance_count_id`);

--
-- Indexes for table `hr_config`
--
ALTER TABLE `hr_config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `hr_config_action`
--
ALTER TABLE `hr_config_action`
  ADD PRIMARY KEY (`config_action_id`);

--
-- Indexes for table `hr_config_action_setup`
--
ALTER TABLE `hr_config_action_setup`
  ADD PRIMARY KEY (`config_action_setup_id`),
  ADD KEY `config_action_id` (`config_action_id`);

--
-- Indexes for table `hr_events`
--
ALTER TABLE `hr_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hr_leaves`
--
ALTER TABLE `hr_leaves`
  ADD PRIMARY KEY (`leave_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `config_action_setup_id` (`config_action_setup_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hr_shift`
--
ALTER TABLE `hr_shift`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ix_languages_locale` (`locale`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_links2menus` (`menu_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`(190));

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages2contacts` (`contact_id`);

--
-- Indexes for table `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_taxonomies`
--
ALTER TABLE `model_taxonomies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model` (`model`,`foreign_key`,`taxonomy_id`),
  ADD KEY `fk_model_taxonomies2taxonomies` (`taxonomy_id`);

--
-- Indexes for table `nodes`
--
ALTER TABLE `nodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ix_nodes_slug_by_type` (`type`,`slug`(190)),
  ADD KEY `fk_nodes2users` (`user_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`payroll_id`),
  ADD KEY `create_by` (`created_by`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `payroll_config`
--
ALTER TABLE `payroll_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hr_config_action_id` (`config_action_id`),
  ADD KEY `payroll_id` (`payroll_id`);

--
-- Indexes for table `payroll_config_employee`
--
ALTER TABLE `payroll_config_employee`
  ADD PRIMARY KEY (`payroll_config_employee_id`),
  ADD KEY `employee_person_id` (`employee_person_id`),
  ADD KEY `payroll_config_id` (`payroll_config_id`),
  ADD KEY `payroll_id` (`payroll_id`);

--
-- Indexes for table `payroll_employee`
--
ALTER TABLE `payroll_employee`
  ADD PRIMARY KEY (`payroll_employee_id`),
  ADD KEY `payroll_id` (`payroll_id`),
  ADD KEY `employee_person_id` (`user_id`);

--
-- Indexes for table `payroll_payments`
--
ALTER TABLE `payroll_payments`
  ADD PRIMARY KEY (`payroll_payment_id`),
  ADD KEY `payroll_id` (`payroll_id`),
  ADD KEY `payment_by` (`payment_by`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Indexes for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_roles_users2roles` (`role_id`);

--
-- Indexes for table `scms_attendance`
--
ALTER TABLE `scms_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `teacher_id` (`user_id`),
  ADD KEY `student_course_cycles` (`student_course_cycle_id`),
  ADD KEY `attandance_ibfk_4` (`student_cycle_id`);

--
-- Indexes for table `scms_attendance_log`
--
ALTER TABLE `scms_attendance_log`
  ADD PRIMARY KEY (`attendance_log_id`),
  ADD KEY `course_session_teacher_id` (`courses_cycle_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `scms_courses`
--
ALTER TABLE `scms_courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `course_type_id` (`course_type_id`);

--
-- Indexes for table `scms_courses_cycle`
--
ALTER TABLE `scms_courses_cycle`
  ADD PRIMARY KEY (`courses_cycle_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `Level_id` (`level_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `scms_course_type`
--
ALTER TABLE `scms_course_type`
  ADD PRIMARY KEY (`course_type_id`);

--
-- Indexes for table `scms_departments`
--
ALTER TABLE `scms_departments`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `scms_faculty`
--
ALTER TABLE `scms_faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `scms_groups`
--
ALTER TABLE `scms_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `scms_guardians`
--
ALTER TABLE `scms_guardians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `scms_levels`
--
ALTER TABLE `scms_levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `scms_sections`
--
ALTER TABLE `scms_sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `shift_id` (`shift_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `scms_sessions`
--
ALTER TABLE `scms_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `scms_shifts`
--
ALTER TABLE `scms_shifts`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indexes for table `scms_staffs`
--
ALTER TABLE `scms_staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `scms_students`
--
ALTER TABLE `scms_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `scms_student_course_cycles`
--
ALTER TABLE `scms_student_course_cycles`
  ADD PRIMARY KEY (`student_course_cycles_id`),
  ADD KEY `student_cycle_id` (`student_cycle_id`),
  ADD KEY `course_department_level_id` (`courses_cycle_id`);

--
-- Indexes for table `scms_student_cycles`
--
ALTER TABLE `scms_student_cycles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `level_id` (`level_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `shift_id` (`shift_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `scms_teachers`
--
ALTER TABLE `scms_teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `designation_id` (`designation_id`);

--
-- Indexes for table `scms_term`
--
ALTER TABLE `scms_term`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `scms_term_course_cycle`
--
ALTER TABLE `scms_term_course_cycle`
  ADD PRIMARY KEY (`term_course_cycle_id`),
  ADD KEY `course_cycle_id` (`course_cycle_id`),
  ADD KEY `term_cycle_id` (`term_cycle_id`);

--
-- Indexes for table `scms_term_course_cycle_part`
--
ALTER TABLE `scms_term_course_cycle_part`
  ADD PRIMARY KEY (`term_course_cycle_part_id`),
  ADD KEY `term_course_cycle_id` (`term_course_cycle_id`);

--
-- Indexes for table `scms_term_cycle`
--
ALTER TABLE `scms_term_cycle`
  ADD PRIMARY KEY (`term_cycle_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `sms_log`
--
ALTER TABLE `sms_log`
  ADD PRIMARY KEY (`sms_log_id`);

--
-- Indexes for table `taxonomies`
--
ALTER TABLE `taxonomies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_taxonomies2terms` (`term_id`),
  ADD KEY `fk_taxonomies2vocabularies` (`vocabulary_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`(190));

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`(190));

--
-- Indexes for table `types_vocabularies`
--
ALTER TABLE `types_vocabularies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_id` (`type_id`,`vocabulary_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users2roles` (`role_id`);

--
-- Indexes for table `vocabularies`
--
ALTER TABLE `vocabularies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`(190));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_banks`
--
ALTER TABLE `acc_banks`
  MODIFY `bank_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `acc_purposes`
--
ALTER TABLE `acc_purposes`
  MODIFY `purpose_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3001;

--
-- AUTO_INCREMENT for table `acc_transactions`
--
ALTER TABLE `acc_transactions`
  MODIFY `transaction_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `acos`
--
ALTER TABLE `acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=414;

--
-- AUTO_INCREMENT for table `aros`
--
ALTER TABLE `aros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `aros_acos`
--
ALTER TABLE `aros_acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_usages`
--
ALTER TABLE `asset_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dashboards`
--
ALTER TABLE `dashboards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees_designation`
--
ALTER TABLE `employees_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  MODIFY `employee_attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee_attendance_count`
--
ALTER TABLE `employee_attendance_count`
  MODIFY `employee_attendance_count_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hr_config`
--
ALTER TABLE `hr_config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hr_config_action`
--
ALTER TABLE `hr_config_action`
  MODIFY `config_action_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hr_config_action_setup`
--
ALTER TABLE `hr_config_action_setup`
  MODIFY `config_action_setup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hr_events`
--
ALTER TABLE `hr_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hr_leaves`
--
ALTER TABLE `hr_leaves`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `hr_shift`
--
ALTER TABLE `hr_shift`
  MODIFY `shift_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=751;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meta`
--
ALTER TABLE `meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `model_taxonomies`
--
ALTER TABLE `model_taxonomies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nodes`
--
ALTER TABLE `nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payroll_config`
--
ALTER TABLE `payroll_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_config_employee`
--
ALTER TABLE `payroll_config_employee`
  MODIFY `payroll_config_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_employee`
--
ALTER TABLE `payroll_employee`
  MODIFY `payroll_employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payroll_payments`
--
ALTER TABLE `payroll_payments`
  MODIFY `payroll_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles_users`
--
ALTER TABLE `roles_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_attendance`
--
ALTER TABLE `scms_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_attendance_log`
--
ALTER TABLE `scms_attendance_log`
  MODIFY `attendance_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_courses`
--
ALTER TABLE `scms_courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_courses_cycle`
--
ALTER TABLE `scms_courses_cycle`
  MODIFY `courses_cycle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_course_type`
--
ALTER TABLE `scms_course_type`
  MODIFY `course_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scms_departments`
--
ALTER TABLE `scms_departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_faculty`
--
ALTER TABLE `scms_faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_groups`
--
ALTER TABLE `scms_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_guardians`
--
ALTER TABLE `scms_guardians`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_levels`
--
ALTER TABLE `scms_levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_sections`
--
ALTER TABLE `scms_sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_sessions`
--
ALTER TABLE `scms_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scms_shifts`
--
ALTER TABLE `scms_shifts`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scms_staffs`
--
ALTER TABLE `scms_staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_students`
--
ALTER TABLE `scms_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_student_course_cycles`
--
ALTER TABLE `scms_student_course_cycles`
  MODIFY `student_course_cycles_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_student_cycles`
--
ALTER TABLE `scms_student_cycles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_teachers`
--
ALTER TABLE `scms_teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_term`
--
ALTER TABLE `scms_term`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_term_course_cycle`
--
ALTER TABLE `scms_term_course_cycle`
  MODIFY `term_course_cycle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_term_course_cycle_part`
--
ALTER TABLE `scms_term_course_cycle_part`
  MODIFY `term_course_cycle_part_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scms_term_cycle`
--
ALTER TABLE `scms_term_cycle`
  MODIFY `term_cycle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sms_log`
--
ALTER TABLE `sms_log`
  MODIFY `sms_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxonomies`
--
ALTER TABLE `taxonomies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `types_vocabularies`
--
ALTER TABLE `types_vocabularies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vocabularies`
--
ALTER TABLE `vocabularies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acc_transactions`
--
ALTER TABLE `acc_transactions`
  ADD CONSTRAINT `acc_transactions_ibfk_1` FOREIGN KEY (`purpose_id`) REFERENCES `acc_purposes` (`purpose_id`),
  ADD CONSTRAINT `acc_transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `acc_transactions_ibfk_3` FOREIGN KEY (`bank_id`) REFERENCES `acc_banks` (`bank_id`);

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `fk_blocks2regions` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments2users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dashboards`
--
ALTER TABLE `dashboards`
  ADD CONSTRAINT `fk_dashboards2users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`shift_id`) REFERENCES `hr_shift` (`shift_id`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`employees_designation_id`) REFERENCES `employees_designation` (`id`);

--
-- Constraints for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD CONSTRAINT `employee_attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`),
  ADD CONSTRAINT `employee_attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hr_config_action_setup`
--
ALTER TABLE `hr_config_action_setup`
  ADD CONSTRAINT `hr_config_action_setup_ibfk_1` FOREIGN KEY (`config_action_id`) REFERENCES `hr_config_action` (`config_action_id`);

--
-- Constraints for table `hr_leaves`
--
ALTER TABLE `hr_leaves`
  ADD CONSTRAINT `hr_leaves_ibfk_1` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `hr_leaves_ibfk_2` FOREIGN KEY (`config_action_setup_id`) REFERENCES `hr_config_action_setup` (`config_action_setup_id`),
  ADD CONSTRAINT `hr_leaves_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `fk_links2menus` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `payroll_config`
--
ALTER TABLE `payroll_config`
  ADD CONSTRAINT `payroll_config_ibfk_1` FOREIGN KEY (`config_action_id`) REFERENCES `hr_config_action_setup` (`config_action_setup_id`),
  ADD CONSTRAINT `payroll_config_ibfk_2` FOREIGN KEY (`payroll_id`) REFERENCES `payroll` (`payroll_id`);

--
-- Constraints for table `payroll_config_employee`
--
ALTER TABLE `payroll_config_employee`
  ADD CONSTRAINT `payroll_config_employee_ibfk_1` FOREIGN KEY (`employee_person_id`) REFERENCES `employee` (`employee_id`),
  ADD CONSTRAINT `payroll_config_employee_ibfk_2` FOREIGN KEY (`payroll_id`) REFERENCES `payroll` (`payroll_id`);

--
-- Constraints for table `payroll_payments`
--
ALTER TABLE `payroll_payments`
  ADD CONSTRAINT `payroll_payments_ibfk_1` FOREIGN KEY (`payment_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payroll_payments_ibfk_2` FOREIGN KEY (`payroll_id`) REFERENCES `payroll` (`payroll_id`);

--
-- Constraints for table `scms_attendance`
--
ALTER TABLE `scms_attendance`
  ADD CONSTRAINT `scms_attendance_ibfk_1` FOREIGN KEY (`student_course_cycle_id`) REFERENCES `scms_student_course_cycles` (`student_course_cycles_id`),
  ADD CONSTRAINT `scms_attendance_ibfk_2` FOREIGN KEY (`student_cycle_id`) REFERENCES `scms_student_cycles` (`id`),
  ADD CONSTRAINT `scms_attendance_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `scms_attendance_log`
--
ALTER TABLE `scms_attendance_log`
  ADD CONSTRAINT `scms_attendance_log_ibfk_1` FOREIGN KEY (`courses_cycle_id`) REFERENCES `scms_courses_cycle` (`courses_cycle_id`),
  ADD CONSTRAINT `scms_attendance_log_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `scms_courses`
--
ALTER TABLE `scms_courses`
  ADD CONSTRAINT `scms_courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `scms_departments` (`department_id`),
  ADD CONSTRAINT `scms_courses_ibfk_2` FOREIGN KEY (`course_type_id`) REFERENCES `scms_course_type` (`course_type_id`);

--
-- Constraints for table `scms_courses_cycle`
--
ALTER TABLE `scms_courses_cycle`
  ADD CONSTRAINT `scms_courses_cycle_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `scms_courses` (`course_id`),
  ADD CONSTRAINT `scms_courses_cycle_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `scms_sessions` (`session_id`),
  ADD CONSTRAINT `scms_courses_cycle_ibfk_3` FOREIGN KEY (`level_id`) REFERENCES `scms_levels` (`level_id`);

--
-- Constraints for table `scms_departments`
--
ALTER TABLE `scms_departments`
  ADD CONSTRAINT `scms_departments_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `scms_faculty` (`faculty_id`);

--
-- Constraints for table `scms_guardians`
--
ALTER TABLE `scms_guardians`
  ADD CONSTRAINT `scms_guardians_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `scms_students` (`id`);

--
-- Constraints for table `scms_sections`
--
ALTER TABLE `scms_sections`
  ADD CONSTRAINT `scms_sections_ibfk_1` FOREIGN KEY (`shift_id`) REFERENCES `hr_shift` (`shift_id`),
  ADD CONSTRAINT `scms_sections_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `scms_levels` (`level_id`);

--
-- Constraints for table `scms_staffs`
--
ALTER TABLE `scms_staffs`
  ADD CONSTRAINT `scms_staffs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `scms_students`
--
ALTER TABLE `scms_students`
  ADD CONSTRAINT `scms_students_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `scms_levels` (`level_id`);

--
-- Constraints for table `scms_student_course_cycles`
--
ALTER TABLE `scms_student_course_cycles`
  ADD CONSTRAINT `scms_student_course_cycles_ibfk_1` FOREIGN KEY (`courses_cycle_id`) REFERENCES `scms_courses_cycle` (`courses_cycle_id`),
  ADD CONSTRAINT `scms_student_course_cycles_ibfk_2` FOREIGN KEY (`student_cycle_id`) REFERENCES `scms_student_cycles` (`id`);

--
-- Constraints for table `scms_student_cycles`
--
ALTER TABLE `scms_student_cycles`
  ADD CONSTRAINT `scms_student_cycles_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `scms_groups` (`group_id`),
  ADD CONSTRAINT `scms_student_cycles_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `scms_levels` (`level_id`),
  ADD CONSTRAINT `scms_student_cycles_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `scms_sections` (`section_id`),
  ADD CONSTRAINT `scms_student_cycles_ibfk_4` FOREIGN KEY (`session_id`) REFERENCES `scms_sessions` (`session_id`),
  ADD CONSTRAINT `scms_student_cycles_ibfk_5` FOREIGN KEY (`shift_id`) REFERENCES `hr_shift` (`shift_id`),
  ADD CONSTRAINT `scms_student_cycles_ibfk_6` FOREIGN KEY (`student_id`) REFERENCES `scms_students` (`id`);

--
-- Constraints for table `scms_teachers`
--
ALTER TABLE `scms_teachers`
  ADD CONSTRAINT `scms_teachers_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `scms_departments` (`department_id`),
  ADD CONSTRAINT `scms_teachers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `scms_teachers_ibfk_3` FOREIGN KEY (`designation_id`) REFERENCES `employees_designation` (`id`);

--
-- Constraints for table `scms_term_course_cycle`
--
ALTER TABLE `scms_term_course_cycle`
  ADD CONSTRAINT `scms_term_course_cycle_ibfk_1` FOREIGN KEY (`course_cycle_id`) REFERENCES `scms_courses_cycle` (`courses_cycle_id`),
  ADD CONSTRAINT `scms_term_course_cycle_ibfk_2` FOREIGN KEY (`term_cycle_id`) REFERENCES `scms_term_cycle` (`term_cycle_id`);

--
-- Constraints for table `scms_term_course_cycle_part`
--
ALTER TABLE `scms_term_course_cycle_part`
  ADD CONSTRAINT `scms_term_course_cycle_part_ibfk_1` FOREIGN KEY (`term_course_cycle_id`) REFERENCES `scms_term_course_cycle` (`term_course_cycle_id`);

--
-- Constraints for table `scms_term_cycle`
--
ALTER TABLE `scms_term_cycle`
  ADD CONSTRAINT `scms_term_cycle_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `scms_term` (`term_id`),
  ADD CONSTRAINT `scms_term_cycle_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `scms_sessions` (`session_id`),
  ADD CONSTRAINT `scms_term_cycle_ibfk_3` FOREIGN KEY (`level_id`) REFERENCES `scms_levels` (`level_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
