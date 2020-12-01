DROP TABLE IF EXISTS t_assets;

DROP TABLE IF EXISTS t_users;

DROP TABLE IF EXISTS t_keys;

CREATE TABLE t_assets (
	id INT NOT NULL AUTO_INCREMENT,
	user_id INT,
	plat_mobil VARCHAR ( 50 ),
	no_rangka VARCHAR ( 120 ),
	no_mesin VARCHAR ( 120 ),
	owner_name VARCHAR ( 100 ),
	date_oil TIMESTAMP NULL DEFAULT NULL,
	date_expired_oil TIMESTAMP NULL DEFAULT NULL,
	status TINYINT,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY ( id ) 
);

CREATE TABLE t_users
(
   id                   INT NOT NULL AUTO_INCREMENT,
   username             VARCHAR(50),
   password             VARCHAR(256),
   email                VARCHAR(50),
   status               INT,
   created_at           TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
   updated_at           TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
   PRIMARY KEY (id)
);

CREATE TABLE `t_keys` (
	`id` INT ( 11 ) NOT NULL AUTO_INCREMENT,
	`user_id` INT ( 11 ) NOT NULL,
	`key` VARCHAR ( 40 ) NOT NULL,
	`level` INT ( 2 ) NOT NULL,
	`ignore_limits` TINYINT ( 1 ) NOT NULL DEFAULT '0',
	`is_private_key` TINYINT ( 1 ) NOT NULL DEFAULT '0',
	`ip_addresses` TEXT NULL DEFAULT NULL,
	`date_created` VARCHAR ( 11 ) NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY ( `id` ) 
) ENGINE = INNODB DEFAULT CHARSET = utf8;


ALTER TABLE t_assets ADD CONSTRAINT FK_RELATIONSHIP_1 FOREIGN KEY ( user_id ) 
	REFERENCES t_users ( id ) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE t_keys add CONSTRAINT FK_RELATIONSHIP_2 FOREIGN KEY (user_id)
    REFERENCES t_users (id) ON DELETE restrict ON UPDATE restrict;