CREATE DATABASE IF NOT EXISTS cyber_portal;
USE cyber_portal;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    room VARCHAR(50) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    score INT NOT NULL DEFAULT 0,
    passed TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (full_name, room, username, password, score, passed, created_at)
VALUES ('Administrator', 'Admin', 'admin', '$2y$10$U6FoC7ct8sJmE7B5uRdRse7MZy5/1s3m8J3g5IhH2p9j9gdIOcX32', 100, 1, NOW());
