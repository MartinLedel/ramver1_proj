-- -----------------------------------------------------
-- Database ramverk1_proj
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `ramverk1_proj`;

CREATE DATABASE IF NOT EXISTS `ramverk1_proj` CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci ;
SHOW WARNINGS;
USE `ramverk1_proj` ;

DROP USER IF EXISTS 'user'@'%';
CREATE USER IF NOT EXISTS 'user'@'%'
    IDENTIFIED WITH mysql_native_password
    BY 'pass'
;

GRANT ALL PRIVILEGES
ON ramverk1_proj.*
TO 'user'@'%'
;

-- Ensure UTF8 on the database connection
SET NAMES utf8;

DROP TABLE IF EXISTS PostsWithTags;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Thread;
DROP TABLE IF EXISTS Points;
DROP TABLE IF EXISTS Tags;
DROP TABLE IF EXISTS Forum;
DROP TABLE IF EXISTS User;

--
-- Table User
--

CREATE TABLE User (
    `id` INT AUTO_INCREMENT NOT NULL,
    `acronym` VARCHAR(80) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `active` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Forum - All threads should go here.
--
CREATE TABLE Forum (
    `id` INT AUTO_INCREMENT NOT NULL,
    `id_user` INT NOT NULL,
    `topic` VARCHAR(120) NOT NULL,
    `content` TEXT NOT NULL,
    `answered` VARCHAR(25) DEFAULT "No",
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (`id_user`)
    REFERENCES `User` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Thread - All posts under a thread so should go here.
--
CREATE TABLE Thread (
    `id` INT AUTO_INCREMENT NOT NULL,
    `id_user` INT,
    `id_forum` INT,
    `content` TEXT NOT NULL,
    `answer` VARCHAR(25) DEFAULT "No",
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (`id_user`)
    REFERENCES `User` (`id`),
    FOREIGN KEY (`id_forum`)
    REFERENCES `Forum` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Comments - Comments under a thread post should go here.
--
CREATE TABLE Comments (
    `id` INT AUTO_INCREMENT NOT NULL,
    `id_user` INT,
    `id_forum` INT,
    `id_thread` INT,
    `content` TEXT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (`id_user`)
    REFERENCES `User` (`id`),
    FOREIGN KEY (`id_forum`)
    REFERENCES `Forum` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Tags
--
CREATE TABLE Tags (
    `id` INT AUTO_INCREMENT NOT NULL,
    `tag` VARCHAR(250),
    PRIMARY KEY (id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `Tags` (`tag`)
VALUES ("Base game"), ("Iceborne"), ("Weapon guide"), ("Monster guide"), ("Random chit-chat"), ("Other");

--
-- Table PostsWithTags - Posts with their tags should go here.
--
CREATE TABLE PostsWithTags (
    `id` INT AUTO_INCREMENT NOT NULL,
    `id_forum` INT,
    `id_tags` INT,
    `tag` VARCHAR(250),
    PRIMARY KEY (id),
    FOREIGN KEY (`id_forum`)
    REFERENCES `Forum` (`id`),
    FOREIGN KEY (`id_tags`)
    REFERENCES `Tags` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `PostsWithTags` (`id_forum`, `id_tags`)
VALUES (1, 1), (1, 3), (2, 1), (2, 4), (3, 2), (3, 5), (4, 2), (4, 4);

--
-- Table User
--
-- CREATE TABLE Points (
--     `id` INT AUTO_INCREMENT NOT NULL,
--     `id_user` INT,
--     `points` INT,
--     PRIMARY KEY (id),
--     FOREIGN KEY (`id_user`)
--     REFERENCES `User` (`id`)
-- ) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
