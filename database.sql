-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2013 at 03:10 AM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ficom`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `graduation_year` int(4) unsigned NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`contact_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contact data for members of groups.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts_altemails`
--

CREATE TABLE `contacts_altemails` (
  `altemail_id` int(8) NOT NULL AUTO_INCREMENT,
  `contact_id` int(8) unsigned NOT NULL,
  `altemail` varchar(255) NOT NULL,
  PRIMARY KEY (`altemail_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Alternate email addresses for contacts' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grants`
--

CREATE TABLE `grants` (
  `grant_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(8) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `undergrads_involved` smallint(5) unsigned NOT NULL,
  `undergrads_benefiting` smallint(5) unsigned NOT NULL,
  `community_benefiting` smallint(5) NOT NULL,
  `contact_id` int(8) unsigned DEFAULT NULL,
  `amount_requested` decimal(10,2) unsigned NOT NULL,
  `amount_funded` decimal(10,2) unsigned NOT NULL,
  `amount_cpf` decimal(10,2) unsigned NOT NULL,
  `type_code` tinyint(3) unsigned NOT NULL,
  `status_code` tinyint(3) unsigned NOT NULL,
  `grantspack_id` int(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`grant_id`),
  KEY `group_id` (`group_id`),
  KEY `grantspack_id` (`grantspack_id`),
  KEY `contact_id` (`contact_id`),
  KEY `status_code` (`status_code`),
  KEY `type_code` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Metadata for grants' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grantspacks`
--

CREATE TABLE `grantspacks` (
  `grantspack_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(8) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type_code` tinyint(3) unsigned NOT NULL,
  `total_requested` decimal(10,2) unsigned NOT NULL,
  `total_funded` decimal(10,2) unsigned NOT NULL,
  `status_code` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`grantspack_id`),
  KEY `session_id` (`session_id`),
  KEY `type_code` (`type_code`),
  KEY `status_code` (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Metadata and summary info for grants packs' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grantspacks_statuses`
--

CREATE TABLE `grantspacks_statuses` (
  `status_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Reference table for the status of a grants pack' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grantspacks_types`
--

CREATE TABLE `grantspacks_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Reference table for types of grants packs.' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `grants_items`
--

CREATE TABLE `grants_items` (
  `item_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `grant_id` int(8) unsigned NOT NULL,
  `description` varchar(1000) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cg_category` varchar(255) NOT NULL,
  `category_code` tinyint(3) unsigned NOT NULL,
  `note` varchar(255) NOT NULL,
  `type_code` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `grant_id` (`grant_id`),
  KEY `type_code` (`category_code`),
  KEY `grant_id_2` (`grant_id`),
  KEY `type_code_2` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Line item expenses and revenues' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grants_items_categories`
--

CREATE TABLE `grants_items_categories` (
  `category_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`category_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Categories for line item expenditures' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grants_items_types`
--

CREATE TABLE `grants_items_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Types (revenue/expenditure/inactive) for grant items' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `grants_statuses`
--

CREATE TABLE `grants_statuses` (
  `status_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`status_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `grants_types`
--

CREATE TABLE `grants_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Types for grants (regular, wintersession, etc.)' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tax_id` int(9) DEFAULT NULL,
  `advisor` varchar(255) NOT NULL,
  `type_code` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `name` (`name`),
  KEY `type_code` (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Metadata for groups applying for grants' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_altnames`
--

CREATE TABLE `groups_altnames` (
  `altname_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(8) unsigned NOT NULL,
  `altname` varchar(255) NOT NULL,
  PRIMARY KEY (`altname_id`),
  KEY `group_id` (`group_id`),
  KEY `group_id_2` (`group_id`),
  KEY `group_id_3` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Alternate names for groups' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_notes`
--

CREATE TABLE `groups_notes` (
  `note_id` int(8) NOT NULL,
  `group_id` int(8) unsigned NOT NULL,
  `note` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_code` tinyint(3) unsigned NOT NULL,
  KEY `type_code` (`type_code`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Text notes on groups.';

-- --------------------------------------------------------

--
-- Table structure for table `groups_notes_types`
--

CREATE TABLE `groups_notes_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Types (regard/alert) for groups' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_positions`
--

CREATE TABLE `groups_positions` (
  `position_id` int(8) NOT NULL AUTO_INCREMENT,
  `contact_id` int(8) unsigned NOT NULL,
  `group_id` int(8) unsigned NOT NULL,
  `position` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_code` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`position_id`),
  KEY `contact_id` (`contact_id`,`group_id`),
  KEY `group_id` (`group_id`),
  KEY `type_code` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pivot table connecting contacts to groups' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_positions_types`
--

CREATE TABLE `groups_positions_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Type of position within a group' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_types`
--

CREATE TABLE `groups_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Type of group' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sessions_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `abbreviation` varchar(255) NOT NULL,
  `total_requested` decimal(10,2) NOT NULL,
  `total_funded` decimal(10,2) NOT NULL,
  `type_code` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`sessions_id`),
  KEY `type_code` (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions_types`
--

CREATE TABLE `sessions_types` (
  `type_code` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL COMMENT 'Text name of type to display',
  PRIMARY KEY (`type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `security_level` int(8) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts_altemails`
--
ALTER TABLE `contacts_altemails`
  ADD CONSTRAINT `contacts_altemails_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grants`
--
ALTER TABLE `grants`
  ADD CONSTRAINT `grants_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grants_ibfk_2` FOREIGN KEY (`grantspack_id`) REFERENCES `grantspacks` (`grantspack_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grants_ibfk_5` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grants_ibfk_6` FOREIGN KEY (`status_code`) REFERENCES `grants_statuses` (`status_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grants_ibfk_7` FOREIGN KEY (`type_code`) REFERENCES `grants_types` (`type_code`) ON UPDATE CASCADE;

--
-- Constraints for table `grantspacks`
--
ALTER TABLE `grantspacks`
  ADD CONSTRAINT `grantspacks_ibfk_2` FOREIGN KEY (`type_code`) REFERENCES `grantspacks_types` (`type_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grantspacks_ibfk_3` FOREIGN KEY (`status_code`) REFERENCES `grants_statuses` (`status_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grantspacks_ibfk_5` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`sessions_id`) ON UPDATE CASCADE;

--
-- Constraints for table `grants_items`
--
ALTER TABLE `grants_items`
  ADD CONSTRAINT `grants_items_ibfk_5` FOREIGN KEY (`type_code`) REFERENCES `grants_items_types` (`type_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `grants_items_ibfk_3` FOREIGN KEY (`grant_id`) REFERENCES `grants` (`grant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grants_items_ibfk_4` FOREIGN KEY (`category_code`) REFERENCES `grants_items_categories` (`category_code`) ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`type_code`) REFERENCES `groups_types` (`type_code`) ON UPDATE CASCADE;

--
-- Constraints for table `groups_altnames`
--
ALTER TABLE `groups_altnames`
  ADD CONSTRAINT `groups_altnames_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups_notes`
--
ALTER TABLE `groups_notes`
  ADD CONSTRAINT `groups_notes_ibfk_1` FOREIGN KEY (`type_code`) REFERENCES `groups_notes_types` (`type_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_notes_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups_positions`
--
ALTER TABLE `groups_positions`
  ADD CONSTRAINT `groups_positions_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_positions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_positions_ibfk_3` FOREIGN KEY (`type_code`) REFERENCES `groups_positions_types` (`type_code`) ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`type_code`) REFERENCES `sessions_types` (`type_code`) ON UPDATE CASCADE;
