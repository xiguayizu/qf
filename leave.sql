/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : leave

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2015-03-04 13:58:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL COMMENT '昵称',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `parentnickname` varchar(20) NOT NULL,
  `parentid` int(10) unsigned NOT NULL COMMENT '老爹',
  `isshow` int(1) NOT NULL DEFAULT '0' COMMENT '是否审核？1审核过。0未审核',
  `ispass` int(1) NOT NULL DEFAULT '0' COMMENT '通过审核？ 1通过  0失败',
  `content` varchar(400) NOT NULL,
  `addip` char(15) NOT NULL,
  `isadvice` int(1) NOT NULL DEFAULT '0' COMMENT '"没有做"是否邮件通知',
  `advicestatic` int(1) NOT NULL DEFAULT '0' COMMENT '"没有做"是否通知过',
  `page` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '“没有做” 属于的页数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('33', '123', '', '1425448648', '0', '0', '1', '1', '我是1', '127.0.0.1', '0', '0', '0');
INSERT INTO `message` VALUES ('34', '我是2层', '', '1425448667', '123', '33', '1', '1', '我是2层', '127.0.0.1', '0', '0', '0');
INSERT INTO `message` VALUES ('35', '我是1层', '', '1425448684', '0', '0', '1', '1', '我是1层', '127.0.0.1', '0', '0', '0');
