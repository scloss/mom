-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2016 at 10:26 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admintable`
--

CREATE TABLE IF NOT EXISTS `admintable` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admintable`
--

INSERT INTO `admintable` (`id`, `user_id`) VALUES
(1, 'showmen.baruaa'),
(2, 'akm.badruddoza'),
(3, 'mahmud.hossain'),
(4, 'khairul.alam'),
(5, 'muhitur.rahman'),
(6, 'ajabbar.kabir'),
(7, 'farhan.solaiman'),
(8, 'musleh.uddin'),
(9, 'md.shariful'),
(10, 'abedur.rahman'),
(11, 'ilmul.haque'),
(12, 'sharmin.zaman'),
(13, 'mustafezur.rahman'),
(14, 'humayun.kabir'),
(15, 'asif.hossain'),
(16, 'pallab'),
(17, 'anwar.hossain'),
(18, 'rony.rashid'),
(19, 'jasim.uddin'),
(20, 'raihan.parvez'),
(21, 'shamama.nazneen');

-- --------------------------------------------------------

--
-- Table structure for table `dept_email_table`
--

CREATE TABLE IF NOT EXISTS `dept_email_table` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `dept_email` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dept_email_table`
--

INSERT INTO `dept_email_table` (`id`, `dept_name`, `dept_email`) VALUES
(1, 'NOC', 'support@summitcommunications.net');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_table`
--

CREATE TABLE IF NOT EXISTS `meeting_table` (
  `meeting_id` int(11) NOT NULL,
  `meeting_title` varchar(1024) NOT NULL,
  `meeting_datetime` datetime NOT NULL,
  `meeting_attendee` varchar(5000) NOT NULL,
  `mail_recipient` varchar(5000) NOT NULL,
  `meeting_type` varchar(255) NOT NULL,
  `meeting_status` varchar(255) NOT NULL,
  `completion` double NOT NULL,
  `mother_meeting_id` int(11) NOT NULL,
  `meeting_organizer_id` varchar(50) NOT NULL,
  `meeting_decision` varchar(10000) NOT NULL,
  `seen_users` varchar(5000) NOT NULL,
  `meeting_comment` varchar(15000) NOT NULL,
  `meeting_files` varchar(500) NOT NULL,
  `initiator_dept` varchar(255) NOT NULL,
  `attendee_dept` varchar(255) NOT NULL,
  `meeting_schedule_type` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting_table`
--

INSERT INTO `meeting_table` (`meeting_id`, `meeting_title`, `meeting_datetime`, `meeting_attendee`, `mail_recipient`, `meeting_type`, `meeting_status`, `completion`, `mother_meeting_id`, `meeting_organizer_id`, `meeting_decision`, `seen_users`, `meeting_comment`, `meeting_files`, `initiator_dept`, `attendee_dept`, `meeting_schedule_type`) VALUES
(1, 'Requirement Analysis For MOM', '2016-06-26 23:48:59', 'showmen.barua@summitcommunications.net,raihan.parvez@summitcommunications.net,ahsanur.rab@summitcommunications.net', 'showmen.barua@summitcommunications.net,raihan.parvez@summitcommunications.net,ahsanur.rab@summitcommunications.net', 'firstMeeting', 'active', 0, 1, 'showmen.barua', 'Requirement Documentation will be provided to the developers.', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar,showmen.barua', 'showmen.barua[2016/06/26 11:52:29] : One step closer to start development.\nshowmen.barua[2016/06/27 09:22:04] : Another session required to clear some confusions ', '', 'NOC', 'NOC,MD''s Office', 'AD-HOC'),
(2, 'NOC and O&M Weekly Meeting', '2016-06-28 23:53:49', 'showmen.barua@summitcommunications.net,razib.hasan@summitcommunications.net,raihan.parvez@summitcommunications.net,mahmud.hossain@summitcommunications.net,arafat.islam@summitcommunications.net', 'showmen.barua@summitcommunications.net,razib.hasan@summitcommunications.net,raihan.parvez@summitcommunications.net,mahmud.hossain@summitcommunications.net,arafat.islam@summitcommunications.net', 'firstMeeting', 'active', 50, 2, 'showmen.barua', 'Both end understood their limitations and improvement scope', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar,showmen.barua', 'showmen.barua[2016/06/27 12:00:44] : It was beneficial for both dept', '', 'NOC', 'Operations & Maintenance - 1', 'Bi-Weekly'),
(3, 'MOM Demo', '2016-06-27 11:03:31', 'showmen.barua@summitcommunications.net,raihan.parvez@summitcommunications.net,md.shariful@summitcommunications.net,muhitur.rahman@summitcommunications.net,ahsanur.rab@summitcommunications.net', 'showmen.barua@summitcommunications.net,raihan.parvez@summitcommunications.net,md.shariful@summitcommunications.net,muhitur.rahman@summitcommunications.net,ahsanur.rab@summitcommunications.net', 'firstMeeting', 'active', 0, 3, 'showmen.barua', 'Demo Presented Successfully', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar', 'showmen.barua[2016/06/27 11:10:15] : \nraihan.parvez[2016/06/27 11:31:43] : Manual is created.', '', 'NOC', 'NOC,Planning Architecture & Design,MD''s Office', 'AD-HOC'),
(4, 'todays meeting', '2016-07-12 15:44:55', 'raihan.parvez@summitcommunications.net,md.shariful@summitcommunications.net,ajabbar.kabir@summitcommunications.net', 'raihan.parvez@summitcommunications.net,md.shariful@summitcommunications.net,ajabbar.kabir@summitcommunications.net', 'firstMeeting', 'active', 0, 4, 'raihan.parvez', 'decision1', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar', 'raihan.parvez[2016/07/12 03:52:33] : ', '', 'NOC', 'Operations & Maintenance - 2', 'Weekly'),
(5, 'asdf', '2016-07-18 13:35:43', 'showmen.barua@summitcommunications.net', 'showmen.barua@summitcommunications.net', 'firstMeeting', 'active', 0, 5, 'showmen.barua', 'asdf', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar', 'showmen.barua[2016/07/18 01:35:12] : ', '', 'NOC', 'NOC', 'AD-HOC'),
(6, 'Gateway internal', '2016-07-18 13:38:01', 'samiul.bashar@summitcommunications.net,hashibur.rahman@summitcommunications.net,ruhul.amin@summitcommunications.net', 'samiul.bashar@summitcommunications.net,hashibur.rahman@summitcommunications.net,atif.masud@summitcommunications.net,ruhul.amin@summitcommunications.net,jobayer.shuvo@summitcommunications.net|IIG', 'firstMeeting', 'active', 100, 6, 'hashibur.rahman', '', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar', 'hashibur.rahman[2016/07/18 01:39:03] : ', '', 'ICX', 'IIG,ICX', 'AD-HOC'),
(7, 'Follow UP: Gateway internal', '2016-07-18 13:38:01', 'samiul.bashar@summitcommunications.net,hashibur.rahman@summitcommunications.net,ruhul.amin@summitcommunications.net,shoeb.shahriar@summitcommunications.net', 'samiul.bashar@summitcommunications.net,hashibur.rahman@summitcommunications.net,atif.masud@summitcommunications.net,ruhul.amin@summitcommunications.net,jobayer.shuvo@summitcommunications.net|IIG,shoeb.shahriar@summitcommunications.net', 'followUpMeeting', 'active', 100, 6, 'ahmad.sukarno', '', ',jobayer.shuvo,muntasir.khan,muntasir.khan,shoeb.shahriar,shoeb.shahriar', 'ahmad.sukarno[2016/07/18 01:43:46] : ', '', 'Coordination', 'IIG,ICX', 'AD-HOC');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_10_04_035034_user_table', 1),
('2015_10_04_035047_meeting_table', 1),
('2015_10_04_035058_mom_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mom_table`
--

CREATE TABLE IF NOT EXISTS `mom_table` (
  `mom_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `mom_title` varchar(1024) NOT NULL,
  `responsible` varchar(3000) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `mom_status` varchar(20) NOT NULL,
  `comment` varchar(20000) NOT NULL,
  `mom_completion_time` datetime NOT NULL,
  `mom_system_completion_time` datetime NOT NULL,
  `mom_completion_status` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mom_table`
--

INSERT INTO `mom_table` (`mom_id`, `meeting_id`, `mom_title`, `responsible`, `start_time`, `end_time`, `mom_status`, `comment`, `mom_completion_time`, `mom_system_completion_time`, `mom_completion_status`) VALUES
(1, 1, 'Finish Documentation', 'showmen.barua@summitcommunications.net', '2016-06-26 23:52:14', '2016-06-29 23:52:15', 'active', 'Try to finish it as soon as possible', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0-50'),
(2, 2, 'SMS TOOL', 'showmen.barua@summitcommunications.net,raihan.parvez@summitcommunications.net', '2016-06-28 23:57:11', '2016-07-31 23:57:18', 'closed', 'Must needed tool.', '0000-00-00 00:00:00', '2016-06-27 10:58:46', '80-100'),
(3, 2, 'Fast Report Crosscheck from O&M ', 'arafat.islam@summitcommunications.net,showmen.barua@summitcommunications.net', '2016-06-28 00:00:03', '2016-07-08 00:00:10', 'active', 'Must needed Improvement', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0-50'),
(4, 3, 'Complete Development for Demo', 'showmen.barua@summitcommunications.net', '2016-06-27 11:09:37', '2016-06-28 11:09:39', 'active', 'Finish the Development of Demo', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0-50'),
(5, 3, 'Prepare Manual', 'showmen.barua@summitcommunications.net,raihan.parvez@summitcommunications.net', '2016-06-27 11:10:45', '2016-07-08 11:10:47', 'active', 'Must Provide a very friendly manual', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0-50'),
(6, 4, 'tool ', 'raihan.parvez@summitcommunications.net', '2016-07-13 15:52:18', '2016-07-15 15:52:22', 'active', 'to be done', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0-50'),
(7, 5, 'asdf', 'showmen.barua@summitcommunications.net', '2016-07-18 13:35:54', '2016-07-18 13:35:55', 'active', 'dfdf', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0-50'),
(8, 6, 'Test session', 'muntasir.khan@summitcommunications.net,hashibur.rahman@summitcommunications.net', '2016-07-18 13:39:40', '2016-07-19 13:39:44', 'closed', '', '0000-00-00 00:00:00', '2016-07-18 02:26:17', '80-100'),
(9, 7, 'Test session', 'muntasir.khan@summitcommunications.net,hashibur.rahman@summitcommunications.net', '2016-07-18 13:39:40', '2016-07-20 13:39:44', 'closed', '', '0000-00-00 00:00:00', '2016-07-18 02:26:38', '80-100');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `super_table`
--

CREATE TABLE IF NOT EXISTS `super_table` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dept` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `super_table`
--

INSERT INTO `super_table` (`id`, `user_id`, `user_name`, `email`, `dept`) VALUES
(2, 'arif', 'Md. Arif Al Islam', 'arif@summitcommunications.net', 'MD''s Office'),
(3, 'khan.mashiur', 'Md. Mashiur Rahman Khan', 'khan.mashiur@summitcommunications.net', 'MD''s Office'),
(4, 'shafakat.hossain', 'Md. Shafakat Hossain', 'shafakat.hossain@summitcommunications.net', 'MD''s Office'),
(5, 'ahsanur.rab', 'Mohammad Ahsanur Rab', 'ahsanur.rab@summitcommunications.net', 'MD''s Office'),
(6, 'showmen.baruaa', 'Showmen Baruaa', 'showmen.baruaa@summitcommunications.net', 'NOC');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE IF NOT EXISTS `user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `login_id` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(20) NOT NULL,
  `dept` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_name`, `user_password`, `login_id`, `user_type`, `email`, `phone`, `dept`) VALUES
(1, 'showmen', 'showmen123', 'showmen.barua', 'admin', 'showmen.barua@summitcommunications.net', 1689565238, 'NOC(OSS)'),
(2, 'Razib Hasan', 'razib123', 'razib.hasan', 'admin', 'razib.hasan@summitcommunications.net', 1234567891, 'NOC'),
(3, 'sakib', 'sakib123', 'sakib.ullah', 'admin', 'sakib.ullah@summitcommunications.net', 1234, 'NOC'),
(4, 'Emtiaz Hossain', 'emtiaz123', 'emtiaz.hossain', 'admin', 'emtiaz.hossain@summitcommunications.net', 123, 'NOC'),
(5, 'Mir Raihan Md. Maeen', 'raihan123', 'mir.raihan', 'admin', 'mir.raihan@summitcommunications.net', 123, 'NOC'),
(6, 'Saeed Naser Kanon', 'kanon123', 'saeed.naser', 'admin', 'saeed.naser@summitcommunications.net', 123, 'NOC'),
(7, 'Md. Shariful Islam', 'shariful123', 'md.shariful', 'admin', 'md.shariful@summitcommunications.net', 123, 'NOC'),
(8, 'Raihan Parvez', 'raihan123', 'raihan.parvez', 'admin', 'raihan.parvez@summitcommunications.net', 123, 'NOC'),
(9, 'Md. Moshiur Rahman', 'moshiur123', 'moshiur.rahman', 'admin', 'moshiur.rahman@summitcommunications.net', 0, 'NOC'),
(10, 'Md. Mahbub Hasan', 'mahbub123', 'mahbub.hasan', 'admin', 'mahbub.hasan@summitcommunications.net', 0, 'NOC'),
(11, 'Sadaf Ibn Mahmud', 'sadaf123', 'sadaf.mahmud', 'admin', 'sadaf.mahmud@summitcommunications.net', 0, 'NOC'),
(12, 'Iqbal ahmed', 'iqbal123', 'iqbal.ahmed', 'admin', 'iqbal.ahmed@summitcommunications.net', 0, 'NOC'),
(13, 'Tahsinul ferdous', 'tahsinul123', 'tahsinul.ferdous', 'admin', 'tahsinul.ferdous@summitcommunications.net', 0, 'NOC'),
(14, 'Sarbik sahan', 'sarbik', 'sarbik.sahan', 'admin', 'sarbik.sahan@summitcommunications.net', 0, 'NOC'),
(15, 'Samar kumar', 'samar123', 'samar.kumar', 'admin', 'samar.kumar@summitcommunications.net', 0, 'NOC'),
(16, 'Iftakhar jahan', 'iftakhar123', 'iftakhar.jahan', 'admin', 'iftakhar.jahan@summitcommunications.net', 0, 'NOC'),
(17, 'Tanveer ahmed', 'tanveer123', 'tanveer.ahmed', 'admin', 'tanveer.ahmed@summitcommunications.net', 0, 'NOC'),
(18, 'Tanvir Ahmed', 'tanvir123', 'etanvir.ahmed', 'admin', 'etanvir.ahmed@summitcommunications.net', 0, 'NOC'),
(19, 'Biplob barua', 'biplob123', 'biplob.barua', 'admin', 'biplob.barua@summitcommunications.net', 0, 'NOC'),
(20, 'Maruf mohammad', 'maruf123', 'maruf.mohammad', 'admin', 'maruf.mohammad@summitcommunications.net ', 0, 'NOC'),
(21, 'Puspita tapu', 'puspita123', 'puspita.tapu', 'admin', 'puspita.tapu@summitcommunications.net', 0, 'NOC'),
(22, 'Nowrin karim', 'nowrin123', 'nowrin.karim', 'admin', 'nowrin.karim@summitcommunications.net', 0, 'NOC'),
(23, 'Trina majumder', 'trina123', 'trina.majumder', 'admin', 'trina.majumder@summitcommunications.net', 0, 'NOC'),
(24, 'Akramul tarafdar', 'akramul123', 'akramul.tarafdar', 'admin', 'akramul.tarafdar@summitcommunications.net', 0, 'NOC'),
(25, 'oss noc', 'oss123', 'showmen.barua', 'admin', 'showmen.barua@summitcommunications.net', 1680565238, 'OSS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admintable`
--
ALTER TABLE `admintable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dept_email_table`
--
ALTER TABLE `dept_email_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_table`
--
ALTER TABLE `meeting_table`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `mom_table`
--
ALTER TABLE `mom_table`
  ADD PRIMARY KEY (`mom_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `super_table`
--
ALTER TABLE `super_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admintable`
--
ALTER TABLE `admintable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `dept_email_table`
--
ALTER TABLE `dept_email_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `meeting_table`
--
ALTER TABLE `meeting_table`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `mom_table`
--
ALTER TABLE `mom_table`
  MODIFY `mom_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `super_table`
--
ALTER TABLE `super_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
