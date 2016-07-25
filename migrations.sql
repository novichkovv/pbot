CREATE DATABASE pbot;
USE pbot;
CREATE TABLE system_users (
id SERIAL PRIMARY KEY,
user_name VARCHAR (255) NOT NULL,
user_password VARCHAR (255) NOT NULL,
create_date DATETIME NOT NULL
)ENGINE=MyISAM;

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  phone VARCHAR (50) NOT NULL,
  create_date DATETIME NOT NULL
)ENGINE=MyISAM;

CREATE TABLE messages (
  id SERIAL PRIMARY KEY,
  message_status TINYINT NOT NULL DEFAULT 0,
  user_id BIGINT UNSIGNED NOT NULL,
  message_id VARCHAR(255) NOT NULL,
  recipient VARCHAR(255) NOT NULL,
  message_type TINYINT NOT NULL,
  content TEXT NOT NULL,
  udh VARCHAR(255) NULL,
  concat VARCHAR(255) NULL,
  concat_count INT NULL,
  concat_total INT NULL,
  push_date DATETIME NOT NULL,
  create_date DATETIME NOT NULL
)ENGINE=MyISAM;

CREATE TABLE user_phrases (
  id SERIAL PRIMARY KEY ,
  phrase_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  create_date DATETIME NOT NULL
)ENGINE=MyISAM;

CREATE TABLE phrases (
  id SERIAL PRIMARY KEY ,
  status_id BIGINT UNSIGNED NOT NULL,
  sort_order INT NULL,
  delay INT NOT NULL DEFAULT 0,
  mask TEXT NULL,
  reply TEXT NULL,
  create_date DATETIME NOT NULL
)ENGINE=MyISAM;

CREATE TABLE statuses (
  id SERIAL PRIMARY KEY ,
  status_name VARCHAR(255) NOT NULL
)ENGINE=MyISAM;

INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Welcome');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Macro');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Use Once');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Highest Wt');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('High Wt');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Normal Wt');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Followup Up');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('URL');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Global Plots');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Keep-alive');
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('Wild Card');

CREATE TABLE queues (
  id SERIAL PRIMARY KEY,
  phone VARCHAR(50) NOT NULL,
  send_time DATETIME NOT NULL,
  sms TEXT NOT NULL,
  sent TINYINT NOT NULL DEFAULT 0,
  user_id BIGINT UNSIGNED NOT NULL,
  message_id BIGINT UNSIGNED NOT NULL,
  create_date DATETIME NOT NULL
)ENGINE=MyISAM;

CREATE TABLE user_phrases (
  id SERIAL PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  phrase_id BIGINT UNSIGNED NOT NULL,
  create_date DATETIME NOT NULL
)ENGINE=MyISAM;

ALTER TABLE queues ADD global_plot TINYINT NOT NULL DEFAULT 0 AFTER sms;
ALTER TABLE queues ADD recipient VARCHAR(255) NOT NULL AFTER message_id;


CREATE TABLE campaigns (
  id SERIAL PRIMARY KEY,
  campaign_name VARCHAR (255) NOT NULL,
  system_user_id BIGINT UNSIGNED NOT NULL,
  create_date DATETIME NOT NULL
);

ALTER TABLE phrases ADD campaign_id BIGINT UNSIGNED NOT NULL AFTER id;
ALTER TABLE queues ADD campaign_id BIGINT UNSIGNED NOT NULL AFTER id;
ALTER TABLE messages ADD campaign_id BIGINT UNSIGNED NOT NULL AFTER id;
ALTER TABLE campaigns ADD phone VARCHAR(255) NOT NULL DEFAULT 0 AFTER id;
ALTER TABLE user_phrases ADD campaign_id BIGINT UNSIGNED NOT NULL DEFAULT 0 AFTER id;

create index user_id on queues (user_id);

CREATE TABLE virtual_numbers (
  id SERIAL PRIMARY KEY,
  campaign_id BIGINT UNSIGNED NOT NULL,
  phone VARCHAR (255) NOT NULL,
  create_date DATETIME NOT NULL
);
ALTER TABLE user_phrases CHANGE campaign_id virtual_number VARCHAR(255) NOT NULL;

CREATE TABLE `old_messages` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`campaign_id` bigint(20) unsigned NOT NULL,
`message_status` tinyint(4) NOT NULL DEFAULT '0',
`user_id` bigint(20) unsigned NOT NULL,
`message_id` varchar(255) NOT NULL,
`recipient` varchar(255) NOT NULL,
`message_type` tinyint(4) NOT NULL,
`content` text NOT NULL,
`udh` varchar(255) DEFAULT NULL,
`concat` varchar(255) DEFAULT NULL,
`concat_count` int(11) DEFAULT NULL,
`concat_total` int(11) DEFAULT NULL,
`push_date` datetime NOT NULL,
`create_date` datetime NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35775 DEFAULT CHARSET=latin1;

CREATE TABLE `old_queues` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`campaign_id` bigint(20) unsigned NOT NULL,
`phone` varchar(50) NOT NULL,
`send_time` datetime NOT NULL,
`sms` text NOT NULL,
`global_plot` tinyint(4) NOT NULL DEFAULT '0',
`sent` tinyint(4) NOT NULL DEFAULT '0',
`user_id` bigint(20) unsigned NOT NULL,
`message_id` bigint(20) unsigned NOT NULL,
`recipient` varchar(255) NOT NULL,
`create_date` datetime NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4368 DEFAULT CHARSET=latin1;

CREATE TABLE `old_user_phrases` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`virtual_number` varchar(255) NOT NULL,
`phrase_id` bigint(20) unsigned NOT NULL,
`user_id` bigint(20) unsigned NOT NULL,
`create_date` datetime NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4029 DEFAULT CHARSET=latin1;

CREATE TABLE state_codes (
  id SERIAL PRIMARY KEY,
  state_code INT NOT NULL,
  state VARCHAR(255) NOT NULL
)ENGINE=MyISAM;

INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('201', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('202', 'Washington D.C.');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('203', 'Connecticut');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('205', 'Alabama');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('206', 'Washington');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('207', 'Maine');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('208', 'Idaho');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('209', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('210', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('212', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('213', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('214', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('215', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('216', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('217', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('218', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('219', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('220', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('224', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('225', 'Louisiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('228', 'Mississippi');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('229', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('231', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('234', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('239', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('240', 'Maryland');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('248', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('251', 'Alabama');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('252', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('253', 'Washington');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('254', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('256', 'Alabama');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('260', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('262', 'Wisconsin');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('264', 'Anguilla');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('267', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('269', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('270', 'Kentucky');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('272', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('276', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('281', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('301', 'Maryland');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('302', 'Delaware');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('303', 'Colorado');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('304', 'West Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('305', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('307', 'Wyoming');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('308', 'Nebraska');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('309', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('310', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('312', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('313', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('314', 'Missouri');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('315', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('316', 'Kansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('317', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('318', 'Louisiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('319', 'Iowa');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('320', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('321', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('323', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('325', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('330', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('331', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('334', 'Alabama');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('336', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('337', 'Louisiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('339', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('346', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('347', 'NewYork');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('351', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('352', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('360', 'Washington');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('361', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('364', 'Kentucky');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('380', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('385', 'Utah');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('386', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('401', 'Rhode Island');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('402', 'Nebraska');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('404', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('405', 'Oklahoma');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('406', 'Montana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('407', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('408', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('409', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('410', 'Maryland');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('412', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('413', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('414', 'Wisconsin');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('415', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('417', 'Missouri');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('419', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('423', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('424', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('425', 'Washington');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('430', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('432', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('434', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('435', 'Utah');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('440', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('441', 'Bermuda');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('442', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('443', 'Maryland');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('458', 'Oregon');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('469', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('470', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('473', 'Grenada');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('475', 'Connecticut');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('478', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('479', 'Arkansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('480', 'Arizona');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('484', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('501', 'Arkansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('502', 'Kentucky');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('503', 'Oregon');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('504', 'Louisiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('505', 'NewMexico');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('507', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('508', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('509', 'Washington');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('510', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('512', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('513', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('515', 'Iowa');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('516', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('517', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('518', 'NewYork');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('520', 'Arizona');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('530', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('531', 'Nebraska');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('534', 'Wisconsin');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('539', 'Oklahoma');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('540', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('541', 'Oregon');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('551', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('559', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('561', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('562', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('563', 'Iowa');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('567', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('570', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('571', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('573', 'Missouri');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('574', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('575', 'New Mexico');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('580', 'Oklahoma');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('585', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('586', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('601', 'Mississippi');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('602', 'Arizona');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('603', 'New Hampshire');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('605', 'South Dakota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('606', 'Kentucky');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('607', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('608', 'Wisconsin');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('609', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('610', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('612', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('614', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('615', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('616', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('617', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('618', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('619', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('620', 'Kansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('623', 'Arizona');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('626', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('628', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('629', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('630', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('631', 'NewYork');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('636', 'Missouri');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('641', 'Iowa');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('646', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('650', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('651', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('657', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('660', 'Missouri');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('661', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('662', 'Mississippi');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('664', 'Montserrat');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('667', 'Maryland');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('669', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('678', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('681', 'West Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('682', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('701', 'North Dakota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('702', 'Nevada');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('703', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('704', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('706', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('707', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('708', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('712', 'Iowa');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('713', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('714', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('715', 'Wisconsin');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('716', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('717', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('718', 'NewYork');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('719', 'Colorado');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('720', 'Colorado');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('721', 'Sint Maarten');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('724', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('725', 'Nevada');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('727', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('731', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('732', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('734', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('740', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('743', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('747', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('754', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('757', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('758', 'St.Lucia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('760', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('762', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('763', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('765', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('767', 'Dominica');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('769', 'Mississippi');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('770', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('772', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('773', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('774', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('775', 'Nevada');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('779', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('781', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('785', 'Kansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('786', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('801', 'Utah');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('802', 'Vermont');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('803', 'South Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('804', 'Virginia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('805', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('806', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('810', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('812', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('813', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('814', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('815', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('816', 'Missouri');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('817', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('818', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('828', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('830', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('831', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('832', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('843', 'South Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('845', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('847', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('848', 'NewJersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('850', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('854', 'South Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('856', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('857', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('858', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('859', 'Kentucky');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('860', 'Connecticut');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('862', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('863', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('864', 'South Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('865', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('870', 'Arkansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('872', 'Illinois');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('876', 'Jamaica');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('878', 'Pennsylvania');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('901', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('903', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('904', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('906', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('907', 'Alaska');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('908', 'NewJersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('909', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('910', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('912', 'Georgia');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('913', 'Kansas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('914', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('915', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('916', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('917', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('918', 'Oklahoma');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('919', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('920', 'Wisconsin');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('925', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('928', 'Arizona');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('929', 'New York');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('930', 'Indiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('931', 'Tennessee');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('936', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('937', 'Ohio');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('938', 'Alabama');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('940', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('941', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('947', 'Michigan');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('949', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('951', 'California');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('952', 'Minnesota');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('954', 'Florida');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('956', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('959', 'Connecticut');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('970', 'Colorado');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('971', 'Oregon');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('972', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('973', 'New Jersey');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('978', 'Massachusetts');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('979', 'Texas');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('980', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('984', 'North Carolina');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('985', 'Louisiana');
INSERT INTO `pbot`.`state_codes` (`state_code`, `state`) VALUES ('989', 'Michigan');

create unique index state_code on state_codes (state_code);
INSERT INTO `pbot`.`statuses` (`status_name`) VALUES ('%GEO%');

CREATE TABLE system_settings (
  id SERIAL PRIMARY KEY,
  setting_key VARCHAR (255) NOT NULL UNIQUE KEY,
  setting_value VARCHAR(255) NULL
)ENGINE=MyISAM;

ALTER TABLE users ADD blocked TINYINT NOT NULL DEFAULT 0 AFTER phone;

CREATE TABLE blacklist (
  id SERIAL PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  phone VARCHAR(20) NOT NULL
)ENGINE=MyISAM;

CREATE INDEX user_id ON blacklist (user_id);
CREATE INDEX phone ON blacklist (phone);

CREATE TABLE `county_codes` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`county_code` int(11) NOT NULL,
`county` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `id` (`id`),
UNIQUE KEY `county_code` (`county_code`)
) ENGINE=MyISAM AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;

INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('201', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('202', 'Washington');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('203', 'New Haven');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('204', 'Yorkton');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('205', 'Birmingham');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('206', 'Seattle');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('207', 'Portland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('208', 'Boise');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('209', 'Fresno');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('210', 'San Antonio');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('212', 'New York');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('213', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('214', 'Dallas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('215', 'Philadelphia');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('216', 'Cleveland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('217', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('218', 'Duluth');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('219', 'Valparaiso');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('224', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('225', 'Baton Rouge');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('226', 'Wyoming');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('228', 'Gulfport');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('229', 'Albany');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('231', 'Muskegon');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('234', 'Akron');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('236', 'Victoria');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('239', 'FortMyers');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('240', 'Baltimore');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('248', 'Detroit');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('249', 'Whitefish Falls');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('250', 'Zeballos');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('251', 'Mobile');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('252', 'Greenville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('253', 'Seattle');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('254', 'Killeen');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('256', 'Huntsville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('260', 'Fort Wayne');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('262', 'Milwaukee');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('267', 'Philadelphia');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('269', 'Kalamazoo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('270', 'Bowling Green');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('272', 'Lake Ariel');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('276', 'Martinsville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('281', 'Houston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('289', 'Woodbridge');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('301', 'Baltimore');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('302', 'Wilmington');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('303', 'Denver');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('304', 'Charleston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('305', 'Miami');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('306', 'Yorkton');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('307', 'Casper');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('308', 'Grand Island');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('309', 'Peoria');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('310', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('312', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('313', 'Detroit');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('314', 'SaintLouis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('315', 'Syracuse');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('316', 'Wichita');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('317', 'Indianapolis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('318', 'Shreveport');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('319', 'CedarRapids');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('320', 'SaintCloud');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('321', 'Orlando');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('323', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('325', 'Abilene');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('330', 'Akron');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('331', 'Lemont');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('334', 'Montgomery');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('336', 'Greensboro');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('337', 'Lafayette');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('339', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('340', 'Charlotte Amalie');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('343', 'Vankleek Hill');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('346', 'Houston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('347', 'Brooklyn');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('351', 'Danvers');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('352', 'Gainesville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('360', 'Seattle');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('361', 'Corpus Christi');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('365', 'Tottenham');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('385', 'Salt Lake City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('386', 'Daytona Beach');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('401', 'Providence');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('402', 'Omaha');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('403', 'Youngstown');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('404', 'Atlanta');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('405', 'Oklahoma City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('406', 'Billings');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('407', 'Orlando');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('408', 'San Jose');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('409', 'Beaumont');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('410', 'Baltimore');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('412', 'Pittsburgh');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('413', 'Springfield');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('414', 'Milwaukee');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('415', 'San Francisco');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('416', 'Toronto');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('417', 'Springfield');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('418', 'Ville Degelis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('419', 'Toledo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('423', 'Chattanooga');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('424', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('425', 'Seattle');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('430', 'Longview');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('431', 'Winnipeg');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('432', 'Midland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('434', 'Lynchburg');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('435', 'Park City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('437', 'Toronto');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('438', 'Saint Genevieve');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('440', 'Cleveland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('442', 'Victorville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('443', 'Baltimore');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('450', 'Yamaska');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('458', 'Eugene');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('469', 'Dallas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('470', 'Atlanta');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('475', 'New Haven');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('478', 'Macon');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('479', 'Springdale');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('480', 'Phoenix');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('484', 'Philadelphia');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('501', 'LittleRock');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('502', 'Louisville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('503', 'Portland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('504', 'New Orleans');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('505', 'Albuquerque');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('506', 'Youngs Cove Road');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('507', 'Rochester');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('508', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('509', 'Spokane');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('510', 'San Jose');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('512', 'Austin');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('513', 'Cincinnati');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('514', 'Saint Genevieve');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('515', 'Des Moines');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('516', 'Springfield Gardens');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('517', 'Lansing');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('518', 'Schenectady');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('519', 'Zurich');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('520', 'Phoenix');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('530', 'Sacramento');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('531', 'Lincoln');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('534', 'Chippewa Falls');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('539', 'Tulsa');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('540', 'Fredericksburg');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('541', 'Eugene');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('551', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('559', 'Fresno');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('561', 'West Palm Beach');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('562', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('563', 'Davenport');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('567', 'Toledo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('570', 'Wilkes Barre');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('571', 'Alexandria');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('573', 'Columbia');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('574', 'South Bend');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('575', 'Las Cruces');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('579', 'Waterloo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('580', 'Oklahoma City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('581', 'Vallee Jonction');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('585', 'Buffalo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('586', 'Detroit');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('587', 'Wetaskiwin');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('601', 'Jackson');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('602', 'Phoenix');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('603', 'Manchester');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('604', 'Yale');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('605', 'Sioux Falls');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('606', 'Sharpsburg');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('607', 'Freeville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('608', 'Madison');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('609', 'Camden');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('610', 'Philadelphia');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('612', 'Minneapolis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('613', 'Yarker');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('614', 'Columbus');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('615', 'Nashville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('616', 'Grand Rapids');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('617', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('618', 'Belleville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('619', 'San Diego');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('620', 'Hutchinson');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('623', 'Phoenix');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('626', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('630', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('631', 'Deer Park');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('636', 'Saint Louis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('639', 'Regina');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('641(Beaman', '');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('646', 'Brooklyn');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('647', 'Toronto');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('650', 'San Jose');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('651', 'Minneapolis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('657', 'Long Beach');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('660', 'Otterville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('661', 'Bakersfield');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('662', 'Southaven');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('667', 'Baltimore');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('669', 'San Jose');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('670', 'Saipan');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('671', 'Santa Rita');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('678', 'Atlanta');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('681', 'Charleston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('682', 'Dallas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('684', 'Pago Pago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('701', 'Fargo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('702', 'Las Vegas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('703', 'Alexandria');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('704', 'Charlotte');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('705', 'Woodville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('706', 'Augusta');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('707', 'Santa Rosa');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('708', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('709', 'Woody Point');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('712', 'Sioux City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('713', 'Houston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('714', 'Long Beach');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('715', 'Green Bay');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('716', 'Buffalo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('717', 'Lancaster');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('718', 'Brooklyn');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('719', 'Colorado Springs');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('720', 'Denver');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('724', 'Pittsburgh');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('725', 'Las Vegas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('727', 'Tampa');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('731', 'Jackson');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('732', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('734', 'Detroit');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('737', 'Austin');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('740', 'Columbus');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('747', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('754', 'Fort Lauderdale');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('757', 'Virginia Beach');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('760', 'San Diego');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('762', 'Augusta');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('763', 'Minneapolis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('765', 'Indianapolis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('769', 'Jackson');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('770', 'Atlanta');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('772', 'Port Saint Lucie');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('773', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('774', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('775', 'Reno');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('778', 'Youbou');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('779', 'Rockford');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('780', 'Zama');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('781', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('785', 'Topeka');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('786', 'Miami');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('787', 'Bayamon');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('801', 'Salt Lake City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('802', 'Shelburne');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('803', 'Columbia');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('804', 'Richmond');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('805', 'Bakersfield');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('806', 'Lubbock');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('807', 'Wunumin Lake');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('808', 'Honolulu');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('810', 'Flint');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('812', 'Evansville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('813', 'Tampa');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('814', 'Erie');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('815', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('816', 'Kansas City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('817', 'Dallas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('818', 'Los Angeles');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('819', 'Yamachiche');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('828', 'Asheville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('830', 'NewBraunfels');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('831', 'Salinas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('832', 'Houston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('843', 'Charleston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('845', 'Poughkeepsie');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('847', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('848', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('850', 'Pensacola');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('856', 'Camden');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('857', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('858', 'San Diego');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('859', 'Lexington');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('860', 'Hartford');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('862', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('863', 'Kissimmee');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('864', 'Greenville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('865', 'Knoxville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('867', 'Yellowknife');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('870', 'Jonesboro');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('872', 'Chicago');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('873', 'Woburn');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('878', 'Pittsburgh');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('901', 'Memphis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('902', 'Yarmouth');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('903', 'Tyler');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('904', 'Jacksonville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('905', 'Woodbridge');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('906', 'Deerton');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('907', 'Anchorage');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('908', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('909', 'Riverside');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('910', 'Fayetteville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('912', 'Savannah');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('913', 'Kansas City');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('914', 'Manhattan');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('915', 'El Paso');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('916', 'Sacramento');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('917', 'Brooklyn');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('918', 'Tulsa');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('919', 'Raleigh');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('920', 'Milwaukee');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('925', 'Oakland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('928', 'Phoenix');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('929', 'Brooklyn');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('931', 'Clarksville');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('936', 'Conroe');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('937', 'Dayton');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('938', 'Goodwater');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('939', 'Bayamon');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('940', 'Denton');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('941', 'Sarasota');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('947', 'Southfield');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('949', 'Santa Ana');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('951', 'Riverside');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('952', 'Minneapolis');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('954', 'Fort Lauderdale');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('956', 'Laredo');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('970', 'Ft Collins');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('971', 'Portland');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('972', 'Dallas');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('973', 'Newark');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('978', 'Boston');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('979', 'College Station');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('980', 'Charlotte');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('984', 'Raleigh');
INSERT INTO `pbot`.`county_codes` (`county_code`, `county`) VALUES ('985', 'New Orleans');


ALTER TABLE campaigns ADD sort_order INT NOT NULL DEFAULT 0 AFTER id;