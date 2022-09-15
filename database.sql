/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : im

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2022-08-23 23:44:03
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `im_manager` VALUES ('1', '1', '超级管理组', '创始人', 'founder', '0957ca902212979ffd4c4927f0b45def', 'Y181VY', '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-08-23 23:02:41', '2022-01-01 18:00:00', '2022-08-23 23:02:41', null, 'NORMAL');
INSERT INTO `im_manager` VALUES ('2', '2', '管理员', '管理员', 'admin', 'fe711720669a634139a1c650be70a4ae', 'VOKYQR', '127.0.0.1', '2022-01-01 18:00:00', '127.0.0.1', '2022-08-23 23:24:18', '2022-01-01 18:00:00', '2022-08-23 23:24:18', null, 'NORMAL');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='模块';

-- ----------------------------
-- Records of im_module
-- ----------------------------
INSERT INTO `im_module` VALUES ('1', 'BACKEND', '后台模块', null, '1', '2022-08-23 16:32:56', '2022-08-23 16:32:56', null, 'NORMAL');

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
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='策略';

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色';

-- ----------------------------
-- Records of im_role
-- ----------------------------
INSERT INTO `im_role` VALUES ('1', 'BACKEND', '1', '超级管理员', null, '110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126', '1', '2022-08-23 17:37:54', '2022-08-23 18:37:24', null, 'NORMAL');
INSERT INTO `im_role` VALUES ('2', 'BACKEND', '1', '管理员', null, '118,119,120,122,123,124', '1', '2022-08-23 18:05:37', '2022-08-23 22:48:28', null, 'NORMAL');

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
INSERT INTO `im_role_policy` VALUES ('2', '118');
INSERT INTO `im_role_policy` VALUES ('2', '119');
INSERT INTO `im_role_policy` VALUES ('2', '120');
INSERT INTO `im_role_policy` VALUES ('2', '122');
INSERT INTO `im_role_policy` VALUES ('2', '123');
INSERT INTO `im_role_policy` VALUES ('2', '124');
