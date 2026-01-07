<?php

namespace Core;

abstract class Model {
    protected Database $db;
    protected string $table;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function all(): array {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    public function find(int $id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
