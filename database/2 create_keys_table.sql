drop table if exists t_keys;
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

alter table t_keys add constraint FK_RELATIONSHIP_1 foreign key (user_id)
      references t_users (id) on delete restrict on update restrict;