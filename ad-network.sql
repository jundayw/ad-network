/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : ad-network

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2022-09-26 16:03:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `im_adsense`
-- ----------------------------
DROP TABLE IF EXISTS `im_adsense`;
CREATE TABLE `im_adsense` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `publishment_id` bigint(20) unsigned DEFAULT '0' COMMENT '流量主编号',
  `industry_id` bigint(20) unsigned DEFAULT '0' COMMENT '行业编号',
  `site_id` bigint(20) unsigned DEFAULT '0' COMMENT '站点编号',
  `channel_id` bigint(20) unsigned DEFAULT '0' COMMENT '频道编号',
  `size_id` bigint(20) unsigned DEFAULT '0' COMMENT '广告尺寸编号',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `origin` enum('UNION','LOCAL') DEFAULT 'UNION' COMMENT '类型{UNION:联盟广告}{LOCAL:本地广告}',
  `device` enum('PC','MOBILE') DEFAULT 'PC' COMMENT '设备{PC:电脑}{MOBILE:移动端}',
  `type` enum('SINGLE','MULTIGRAPH','POPUP','FLOAT','COUPLET') DEFAULT 'SINGLE' COMMENT '展现类型{SINGLE:单图}{MULTIGRAPH:多图}{POPUP:弹窗}{FLOAT:悬浮}{COUPLET:对联}',
  `charging` enum('DEFAULT','CPC','CPM','CPV','CPA','CPS') DEFAULT 'DEFAULT' COMMENT '广告类型{DEFAULT}{CPC}{CPM}{CPV}{CPA}{CPS}',
  `vacant` enum('EXCHANGE','DEFAULT','UNION','FIXED','HIDDEN') DEFAULT 'EXCHANGE' COMMENT '空闲设置{EXCHANGE:显示换量广告}{DEFAULT:显示默认广告}{UNION:显示联盟广告}{FIXED:固定占位符}{HIDDEN:隐藏广告位}',
  `locator` varchar(255) DEFAULT NULL COMMENT '默认广告地址',
  `image` varchar(255) DEFAULT NULL COMMENT '默认广告图片',
  `code` text COMMENT '联盟广告代码',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:投放中}{DISABLE:暂停投放}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='广告位';

-- ----------------------------
-- Records of im_adsense
-- ----------------------------
INSERT INTO `im_adsense` VALUES ('1', '10086', '3', '1', '1', '21', '单图换量', 'UNION', 'PC', 'SINGLE', 'CPS', 'EXCHANGE', null, null, null, '2022-09-24 12:51:28', '2022-09-26 14:43:32', null, 'NORMAL');
INSERT INTO `im_adsense` VALUES ('2', '10086', '3', '1', '1', '21', '多图本地', 'UNION', 'PC', 'MULTIGRAPH', 'DEFAULT', 'DEFAULT', 'http://v2.me.yunduanchongqing.com/user/login/', 'http://adwords.me.yunduanchongqing.com/upload/20220926/9b4db057fda9b0fd820a79c9ab41edaa.png', null, '2022-09-24 12:55:16', '2022-09-26 13:44:28', null, 'NORMAL');
INSERT INTO `im_adsense` VALUES ('3', '10086', '3', '1', '1', '9', '悬浮联盟', 'UNION', 'PC', 'FLOAT', 'DEFAULT', 'UNION', null, null, '<div id=\"kp_box_479\" data-pid=\"479\">\r\n    <div class=\"_gnumici5vli\"></div>\r\n    <script type=\"text/javascript\">\r\n        (window.slotbydup = window.slotbydup || []).push({\r\n            id: \"u5883818\",\r\n            container: \"_gnumici5vli\",\r\n            async: true\r\n        });\r\n        alert(123)\r\n\'ALERT\', \'CONSOLE\', \'LOCATION\', \'COOKIE\', \'EVAL\'\r\n\'alert\', \'console\', \'location\', \'cookie\', \'eval\'\r\n    </script>\r\n    <script type=\"text/javascript\" src=\"//cpro.baidustatic.com/cpro/ui/cm.js\" async=\"async\" defer=\"defer\"></script>\r\n</div>', '2022-09-24 13:06:07', '2022-09-25 14:48:31', null, 'NORMAL');
INSERT INTO `im_adsense` VALUES ('4', '10086', '3', '1', '1', '12', '对联占位', 'UNION', 'PC', 'COUPLET', 'CPS', 'FIXED', null, null, null, '2022-09-24 13:06:47', '2022-09-26 14:35:21', null, 'NORMAL');
INSERT INTO `im_adsense` VALUES ('5', '10086', '3', '1', '1', '9', '弹窗隐藏', 'UNION', 'PC', 'POPUP', 'DEFAULT', 'HIDDEN', null, null, null, '2022-09-24 13:07:20', '2022-09-24 23:20:07', null, 'NORMAL');
INSERT INTO `im_adsense` VALUES ('6', '10086', '3', '1', '1', '10', '悬浮换量', 'UNION', 'PC', 'FLOAT', 'CPS', 'EXCHANGE', null, null, null, '2022-09-24 17:38:48', '2022-09-26 14:43:24', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_advertisement`
-- ----------------------------
DROP TABLE IF EXISTS `im_advertisement`;
CREATE TABLE `im_advertisement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('COMPANY','PERSONAL') DEFAULT 'COMPANY' COMMENT '类型{COMPANY:公司}{PERSONAL:个人}',
  `name` varchar(255) DEFAULT NULL COMMENT '公司名称/真实姓名',
  `licence` varchar(255) DEFAULT NULL COMMENT '营业执照编号/身份证编号',
  `licence_image` varchar(255) DEFAULT NULL COMMENT '营业执照附件/身份证附件',
  `corporation` varchar(255) DEFAULT NULL COMMENT '联系人',
  `mobile` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `total` bigint(20) unsigned DEFAULT '0' COMMENT '总额',
  `balance` bigint(20) unsigned DEFAULT '0' COMMENT '余额',
  `frozen` bigint(20) unsigned DEFAULT '0' COMMENT '冻结金额',
  `audit` enum('INIT','WAIT','SUCCESS','FAILURE','STOP') DEFAULT 'INIT' COMMENT '审核状态{INIT:初始化}{WAIT:待审核}{SUCCESS:成功}{FAILURE:失败}{STOP:终止合作}',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10089 DEFAULT CHARSET=utf8mb4 COMMENT='广告主主体';

-- ----------------------------
-- Records of im_advertisement
-- ----------------------------
INSERT INTO `im_advertisement` VALUES ('1', 'COMPANY', '公益科技有限公司', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', '公益', '13627666666', '1000000', '1000000', '0', 'SUCCESS', null, '2022-09-20 12:16:03', null, 'NORMAL');
INSERT INTO `im_advertisement` VALUES ('2', 'PERSONAL', '换量科技有限公司', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', '换量', '13627685888', '1000000', '1000000', '0', 'SUCCESS', '2022-09-20 11:57:46', '2022-09-20 12:05:50', null, 'NORMAL');
INSERT INTO `im_advertisement` VALUES ('10086', 'PERSONAL', 'ad1', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', 'ad1', '13627685888', '1000000', '1000000', '0', 'SUCCESS', '2022-09-20 11:57:46', '2022-09-20 12:05:50', null, 'NORMAL');
INSERT INTO `im_advertisement` VALUES ('10087', 'COMPANY', 'ad2', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', 'ad2', '13627685888', '1000000', '1000000', '0', 'SUCCESS', '2022-09-20 11:57:46', '2022-09-20 12:05:50', null, 'NORMAL');
INSERT INTO `im_advertisement` VALUES ('10088', 'COMPANY', 'ad3', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', 'ad3', '13627685888', '1000000', '1000000', '0', 'SUCCESS', '2022-09-20 11:57:46', '2022-09-20 12:05:50', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_advertiser`
-- ----------------------------
DROP TABLE IF EXISTS `im_advertiser`;
CREATE TABLE `im_advertiser` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `advertisement_id` bigint(20) unsigned DEFAULT NULL,
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色编号',
  `role_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '角色名称',
  `usernick` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户名',
  `userpass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `usersalt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '加盐',
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `register_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '注册地址',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `last_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录地址',
  `last_time` datetime DEFAULT NULL COMMENT '登录时间',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') COLLATE utf8mb4_unicode_ci DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `username` (`username`(191)) USING BTREE,
  KEY `delete_time` (`delete_time`) USING BTREE,
  KEY `state` (`state`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='广告主账户';

-- ----------------------------
-- Records of im_advertiser
-- ----------------------------
INSERT INTO `im_advertiser` VALUES ('1', '1', '3', '管理员', 'admin', 'admin', 'fe711720669a634139a1c650be70a4ae', 'VOKYQR', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-09-26 09:52:31', '2022-01-01 18:00:00', '2022-09-26 09:52:31', null, 'NORMAL');
INSERT INTO `im_advertiser` VALUES ('2', '2', '3', '管理员', 'manager', 'manager', '55cfd6ad117185fceece18cc454e7984', 'JGtlMl', null, '127.0.0.1', '2022-09-20 11:57:46', '127.0.0.1', '2022-09-21 17:15:56', '2022-09-20 11:57:46', '2022-09-21 17:15:56', null, 'NORMAL');
INSERT INTO `im_advertiser` VALUES ('3', '2', '3', '管理员', 'member', 'member', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-09-21 17:15:56', '2022-09-20 11:57:46', '2022-09-20 11:57:46', null, 'NORMAL');
INSERT INTO `im_advertiser` VALUES ('4', '10086', '3', '管理员', 'test1', 'test1', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-09-26 11:50:56', '2022-01-01 18:00:00', '2022-09-26 11:50:56', null, 'NORMAL');
INSERT INTO `im_advertiser` VALUES ('5', '10087', '3', '管理员', 'test2', 'test2', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-01-01 18:00:00', '2022-01-01 18:00:00', '2022-01-01 18:00:00', null, 'NORMAL');
INSERT INTO `im_advertiser` VALUES ('6', '10088', '3', '管理员', 'test3', 'test3', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-01-01 18:00:00', '2022-01-01 18:00:00', '2022-01-01 18:00:00', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_channel`
-- ----------------------------
DROP TABLE IF EXISTS `im_channel`;
CREATE TABLE `im_channel` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `publishment_id` bigint(20) unsigned DEFAULT NULL,
  `site_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `description` text COMMENT '描述',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='频道';

-- ----------------------------
-- Records of im_channel
-- ----------------------------
INSERT INTO `im_channel` VALUES ('1', '10086', '1', '明星详情', null, '2022-09-16 12:26:22', '2022-09-16 12:26:22', null, 'NORMAL');
INSERT INTO `im_channel` VALUES ('2', '10087', '2', '明星详情', null, '2022-09-16 12:28:05', '2022-09-16 12:28:27', null, 'NORMAL');
INSERT INTO `im_channel` VALUES ('3', '10088', '3', '明星详情', null, '2022-09-24 12:50:32', '2022-09-24 12:50:32', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_creative`
-- ----------------------------
DROP TABLE IF EXISTS `im_creative`;
CREATE TABLE `im_creative` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `advertisement_id` bigint(20) unsigned DEFAULT '0',
  `program_id` bigint(20) unsigned DEFAULT '0',
  `element_id` bigint(20) unsigned DEFAULT '0',
  `size_id` bigint(20) unsigned DEFAULT '0',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `location` varchar(255) DEFAULT NULL COMMENT '地址',
  `image` varchar(255) DEFAULT NULL COMMENT '物料',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='广告创意';

-- ----------------------------
-- Records of im_creative
-- ----------------------------
INSERT INTO `im_creative` VALUES ('1', '10086', '5', '3', '21', '980x120', 'http://v2.me.yunduanchongqing.com/?980x120', 'http://adwords.me.yunduanchongqing.com/upload/20220926/7ac5178e258dcbfe092b84c7448ad3e2.png', '2022-09-24 13:13:31', '2022-09-26 13:58:45', null, 'NORMAL');
INSERT INTO `im_creative` VALUES ('2', '10086', '5', '3', '21', '980x120-2', 'http://v2.me.yunduanchongqing.com/?980x120-2', 'http://adwords.me.yunduanchongqing.com/upload/20220926/e0cb9b1f404cae553c9247f6286c896a.png', '2022-09-24 13:14:21', '2022-09-26 13:57:37', null, 'NORMAL');
INSERT INTO `im_creative` VALUES ('3', '10086', '5', '3', '9', '300x250', 'http://v2.me.yunduanchongqing.com/?300x250', 'http://adwords.me.yunduanchongqing.com/upload/20220926/724a54c49db3d62989754539e08984e5.png', '2022-09-24 13:15:14', '2022-09-26 13:56:38', null, 'NORMAL');
INSERT INTO `im_creative` VALUES ('4', '10086', '5', '6', '9', '300x250-2', 'http://v2.me.yunduanchongqing.com/?300x250-2', 'http://adwords.me.yunduanchongqing.com/upload/20220926/addfdf3a860c593b8f763c441d73eab0.png', '2022-09-24 13:16:02', '2022-09-26 13:55:02', null, 'NORMAL');
INSERT INTO `im_creative` VALUES ('5', '10086', '5', '3', '12', '120x600', 'http://v2.me.yunduanchongqing.com/?120x600', 'http://adwords.me.yunduanchongqing.com/upload/20220926/1880d82f3e569058fcb89b13a9d11880.png', '2022-09-24 13:16:47', '2022-09-26 13:54:47', null, 'NORMAL');
INSERT INTO `im_creative` VALUES ('6', '10086', '5', '6', '21', '980x120-3', 'http://v2.me.yunduanchongqing.com/?980x120-3', 'http://adwords.me.yunduanchongqing.com/upload/20220926/6762abafab0691753bee4d018bda192d.png', '2022-09-24 14:38:26', '2022-09-26 13:52:58', null, 'NORMAL');
INSERT INTO `im_creative` VALUES ('7', '10086', '5', '3', '10', '336x280', 'http://v2.me.yunduanchongqing.com/label/about/', 'http://adwords.me.yunduanchongqing.com/upload/20220926/74a6caa680569c9caf0ca6c84fa67fbe.png', '2022-09-24 17:51:17', '2022-09-26 13:52:47', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_element`
-- ----------------------------
DROP TABLE IF EXISTS `im_element`;
CREATE TABLE `im_element` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `advertisement_id` bigint(20) unsigned DEFAULT '0',
  `program_id` bigint(20) unsigned DEFAULT '0',
  `release_begin` datetime DEFAULT NULL COMMENT '投放日期',
  `release_finish` datetime DEFAULT NULL COMMENT '投放日期',
  `period_begin` time DEFAULT NULL COMMENT '投放时段',
  `period_finish` time DEFAULT NULL COMMENT '投放时段',
  `type` enum('CPC','CPM','CPA','CPS') DEFAULT 'CPC' COMMENT '出价方式{CPC}{CPM}{CPA}{CPS}',
  `rate` bigint(20) unsigned DEFAULT '0' COMMENT '出价',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='广告单元';

-- ----------------------------
-- Records of im_element
-- ----------------------------
INSERT INTO `im_element` VALUES ('1', '1', '1', '2022-10-01 00:00:00', '2122-12-31 23:55:00', '00:00:00', '23:59:59', 'CPC', '250', '默认推广单元', '2022-09-21 15:24:17', '2022-09-21 15:24:17', null, 'NORMAL');
INSERT INTO `im_element` VALUES ('2', '2', '3', '2022-09-15 00:00:00', '2122-12-31 23:55:00', '00:00:00', '23:59:59', 'CPC', '1600', '默认推广单元', '2022-09-21 16:10:32', '2022-09-21 16:13:11', null, 'NORMAL');
INSERT INTO `im_element` VALUES ('3', '10086', '5', '2022-09-15 00:00:00', '2122-12-31 23:55:00', '00:00:00', '23:59:59', 'CPC', '5000', '默认推广单元', '2022-09-24 13:08:28', '2022-09-24 13:08:28', null, 'NORMAL');
INSERT INTO `im_element` VALUES ('4', '10087', '7', '2022-09-15 00:00:00', '2122-12-31 23:55:00', '00:00:00', '23:59:59', 'CPC', '2000', '默认推广单元', '2022-09-24 14:37:34', '2022-09-24 14:37:34', null, 'NORMAL');
INSERT INTO `im_element` VALUES ('5', '10088', '9', '2022-09-15 00:00:00', '2122-12-31 23:55:00', '00:00:00', '23:59:59', 'CPC', '2000', '默认推广单元', '2022-09-24 14:37:34', '2022-09-24 14:37:34', null, 'NORMAL');
INSERT INTO `im_element` VALUES ('6', '10086', '5', '2022-09-15 00:00:00', '2122-12-31 23:55:00', '00:00:00', '23:59:59', 'CPM', '2000', '自定义推广单元', '2022-09-24 14:37:34', '2022-09-24 14:37:34', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_industry`
-- ----------------------------
DROP TABLE IF EXISTS `im_industry`;
CREATE TABLE `im_industry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '名称',
  `sorting` int(11) unsigned DEFAULT '1' COMMENT '排序',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='行业';

-- ----------------------------
-- Records of im_industry
-- ----------------------------
INSERT INTO `im_industry` VALUES ('1', '综合门户', '1', '2022-09-15 16:28:23', '2022-09-15 16:28:23', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('2', '生活服务', '1', '2022-09-15 16:28:33', '2022-09-15 16:28:33', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('3', '影视动漫', '1', '2022-09-15 16:28:39', '2022-09-15 16:28:39', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('4', '新闻资讯', '1', '2022-09-15 16:28:46', '2022-09-15 16:28:46', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('5', '工具服务', '1', '2022-09-15 16:28:51', '2022-09-15 16:28:51', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('6', '网络购物', '1', '2022-09-15 16:28:56', '2022-09-15 16:28:56', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('7', '社交平台', '1', '2022-09-15 16:28:57', '2022-09-15 16:29:04', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('8', '游戏', '1', '2022-09-15 16:29:25', '2022-09-15 16:29:25', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('9', '音乐', '1', '2022-09-15 16:29:34', '2022-09-15 16:29:34', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('10', '小说', '1', '2022-09-15 16:29:43', '2022-09-15 16:29:43', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('11', '医疗', '1', '2022-09-15 16:29:50', '2022-09-15 16:29:50', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('12', '金融', '1', '2022-09-15 16:30:00', '2022-09-15 16:30:00', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('13', '旅游', '1', '2022-09-15 16:30:06', '2022-09-15 16:30:06', null, 'NORMAL');
INSERT INTO `im_industry` VALUES ('14', '其它', '1', '2022-09-15 16:30:20', '2022-09-15 16:34:12', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_manager`
-- ----------------------------
DROP TABLE IF EXISTS `im_manager`;
CREATE TABLE `im_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色编号',
  `role_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '角色名称',
  `usernick` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户名',
  `userpass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `usersalt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '加盐',
  `register_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '注册地址',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `last_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录地址',
  `last_time` datetime DEFAULT NULL COMMENT '登录时间',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') COLLATE utf8mb4_unicode_ci DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `username` (`username`(191)) USING BTREE,
  KEY `delete_time` (`delete_time`) USING BTREE,
  KEY `state` (`state`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='后台账户';

-- ----------------------------
-- Records of im_manager
-- ----------------------------
INSERT INTO `im_manager` VALUES ('1', '1', '超级管理组', '创始人', 'founder', '0957ca902212979ffd4c4927f0b45def', 'Y181VY', '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-09-26 14:59:33', '2022-01-01 18:00:00', '2022-09-26 14:59:33', null, 'NORMAL');
INSERT INTO `im_manager` VALUES ('2', '2', '管理员', '管理员', 'admin', 'fe711720669a634139a1c650be70a4ae', 'VOKYQR', '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-08-23 23:24:18', '2022-01-01 18:00:00', '2022-08-23 23:24:18', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_material`
-- ----------------------------
DROP TABLE IF EXISTS `im_material`;
CREATE TABLE `im_material` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `publishment_id` bigint(20) unsigned DEFAULT '0',
  `size_id` bigint(20) unsigned DEFAULT '0',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `device` enum('PC','MOBILE') DEFAULT 'PC' COMMENT '设备{PC:电脑}{MOBILE:移动端}',
  `location` varchar(255) DEFAULT NULL COMMENT '地址',
  `image` varchar(255) DEFAULT NULL COMMENT '物料',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COMMENT='广告物料';

-- ----------------------------
-- Records of im_material
-- ----------------------------
INSERT INTO `im_material` VALUES ('1', '1', '5', '200x200-g', 'PC', 'http://v2.me.yunduanchongqing.com/?200x200-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/819dc5ba5c23d7aa13c0a103d3ba522f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('2', '1', '6', '240x400-g', 'PC', 'http://v2.me.yunduanchongqing.com/?240x400-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/da0fcef00186d64953cfe73e116b79fd.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('3', '1', '7', '250x250-g', 'PC', 'http://v2.me.yunduanchongqing.com/?250x250-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/b437c409a495ee543fb5b5a7d89cb4ec.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('4', '1', '8', '250x360-g', 'PC', 'http://v2.me.yunduanchongqing.com/?250x360-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/7bd78394da3599b8d383215d3a5cf20d.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('5', '1', '9', '300x250-g', 'PC', 'http://v2.me.yunduanchongqing.com/?300x250-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/5d2a62a4f311108b16e486375788d04a.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('6', '1', '10', '336x280-g', 'PC', 'http://v2.me.yunduanchongqing.com/?336x280-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/7e6cd33342968c56284e59417be26caf.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('7', '1', '11', '580x400-g', 'PC', 'http://v2.me.yunduanchongqing.com/?580x400-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/aee2d6bcb1855b839ad82f1c23802fb3.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('8', '1', '12', '120x600-g', 'PC', 'http://v2.me.yunduanchongqing.com/?120x600-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/78405de9be022c33255c0389a2da1cef.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('9', '1', '13', '160x600-g', 'PC', 'http://v2.me.yunduanchongqing.com/?160x600-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/cd890914dc0b7e2890a95ffd58911ca7.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('10', '1', '14', '300x600-g', 'PC', 'http://v2.me.yunduanchongqing.com/?300x600-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/c0c2a17bf9dbae6c0fabfc85db3b156f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('11', '1', '15', '300x1050-g', 'PC', 'http://v2.me.yunduanchongqing.com/?300x1050-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/a6d4e28908d4b8099302ff260ece2593.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('12', '1', '16', '486x60-g', 'PC', 'http://v2.me.yunduanchongqing.com/?486x60-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/bdbbeec09fddbf467988aac8ba6abadc.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('13', '1', '17', '728x90-g', 'PC', 'http://v2.me.yunduanchongqing.com/?728x90-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/a7ea821541eb7f572f804bddf98636a9.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('14', '1', '18', '930x180-g', 'PC', 'http://v2.me.yunduanchongqing.com/?930x180-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/2f5e8c0ab0f22535ce8f4c4db3c94fb1.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('15', '1', '19', '970x90-g', 'PC', 'http://v2.me.yunduanchongqing.com/?970x90-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/92c67dcc62abe42152257dc1fd60f375.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('16', '1', '20', '970x250-g', 'PC', 'http://v2.me.yunduanchongqing.com/?970x250-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/052d34c36ab784e32033cf99c6046bc5.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('17', '1', '21', '980x120-g', 'PC', 'http://v2.me.yunduanchongqing.com/?980x120-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/b1023b4548c90fdc01b480a21eaf2aa2.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('18', '1', '22', '300x50-g', 'PC', 'http://v2.me.yunduanchongqing.com/?300x50-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/b4a584b7793f8a1f3e8ab6fa20481233.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('19', '1', '23', '320x50-g', 'PC', 'http://v2.me.yunduanchongqing.com/?320x50-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/cec241c436250b4c62e52e5a65cad755.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('20', '1', '24', '320x100-g', 'PC', 'http://v2.me.yunduanchongqing.com/?320x100-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/00d1e8293eb9d979e7066cb60625396f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('21', '1', '9', '300x250-g', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?300x250-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/5d2a62a4f311108b16e486375788d04a.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('22', '1', '22', '300x50-g', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?300x50-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/b4a584b7793f8a1f3e8ab6fa20481233.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('23', '1', '23', '320x50-g', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?320x50-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/cec241c436250b4c62e52e5a65cad755.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('24', '1', '24', '320x100-g', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?320x100-g', 'http://adwords.me.yunduanchongqing.com/upload/20220925/00d1e8293eb9d979e7066cb60625396f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('25', '2', '5', '200x200-h', 'PC', 'http://v2.me.yunduanchongqing.com/?200x200-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/819dc5ba5c23d7aa13c0a103d3ba522f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('26', '2', '6', '240x400-h', 'PC', 'http://v2.me.yunduanchongqing.com/?240x400-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/da0fcef00186d64953cfe73e116b79fd.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('27', '2', '7', '250x250-h', 'PC', 'http://v2.me.yunduanchongqing.com/?250x250-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/b437c409a495ee543fb5b5a7d89cb4ec.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('28', '2', '8', '250x360-h', 'PC', 'http://v2.me.yunduanchongqing.com/?250x360-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/7bd78394da3599b8d383215d3a5cf20d.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('29', '2', '9', '300x250-h', 'PC', 'http://v2.me.yunduanchongqing.com/?300x250-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/5d2a62a4f311108b16e486375788d04a.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('30', '2', '10', '336x280-h', 'PC', 'http://v2.me.yunduanchongqing.com/?336x280-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/7e6cd33342968c56284e59417be26caf.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('31', '2', '11', '580x400-h', 'PC', 'http://v2.me.yunduanchongqing.com/?580x400-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/aee2d6bcb1855b839ad82f1c23802fb3.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('32', '2', '12', '120x600-h', 'PC', 'http://v2.me.yunduanchongqing.com/?120x600-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/78405de9be022c33255c0389a2da1cef.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('33', '2', '13', '160x600-h', 'PC', 'http://v2.me.yunduanchongqing.com/?160x600-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/cd890914dc0b7e2890a95ffd58911ca7.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('34', '2', '14', '300x600-h', 'PC', 'http://v2.me.yunduanchongqing.com/?300x600-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/c0c2a17bf9dbae6c0fabfc85db3b156f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('35', '2', '15', '300x1050-h', 'PC', 'http://v2.me.yunduanchongqing.com/?300x1050-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/a6d4e28908d4b8099302ff260ece2593.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('36', '2', '16', '486x60-h', 'PC', 'http://v2.me.yunduanchongqing.com/?486x60-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/bdbbeec09fddbf467988aac8ba6abadc.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('37', '2', '17', '728x90-h', 'PC', 'http://v2.me.yunduanchongqing.com/?728x90-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/a7ea821541eb7f572f804bddf98636a9.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('38', '2', '18', '930x180-h', 'PC', 'http://v2.me.yunduanchongqing.com/?930x180-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/2f5e8c0ab0f22535ce8f4c4db3c94fb1.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('39', '2', '19', '970x90-h', 'PC', 'http://v2.me.yunduanchongqing.com/?970x90-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/92c67dcc62abe42152257dc1fd60f375.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('40', '2', '20', '970x250-h', 'PC', 'http://v2.me.yunduanchongqing.com/?970x250-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/052d34c36ab784e32033cf99c6046bc5.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('41', '2', '21', '980x120-h', 'PC', 'http://v2.me.yunduanchongqing.com/?980x120-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/b1023b4548c90fdc01b480a21eaf2aa2.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('42', '2', '22', '300x50-h', 'PC', 'http://v2.me.yunduanchongqing.com/?300x50-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/b4a584b7793f8a1f3e8ab6fa20481233.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('43', '2', '23', '320x50-h', 'PC', 'http://v2.me.yunduanchongqing.com/?320x50-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/cec241c436250b4c62e52e5a65cad755.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('44', '2', '24', '320x100-h', 'PC', 'http://v2.me.yunduanchongqing.com/?320x100-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/00d1e8293eb9d979e7066cb60625396f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('45', '2', '9', '300x250-h', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?300x250-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/5d2a62a4f311108b16e486375788d04a.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('46', '2', '22', '300x50-h', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?300x50-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/b4a584b7793f8a1f3e8ab6fa20481233.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('47', '2', '23', '320x50-h', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?320x50-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/cec241c436250b4c62e52e5a65cad755.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');
INSERT INTO `im_material` VALUES ('48', '2', '24', '320x100-h', 'MOBILE', 'http://v2.me.yunduanchongqing.com/?320x100-h', 'http://adwords.me.yunduanchongqing.com/upload/20220926/00d1e8293eb9d979e7066cb60625396f.png', '2022-09-26 12:02:28', '2022-09-26 12:02:28', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_module`
-- ----------------------------
DROP TABLE IF EXISTS `im_module`;
CREATE TABLE `im_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标识符',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模块名称',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `sorting` int(11) unsigned DEFAULT '1' COMMENT '排序',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') COLLATE utf8mb4_unicode_ci DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`),
  KEY `namespace` (`namespace`(191),`state`) USING BTREE,
  KEY `sorting` (`sorting`,`state`) USING BTREE,
  KEY `delete_time` (`delete_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='模块';

-- ----------------------------
-- Records of im_module
-- ----------------------------
INSERT INTO `im_module` VALUES ('1', 'BACKEND', '后台模块', null, '1', '2022-08-23 16:32:56', '2022-08-23 16:32:56', null, 'NORMAL');
INSERT INTO `im_module` VALUES ('2', 'ADVERTISEMENT', '广告主平台', null, '1', '2022-09-15 17:51:46', '2022-09-15 17:51:46', null, 'NORMAL');
INSERT INTO `im_module` VALUES ('3', 'PUBLISHMENT', '流量主平台', null, '1', '2022-09-15 17:52:05', '2022-09-15 17:52:05', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_policy`
-- ----------------------------
DROP TABLE IF EXISTS `im_policy`;
CREATE TABLE `im_policy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_namespace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标识符',
  `module_id` int(11) unsigned DEFAULT '0' COMMENT '所属模块',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '父级编号',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `type` enum('NAVIGATION','PAGE','NODE') COLLATE utf8mb4_unicode_ci DEFAULT 'NODE' COMMENT '菜单{NAVIGATION:菜单}{PAGE:页面}{NODE:节点}',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图标',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `statement` text COLLATE utf8mb4_unicode_ci COMMENT '授权语句',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `sorting` int(11) unsigned DEFAULT '1' COMMENT '排序',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') COLLATE utf8mb4_unicode_ci DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`),
  KEY `module_namespace` (`module_namespace`(191),`state`) USING BTREE,
  KEY `module_id` (`module_id`,`state`) USING BTREE,
  KEY `pid` (`pid`,`state`) USING BTREE,
  KEY `navigation` (`type`,`state`) USING BTREE,
  KEY `sorting` (`sorting`,`state`) USING BTREE,
  KEY `delete_time` (`delete_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='策略';

-- ----------------------------
-- Records of im_policy
-- ----------------------------
INSERT INTO `im_policy` VALUES ('1', 'BACKEND', '1', '0', '系统管理', 'NAVIGATION', 'icon-settings', null, null, null, '1', '2022-08-23 17:27:26', '2022-08-23 18:01:11', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('2', 'BACKEND', '1', '0', '模块管理', 'NAVIGATION', 'icon-layers', null, null, null, '1', '2022-08-23 17:27:35', '2022-08-23 17:27:35', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('3', 'BACKEND', '1', '0', '策略管理', 'NAVIGATION', 'icon-badge', null, null, null, '1', '2022-08-23 17:27:54', '2022-08-23 17:27:54', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('4', 'BACKEND', '1', '0', '角色管理', 'NAVIGATION', 'icon-grid', null, null, null, '1', '2022-08-23 17:27:46', '2022-08-23 17:27:46', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('5', 'BACKEND', '1', '0', '账户管理', 'NAVIGATION', 'icon-people', null, null, null, '1', '2022-08-23 17:28:02', '2022-08-23 17:28:02', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('110', 'BACKEND', '1', '2', '模块管理', 'PAGE', 'icon-settings', 'backend.module.list', 'backend.module.list', null, '1', '2022-08-23 17:29:09', '2022-08-23 17:29:09', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('111', 'BACKEND', '1', '110', '新增模块', 'NODE', 'icon-settings', 'backend.module.create', 'backend.module.create,backend.module.store', null, '1', '2022-08-23 17:29:56', '2022-08-23 17:29:56', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('112', 'BACKEND', '1', '110', '编辑模块', 'NODE', 'icon-settings', 'backend.module.edit', 'backend.module.edit,backend.module.update', null, '1', '2022-08-23 17:30:14', '2022-08-23 17:30:14', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('113', 'BACKEND', '1', '110', '删除模块', 'NODE', 'icon-settings', 'backend.module.destroy', 'backend.module.destroy', null, '1', '2022-08-23 17:31:09', '2022-08-23 17:31:09', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('114', 'BACKEND', '1', '3', '策略管理', 'PAGE', 'icon-settings', 'backend.policy.list', 'backend.policy.list', null, '1', '2022-08-23 17:32:38', '2022-08-23 17:32:38', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('115', 'BACKEND', '1', '114', '新增策略', 'NODE', 'icon-settings', 'backend.policy.create', 'backend.policy.create,backend.policy.store', null, '1', '2022-08-23 17:33:01', '2022-08-23 17:33:01', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('116', 'BACKEND', '1', '114', '编辑策略', 'NODE', 'icon-settings', 'backend.policy.edit', 'backend.policy.edit,backend.policy.update', null, '1', '2022-08-23 17:33:18', '2022-08-23 17:33:18', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('117', 'BACKEND', '1', '114', '删除策略', 'NODE', 'icon-settings', 'backend.policy.destroy', 'backend.policy.destroy', null, '1', '2022-08-23 17:33:31', '2022-08-23 17:33:31', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('118', 'BACKEND', '1', '4', '角色管理', 'PAGE', 'icon-settings', 'backend.role.list', 'backend.role.list', null, '1', '2022-08-23 17:34:56', '2022-08-23 17:34:56', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('119', 'BACKEND', '1', '118', '新增角色', 'NODE', 'icon-settings', 'backend.role.create', 'backend.role.create,backend.role.store', null, '1', '2022-08-23 17:35:18', '2022-08-23 17:35:18', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('120', 'BACKEND', '1', '118', '编辑角色', 'NODE', 'icon-settings', 'backend.role.edit', 'backend.role.edit,backend.role.update', null, '1', '2022-08-23 17:35:36', '2022-08-23 17:35:36', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('121', 'BACKEND', '1', '118', '删除角色', 'NODE', 'icon-settings', 'backend.role.destroy', 'backend.role.destroy', null, '1', '2022-08-23 17:35:51', '2022-08-23 17:35:51', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('122', 'BACKEND', '1', '5', '账户管理', 'PAGE', 'icon-settings', 'backend.manager.list', 'backend.manager.list', null, '1', '2022-08-23 17:36:20', '2022-08-23 17:36:20', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('123', 'BACKEND', '1', '122', '新增账户', 'NODE', 'icon-settings', 'backend.manager.create', 'backend.manager.create,backend.manager.store', null, '1', '2022-08-23 17:36:35', '2022-08-23 17:36:35', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('124', 'BACKEND', '1', '122', '编辑账户', 'NODE', 'icon-settings', 'backend.manager.edit', 'backend.manager.edit,backend.manager.update', null, '1', '2022-08-23 17:36:52', '2022-08-23 17:36:52', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('125', 'BACKEND', '1', '122', '删除账户', 'NODE', 'icon-settings', 'backend.manager.destroy', 'backend.manager.destroy', null, '1', '2022-08-23 17:37:09', '2022-08-23 17:37:09', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('126', 'BACKEND', '1', '122', '重置密码', 'NODE', 'icon-settings', 'backend.manager.password', 'backend.manager.password', null, '1', '2022-08-23 18:19:58', '2022-08-23 18:19:58', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('127', 'BACKEND', '1', '0', '行业管理', 'NAVIGATION', 'icon-settings', null, '', null, '1', '2022-09-15 13:55:48', '2022-09-15 13:55:48', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('128', 'BACKEND', '1', '127', '行业管理', 'PAGE', 'icon-settings', 'backend.industry.list', 'backend.industry.list', null, '1', '2022-09-15 13:56:09', '2022-09-15 13:56:09', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('129', 'BACKEND', '1', '128', '新增行业', 'NODE', 'icon-settings', 'backend.industry.create', 'backend.industry.create,backend.industry.store', null, '1', '2022-09-15 13:56:27', '2022-09-15 13:56:27', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('130', 'BACKEND', '1', '128', '编辑行业', 'NODE', 'icon-settings', 'backend.industry.edit', 'backend.industry.edit,backend.industry.update', null, '1', '2022-09-15 13:56:44', '2022-09-15 13:56:44', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('131', 'BACKEND', '1', '128', '删除行业', 'NODE', 'icon-settings', 'backend.industry.destroy', 'backend.industry.destroy', null, '1', '2022-09-15 13:57:01', '2022-09-15 13:57:01', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('132', 'PUBLISHMENT', '3', '0', '站点管理', 'NAVIGATION', 'icon-settings', null, '', null, '1', '2022-09-15 20:37:35', '2022-09-15 20:37:35', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('133', 'PUBLISHMENT', '3', '132', '站点管理', 'PAGE', 'icon-settings', 'publishment.site.list', 'publishment.site.list', null, '1', '2022-09-15 20:38:03', '2022-09-15 20:38:25', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('134', 'PUBLISHMENT', '3', '133', '新增站点', 'NODE', 'icon-settings', 'publishment.site.create', 'publishment.site.create,publishment.site.store,publishment.site.verify,publishment.site.verification,publishment.site.download', null, '1', '2022-09-15 20:38:44', '2022-09-15 22:52:24', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('135', 'PUBLISHMENT', '3', '133', '编辑站点', 'NODE', 'icon-settings', 'publishment.site.edit', 'publishment.site.edit,publishment.site.update', null, '1', '2022-09-15 20:38:59', '2022-09-15 20:38:59', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('136', 'PUBLISHMENT', '3', '133', '删除站点', 'NODE', 'icon-settings', 'publishment.site.destroy', 'publishment.site.destroy', null, '1', '2022-09-15 20:39:14', '2022-09-15 20:39:14', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('137', 'PUBLISHMENT', '3', '132', '频道管理', 'PAGE', 'icon-settings', 'publishment.channel.list', 'publishment.channel.list', null, '1', '2022-09-16 12:08:38', '2022-09-16 12:08:38', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('138', 'PUBLISHMENT', '3', '137', '新增频道', 'NODE', 'icon-settings', 'publishment.channel.create', 'publishment.channel.create,publishment.channel.store', null, '1', '2022-09-16 12:08:57', '2022-09-16 12:08:57', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('139', 'PUBLISHMENT', '3', '137', '编辑频道', 'NODE', 'icon-settings', 'publishment.channel.edit', 'publishment.channel.edit,publishment.channel.update', null, '1', '2022-09-16 12:09:15', '2022-09-16 12:09:15', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('140', 'PUBLISHMENT', '3', '137', '删除频道', 'NODE', 'icon-settings', 'publishment.channel.destroy', 'publishment.channel.destroy', null, '1', '2022-09-16 12:09:30', '2022-09-16 12:09:30', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('141', 'BACKEND', '1', '127', '广告尺寸', 'PAGE', 'icon-settings', 'backend.size.list', 'backend.size.list', null, '1', '2022-09-17 14:40:24', '2022-09-17 14:40:24', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('142', 'BACKEND', '1', '141', '新增广告尺寸', 'NODE', 'icon-settings', 'backend.size.create', 'backend.size.create,backend.size.store', null, '1', '2022-09-17 14:40:43', '2022-09-17 14:40:43', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('143', 'BACKEND', '1', '141', '编辑广告尺寸', 'NODE', 'icon-settings', 'backend.size.edit', 'backend.size.edit,backend.size.update', null, '1', '2022-09-17 14:40:58', '2022-09-17 14:40:58', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('144', 'BACKEND', '1', '141', '删除广告尺寸', 'NODE', 'icon-settings', 'backend.size.destroy', 'backend.size.destroy', null, '1', '2022-09-17 14:41:14', '2022-09-17 14:41:14', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('145', 'PUBLISHMENT', '3', '0', '广告位管理', 'NAVIGATION', 'icon-settings', null, '', null, '1', '2022-09-18 22:35:36', '2022-09-18 22:35:36', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('146', 'PUBLISHMENT', '3', '145', '广告位管理', 'PAGE', 'icon-settings', 'publishment.adsense.list', 'publishment.adsense.list', null, '1', '2022-09-18 22:36:04', '2022-09-18 22:36:04', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('147', 'PUBLISHMENT', '3', '146', '新增广告位', 'NODE', 'icon-settings', 'publishment.adsense.create', 'publishment.adsense.create,publishment.adsense.store', null, '1', '2022-09-18 22:36:20', '2022-09-18 22:36:20', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('148', 'PUBLISHMENT', '3', '146', '编辑广告位', 'NODE', 'icon-settings', 'publishment.adsense.edit', 'publishment.adsense.edit,publishment.adsense.update', null, '1', '2022-09-18 22:36:36', '2022-09-18 22:36:36', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('149', 'PUBLISHMENT', '3', '146', '删除广告位', 'NODE', 'icon-settings', 'publishment.adsense.destroy', 'publishment.adsense.destroy', null, '1', '2022-09-18 22:36:50', '2022-09-18 22:36:50', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('150', 'ADVERTISEMENT', '2', '0', '推广', 'NAVIGATION', 'icon-settings', null, '', null, '1', '2022-09-20 16:20:48', '2022-09-20 16:20:48', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('151', 'ADVERTISEMENT', '2', '150', '广告计划', 'PAGE', 'icon-settings', 'advertisement.program.list', 'advertisement.program.list', null, '1', '2022-09-20 16:22:11', '2022-09-20 16:22:11', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('152', 'ADVERTISEMENT', '2', '151', '新建广告计划', 'NODE', 'icon-settings', 'advertisement.program.create', 'advertisement.program.create,advertisement.program.store', null, '1', '2022-09-20 16:22:30', '2022-09-20 16:22:30', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('153', 'ADVERTISEMENT', '2', '151', '编辑广告计划', 'NODE', 'icon-settings', 'advertisement.program.edit', 'advertisement.program.edit,advertisement.program.update', null, '1', '2022-09-20 16:22:51', '2022-09-20 16:22:51', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('154', 'ADVERTISEMENT', '2', '151', '删除广告计划', 'NODE', 'icon-settings', 'advertisement.program.destroy', 'advertisement.program.destroy', null, '1', '2022-09-20 16:23:10', '2022-09-20 16:23:10', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('155', 'ADVERTISEMENT', '2', '150', '广告单元', 'PAGE', 'icon-settings', 'advertisement.element.list', 'advertisement.element.list', null, '1', '2022-09-20 16:23:30', '2022-09-20 16:23:30', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('156', 'ADVERTISEMENT', '2', '155', '新增广告单元', 'NODE', 'icon-settings', 'advertisement.element.create', 'advertisement.element.create,advertisement.element.store', null, '1', '2022-09-20 16:23:51', '2022-09-20 16:23:51', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('157', 'ADVERTISEMENT', '2', '155', '编辑广告单元', 'NODE', 'icon-settings', 'advertisement.element.edit', 'advertisement.element.edit,advertisement.element.update', null, '1', '2022-09-20 16:24:15', '2022-09-20 16:24:15', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('158', 'ADVERTISEMENT', '2', '155', '删除广告单元', 'NODE', 'icon-settings', 'advertisement.element.destroy', 'advertisement.element.destroy', null, '1', '2022-09-20 16:24:33', '2022-09-20 16:24:33', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('159', 'ADVERTISEMENT', '2', '150', '广告创意', 'PAGE', 'icon-settings', 'advertisement.creative.list', 'advertisement.creative.list', null, '1', '2022-09-20 16:25:16', '2022-09-20 16:25:16', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('160', 'ADVERTISEMENT', '2', '159', '新增广告创意', 'NODE', 'icon-settings', 'advertisement.creative.create', 'advertisement.creative.create,advertisement.creative.store', null, '1', '2022-09-20 16:25:34', '2022-09-20 16:25:34', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('161', 'ADVERTISEMENT', '2', '159', '编辑广告创意', 'NODE', 'icon-settings', 'advertisement.creative.edit', 'advertisement.creative.edit,advertisement.creative.update', null, '1', '2022-09-20 16:25:50', '2022-09-20 16:25:50', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('162', 'ADVERTISEMENT', '2', '159', '删除广告创意', 'NODE', 'icon-settings', 'advertisement.creative.destroy', 'advertisement.creative.destroy', null, '1', '2022-09-20 16:26:06', '2022-09-20 16:26:06', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('163', 'PUBLISHMENT', '3', '0', '换量广告', 'NAVIGATION', 'icon-settings', null, '', null, '1', '2022-09-25 14:55:05', '2022-09-25 14:55:05', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('164', 'PUBLISHMENT', '3', '163', '广告物料', 'PAGE', 'icon-settings', 'publishment.material.list', 'publishment.material.list', null, '1', '2022-09-25 14:55:27', '2022-09-25 14:55:27', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('165', 'PUBLISHMENT', '3', '164', '新增广告物料', 'NODE', 'icon-settings', 'publishment.material.create', 'publishment.material.create,publishment.material.store', null, '1', '2022-09-25 14:55:44', '2022-09-25 14:55:44', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('166', 'PUBLISHMENT', '3', '164', '编辑广告物料', 'NODE', 'icon-settings', 'publishment.material.edit', 'publishment.material.edit,publishment.material.update', null, '1', '2022-09-25 14:56:03', '2022-09-25 14:56:03', null, 'NORMAL');
INSERT INTO `im_policy` VALUES ('167', 'PUBLISHMENT', '3', '164', '删除广告物料', 'NODE', 'icon-settings', 'publishment.material.destroy', 'publishment.material.destroy', null, '1', '2022-09-25 14:56:19', '2022-09-25 14:56:19', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_program`
-- ----------------------------
DROP TABLE IF EXISTS `im_program`;
CREATE TABLE `im_program` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `advertisement_id` bigint(20) unsigned DEFAULT '0',
  `device` enum('PC','MOBILE') DEFAULT 'PC' COMMENT '设备{PC:电脑}{MOBILE:移动端}',
  `limit` bigint(20) unsigned DEFAULT '0' COMMENT '日限额',
  `charge` bigint(20) unsigned DEFAULT '0' COMMENT '当日消费',
  `expire` date DEFAULT NULL COMMENT '日期',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='广告计划';

-- ----------------------------
-- Records of im_program
-- ----------------------------
INSERT INTO `im_program` VALUES ('1', '1', 'PC', '100000', '0', null, '电脑端推广计划', '2022-09-21 12:07:07', '2022-09-21 18:13:23', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('2', '1', 'MOBILE', '50000', '0', null, '移动端推广计划', '2022-09-21 12:08:12', '2022-09-21 12:19:26', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('3', '2', 'PC', '100000', '0', null, '电脑端推广计划', '2022-09-21 12:07:07', '2022-09-21 18:13:23', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('4', '2', 'MOBILE', '50000', '0', null, '移动端推广计划', '2022-09-21 12:08:12', '2022-09-21 12:19:26', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('5', '10086', 'PC', '100000', '0', null, '电脑端推广计划', '2022-09-21 12:07:07', '2022-09-21 18:13:23', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('6', '10086', 'MOBILE', '50000', '0', null, '移动端推广计划', '2022-09-21 12:08:12', '2022-09-21 12:19:26', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('7', '10087', 'PC', '100000', '0', null, '电脑端推广计划', '2022-09-21 12:07:07', '2022-09-21 18:13:23', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('8', '10087', 'MOBILE', '50000', '0', null, '移动端推广计划', '2022-09-21 12:08:12', '2022-09-21 12:19:26', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('9', '10088', 'PC', '100000', '0', null, '电脑端推广计划', '2022-09-21 12:07:07', '2022-09-21 18:13:23', null, 'NORMAL');
INSERT INTO `im_program` VALUES ('10', '10088', 'MOBILE', '50000', '0', null, '移动端推广计划', '2022-09-21 12:08:12', '2022-09-21 12:19:26', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_publisher`
-- ----------------------------
DROP TABLE IF EXISTS `im_publisher`;
CREATE TABLE `im_publisher` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `publishment_id` bigint(20) unsigned DEFAULT NULL,
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色编号',
  `role_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '角色名称',
  `usernick` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户名',
  `userpass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `usersalt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '加盐',
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `register_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '注册地址',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `last_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录地址',
  `last_time` datetime DEFAULT NULL COMMENT '登录时间',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') COLLATE utf8mb4_unicode_ci DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `username` (`username`(191)) USING BTREE,
  KEY `delete_time` (`delete_time`) USING BTREE,
  KEY `state` (`state`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='流量主账户';

-- ----------------------------
-- Records of im_publisher
-- ----------------------------
INSERT INTO `im_publisher` VALUES ('1', '1', '4', '管理员', 'admin', 'admin', 'bbad3eb5c50e5b21325f3a164cd5d29f', 'P0r9Ir', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-09-26 14:07:11', '2022-01-01 18:00:00', '2022-09-26 14:07:11', null, 'NORMAL');
INSERT INTO `im_publisher` VALUES ('2', '2', '4', '管理员', 'manager', 'manager', 'bbad3eb5c50e5b21325f3a164cd5d29f', 'P0r9Ir', null, '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-09-26 12:00:32', '2022-01-01 18:00:00', '2022-09-26 12:00:32', null, 'NORMAL');
INSERT INTO `im_publisher` VALUES ('3', '3', '4', '管理员', 'member', 'member', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-09-19 22:26:17', '127.0.0.1', '2022-09-19 22:39:52', '2022-09-19 22:26:17', '2022-09-19 22:39:52', null, 'NORMAL');
INSERT INTO `im_publisher` VALUES ('4', '10086', '4', '管理员', 'test1', 'test1', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-09-19 22:26:17', '127.0.0.1', '2022-09-26 14:07:22', '2022-09-19 22:26:17', '2022-09-26 14:07:22', null, 'NORMAL');
INSERT INTO `im_publisher` VALUES ('5', '10087', '4', '管理员', 'test2', 'test2', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-09-19 22:26:17', '127.0.0.1', '2022-09-19 22:26:17', '2022-09-19 22:26:17', '2022-09-19 22:26:17', null, 'NORMAL');
INSERT INTO `im_publisher` VALUES ('6', '10088', '4', '管理员', 'test3', 'test3', '77ddc03c676f3489190ed595d0bb12f6', '1KZcof', null, '127.0.0.1', '2022-09-19 22:26:17', '127.0.0.1', '2022-09-19 22:26:17', '2022-09-19 22:26:17', '2022-09-19 22:26:17', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_publishment`
-- ----------------------------
DROP TABLE IF EXISTS `im_publishment`;
CREATE TABLE `im_publishment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('COMPANY','PERSONAL') DEFAULT 'COMPANY' COMMENT '类型{COMPANY:公司}{PERSONAL:个人}',
  `name` varchar(255) DEFAULT NULL COMMENT '公司名称/真实姓名',
  `licence` varchar(255) DEFAULT NULL COMMENT '营业执照编号/身份证编号',
  `licence_image` varchar(255) DEFAULT NULL COMMENT '营业执照附件/身份证附件',
  `corporation` varchar(255) DEFAULT NULL COMMENT '联系人',
  `mobile` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `total` bigint(20) unsigned DEFAULT '0' COMMENT '总额',
  `balance` bigint(20) unsigned DEFAULT '0' COMMENT '余额',
  `frozen` bigint(20) unsigned DEFAULT '0' COMMENT '冻结金额',
  `weight` bigint(20) DEFAULT '0' COMMENT '换量权重',
  `audit` enum('INIT','WAIT','SUCCESS','FAILURE','STOP') DEFAULT 'INIT' COMMENT '审核状态{INIT:初始化}{WAIT:待审核}{SUCCESS:成功}{FAILURE:失败}{STOP:终止合作}',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10089 DEFAULT CHARSET=utf8mb4 COMMENT='流量主主体';

-- ----------------------------
-- Records of im_publishment
-- ----------------------------
INSERT INTO `im_publishment` VALUES ('1', 'PERSONAL', '公益', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', '公益', '13627685999', '0', '0', '0', '0', 'SUCCESS', null, '2022-09-20 00:00:52', null, 'NORMAL');
INSERT INTO `im_publishment` VALUES ('2', 'COMPANY', '换量', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', '换量', '13627685999', '0', '0', '0', '0', 'SUCCESS', '2022-09-19 22:26:17', '2022-09-19 23:54:00', null, 'NORMAL');
INSERT INTO `im_publishment` VALUES ('10086', 'COMPANY', 'test1', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', 'test1', '13627685999', '0', '0', '0', '0', 'SUCCESS', '2022-09-19 22:26:17', '2022-09-19 23:54:00', null, 'NORMAL');
INSERT INTO `im_publishment` VALUES ('10087', 'COMPANY', 'test2', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', 'test2', '13627685999', '0', '0', '0', '0', 'SUCCESS', '2022-09-19 22:26:17', '2022-09-19 23:54:00', null, 'NORMAL');
INSERT INTO `im_publishment` VALUES ('10088', 'COMPANY', 'test3', '91320200747189665N', 'https://via.placeholder.com/200x200/ac68e1/fff/200x200.png?text=200x200', 'test3', '13627685999', '0', '0', '0', '0', 'SUCCESS', '2022-09-19 22:26:17', '2022-09-19 23:54:00', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_role`
-- ----------------------------
DROP TABLE IF EXISTS `im_role`;
CREATE TABLE `im_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_namespace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标识符',
  `module_id` int(11) unsigned DEFAULT '0' COMMENT '所属模块',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '角色名称',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `policies` longtext COLLATE utf8mb4_unicode_ci COMMENT '策略集合',
  `sorting` int(11) unsigned DEFAULT '1' COMMENT '排序',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') COLLATE utf8mb4_unicode_ci DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`),
  KEY `module_namespace` (`module_namespace`(191),`state`) USING BTREE,
  KEY `module_id` (`module_id`,`state`) USING BTREE,
  KEY `sorting` (`sorting`,`state`) USING BTREE,
  KEY `delete_time` (`delete_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色';

-- ----------------------------
-- Records of im_role
-- ----------------------------
INSERT INTO `im_role` VALUES ('1', 'BACKEND', '1', '超级管理员', null, '110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,128,129,130,131,141,142,143,144', '1', '2022-08-23 17:37:54', '2022-09-17 14:41:26', null, 'NORMAL');
INSERT INTO `im_role` VALUES ('2', 'BACKEND', '1', '管理员', null, '118,119,120,122,123,124', '1', '2022-08-23 18:05:37', '2022-08-23 22:48:28', null, 'NORMAL');
INSERT INTO `im_role` VALUES ('3', 'ADVERTISEMENT', '2', '管理员', null, '151,152,153,154,155,156,157,158,159,160,161,162', '1', '2022-09-15 17:53:34', '2022-09-20 16:26:20', null, 'NORMAL');
INSERT INTO `im_role` VALUES ('4', 'PUBLISHMENT', '3', '管理员', null, '133,134,135,136,137,138,139,140,146,147,148,149,164,165,166,167', '1', '2022-09-15 17:53:43', '2022-09-25 14:56:35', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_role_policy`
-- ----------------------------
DROP TABLE IF EXISTS `im_role_policy`;
CREATE TABLE `im_role_policy` (
  `role_id` int(11) unsigned NOT NULL DEFAULT '0',
  `policy_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`,`policy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色策略';

-- ----------------------------
-- Records of im_role_policy
-- ----------------------------
INSERT INTO `im_role_policy` VALUES ('1', '110');
INSERT INTO `im_role_policy` VALUES ('1', '111');
INSERT INTO `im_role_policy` VALUES ('1', '112');
INSERT INTO `im_role_policy` VALUES ('1', '113');
INSERT INTO `im_role_policy` VALUES ('1', '114');
INSERT INTO `im_role_policy` VALUES ('1', '115');
INSERT INTO `im_role_policy` VALUES ('1', '116');
INSERT INTO `im_role_policy` VALUES ('1', '117');
INSERT INTO `im_role_policy` VALUES ('1', '118');
INSERT INTO `im_role_policy` VALUES ('1', '119');
INSERT INTO `im_role_policy` VALUES ('1', '120');
INSERT INTO `im_role_policy` VALUES ('1', '121');
INSERT INTO `im_role_policy` VALUES ('1', '122');
INSERT INTO `im_role_policy` VALUES ('1', '123');
INSERT INTO `im_role_policy` VALUES ('1', '124');
INSERT INTO `im_role_policy` VALUES ('1', '125');
INSERT INTO `im_role_policy` VALUES ('1', '126');
INSERT INTO `im_role_policy` VALUES ('1', '128');
INSERT INTO `im_role_policy` VALUES ('1', '129');
INSERT INTO `im_role_policy` VALUES ('1', '130');
INSERT INTO `im_role_policy` VALUES ('1', '131');
INSERT INTO `im_role_policy` VALUES ('1', '141');
INSERT INTO `im_role_policy` VALUES ('1', '142');
INSERT INTO `im_role_policy` VALUES ('1', '143');
INSERT INTO `im_role_policy` VALUES ('1', '144');
INSERT INTO `im_role_policy` VALUES ('2', '118');
INSERT INTO `im_role_policy` VALUES ('2', '119');
INSERT INTO `im_role_policy` VALUES ('2', '120');
INSERT INTO `im_role_policy` VALUES ('2', '122');
INSERT INTO `im_role_policy` VALUES ('2', '123');
INSERT INTO `im_role_policy` VALUES ('2', '124');
INSERT INTO `im_role_policy` VALUES ('3', '151');
INSERT INTO `im_role_policy` VALUES ('3', '152');
INSERT INTO `im_role_policy` VALUES ('3', '153');
INSERT INTO `im_role_policy` VALUES ('3', '154');
INSERT INTO `im_role_policy` VALUES ('3', '155');
INSERT INTO `im_role_policy` VALUES ('3', '156');
INSERT INTO `im_role_policy` VALUES ('3', '157');
INSERT INTO `im_role_policy` VALUES ('3', '158');
INSERT INTO `im_role_policy` VALUES ('3', '159');
INSERT INTO `im_role_policy` VALUES ('3', '160');
INSERT INTO `im_role_policy` VALUES ('3', '161');
INSERT INTO `im_role_policy` VALUES ('3', '162');
INSERT INTO `im_role_policy` VALUES ('4', '133');
INSERT INTO `im_role_policy` VALUES ('4', '134');
INSERT INTO `im_role_policy` VALUES ('4', '135');
INSERT INTO `im_role_policy` VALUES ('4', '136');
INSERT INTO `im_role_policy` VALUES ('4', '137');
INSERT INTO `im_role_policy` VALUES ('4', '138');
INSERT INTO `im_role_policy` VALUES ('4', '139');
INSERT INTO `im_role_policy` VALUES ('4', '140');
INSERT INTO `im_role_policy` VALUES ('4', '146');
INSERT INTO `im_role_policy` VALUES ('4', '147');
INSERT INTO `im_role_policy` VALUES ('4', '148');
INSERT INTO `im_role_policy` VALUES ('4', '149');
INSERT INTO `im_role_policy` VALUES ('4', '164');
INSERT INTO `im_role_policy` VALUES ('4', '165');
INSERT INTO `im_role_policy` VALUES ('4', '166');
INSERT INTO `im_role_policy` VALUES ('4', '167');

-- ----------------------------
-- Table structure for `im_site`
-- ----------------------------
DROP TABLE IF EXISTS `im_site`;
CREATE TABLE `im_site` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `publishment_id` bigint(20) unsigned DEFAULT NULL COMMENT '流量主编号',
  `industry_id` bigint(20) unsigned DEFAULT NULL COMMENT '行业编号',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `protocol` varchar(255) DEFAULT NULL COMMENT '协议',
  `domain` varchar(255) DEFAULT NULL COMMENT '域名',
  `description` text COMMENT '描述',
  `hash` varchar(255) DEFAULT NULL COMMENT '签名',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='站点';

-- ----------------------------
-- Records of im_site
-- ----------------------------
INSERT INTO `im_site` VALUES ('1', '10086', '3', '电影网站', 'http://', 'v2.me.yunduanchongqing.com/', null, '53d6a6cc4eb4c151e80ad577802286d8', '2022-09-19 16:28:29', '2022-09-19 16:28:29', null, 'NORMAL');
INSERT INTO `im_site` VALUES ('2', '10087', '3', '电影网站', 'http://', 'v2.me.yunduanchongqing.com/', null, '53d6a6cc4eb4c151e80ad577802286d8', '2022-09-24 12:50:14', '2022-09-24 12:50:14', null, 'NORMAL');
INSERT INTO `im_site` VALUES ('3', '10088', '3', '电影网站', 'http://', 'v2.me.yunduanchongqing.com/', null, '53d6a6cc4eb4c151e80ad577802286d8', '2022-09-24 12:50:14', '2022-09-24 12:50:14', null, 'NORMAL');

-- ----------------------------
-- Table structure for `im_size`
-- ----------------------------
DROP TABLE IF EXISTS `im_size`;
CREATE TABLE `im_size` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned DEFAULT '0' COMMENT '父级编号',
  `title` varchar(255) DEFAULT NULL COMMENT '名称',
  `width` int(11) unsigned DEFAULT '0' COMMENT '宽度',
  `height` int(11) unsigned DEFAULT '0' COMMENT '高度',
  `description` text COMMENT '描述',
  `device` varchar(255) DEFAULT NULL COMMENT '设备{PC:电脑}{MOBILE:移动端}',
  `type` varchar(255) DEFAULT NULL COMMENT '展现类型{SINGLE:单图}{MULTIGRAPH:多图}{POPUP:弹窗}{FLOAT:悬浮}{COUPLET:对联}',
  `sorting` int(11) unsigned DEFAULT '1' COMMENT '排序',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  `state` enum('NORMAL','DISABLE') DEFAULT 'DISABLE' COMMENT '状态{NORMAL:正常}{DISABLE:禁用}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COMMENT='尺寸';

-- ----------------------------
-- Records of im_size
-- ----------------------------
INSERT INTO `im_size` VALUES ('1', '0', '方形和矩形', null, null, null, '', '', '1', '2022-09-17 15:25:40', '2022-09-17 15:25:40', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('2', '0', '摩天大楼', null, null, null, '', '', '1', '2022-09-17 15:25:49', '2022-09-17 15:25:49', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('3', '0', '横幅', null, null, null, '', '', '3', '2022-09-17 15:25:58', '2022-09-17 22:18:06', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('4', '0', '半横幅', null, null, null, '', '', '2', '2022-09-17 15:27:08', '2022-09-17 22:18:00', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('5', '1', '小方形', '200', '200', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:27:39', '2022-09-17 21:52:01', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('6', '1', '竖向矩形', '240', '400', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:28:18', '2022-09-17 21:45:24', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('7', '1', '正方形', '250', '250', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:28:29', '2022-09-17 21:45:31', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('8', '1', '三倍宽屏', '250', '360', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:28:42', '2022-09-17 21:45:37', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('9', '1', '内插矩形', '300', '250', null, 'PC,MOBILE', 'SINGLE,MULTIGRAPH,POPUP,FLOAT', '1', '2022-09-17 15:28:52', '2022-09-17 22:24:20', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('10', '1', '大矩形', '336', '280', null, 'PC', 'SINGLE,MULTIGRAPH,POPUP,FLOAT', '1', '2022-09-17 15:29:03', '2022-09-17 22:24:27', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('11', '1', 'Netboard', '580', '400', null, 'PC', 'SINGLE,MULTIGRAPH,POPUP', '1', '2022-09-17 15:29:22', '2022-09-17 21:44:46', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('12', '2', '摩天大楼', '120', '600', null, 'PC', 'SINGLE,MULTIGRAPH,COUPLET', '1', '2022-09-17 15:29:47', '2022-09-17 22:20:00', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('13', '2', '宽幅摩天大楼', '160', '600', null, 'PC', 'SINGLE,MULTIGRAPH,COUPLET', '1', '2022-09-17 15:30:02', '2022-09-17 22:20:06', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('14', '2', '半版广告', '300', '600', null, 'PC', 'SINGLE,MULTIGRAPH,COUPLET', '1', '2022-09-17 15:30:16', '2022-09-17 22:20:11', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('15', '2', '纵向', '300', '1050', null, 'PC', 'SINGLE,MULTIGRAPH,COUPLET', '1', '2022-09-17 15:30:32', '2022-09-17 22:20:32', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('16', '3', '横幅', '486', '60', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:30:57', '2022-09-17 15:30:57', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('17', '3', '页首横幅', '728', '90', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:31:11', '2022-09-17 15:31:11', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('18', '3', '顶部横幅', '930', '180', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:31:25', '2022-09-17 15:31:25', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('19', '3', '大型页首横幅', '970', '90', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:31:39', '2022-09-17 15:31:39', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('20', '3', '广告牌', '970', '250', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:31:51', '2022-09-17 15:31:51', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('21', '3', '全景', '980', '120', null, 'PC', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:32:02', '2022-09-17 15:32:02', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('22', '4', '小型半横幅', '300', '50', null, 'PC,MOBILE', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:32:18', '2022-09-17 22:12:32', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('23', '4', '中型半横幅', '320', '50', null, 'PC,MOBILE', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:32:30', '2022-09-17 22:12:37', null, 'NORMAL');
INSERT INTO `im_size` VALUES ('24', '4', '大型半横幅', '320', '100', null, 'PC,MOBILE', 'SINGLE,MULTIGRAPH', '1', '2022-09-17 15:32:44', '2022-09-17 22:12:42', null, 'NORMAL');
