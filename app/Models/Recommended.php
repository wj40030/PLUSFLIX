<?php

namespace App\Models;

use Core\Database;

class Recommended {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getSeriesData(): array {
        $this->db->query("SELECT * FROM series");
        return $this->db->resultSet();
    }
}
?>