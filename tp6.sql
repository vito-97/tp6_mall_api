/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : tp6

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 25/02/2022 17:21:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mall_banner
-- ----------------------------
DROP TABLE IF EXISTS `mall_banner`;
CREATE TABLE `mall_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Banner描述',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'banner管理表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_banner
-- ----------------------------
INSERT INTO `mall_banner` VALUES (1, '首页置顶', '首页轮播图', 0, 0, 0);

-- ----------------------------
-- Table structure for mall_banner_item
-- ----------------------------
DROP TABLE IF EXISTS `mall_banner_item`;
CREATE TABLE `mall_banner_item`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'banner子项表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_banner_item
-- ----------------------------
INSERT INTO `mall_banner_item` VALUES (1, 65, '6', 1, 1, 0, 0, 0);
INSERT INTO `mall_banner_item` VALUES (2, 2, '25', 1, 1, 0, 0, 0);
INSERT INTO `mall_banner_item` VALUES (3, 3, '11', 1, 1, 0, 0, 0);
INSERT INTO `mall_banner_item` VALUES (5, 1, '10', 1, 1, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_category
-- ----------------------------
DROP TABLE IF EXISTS `mall_category`;
CREATE TABLE `mall_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) NULL DEFAULT NULL COMMENT '外键，关联image表',
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '描述',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品类目' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_category
-- ----------------------------
INSERT INTO `mall_category` VALUES (2, '果味', 6, NULL, 0, 0, 0);
INSERT INTO `mall_category` VALUES (3, '蔬菜', 5, NULL, 0, 0, 0);
INSERT INTO `mall_category` VALUES (4, '炒货', 7, NULL, 0, 0, 0);
INSERT INTO `mall_category` VALUES (5, '点心', 4, NULL, 0, 0, 0);
INSERT INTO `mall_category` VALUES (6, '粗茶', 8, NULL, 0, 0, 0);
INSERT INTO `mall_category` VALUES (7, '淡饭', 9, NULL, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_image
-- ----------------------------
DROP TABLE IF EXISTS `mall_image`;
CREATE TABLE `mall_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `from` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 来自本地，2 来自公网',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '图片总表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_image
-- ----------------------------
INSERT INTO `mall_image` VALUES (1, '/banner-1a.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (2, '/banner-2a.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (3, '/banner-3a.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (4, '/category-cake.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (5, '/category-vg.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (6, '/category-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (7, '/category-fry-a.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (8, '/category-tea.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (9, '/category-rice.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (10, '/product-dryfruit@1.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (13, '/product-vg@1.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (14, '/product-rice@6.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (16, '/1@theme.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (17, '/2@theme.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (18, '/3@theme.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (19, '/detail-1@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (20, '/detail-2@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (21, '/detail-3@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (22, '/detail-4@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (23, '/detail-5@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (24, '/detail-6@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (25, '/detail-7@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (26, '/detail-8@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (27, '/detail-9@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (28, '/detail-11@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (29, '/detail-10@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (31, '/product-rice@1.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (32, '/product-tea@1.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (33, '/product-dryfruit@2.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (36, '/product-dryfruit@3.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (37, '/product-dryfruit@4.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (38, '/product-dryfruit@5.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (39, '/product-dryfruit-a@6.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (40, '/product-dryfruit@7.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (41, '/product-rice@2.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (42, '/product-rice@3.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (43, '/product-rice@4.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (44, '/product-fry@1.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (45, '/product-fry@2.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (46, '/product-fry@3.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (47, '/product-tea@2.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (48, '/product-tea@3.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (49, '/1@theme-head.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (50, '/2@theme-head.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (51, '/3@theme-head.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (52, '/product-cake@1.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (53, '/product-cake@2.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (54, '/product-cake-a@3.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (55, '/product-cake-a@4.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (56, '/product-dryfruit@8.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (57, '/product-fry@4.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (58, '/product-fry@5.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (59, '/product-rice@5.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (60, '/product-rice@7.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (62, '/detail-12@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (63, '/detail-13@1-dryfruit.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (65, '/banner-4a.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (66, '/product-vg@4.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (67, '/product-vg@5.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (68, '/product-vg@2.png', 1, 0, 0, 0);
INSERT INTO `mall_image` VALUES (69, '/product-vg@3.png', 1, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_order
-- ----------------------------
DROP TABLE IF EXISTS `mall_order`;
CREATE TABLE `mall_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `total_price` decimal(6, 2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未支付， 2：已支付，3：已发货 , 4: 已支付，但库存不足',
  `snap_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT 0,
  `snap_items` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '地址快照',
  `prepay_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_no`(`order_no`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_order
-- ----------------------------

-- ----------------------------
-- Table structure for mall_order_product
-- ----------------------------
DROP TABLE IF EXISTS `mall_order_product`;
CREATE TABLE `mall_order_product`  (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_id`, `order_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for mall_product
-- ----------------------------
DROP TABLE IF EXISTS `mall_product`;
CREATE TABLE `mall_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品名称',
  `price` decimal(6, 2) NOT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT '库存量',
  `category_id` int(11) NULL DEFAULT NULL,
  `main_img_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `from` tinyint(4) NOT NULL DEFAULT 1 COMMENT '图片来自 1 本地 ，2公网',
  `summary` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '摘要',
  `img_id` int(11) NULL DEFAULT NULL COMMENT '图片外键',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_product
-- ----------------------------
INSERT INTO `mall_product` VALUES (1, '芹菜 半斤', 0.01, 998, 3, '/product-vg@1.png', 1, NULL, 13, 0, 0, 0);
INSERT INTO `mall_product` VALUES (2, '梨花带雨 3个', 0.01, 984, 2, '/product-dryfruit@1.png', 1, NULL, 10, 0, 0, 0);
INSERT INTO `mall_product` VALUES (3, '素米 327克', 0.01, 996, 7, '/product-rice@1.png', 1, NULL, 31, 0, 0, 0);
INSERT INTO `mall_product` VALUES (4, '红袖枸杞 6克*3袋', 0.01, 998, 6, '/product-tea@1.png', 1, NULL, 32, 0, 0, 0);
INSERT INTO `mall_product` VALUES (5, '春生龙眼 500克', 0.01, 995, 2, '/product-dryfruit@2.png', 1, NULL, 33, 0, 0, 0);
INSERT INTO `mall_product` VALUES (6, '小红的猪耳朵 120克', 0.01, 997, 5, '/product-cake@2.png', 1, NULL, 53, 0, 0, 0);
INSERT INTO `mall_product` VALUES (7, '泥蒿 半斤', 0.01, 998, 3, '/product-vg@2.png', 1, NULL, 68, 0, 0, 0);
INSERT INTO `mall_product` VALUES (8, '夏日芒果 3个', 0.01, 995, 2, '/product-dryfruit@3.png', 1, NULL, 36, 0, 0, 0);
INSERT INTO `mall_product` VALUES (9, '冬木红枣 500克', 0.01, 996, 2, '/product-dryfruit@4.png', 1, NULL, 37, 0, 0, 0);
INSERT INTO `mall_product` VALUES (10, '万紫千凤梨 300克', 0.01, 996, 2, '/product-dryfruit@5.png', 1, NULL, 38, 0, 0, 0);
INSERT INTO `mall_product` VALUES (11, '贵妃笑 100克', 0.01, 994, 2, '/product-dryfruit-a@6.png', 1, NULL, 39, 0, 0, 0);
INSERT INTO `mall_product` VALUES (12, '珍奇异果 3个', 0.01, 999, 2, '/product-dryfruit@7.png', 1, NULL, 40, 0, 0, 0);
INSERT INTO `mall_product` VALUES (13, '绿豆 125克', 0.01, 999, 7, '/product-rice@2.png', 1, NULL, 41, 0, 0, 0);
INSERT INTO `mall_product` VALUES (14, '芝麻 50克', 0.01, 999, 7, '/product-rice@3.png', 1, NULL, 42, 0, 0, 0);
INSERT INTO `mall_product` VALUES (15, '猴头菇 370克', 0.01, 999, 7, '/product-rice@4.png', 1, NULL, 43, 0, 0, 0);
INSERT INTO `mall_product` VALUES (16, '西红柿 1斤', 0.01, 999, 3, '/product-vg@3.png', 1, NULL, 69, 0, 0, 0);
INSERT INTO `mall_product` VALUES (17, '油炸花生 300克', 0.01, 999, 4, '/product-fry@1.png', 1, NULL, 44, 0, 0, 0);
INSERT INTO `mall_product` VALUES (18, '春泥西瓜子 128克', 0.01, 997, 4, '/product-fry@2.png', 1, NULL, 45, 0, 0, 0);
INSERT INTO `mall_product` VALUES (19, '碧水葵花籽 128克', 0.01, 999, 4, '/product-fry@3.png', 1, NULL, 46, 0, 0, 0);
INSERT INTO `mall_product` VALUES (20, '碧螺春 12克*3袋', 0.01, 999, 6, '/product-tea@2.png', 1, NULL, 47, 0, 0, 0);
INSERT INTO `mall_product` VALUES (21, '西湖龙井 8克*3袋', 0.01, 998, 6, '/product-tea@3.png', 1, NULL, 48, 0, 0, 0);
INSERT INTO `mall_product` VALUES (22, '梅兰清花糕 1个', 0.01, 997, 5, '/product-cake-a@3.png', 1, NULL, 54, 0, 0, 0);
INSERT INTO `mall_product` VALUES (23, '清凉薄荷糕 1个', 0.01, 998, 5, '/product-cake-a@4.png', 1, NULL, 55, 0, 0, 0);
INSERT INTO `mall_product` VALUES (25, '小明的妙脆角 120克', 0.01, 999, 5, '/product-cake@1.png', 1, NULL, 52, 0, 0, 0);
INSERT INTO `mall_product` VALUES (26, '红衣青瓜 混搭160克', 0.01, 999, 2, '/product-dryfruit@8.png', 1, NULL, 56, 0, 0, 0);
INSERT INTO `mall_product` VALUES (27, '锈色瓜子 100克', 0.01, 998, 4, '/product-fry@4.png', 1, NULL, 57, 0, 0, 0);
INSERT INTO `mall_product` VALUES (28, '春泥花生 200克', 0.01, 999, 4, '/product-fry@5.png', 1, NULL, 58, 0, 0, 0);
INSERT INTO `mall_product` VALUES (29, '冰心鸡蛋 2个', 0.01, 999, 7, '/product-rice@5.png', 1, NULL, 59, 0, 0, 0);
INSERT INTO `mall_product` VALUES (30, '八宝莲子 200克', 0.01, 999, 7, '/product-rice@6.png', 1, NULL, 14, 0, 0, 0);
INSERT INTO `mall_product` VALUES (31, '深涧木耳 78克', 0.01, 999, 7, '/product-rice@7.png', 1, NULL, 60, 0, 0, 0);
INSERT INTO `mall_product` VALUES (32, '土豆 半斤', 0.01, 999, 3, '/product-vg@4.png', 1, NULL, 66, 0, 0, 0);
INSERT INTO `mall_product` VALUES (33, '青椒 半斤', 0.01, 999, 3, '/product-vg@5.png', 1, NULL, 67, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_product_image
-- ----------------------------
DROP TABLE IF EXISTS `mall_product_image`;
CREATE TABLE `mall_product_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `order` int(11) NOT NULL DEFAULT 0 COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_product_image
-- ----------------------------
INSERT INTO `mall_product_image` VALUES (4, 19, 1, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (5, 20, 2, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (6, 21, 3, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (7, 22, 4, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (8, 23, 5, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (9, 24, 6, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (10, 25, 7, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (11, 26, 8, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (12, 27, 9, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (13, 28, 11, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (14, 29, 10, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (18, 62, 12, 11, 0, 0, 0);
INSERT INTO `mall_product_image` VALUES (19, 63, 13, 11, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_product_property
-- ----------------------------
DROP TABLE IF EXISTS `mall_product_property`;
CREATE TABLE `mall_product_property`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_product_property
-- ----------------------------
INSERT INTO `mall_product_property` VALUES (1, '品名', '杨梅', 11, 0, 0, 0);
INSERT INTO `mall_product_property` VALUES (2, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, 0, 0, 0);
INSERT INTO `mall_product_property` VALUES (3, '产地', '火星', 11, 0, 0, 0);
INSERT INTO `mall_product_property` VALUES (4, '保质期', '180天', 11, 0, 0, 0);
INSERT INTO `mall_product_property` VALUES (5, '品名', '梨子', 2, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_theme
-- ----------------------------
DROP TABLE IF EXISTS `mall_theme`;
CREATE TABLE `mall_theme`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '专题名称',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专题描述',
  `topic_img_id` int(11) NOT NULL COMMENT '主题图，外键',
  `head_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主题信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_theme
-- ----------------------------
INSERT INTO `mall_theme` VALUES (1, '专题栏位一', '美味水果世界', 16, 49, 0, 0, 0);
INSERT INTO `mall_theme` VALUES (2, '专题栏位二', '新品推荐', 17, 50, 0, 0, 0);
INSERT INTO `mall_theme` VALUES (3, '专题栏位三', '做个干物女', 18, 18, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_theme_product
-- ----------------------------
DROP TABLE IF EXISTS `mall_theme_product`;
CREATE TABLE `mall_theme_product`  (
  `theme_id` int(11) NOT NULL COMMENT '主题外键',
  `product_id` int(11) NOT NULL COMMENT '商品外键',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`theme_id`, `product_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主题所包含的商品' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_theme_product
-- ----------------------------
INSERT INTO `mall_theme_product` VALUES (1, 2, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (1, 5, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (1, 8, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (1, 10, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (1, 12, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (1, 33, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 1, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 2, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 3, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 5, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 6, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 16, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (2, 33, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (3, 15, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (3, 18, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (3, 19, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (3, 27, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (3, 30, 0, 0, 0);
INSERT INTO `mall_theme_product` VALUES (3, 31, 0, 0, 0);

-- ----------------------------
-- Table structure for mall_third_app
-- ----------------------------
DROP TABLE IF EXISTS `mall_third_app`;
CREATE TABLE `mall_third_app`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '应用权限',
  `scope_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '权限描述',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '访问API的各应用账号密码表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_third_app
-- ----------------------------
INSERT INTO `mall_third_app` VALUES (1, 'starcraft', '777*777', 'CMS', '32', 'Super', 0, 0, 0);

-- ----------------------------
-- Table structure for mall_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_user`;
CREATE TABLE `mall_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `extend` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `last_login_ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `last_login_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `openid`(`openid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_user
-- ----------------------------
INSERT INTO `mall_user` VALUES (1, 'o3uv9vlnmm6xCOim7GjuMT4eIbYc', '', '', '127.0.0.1', 1645780609, 1, 0, 1645780566, 1645780609);

-- ----------------------------
-- Table structure for mall_user_address
-- ----------------------------
DROP TABLE IF EXISTS `mall_user_address`;
CREATE TABLE `mall_user_address`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手机号',
  `province` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '省',
  `city` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '市',
  `country` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '区',
  `detail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '详细地址',
  `user_id` int(11) NOT NULL COMMENT '外键',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mall_user_address
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
