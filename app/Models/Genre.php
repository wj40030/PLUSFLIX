<?php
namespace App\Models;

use Core\Model;
use Core\Database;

class Genre extends Model {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->table = 'genres';
    }

    public function getAllGenres() {
        $this->db->query("SELECT * FROM genres ORDER BY name ASC");
        return $this->db->resultSet();
    }
}