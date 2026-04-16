SET NAMES utf8mb4;

CREATE USER IF NOT EXISTS 'p-351366_php-docker'@'%' IDENTIFIED BY 'Anna-140275';
GRANT ALL PRIVILEGES ON `p-351366_php-docker`.* TO 'p-351366_php-docker'@'%';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO users (name, email) VALUES
('Иван Иванов', 'ivan@example.com'),
('Мария Петрова', 'maria@example.com');
