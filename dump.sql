CREATE DATABASE IF NOT EXISTS banner_tracking DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE banner_tracking;

CREATE TABLE IF NOT EXISTS banner_views (
    id VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_bin PRIMARY KEY,
    ip_address BIGINT UNSIGNED,
    user_agent VARCHAR(191),
    view_date DATETIME,
    page_url VARCHAR(191),
    views_count INT UNSIGNED DEFAULT 0
);
