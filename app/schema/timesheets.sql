drop table if exists hr_time_sheets;
CREATE TABLE `hr_time_sheets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `duration` smallint(6) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL COMMENT 'add here if timesheet is late has ot etc',
  `status` enum('pending','approved','cancelled') DEFAULT 'approved',
  `approved_by` int(10) DEFAULT NULL,
  `type` char(20) DEFAULT 'automatic' COMMENT 'manual is sent via form',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  `is_ot` tinyint(1) DEFAULT 0,
  `flushed_hours` int(11) DEFAULT NULL COMMENT 'in minutes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64711 DEFAULT CHARSET=utf8mb4;



CREATE TABLE `user_meta` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `domain` smallint(6) DEFAULT NULL,
  `domain_user_token` varchar(100) DEFAULT NULL,
  `rate_per_hour` decimal(10,2) DEFAULT NULL,
  `rate_per_day` decimal(10,2) DEFAULT NULL,
  `work_hours` decimal(10,2) DEFAULT NULL,
  `max_work_hours` decimal(10,2) DEFAULT NULL,
  `bk_username` varchar(50) DEFAULT NULL,
  `weekly_max_earning` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8mb4;