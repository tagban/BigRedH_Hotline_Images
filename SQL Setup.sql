-- BigRedH Media Bridge Database Schema
-- Version 1.1

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Table for tracking image uploads
CREATE TABLE IF NOT EXISTS `media_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `uploader_ip` varchar(45) NOT NULL,
  `client_id` varchar(50) DEFAULT 'Unknown',
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uploader_ip_idx` (`uploader_ip`),
  KEY `client_id_idx` (`client_id`),
  KEY `expiry_idx` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for moderation and security
CREATE TABLE IF NOT EXISTS `banned_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) NOT NULL,
  `type` enum('IP','USER') NOT NULL DEFAULT 'IP',
  `reason` text DEFAULT NULL,
  `banned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;