<?php

namespace App\Models;

use Core\Model;
use Core\Database;

class Recommended {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->table = 'productions';
    }

    public function getAllMovies() {
        $this->db->query('SELECT id FROM productions');
        $movies = $this->db->resultSet();

        $this->db->query('SELECT p.*, g.name as genre, sp.name as streaming_platforms FROM productions p LEFT JOIN genres g ON p.genre_id = g.id LEFT JOIN streaming_platforms sp ON p.streaming_platforms_id = sp.id ORDER BY p.watchlist_count DESC, p.rating DESC, p.year DESC LIMIT 8');
        return $this->db->resultSet();
    }
}
?>