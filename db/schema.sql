CREATE DATABASE IF NOT EXISTS fanza CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fanza;

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_id VARCHAR(64) NOT NULL UNIQUE,
    product_id VARCHAR(64) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    url TEXT,
    affiliate_url TEXT,
    image_list TEXT,
    image_small TEXT,
    image_large TEXT,
    date_published DATETIME DEFAULT NULL,
    service_code VARCHAR(64) DEFAULT NULL,
    floor_code VARCHAR(64) DEFAULT NULL,
    category_name VARCHAR(128) DEFAULT NULL,
    price_min INT DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_items_date (date_published)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS actresses (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ruby VARCHAR(255) DEFAULT NULL,
    bust INT DEFAULT NULL,
    cup VARCHAR(32) DEFAULT NULL,
    waist INT DEFAULT NULL,
    hip INT DEFAULT NULL,
    height INT DEFAULT NULL,
    birthday DATE DEFAULT NULL,
    blood_type VARCHAR(32) DEFAULT NULL,
    hobby TEXT DEFAULT NULL,
    prefectures VARCHAR(255) DEFAULT NULL,
    image_small TEXT,
    image_large TEXT,
    listurl_digital TEXT,
    listurl_monthly TEXT,
    listurl_mono TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS genres (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ruby VARCHAR(255) DEFAULT NULL,
    list_url TEXT,
    site_code VARCHAR(64) DEFAULT NULL,
    service_code VARCHAR(64) DEFAULT NULL,
    floor_id VARCHAR(64) DEFAULT NULL,
    floor_code VARCHAR(64) DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS makers (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ruby VARCHAR(255) DEFAULT NULL,
    list_url TEXT,
    site_code VARCHAR(64) DEFAULT NULL,
    service_code VARCHAR(64) DEFAULT NULL,
    floor_id VARCHAR(64) DEFAULT NULL,
    floor_code VARCHAR(64) DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS series (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ruby VARCHAR(255) DEFAULT NULL,
    list_url TEXT,
    site_code VARCHAR(64) DEFAULT NULL,
    service_code VARCHAR(64) DEFAULT NULL,
    floor_id VARCHAR(64) DEFAULT NULL,
    floor_code VARCHAR(64) DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS item_actresses (
    content_id VARCHAR(64) NOT NULL,
    actress_id BIGINT NOT NULL,
    PRIMARY KEY (content_id, actress_id),
    INDEX idx_item_actresses_actress (actress_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS item_genres (
    content_id VARCHAR(64) NOT NULL,
    genre_id INT NOT NULL,
    PRIMARY KEY (content_id, genre_id),
    INDEX idx_item_genres_genre (genre_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS item_makers (
    content_id VARCHAR(64) NOT NULL,
    maker_id INT NOT NULL,
    PRIMARY KEY (content_id, maker_id),
    INDEX idx_item_makers_maker (maker_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS item_series (
    content_id VARCHAR(64) NOT NULL,
    series_id INT NOT NULL,
    PRIMARY KEY (content_id, series_id),
    INDEX idx_item_series_series (series_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS item_labels (
    content_id VARCHAR(64) NOT NULL,
    label_id INT DEFAULT NULL,
    label_name VARCHAR(255) NOT NULL,
    label_ruby VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (content_id, label_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS import_state (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(32) NOT NULL,
    last_offset INT NOT NULL DEFAULT 1,
    last_param VARCHAR(255) DEFAULT NULL,
    updated_at DATETIME NOT NULL,
    UNIQUE KEY uniq_import_state_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
