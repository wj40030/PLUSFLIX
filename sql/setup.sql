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
('Pierwszy przyklad', 'To jest przykladowy opis z bazy danych.'),
('Drugi przyklad', 'Kolejny opis do celow testowych.');

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

CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO genres (name) VALUES
('Dramat'),
('Sci-Fi'),
('Kryminal'),
('Akcja'),
('Horror'),
('Komedia'),
('Fantasy');

CREATE TABLE IF NOT EXISTS productions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    genre_id INT,
    description TEXT,
    year INT,
    rating DECIMAL(3,1),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (genre_id) REFERENCES genres(id)
);

INSERT INTO productions (title, type, genre_id, description, year, rating) VALUES
('Breaking Bad', 'Serial', 1, 'Nauczyciel chemii zmienia sie w producenta metamfetaminy.', 2008, 9.5),
('Stranger Things', 'Serial', 5, 'Grupa dzieci odkrywa tajemnice i nadprzyrodzone wydarzenia w swoim miasteczku.', 2016, 8.7),
('The Shawshank Redemption', 'Film', 1, 'Dwaj wiezniowie zawiazuja wiez przez lata, znajdujac pocieche i ostateczne odkupienie.', 1994, 9.3),
('Inception', 'Film', 2, 'Zlodziej kradnacy sekrety poprzez technologie dzielenia sie snami.', 2010, 8.8),
('The Office', 'Serial', 6, 'Mockument o codziennym zyciu pracownikow biurowych.', 2005, 8.9),
('Pulp Fiction', 'Film', 3, 'Kilka historii przestepcow przeplataja sie w Los Angeles.', 1994, 8.9),
('The Witcher', 'Serial', 7, 'Lowca potworow walczy z plaga w swiecie fantasy.', 2019, 8.8),
('The Dark Knight', 'Film', 4, 'Batman walczy z anarchistycznym przestepca - Jokerem.', 2008, 9.0),
('Game of Thrones', 'Serial', 7, 'Wielkie rody walcza o Zelazny Tron w krainie Westeros.', 2011, 9.2),
('Interstellar', 'Film', 2, 'Podroz przez przestrzen kosmiczna w poszukiwaniu nowego domu dla ludzkosci.', 2014, 8.6),
('Friends', 'Serial', 6, 'Grupa przyjaciol w Nowym Jorku przez wzloty i upadki zycia.', 1994, 8.8),
('The Matrix', 'Film', 2, 'Haker odkrywa prawde o rzeczywistosci i swojej roli w wojnie przeciwko kontrolerom.', 1999, 8.7);
    
CREATE TABLE IF NOT EXISTS ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    production_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    is_approved TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (production_id) REFERENCES productions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS watchlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    production_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (production_id) REFERENCES productions(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, production_id)
);

CREATE TABLE IF NOT EXISTS series (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    genre VARCHAR(100),
    streaming_site VARCHAR(100)
);

INSERT INTO series (title, description, genre, streaming_site) VALUES
('Vox Machina', 'Przykladowa seria 1', 'Fantasy', 'Amazon Prime'),
('The Walking Dead', 'Przykladowa seria 2', 'Horror', 'Netflix');
