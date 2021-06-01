/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
USE shulnet;

DROP TABLE IF EXISTS ppSD_abuse;
CREATE TABLE `ppSD_abuse` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) DEFAULT NULL,
  `time` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_access_granters;
CREATE TABLE `ppSD_access_granters` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(35) DEFAULT NULL COMMENT 'ppSD_products ID or ppSD_',
  `type` enum('content','newsletter') DEFAULT NULL,
  `grants_to` varchar(25) DEFAULT NULL COMMENT 'ppSD_content ID ppSD_event_timeline ID or ppSD_events ID',
  `timeframe` varchar(12) DEFAULT NULL COMMENT 'For subscription product, always matches that timeframe.',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`,`grants_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_accounts;
CREATE TABLE `ppSD_accounts` (
  `id` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(65) DEFAULT NULL,
  `contact_frequency` varchar(12) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `default` tinyint(1) DEFAULT '0',
  `master_user` varchar(20) DEFAULT NULL COMMENT 'This is a ppSD_member ID.',
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '0',
  `last_updated` datetime DEFAULT '1920-01-01 00:01:01',
  `last_updated_by` mediumint(6) DEFAULT NULL,
  `last_action` datetime DEFAULT '1920-01-01 00:01:01',
  `source` mediumint(5) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `start_page` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_user` (`master_user`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_account_data;
CREATE TABLE `ppSD_account_data` (
  `account_id` varchar(10) NOT NULL DEFAULT '',
  `address_line_1` varchar(125) DEFAULT NULL,
  `address_line_2` varchar(75) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `office_phone` varchar(25) DEFAULT NULL,
  `alt_phone` varchar(25) DEFAULT NULL,
  `fax` varchar(25) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `url` varchar(125) DEFAULT NULL,
  `industry` varchar(45) DEFAULT NULL,
  `account_type` varchar(25) DEFAULT NULL,
  `email_optout` tinyint(1) DEFAULT '0',
  `facebook` varchar(125) DEFAULT NULL,
  `twitter` varchar(125) DEFAULT NULL,
  `linkedin` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  KEY `company_name` (`company_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_account_types;
CREATE TABLE `ppSD_account_types` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `type` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_activity_methods;
CREATE TABLE `ppSD_activity_methods` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `icon` varchar(35) DEFAULT NULL,
  `link` varchar(35) DEFAULT NULL,
  `link_type` enum('popup','popup_large','link','slider') DEFAULT NULL,
  `custom` tinyint(1) DEFAULT '1',
  `text` varchar(75) DEFAULT NULL,
  `in_feed` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_bounced_emails;
CREATE TABLE `ppSD_bounced_emails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email_id` varchar(35) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `user_id` varchar(25) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cache;
CREATE TABLE `ppSD_cache` (
  `act_id` varchar(45) NOT NULL DEFAULT '',
  `data` longtext,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `expires` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_calendars;
CREATE TABLE `ppSD_calendars` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL DEFAULT '',
  `template` mediumint(5) DEFAULT NULL,
  `members_only` tinyint(1) DEFAULT '1',
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `style` tinyint(1) DEFAULT '1' COMMENT '1 = Calendar, 2 = Long List, 3 = Cloud',
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_campaigns;
CREATE TABLE `ppSD_campaigns` (
  `id` varchar(11) NOT NULL DEFAULT '',
  `when_type` enum('after_join','exact_date') DEFAULT NULL,
  `criteria_id` int(9) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `type` enum('email','sms','facebook','twitter') DEFAULT NULL,
  `user_type` enum('member','contact','rsvp','account') DEFAULT NULL,
  `name` varchar(85) DEFAULT NULL,
  `kill_condition` enum('on_open','unsubscribe','purchase','register','form_submit','rsvp') DEFAULT NULL,
  `owner` mediumint(5) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 = Active, 2 = Paused',
  `update_activity` tinyint(1) DEFAULT '1',
  `last_sent` datetime DEFAULT '1920-01-01 00:01:01',
  `optin_type` enum('criteria','single_optin','double_optin') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `criteria_id` (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_campaign_items;
CREATE TABLE `ppSD_campaign_items` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(85) DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  `msg_id` varchar(35) DEFAULT NULL,
  `when_timeframe` varchar(12) DEFAULT NULL,
  `when_date` datetime DEFAULT '1920-01-01 00:01:01',
  `template_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `msg_id` (`msg_id`),
  KEY `template_id` (`template_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_campaign_logs;
CREATE TABLE `ppSD_campaign_logs` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `user_id` varchar(35) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `trackback_id` varchar(27) DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  `saved_id` varchar(35) DEFAULT NULL COMMENT 'Matches ppSD_saved_emails',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_campaign_subscriptions;
CREATE TABLE `ppSD_campaign_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` varchar(11) DEFAULT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  `user_type` enum('member','contact') DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `subscribed_by` enum('user','employee','condition','criteria') DEFAULT NULL,
  `subscribed_by_id` varchar(15) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `optin_id` varchar(20) DEFAULT NULL,
  `optin_date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Campaigns can be criteria based or subscription-based.';

DROP TABLE IF EXISTS ppSD_campaign_unsubscribe;
CREATE TABLE `ppSD_campaign_unsubscribe` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `user_id` varchar(20) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  `by` enum('user','staff','kill_condition','bounce') DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `staff` mediumint(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_captcha;
CREATE TABLE `ppSD_captcha` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `captcha` varchar(25) DEFAULT NULL,
  `redirect` mediumtext,
  `type` enum('staff','user') DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL COMMENT 'Can me ip, staff username, or member id',
  `form_session` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_session` (`form_session`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_billing;
CREATE TABLE `ppSD_cart_billing` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(125) DEFAULT NULL,
  `method` enum('Credit Card','Check','PayPal','Invoice','Other') DEFAULT NULL,
  `card_type` enum('','Visa','Mastercard','Amex','Diners','Discover','JCB') DEFAULT NULL,
  `gateway` varchar(35) DEFAULT NULL COMMENT 'ppSD_payment_gateways',
  `gateway_id_1` varchar(45) DEFAULT NULL,
  `gateway_id_2` varchar(45) DEFAULT NULL,
  `company_name` varchar(125) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `cc_number` varchar(255) DEFAULT NULL,
  `card_exp_yy` varchar(255) DEFAULT NULL,
  `card_exp_mm` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `member_id` varchar(20) DEFAULT NULL,
  `salt` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_categories;
CREATE TABLE `ppSD_cart_categories` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `description` text,
  `meta_title` varchar(69) DEFAULT NULL,
  `meta_desc` varchar(156) DEFAULT NULL,
  `meta_keywords` varchar(150) DEFAULT NULL,
  `subcategory` mediumint(5) DEFAULT NULL,
  `template_id` varchar(65) DEFAULT NULL,
  `cols` tinyint(1) DEFAULT '0',
  `search_index` tinyint(1) DEFAULT '0',
  `public` tinyint(1) DEFAULT '0',
  `hide` tinyint(1) DEFAULT '0',
  `members_only` tinyint(1) DEFAULT '0',
  `owner` mediumint(6) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `subcategory` (`subcategory`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_coupon_codes;
CREATE TABLE `ppSD_cart_coupon_codes` (
  `id` varchar(15) NOT NULL DEFAULT '',
  `description` varchar(150) DEFAULT NULL,
  `dollars_off` decimal(8,2) DEFAULT NULL,
  `percent_off` smallint(3) DEFAULT NULL,
  `products` text,
  `max_use_overall` int(7) DEFAULT NULL,
  `date_start` datetime DEFAULT '1920-01-01 00:01:01',
  `date_end` datetime DEFAULT '1920-01-01 00:01:01',
  `current_customers_only` tinyint(1) DEFAULT '0',
  `max_use_per_user` int(6) DEFAULT NULL,
  `cart_minimum` decimal(8,2) DEFAULT NULL,
  `type` enum('dollars_off','percent_off','shipping') DEFAULT NULL,
  `flat_shipping` decimal(6,2) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_coupon_codes_used;
CREATE TABLE `ppSD_cart_coupon_codes_used` (
  `order_id` varchar(14) NOT NULL DEFAULT '',
  `member_id` varchar(20) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  `savings` decimal(8,2) DEFAULT NULL,
  `tax` decimal(8,2) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`order_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_items;
CREATE TABLE `ppSD_cart_items` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `cart_session` varchar(14) DEFAULT NULL,
  `product_id` varchar(35) DEFAULT NULL,
  `qty` int(7) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `option1` varchar(35) DEFAULT NULL,
  `option2` varchar(35) DEFAULT NULL,
  `option3` varchar(35) DEFAULT NULL,
  `option4` varchar(35) DEFAULT NULL,
  `option5` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_session` (`cart_session`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_items_complete;
CREATE TABLE `ppSD_cart_items_complete` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `cart_session` varchar(14) DEFAULT NULL,
  `product_id` varchar(35) DEFAULT NULL,
  `qty` int(7) DEFAULT NULL,
  `unit_price` decimal(8,2) DEFAULT NULL,
  `subscription_id` varchar(22) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `tax` decimal(8,2) DEFAULT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `savings` decimal(8,2) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `option1` varchar(35) DEFAULT NULL,
  `option2` varchar(35) DEFAULT NULL,
  `option3` varchar(35) DEFAULT NULL,
  `option4` varchar(35) DEFAULT NULL,
  `option5` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_session` (`cart_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_refunds;
CREATE TABLE `ppSD_cart_refunds` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `total` decimal(8,2) DEFAULT NULL,
  `reason` text,
  `order_id` varchar(14) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1 = Refund / 2 = Chargeback',
  `chargeback_fee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_sessions;
CREATE TABLE `ppSD_cart_sessions` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(20) NOT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `last_activity` datetime DEFAULT '1920-01-01 00:01:01',
  `date_completed` datetime DEFAULT '1920-01-01 00:01:01',
  `status` tinyint(1) DEFAULT '0',
  `member_id` varchar(20) NOT NULL,
  `member_type` enum('member','contact','rsvp','other') NOT NULL,
  `code` varchar(15) NOT NULL,
  `ip` varchar(35) NOT NULL,
  `payment_gateway` varchar(35) NOT NULL,
  `gateway_order_id` varchar(50) NOT NULL,
  `gateway_resp_code` varchar(8) NOT NULL,
  `state` varchar(3) NOT NULL,
  `country` varchar(80) NOT NULL,
  `zip` varchar(8) NOT NULL,
  `return_path` varchar(255) NOT NULL,
  `reg_session` varchar(40) NOT NULL,
  `gateway_msg` varchar(125) NOT NULL,
  `shipping_rule` mediumint(5) NOT NULL,
  `shipping_name` varchar(125) NOT NULL,
  `card_id` varchar(13) NOT NULL,
  `salt` varchar(25) NOT NULL COMMENT 'For PayPal IPN notification',
  `agreed_to_terms` tinyint(1) DEFAULT '0',
  `saw_upsell` tinyint(1) DEFAULT '0',
  `dependencies` tinyint(1) DEFAULT '0',
  `dependency_submitted` text NOT NULL,
  `invoice_id` varchar(35) NOT NULL,
  `return_time_out` datetime DEFAULT '1920-01-01 00:01:01',
  `return_code` varchar(45) NOT NULL,
  `donation` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `member_id` (`member_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=692 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_session_totals;
CREATE TABLE `ppSD_cart_session_totals` (
  `tid` int(9) NOT NULL AUTO_INCREMENT,
  `id` varchar(14) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL COMMENT 'This reflects actual income.',
  `gateway_fees` decimal(15,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `subtotal_nosave` decimal(15,2) DEFAULT NULL COMMENT 'Subtotal of item prices after all savings and volume discounts.',
  `shipping` decimal(15,2) DEFAULT NULL,
  `tax` decimal(15,2) DEFAULT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `savings` decimal(15,2) DEFAULT NULL,
  `refunds` decimal(15,2) DEFAULT NULL,
  `invoice_due` decimal(15,2) DEFAULT NULL,
  `invoice_paid` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_terms;
CREATE TABLE `ppSD_cart_terms` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) DEFAULT NULL,
  `terms` mediumtext,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `owner` mediumint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cart_tracking;
CREATE TABLE `ppSD_cart_tracking` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `cart_session` varchar(14) DEFAULT NULL,
  `page` varchar(100) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=923 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_cemetery;
CREATE TABLE `ppSD_cemetery` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `CemeteryName` varchar(1000) DEFAULT NULL,
  `SatelliteImage` varchar(255) DEFAULT NULL,
  `StreetAddress` varchar(255) DEFAULT NULL,
  `MapsPlusCode` varchar(255) DEFAULT NULL,
  `Latitude` decimal(11,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_contacts;
CREATE TABLE `ppSD_contacts` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `type` int(5) DEFAULT '1',
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `bounce_notice` datetime DEFAULT '1920-01-01 00:01:01',
  `last_updated` datetime DEFAULT '1920-01-01 00:01:01',
  `last_action` datetime DEFAULT '1920-01-01 00:01:01',
  `next_action` datetime DEFAULT '1920-01-01 00:01:01',
  `email_optout` datetime DEFAULT '1920-01-01 00:01:01',
  `sms_optout` datetime DEFAULT '1920-01-01 00:01:01',
  `owner` mediumint(5) DEFAULT NULL COMMENT 'ppSD_staff ID, or 2 = system = unassigned',
  `email` varchar(125) DEFAULT NULL,
  `last_updated_by` mediumint(6) DEFAULT NULL,
  `source` mediumint(5) DEFAULT NULL,
  `account` varchar(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 = Active, 2 = Converted, 3 = Dead',
  `public` tinyint(1) DEFAULT '1' COMMENT '1 = All can see, 0 = admin and owner, 2 = permission group only',
  `email_pref` enum('html','text') DEFAULT NULL,
  `converted` tinyint(1) DEFAULT '0',
  `converted_id` int(9) DEFAULT NULL COMMENT 'Matches ppSD_lead_conversion ID',
  `expected_value` decimal(10,2) DEFAULT NULL,
  `actual_dollars` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`),
  KEY `account` (`account`),
  KEY `source` (`source`),
  KEY `converted` (`converted_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_contact_data;
CREATE TABLE `ppSD_contact_data` (
  `contact_id` varchar(20) NOT NULL DEFAULT '',
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `middle_name` varchar(40) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address_line_1` varchar(80) DEFAULT NULL,
  `address_line_2` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cell` varchar(15) DEFAULT NULL,
  `cell_carrier` varchar(20) DEFAULT NULL,
  `office_phone` varchar(20) DEFAULT NULL,
  `alt_phone` varchar(20) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(80) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT '1920-01-01',
  `occupation` varchar(40) DEFAULT NULL,
  `sms_optout` tinyint(1) DEFAULT '0',
  `email_optout` tinyint(1) DEFAULT '0',
  `deceased` tinyint(1) NOT NULL,
  `fathers_hebrew_name` varchar(50) NOT NULL,
  `hebrew_name` varchar(50) NOT NULL,
  `mothers_hebrew_name` varchar(50) NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `last_name` (`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_content;
CREATE TABLE `ppSD_content` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `permalink` varchar(150) DEFAULT NULL,
  `permalink_clean` varchar(150) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` enum('folder','page','redirect','section','file','newsletter','profile','user_group') DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `additional_update_fieldsets` varchar(255) DEFAULT NULL COMMENT 'CSV of fieldset IDs',
  `display_on_usercp` tinyint(1) DEFAULT '0',
  `owner` mediumint(5) DEFAULT NULL,
  `section` varchar(35) DEFAULT NULL,
  `secure` tinyint(1) DEFAULT '0',
  `section_homepage` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permalink` (`permalink`),
  KEY `section_homepage` (`section_homepage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_content_access;
CREATE TABLE `ppSD_content_access` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `added` datetime DEFAULT '1920-01-01 00:01:01',
  `expires` datetime DEFAULT '1920-01-01 00:01:01',
  `timeframe` varchar(12) DEFAULT NULL,
  `member_id` varchar(20) DEFAULT NULL,
  `content_id` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_criteria_cache;
CREATE TABLE `ppSD_criteria_cache` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `criteria` mediumtext NOT NULL,
  `search_id` varchar(29) NOT NULL,
  `act_id` varchar(30) NOT NULL,
  `email_id` varchar(13) NOT NULL,
  `save` tinyint(1) DEFAULT '0',
  `name` varchar(85) NOT NULL,
  `type` enum('yahrzeit','member','contact','rsvp','account','campaign','transaction','subscription','invoice') NOT NULL,
  `act` enum('email','search','print','campaign','export','other') NOT NULL,
  `date` datetime NOT NULL,
  `inclusive` enum('or','and') NOT NULL,
  `public` tinyint(1) DEFAULT '0',
  `owner` mediumint(5) NOT NULL,
  `sort` varchar(60) DEFAULT 'last_name',
  `sort_order` varchar(4) DEFAULT 'ASC',
  `display_per_page` mediumint(5) DEFAULT '50',
  PRIMARY KEY (`id`),
  KEY `search_id` (`search_id`,`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_custom_actions;
CREATE TABLE `ppSD_custom_actions` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) DEFAULT NULL,
  `trigger` varchar(30) DEFAULT NULL COMMENT 'Can be any task used throughout the program.',
  `trigger_type` tinyint(1) DEFAULT '0',
  `specific_trigger` varchar(35) DEFAULT NULL,
  `when` tinyint(1) DEFAULT '1' COMMENT '1 = before, 2 = after',
  `type` tinyint(1) DEFAULT '1' COMMENT '1 = php include, 2 = email, 3 = mysql query, 4 = curl',
  `data` mediumtext COMMENT 'For include, path to file. For email, it is a data array that goes into email class. For mysql, list of queries.',
  `active` tinyint(1) DEFAULT '1',
  `owner` mediumint(6) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `plugin` varchar(50) DEFAULT NULL,
  `order` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_custom_callers;
CREATE TABLE `ppSD_custom_callers` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `caller` varchar(35) DEFAULT NULL,
  `replacement` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_data_eav;
CREATE TABLE `ppSD_data_eav` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(35) DEFAULT NULL COMMENT 'Either ppSD_members ID or ppSD_contacts ID. If none, leave blank.',
  `key` varchar(45) DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_departments;
CREATE TABLE `ppSD_departments` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) DEFAULT NULL,
  `head_employee` mediumint(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `head_employee` (`head_employee`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_donations;
CREATE TABLE `ppSD_donations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `member_id` varchar(20) DEFAULT NULL,
  `member_type` enum('member','contact') DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1',
  `comments` mediumtext,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_donation_amounts;
CREATE TABLE `ppSD_donation_amounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `description` mediumtext,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_donation_campaigns;
CREATE TABLE `ppSD_donation_campaigns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `starts` datetime DEFAULT '1920-01-01 00:01:01',
  `ends` datetime DEFAULT '1920-01-01 00:01:01',
  `goal` decimal(10,2) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_email_scheduled;
CREATE TABLE `ppSD_email_scheduled` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `to` varchar(85) DEFAULT NULL,
  `user_id` varchar(21) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp','account') DEFAULT NULL,
  `email_id` varchar(35) DEFAULT NULL COMMENT 'Matches ppSD_saved_email_content',
  `added` datetime DEFAULT '1920-01-01 00:01:01',
  `type` enum('email','sms') DEFAULT NULL,
  `delete_email_after` tinyint(1) DEFAULT '0',
  `campaign` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1371 DEFAULT CHARSET=utf8 COMMENT='List of scheduled emails waiting to be sent. Deleted after.';

DROP TABLE IF EXISTS ppSD_email_trackback;
CREATE TABLE `ppSD_email_trackback` (
  `id` varchar(27) NOT NULL DEFAULT '',
  `email_id` varchar(35) DEFAULT '0',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `viewed` datetime DEFAULT '1920-01-01 00:01:01',
  `last_viewed` datetime DEFAULT '1920-01-01 00:01:01',
  `status` tinyint(1) DEFAULT '0',
  `times_opened` smallint(4) DEFAULT '0',
  `user_id` varchar(20) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  `campaign_saved_id` varchar(35) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `email_id` (`email_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_error_codes;
CREATE TABLE `ppSD_error_codes` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `code` varchar(4) DEFAULT NULL,
  `msg` text,
  `lang` varchar(3) DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_events;
CREATE TABLE `ppSD_events` (
  `id` varchar(9) NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  `tagline` varchar(150) DEFAULT NULL,
  `calendar_id` mediumint(4) DEFAULT NULL,
  `starts` datetime DEFAULT '1920-01-01 00:01:01',
  `ends` datetime DEFAULT '1920-01-01 00:01:01',
  `start_registrations` datetime DEFAULT '1920-01-01 00:01:01',
  `early_bird_end` datetime DEFAULT '1920-01-01 00:01:01',
  `close_registration` datetime DEFAULT '1920-01-01 00:01:01',
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `max_rsvps` mediumint(6) DEFAULT NULL,
  `members_only_rsvp` tinyint(1) DEFAULT '0',
  `members_only_view` tinyint(1) DEFAULT '0',
  `allow_guests` tinyint(1) DEFAULT '0',
  `max_guests` smallint(2) DEFAULT NULL,
  `description` mediumtext,
  `post_rsvp_message` mediumtext,
  `online` tinyint(1) DEFAULT '0' COMMENT '1 = online event, 2 = offline event',
  `url` varchar(255) DEFAULT NULL,
  `location_name` varchar(50) DEFAULT NULL,
  `address_line_1` varchar(125) DEFAULT NULL,
  `address_line_2` varchar(75) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `all_day` tinyint(1) DEFAULT '0',
  `custom_template` varchar(60) DEFAULT NULL,
  `custom_email_template` varchar(35) DEFAULT NULL,
  `custom_email_guest_template` varchar(35) DEFAULT NULL,
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `calendar_id` (`calendar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_products;
CREATE TABLE `ppSD_event_products` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(35) DEFAULT NULL,
  `event_id` varchar(9) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1 = rsvp, 2 = guest rsvp, 3 = addon, 4 = early bird, 6= early bird member, 5 = member pricing',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_reminders;
CREATE TABLE `ppSD_event_reminders` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(9) CHARACTER SET latin1 DEFAULT NULL,
  `send_date` date DEFAULT NULL,
  `sent_on` date DEFAULT NULL,
  `timeframe` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `when` enum('before','after') DEFAULT NULL,
  `template_id` varchar(35) CHARACTER SET latin1 DEFAULT NULL,
  `sms` tinyint(1) DEFAULT '0',
  `custom_message` text,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_reminder_logs;
CREATE TABLE `ppSD_event_reminder_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(9) DEFAULT NULL,
  `rsvp_id` varchar(21) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `msg_id` int(9) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `status_msg` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`,`rsvp_id`),
  KEY `msg_id` (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_rsvps;
CREATE TABLE `ppSD_event_rsvps` (
  `id` varchar(21) NOT NULL DEFAULT '',
  `event_id` varchar(9) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL COMMENT 'The ppSD_member ID.',
  `email` varchar(85) DEFAULT NULL,
  `bounce_notice` datetime DEFAULT '1920-01-01 00:01:01',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `arrived_date` datetime DEFAULT '1920-01-01 00:01:01',
  `type` tinyint(1) DEFAULT '1' COMMENT '1 = Primary / 2 = Guest',
  `primary_rsvp` varchar(21) DEFAULT NULL COMMENT 'For guests, this is the main RSVP ID.',
  `order_id` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '1 = Paid / 2 = Pending Payment',
  `checked_in_by` mediumint(5) DEFAULT NULL,
  `arrived` tinyint(1) DEFAULT '0',
  `qrcode_key` varchar(65) DEFAULT NULL,
  `ip` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `primary_rsvp` (`primary_rsvp`),
  KEY `user_id` (`user_id`),
  KEY `qrcode_key` (`qrcode_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_rsvp_data;
CREATE TABLE `ppSD_event_rsvp_data` (
  `rsvp_id` varchar(21) NOT NULL DEFAULT '',
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `address_line_1` varchar(80) DEFAULT NULL,
  `address_line_2` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cell` varchar(20) DEFAULT NULL,
  `cell_carrier` varchar(20) DEFAULT NULL,
  `sms_optout` tinyint(1) DEFAULT '0',
  `email` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`rsvp_id`),
  KEY `last_name` (`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_tags;
CREATE TABLE `ppSD_event_tags` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `tag` smallint(3) DEFAULT NULL COMMENT 'Matches ID in ppSD_event_types',
  `event_id` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`,`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_timeline;
CREATE TABLE `ppSD_event_timeline` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(9) DEFAULT NULL,
  `starts` datetime DEFAULT '1920-01-01 00:01:01',
  `ends` datetime DEFAULT '1920-01-01 00:01:01',
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `location_name` varchar(50) DEFAULT NULL,
  `address_line_1` varchar(125) DEFAULT NULL,
  `address_line_2` varchar(75) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(3) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_event_types;
CREATE TABLE `ppSD_event_types` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_favorites;
CREATE TABLE `ppSD_favorites` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `user_id` varchar(25) DEFAULT NULL,
  `user_type` enum('member','contact','account') DEFAULT NULL,
  `owner` mediumint(5) DEFAULT NULL,
  `ref_name` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_fields;
CREATE TABLE `ppSD_fields` (
  `id` varchar(60) NOT NULL DEFAULT '',
  `display_name` varchar(85) DEFAULT NULL,
  `type` enum('text','textarea','radio','select','checkbox','attachment','section','multiselect','multicheckbox','linkert','date') DEFAULT NULL,
  `special_type` enum('','formatting','date','datetime','url','password','email','random_id','terms','phone','state','country','cell_carriers','cc','cc_expiration') DEFAULT NULL,
  `logic` tinyint(1) DEFAULT '0',
  `logic_dependent` tinyint(1) DEFAULT '0' COMMENT '1 = Top level logic / 2 = Second level logic',
  `desc` mediumtext,
  `label_position` enum('top','left') DEFAULT NULL,
  `options` mediumtext,
  `styling` mediumtext,
  `default_value` varchar(85) DEFAULT NULL,
  `encrypted` tinyint(1) DEFAULT '0',
  `sensitive` tinyint(1) DEFAULT '0' COMMENT 'Hides data on previews.',
  `maxlength` smallint(3) DEFAULT NULL,
  `settings` mediumtext,
  `permissions_group` tinyint(3) DEFAULT '0',
  `primary` tinyint(1) DEFAULT '0',
  `static` tinyint(1) DEFAULT '0',
  `data_type` tinyint(1) DEFAULT '0' COMMENT '1 = all, 2 = letters, 3 = numbers, 4 = letters/numbers',
  `min_len` mediumint(5) DEFAULT NULL,
  `scope_member` tinyint(1) DEFAULT '0',
  `scope_contact` tinyint(1) DEFAULT '0',
  `scope_rsvp` tinyint(1) DEFAULT '0',
  `scope_account` tinyint(1) DEFAULT '0',
  `osk_language` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_fieldsets;
CREATE TABLE `ppSD_fieldsets` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(85) DEFAULT NULL,
  `desc` mediumtext,
  `order` smallint(3) DEFAULT NULL,
  `columns` tinyint(1) DEFAULT '1',
  `logic_dependent` tinyint(1) DEFAULT '0',
  `static` tinyint(1) DEFAULT '0' COMMENT '1 = Default, no delete, 2 = Custom, 0 = Custom but not visible (events, etc.)',
  `owner` mediumint(5) DEFAULT NULL,
  `billing` tinyint(1) DEFAULT '0' COMMENT 'Used to prevent displaying billing data in dropdowns to avoid confusion.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_fieldsets_fields;
CREATE TABLE `ppSD_fieldsets_fields` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `fieldset` mediumint(5) DEFAULT NULL,
  `field` varchar(60) DEFAULT NULL,
  `order` mediumint(4) DEFAULT NULL,
  `req` tinyint(1) DEFAULT '0',
  `column` tinyint(1) DEFAULT '1',
  `tabindex` mediumint(4) DEFAULT NULL,
  `autoadd_product` varchar(11) DEFAULT NULL COMMENT 'Mainly used for event registration',
  `autoadd_value` varchar(100) DEFAULT NULL COMMENT 'If "autoadd_value" is selected for the input, "autoadd_product" will be added to cart.',
  PRIMARY KEY (`id`),
  KEY `field` (`field`),
  KEY `fieldset` (`fieldset`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_fieldsets_locations;
CREATE TABLE `ppSD_fieldsets_locations` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `location` varchar(35) DEFAULT NULL COMMENT 'account-ID for account-specific sets',
  `act_id` varchar(35) DEFAULT NULL,
  `order` smallint(3) DEFAULT NULL,
  `col` smallint(2) DEFAULT NULL,
  `fieldset_id` mediumint(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fieldset_id` (`fieldset_id`),
  KEY `act_id` (`act_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_field_logic;
CREATE TABLE `ppSD_field_logic` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `field_id` varchar(8) DEFAULT NULL,
  `field_value` varchar(85) DEFAULT NULL,
  `display_type` enum('field','fieldset','msg_popup','msg_inline','email','text') DEFAULT NULL,
  `display_id` varchar(8) DEFAULT NULL,
  `display_msg` mediumtext,
  `template_id` mediumint(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`,`display_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_forms;
CREATE TABLE `ppSD_forms` (
  `id` varchar(25) NOT NULL DEFAULT '',
  `type` enum('admin_cp','payment_form','register-free','contact','update_account','event','register-paid','campaign','dependency','update') DEFAULT NULL,
  `criteria` mediumtext,
  `act_id` varchar(20) DEFAULT '',
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `code_required` tinyint(1) DEFAULT '0',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '0',
  `reg_status` varchar(1) DEFAULT NULL COMMENT 'Registrations only: A, P (email approve), Y (admin approve)',
  `pages` tinyint(1) DEFAULT '1',
  `member_type` mediumint(5) DEFAULT NULL,
  `preview` tinyint(1) DEFAULT '0',
  `step1_name` varchar(65) DEFAULT NULL,
  `step2_name` varchar(65) DEFAULT NULL,
  `step3_name` varchar(65) DEFAULT NULL,
  `step4_name` varchar(65) DEFAULT NULL,
  `step5_name` varchar(65) DEFAULT NULL,
  `public_list` tinyint(1) DEFAULT '1',
  `static` tinyint(1) DEFAULT '0',
  `disabled` tinyint(1) DEFAULT '0',
  `account_create` tinyint(1) DEFAULT '0',
  `terms_id` smallint(4) DEFAULT NULL,
  `captcha` tinyint(1) DEFAULT '0',
  `redirect` varchar(255) DEFAULT NULL,
  `account` varchar(8) DEFAULT NULL,
  `source` mediumint(5) DEFAULT NULL,
  `email_thankyou` tinyint(1) DEFAULT '0',
  `template` varchar(35) DEFAULT NULL,
  `email_forward` text,
  PRIMARY KEY (`id`),
  KEY `act_id` (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_form_closed_sessions;
CREATE TABLE `ppSD_form_closed_sessions` (
  `code` varchar(29) NOT NULL DEFAULT '',
  `used` tinyint(1) DEFAULT '0',
  `form_id` varchar(25) DEFAULT NULL,
  `date_issued` datetime DEFAULT '1920-01-01 00:01:01',
  `date_used` datetime DEFAULT '1920-01-01 00:01:01',
  `form_session` varchar(40) DEFAULT NULL,
  `sent_to` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_form_conditions;
CREATE TABLE `ppSD_form_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `act_id` varchar(35) DEFAULT NULL COMMENT 'Form ID',
  `type` enum('content','product','campaign','kill','coupon','expected_value','assign_contact') DEFAULT NULL,
  `field_name` varchar(25) DEFAULT NULL,
  `field_eq` varchar(4) DEFAULT NULL,
  `field_value` varchar(75) DEFAULT NULL,
  `condition_id` varchar(35) DEFAULT NULL COMMENT 'Product, campaign, or content id',
  `act_qty` varchar(12) DEFAULT NULL COMMENT 'Could be a timeframe or a qty.',
  PRIMARY KEY (`id`),
  KEY `form_id` (`act_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_form_products;
CREATE TABLE `ppSD_form_products` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `form_id` varchar(25) DEFAULT NULL,
  `product_id` varchar(35) DEFAULT NULL,
  `qty_control` tinyint(1) DEFAULT '1' COMMENT '1 = Add 1, 2 = user select',
  `type` tinyint(1) DEFAULT '1' COMMENT '1 = Required / 2 = Optional',
  `order` smallint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_form_requests;
CREATE TABLE `ppSD_form_requests` (
  `id` varchar(31) NOT NULL DEFAULT '',
  `form_id` varchar(25) DEFAULT NULL,
  `member_id` varchar(20) DEFAULT NULL,
  `member_type` enum('member','contact','rsvp') DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `expires` datetime DEFAULT '1920-01-01 00:01:01',
  `completed` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_form_sessions;
CREATE TABLE `ppSD_form_sessions` (
  `id` varchar(40) NOT NULL DEFAULT '',
  `member_id` varchar(20) DEFAULT NULL,
  `closed_code` varchar(33) DEFAULT NULL,
  `code_approved` tinyint(1) DEFAULT '0',
  `req_login` tinyint(1) DEFAULT '0',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `last_activity` datetime DEFAULT '1920-01-01 00:01:01',
  `step` smallint(2) DEFAULT NULL,
  `form_id` varchar(25) DEFAULT NULL,
  `act_id` varchar(20) DEFAULT NULL COMMENT 'Reg form ID or Event ID being acted on',
  `type` enum('register','lead','update','dependency','event','forced_update','campaign','contact') DEFAULT NULL,
  `s1` mediumtext,
  `s2` mediumtext,
  `s3` mediumtext,
  `s4` mediumtext,
  `s5` mediumtext,
  `s6` int(11) DEFAULT NULL,
  `s7` int(11) DEFAULT NULL,
  `s8` int(11) DEFAULT NULL,
  `ip` varchar(35) DEFAULT NULL,
  `salt` varchar(6) DEFAULT NULL,
  `cart_id` varchar(14) DEFAULT NULL,
  `products` text,
  `terms` tinyint(1) DEFAULT '0',
  `final_member_id` varchar(25) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `act_id` (`act_id`),
  KEY `member_id` (`member_id`),
  KEY `cart_id` (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_form_submit;
CREATE TABLE `ppSD_form_submit` (
  `id` varchar(30) NOT NULL DEFAULT '',
  `form_id` varchar(25) DEFAULT NULL,
  `form_name` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `user_id` varchar(25) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp','account') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_history;
CREATE TABLE `ppSD_history` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `method` varchar(75) DEFAULT NULL,
  `owner` mediumint(5) DEFAULT NULL COMMENT 'c7_staff ID',
  `notes` mediumtext,
  `plugin` varchar(30) DEFAULT NULL,
  `user_id` varchar(35) DEFAULT NULL COMMENT 'ppSD_members ID or ppSD_contacts ID',
  `act_id` varchar(35) DEFAULT NULL COMMENT 'If possible, the ID of the action, such as the email or note.',
  `type` tinyint(1) DEFAULT '1' COMMENT '1 = member, 2 = contact, 3 = rsvp, 4 = other',
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`),
  KEY `user_id` (`user_id`),
  KEY `act_id` (`act_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3459 DEFAULT CHARSET=utf8 COMMENT='This is basically an activity feed for users.';

DROP TABLE IF EXISTS ppSD_homepage_widgets;
CREATE TABLE `ppSD_homepage_widgets` (
  `id` varchar(25) NOT NULL DEFAULT '',
  `options` text,
  `title` varchar(50) DEFAULT NULL,
  `perms` enum('admin','all') DEFAULT NULL,
  `static` tinyint(1) DEFAULT '0',
  `employee` mediumint(5) DEFAULT NULL,
  `add_fields` text,
  `hide` tinyint(1) DEFAULT '0',
  `custom` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_invoices;
CREATE TABLE `ppSD_invoices` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `last_reminder` datetime DEFAULT '1920-01-01 00:01:01',
  `date_due` datetime DEFAULT '1920-01-01 00:01:01',
  `total_reminders` smallint(3) DEFAULT NULL,
  `order_id` varchar(14) DEFAULT NULL COMMENT 'Mainly used to associate totals and shipping data',
  `member_id` varchar(20) DEFAULT NULL,
  `member_type` enum('member','contact') DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0 = Unpaid, 1 = Paid, 2 = Partial Payment, 3 = Overdue, 4 = Dead',
  `salt` varchar(4) DEFAULT NULL,
  `hash` varchar(60) DEFAULT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `shipping_rule` mediumint(5) DEFAULT NULL,
  `shipping_name` varchar(125) DEFAULT NULL,
  `ip` varchar(35) DEFAULT NULL,
  `owner` mediumint(5) DEFAULT NULL,
  `hourly` decimal(8,2) DEFAULT NULL,
  `rsvp_id` varchar(21) DEFAULT NULL,
  `rolling_invoice` tinyint(1) DEFAULT '0',
  `auto_inform` tinyint(1) DEFAULT '0',
  `check_only` tinyint(1) DEFAULT '0',
  `quote` tinyint(1) DEFAULT '0',
  `sub_id` varchar(30) DEFAULT NULL,
  `seen` mediumint(4) DEFAULT '0',
  `last_seen_date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `rsvp_id` (`rsvp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_invoice_components;
CREATE TABLE `ppSD_invoice_components` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(35) DEFAULT NULL,
  `type` enum('product','time','credit') DEFAULT NULL,
  `minutes` int(8) DEFAULT NULL,
  `hourly` decimal(8,2) DEFAULT NULL,
  `product_id` varchar(35) DEFAULT NULL,
  `qty` int(7) DEFAULT NULL,
  `unit_price` decimal(8,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `option1` varchar(35) DEFAULT NULL,
  `option2` varchar(35) DEFAULT NULL,
  `option3` varchar(35) DEFAULT NULL,
  `option4` varchar(35) DEFAULT NULL,
  `option5` varchar(35) DEFAULT NULL,
  `name` varchar(85) DEFAULT NULL,
  `description` text,
  `owner` mediumint(5) DEFAULT NULL,
  `tax` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_invoice_data;
CREATE TABLE `ppSD_invoice_data` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `company_name` varchar(80) DEFAULT NULL,
  `contact_name` varchar(80) DEFAULT NULL,
  `address_line_1` varchar(80) DEFAULT NULL,
  `address_line_2` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(3) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `website` varchar(125) DEFAULT NULL,
  `memo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_invoice_payments;
CREATE TABLE `ppSD_invoice_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(14) DEFAULT NULL,
  `invoice_id` varchar(35) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `paid` decimal(8,2) DEFAULT NULL,
  `new_balance` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_invoice_totals;
CREATE TABLE `ppSD_invoice_totals` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `paid` decimal(8,2) DEFAULT NULL,
  `due` decimal(8,2) DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT NULL,
  `shipping` decimal(8,2) DEFAULT NULL,
  `tax` decimal(8,2) DEFAULT NULL,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `credits` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_lead_conversion;
CREATE TABLE `ppSD_lead_conversion` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `began` datetime DEFAULT '1920-01-01 00:01:01',
  `contact_id` varchar(20) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `owner` mediumint(6) DEFAULT NULL,
  `estimated_value` decimal(9,2) DEFAULT NULL,
  `actual_value` decimal(9,2) DEFAULT NULL,
  `percent_change` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`user_id`),
  KEY `owner` (`owner`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_leyning;
CREATE TABLE `ppSD_leyning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parashat_id` int(11) DEFAULT NULL,
  `honor` varchar(1500) DEFAULT NULL,
  `honoree` varchar(1500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1482 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS ppSD_link_tracking;
CREATE TABLE `ppSD_link_tracking` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `email_id` varchar(35) DEFAULT NULL,
  `clicked` mediumint(4) DEFAULT NULL,
  `first_clicked` datetime DEFAULT '1920-01-01 00:01:01',
  `last_clicked` datetime DEFAULT '1920-01-01 00:01:01',
  `link` varchar(255) DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  `campaign_email_id` varchar(35) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `user_type` enum('contact','member','rsvp') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_logins;
CREATE TABLE `ppSD_logins` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(35) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `member_id` varchar(20) DEFAULT NULL,
  `ip` varchar(35) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `host` varchar(80) DEFAULT NULL,
  `browser` varchar(150) DEFAULT NULL,
  `browser_short` varchar(25) DEFAULT NULL,
  `attempt_no` smallint(3) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `notes` mediumtext,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_login_annoucement_location;
CREATE TABLE `ppSD_login_annoucement_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_login_announcements;
CREATE TABLE `ppSD_login_announcements` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `starts` datetime DEFAULT '1970-01-01 00:01:01',
  `ends` datetime DEFAULT '1970-01-01 00:01:01',
  `title` varchar(100) DEFAULT NULL,
  `content` mediumtext,
  `show_criteria` int(9) DEFAULT NULL COMMENT 'Matches ppSD_criteria_cache',
  `active` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT '1970-01-01 00:01:01',
  `owner` mediumint(5) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '0',
  `region` varchar(50) DEFAULT 'login',
  `type` enum('post','video','gallery','other') DEFAULT 'post',
  `media_location` enum('top','left','right') DEFAULT 'top',
  `media` varchar(150) DEFAULT NULL,
  `media_token` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `starts` (`starts`),
  KEY `ends` (`ends`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_login_announcement_logs;
CREATE TABLE `ppSD_login_announcement_logs` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(9) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `member_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_login_announcement_regions;
CREATE TABLE `ppSD_login_announcement_regions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `display` mediumint(6) DEFAULT NULL,
  `snippet_length` mediumint(4) DEFAULT '100',
  `template_set_prefix` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_login_temp;
CREATE TABLE `ppSD_login_temp` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `ip` varchar(35) DEFAULT NULL,
  `attempt` smallint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_members;
CREATE TABLE `ppSD_members` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(6) DEFAULT NULL,
  `email` varchar(110) DEFAULT NULL,
  `bounce_notice` datetime DEFAULT '1920-01-01 00:01:01',
  `joined` datetime DEFAULT '1920-01-01 00:01:01',
  `last_renewal` datetime DEFAULT '1920-01-01 00:01:01',
  `last_action` datetime DEFAULT '1920-01-01 00:01:01',
  `last_login` datetime DEFAULT '1920-01-01 00:01:01',
  `last_updated` datetime DEFAULT '1920-01-01 00:01:01',
  `last_date_check` datetime DEFAULT NULL COMMENT 'Used for inactivity checks',
  `next_action` datetime DEFAULT '1920-01-01 00:01:01',
  `concurrent_login_date` datetime DEFAULT '1920-01-01 00:01:01',
  `locked` datetime DEFAULT '1920-01-01 00:01:01',
  `email_optout` datetime DEFAULT '1920-01-01 00:01:01',
  `sms_optout` datetime DEFAULT '1920-01-01 00:01:01',
  `activated` datetime DEFAULT '1920-01-01 00:01:01',
  `last_updated_by` varchar(20) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `status_msg` varchar(255) DEFAULT NULL COMMENT 'If someone is paused, rejected, etc.. this holds the reason.',
  `conversion_id` int(8) DEFAULT '0',
  `source` mediumint(5) DEFAULT '0' COMMENT 'Corresponds to ppSD_sources',
  `concurrent_login_notices` tinyint(3) DEFAULT '0',
  `public` tinyint(1) DEFAULT '0',
  `owner` mediumint(6) DEFAULT NULL,
  `email_pref` enum('html','text') DEFAULT NULL,
  `locked_ip` varchar(25) DEFAULT NULL,
  `login_attempts` tinyint(1) DEFAULT '0',
  `account` varchar(10) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `start_page` varchar(255) DEFAULT NULL,
  `converted` tinyint(1) DEFAULT '0',
  `converted_id` int(9) DEFAULT NULL,
  `listing_display` tinyint(1) DEFAULT '0',
  `member_type` mediumint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `username` (`username`),
  KEY `member_type` (`member_type`),
  KEY `account` (`account`),
  KEY `source` (`source`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_member_activations;
CREATE TABLE `ppSD_member_activations` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(20) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `owner` mediumint(5) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_member_data;
CREATE TABLE `ppSD_member_data` (
  `member_id` varchar(20) NOT NULL DEFAULT '',
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `address_line_1` varchar(80) DEFAULT NULL,
  `address_line_2` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `sms_optout` tinyint(1) DEFAULT '0',
  `email_optout` tinyint(1) DEFAULT '0',
  `dob` date DEFAULT '1920-01-01',
  `title` varchar(10) DEFAULT NULL,
  `middle_name` varchar(40) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `industry` varchar(30) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(80) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `cell` varchar(15) DEFAULT NULL,
  `cell_carrier` varchar(20) DEFAULT NULL,
  `alt_phone` varchar(20) DEFAULT NULL,
  `office_phone` varchar(20) DEFAULT NULL,
  `aliyah` tinyint(1) NOT NULL,
  `bnai_mitzvah_date` date NOT NULL,
  `chazanut` tinyint(1) NOT NULL,
  `cohenleviisrael` varchar(50) NOT NULL,
  `dvar_torah` tinyint(1) NOT NULL,
  `deceased` tinyint(1) NOT NULL,
  `fathers_hebrew_name` varchar(50) NOT NULL,
  `haftarah` tinyint(1) NOT NULL,
  `hebrew_name` varchar(50) NOT NULL,
  `kria_batorah` tinyint(1) NOT NULL,
  `maftir` tinyint(1) NOT NULL,
  `mothers_hebrew_name` varchar(50) NOT NULL,
  `wedding_anniversary_date` date NOT NULL,
  `quickbooks_customer_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  KEY `last_name` (`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_member_types;
CREATE TABLE `ppSD_member_types` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) DEFAULT NULL,
  `order` mediumint(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_member_types_content;
CREATE TABLE `ppSD_member_types_content` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `member_type` mediumint(4) DEFAULT NULL,
  `act_id` varchar(30) DEFAULT NULL,
  `act_type` enum('content','other') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_type` (`member_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_newsletters_subscribers;
CREATE TABLE `ppSD_newsletters_subscribers` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) DEFAULT NULL,
  `user_type` enum('member','contact') DEFAULT NULL,
  `newsletter_id` varchar(10) DEFAULT NULL,
  `added` datetime DEFAULT '1920-01-01 00:01:01',
  `expires` datetime DEFAULT '1920-01-01 00:01:01',
  `unsubscribed` datetime DEFAULT '1920-01-01 00:01:01',
  `double_optin` datetime DEFAULT '1920-01-01 00:01:01',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 = subscribed, 0 = unsubscribed',
  `activation_code` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_notes;
CREATE TABLE `ppSD_notes` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `user_id` varchar(35) DEFAULT NULL,
  `item_scope` varchar(25) DEFAULT NULL,
  `name` varchar(85) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `deadline` datetime DEFAULT '1920-01-01 00:01:01',
  `completed_on` datetime DEFAULT '1920-01-01 00:01:01',
  `seen_date` datetime DEFAULT '1920-01-01 00:01:01',
  `note` mediumtext,
  `added_by` mediumint(6) DEFAULT NULL,
  `label` tinyint(2) DEFAULT NULL COMMENT 'Matches ppSD_note_labels',
  `public` tinyint(1) DEFAULT '0' COMMENT '2 = broadcast , 1 = all can see, 0 = creator and admin only',
  `value` decimal(10,2) DEFAULT NULL,
  `for` mediumint(5) DEFAULT NULL,
  `remove_from_cp` tinyint(1) DEFAULT '0',
  `complete` tinyint(1) DEFAULT '0',
  `completed_by` mediumint(5) DEFAULT '0',
  `priority` tinyint(1) DEFAULT '0',
  `encrypt` tinyint(1) DEFAULT '0',
  `pin` tinyint(1) DEFAULT '0',
  `seen` tinyint(1) DEFAULT '0',
  `external_id` varchar(30) DEFAULT NULL COMMENT 'Used for external calendar links.',
  `advance_pipeline` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `added_by` (`added_by`),
  KEY `name` (`name`),
  KEY `for` (`for`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_note_labels;
CREATE TABLE `ppSD_note_labels` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `label` varchar(35) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `fontcolor` varchar(6) DEFAULT NULL,
  `static_lookup` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_options;
CREATE TABLE `ppSD_options` (
  `id` varchar(50) NOT NULL DEFAULT '',
  `display` varchar(75) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('text','select','radio','checkbox','timeframe','special','file_size','textarea') DEFAULT NULL,
  `width` mediumint(3) DEFAULT NULL,
  `options` mediumtext,
  `section` varchar(20) DEFAULT NULL,
  `maxlength` mediumint(5) DEFAULT NULL,
  `class` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_packages;
CREATE TABLE `ppSD_packages` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `prorate_upgrades` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_pages;
CREATE TABLE `ppSD_pages` (
  `id` varchar(14) NOT NULL DEFAULT '',
  `title` varchar(35) DEFAULT NULL,
  `meta_title` varchar(69) DEFAULT NULL,
  `meta_desc` varchar(156) DEFAULT NULL,
  `meta_keywords` varchar(85) DEFAULT NULL,
  `members_only` tinyint(1) DEFAULT '0',
  `section` varchar(35) DEFAULT NULL,
  `template` varchar(65) DEFAULT NULL,
  `content` longtext,
  `live` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `section` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_parashat;
CREATE TABLE `ppSD_parashat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `parsha_date` datetime DEFAULT NULL COMMENT 'parsha date',
  `title` varchar(1500) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_payment_gateways;
CREATE TABLE `ppSD_payment_gateways` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `fee_flat` decimal(6,2) DEFAULT NULL,
  `fee_percent` decimal(5,2) DEFAULT NULL,
  `test_mode` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `online` varchar(255) DEFAULT NULL,
  `api` tinyint(1) DEFAULT NULL,
  `local_card_storage` tinyint(1) DEFAULT NULL,
  `credential1` varchar(255) DEFAULT NULL,
  `credential2` varchar(255) DEFAULT NULL,
  `credential3` varchar(255) DEFAULT NULL,
  `credential4` varchar(255) DEFAULT NULL,
  `primary` tinyint(1) DEFAULT NULL,
  `method_cc_visa` tinyint(1) DEFAULT NULL,
  `method_cc_amex` int(11) DEFAULT NULL,
  `method_cc_mc` int(11) DEFAULT NULL,
  `method_cc_discover` int(11) DEFAULT NULL,
  `method_check` tinyint(1) DEFAULT NULL,
  `method_refund` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_permission_groups;
CREATE TABLE `ppSD_permission_groups` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `owner` mediumint(6) DEFAULT NULL COMMENT 'c7_staff ID',
  `start_page` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_permission_group_settings;
CREATE TABLE `ppSD_permission_group_settings` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `group_id` tinyint(3) DEFAULT NULL,
  `scope` varchar(25) DEFAULT NULL,
  `action` varchar(25) DEFAULT NULL,
  `allowed` enum('all','owned','none') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group_id`),
  KEY `permission` (`scope`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_pipeline;
CREATE TABLE `ppSD_pipeline` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `position` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_products;
CREATE TABLE `ppSD_products` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `associated_id` varchar(20) DEFAULT '' COMMENT 'Event, etc.',
  `name` varchar(85) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `description` text,
  `type` tinyint(1) DEFAULT NULL COMMENT '1 = one time, 2 = subscription, 3 = trial, 4 = donation',
  `physical` tinyint(1) DEFAULT NULL COMMENT '1 = physical but no shipping, 2 = physical and needs shipping',
  `tax_exempt` tinyint(1) DEFAULT '0',
  `cost_in_credits` int(7) DEFAULT NULL,
  `grant_credits` int(7) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `upfront_cost` decimal(15,2) DEFAULT NULL,
  `trial_price` decimal(15,2) DEFAULT NULL,
  `trial_period` varchar(12) DEFAULT NULL,
  `trial_repeat` smallint(3) DEFAULT NULL,
  `renew_max` mediumint(5) DEFAULT NULL,
  `renew_timeframe` varchar(12) DEFAULT NULL,
  `threshold_date` varchar(5) DEFAULT NULL COMMENT 'For subscriptions, if started after a certain date, it will automatically set the next renewal to threshold_date_set',
  `threshold_date_set` datetime DEFAULT '1920-01-01 00:01:01',
  `hide` tinyint(1) DEFAULT NULL,
  `hide_in_admin` tinyint(1) DEFAULT '0',
  `weight` decimal(8,2) DEFAULT NULL,
  `member_type` mediumint(5) DEFAULT NULL,
  `cart_ordering` mediumint(6) DEFAULT NULL,
  `category` mediumint(6) DEFAULT NULL,
  `attribute_to` varchar(11) DEFAULT NULL,
  `max_per_cart` int(7) DEFAULT NULL COMMENT 'Allow quantities to be added or only 1',
  `min_per_cart` int(8) DEFAULT NULL,
  `limit_attr` tinyint(1) DEFAULT NULL COMMENT '1 = Max 1 selected, 2 = Input number to buy',
  `terms` mediumint(4) DEFAULT NULL COMMENT 'Matches ppSD_terms ID',
  `popularity` smallint(6) DEFAULT NULL,
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `invoice_id` varchar(35) DEFAULT '',
  `featured` tinyint(1) DEFAULT '0',
  `base_popularity` mediumint(5) DEFAULT NULL,
  `members_only` tinyint(1) DEFAULT '0',
  `auto_register` tinyint(1) DEFAULT '0',
  `sync_id` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`,`attribute_to`),
  KEY `type` (`type`),
  KEY `associated_id` (`associated_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_products_linked;
CREATE TABLE `ppSD_products_linked` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(35) DEFAULT NULL,
  `package_id` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `package_id` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_products_options;
CREATE TABLE `ppSD_products_options` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(35) DEFAULT NULL,
  `option_no` varchar(35) DEFAULT NULL,
  `option_value` varchar(35) DEFAULT NULL,
  `options` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_products_options_qty;
CREATE TABLE `ppSD_products_options_qty` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(35) DEFAULT NULL,
  `option1` varchar(35) DEFAULT NULL COMMENT 'Represents the csv value option in ppSD_product_options',
  `option2` varchar(35) DEFAULT NULL,
  `option3` varchar(35) DEFAULT NULL,
  `option4` varchar(35) DEFAULT NULL,
  `option5` varchar(35) DEFAULT NULL,
  `qty` int(7) DEFAULT NULL,
  `price_adjust` decimal(8,2) DEFAULT NULL,
  `weight_adjust` decimal(6,2) DEFAULT NULL,
  `sync_id` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `option1` (`option1`,`option2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Example: for size options, color options, etc.';

DROP TABLE IF EXISTS ppSD_products_tiers;
CREATE TABLE `ppSD_products_tiers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(35) DEFAULT NULL,
  `low` mediumint(5) DEFAULT NULL,
  `high` mediumint(5) DEFAULT NULL,
  `discount` decimal(4,2) DEFAULT NULL COMMENT 'Percentage',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_product_dependencies;
CREATE TABLE `ppSD_product_dependencies` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `type` enum('form') DEFAULT NULL,
  `act_id` varchar(25) DEFAULT NULL,
  `options` text,
  `product_id` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `act_id` (`act_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_product_upsell;
CREATE TABLE `ppSD_product_upsell` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `product` varchar(35) DEFAULT NULL,
  `upsell` varchar(35) DEFAULT NULL,
  `type` enum('popup','checkout') DEFAULT NULL,
  `order` mediumint(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_QBInvoicePull;
CREATE TABLE `ppSD_QBInvoicePull` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `lastAccessToken` varchar(1000) DEFAULT NULL,
  `refreshToken` varchar(1000) DEFAULT NULL,
  `refreshTokenExpires` varchar(1000) DEFAULT NULL,
  `expires_in` varchar(1000) DEFAULT NULL,
  `realmId` varchar(1000) DEFAULT '9130349632301756',
  `update_time` datetime DEFAULT NULL COMMENT 'update time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_qr_devices;
CREATE TABLE `ppSD_qr_devices` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `employee_id` mediumint(6) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `ip` varchar(35) DEFAULT NULL,
  `host` varchar(75) DEFAULT NULL,
  `browser` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_reminders;
CREATE TABLE `ppSD_reminders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT '1920-01-01 00:01:00',
  `seen_on` datetime DEFAULT '1920-01-01 00:01:00',
  `remind_on` date DEFAULT NULL,
  `user_id` varchar(30) DEFAULT NULL,
  `user_type` enum('member','contact','account','invoice','transaction','event','other') DEFAULT 'other',
  `title` varchar(100) DEFAULT NULL,
  `message` mediumtext,
  `for` int(11) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `for` (`for`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_reset_passwords;
CREATE TABLE `ppSD_reset_passwords` (
  `id` varchar(40) NOT NULL DEFAULT '',
  `member_id` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_routes;
CREATE TABLE `ppSD_routes` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) DEFAULT NULL,
  `resolve` varchar(75) DEFAULT NULL,
  `plugin` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_saved_emails;
CREATE TABLE `ppSD_saved_emails` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `content` mediumtext,
  `subject` varchar(100) DEFAULT NULL,
  `to` varchar(125) DEFAULT NULL,
  `from` varchar(125) DEFAULT NULL,
  `cc` varchar(125) DEFAULT NULL,
  `bcc` varchar(125) DEFAULT NULL,
  `sent_by` varchar(50) DEFAULT NULL,
  `format` varchar(12) DEFAULT NULL,
  `template` varchar(10) DEFAULT NULL,
  `type` char(1) DEFAULT NULL,
  `newsletter` mediumint(6) DEFAULT '0',
  `statuses` varchar(100) DEFAULT NULL,
  `areas` varchar(255) DEFAULT NULL,
  `inclusive` char(1) DEFAULT NULL,
  `criteria` char(3) DEFAULT NULL,
  `mass_email_id` varchar(26) DEFAULT '0',
  `user_id` varchar(35) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `fail` tinyint(1) DEFAULT '0',
  `fail_reason` varchar(100) DEFAULT NULL,
  `sentvia` varchar(30) DEFAULT NULL,
  `vendor_id` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_saved_email_content;
CREATE TABLE `ppSD_saved_email_content` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `message` mediumtext,
  `subject` varchar(150) DEFAULT NULL,
  `from` varchar(85) DEFAULT NULL,
  `to` varchar(85) DEFAULT NULL,
  `reply_to` varchar(85) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `trackback` tinyint(1) DEFAULT '0',
  `track_links` tinyint(1) DEFAULT '0',
  `save` tinyint(1) DEFAULT '0',
  `criteria_id` int(9) DEFAULT NULL,
  `update_activity` tinyint(1) DEFAULT '0',
  `owner` mediumint(5) DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `criteria_id` (`criteria_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Saves the content of mass emails and campaign emails.';

DROP TABLE IF EXISTS ppSD_saved_sms;
CREATE TABLE `ppSD_saved_sms` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `msg` varchar(160) DEFAULT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `cell` varchar(30) DEFAULT NULL,
  `carrier` varchar(30) DEFAULT NULL,
  `sentvia` varchar(30) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `provider_id` varchar(50) DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `message` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_schedule_social;
CREATE TABLE `ppSD_schedule_social` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `type` enum('date','after_join') DEFAULT NULL,
  `post` mediumtext,
  `where` enum('company_feed','post_to_user') DEFAULT NULL,
  `site` enum('facebook','twitter') DEFAULT NULL,
  `post_date` datetime DEFAULT '1920-01-01 00:01:01',
  `post_timeframe` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS ppSD_sections;
CREATE TABLE `ppSD_sections` (
  `name` varchar(35) NOT NULL DEFAULT '',
  `display_title` varchar(50) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `subsection` varchar(35) DEFAULT NULL,
  `main_nav` tinyint(1) DEFAULT '0',
  `secure` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_sessions;
CREATE TABLE `ppSD_sessions` (
  `id` varchar(35) NOT NULL DEFAULT '',
  `member_id` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `ended` datetime DEFAULT '1920-01-01 00:01:01',
  `last_activity` datetime DEFAULT '1920-01-01 00:01:01',
  `ended_by` tinyint(1) DEFAULT '0',
  `ip` varchar(35) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `remember` tinyint(1) DEFAULT '0',
  `salt` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_shipping;
CREATE TABLE `ppSD_shipping` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `cart_session` varchar(14) DEFAULT NULL,
  `invoice_id` varchar(35) DEFAULT NULL,
  `company_name` varchar(125) DEFAULT NULL,
  `name` varchar(125) DEFAULT NULL COMMENT 'Name of shipping package',
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `address_line_1` varchar(175) DEFAULT NULL,
  `address_line_2` varchar(175) DEFAULT NULL,
  `city` varchar(75) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ship_directions` text,
  `shipped` tinyint(1) DEFAULT '0',
  `ship_date` datetime DEFAULT '1920-01-01 00:01:01',
  `trackable` tinyint(1) DEFAULT '0',
  `shipping_number` varchar(50) DEFAULT NULL,
  `shipping_provider` varchar(50) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`id`),
  KEY `cart_session` (`cart_session`,`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_shipping_rules;
CREATE TABLE `ppSD_shipping_rules` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) DEFAULT NULL,
  `type` enum('weight','region','qty','total','product','flat') DEFAULT NULL,
  `priority` mediumint(5) DEFAULT NULL,
  `details` text,
  `cost` decimal(6,2) DEFAULT NULL,
  `low` varchar(12) DEFAULT NULL,
  `high` varchar(12) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `zip` varchar(11) DEFAULT NULL,
  `state` varchar(3) DEFAULT NULL,
  `product` varchar(35) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `sync_id` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_social_media_feed;
CREATE TABLE `ppSD_social_media_feed` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_id` varchar(30) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `site` enum('facebook','twitter','linkedin') DEFAULT NULL,
  `post` text,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_sources;
CREATE TABLE `ppSD_sources` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `source` varchar(85) DEFAULT NULL,
  `type` enum('form','custom') DEFAULT NULL,
  `trigger` varchar(50) DEFAULT NULL,
  `redirect` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_source_tracking;
CREATE TABLE `ppSD_source_tracking` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `converted_date` datetime DEFAULT '1920-01-01 00:01:01',
  `referrer` varchar(255) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `converted` tinyint(1) DEFAULT '0',
  `user_id` varchar(50) DEFAULT NULL,
  `user_type` enum('member','contact','rsvp') DEFAULT NULL,
  `link_variation` enum('-','A','B') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_staff;
CREATE TABLE `ppSD_staff` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `permission_group` smallint(3) DEFAULT NULL,
  `signature` mediumtext,
  `email` varchar(150) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address_line_1` varchar(80) DEFAULT NULL,
  `address_line_2` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(3) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `alt_phone` varchar(20) DEFAULT NULL,
  `office_phone` varchar(20) DEFAULT NULL,
  `cell` varchar(15) DEFAULT NULL,
  `cell_carrier` varchar(20) DEFAULT NULL,
  `sms_optout` tinyint(1) DEFAULT NULL,
  `email_optout` tinyint(1) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(80) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `occupation` varchar(75) DEFAULT NULL,
  `locked` datetime DEFAULT '1920-01-01 00:01:01',
  `locked_ip` varchar(25) DEFAULT NULL,
  `login_attempts` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `options` mediumtext,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `last_updated` datetime DEFAULT '1920-01-01 00:01:01',
  `owner` mediumint(5) DEFAULT NULL,
  `static` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `permission_group` (`permission_group`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_staff_in;
CREATE TABLE `ppSD_staff_in` (
  `id` varchar(100) NOT NULL DEFAULT '',
  `salt` varchar(4) DEFAULT NULL,
  `masterlog` datetime DEFAULT '1920-01-01 00:01:01',
  `expires` datetime DEFAULT '1920-01-01 00:01:01',
  `complete` datetime DEFAULT '1920-01-01 00:01:01',
  `username` varchar(100) DEFAULT NULL,
  `remember` tinyint(1) DEFAULT '0',
  `ip` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_stats;
CREATE TABLE `ppSD_stats` (
  `key` varchar(70) NOT NULL DEFAULT '',
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_subscriptions;
CREATE TABLE `ppSD_subscriptions` (
  `id` varchar(22) NOT NULL DEFAULT '',
  `member_id` varchar(20) DEFAULT NULL,
  `member_type` enum('member','contact') DEFAULT NULL,
  `order_id` varchar(14) DEFAULT NULL,
  `card_id` varchar(13) DEFAULT NULL COMMENT 'ppSD_cart_billing',
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `last_renewed` datetime DEFAULT '1920-01-01 00:01:01',
  `next_renew` date DEFAULT '1920-01-01',
  `next_renew_keep` date DEFAULT '1920-01-01',
  `cancel_date` datetime DEFAULT '1920-01-01 00:00:00',
  `price` decimal(15,2) DEFAULT NULL,
  `retry` smallint(3) DEFAULT NULL,
  `product` varchar(35) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `advance_notice_sent` tinyint(1) DEFAULT '0',
  `in_trial` tinyint(1) DEFAULT '0',
  `trial_charge_number` smallint(3) DEFAULT NULL COMMENT 'How many times trial period has been charged',
  `paypal` tinyint(1) DEFAULT '0' COMMENT '1 = PayPal Handles It',
  `paypal_id` varchar(20) DEFAULT NULL COMMENT 'Subscription ID',
  `cancel_reason` varchar(75) DEFAULT NULL,
  `gateway` varchar(35) DEFAULT NULL,
  `notice_sent` tinyint(1) DEFAULT NULL,
  `salt` varchar(45) DEFAULT NULL COMMENT 'Used for no-login CC updates',
  `spawned_invoice` varchar(35) DEFAULT NULL,
  `product_options` mediumtext,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `paypal_id` (`paypal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_subscription_reattempts;
CREATE TABLE `ppSD_subscription_reattempts` (
  `fail_attempt` smallint(2) NOT NULL DEFAULT '0',
  `timeframe` varchar(12) DEFAULT NULL,
  `penalty_percent` decimal(5,2) DEFAULT NULL,
  `penalty_fixed` decimal(7,2) DEFAULT NULL,
  `cancel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`fail_attempt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_tags;
CREATE TABLE `ppSD_tags` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `tag` varchar(35) DEFAULT NULL,
  `item_id` varchar(40) DEFAULT NULL,
  `item_type` tinyint(1) DEFAULT '0' COMMENT '1 = Upload',
  `owner` mediumint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_tax_classes;
CREATE TABLE `ppSD_tax_classes` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `state` varchar(35) DEFAULT NULL,
  `country` varchar(35) DEFAULT NULL,
  `zips` mediumtext,
  `percent_physical` decimal(5,3) DEFAULT NULL,
  `percent_digital` decimal(5,3) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_temp;
CREATE TABLE `ppSD_temp` (
  `id` varchar(40) DEFAULT NULL,
  `data` longtext,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Temporary information for previewing and other short-term ca';

DROP TABLE IF EXISTS ppSD_templates;
CREATE TABLE `ppSD_templates` (
  `id` varchar(65) NOT NULL DEFAULT '',
  `path` varchar(150) DEFAULT NULL,
  `theme` varchar(25) DEFAULT NULL,
  `subtemplate` varchar(65) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `caller_tags` text,
  `order` smallint(3) DEFAULT NULL,
  `custom_header` varchar(65) DEFAULT NULL,
  `custom_footer` varchar(65) DEFAULT NULL,
  `custom_template` varchar(65) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '3' COMMENT '1 = Header, 2 = Footer, 3 = Custom template, 0 = Template, 4 = page',
  `section` varchar(35) DEFAULT NULL,
  `content` mediumtext,
  `secure` tinyint(1) DEFAULT '0',
  `static` tinyint(1) DEFAULT '0',
  `owner` mediumint(5) DEFAULT NULL,
  `encrypt` tinyint(1) DEFAULT '0',
  `meta_title` varchar(65) DEFAULT NULL,
  `lang` varchar(3) DEFAULT 'en',
  PRIMARY KEY (`id`),
  KEY `subtemplate` (`subtemplate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_templates_email;
CREATE TABLE `ppSD_templates_email` (
  `template` varchar(35) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `to` varchar(125) DEFAULT NULL,
  `from` varchar(80) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `format` tinyint(1) DEFAULT '1' COMMENT '1 = html / 0 = plain text',
  `status` tinyint(1) DEFAULT '1',
  `save` tinyint(1) DEFAULT '1',
  `track` tinyint(1) DEFAULT '1',
  `track_links` tinyint(1) DEFAULT '1',
  `caller_tags` text,
  `custom` tinyint(1) DEFAULT '1' COMMENT 'If this was custom created by the user.',
  `owner` mediumint(6) DEFAULT NULL,
  `public` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT '1920-01-01 00:01:01',
  `header_id` varchar(35) DEFAULT NULL,
  `footer_id` varchar(35) DEFAULT NULL,
  `static` tinyint(1) DEFAULT '0',
  `default_for` tinyint(1) DEFAULT '0' COMMENT '1 = email, 2 = targeted, 3 = scheduled',
  `theme` varchar(25) DEFAULT NULL,
  `type` enum('template','header','footer') DEFAULT NULL,
  KEY `template` (`template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_templates_lang;
CREATE TABLE `ppSD_templates_lang` (
  `up` int(9) NOT NULL AUTO_INCREMENT,
  `id` varchar(65) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `content` mediumtext,
  `lang` varchar(3) DEFAULT NULL,
  `meta_title` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`up`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_themes;
CREATE TABLE `ppSD_themes` (
  `id` varchar(25) NOT NULL DEFAULT '',
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `author` varchar(45) DEFAULT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  `img_1` varchar(150) DEFAULT NULL,
  `img_2` varchar(150) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `type` enum('html','email','mobile') DEFAULT NULL,
  `style` enum('Clean','Minimalist','Experimental','Corporate','Colorful','Dark','Other') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_tracking_activity;
CREATE TABLE `ppSD_tracking_activity` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `track_id` varchar(32) DEFAULT NULL,
  `type` enum('order','member','contact','rsvp','invoice') DEFAULT NULL,
  `act_id` varchar(35) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `campaign_id` varchar(11) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `track_id` (`track_id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_trash_bin;
CREATE TABLE `ppSD_trash_bin` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `act_id` varchar(35) DEFAULT NULL,
  `data` mediumtext,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  PRIMARY KEY (`id`),
  KEY `act_id` (`act_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_uploads;
CREATE TABLE `ppSD_uploads` (
  `id` varchar(30) NOT NULL DEFAULT '',
  `item_id` varchar(35) DEFAULT NULL COMMENT 'Matches either the ppSD_members id or ppSD_contacts id',
  `type` enum('member','contact','event','product','cart_category','digital_product','employee') DEFAULT NULL,
  `filename` varchar(150) DEFAULT '',
  `name` varchar(150) DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT '1920-01-01 00:01:01',
  `downloaded` int(8) DEFAULT NULL,
  `label` varchar(25) DEFAULT NULL COMMENT 'Optional label that can be sent from the hidden form.',
  `cp_only` tinyint(1) DEFAULT '0' COMMENT '1 = only visible on admin CP',
  `note_id` varchar(35) DEFAULT NULL,
  `owner` mediumint(9) DEFAULT NULL,
  `email_id` varchar(35) DEFAULT NULL,
  `byuser` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`item_id`),
  KEY `label` (`label`),
  KEY `note_id` (`note_id`),
  KEY `owner` (`owner`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_usage_logs;
CREATE TABLE `ppSD_usage_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT '1920-01-01 00:01:01',
  `end_date` datetime DEFAULT '1920-01-01 00:01:01',
  `username` varchar(150) DEFAULT NULL,
  `act_id` varchar(35) DEFAULT NULL,
  `type` enum('staff','user') DEFAULT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '1',
  `msg` varchar(255) DEFAULT NULL,
  `task` varchar(75) DEFAULT NULL,
  `ip` varchar(25) DEFAULT NULL,
  `session` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`task`),
  KEY `session` (`session`)
) ENGINE=InnoDB AUTO_INCREMENT=6794 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_widgets;
CREATE TABLE `ppSD_widgets` (
  `id` varchar(75) NOT NULL DEFAULT '',
  `name` varchar(45) DEFAULT NULL,
  `type` enum('plugin','menu','html','code','upload_list') DEFAULT NULL,
  `menu_type` enum('horizontal','vertical') DEFAULT NULL,
  `content` longtext,
  `active` tinyint(1) DEFAULT '1',
  `add_class` varchar(50) DEFAULT NULL,
  `add_id` varchar(50) DEFAULT NULL,
  `author` varchar(35) DEFAULT NULL,
  `author_url` varchar(120) DEFAULT NULL,
  `author_twitter` varchar(120) DEFAULT NULL,
  `version` varchar(6) DEFAULT NULL,
  `installed` datetime DEFAULT '1920-01-01 00:01:01',
  `original_creator` varchar(40) DEFAULT NULL,
  `original_creator_url` varchar(120) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_widgets_menus;
CREATE TABLE `ppSD_widgets_menus` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `widget_id` varchar(25) DEFAULT NULL,
  `submenu` mediumint(6) DEFAULT NULL,
  `title` varchar(125) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `link_type` tinyint(1) DEFAULT '1' COMMENT '1 = cms page, 2 = full url, 3 = onsite build url',
  `link_target` enum('same','new') DEFAULT NULL,
  `position` smallint(3) DEFAULT NULL,
  `content_id` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submenu` (`submenu`),
  KEY `widget_id` (`widget_id`),
  KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_yahrzeits;
CREATE TABLE `ppSD_yahrzeits` (
  `id` varchar(20) NOT NULL,
  `English_Name` varchar(255) DEFAULT NULL,
  `Hebrew_Name` varchar(255) DEFAULT NULL,
  `English_Date_of_Death` datetime DEFAULT NULL,
  `Hebrew_Date_of_Death` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ppSD_yahrzeit_members;
CREATE TABLE `ppSD_yahrzeit_members` (
  `yahrzeit_id` varchar(20) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `Relationship` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE OR REPLACE VIEW `view_yahrzeit_data` AS (select `a`.`yahrzeit_id` AS `yahrzeit_id`,concat(coalesce(`b`.`member_id`,''),',',coalesce(`a`.`Relationship`,''),',',coalesce(`b`.`first_name`,''),' ',coalesce(`b`.`last_name`,''),',',coalesce(`b`.`address_line_1`,''),',',coalesce(`b`.`address_line_2`,''),',',coalesce(`b`.`city`,''),',',coalesce(`b`.`state`,''),',',coalesce(`b`.`zip`,'')) AS `MemberData` from (`ppSD_yahrzeit_members` `a` left join `ppSD_member_data` `b` on((`a`.`user_id` = `b`.`member_id`))));