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
        $this->db->query('SELECT p.*, g.name as genre FROM productions p LEFT JOIN genres g ON p.genre_id = g.id ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    public function searchMovies($searchTerm) {
        $this->db->query('SELECT productions.*, genres.name as genre FROM productions LEFT JOIN genres ON productions.genre_id = genres.id WHERE productions.title LIKE :search OR productions.description LIKE :search OR genres.name LIKE :search ORDER BY productions.rating DESC');
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }

    public function getMovieById($id) {
        $this->db->query('SELECT p.*, g.name as genre FROM productions p LEFT JOIN genres g ON p.genre_id = g.id WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getMoviesByGenre($genre) {
        $this->db->query('SELECT productions.*, genres.name as genre FROM productions LEFT JOIN genres ON productions.genre_id = genres.id WHERE genres.name = :genre ORDER BY productions.rating DESC');
        $this->db->bind(':genre', $genre);
        return $this->db->resultSet();
    }

    public function getRandomMovie() {
        $this->db->query('SELECT p.*, g.name as genre FROM productions p LEFT JOIN genres g ON p.genre_id = g.id ORDER BY RAND() LIMIT 1');
        return $this->db->single();
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
}
