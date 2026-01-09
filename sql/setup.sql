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

-- Tabela uzytkownikow
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dodanie kont: user i admin
INSERT INTO users (username, password, role) VALUES
('user', 'user', 'user'),
('admin', 'tajne', 'admin');

-- Tabela gatunkow
CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genre VARCHAR(50) NOT NULL
);

-- Przykladowe gatunki
INSERT INTO genres (genre) VALUES
('Animation'),
('Horror');

-- Tabela platform streamingowych
CREATE TABLE IF NOT EXISTS streaming_sites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  streaming_site VARCHAR(50) NOT NULL
);

-- Przykladowe platformy streamingowe
INSERT INTO streaming_sites (streaming_site) VALUES
('Netflix'),
('Prime Video');

-- Tabela serii
CREATE TABLE IF NOT EXISTS series (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    genre INT,
    streaming_site INT,
    FOREIGN KEY (genre) REFERENCES genres(id),
    FOREIGN KEY (streaming_site) REFERENCES streaming_sites(id)
);

-- Przykladowe serie
INSERT INTO series (title, description, genre, streaming_site) VALUES
('Vox Machina', 'Przykładowa seria 1', 1, 2),
('The Walking Dead', 'Przykładowa seria 2', 2, 1);