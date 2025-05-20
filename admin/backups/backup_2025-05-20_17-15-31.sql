-- Database Backup
-- Generated: 2025-05-20 17:15:31
-- Database: u283492965_nailarchidb

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- Table structure for table `2fa_attempts`
DROP TABLE IF EXISTS `2fa_attempts`;
CREATE TABLE `2fa_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `success` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `admin_id` (`admin_id`),
  KEY `idx_attempt_time` (`attempt_time`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `2fa_attempts`
INSERT INTO `2fa_attempts` VALUES ('1', '7', NULL, '::1', '2025-05-15 17:14:13', '1');
INSERT INTO `2fa_attempts` VALUES ('2', '6', NULL, '::1', '2025-05-15 22:16:51', '1');
INSERT INTO `2fa_attempts` VALUES ('3', '0', NULL, '2001:4450:4fe8:6000:e823:e580:6adb:4d7d', '2025-05-16 18:22:48', '1');
INSERT INTO `2fa_attempts` VALUES ('4', '0', NULL, '175.176.40.5', '2025-05-17 00:30:11', '1');
INSERT INTO `2fa_attempts` VALUES ('5', '0', NULL, '175.176.40.244', '2025-05-17 03:39:55', '1');
INSERT INTO `2fa_attempts` VALUES ('6', '0', NULL, '2001:fd8:1801:dbfe:6880:5356:aa93:abe1', '2025-05-17 09:28:47', '1');
INSERT INTO `2fa_attempts` VALUES ('7', '0', NULL, '175.176.41.123', '2025-05-20 01:13:53', '1');
INSERT INTO `2fa_attempts` VALUES ('8', '0', NULL, '152.32.99.180', '2025-05-20 08:14:19', '1');
INSERT INTO `2fa_attempts` VALUES ('9', '0', NULL, '152.32.99.180', '2025-05-20 08:56:43', '1');
INSERT INTO `2fa_attempts` VALUES ('10', '0', NULL, '152.32.99.180', '2025-05-20 09:01:49', '1');


-- Table structure for table `admin_users`
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','super_admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `mfa_verified_session` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `admin_users`
INSERT INTO `admin_users` VALUES ('1', 'admin', 'admin@nailarchitect.com', '$2y$10$ZF0Zi5NUyMc3uOjaZKr16uPA3JIHsDVK7eBSEJWLVlyN82I1nknnK', 'Admin', 'User', '09123456789', 'super_admin', '2025-05-12 17:35:49', '2025-05-20 08:44:58', '1', NULL);
INSERT INTO `admin_users` VALUES ('2', 'kuznets', 'kuznets.calleja@gmail.com', '$2y$10$631IoFLO9kn/0D1Mz1CLSeSAwy0Ih2TCVKp0h8N8xlTxJulnceOtG', 'Lele', 'Coy', '12312312312', 'admin', '2025-05-13 09:52:40', '2025-05-14 14:44:26', '1', NULL);


-- Table structure for table `booking_images`
DROP TABLE IF EXISTS `booking_images`;
CREATE TABLE `booking_images` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `booking_images`
INSERT INTO `booking_images` VALUES ('2', '2', 'uploads/inspirations/NAI-8455408_0_ballot.png');
INSERT INTO `booking_images` VALUES ('3', '3', 'uploads/inspirations/NAI-1939264_0_send.png');
INSERT INTO `booking_images` VALUES ('4', '4', 'uploads/inspirations/NAI-3229037_0_send.png');
INSERT INTO `booking_images` VALUES ('5', '8', 'uploads/inspirations/NAI-9689707_0_mdi_vote.png');
INSERT INTO `booking_images` VALUES ('6', '9', 'uploads/inspirations/NAI-6387058_0_asdasdasd.jpg');
INSERT INTO `booking_images` VALUES ('7', '10', 'uploads/inspirations/NAI-7501589_0_login4.png');
INSERT INTO `booking_images` VALUES ('8', '10', 'uploads/inspirations/NAI-7501589_1_133886785738657170.jpg');
INSERT INTO `booking_images` VALUES ('9', '11', 'uploads/inspirations/NAI-2647751_0_80e99433-7615-4b0f-8e9d-a0ec58dfe0fa-XXX_D07G1PAT13_20P6X18LINES.webp');


-- Table structure for table `bookings`
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `service` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `notes` text DEFAULT NULL,
  `technician` varchar(50) DEFAULT 'TBD',
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `reference_id` varchar(20) NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `bookings`
INSERT INTO `bookings` VALUES ('2', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'press-ons', '2025-05-13', '14:00', 'hehe', 'TBD', '45', '300.00', '0', 'cancelled', '2025-05-11 10:53:10');
INSERT INTO `bookings` VALUES ('3', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'other', '2025-05-14', '14:00', 'asdasd', 'TBD', '60', '500.00', 'NAI-1939264', 'confirmed', '2025-05-11 10:59:02');
INSERT INTO `bookings` VALUES ('4', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'soft-gel', '2025-05-15', '14:00', 'asdasd', 'TBD', '60', '800.00', 'NAI-3229037', 'cancelled', '2025-05-11 11:02:29');
INSERT INTO `bookings` VALUES ('5', '6', 'Berlin Dela Cruz', 'maeracreation@gmail.com', '123187237612', 'other', '2025-05-12', '10:00', '', 'TBD', '60', '500.00', 'NAI-2981935', 'completed', '2025-05-11 13:32:58');
INSERT INTO `bookings` VALUES ('6', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'soft-gel', '2025-05-12', '15:00', '', 'TBD', '60', '800.00', 'NAI-9264289', 'completed', '2025-05-11 13:35:29');
INSERT INTO `bookings` VALUES ('7', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'builder-gel', '2025-05-12', '18:00', '', 'TBD', '60', '750.00', 'NAI-3070252', 'confirmed', '2025-05-11 14:03:34');
INSERT INTO `bookings` VALUES ('8', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'removal-fill', '2025-05-17', '11:00', 'wazzup', 'TBD', '30', '150.00', 'NAI-9689707', 'confirmed', '2025-05-11 16:40:38');
INSERT INTO `bookings` VALUES ('9', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'builder-gel', '2025-05-14', '15:00', '', 'TBD', '60', '750.00', 'NAI-6387058', 'confirmed', '2025-05-12 00:29:43');
INSERT INTO `bookings` VALUES ('10', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'soft-gel', '2025-05-14', '16:00', 'hehe', 'TBD', '60', '800.00', 'NAI-7501589', 'pending', '2025-05-12 11:13:38');
INSERT INTO `bookings` VALUES ('11', '7', 'Tapuu Lelee', 'angcuteko213@gmail.com', '09491145757', 'menicure', '2025-05-29', '14:00', 'hello', 'TBD', '45', '400.00', 'NAI-2647751', 'cancelled', '2025-05-14 05:44:18');


-- Table structure for table `chat_conversations`
DROP TABLE IF EXISTS `chat_conversations`;
CREATE TABLE `chat_conversations` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table structure for table `chat_messages`
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_type` enum('admin','user') NOT NULL,
  `message` text NOT NULL,
  `has_attachment` tinyint(1) NOT NULL DEFAULT 0,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `conversation_id` (`conversation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table structure for table `inquiries`
DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','responded') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_email` (`email`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_subject` (`subject`),
  FULLTEXT KEY `ft_message` (`message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `inquiries`
INSERT INTO `inquiries` VALUES ('3', 'Anna', 'Reyes', 'anna.reyes@email.com', '09369871234', 'General Inquiry', 'I love your work! Do you have any ongoing promotions or packages for regular clients?', 'responded', '2025-05-13 20:07:53', '2025-05-13 20:07:53');
INSERT INTO `inquiries` VALUES ('4', 'Patricia', 'Garcia', 'patricia.g@email.com', NULL, 'Feedback', 'Just wanted to say thank you for the amazing service last week. My nails still look perfect!', 'responded', '2025-05-13 20:07:53', '2025-05-13 20:07:53');
INSERT INTO `inquiries` VALUES ('7', 'aaa', '', 'bondoc.aaliyah.b@gmail.com', '123187237612', 'services', 'asdasdas', 'read', '2025-05-13 20:19:21', '2025-05-14 06:08:49');
INSERT INTO `inquiries` VALUES ('8', 'sdasd', '', 'admin@nailarchitect.com', '0987655323', 'general', 'sdasda', 'read', '2025-05-13 20:19:34', '2025-05-13 20:38:50');
INSERT INTO `inquiries` VALUES ('9', 'aaa', '', 'admin@nailarchitect.com', '123187237612', 'general', 'sadasd', 'read', '2025-05-13 20:19:44', '2025-05-13 20:25:57');


-- Table structure for table `message_attachments`
DROP TABLE IF EXISTS `message_attachments`;
CREATE TABLE `message_attachments` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `message_attachments`
INSERT INTO `message_attachments` VALUES ('3', '19', 'HELLO.png', 'uploads/messages/682010b957cef_HELLO.png', '1883', 'image/png', '2025-05-11 10:51:37');
INSERT INTO `message_attachments` VALUES ('4', '23', 'asdasdasd.jpg', 'uploads/messages/6821b2e771c2a_asdasdasd.jpg', '52413', 'image/jpeg', '2025-05-12 16:35:51');


-- Table structure for table `messages`
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ID of the user this message belongs to',
  `sender_id` int(11) DEFAULT NULL COMMENT 'ID of the sender (user ID or NULL for salon)',
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `has_attachment` tinyint(1) NOT NULL DEFAULT 0,
  `read_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = unread, 1 = read',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `messages`
INSERT INTO `messages` VALUES ('3', '6', '6', 'asda', 'asdasd', '0', '1', '2025-05-04 15:27:35');
INSERT INTO `messages` VALUES ('4', '6', '6', 'hello', '123123', '0', '1', '2025-05-04 09:48:27');
INSERT INTO `messages` VALUES ('5', '6', '6', 'Re: Salon Conversation', 'hi', '0', '0', '2025-05-05 03:48:36');
INSERT INTO `messages` VALUES ('6', '6', '6', 'Re: Salon Conversation', 'meow meow meow\\r\\n', '0', '0', '2025-05-05 03:48:46');
INSERT INTO `messages` VALUES ('7', '6', '6', 'Re: Salon Conversation', 'meow meow', '0', '0', '2025-05-05 03:48:53');
INSERT INTO `messages` VALUES ('8', '6', '6', 'Re: Salon Conversation', 'asdafasdf ', '0', '0', '2025-05-05 03:48:56');
INSERT INTO `messages` VALUES ('9', '6', NULL, 'Re: Re: Salon Conversation', 'hi', '0', '1', '2025-05-05 05:12:26');
INSERT INTO `messages` VALUES ('10', '6', NULL, 'test', 'hey', '0', '1', '2025-05-05 05:13:12');
INSERT INTO `messages` VALUES ('11', '6', NULL, 'Nail Architect', 'hi\r\n', '0', '1', '2025-05-05 05:16:19');
INSERT INTO `messages` VALUES ('17', '7', '7', 'Test', 'asdasd', '0', '0', '2025-05-05 10:13:59');
INSERT INTO `messages` VALUES ('18', '7', NULL, 'Nail Architect', 'niggus', '0', '1', '2025-05-05 10:14:09');
INSERT INTO `messages` VALUES ('19', '7', '7', 'Re: Salon Conversation', 'hi', '1', '0', '2025-05-11 04:51:37');
INSERT INTO `messages` VALUES ('20', '7', '7', 'Re: Salon Conversation', 'hi', '0', '0', '2025-05-12 10:28:29');
INSERT INTO `messages` VALUES ('21', '7', '7', 'Re: Salon Conversation', 'hello', '0', '0', '2025-05-12 10:29:15');
INSERT INTO `messages` VALUES ('22', '7', NULL, 'Nail Architect', 'hello', '0', '1', '2025-05-12 10:29:38');
INSERT INTO `messages` VALUES ('23', '7', '7', 'Re: Salon Conversation', 'asdasd', '1', '0', '2025-05-12 10:35:51');
INSERT INTO `messages` VALUES ('24', '7', '7', 'Live Chat Request', 'I\\\'d like to chat with a live agent please.', '0', '0', '2025-05-12 10:50:00');
INSERT INTO `messages` VALUES ('25', '7', '7', 'Chat Widget Message', 'hi', '0', '0', '2025-05-12 10:50:05');
INSERT INTO `messages` VALUES ('26', '7', NULL, 'Nail Architect', 'hello', '0', '1', '2025-05-12 10:50:15');
INSERT INTO `messages` VALUES ('27', '7', NULL, 'Nail Architect', 'wazzup', '0', '1', '2025-05-12 10:50:32');
INSERT INTO `messages` VALUES ('28', '7', '7', 'Chat Widget Message', 'hehe', '0', '0', '2025-05-12 10:56:28');
INSERT INTO `messages` VALUES ('29', '7', '7', 'Chat Widget Message', 'hey', '0', '0', '2025-05-12 10:57:53');
INSERT INTO `messages` VALUES ('30', '7', NULL, 'Nail Architect', '123', '0', '1', '2025-05-12 10:58:02');
INSERT INTO `messages` VALUES ('31', '7', NULL, 'Nail Architect', '123123', '0', '1', '2025-05-12 10:58:26');


-- Table structure for table `password_resets`
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`),
  KEY `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `password_resets`
INSERT INTO `password_resets` VALUES ('0', '6', '2a1e3b4902d2e358ecdd6dd509816606d72d98c778e1b71caf00fdb4d35909a9', '2025-05-17 01:25:40', '2025-05-17 00:25:40');


-- Table structure for table `payment_proofs`
DROP TABLE IF EXISTS `payment_proofs`;
CREATE TABLE `payment_proofs` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `payment_proofs`
INSERT INTO `payment_proofs` VALUES ('2', '2', 'uploads/payments/NAI-8455408_ballot.png', '2025-05-11 10:53:10');
INSERT INTO `payment_proofs` VALUES ('3', '3', 'uploads/payments/NAI-1939264_logout.png', '2025-05-11 10:59:02');
INSERT INTO `payment_proofs` VALUES ('4', '4', 'uploads/payments/NAI-3229037_send.png', '2025-05-11 11:02:29');
INSERT INTO `payment_proofs` VALUES ('5', '5', 'uploads/payments/NAI-2981935_asdasdasd.jpg', '2025-05-11 13:32:58');
INSERT INTO `payment_proofs` VALUES ('6', '6', 'uploads/payments/NAI-9264289_logout.png', '2025-05-11 13:35:29');
INSERT INTO `payment_proofs` VALUES ('7', '7', 'uploads/payments/NAI-3070252_mdi_vote.png', '2025-05-11 14:03:34');
INSERT INTO `payment_proofs` VALUES ('8', '8', 'uploads/payments/NAI-9689707_HELLO.png', '2025-05-11 16:40:38');
INSERT INTO `payment_proofs` VALUES ('9', '9', 'uploads/payments/NAI-6387058_asdasdasd.jpg', '2025-05-12 00:29:43');
INSERT INTO `payment_proofs` VALUES ('10', '10', 'uploads/payments/NAI-7501589_login3.png', '2025-05-12 11:13:38');
INSERT INTO `payment_proofs` VALUES ('11', '11', 'uploads/payments/NAI-2647751_111.png', '2025-05-14 05:44:18');


-- Table structure for table `user_2fa`
DROP TABLE IF EXISTS `user_2fa`;
CREATE TABLE `user_2fa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `secret` varchar(32) NOT NULL,
  `enabled` tinyint(1) DEFAULT 0,
  `backup_codes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user` (`user_id`),
  UNIQUE KEY `unique_admin` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `user_2fa`
INSERT INTO `user_2fa` VALUES ('0', '0', NULL, 'EZRD52MFL2NDX3TJ', '1', '[\"04A3BCB4\",\"6BEBF49A\",\"AA7B4FDD\",\"45AB7985\",\"3062BD02\",\"83E11C6E\",\"F96C3D3B\"]', '2025-05-16 18:21:55', '2025-05-20 08:16:43');
INSERT INTO `user_2fa` VALUES ('1', '7', NULL, 'YZZLJTJU2474GI5O', '1', '[\"61AB1228\",\"A80FCB1E\",\"9169C069\",\"AE70EE89\",\"21A4521F\",\"EE8E8897\",\"BD9A0D5E\",\"470AF857\"]', '2025-05-15 17:08:30', '2025-05-15 17:08:30');
INSERT INTO `user_2fa` VALUES ('2', '6', NULL, '73A4SR7LTEMOQO7Z', '1', '[\"D2453BAE\",\"F7A83E4B\",\"5759C71E\",\"3B3DCA06\",\"B58B804F\",\"9D9AEBC1\",\"73049697\",\"904E7103\"]', '2025-05-15 22:15:00', '2025-05-15 22:15:30');


-- Table structure for table `user_profile_history`
DROP TABLE IF EXISTS `user_profile_history`;
CREATE TABLE `user_profile_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `old_first_name` varchar(50) NOT NULL,
  `old_last_name` varchar(50) NOT NULL,
  `old_email` varchar(100) NOT NULL,
  `old_phone` varchar(20) NOT NULL,
  `new_first_name` varchar(50) NOT NULL,
  `new_last_name` varchar(50) NOT NULL,
  `new_email` varchar(100) NOT NULL,
  `new_phone` varchar(20) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `changed_by` int(11) DEFAULT NULL COMMENT 'Who made the change (user_id or admin_id)',
  `update_past_records` tinyint(1) DEFAULT 0 COMMENT '1 if past records were updated',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `changed_at` (`changed_at`),
  KEY `idx_user_changed` (`user_id`,`changed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `mfa_verified_session` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email_token` (`email`,`verification_token`),
  KEY `idx_is_verified` (`is_verified`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_full_name` (`first_name`,`last_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `users`
INSERT INTO `users` VALUES ('0', 'Aa', 'adsas', 'aaliyah04bondoc@gmail.com', '00972376152', '$2y$10$lPtxG/U4TLZllojP/N3czOavxVBAZr8kXywkZcHAGE1tGHXZ8yRVa', '2025-05-16 17:34:48', NULL, '2025-05-17 17:34:48', '1', NULL);
INSERT INTO `users` VALUES ('2', 'Lele', 'Lele', 'cutie@gmail.com', '12312312', '$2y$10$SDHocuC7BeFd8./xbmfVXeQHmlSOZneuAFVlB/qnX2dKRbZ7d6SMG', '2025-04-26 15:14:59', NULL, NULL, '0', NULL);
INSERT INTO `users` VALUES ('4', 'Jez', 'Ariel Pogi', 'jezariel13@gmail.com', '123187237612', '$2y$10$xWQi8Dg5Dm8.vizhjEuMG.lU4ADOm8zyUMEtrVcJbYHIoDsx789j.', '2025-05-04 13:53:17', '041c3ab4200b468a70718edeced32de6', '2025-05-05 07:53:17', '0', NULL);
INSERT INTO `users` VALUES ('7', 'Tapuu', 'Lelee', 'angcuteko213@gmail.com', '09491145757', '$2y$10$S6znDhcFruas5UbaKeJODOqx8kK07r9zgFsyIbmd3FAISMNLUpRC6', '2025-05-05 15:15:17', NULL, '2025-05-13 09:58:46', '1', NULL);

