<?php

namespace App\Models;

use Core\Database;

class Example {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getTestData(): array {
        $this->db->query("SELECT * FROM examples");
        return $this->db->resultSet();
    }
}
