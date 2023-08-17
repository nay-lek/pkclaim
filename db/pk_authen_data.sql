/*
Navicat MySQL Data Transfer

Source Server         : hosxp
Source Server Version : 50505
Source Host           : 192.168.1.200:3306
Source Database       : hos

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-08-17 13:57:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pk_authen_data
-- ----------------------------
DROP TABLE IF EXISTS `pk_authen_data`;
CREATE TABLE `pk_authen_data` (
  `hosp_code` varchar(255) NOT NULL,
  `hosp_name` varchar(255) DEFAULT NULL,
  `cid` varchar(255) NOT NULL,
  `pt_name` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `main_pttype` varchar(255) DEFAULT NULL,
  `sub_pttype` varchar(255) DEFAULT NULL,
  `service_in_code` varchar(255) DEFAULT NULL,
  `claim_code` varchar(255) DEFAULT NULL,
  `service_in_type` varchar(255) DEFAULT NULL,
  `service_code` varchar(255) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `hn_code` varchar(255) DEFAULT NULL,
  `an_code` varchar(255) DEFAULT NULL,
  `date_serv` varchar(255) NOT NULL,
  `date_authen` varchar(255) DEFAULT NULL,
  `sts` varchar(255) DEFAULT NULL,
  `route_authen` varchar(255) DEFAULT NULL,
  `method_authen` varchar(255) DEFAULT NULL,
  `user_authen` varchar(255) DEFAULT NULL,
  `date_modify_authen` varchar(255) DEFAULT NULL,
  `user_modify_authen` varchar(255) DEFAULT NULL,
  `comment_cancel` varchar(255) DEFAULT NULL,
  `update_flag` char(1) DEFAULT NULL,
  `vn_visit_pttype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`hosp_code`,`cid`,`date_serv`)
) ENGINE=MyISAM DEFAULT CHARSET=tis620 COLLATE=tis620_thai_ci;
