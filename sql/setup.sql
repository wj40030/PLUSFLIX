CREATE DATABASE IF NOT EXISTS plusflix;
USE plusflix;

-- Tabela examples
CREATE TABLE IF NOT EXISTS examples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Przykładowe dane
INSERT INTO examples (title, description) VALUES 
('Pierwszy przykład', 'To jest przykładowy opis z bazy danych.'),
('Drugi przykład', 'Kolejny opis do celów testowych.');