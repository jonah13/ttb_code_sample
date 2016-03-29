<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_db extends CI_Controller 
{
	const NB_COMMENTS_PER_PAGE = 10000000;
	protected $page_data;
	protected $db_name = 'ttb2';
	protected $old_db_name = 'ttbproduction';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function generate_queries()
	{
		$db_name = $this->db_name;
		$old_db_name = $this->old_db_name;

		echo "<br/><br/>-- --------------------------------  create all tables -------------------------------------<br/>";		



		//transfer all users
		$query = "
			CREATE TABLE IF NOT EXISTS `users` (
			  `ID` int(10) unsigned NOT NULL auto_increment,
			  `username` varchar(20) NOT NULL,
			  `password` varchar(20) NOT NULL,
			  `email` varchar(50) NOT NULL,
			  `phone` varchar(20) default NULL,
			  `first_name` varchar(20) default NULL,
			  `last_name` varchar(20) default NULL,
			  `type` varchar(20) default NULL,
			  `signup_date` datetime default NULL,
			  `last_login` datetime default NULL,
			  `is_active` int(11) NOT NULL default '1',
			  PRIMARY KEY  (`ID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

			INSERT ".$db_name.".users
			(ID, username, password, email, phone, first_name, last_name, type, signup_date, last_login, is_active)
			SELECT ID, username, password, email, phone, first_name, last_name, type, sign_up_date, last_login, active
			FROM ".$old_db_name.".users o_u
			WHERE NOT EXISTS (SELECT * FROM ".$db_name.".users u WHERE o_u.ID = u.ID)
		";

		echo "<br/><br/>-- --------------------------------  TRANSFER USERS -------------------------------------<br/>";
		echo $query;

		//transfer all companies
		$query ="
			CREATE TABLE IF NOT EXISTS `companies` (
			  `ID` int(10) unsigned NOT NULL auto_increment,
			  `name` varchar(50) NOT NULL,
			  `address` varchar(100) default NULL,
			  `city` varchar(20) default NULL,
			  `state` varchar(20) default NULL,
			  `zipcode` varchar(20) default NULL,
			  `date_added` datetime NOT NULL,
			  `company_contact` varchar(50) default NULL,
			  `contact_phone` varchar(20) default NULL,
			  `contact_email` varchar(50) default NULL,
			  `website` varchar(50) default NULL,
			  `business_type` varchar(50) default NULL,
			  `is_active` int(11) NOT NULL default '1',
			  `is_test` int(11) default '0',
			  `qr_header` varchar(100) default NULL,
			  `qr_comment_label` varchar(500) default NULL,
			  `qr_success_text` varchar(1000) default NULL,
			  `sms_first_reply` varchar(500) default NULL,
			  `sms_last_reply` varchar(500) default NULL,
			  `s_header_logo` varchar(20) default NULL,
			  `s_body_bg_type` varchar(20) NOT NULL default 'gradient',
			  `s_body_bg1` varchar(20) default NULL,
			  `s_body_bg2` varchar(20) default NULL,
			  `s_body_bg_pic` varchar(20) default NULL,
			  `s_header_bg_type` varchar(20) NOT NULL default 'gradient',
			  `s_header_bg1` varchar(20) default NULL,
			  `s_header_bg2` varchar(20) default NULL,
			  `s_header_bg_pic` varchar(20) default NULL,
			  `s_header_fcolor` varchar(20) default NULL,
			  `s_header_ffamily` varchar(100) default NULL,
			  `s_header_fsize` int(11) default NULL,
			  `s_labels_fcolor` varchar(20) default NULL,
			  `s_labels_ffamily` varchar(100) default NULL,
			  `s_labels_fsize` int(11) default NULL,
			  `cf_asked_for` varchar(20) default NULL,
			  `cf_type` varchar(20) default NULL,
			  `cf_qr_label` varchar(500) default NULL,
			  `cf_required` int(11) default NULL,
			  `cf_pos` varchar(20) default NULL,
			  `cf_sms_text` varchar(500) default NULL,
			  `cf_sms_pos` varchar(20) default NULL,
			  `cf2_asked_for` varchar(20) default NULL,
			  `cf2_type` varchar(20) default NULL,
			  `cf2_required` int(11) default NULL,
			  `cf2_qr_label` varchar(500) default NULL,
			  `cf2_pos` varchar(20) default NULL,
			  `cf2_sms_text` varchar(500) default NULL,
			  `cf2_sms_pos` varchar(20) default NULL,
			  `unitname` varchar(64) NOT NULL,
			  `qr-order` varchar(64) NOT NULL,
			  `qr-rating-text` varchar(128) NOT NULL,
			  `qr-idfield-text` varchar(128) NOT NULL,
			  `qr-comment-text` varchar(128) NOT NULL,
			  `qr-contact-text` varchar(128) NOT NULL,
			  `qr-contest-text` varchar(128) NOT NULL,
			  `qr-reply-text` varchar(128) NOT NULL,
			  `sms-order` varchar(64) NOT NULL,
			  `sms-rating-text` varchar(128) NOT NULL,
			  `sms-idfield-text` varchar(128) NOT NULL,
			  `sms-comment-text` varchar(128) NOT NULL,
			  `sms-contact-text` varchar(128) NOT NULL,
			  `sms-contest-text` varchar(128) NOT NULL,
			  `sms-reply-text` varchar(128) NOT NULL,
			  `qr-idfield-answers` varchar(128) NOT NULL,
			  `sms-idfield-answers` varchar(128) NOT NULL,
			  PRIMARY KEY  (`ID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

			INSERT ".$db_name.".companies
			(ID, name, address, city, state, zipcode, date_added, company_contact, contact_phone, contact_email,is_active)
			SELECT ID, name, address, city, state, zipcode, date_added, company_contact, phone, email,active
			FROM ".$old_db_name.".companies o_u
			WHERE NOT EXISTS (SELECT * FROM ".$db_name.".companies u WHERE o_u.ID = u.ID)
		";

		echo "<br/><br/>-- --------------------------------  TRANSFER COMPANIES -------------------------------------<br/>";
		echo $query;

		//transfer all locations
		$query = "
			CREATE TABLE IF NOT EXISTS `locations` (
			  `ID` int(10) unsigned NOT NULL auto_increment,
			  `name` varchar(50) NOT NULL,
			  `business_type` varchar(50) default NULL,
			  `address` varchar(100) default NULL,
			  `city` varchar(20) default NULL,
			  `state` varchar(20) default NULL,
			  `zipcode` varchar(20) default NULL,
			  `website` varchar(50) default NULL,
			  `is_active` int(11) default '1',
			  `timezone` varchar(20) NOT NULL default 'PST',
			  `company_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY  (`ID`),
			  KEY `fk_locations_companies1_idx` (`company_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

			INSERT ".$db_name.".locations
			(ID, company_id, name, business_type, address, city, state, zipcode, website, timezone)
			(
			  SELECT ID, company_id, name, business_type, address, city, state, zipcode, website, timezone
			  FROM ".$old_db_name.".stores o_u
			  where ID in (
			    select ID from ".$old_db_name.".stores
			    where company_id in (SELECT ID FROM ".$db_name.".companies)
			    )
				AND NOT EXISTS (SELECT * FROM ".$db_name.".locations u WHERE o_u.ID = u.ID)
			);
		";

		echo "<br/><br/>-- --------------------------------  TRANSFER LOCATIONS -------------------------------------<br/>";
		echo $query;

		//transfer all codes
		$query = "
			CREATE TABLE IF NOT EXISTS `codes` (
			  `ID` int(10) unsigned NOT NULL auto_increment,
			  `code` varchar(20) NOT NULL,
			  `description` varchar(2000) default NULL,
			  `is_global` int(11) NOT NULL default '0',
			  `negative_type` varchar(20) NOT NULL default 'any_negative',
			  `location_id` int(10) unsigned NOT NULL,
			  `company_id` int(11) NOT NULL,
			  `idfieldset` varchar(64) NOT NULL,
			  PRIMARY KEY  (`ID`),
			  UNIQUE KEY `code_UNIQUE` (`code`),
			  KEY `fk_codes_locations1_idx` (`location_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

			INSERT ".$db_name.".codes
			(ID, code, description, is_global, location_id, company_id)
			SELECT ID, code, description, is_global, store_id, company_id
			FROM ".$old_db_name.".codes o_u
			WHERE NOT EXISTS (SELECT * FROM ".$db_name.".codes u WHERE o_u.ID = u.ID)
		";

		echo "<br/><br/>-- --------------------------------  TRANSFER CODES -------------------------------------<br/>";
		echo $query;

		//transfer all comments
		$query = "
			CREATE TABLE IF NOT EXISTS `comments` (
			  `ID` int(10) unsigned NOT NULL auto_increment,
			  `comment` varchar(2000) character set utf8 collate utf8_unicode_ci NOT NULL,
			  `time` datetime NOT NULL,
			  `comment_time` datetime NOT NULL,
			  `time_type` varchar(20) NOT NULL default 'specific',
			  `analyzer_nature` varchar(20) default NULL,
			  `nature` varchar(20) NOT NULL,
			  `origin` varchar(20) NOT NULL,
			  `extra_data` varchar(50) default NULL,
			  `sec_extra_data` varchar(50) default NULL,
			  `indirect_origin` varchar(20) default NULL,
			  `phone_number` varchar(20) default NULL,
			  `ip_address` varchar(20) default NULL,
			  `cookie_id` varchar(50) default NULL,
			  `user_agent` varchar(120) default NULL,
			  `session_id` varchar(50) default NULL,
			  `admin_id` int(11) default NULL,
			  `code_id` int(10) unsigned NOT NULL,
			  `code` varchar(20) default NULL,
			  `location_id` int(11) NOT NULL,
			  `company_id` int(11) NOT NULL,
			  `is_test` int(11) NOT NULL default '0',
			  `seen` int(11) NOT NULL default '0',
			  `seen_by` int(11) default '15',
			  `rating` varchar(3) NOT NULL,
			  `contact` varchar(64) NOT NULL,
			  `unit` varchar(64) NOT NULL,
			  `contest` varchar(64) NOT NULL,
			  PRIMARY KEY  (`ID`),
			  KEY `fk_comments_codes1_idx` (`code_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

			INSERT ".$db_name.".comments
			(ID, comment, time, comment_time, time_type, analyzer_nature, nature, origin, extra_data, sec_extra_data, indirect_origin, code, code_id, session_id)
			(
			  SELECT  
			        cm.ID, cm.comment, time, time, cm.time_type,
			        cm.nature, cm.nature, 
			        cm.origin, cm.extra_data, cm.sec_extra_data, 
			        cm.indirect_source, cm.code, co.ID,cm.session_id
			  FROM ".$old_db_name.".comments cm 
			  inner join ".$old_db_name.".codes co on cm.code = co.code
				WHERE NOT EXISTS (SELECT * FROM ".$db_name.".comments c WHERE cm.ID = c.ID)
			);
		";

		echo "<br/><br/>-- --------------------------------  TRANSFER COMMENTS -------------------------------------<br/>";
		echo $query;

		//transfer user rights
		$query = "
			CREATE TABLE IF NOT EXISTS `user_rights` (
			  `user_id` int(10) unsigned default NULL,
			  `target_type` varchar(45) default NULL,
			  `company_id` int(10) unsigned default NULL,
			  `location_id` int(10) unsigned default NULL,
			  `code_id` int(10) unsigned default NULL,
			  `group_id` int(10) unsigned default NULL,
			  KEY `fk_user_rights_users` (`user_id`),
			  KEY `fk_user_rights_companies1_idx` (`company_id`),
			  KEY `fk_user_rights_locations1_idx` (`location_id`),
			  KEY `fk_user_rights_codes1_idx` (`code_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;


			INSERT INTO ".$db_name.".user_rights
			(user_id, target_type, company_id, location_id, code_id, group_id) 
			( 
				SELECT c.user_id , 'company', c.id, NULL, NULL, NULL  from ".$old_db_name.".companies c
				where c.user_id in (select id from ".$db_name.".users)
				and c.id in (select id from ".$db_name.".companies)
			);
			INSERT INTO ".$db_name.".user_rights
			(user_id, target_type, company_id, location_id, code_id, group_id) 
			( 
				select l.user_id , 'location', NULL, l.id, NULL, NULL  from ".$old_db_name.".user_stores l
				where l.user_id in (select id from users)
				and l.id in (select id from ".$db_name.".locations)
			);
		";	

			echo "<br/><br/>-- --------------------------------  TRANSFER USER RIGHTS -------------------------------------<br/>";
		echo $query;
	
	
	}
}