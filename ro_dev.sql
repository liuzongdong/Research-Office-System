-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-06-27 03:13:40
-- 服务器版本： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ro_dev`
--

-- --------------------------------------------------------

--
-- 表的结构 `academic_monograph`
--

CREATE TABLE `academic_monograph` (
  `academic_monograph_id` int(11) NOT NULL,
  `academic_monograph_author_id` int(11) DEFAULT NULL,
  `academic_monograph_monograph_title` varchar(200) DEFAULT '',
  `academic_monograph_abstract` text,
  `academic_monograph_author` varchar(100) DEFAULT '',
  `academic_monograph_isbn_number` varchar(40) DEFAULT '',
  `academic_monograph_country` varchar(40) DEFAULT '',
  `academic_monograph_city` varchar(40) DEFAULT '',
  `academic_monograph_total_word` varchar(40) DEFAULT '',
  `academic_monograph_press` varchar(40) DEFAULT '',
  `academic_monograph_published_date` varchar(40) DEFAULT '',
  `academic_monograph_file` varchar(40) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `application`
--

CREATE TABLE `application` (
  `app_id` int(11) NOT NULL,
  `app_user_id` int(11) DEFAULT NULL,
  `app_title` varchar(40) DEFAULT '',
  `app_update_date` varchar(40) DEFAULT '',
  `action` varchar(10) DEFAULT '',
  `app_type` varchar(20) DEFAULT '',
  `file_src` varchar(200) DEFAULT '',
  `approval` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `conference_paper`
--

CREATE TABLE `conference_paper` (
  `conference_paper_id` int(11) NOT NULL,
  `conference_paper_user_id` int(11) DEFAULT NULL,
  `report_name` varchar(200) DEFAULT '',
  `conference_paper_abstract` text,
  `conference_paper_authors` varchar(100) DEFAULT '',
  `report_type` varchar(40) DEFAULT '',
  `conference_paper_name` varchar(200) DEFAULT '',
  `conference_paper_organizer` varchar(200) DEFAULT '',
  `region` varchar(40) DEFAULT '',
  `city` varchar(40) DEFAULT '',
  `address` varchar(40) DEFAULT '',
  `page_number` varchar(40) DEFAULT '',
  `start_date` varchar(40) DEFAULT '',
  `due_date` varchar(40) DEFAULT '',
  `published_date` varchar(40) DEFAULT '',
  `conference_paper_file` varchar(40) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `conference_presentation`
--

CREATE TABLE `conference_presentation` (
  `conference_presentation_id` int(11) NOT NULL,
  `conference_presentation_author_id` int(11) DEFAULT NULL,
  `conference_presentation_report_type` varchar(20) DEFAULT '',
  `conference_presentation_type_of_meeting` varchar(20) DEFAULT '',
  `conference_presentation_report_name` varchar(200) DEFAULT '',
  `conference_presentation_conference_name` varchar(200) DEFAULT '',
  `conference_presentation_abstract` text,
  `conference_presentation_author` varchar(100) DEFAULT '',
  `conference_presentation_country` varchar(40) DEFAULT '',
  `conference_presentation_conference_address` varchar(40) DEFAULT '',
  `conference_presentation_start_date` varchar(40) DEFAULT '',
  `conference_presentation_due_date` varchar(40) DEFAULT '',
  `conference_presentation_file` varchar(40) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `external_project`
--

CREATE TABLE `external_project` (
  `ep_id` int(11) NOT NULL,
  `ep_user_id` int(11) DEFAULT NULL,
  `ep_title` varchar(200) DEFAULT '',
  `ep_role` varchar(40) DEFAULT '',
  `ep_fundsource` varchar(40) DEFAULT '',
  `ep_duration_from` varchar(40) DEFAULT '',
  `ep_duration_to` varchar(40) NOT NULL DEFAULT '',
  `ep_amount` varchar(40) DEFAULT '',
  `ep_type` varchar(40) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `industry_project`
--

CREATE TABLE `industry_project` (
  `ip_id` int(11) NOT NULL,
  `ip_user_id` int(11) DEFAULT NULL,
  `ip_title` varchar(200) DEFAULT '',
  `ip_role` varchar(40) DEFAULT '',
  `ip_fundsource` varchar(40) DEFAULT '',
  `ip_duration_from` varchar(40) DEFAULT '',
  `ip_duration_to` varchar(40) NOT NULL DEFAULT '',
  `ip_amount` varchar(40) DEFAULT '',
  `ip_type` varchar(40) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `iv_project`
--

CREATE TABLE `iv_project` (
  `iv_project_id` int(11) NOT NULL,
  `iv_project_user_id` int(11) DEFAULT NULL,
  `iv_project_name` varchar(200) DEFAULT '',
  `iv_project_budget` varchar(40) DEFAULT '',
  `iv_project_file` varchar(100) DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `journal`
--

CREATE TABLE `journal` (
  `journal_id` int(11) NOT NULL,
  `journal_user_id` int(11) DEFAULT NULL,
  `journal_title` varchar(200) DEFAULT '',
  `journal_abstract` text,
  `journal_authors` varchar(100) DEFAULT '',
  `journal_name` varchar(200) DEFAULT '',
  `journal_date` varchar(40) DEFAULT '',
  `journal_status` int(11) DEFAULT '0',
  `sci` int(1) NOT NULL DEFAULT '0',
  `ei` int(1) NOT NULL DEFAULT '0',
  `istp` int(1) NOT NULL DEFAULT '0',
  `iff` int(1) NOT NULL DEFAULT '0',
  `acknowledged` int(1) NOT NULL DEFAULT '0',
  `journal_src` varchar(100) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `patent`
--

CREATE TABLE `patent` (
  `patent_id` int(11) NOT NULL,
  `patent_author_id` int(11) DEFAULT NULL,
  `patent_name` varchar(200) DEFAULT '',
  `patent_code` varchar(40) DEFAULT '',
  `patent_authorization` varchar(100) DEFAULT '',
  `patent_src` varchar(200) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `personnel_deveplopment`
--

CREATE TABLE `personnel_deveplopment` (
  `personnel_deveplopment_id` int(11) NOT NULL,
  `personnel_deveplopment_author_id` int(11) DEFAULT NULL,
  `personnel_deveplopment_training_category` varchar(200) DEFAULT '',
  `personnel_deveplopment_training_person` varchar(200) DEFAULT '',
  `personnel_deveplopment_author` varchar(200) DEFAULT '',
  `personnel_deveplopment_project_name` varchar(200) DEFAULT '',
  `personnel_deveplopment_abstract` text,
  `personnel_deveplopment_start_date` varchar(40) DEFAULT '',
  `personnel_deveplopment_due_date` varchar(40) DEFAULT '',
  `personnel_deveplopment_file` varchar(100) DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `research_award`
--

CREATE TABLE `research_award` (
  `research_award_id` int(11) NOT NULL,
  `research_award_author_id` int(11) DEFAULT NULL,
  `research_award_achievement_name` varchar(200) DEFAULT '',
  `research_award_abstract` text,
  `research_award_author` varchar(200) DEFAULT '',
  `research_award_assessment_organization` varchar(200) DEFAULT '',
  `research_award_reward_category` varchar(40) NOT NULL DEFAULT '',
  `research_award_reward_grade` varchar(40) NOT NULL DEFAULT '',
  `research_award_publication_time` varchar(40) DEFAULT '',
  `research_award_file` varchar(40) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `software_copyright`
--

CREATE TABLE `software_copyright` (
  `software_copyright_id` int(11) NOT NULL,
  `software_copyright_author_id` int(11) DEFAULT NULL,
  `software_copyright_dynacomm` varchar(200) DEFAULT '',
  `software_copyright_author` varchar(200) DEFAULT '',
  `software_copyright_registration_number` varchar(200) DEFAULT '',
  `software_copyright_way` varchar(20) DEFAULT '',
  `software_copyright_scope` varchar(20) DEFAULT '',
  `software_copyright_completion_time` varchar(40) DEFAULT '',
  `software_copyright_file` varchar(100) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `uic_project`
--

CREATE TABLE `uic_project` (
  `up_id` int(11) NOT NULL,
  `up_user_id` int(11) DEFAULT NULL,
  `up_title` varchar(200) DEFAULT '',
  `up_duration_from` varchar(40) DEFAULT '',
  `up_duration_to` varchar(40) NOT NULL DEFAULT '',
  `up_file` varchar(200) NOT NULL DEFAULT '',
  `action` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(40) DEFAULT '',
  `password` varchar(100) DEFAULT '',
  `user_type` int(11) DEFAULT '1',
  `last_name` varchar(40) DEFAULT '',
  `first_name` varchar(40) DEFAULT '',
  `english_name` varchar(40) CHARACTER SET utf8 DEFAULT 'Teacher',
  `division` varchar(10) DEFAULT '',
  `programme` varchar(10) DEFAULT '',
  `degree` varchar(40) DEFAULT '',
  `phone` varchar(40) DEFAULT '',
  `education_desc` text,
  `image_src` varchar(200) DEFAULT '',
  `ip_address` varchar(20) NOT NULL DEFAULT '0.0.0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_monograph`
--
ALTER TABLE `academic_monograph`
  ADD PRIMARY KEY (`academic_monograph_id`),
  ADD KEY `academic_monograph_author_id` (`academic_monograph_author_id`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `app_user_id` (`app_user_id`);

--
-- Indexes for table `conference_paper`
--
ALTER TABLE `conference_paper`
  ADD PRIMARY KEY (`conference_paper_id`),
  ADD KEY `conference_paper_user_id` (`conference_paper_user_id`);

--
-- Indexes for table `conference_presentation`
--
ALTER TABLE `conference_presentation`
  ADD PRIMARY KEY (`conference_presentation_id`),
  ADD KEY `conference_presentation_author_id` (`conference_presentation_author_id`);

--
-- Indexes for table `external_project`
--
ALTER TABLE `external_project`
  ADD PRIMARY KEY (`ep_id`),
  ADD KEY `ep_user_id` (`ep_user_id`);

--
-- Indexes for table `industry_project`
--
ALTER TABLE `industry_project`
  ADD PRIMARY KEY (`ip_id`),
  ADD KEY `ip_user_id` (`ip_user_id`);

--
-- Indexes for table `iv_project`
--
ALTER TABLE `iv_project`
  ADD PRIMARY KEY (`iv_project_id`),
  ADD KEY `iv_project_user_id` (`iv_project_user_id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `journal_user_id` (`journal_user_id`);

--
-- Indexes for table `patent`
--
ALTER TABLE `patent`
  ADD PRIMARY KEY (`patent_id`),
  ADD KEY `patent_author_id` (`patent_author_id`);

--
-- Indexes for table `personnel_deveplopment`
--
ALTER TABLE `personnel_deveplopment`
  ADD PRIMARY KEY (`personnel_deveplopment_id`),
  ADD KEY `personnel_deveplopment_author_id` (`personnel_deveplopment_author_id`);

--
-- Indexes for table `research_award`
--
ALTER TABLE `research_award`
  ADD PRIMARY KEY (`research_award_id`),
  ADD KEY `research_award_author_id` (`research_award_author_id`);

--
-- Indexes for table `software_copyright`
--
ALTER TABLE `software_copyright`
  ADD PRIMARY KEY (`software_copyright_id`),
  ADD KEY `software_copyright_author_id` (`software_copyright_author_id`);

--
-- Indexes for table `uic_project`
--
ALTER TABLE `uic_project`
  ADD PRIMARY KEY (`up_id`),
  ADD KEY `pub_user_id` (`up_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `academic_monograph`
--
ALTER TABLE `academic_monograph`
  MODIFY `academic_monograph_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `application`
--
ALTER TABLE `application`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `conference_paper`
--
ALTER TABLE `conference_paper`
  MODIFY `conference_paper_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `conference_presentation`
--
ALTER TABLE `conference_presentation`
  MODIFY `conference_presentation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `external_project`
--
ALTER TABLE `external_project`
  MODIFY `ep_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `industry_project`
--
ALTER TABLE `industry_project`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `iv_project`
--
ALTER TABLE `iv_project`
  MODIFY `iv_project_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `journal`
--
ALTER TABLE `journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `patent`
--
ALTER TABLE `patent`
  MODIFY `patent_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `personnel_deveplopment`
--
ALTER TABLE `personnel_deveplopment`
  MODIFY `personnel_deveplopment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `research_award`
--
ALTER TABLE `research_award`
  MODIFY `research_award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `software_copyright`
--
ALTER TABLE `software_copyright`
  MODIFY `software_copyright_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `uic_project`
--
ALTER TABLE `uic_project`
  MODIFY `up_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 限制导出的表
--

--
-- 限制表 `academic_monograph`
--
ALTER TABLE `academic_monograph`
  ADD CONSTRAINT `academic_monograph_ibfk_1` FOREIGN KEY (`academic_monograph_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`app_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `conference_paper`
--
ALTER TABLE `conference_paper`
  ADD CONSTRAINT `conference_paper_ibfk_1` FOREIGN KEY (`conference_paper_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `conference_presentation`
--
ALTER TABLE `conference_presentation`
  ADD CONSTRAINT `conference_presentation_ibfk_1` FOREIGN KEY (`conference_presentation_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `external_project`
--
ALTER TABLE `external_project`
  ADD CONSTRAINT `external_project_ibfk_1` FOREIGN KEY (`ep_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `industry_project`
--
ALTER TABLE `industry_project`
  ADD CONSTRAINT `industry_project_ibfk_1` FOREIGN KEY (`ip_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `iv_project`
--
ALTER TABLE `iv_project`
  ADD CONSTRAINT `iv_project_ibfk_1` FOREIGN KEY (`iv_project_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `journal`
--
ALTER TABLE `journal`
  ADD CONSTRAINT `journal_ibfk_1` FOREIGN KEY (`journal_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `patent`
--
ALTER TABLE `patent`
  ADD CONSTRAINT `patent_ibfk_1` FOREIGN KEY (`patent_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `personnel_deveplopment`
--
ALTER TABLE `personnel_deveplopment`
  ADD CONSTRAINT `personnel_deveplopment_ibfk_1` FOREIGN KEY (`personnel_deveplopment_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `research_award`
--
ALTER TABLE `research_award`
  ADD CONSTRAINT `research_award_ibfk_1` FOREIGN KEY (`research_award_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `software_copyright`
--
ALTER TABLE `software_copyright`
  ADD CONSTRAINT `software_copyright_ibfk_1` FOREIGN KEY (`software_copyright_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `uic_project`
--
ALTER TABLE `uic_project`
  ADD CONSTRAINT `uic_project_ibfk_1` FOREIGN KEY (`up_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
