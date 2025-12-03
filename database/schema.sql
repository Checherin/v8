-- database/schema.sql - Схема базы данных DEKKO

-- Создание базы данных
CREATE DATABASE IF NOT EXISTS dekko_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dekko_app;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица заявок
CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    furniture_type VARCHAR(50) NOT NULL,
    material VARCHAR(50) NOT NULL,
    comment TEXT,
    status TINYINT(1) DEFAULT 1 COMMENT '1-на рассмотрении, 2-одобрено, 3-отклонено',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Создание админа по умолчанию (логин: admin, пароль: admin)
INSERT INTO users (login, password, name, email, phone, is_admin) 
VALUES ('admin', 'admin', 'Администратор', 'admin@dekko.ru', '+7 (000) 000-00-00', 1);

-- Создание тестового пользователя (логин: user, пароль: user)
INSERT INTO users (login, password, name, email, phone, is_admin) 
VALUES ('user', 'user', 'Тестовый пользователь', 'user@dekko.ru', '+7 (111) 111-11-11', 0);