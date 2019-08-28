-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2018 at 02:12 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wgsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contacts_id` int(11) NOT NULL,
  `contacts_title` varchar(250) DEFAULT NULL,
  `contacts_from` varchar(250) DEFAULT NULL,
  `temp` varchar(250) NOT NULL DEFAULT 'no',
  `csv_file` text,
  `csv_file_columns` text,
  `csv_file_name` varchar(250) DEFAULT NULL,
  `csv_contacts_column` int(11) DEFAULT NULL,
  `recepient_contacts` text,
  `contacts_phone_book_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `phone_book_columns` text,
  `phone_book_contacts` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contacts_id`, `contacts_title`, `contacts_from`, `temp`, `csv_file`, `csv_file_columns`, `csv_file_name`, `csv_contacts_column`, `recepient_contacts`, `contacts_phone_book_id`, `created_by`, `modified_by`, `created_at`, `updated_at`, `phone_book_columns`, `phone_book_contacts`) VALUES
(2, 'contacts222.csv', 'csv', 'no', 'uploads/csv/AAGS3KQWrLG1ogNsbq46Q9pRxw57MR.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', NULL, NULL),
(3, 'asa', 'phone_book', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', '[\"first_name\",\"last_name\",\"telephone\",\"email\"]', '[{\"first_name\":\"pius\",\"last_name\":\"Malala\",\"phone\":\"4455454\",\"email\":\"mail@yahoo.com\"},{\"first_name\":\"kevin\",\"last_name\":\"ochieng\",\"phone\":\"454545\",\"email\":\"malala@yahoo.com\"}]'),
(4, 'contacts222.csv', 'csv', 'no', 'uploads/csv/GpoqIkThBitVf5ll23divFpyy0eLkY.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', NULL, NULL),
(5, 'Contacts', 'phone_book', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', '[\"first_name\",\"last_name\",\"telephone\",\"email\"]', '[{\"first_name\":\"pius\",\"last_name\":\"Malala\",\"phone\":\"4455454\",\"email\":\"mail@yahoo.com\"},{\"first_name\":\"kevin\",\"last_name\":\"ochieng\",\"phone\":\"454545\",\"email\":\"malala@yahoo.com\"}]'),
(6, 'IT GROUP', 'phone_book', 'no', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', '[\"first_name\",\"last_name\",\"telephone\",\"email\"]', '[{\"first_name\":\"kEVIN\",\"last_name\":\"oCHIENG\",\"phone\":\"0713295853\",\"email\":\"mail@yahoo.com\"},{\"first_name\":\"Anthony\",\"last_name\":\"Mukoma\",\"phone\":\"0754111212\",\"email\":null}]'),
(7, 'contacts222.csv', 'csv', 'no', 'uploads/csv/D30rtjcvKa6U2jGFKpZpvZCdBOQjuG.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', NULL, NULL),
(8, 'contacts222.csv', 'csv', 'no', 'uploads/csv/90hYK2Sm18ubrM6x3iOqXMBTOmhTvH.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-07-31', '2018-07-31', NULL, NULL),
(9, 'contacts222.csv', 'csv', 'no', 'uploads/csv/8EnBbnGoNDDjQjMxGkDpv0Mjkg75iw.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-01', '2018-08-01', NULL, NULL),
(10, 'contacts222.csv', 'csv', 'no', 'uploads/csv/Wjez5vuyvbi8pPDAOVkhnLOEfwofN7.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-01', '2018-08-01', NULL, NULL),
(11, 'contacts222.csv', 'csv', 'no', 'uploads/csv/VlwT7froD6aE1EvMw2I6ZfaUCAb69L.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-01', '2018-08-01', NULL, NULL),
(12, 'contacts2444a.csv', 'csv', 'no', 'uploads/csv/Pk2wajYw7423E4CewLRRZPvDDm2Ge6.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts2444a.csv', 7, NULL, NULL, 1, 1, '2018-08-01', '2018-08-01', NULL, NULL),
(13, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/V8Y0nWLOjQzdVhF5HWCyGHOT4dKNrX.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(14, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/bowi7X4BvCvE8z0p8OJxPJ8YdPAWXh.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(15, 'contacts222.csv', 'csv', 'no', 'uploads/csv/by51n61vhwj8hawh2M1C07Cm80MJ54.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(16, 'contacts222.csv', 'csv', 'no', 'uploads/csv/3yMa0cboQAP6Z232g3mqLUKzkviHS1.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(17, 'contacts222.csv', 'csv', 'no', 'uploads/csv/kS7aBJS1wtpZ0KeIZQybxm2fxwbW72.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(18, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/Zbt7pyo5f67PcEhe4f5664tgT2gzP1.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(19, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/93wewgMj9TqYwXsgu2JISdNrwlOUfe.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(20, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/KGZQriWpyZOsFA4zdzXmsRpd6ex7rj.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(21, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/rgH7VKKSuZ0K9xJdwLMBqlkz7Sh0Om.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(22, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/ktmCoagN0u1NWLf95Wk027uLSQeveV.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(23, 'contacts222.csv', 'csv', 'no', 'uploads/csv/dopA8wfkxF7NN928xhrD2l2pS3CMCX.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts222.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(24, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/TaAccfJ7QOY7Mk5oeoPg5fMBDuS7de.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL),
(25, 'contacts_many.csv', 'csv', 'no', 'uploads/csv/NSyyFm63Dig3Qq4L63dIo9QUj2Le5M.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', 'contacts_many.csv', 7, NULL, NULL, 1, 1, '2018-08-03', '2018-08-03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `csv_temp_uploads`
--

CREATE TABLE `csv_temp_uploads` (
  `csv_temp_id` int(11) NOT NULL,
  `csv_path` text NOT NULL,
  `csv_columns` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `file_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `csv_temp_uploads`
--

INSERT INTO `csv_temp_uploads` (`csv_temp_id`, `csv_path`, `csv_columns`, `created_at`, `created_by`, `file_name`) VALUES
(1, 'uploads/csv/Qxe0r0IrNVZkKKJm2IJYijl424tNZS.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', '2018-07-26 09:59:28', 1, ''),
(2, 'uploads/csv/srFfLuGKcba7nY2lEjqrsh2p8bK5WL.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', '2018-07-26 10:05:19', 1, ''),
(3, 'uploads/csv/wQAx51kzWo8yy9RKDBHwo60pNBfG4Z.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', '2018-07-26 10:08:06', 1, ''),
(4, 'uploads/csv/P0XBS2XLKEM7gA8VdQ6AZUKHfjgk2y.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', '2018-07-26 10:10:05', 1, ''),
(5, 'uploads/csv/BmOZBEYOpTrtSuoCrr6loZpfSrwTUc.csv', '[\"CODE\",\"NAME\",\"ADDRESS\",\"AREA\",\"CITY\",\"PKG\",\"SEGMENT\",\"CONTACT\",\"PAS\",\"NPD AGE\",\"NO DISC\",\" BILL \",\" DISCOUNT \",\" AMOUNT TO PAY \"]', '2018-07-26 10:13:01', 1, 'contacts222.csv');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(250) NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quees`
--

CREATE TABLE `quees` (
  `que_id` int(11) NOT NULL,
  `uid` varchar(64) DEFAULT NULL,
  `text_id` int(11) NOT NULL,
  `phone_no` varchar(250) NOT NULL,
  `message` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `time_sent` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quee_status`
--

CREATE TABLE `quee_status` (
  `quee_status_id` int(11) NOT NULL,
  `quee_status_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quee_status`
--

INSERT INTO `quee_status` (`quee_status_id`, `quee_status_name`) VALUES
(1, 'pending'),
(2, 'sent'),
(3, 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

CREATE TABLE `texts` (
  `text_id` int(11) NOT NULL,
  `text_title` varchar(250) NOT NULL,
  `contacts_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(250) NOT NULL,
  `from_source` varchar(250) DEFAULT NULL,
  `recepient_contacts` text,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `qued` tinyint(2) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `texts`
--

INSERT INTO `texts` (`text_id`, `text_title`, `contacts_id`, `message`, `status`, `from_source`, `recepient_contacts`, `created_by`, `modified_by`, `created_at`, `updated_at`, `qued`) VALUES
(8, 'sddsd', 25, '{NAME} {CODE}', 'published', 'csv_upload', '', 1, 1, '2018-08-03 12:40:45', '2018-08-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kevin Ochieng', 'kvnochieng52@gmail.com', '$2y$10$JgRUk2ytfsWJpUrJNIj5HOK7D1iBaUzoeeo8K.05BeGFNLoLIkebq', 'ecFys6X5a4eKlOWhDEnmt0qBe3HOG85KMvBlijU3gF8SOgypRBIcRF8ctTOg', '2018-07-09 09:37:30', '2018-07-09 09:37:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contacts_id`);

--
-- Indexes for table `csv_temp_uploads`
--
ALTER TABLE `csv_temp_uploads`
  ADD PRIMARY KEY (`csv_temp_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quees`
--
ALTER TABLE `quees`
  ADD PRIMARY KEY (`que_id`);

--
-- Indexes for table `quee_status`
--
ALTER TABLE `quee_status`
  ADD PRIMARY KEY (`quee_status_id`);

--
-- Indexes for table `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`text_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contacts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `csv_temp_uploads`
--
ALTER TABLE `csv_temp_uploads`
  MODIFY `csv_temp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quees`
--
ALTER TABLE `quees`
  MODIFY `que_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quee_status`
--
ALTER TABLE `quee_status`
  MODIFY `quee_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `texts`
--
ALTER TABLE `texts`
  MODIFY `text_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
