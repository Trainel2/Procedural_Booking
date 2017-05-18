/*
Navicat MySQL Data Transfer

Source Server         : Mysql
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : meetingroom

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-05-18 14:00:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for booking
-- ----------------------------
DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `id` int(11) NOT NULL COMMENT 'รหัสการจองห้องประชุม',
  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'หัวข้อการจองห้องประชุม',
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'รายละเอียด',
  `dateStart` date NOT NULL COMMENT 'วันที่จอง',
  `timeStart` time NOT NULL COMMENT 'เวลาที่จอง',
  `dateFinish` date NOT NULL COMMENT 'วันที่สิ้นสุด',
  `timeFinish` time NOT NULL COMMENT 'เวลาสิ้นสุด',
  `quantity` int(11) NOT NULL COMMENT 'จำนวนผู้เข้าอบรม',
  `status` enum('0','1','2') COLLATE utf8_bin DEFAULT '0' COMMENT 'สถานะการจอง',
  `roomID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of booking
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_book
-- ----------------------------
DROP TABLE IF EXISTS `tbl_book`;
CREATE TABLE `tbl_book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_date_start` date DEFAULT NULL,
  `book_time_start` time DEFAULT NULL,
  `book_date_finish` date DEFAULT NULL,
  `book_time_finish` time DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_detail` varchar(255) DEFAULT NULL,
  `book_qty` int(11) DEFAULT NULL,
  `book_status` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_book
-- ----------------------------
INSERT INTO `tbl_book` VALUES ('1', '2016-11-16', '08:30:00', '2016-11-23', '17:30:00', 'อบรมพนักงานใหม่', 'อบรมพนักงานใหม่ ...', '20', 'อนุมัติ', '1', '1');
INSERT INTO `tbl_book` VALUES ('2', '2017-01-18', '08:00:00', '2017-01-18', '16:00:00', 'การอบรมเกี่ยวกับคอมพิวเตอร์', 'ความรู้ทั่วไปเกี่ยวคอมพิวเตอร์', '20', 'รอการอนุมัติ', '2', '1');
INSERT INTO `tbl_book` VALUES ('3', '2016-11-15', '18:00:00', '2016-11-19', '19:30:00', 'Test', 'Test', '20', 'อนุมัติ', '1', '3');
INSERT INTO `tbl_book` VALUES ('4', '2016-11-15', '18:00:00', '2016-11-19', '19:30:00', 'Test1', 'test1', '20', 'อนุมัติ', '1', '2');
INSERT INTO `tbl_book` VALUES ('5', '2016-11-29', '16:00:00', '2016-11-30', '16:30:00', 'test2', 'test2', '20', 'รอการอนุมัติ', '1', '1');

-- ----------------------------
-- Table structure for tbl_department
-- ----------------------------
DROP TABLE IF EXISTS `tbl_department`;
CREATE TABLE `tbl_department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_department
-- ----------------------------
INSERT INTO `tbl_department` VALUES ('1', 'เทคโนโลยีสารสนเทศ');
INSERT INTO `tbl_department` VALUES ('2', 'bbb');
INSERT INTO `tbl_department` VALUES ('4', 'กกก');
INSERT INTO `tbl_department` VALUES ('5', 'test');

-- ----------------------------
-- Table structure for tbl_news
-- ----------------------------
DROP TABLE IF EXISTS `tbl_news`;
CREATE TABLE `tbl_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `news_detail` text COLLATE utf8_bin,
  `news_date` date DEFAULT NULL,
  `news_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `news_upload` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of tbl_news
-- ----------------------------
INSERT INTO `tbl_news` VALUES ('1', 'test', 0xE0B897E0B894E0B8AAE0B8ADE0B89A, '2016-11-17', null, null, '1');
INSERT INTO `tbl_news` VALUES ('11', 'ฟฟฟ', 0xE0B89FE0B89FE0B89F, '2016-11-21', null, null, '1');
INSERT INTO `tbl_news` VALUES ('17', 'ทดสอบการโพสข้อมูลข่าวสารบริษัท', 0xE0B882E0B988E0B8B2E0B8A7E0B8AAE0B8B2E0B8A3E0B89AE0B8A3E0B8B4E0B8A9E0B8B1E0B8970D3C62723E0AE0B897E0B894E0B8AAE0B8ADE0B89AE0B881E0B8B2E0B8A3E0B897E0B8B3E0B887E0B8B2E0B8990D3C62723E0A6173646661736661, '2016-12-06', 'New Text Document (2).txt', 'file_5846689f8d272.txt', '1');

-- ----------------------------
-- Table structure for tbl_rooms
-- ----------------------------
DROP TABLE IF EXISTS `tbl_rooms`;
CREATE TABLE `tbl_rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) DEFAULT NULL,
  `room_detail` varchar(255) DEFAULT NULL,
  `room_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_rooms
-- ----------------------------
INSERT INTO `tbl_rooms` VALUES ('1', 'ห้องประชุม 1', 'จุคนได้ ... 5555', 'rooms_582175dd95cd0.jpg');
INSERT INTO `tbl_rooms` VALUES ('2', 'ห้องประชุม 2', 'test', 'rooms_582c0a44d941b.png');
INSERT INTO `tbl_rooms` VALUES ('3', 'teest 3', 'test', 'rooms_582c0ab034735.png');

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_firstname` varchar(255) DEFAULT NULL,
  `user_lastname` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES ('1', 'admin', '2bae8b8de8bf572e3edfa5048eec47d9db073da8390de83a5dfee102c2ee0894', 'Administrator', 'admin', 'admin@admin.com', 'admin', '1');
INSERT INTO `tbl_users` VALUES ('2', 'user', '2bae8b8de8bf572e3edfa5048eec47d9db073da8390de83a5dfee102c2ee0894', 'test', 'test', 'test@test.com', 'user', '1');
INSERT INTO `tbl_users` VALUES ('5', 'test', '2bae8b8de8bf572e3edfa5048eec47d9db073da8390de83a5dfee102c2ee0894', 'ทดสอบ', 'ทดสอบ', 'test@test.com', 'user', '4');
INSERT INTO `tbl_users` VALUES ('6', 'abc', '2bae8b8de8bf572e3edfa5048eec47d9db073da8390de83a5dfee102c2ee0894', 'aaa', 'bbb', 'ab@ab.com', 'user', '2');
