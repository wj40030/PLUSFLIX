CREATE DATABASE IF NOT EXISTS plusflix;
USE plusflix;

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

CREATE TABLE IF NOT EXISTS streaming_platforms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2),
    offer TEXT
    );

INSERT INTO streaming_platforms (name, price, offer) VALUES
('Netflix', 43.00, '4K, 4 Ekrany'),
('Prime Video', 10.99, 'Darmowa dostawa, Video, Gaming');

CREATE TABLE IF NOT EXISTS productions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    genre_id INT,
    description TEXT,
    streaming_platforms_id INT,
    year INT,
    rating DECIMAL(3,1),
    watchlist_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (genre_id) REFERENCES genres(id),
    FOREIGN KEY (streaming_platforms_id) REFERENCES streaming_platforms(id)
    );

INSERT INTO productions (title, type, genre_id, description, streaming_platforms_id, year, rating, watchlist_count) VALUES
('Breaking Bad', 'Serial', 1, 'Nauczyciel chemii zmienia sie w producenta metamfetaminy.', 1, 2008, 9.5, 100),
('Stranger Things', 'Serial', 5, 'Grupa dzieci odkrywa tajemnice i nadprzyrodzone wydarzenia w swoim miasteczku.', 1, 2016, 8.7, 25),
('The Shawshank Redemption', 'Film', 1, 'Dwaj wiezniowie zawiazuja wiez przez lata, znajdujac pocieche i ostateczne odkupienie.', 2, 1994, 9.3, 45),
('Inception', 'Film', 2, 'Zlodziej kradnacy sekrety poprzez technologie dzielenia sie snami.', 2, 2010, 8.8, 65),
('The Office', 'Serial', 6, 'Mockument o codziennym zyciu pracownikow biurowych.', 1, 2005, 8.9, 120),
('Pulp Fiction', 'Film', 3, 'Kilka historii przestepcow przeplataja sie w Los Angeles.', 1, 1994, 8.9, 15),
('The Witcher', 'Serial', 7, 'Lowca potworow walczy z plaga w swiecie fantasy.', 2, 2019, 8.8, 50),
('The Dark Knight', 'Film', 4, 'Batman walczy z anarchistycznym przestepca - Jokerem.', 1, 2008, 9.0, 34),
('Game of Thrones', 'Serial', 7, 'Wielkie rody walcza o Zelazny Tron w krainie Westeros.', 2, 2011, 9.2, 60),
('Interstellar', 'Film', 2, 'Podroz przez przestrzen kosmiczna w poszukiwaniu nowego domu dla ludzkosci.', 2, 2014, 8.6, 70),
('Friends', 'Serial', 6, 'Grupa przyjaciol w Nowym Jorku przez wzloty i upadki zycia.', 2, 1994, 8.8, 50),
('The Matrix', 'Film', 2, 'Haker odkrywa prawde o rzeczywistosci i swojej roli w wojnie przeciwko kontrolerom.', 1, 1999, 8.7, 50);

CREATE TABLE IF NOT EXISTS watchlist (
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         user_id INT NOT NULL,
                                         production_id INT NOT NULL,
                                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                         FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (production_id) REFERENCES productions(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, production_id)
    );

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
