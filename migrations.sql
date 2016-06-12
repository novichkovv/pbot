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
