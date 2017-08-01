
/*CREATE DATABASE*/
DROP DATABASE IF EXISTS superkarlskrona;

CREATE DATABASE superkarlskrona;

/*CREATE TABLES*/
DROP TABLE IF EXISTS `superkarlskrona`.`user`;

CREATE TABLE `superkarlskrona`.`user`(
  `uid` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250),
  `birthday` VARCHAR(250),
  `email` VARCHAR(250),
  `code` VARCHAR(250),
  PRIMARY KEY(`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `superkarlskrona`.`topic`;

CREATE TABLE `superkarlskrona`.`topic`(
  `tid` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250),
  `like` INT DEFAULT '0',
  `dislike` INT DEFAULT '0',
  `color` VARCHAR(250),
  `description` VARCHAR(250),
  `code` VARCHAR(250),
  PRIMARY KEY(`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `superkarlskrona`.`topic` add COLUMN uid int; /*VITAL!!!!!!S*/
alter table `superkarlskrona`.`topic` add COLUMN dateTimeStamp TIMESTAMP NOT NULL DEFAULT NOW();

DROP TABLE IF EXISTS `superkarlskrona`.`comment`;

CREATE TABLE `superkarlskrona`.`comment`(
  `cid` INT NOT NULL AUTO_INCREMENT,
  `tid` INT,
  `uid` INT,
  `like` INT DEFAULT '0',
  `dislike` INT DEFAULT '0',
  `comment` VARCHAR(250),
  PRIMARY KEY(`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*Don't need foreign keys*/

alter table `superkarlskrona`.`comment` add COLUMN dateTimeStamp TIMESTAMP NOT NULL DEFAULT NOW();

CREATE TABLE `superkarlskrona`.`color`(
  `colorid` INT NOT NULL AUTO_INCREMENT,
  `color` VARCHAR(250),
  PRIMARY KEY(`colorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `superkarlskrona`.`color`(`color`) VALUES
("lightpink"),
("lightblue"),
("lightgreen"),
("yellow");


DROP TABLE IF EXISTS `superkarlskrona`.`room`;

CREATE TABLE `superkarlskrona`.`room`(
  `rid` INT NOT NULL AUTO_INCREMENT,
  `address` VARCHAR(250),
  `description` VARCHAR(250),
  `contact` VARCHAR(250),
  `uid` int,
  PRIMARY KEY(`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `superkarlskrona`.`application`;

CREATE TABLE `superkarlskrona`.`application`(
  `aid` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(250),
  `contact` VARCHAR(250),
  `uid` int, /*This uif belongs to the user who applies the room, rather than publish it!*/
  `rid` int,
  PRIMARY KEY(`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* create admin user */
INSERT INTO `superkarlskrona`.`user`(`name`, `email`, `code`) VALUES ("admin", "dev@superkarlskrona.se", "1" );


/* Create Procedure*/
DROP PROCEDURE IF EXISTS `superkarlskrona`.add_topic;


DELIMITER //
CREATE PROCEDURE `superkarlskrona`.add_topic (
	  _topic VARCHAR(250),
      _uid int,
    OUT output VARCHAR(500)
)
BEGIN
    DECLARE _color VARCHAR(250);
	  SET output = "";

    IF _topic != "" THEN
    BEGIN

            SET _color = (SELECT color FROM color ORDER BY RAND() LIMIT 1);

						INSERT INTO topic		(description, color, uid) VALUES  (_topic, _color, _uid);

						SET output = "Topic added!";


    END;
	ELSE
		SET output = "Something went wrong please try again!";
    END IF;
END;
//
DELIMITER ;
