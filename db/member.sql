-- Active: 1699513016791@@127.0.0.1@3306@memsite

-- CREATE DATABASE `memsite`;

use memsite;

SHOW TABLES;

SELECT * FROM member;

DESC member;

CREATE TABLE
    `member` (
        `idx` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `id` VARCHAR(100) DEFAULT '',
        `name` VARCHAR(100) DEFAULT '',
        `email` VARCHAR(100) DEFAULT '',
        `password` VARCHAR(100) DEFAULT '',
        `zipcode` CHAR(5) DEFAULT '',
        `addr1` VARCHAR(255) DEFAULT '',
        `addr2` VARCHAR(255) DEFAULT '',
        `photo` VARCHAR(100) DEFAULT '',
        `create_at` DATETIME,
        `ip` VARCHAR(20) DEFAULT '',
        PRIMARY KEY(idx),
        UNIQUE INDEX `id` (`id`) Using BTREE
    );

ALTER TABLE `member`
ADD
    COLUMN `login_dt` DATETIME AFTER create_at;

DESC member;

ALTER TABLE `member` ADD COLUMN `level` TINYINT UNSIGNED DEFAULT 1;

UPDATE `member` SET id = 'admin', `level` = 10 WHERE id = '관리자';

UPDATE `member` SET name = '관리자', `level` = 10 WHERE id = 'admin';

CREATE TABLE
    `board_manage` (
        `idx` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) DEFAULT '' COMMENT '게시판 이름',
        `btype` ENUM('board', 'gallery') DEFAULT 'board' COMMENT '게시판 타입',
        `cnt` INTEGER DEFAULT 0 COMMENT '게시물 수',
        `create_at` DATETIME,
        PRIMARY KEY (idx)
    );

ALTER TABLE board_manage
ADD
    COLUMN `bcode` VARCHAR(40) DEFAULT '' AFTER `name`;

SELECT * FROM board_manage;

DESC board_manage;

INSERT INTO board_manage
VALUES (
        NULL,
        '자유게시판',
        'free',
        'board',
        0,
        NOW()
    );