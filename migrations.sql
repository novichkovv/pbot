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