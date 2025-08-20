```sql
CREATE TABLE `payments`
(
    `id`           int(11) NOT NULL AUTO_INCREMENT,
    `payment_id`   varchar(100)   NOT NULL,
    `amount`       decimal(10, 2) NOT NULL,
    `currency`     varchar(10)  DEFAULT 'USD',
    `status`       enum('pending','completed','failed','expired') DEFAULT 'pending',
    `user_session` varchar(100) DEFAULT NULL,
    `qr_code_data` text,
    `created_at`   timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `payment_id` (`payment_id`),
    KEY            `status` (`status`),
    KEY            `user_session` (`user_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```