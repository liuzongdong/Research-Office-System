CREATE TABLE `user` -- User table, users can use email or username to login.
(
    `user_id` int auto_increment primary key,
    `user_email` varchar(40) DEFAULT '',
    `username` varchar(40) DEFAULT '',
    `password` varchar(40) DEFAULT '',
    `user_type` int DEFAULT 0, -- 1 for teacher, 2 for PD, 3 for staff, 4 for admin.
    `last_name` varchar(40) DEFAULT '',
    `first_name` varchar(40) DEFAULT '',
    `english_name` varchar(40) DEFAULT '',
    `division` varchar(10) DEFAULT '',
    `programme` varchar(10) DEFAULT '',
    `degree` varchar(40) DEFAULT '',
    `phone` varchar(40) DEFAULT '',
    `education_desc` text DEFAULT '',
    `image_src` varchar(200) DEFAULT '' -- Used to Store Personal Photo.
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `application`
(
    `app_id` int(11) auto_increment primary key,
    `app_user_id` int(11),
    `app_title` varchar(200) DEFAULT '',
    `app_update_date` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    `app_type` varchar(10) DEFAULT '',
    `file_src` varchar(200) DEFAULT '',
    `approval` tinyint(1) DEFAULT 0,
    FOREIGN KEY (`app_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `external_project`
(
    `ep_id` int(11) auto_increment primary key,
    `ep_user_id` int(11),
    `ep_title` varchar(200) DEFAULT '',
    `ep_role` varchar(40) DEFAULT '',
    `ep_fundsource` varchar(40) DEFAULT '',
    `ep_duration` varchar(40) DEFAULT '',
    `ep_amount` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`ep_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `publication`
(
    `pub_id` int(11) auto_increment primary key,
    `pub_user_id` int(11),
    `pub_type` varchar(20) DEFAULT '',
    `pub_title` varchar(300) DEFAULT '',
    `pub_chapter` varchar(100) DEFAULT '',
    `pub_author` varchar(100) DEFAULT '',
    `pub_time` varchar(40) DEFAULT '',
    `pub_journal_name` varchar(100) DEFAULT '',
    `pub_vol` varchar(40) DEFAULT '',
    `pub_pp` varchar(40) DEFAULT '',
    `pub_conference_name` varchar(100) DEFAULT '',
    `pub_place` varchar(100) DEFAULT '',
    `pub_organizer` varchar(100) DEFAULT '',
    `pub_acknowleged` varchar(11) DEFAULT '',
    `pub_indexby` varchar(11) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`pub_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `uic_project`
(
    `up_id` int(11) auto_increment primary key,
    `pub_user_id` int(11),
    `up_title` varchar(200) DEFAULT '',
    `up_duration` varchar(40) DEFAULT '',
    `up_update_date` varchar(40) DEFAULT '',
    `up_fund_category` varchar(40) DEFAULT '',
    `up_budget` varchar(40) DEFAULT '',
    `up_inv_type` varchar(40) DEFAULT '',
    `up_inv_name` varchar(40) DEFAULT '',
    `up_inv_email` varchar(40) DEFAULT '',
    `up_inv_div` varchar(40) DEFAULT '',
    `up_inv_prog` varchar(40) DEFAULT '',
    `up_abstract` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`pub_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `journal`
(
    `journal_id` int(11) auto_increment primary key,
    `journal_user_id` int(11),
    `journal_title` varchar(200) DEFAULT '',
    `journal_abstract` text DEFAULT '',
    `journal_authors` varchar(100) DEFAULT '',
    `journal_name` varchar(200) DEFAULT '',
    `journal_date` varchar(40) DEFAULT '',
    `journal_status` int(11) DEFAULT 0, /* 0 for 'Accepted or Unpublished', 1 for 'Published' */
    `action` varchar(10) DEFAULT ''
    FOREIGN KEY (`journal_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `conference_paper`
(
    `conference_paper_id` int(11) auto_increment primary key,
    `conference_paper_user_id` int(11),
    `report_name` varchar(200) DEFAULT '',
    `conference_paper_abstract` text DEFAULT '',
    `conference_paper_authors` varchar(100) DEFAULT '',
    `report_type` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report', 3 for 'Poster Presentation' */
    `conference_paper_name` varchar(200) DEFAULT '',
    `conference_paper_organizer` varchar(200) DEFAULT '',
    `region` varchar(40) DEFAULT '',
    `city` varchar(40) DEFAULT ''
    `address` varchar(40) DEFAULT '',
    `page_number` varchar(40) DEFAULT '',
    `start_date` varchar(40) DEFAULT '',
    `due_date` varchar(40) DEFAULT '',
    `published_date` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT ''
    FOREIGN KEY (`conference_paper_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `academic_monograph`
(
    `academic_monograph_id` int(11) auto_increment primary key,
    `academic_monograph_author_id` int(11),
    `academic_monograph_monograph_title` varchar(200) DEFAULT '',
    `academic_monograph_abstract` text DEFAULT '',
    `academic_monograph_author` varchar(100) DEFAULT '',
    `academic_monograph_isbn_number` varchar(40) DEFAULT '',
    `academic_monograph_country` varchar(40) DEFAULT '',
    `academic_monograph_city` varchar(40) DEFAULT '',
    `academic_monograph_total_word` varchar(40) DEFAULT '',
    `academic_monograph_press` varchar(40) DEFAULT '',
    `academic_monograph_published_date` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT ''
    FOREIGN KEY (`academic_monograph_author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `patent` -- Patent table
(
    `patent_id` int auto_increment primary key,
    `patent_author_id` int(11),
    `patent_name` varchar(200) DEFAULT '',
    `paten_code` varchar(40) DEFAULT '',
    `patent_authorization` varchar(100) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`patent_author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE --当外键的值删除, 本表中对应的列筛除, 当外键的值改变, 本表中对应的列值改变
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `conference_presentation`
(
    `conference_presentation_id` int(11) auto_increment primary key,
    `conference_presentation_author_id` int(11),
    `conference_presentation_report_type` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report', 3 for 'Poster Presentation' */
    `conference_presentation_type_of_meeting` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report', 3 for 'Poster Presentation' */
    `conference_presentation_report_name` varchar(200) DEFAULT '',
    `conference_presentation_conference_name` varchar(200) DEFAULT '',
    `conference_presentation_abstract` text DEFAULT '',
    `conference_presentation_author` varchar(100) DEFAULT '',
    `conference_presentation_country` varchar(40) DEFAULT '',
    `conference_presentation_conference_address` varchar(40) DEFAULT '',
    `conference_presentation_start_date` varchar(40) DEFAULT '',
    `conference_presentation_due_date` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`conference_presentation_author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `software_copyright`
(
    `software_copyright_id` int auto_increment primary key,
    `software_copyright_author_id` int(11),
    `software_copyright_dynacomm` varchar(200) DEFAULT '',
    `software_copyright_author` varchar(200) DEFAULT '',
    `software_copyright_registration_number` varchar(200) DEFAULT '',
    `software_copyright_way` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report' */
    `software_copyright_scope` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report' */
    `software_copyright_completion_time` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`software_copyright_author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `research_award` -- Patent table
(
    `research_award_id` int auto_increment primary key,
    `research_award_author_id` int(11),
    `research_award_achievement_name` varchar(200) DEFAULT '',
    `research_award_abstract` text DEFAULT'',
    `research_award_author` varchar(200) DEFAULT '',
    `research_award_assessment_organization` varchar(200) DEFAULT '',
    `research_award_reward_category` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report' */
    `research_award_reward_grade` int(11) DEFAULT 1, /* 1 for 'Invited Report', 2 for 'Group Report' */
    `research_award_publication_time` varchar(40) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`research_award_author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `personnel_deveplopment`
(
    `personnel_deveplopment_id` int auto_increment primary key,
    `personnel_deveplopment_author_id` int(11),
    `personnel_deveplopment_training_category` varchar(200) DEFAULT '',
    `personnel_deveplopment_training_person` varchar(200) DEFAULT '',
    `personnel_deveplopment_author` varchar(200) DEFAULT '',
    `personnel_deveplopment_project_name` varchar(200) DEFAULT '',
    `personnel_deveplopment_abstract` text DEFAULT'',
    `personnel_deveplopment_start_date` varchar(40) DEFAULT '',
    `personnel_deveplopment_due_date` varchar(40) DEFAULT '',
    `personnel_deveplopment_file` varchar(100) DEFAULT '', /* 1 for 'Invited Report', 2 for 'Group Report' */
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`personnel_deveplopment_author_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `iv_project`
(
    `iv_project_id` int auto_increment primary key,
    `iv_project_user_id` int(11),
    `iv_project_name` varchar(200) DEFAULT '',
    `iv_project_budget` varchar(40) DEFAULT '',
    `iv_project_file` varchar(100) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`iv_project_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `completion_report`
(
    `completion_report_id` int auto_increment primary key,
    `completion_report_user_id` int(11),
    `completion_report_form_title` varchar(200) DEFAULT '',
    `cr_principal_investigator_name` varchar(200) DEFAULT '',
    `cr_principal_investigator_unit` varchar(200) DEFAULT '',
    `cr_co_investigator_name` varchar(200) DEFAULT '',
    `cr_co_investigator_unit` varchar(200) DEFAULT '',
    `cr_others_name` varchar(200) DEFAULT '',
    `cr_others_unit` varchar(200) DEFAULT '',
    `completion_report_form_project_starting_date` varchar(20) DEFAULT '',
    `completion_report_form_project_completion_date` varchar(20) DEFAULT '',
    `actual_project_starting_date` varchar(20) DEFAULT '',
    `actual_project_completion_date` varchar(20) DEFAULT '',
    `completion_report_file` varchar(200) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`completion_report_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_undertaking`
(
    `project_undertaking_id` int auto_increment primary key,
    `project_undertaking_user_id` int(11),
    `project_undertaking_title` varchar(200) DEFAULT '',
    `project_undertaking_type` varchar(20) DEFAULT '',
    `project_undertaking_file` varchar(200) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`project_undertaking_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `midterm_report`
(
    `midterm_report_id` int auto_increment primary key,
    `midterm_report_user_id` int(11),
    `midterm_progress_report_form_title` varchar(200) DEFAULT '',
    `mp_principal_investigator_name` varchar(200) DEFAULT '',
    `mp_principal_investigator_unit` varchar(200) DEFAULT '',
    `mp_co_investigator_name` varchar(200) DEFAULT '',
    `mp_co_investigator_unit` varchar(200) DEFAULT '',
    `mp_others_name` varchar(200) DEFAULT '',
    `mp_others_unit` varchar(200) DEFAULT '',
    `midterm_progress_report_form_project_starting_date` varchar(20) DEFAULT '',
    `midterm_progress_report_form_project_completion_date` varchar(20) DEFAULT '',
    `midterm_progress_report_form_duration` varchar(20) DEFAULT '',
    `midterm_report_file` varchar(200) DEFAULT '',
    `action` varchar(10) DEFAULT '',
    FOREIGN KEY (`midterm_report_user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


SELECT `patent_name`, `patent_code`, `english_name`, `division` FROM `patent`, `user` WHERE patent.patent_author_id = user.user_id AND user.user_id = 1
