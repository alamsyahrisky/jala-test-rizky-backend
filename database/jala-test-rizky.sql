/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80030
 Source Host           : localhost:3306
 Source Schema         : jala-test-rizky

 Target Server Type    : MySQL
 Target Server Version : 80030
 File Encoding         : 65001

 Date: 02/03/2023 16:16:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, 'SPT', 'Sepatu Sport', NULL, '2023-03-02 08:34:56', NULL);
INSERT INTO `category` VALUES (2, 'SND', 'Sepatu Casual', '2023-02-28 07:14:45', '2023-03-02 08:35:03', NULL);
INSERT INTO `category` VALUES (3, 'KOS', 'Kaos', '2023-02-28 07:17:02', '2023-02-28 08:11:14', '2023-02-28 08:11:14');
INSERT INTO `category` VALUES (4, 'FRM', 'Sepatu Formal', '2023-03-02 08:41:33', '2023-03-02 08:41:33', NULL);
INSERT INTO `category` VALUES (5, 'SNL', 'Sandal', '2023-03-02 08:46:40', '2023-03-02 08:46:40', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price_total` int NOT NULL,
  `item_total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `invoice_number_unique`(`number` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoice
-- ----------------------------
INSERT INTO `invoice` VALUES ('3de53f84-3ed5-4c5e-b01e-3437f6961c86', 'PO-02032023-002', '2023-03-02', NULL, 'Test', 6650000, 2, '2023-03-02 04:12:28', '2023-03-02 04:12:28', NULL);
INSERT INTO `invoice` VALUES ('424a6c4c-c707-4d6f-b437-09b6398bf005', 'PO-02032023-003', '2023-03-02', NULL, NULL, 2500000, 1, '2023-03-02 04:20:37', '2023-03-02 04:20:37', NULL);
INSERT INTO `invoice` VALUES ('60a0e668-a0c1-4708-8582-f42988b38b31', 'PO-02032023-004', '2023-03-02', 'Cepet', 'Supplier A', 66850000, 3, '2023-03-02 08:57:36', '2023-03-02 08:57:36', NULL);
INSERT INTO `invoice` VALUES ('984a2030-24ae-4987-b899-0a47ef1cf2b3', 'PO-28022023-001', '2023-02-28', NULL, 'Test Company', 8100000, 2, '2023-02-28 15:20:03', '2023-02-28 15:20:03', NULL);

-- ----------------------------
-- Table structure for invoice_detail
-- ----------------------------
DROP TABLE IF EXISTS `invoice_detail`;
CREATE TABLE `invoice_detail`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoice_detail_invoice_id_foreign`(`invoice_id` ASC) USING BTREE,
  INDEX `invoice_detail_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `invoice_detail_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `invoice_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoice_detail
-- ----------------------------
INSERT INTO `invoice_detail` VALUES ('111e332a-17a3-4223-9295-764da48495cc', '424a6c4c-c707-4d6f-b437-09b6398bf005', '859eedd9-e648-4918-9dfd-23b9b59466ce', 10, 250000, 2500000, '2023-03-02 04:20:37', '2023-03-02 04:20:37', NULL);
INSERT INTO `invoice_detail` VALUES ('2d036b64-396c-45f4-bcd1-be9c7616f9a4', '984a2030-24ae-4987-b899-0a47ef1cf2b3', '859eedd9-e648-4918-9dfd-23b9b59466ce', 10, 250000, 2500000, '2023-02-28 15:20:03', '2023-02-28 15:20:03', NULL);
INSERT INTO `invoice_detail` VALUES ('3e6e6797-1a53-4990-9e01-575d2bf8dc36', '60a0e668-a0c1-4708-8582-f42988b38b31', '0ad0229b-08d4-43ad-8d00-9e2c3665024b', 50, 827000, 41350000, '2023-03-02 08:57:36', '2023-03-02 08:57:36', NULL);
INSERT INTO `invoice_detail` VALUES ('407fbd32-9ba3-4c88-8291-3ef751756f65', '984a2030-24ae-4987-b899-0a47ef1cf2b3', '4df2502d-90c2-400b-a4b5-b211ca834748', 20, 280000, 5600000, '2023-02-28 15:20:03', '2023-02-28 15:20:03', NULL);
INSERT INTO `invoice_detail` VALUES ('a7a9e601-80a8-4b9b-9ac5-a121858edba1', '60a0e668-a0c1-4708-8582-f42988b38b31', '113fb031-b5ac-4593-ba81-32055aec868c', 30, 350000, 10500000, '2023-03-02 08:57:36', '2023-03-02 08:57:36', NULL);
INSERT INTO `invoice_detail` VALUES ('acd5f18d-5579-4c4e-98a3-006c54a13c8b', '3de53f84-3ed5-4c5e-b01e-3437f6961c86', 'd83294b5-8a1b-492b-910d-00c65d3e9d62', 10, 400000, 4000000, '2023-03-02 04:12:28', '2023-03-02 04:12:28', NULL);
INSERT INTO `invoice_detail` VALUES ('c7532b2f-239d-43f5-8473-ed5125f9831b', '60a0e668-a0c1-4708-8582-f42988b38b31', '449f0511-eb4d-4862-95d3-04952936c773', 20, 750000, 15000000, '2023-03-02 08:57:36', '2023-03-02 08:57:36', NULL);
INSERT INTO `invoice_detail` VALUES ('ca15bae8-82ef-42d7-8b84-92a5cbe3216b', '3de53f84-3ed5-4c5e-b01e-3437f6961c86', 'f0add435-6ed6-46bb-9954-46e6c025aec6', 10, 265000, 2650000, '2023-03-02 04:12:28', '2023-03-02 04:12:28', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (66, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (67, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (68, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (69, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (70, '2023_02_28_024426_create_category_table', 1);
INSERT INTO `migrations` VALUES (71, '2023_02_28_024614_create_product_table', 1);
INSERT INTO `migrations` VALUES (72, '2023_02_28_025425_create_invoice', 1);
INSERT INTO `migrations` VALUES (73, '2023_02_28_025724_create_invoice_detail_table', 1);
INSERT INTO `migrations` VALUES (74, '2023_02_28_030529_create_order_table', 1);
INSERT INTO `migrations` VALUES (75, '2023_02_28_030821_create_order_detail_table', 1);
INSERT INTO `migrations` VALUES (76, '2023_02_28_145535_create_table_stock', 2);
INSERT INTO `migrations` VALUES (77, '2023_02_28_150332_create_stock_table', 3);
INSERT INTO `migrations` VALUES (78, '2023_02_28_150458_create_stock_detail_table', 4);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('CART','PENDING','SUCCESS','CANCEL','PROCESS') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'CART',
  `price_total` int NOT NULL,
  `item_total` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `order_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('07e30802-cbc0-41b1-8c56-b3cffb62b053', 'SO-02032023-003', 2, '2023-03-02', 'PENDING', 1650000, 2, NULL, '2023-03-02 03:05:29', '2023-03-02 03:23:22', NULL);
INSERT INTO `order` VALUES ('11a89b58-d16c-4d79-beb7-f832e4c903e9', 'SO-02032023-005', 3, '2023-03-02', 'PENDING', 1640000, 2, NULL, '2023-03-02 04:26:15', '2023-03-02 04:27:24', NULL);
INSERT INTO `order` VALUES ('3a81c90d-f4dd-44c9-899d-9f5ba64f4c37', 'SO-02032023-007', 4, '2023-03-02', 'PENDING', 5500000, 2, 'size 40', '2023-03-02 09:07:35', '2023-03-02 09:10:50', NULL);
INSERT INTO `order` VALUES ('7f435b90-9a69-46a3-9dad-cf38b543d7e2', 'SO-01032023-002', 2, '2023-03-01', 'PENDING', 780000, 2, 'Ditunggu ya', '2023-03-01 09:58:10', '2023-03-01 15:22:38', NULL);
INSERT INTO `order` VALUES ('aa675baa-b42f-4a14-8f61-d3bfa32d516f', 'SO-01032023-001', 2, '2023-03-01', 'PENDING', 2650000, 2, NULL, '2023-03-01 02:58:19', '2023-03-01 03:41:34', NULL);
INSERT INTO `order` VALUES ('d46d30bc-b9da-4ff3-b7e0-b66ae6066cad', 'SO-02032023-006', 4, '2023-03-02', 'SUCCESS', 5885000, 2, 'size 45', '2023-03-02 08:59:35', '2023-03-02 09:00:04', NULL);
INSERT INTO `order` VALUES ('df33f932-f0b6-4095-8292-ab093635ee60', 'SO-02032023-004', 3, '2023-03-02', 'SUCCESS', 780000, 2, NULL, '2023-03-02 04:22:03', '2023-03-02 04:22:03', NULL);

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_detail_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `order_detail_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `order_detail_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `order_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_detail
-- ----------------------------
INSERT INTO `order_detail` VALUES ('03a91c36-9187-4310-98f2-efee65108493', '07e30802-cbc0-41b1-8c56-b3cffb62b053', '4df2502d-90c2-400b-a4b5-b211ca834748', 2, 280000, 560000, '2023-03-02 03:05:29', '2023-03-02 03:09:21', '2023-03-02 03:09:21');
INSERT INTO `order_detail` VALUES ('13a7938d-e2ee-403c-bfd3-1ed08c8af6d8', '11a89b58-d16c-4d79-beb7-f832e4c903e9', '859eedd9-e648-4918-9dfd-23b9b59466ce', 2, 250000, 500000, '2023-03-02 04:26:30', '2023-03-02 04:26:40', '2023-03-02 04:26:40');
INSERT INTO `order_detail` VALUES ('2dbe47a1-d37f-497c-81d1-34e0453dc48b', 'd46d30bc-b9da-4ff3-b7e0-b66ae6066cad', '0ad0229b-08d4-43ad-8d00-9e2c3665024b', 5, 827000, 4135000, '2023-03-02 08:59:35', '2023-03-02 08:59:35', NULL);
INSERT INTO `order_detail` VALUES ('2f0a23a8-b9c2-4040-a0d3-958cd6233f50', 'df33f932-f0b6-4095-8292-ab093635ee60', '859eedd9-e648-4918-9dfd-23b9b59466ce', 2, 250000, 500000, '2023-03-02 04:22:03', '2023-03-02 04:22:03', NULL);
INSERT INTO `order_detail` VALUES ('55142e88-dec0-44ee-9722-6d3ad7bac384', 'df33f932-f0b6-4095-8292-ab093635ee60', '4df2502d-90c2-400b-a4b5-b211ca834748', 1, 280000, 280000, '2023-03-02 04:22:03', '2023-03-02 04:22:03', NULL);
INSERT INTO `order_detail` VALUES ('56dea309-d507-42ce-84bf-552035a1b641', '11a89b58-d16c-4d79-beb7-f832e4c903e9', 'd83294b5-8a1b-492b-910d-00c65d3e9d62', 2, 400000, 800000, '2023-03-02 04:26:55', '2023-03-02 04:27:24', NULL);
INSERT INTO `order_detail` VALUES ('75d49408-202c-45c3-b627-7e220de2c7d8', '7f435b90-9a69-46a3-9dad-cf38b543d7e2', '859eedd9-e648-4918-9dfd-23b9b59466ce', 2, 250000, 500000, '2023-03-01 12:41:28', '2023-03-01 15:22:07', NULL);
INSERT INTO `order_detail` VALUES ('83eb17be-8adb-4353-82c2-9ee2b8958d3b', '7f435b90-9a69-46a3-9dad-cf38b543d7e2', '4df2502d-90c2-400b-a4b5-b211ca834748', 1, 280000, 280000, '2023-03-01 09:58:10', '2023-03-01 09:58:10', NULL);
INSERT INTO `order_detail` VALUES ('89aa5091-b8e7-4cf9-9e32-68694743f91a', '07e30802-cbc0-41b1-8c56-b3cffb62b053', '4df2502d-90c2-400b-a4b5-b211ca834748', 5, 280000, 1400000, '2023-03-02 03:18:40', '2023-03-02 03:22:58', '2023-03-02 03:22:58');
INSERT INTO `order_detail` VALUES ('8ed0135c-5a98-4b26-9523-a9df39ab0747', '07e30802-cbc0-41b1-8c56-b3cffb62b053', '4df2502d-90c2-400b-a4b5-b211ca834748', 5, 280000, 1400000, '2023-03-02 03:09:36', '2023-03-02 03:16:04', '2023-03-02 03:16:04');
INSERT INTO `order_detail` VALUES ('9327e5c6-b77e-48cb-b9f7-672bd5b54fec', 'd46d30bc-b9da-4ff3-b7e0-b66ae6066cad', '113fb031-b5ac-4593-ba81-32055aec868c', 5, 350000, 1750000, '2023-03-02 08:59:35', '2023-03-02 08:59:35', NULL);
INSERT INTO `order_detail` VALUES ('9545444f-18b8-4e6e-976a-ba3cb1b06887', '07e30802-cbc0-41b1-8c56-b3cffb62b053', '859eedd9-e648-4918-9dfd-23b9b59466ce', 1, 250000, 250000, '2023-03-02 03:22:43', '2023-03-02 03:22:43', NULL);
INSERT INTO `order_detail` VALUES ('98f92366-9a17-4df5-b018-d1531054d204', 'aa675baa-b42f-4a14-8f61-d3bfa32d516f', '4df2502d-90c2-400b-a4b5-b211ca834748', 5, 280000, 1400000, '2023-03-01 02:58:19', '2023-03-01 02:58:19', NULL);
INSERT INTO `order_detail` VALUES ('a2a2b7af-90db-4b47-ba47-998e00326808', 'aa675baa-b42f-4a14-8f61-d3bfa32d516f', '859eedd9-e648-4918-9dfd-23b9b59466ce', 5, 250000, 1250000, '2023-03-01 02:58:19', '2023-03-01 02:58:19', NULL);
INSERT INTO `order_detail` VALUES ('a414d2f1-1d98-4429-8abe-b6dc6b1b8465', '3a81c90d-f4dd-44c9-899d-9f5ba64f4c37', '113fb031-b5ac-4593-ba81-32055aec868c', 5, 350000, 1750000, '2023-03-02 09:07:35', '2023-03-02 09:07:35', NULL);
INSERT INTO `order_detail` VALUES ('ce447501-1614-4639-9103-37da3b3ddb2b', '7f435b90-9a69-46a3-9dad-cf38b543d7e2', '859eedd9-e648-4918-9dfd-23b9b59466ce', 1, 250000, 250000, '2023-03-01 10:00:45', '2023-03-01 12:41:17', '2023-03-01 12:41:17');
INSERT INTO `order_detail` VALUES ('e0b5dc89-c353-4bdb-af5b-2988e67f3edd', '11a89b58-d16c-4d79-beb7-f832e4c903e9', '4df2502d-90c2-400b-a4b5-b211ca834748', 3, 280000, 840000, '2023-03-02 04:26:15', '2023-03-02 04:26:15', NULL);
INSERT INTO `order_detail` VALUES ('ee4c7118-5ab9-4e17-8420-3aadf077f056', '07e30802-cbc0-41b1-8c56-b3cffb62b053', '859eedd9-e648-4918-9dfd-23b9b59466ce', 1, 250000, 250000, '2023-03-02 03:21:20', '2023-03-02 03:22:35', '2023-03-02 03:22:35');
INSERT INTO `order_detail` VALUES ('f5826e04-5ef2-4069-8a34-e45c331de274', '07e30802-cbc0-41b1-8c56-b3cffb62b053', '4df2502d-90c2-400b-a4b5-b211ca834748', 5, 280000, 1400000, '2023-03-02 03:23:07', '2023-03-02 03:23:07', NULL);
INSERT INTO `order_detail` VALUES ('ff916897-a400-4d91-94c0-077dd96a516c', '3a81c90d-f4dd-44c9-899d-9f5ba64f4c37', '449f0511-eb4d-4862-95d3-04952936c773', 5, 750000, 3750000, '2023-03-02 09:08:23', '2023-03-02 09:10:37', NULL);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` int UNSIGNED NULL DEFAULT 12,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `condition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `weight` int NULL DEFAULT NULL,
  `stok` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `product_sku_unique`(`sku` ASC) USING BTREE,
  INDEX `product_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('0ad0229b-08d4-43ad-8d00-9e2c3665024b', 'PRD-FRM-001', 'ALPHA URBAN BOOTS FULL BLACK', 'alpha-urban-boots-full-black', 'Salah satu dari koleksi THE FOUNDER, Alpha Urban Boots adalah sepatu dengan karakter kuat yang bisa digunakan oleh Bro & Sis yang memiliki kepercayaan diri tinggi. Design tajam dan ekslusif akan memberikan sentuhan classy dan memperkuat karakter pada setiap tampilan Bro & Sis.', 827000, 'assets/product//sJYjT4oZ5djeKn6D1m3zmC6mhIRVc58fSC04cbWH.webp', 4, 'Baru', 3, 45, '2023-03-02 08:48:00', '2023-03-02 08:59:35', NULL);
INSERT INTO `product` VALUES ('113fb031-b5ac-4593-ba81-32055aec868c', 'PRD-SNL-002', 'LIKI BLACK OWS', 'liki-black-ows', 'Liki menjadi teman berpetualang dengan leluasa dengan desain removable strap yang bisa disesuaikan dengan kebutuhan. Dilengkapi dengan midsole yang empuk dan outsole dengan rubber anti slip yang membuat langkahmu semakin leluasa.', 350000, 'assets/product//tzL9vnXklikHi1gVHQ4gUlIjtD1FXaFGy7whcdAe.webp', 5, 'Baru', 5, 20, '2023-03-02 08:50:34', '2023-03-02 09:10:50', NULL);
INSERT INTO `product` VALUES ('449f0511-eb4d-4862-95d3-04952936c773', 'PRD-FRM-002', 'ARKETO BOOTS VINTAGE BROWN BS', 'arketo-boots-vintage-brown-bs', 'Brodo kembali menghadirkan middle-cut boots yang terinspirasi dari siluet sepatu berjenis chukka. Didesain sesuai dengan karakter desain khas Brodo, Arketto dilengkapi outsole Peta Komando yang melegenda.', 750000, 'assets/product//Mbkt4lbVrNWazvIiMy6xLNFJJvdp6FfOdb4JYlsV.webp', 4, 'Baru', 2, 15, '2023-03-02 08:48:59', '2023-03-02 09:10:50', NULL);
INSERT INTO `product` VALUES ('4df2502d-90c2-400b-a4b5-b211ca834748', 'PRD-SPT-004', 'Piero Jogger Black', 'piero-jogger-black', 'Konsep warna yang lebih fresh untuk memberikan kesan ceria pada si pemakai”“Konsep warna yang lebih fresh untuk memberikan kesan ceria pada si pemakai', 280000, 'assets/product//WmteoJAtdwbTjqyPdjsXsBPj8IsR87IC3fZ7Zc7q.jpg', 1, 'Bekas', 3, 5, '2023-02-28 10:07:22', '2023-03-02 04:27:24', NULL);
INSERT INTO `product` VALUES ('53a4d08a-2fa9-45ca-ba31-c9b4c31f9121', 'PRD-SNL-001', 'BROSLIDE SINGLE STRAP FULLL BLACK', 'broslide-single-strap-fulll-black', 'Broslide Single Strap merupakan iterasi dari broslide, menggunakan material nylon yang ringan dengan lining mesh yang breathable menjadikan Broslide Single Strap siap digunakan untuk cuaca apapun, dengan webbing sebagai adjuster dan merepon bentuk dari garis Signore.', 140000, 'assets/product//GNtZ8TuLXUXwdDcCW2vir42iQMT2Ee6KGmPMeBKO.webp', 5, 'Baru', 1, NULL, '2023-03-02 08:49:53', '2023-03-02 08:49:53', NULL);
INSERT INTO `product` VALUES ('859eedd9-e648-4918-9dfd-23b9b59466ce', 'PRD-SND-001', 'Piero Jogger White', 'piero-jogger-white', 'Konsep warna yang lebih fresh untuk memberikan kesan ceria pada si pemakai”“Konsep warna yang lebih fresh untuk memberikan kesan ceria pada si pemakai', 250000, 'assets/product//meU6ViHxcUMiaB2OBr1sy5A6SilKu4SIaB8JHO6E.jpg', 2, 'Baru', 2, 10, '2023-02-28 08:37:50', '2023-03-02 04:22:03', NULL);
INSERT INTO `product` VALUES ('d83294b5-8a1b-492b-910d-00c65d3e9d62', 'PRD-SPT-003', 'Piero Jogger Navy', 'piero-jogger-navy', 'Jogger edisi ulang tahun yang ke-8,dengan konsep eksplorasi kombinasi material unik yang belum pernah dilakukan sebelumnya.', 400000, 'assets/product//fJAUG0aW7np5Ho3mMJMzTHMnuTRt83D2b1ERCdRX.jpg', 1, 'Baru', 2, 8, '2023-02-28 08:51:24', '2023-03-02 04:27:24', NULL);
INSERT INTO `product` VALUES ('f0add435-6ed6-46bb-9954-46e6c025aec6', 'PRD-SPT-002', 'Piero City Core White', 'piero-city-core-white', 'Piero City Core W merupakan koleksi untuk wanita yang terlaris kini hadir dengan warna baru yang kontras untuk memberikan kesan fresh dan youthful. City Core W cocok sekali untuk mewarnai hari-hari pemakai dalam aktivitas apapun. Upper mesh pada sepatu ini memiliki tekstur yang lembut sehingga nyaman dan memberikan sirkulasi udara yang maksimal. Insole City Core W menggunakan Neo Lite Foam dan outsole SNC Foam untuk memberikan ekstra kenyamanan pemakai.', 265000, 'assets/product//oLAJ1oCP1moUHes63FNShyxVVe06Ac2tfqIGynfK.jpg', 1, 'Baru', 3, 10, '2023-02-28 08:38:51', '2023-03-02 04:12:28', NULL);

-- ----------------------------
-- Table structure for stock
-- ----------------------------
DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `in` int NOT NULL,
  `out` int NOT NULL,
  `total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stock_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `stock_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stock
-- ----------------------------
INSERT INTO `stock` VALUES ('340afec0-25ca-4982-b430-19ed72256106', '859eedd9-e648-4918-9dfd-23b9b59466ce', 20, 10, 10, '2023-02-28 15:20:03', '2023-03-02 04:22:03');
INSERT INTO `stock` VALUES ('5f9a3155-55d9-4182-952b-c84f89f4c86b', '449f0511-eb4d-4862-95d3-04952936c773', 20, 5, 15, '2023-03-02 08:57:36', '2023-03-02 09:10:50');
INSERT INTO `stock` VALUES ('6092241f-faca-4f34-b3d0-f87d36e26d81', 'f0add435-6ed6-46bb-9954-46e6c025aec6', 10, 0, 10, '2023-03-02 04:12:28', '2023-03-02 04:12:28');
INSERT INTO `stock` VALUES ('95757e51-c1f7-41b0-94a4-6848b142fefd', '0ad0229b-08d4-43ad-8d00-9e2c3665024b', 50, 5, 45, '2023-03-02 08:57:36', '2023-03-02 08:59:35');
INSERT INTO `stock` VALUES ('d6b61d5f-096d-4c53-9921-f8804eb1083c', 'd83294b5-8a1b-492b-910d-00c65d3e9d62', 10, 2, 8, '2023-03-02 04:12:28', '2023-03-02 04:27:24');
INSERT INTO `stock` VALUES ('da61067a-4878-4039-8596-795dd6f69b9d', '113fb031-b5ac-4593-ba81-32055aec868c', 30, 10, 20, '2023-03-02 08:57:36', '2023-03-02 09:10:50');
INSERT INTO `stock` VALUES ('f5243715-a837-470e-8ee9-ffcb3a14202a', '4df2502d-90c2-400b-a4b5-b211ca834748', 20, 15, 5, '2023-02-28 15:20:03', '2023-03-02 04:27:24');

-- ----------------------------
-- Table structure for stock_detail
-- ----------------------------
DROP TABLE IF EXISTS `stock_detail`;
CREATE TABLE `stock_detail`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('in','out') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `stock_detail_stock_id_foreign`(`stock_id` ASC) USING BTREE,
  CONSTRAINT `stock_detail_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stock_detail
-- ----------------------------
INSERT INTO `stock_detail` VALUES ('03311472-13ba-41cb-9494-6f7660b9586a', 'd6b61d5f-096d-4c53-9921-f8804eb1083c', 'in', 10, 'PO-02032023-002', '2023-03-02 04:12:28', '2023-03-02 04:12:28');
INSERT INTO `stock_detail` VALUES ('0f4d631f-71e5-4a75-8233-aa83d2fbdd3e', 'f5243715-a837-470e-8ee9-ffcb3a14202a', 'out', 1, 'SO-02032023-004', '2023-03-02 04:22:03', '2023-03-02 04:22:03');
INSERT INTO `stock_detail` VALUES ('499596b9-9014-4c11-ae6e-ca068bf35aa5', '340afec0-25ca-4982-b430-19ed72256106', 'out', 2, 'SO-02032023-004', '2023-03-02 04:22:03', '2023-03-02 04:22:03');
INSERT INTO `stock_detail` VALUES ('7ef23b21-b429-43a0-a246-2bd3834fa970', 'da61067a-4878-4039-8596-795dd6f69b9d', 'in', 30, 'PO-02032023-004', '2023-03-02 08:57:36', '2023-03-02 08:57:36');
INSERT INTO `stock_detail` VALUES ('82e2e7bb-c8e9-4f59-a882-ea6eddf390a8', 'f5243715-a837-470e-8ee9-ffcb3a14202a', 'out', 5, 'SO-01032023-001', '2023-03-01 02:58:19', '2023-03-01 02:58:19');
INSERT INTO `stock_detail` VALUES ('8a769b93-4408-45b0-b20c-12db2482d7e8', '340afec0-25ca-4982-b430-19ed72256106', 'out', 5, 'SO-01032023-001', '2023-03-01 02:58:19', '2023-03-01 02:58:19');
INSERT INTO `stock_detail` VALUES ('8dce03d2-a08c-47ca-9e7c-b7896decc33e', '95757e51-c1f7-41b0-94a4-6848b142fefd', 'out', 5, 'SO-02032023-006', '2023-03-02 08:59:35', '2023-03-02 08:59:35');
INSERT INTO `stock_detail` VALUES ('a7d60384-8dcc-44de-b4b0-edcbfbb95d7a', 'f5243715-a837-470e-8ee9-ffcb3a14202a', 'out', 3, 'SO-02032023-005', '2023-03-02 04:27:24', '2023-03-02 04:27:24');
INSERT INTO `stock_detail` VALUES ('c4e76a09-ed52-4f77-8aa8-9c8db54fb5ae', '340afec0-25ca-4982-b430-19ed72256106', 'in', 10, 'PO-28022023-001', '2023-02-28 15:20:03', '2023-02-28 15:20:03');
INSERT INTO `stock_detail` VALUES ('c54c0926-a67b-4b32-b469-6325f96178a9', '340afec0-25ca-4982-b430-19ed72256106', 'out', 1, 'SO-02032023-003', '2023-03-02 03:23:22', '2023-03-02 03:23:22');
INSERT INTO `stock_detail` VALUES ('cc3a70bb-4a74-4e6b-bdd4-00af6e1b0bac', '340afec0-25ca-4982-b430-19ed72256106', 'out', 2, 'SO-01032023-002', '2023-03-01 15:22:38', '2023-03-01 15:22:38');
INSERT INTO `stock_detail` VALUES ('d2e08fa1-9bba-4328-ad97-bd22b6e2fa3e', '340afec0-25ca-4982-b430-19ed72256106', 'in', 10, 'PO-02032023-003', '2023-03-02 04:20:37', '2023-03-02 04:20:37');
INSERT INTO `stock_detail` VALUES ('d635ab57-2493-417e-a7db-3659109129a4', 'f5243715-a837-470e-8ee9-ffcb3a14202a', 'in', 20, 'PO-28022023-001', '2023-02-28 15:20:03', '2023-02-28 15:20:03');
INSERT INTO `stock_detail` VALUES ('e11b70a1-859e-41e1-8f55-4e1be3f02c0b', 'da61067a-4878-4039-8596-795dd6f69b9d', 'out', 5, 'SO-02032023-006', '2023-03-02 08:59:35', '2023-03-02 08:59:35');
INSERT INTO `stock_detail` VALUES ('e897e986-6eeb-49c7-a8c5-346809654d12', '6092241f-faca-4f34-b3d0-f87d36e26d81', 'in', 10, 'PO-02032023-002', '2023-03-02 04:12:28', '2023-03-02 04:12:28');
INSERT INTO `stock_detail` VALUES ('ead58c57-854c-4097-96a4-e64ca1de12be', 'f5243715-a837-470e-8ee9-ffcb3a14202a', 'out', 1, 'SO-01032023-002', '2023-03-01 15:22:38', '2023-03-01 15:22:38');
INSERT INTO `stock_detail` VALUES ('f47b7b4a-f52e-4a89-8368-80a855bf082a', '95757e51-c1f7-41b0-94a4-6848b142fefd', 'in', 50, 'PO-02032023-004', '2023-03-02 08:57:36', '2023-03-02 08:57:36');
INSERT INTO `stock_detail` VALUES ('f58c7dd8-6c10-4cf3-bac5-3b0c7fe91037', 'd6b61d5f-096d-4c53-9921-f8804eb1083c', 'out', 2, 'SO-02032023-005', '2023-03-02 04:27:24', '2023-03-02 04:27:24');
INSERT INTO `stock_detail` VALUES ('f6dc7aa2-1ce0-438a-8711-f27895adace8', 'f5243715-a837-470e-8ee9-ffcb3a14202a', 'out', 5, 'SO-02032023-003', '2023-03-02 03:23:22', '2023-03-02 03:23:22');
INSERT INTO `stock_detail` VALUES ('f79ab3af-f2c0-4fef-b2b2-754b76fb0d6b', '5f9a3155-55d9-4182-952b-c84f89f4c86b', 'in', 20, 'PO-02032023-004', '2023-03-02 08:57:36', '2023-03-02 08:57:36');
INSERT INTO `stock_detail` VALUES ('fc875653-b15c-48d0-a2cc-b1baa36b03c7', '5f9a3155-55d9-4182-952b-c84f89f4c86b', 'out', 5, 'SO-02032023-007', '2023-03-02 09:10:50', '2023-03-02 09:10:50');
INSERT INTO `stock_detail` VALUES ('fcb9bd65-25f1-482b-944d-045e4b90f599', 'da61067a-4878-4039-8596-795dd6f69b9d', 'out', 5, 'SO-02032023-007', '2023-03-02 09:10:50', '2023-03-02 09:10:50');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `role` enum('ADMIN','USER') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', 'admin@admin.com', NULL, NULL, 'ADMIN', NULL, '$2y$10$NhaGvhKddF7JJh3XX6lrFO8uD/7eKTUiAKBcve24fNCXslZEiTHLS', NULL, '2023-02-28 03:46:15', '2023-02-28 03:46:15', NULL);
INSERT INTO `users` VALUES (2, 'Bambang Dariono', 'bambang@gmail.com', '1234567890', 'jalan brantas nomor 88', 'USER', NULL, '$2y$10$lS1qFIo.Ex3yNzPy8qn/AOnU5Zvb6bAhU8jjZJIUQETh6slouioLW', NULL, '2023-02-28 11:11:13', '2023-03-02 02:18:15', NULL);
INSERT INTO `users` VALUES (3, 'Doyok', 'doyok@gmail.com', '12345', 'Jalan Bromo', 'USER', NULL, '$2y$10$uGTjK2n8lm8nqrpB2cnb9eRcfJVlfRHSroqV7XmcBJrBL6rj8XWv.', NULL, '2023-03-01 07:36:30', '2023-03-01 07:36:30', NULL);
INSERT INTO `users` VALUES (4, 'Dani', 'dani@gmail.com', '081234567890', 'Jalan Ikan Tuna', 'USER', NULL, '$2y$10$fb3slSsDM25RCrNlmJTJO.EygybGDMZnKSwRFSV9798DSDWVwlTOC', NULL, '2023-03-02 08:34:30', '2023-03-02 08:34:30', NULL);

SET FOREIGN_KEY_CHECKS = 1;
