<?php

namespace App\Models;

use Core\Model;
use Core\Database;

class Movie extends Model {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->table = 'productions';
    }

    public function getAllMovies() {
        $this->db->query('SELECT id FROM productions');
        $movies = $this->db->resultSet();
        foreach($movies as $movie) {
            $this->updateSingleMovieRating($movie->id);
        }

        $this->db->query('SELECT p.*, g.name as genre, sp.name as streaming_platforms FROM productions p LEFT JOIN genres g ON p.genre_id = g.id LEFT JOIN streaming_platforms sp ON p.streaming_platforms_id = sp.id ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    public function searchMovies($searchTerm) {
        $this->db->query('SELECT productions.*, genres.name as genre, sp.name as streaming_platforms FROM productions LEFT JOIN genres ON productions.genre_id = genres.id LEFT JOIN streaming_platforms sp ON p.streaming_platforms_id = sp.id WHERE productions.title LIKE :search OR productions.description LIKE :search OR genres.name LIKE :search ORDER BY productions.rating DESC');
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }

    public function filterMovies($genre, $streamingPlatforms) {
        $sql = 'SELECT p.*, g.name as genre, sp.name as streaming_platforms 
                FROM productions p 
                LEFT JOIN genres g ON p.genre_id = g.id 
                LEFT JOIN streaming_platforms sp ON p.streaming_platforms_id = sp.id 
                WHERE 1=1';
        
        if (!empty($genre)) {
            $sql .= ' AND p.genre_id = :genre';
        }
        
        if (!empty($streamingPlatforms)) {
            $sql .= ' AND p.streaming_platforms_id = :streamingPlatforms';
        }
        
        $sql .= ' ORDER BY p.rating DESC';
        
        $this->db->query($sql);
        
        if (!empty($genre)) {
            $this->db->bind(':genre', $genre);
        }
        
        if (!empty($streamingPlatforms)) {
            $this->db->bind(':streamingPlatforms', $streamingPlatforms);
        }
        
        return $this->db->resultSet();
    }

    public function getMovieById($id) {
        // Przelicz ocenę przed pobraniem szczegółów, aby mieć pewność, że jest aktualna
        $this->updateSingleMovieRating($id);
        $this->db->query('SELECT p.*, g.name as genre FROM productions p LEFT JOIN genres g ON p.genre_id = g.id WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    private function updateSingleMovieRating($id) {
        $this->db->query('SELECT AVG(rating) as avg_rating FROM ratings WHERE production_id = :production_id AND is_approved = 1');
        $this->db->bind(':production_id', $id);
        $row = $this->db->single();
        
        $avgRating = ($row && $row->avg_rating !== null) ? round($row->avg_rating, 1) : 0;
        
        $this->db->query('UPDATE productions SET rating = :rating WHERE id = :id');
        $this->db->bind(':rating', $avgRating);
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function getMoviesByGenre($genre) {
        $this->db->query('SELECT productions.*, genres.name as genre FROM productions LEFT JOIN genres ON productions.genre_id = genres.id WHERE genres.name = :genre ORDER BY productions.rating DESC');
        $this->db->bind(':genre', $genre);
        return $this->db->resultSet();
    }

    public function getRandomMovie() {
        $this->db->query('SELECT id FROM productions ORDER BY RAND() LIMIT 1');
        $movie = $this->db->single();
        if ($movie) {
            $this->updateSingleMovieRating($movie->id);
            return $this->getMovieById($movie->id);
        }
        return null;
    }

    public function addToWatchlist($userId, $movieId) {
        $this->db->query('INSERT IGNORE INTO watchlist (user_id, production_id) VALUES (:user_id, :production_id)');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':production_id', $movieId);
        return $this->db->execute();
    }

    public function removeFromWatchlist($userId, $movieId) {
        $this->db->query('DELETE FROM watchlist WHERE user_id = :user_id AND production_id = :production_id');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':production_id', $movieId);
        return $this->db->execute();
    }

    public function getWatchlist($userId) {
        $this->db->query('SELECT p.*, g.name as genre 
                          FROM productions p 
                          JOIN watchlist w ON p.id = w.production_id 
                          LEFT JOIN genres g ON p.genre_id = g.id 
                          WHERE w.user_id = :user_id 
                          ORDER BY w.created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function isInWatchlist($userId, $movieId) {
        $this->db->query('SELECT * FROM watchlist WHERE user_id = :user_id AND production_id = :production_id');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':production_id', $movieId);
        $this->db->single();
        return $this->db->rowCount() > 0;
    }
    public function addMovie($data) {
        $this->db->query('INSERT INTO productions (title, type, genre_id, description, streaming_platforms_id, year, rating) VALUES (:title, :type, :genre_id, :description, :streaming_platforms_id, :year, :rating)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':genre_id', $data['genre_id']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':streaming_platforms_id', $data['streaming_platforms_id']);
        $this->db->bind(':year', $data['year']);
        $this->db->bind(':rating', 0);
        return $this->db->execute();
    }

    public function deleteMovie($id) {
        $this->db->query('DELETE FROM productions WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function updateMovie($id, $data) {
        $this->db->query('UPDATE productions SET title = :title, type = :type, genre_id = :genre_id, description = :description, streaming_platforms_id = :streaming_platforms_id, year = :year WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':genre_id', $data['genre_id']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':streaming_platforms_id', $data['streaming_platforms_id']);
        $this->db->bind(':year', $data['year']);
        return $this->db->execute();
    }
    public function getMoviesWithPagination($limit, $offset) {
        $this->db->query('SELECT p.*, g.name as genre, sp.name as streaming_platforms 
                      FROM productions p 
                      LEFT JOIN genres g ON p.genre_id = g.id 
                      Left JOIN streaming_platforms sp ON p.streaming_platforms_id = sp.id
                      ORDER BY p.created_at DESC 
                      LIMIT :limit OFFSET :offset');
        $this->db->bind(':limit', $limit);
        $this->db->bind(':offset', $offset);
        return $this->db->resultSet();
    }

    public function getTotalMoviesCount() {
        $this->db->query('SELECT COUNT(*) as total FROM productions');
        $row = $this->db->single();
        return $row->total;
    }
}

