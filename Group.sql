-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2015 at 02:16 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `makeadiff_madapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('executive','national','fellow','volunteer','strat') NOT NULL,
  `group_type` enum('normal','hierarchy') NOT NULL DEFAULT 'normal',
  `vertical_id` int(11) unsigned NOT NULL,
  `region_id` int(11) unsigned NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=363 ;

--
-- Dumping data for table `Group`
--

INSERT INTO `Group` (`id`, `name`, `type`, `group_type`, `vertical_id`, `region_id`, `status`) VALUES
(1, 'Leadership Team', 'national', 'normal', 14, 0, '1'),
(2, 'City Team Lead', 'fellow', 'normal', 1, 0, '1'),
(3, 'All Access', 'national', 'normal', 14, 0, '0'),
(4, 'Center Support Fellow', 'fellow', 'normal', 4, 0, '1'),
(5, 'HR Fellow', 'fellow', 'normal', 8, 0, '1'),
(10, 'CR - Intern', 'volunteer', 'normal', 13, 0, '1'),
(8, 'Mentors', 'volunteer', 'normal', 3, 0, '1'),
(9, 'Teacher', 'volunteer', 'normal', 3, 0, '1'),
(11, 'PR Fellow', 'fellow', 'normal', 7, 0, '1'),
(12, 'Discover Fellow', 'fellow', 'normal', 6, 0, '1'),
(14, 'Intern', 'volunteer', 'normal', 0, 0, '0'),
(15, 'Finance Controller', 'fellow', 'normal', 9, 0, '1'),
(19, 'Ed Support Fellow', 'fellow', 'normal', 3, 0, '1'),
(18, 'Library', 'volunteer', 'normal', 0, 0, '0'),
(20, 'Events Fellow', 'fellow', 'normal', 10, 0, '1'),
(21, 'Events Intern', 'volunteer', 'normal', 10, 0, '1'),
(22, 'Library Fellow', 'fellow', 'normal', 0, 0, '0'),
(23, 'Discover Intern', 'volunteer', 'normal', 6, 0, '1'),
(24, 'Executive Team', 'executive', 'normal', 14, 0, '1'),
(304, 'Discover Fellow, Central', 'fellow', 'hierarchy', 6, 4, '1'),
(303, 'Discover Fellow, Deccan', 'fellow', 'hierarchy', 6, 3, '1'),
(302, 'Discover Fellow, North', 'fellow', 'hierarchy', 6, 2, '1'),
(301, 'Discover Fellow, South', 'fellow', 'hierarchy', 6, 1, '1'),
(300, 'Propel Fellow, Central', 'fellow', 'hierarchy', 5, 4, '1'),
(299, 'Propel Fellow, Deccan', 'fellow', 'hierarchy', 5, 3, '1'),
(298, 'Propel Fellow, North', 'fellow', 'hierarchy', 5, 2, '1'),
(297, 'Propel Fellow, South', 'fellow', 'hierarchy', 5, 1, '1'),
(296, 'CS Fellow, Central', 'fellow', 'hierarchy', 4, 4, '1'),
(295, 'CS Fellow, Deccan', 'fellow', 'hierarchy', 4, 3, '1'),
(294, 'CS Fellow, North', 'fellow', 'hierarchy', 4, 2, '1'),
(293, 'CS Fellow, South', 'fellow', 'hierarchy', 4, 1, '1'),
(292, 'ES Fellow, Central', 'fellow', 'hierarchy', 3, 4, '1'),
(291, 'ES Fellow, Deccan', 'fellow', 'hierarchy', 3, 3, '1'),
(290, 'ES Fellow, North', 'fellow', 'hierarchy', 3, 2, '1'),
(289, 'ES Fellow, South', 'fellow', 'hierarchy', 3, 1, '1'),
(288, 'CH Fellow, Central', 'fellow', 'hierarchy', 2, 4, '1'),
(287, 'CH Fellow, Deccan', 'fellow', 'hierarchy', 2, 3, '1'),
(286, 'CH Fellow, North', 'fellow', 'hierarchy', 2, 2, '1'),
(285, 'CH Fellow, South', 'fellow', 'hierarchy', 2, 1, '1'),
(284, 'CTL, Central', 'fellow', 'hierarchy', 1, 4, '1'),
(283, 'CTL, Deccan', 'fellow', 'hierarchy', 1, 3, '1'),
(282, 'CTL, North', 'fellow', 'hierarchy', 1, 2, '1'),
(281, 'CTL, South', 'fellow', 'hierarchy', 1, 1, '1'),
(280, 'CR Fellow', 'fellow', 'normal', 13, 0, '1'),
(279, 'CFR Fellow', 'fellow', 'normal', 12, 0, '1'),
(355, 'Ed Support Strat', 'strat', 'normal', 3, 0, '1'),
(356, 'Discover Strat', 'strat', 'normal', 6, 0, '1'),
(350, 'Strat', 'strat', 'normal', 0, 0, '1'),
(354, 'PR Strat', 'strat', 'normal', 7, 0, '1'),
(272, 'Propel Fellow', 'fellow', 'normal', 5, 0, '1'),
(358, 'Center Support Strat', 'strat', 'normal', 4, 0, '1'),
(357, 'HR Strat', 'strat', 'normal', 8, 0, '1'),
(269, 'Center Head', 'fellow', 'normal', 2, 0, '1'),
(267, 'Center Head, Central', 'fellow', 'hierarchy', 0, 4, '1'),
(266, 'Center Head, Deccan', 'fellow', 'hierarchy', 0, 3, '1'),
(265, 'Center Head, North', 'fellow', 'hierarchy', 0, 2, '1'),
(264, 'Center Head, South', 'fellow', 'hierarchy', 0, 1, '1'),
(360, 'Finance Strat', 'strat', 'normal', 9, 0, '1'),
(262, 'FRH', 'fellow', 'normal', 11, 0, '1'),
(261, 'CTL, Central', 'fellow', 'hierarchy', 0, 4, '1'),
(260, 'CTL, Deccan', 'fellow', 'hierarchy', 0, 3, '1'),
(259, 'CTL, North', 'fellow', 'hierarchy', 0, 2, '1'),
(258, 'CTL, South', 'fellow', 'hierarchy', 0, 1, '1'),
(256, 'CR Strat, Central', 'strat', 'hierarchy', 13, 4, '1'),
(255, 'CR Strat, Deccan', 'strat', 'hierarchy', 13, 3, '1'),
(254, 'CR Strat, North', 'strat', 'hierarchy', 13, 2, '1'),
(253, 'CR Strat, South', 'strat', 'hierarchy', 13, 1, '1'),
(252, 'Program Director, Corporate Relations', 'national', 'normal', 13, 0, '1'),
(251, 'CFR Strat, Central', 'strat', 'hierarchy', 12, 4, '1'),
(250, 'CFR Strat, Deccan', 'strat', 'hierarchy', 12, 3, '1'),
(249, 'CFR Strat, North', 'strat', 'hierarchy', 12, 2, '1'),
(248, 'CFR Strat', 'strat', 'normal', 12, 0, '1'),
(247, 'Program Director, Community Fund Raising', 'national', 'normal', 12, 0, '1'),
(351, 'Events Strat', 'strat', 'normal', 10, 0, '1'),
(352, 'CR Strat', 'strat', 'normal', 13, 0, '1'),
(353, 'Operations Director', 'national', 'normal', 0, 0, '1'),
(242, 'Program Director, Fundraising Head', 'national', 'normal', 11, 0, '1'),
(241, 'Events Strat, Central', 'strat', 'hierarchy', 10, 4, '1'),
(240, 'Events Strat, Deccan', 'strat', 'hierarchy', 10, 3, '1'),
(239, 'Events Strat, North', 'strat', 'hierarchy', 10, 2, '1'),
(238, 'Events Strat, South', 'strat', 'hierarchy', 10, 1, '1'),
(237, 'Program Director, Events', 'national', 'normal', 10, 0, '1'),
(236, 'Finance Strat, Central', 'strat', 'hierarchy', 9, 4, '1'),
(235, 'Finance Strat, Deccan', 'strat', 'hierarchy', 9, 3, '1'),
(234, 'Finance Strat, North', 'strat', 'hierarchy', 9, 2, '1'),
(233, 'Finance Strat, South', 'strat', 'hierarchy', 9, 1, '1'),
(232, 'Program Director, Finance', 'national', 'normal', 9, 0, '1'),
(231, 'HR Strat, Central', 'strat', 'hierarchy', 8, 4, '1'),
(230, 'HR Strat, Deccan', 'strat', 'hierarchy', 8, 3, '1'),
(229, 'HR Strat, North', 'strat', 'hierarchy', 8, 2, '1'),
(228, 'HR Strat, South', 'strat', 'hierarchy', 8, 1, '1'),
(227, 'Program Director, Human Resources', 'national', 'normal', 8, 0, '1'),
(226, 'PR Strat, Central', 'strat', 'hierarchy', 7, 4, '1'),
(225, 'PR Strat, Deccan', 'strat', 'hierarchy', 7, 3, '1'),
(224, 'PR Strat, North', 'strat', 'hierarchy', 7, 2, '1'),
(223, 'PR Strat, South', 'strat', 'hierarchy', 7, 1, '1'),
(222, 'Program Director, Public Relations', 'national', 'normal', 7, 0, '1'),
(221, 'Discover Strat, Central', 'strat', 'hierarchy', 6, 4, '1'),
(220, 'Discover Strat, Deccan', 'strat', 'hierarchy', 6, 3, '1'),
(219, 'Discover Strat, North', 'strat', 'hierarchy', 6, 2, '1'),
(218, 'Discover Strat, South', 'strat', 'hierarchy', 6, 1, '1'),
(217, 'Program Director, Discover', 'national', 'normal', 6, 0, '1'),
(216, 'Propel Strat, Central', 'strat', 'hierarchy', 5, 4, '1'),
(215, 'Propel Strat, Deccan', 'strat', 'hierarchy', 5, 3, '1'),
(214, 'Propel Strat, North', 'strat', 'hierarchy', 5, 2, '1'),
(213, 'Propel Strat, South', 'strat', 'hierarchy', 5, 1, '1'),
(212, 'Program Director, Propel', 'national', 'normal', 5, 0, '1'),
(211, 'CS Strat, Central', 'strat', 'hierarchy', 4, 4, '1'),
(210, 'CS Strat, Deccan', 'strat', 'hierarchy', 4, 3, '1'),
(209, 'CS Strat, North', 'strat', 'hierarchy', 4, 2, '1'),
(208, 'CS Strat, South', 'strat', 'hierarchy', 4, 1, '1'),
(207, 'Program Director, Center Support', 'national', 'normal', 4, 0, '1'),
(206, 'ES Strat, Central', 'strat', 'hierarchy', 3, 4, '1'),
(205, 'ES Strat, Deccan', 'strat', 'hierarchy', 3, 3, '1'),
(204, 'ES Strat, North', 'strat', 'hierarchy', 3, 2, '1'),
(203, 'ES Strat, South', 'strat', 'hierarchy', 3, 1, '1'),
(202, 'Program Director, Ed Support', 'national', 'normal', 3, 0, '1'),
(201, 'CH Strat, Central', 'strat', 'hierarchy', 2, 4, '1'),
(200, 'CH Strat, Deccan', 'strat', 'hierarchy', 2, 3, '1'),
(199, 'CH Strat, North', 'strat', 'hierarchy', 2, 2, '1'),
(198, 'CH Strat, South', 'strat', 'hierarchy', 2, 1, '1'),
(359, 'Propel Strat', 'strat', 'normal', 5, 0, '1'),
(191, 'Operations Director, Central', 'national', 'hierarchy', 0, 4, '1'),
(190, 'Operations Director, Deccan', 'national', 'hierarchy', 0, 3, '1'),
(189, 'Operations Director, North', 'national', 'hierarchy', 0, 2, '1'),
(188, 'Operations Director, South', 'national', 'hierarchy', 0, 1, '1'),
(305, 'PR Fellow, South', 'fellow', 'hierarchy', 7, 1, '1'),
(306, 'PR Fellow, North', 'fellow', 'hierarchy', 7, 2, '1'),
(307, 'PR Fellow, Deccan', 'fellow', 'hierarchy', 7, 3, '1'),
(308, 'PR Fellow, Central', 'fellow', 'hierarchy', 7, 4, '1'),
(309, 'HR Fellow, South', 'fellow', 'hierarchy', 8, 1, '1'),
(310, 'HR Fellow, North', 'fellow', 'hierarchy', 8, 2, '1'),
(311, 'HR Fellow, Deccan', 'fellow', 'hierarchy', 8, 3, '1'),
(312, 'HR Fellow, Central', 'fellow', 'hierarchy', 8, 4, '1'),
(313, 'Finance Fellow, South', 'fellow', 'hierarchy', 9, 1, '1'),
(314, 'Finance Fellow, North', 'fellow', 'hierarchy', 9, 2, '1'),
(315, 'Finance Fellow, Deccan', 'fellow', 'hierarchy', 9, 3, '1'),
(316, 'Finance Fellow, Central', 'fellow', 'hierarchy', 9, 4, '1'),
(317, 'Events Fellow, South', 'fellow', 'hierarchy', 10, 1, '1'),
(318, 'Events Fellow, North', 'fellow', 'hierarchy', 10, 2, '1'),
(319, 'Events Fellow, Deccan', 'fellow', 'hierarchy', 10, 3, '1'),
(320, 'Events Fellow, Central', 'fellow', 'hierarchy', 10, 4, '1'),
(321, 'FH, South', 'fellow', 'hierarchy', 11, 1, '1'),
(322, 'FH, North', 'fellow', 'hierarchy', 11, 2, '1'),
(323, 'FH, Deccan', 'fellow', 'hierarchy', 11, 3, '1'),
(324, 'FH, Central', 'fellow', 'hierarchy', 11, 4, '1'),
(325, 'CFR Fellow, South', 'fellow', 'hierarchy', 12, 1, '1'),
(326, 'CFR Fellow, North', 'fellow', 'hierarchy', 12, 2, '1'),
(327, 'CFR Fellow, Deccan', 'fellow', 'hierarchy', 12, 3, '1'),
(328, 'CFR Fellow, Central', 'fellow', 'hierarchy', 12, 4, '1'),
(329, 'CR Fellow, South', 'fellow', 'hierarchy', 13, 1, '1'),
(330, 'CR Fellow, North', 'fellow', 'hierarchy', 13, 2, '1'),
(331, 'CR Fellow, Deccan', 'fellow', 'hierarchy', 13, 3, '1'),
(332, 'CR Fellow, Central', 'fellow', 'hierarchy', 13, 4, '1'),
(333, 'CTL Intern', 'volunteer', 'normal', 1, 0, '1'),
(334, 'CH Intern', 'volunteer', 'normal', 2, 0, '1'),
(335, 'ES Intern', 'volunteer', 'normal', 3, 0, '1'),
(336, 'CS Intern', 'volunteer', 'normal', 4, 0, '1'),
(337, 'Propel Intern', 'volunteer', 'normal', 5, 0, '1'),
(339, 'PR Intern', 'volunteer', 'normal', 7, 0, '1'),
(340, 'HR Intern', 'volunteer', 'normal', 8, 0, '1'),
(341, 'Finance Intern', 'volunteer', 'normal', 9, 0, '1'),
(343, 'FH Intern', 'volunteer', 'normal', 11, 0, '1'),
(344, 'CFR Intern', 'volunteer', 'normal', 12, 0, '1'),
(348, 'Propel Wingman', 'volunteer', 'normal', 5, 0, '1'),
(349, 'Propel Volunteer', 'volunteer', 'normal', 5, 0, '1'),
(361, 'Program Director, Problem Definition', 'national', 'normal', 15, 0, '1'),
(362, 'PD Fellow', 'fellow', 'normal', 15, 0, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Group`
--
ALTER TABLE `Group`
 ADD PRIMARY KEY (`id`), ADD KEY `vertical_id` (`vertical_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Group`
--
ALTER TABLE `Group`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=363;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
