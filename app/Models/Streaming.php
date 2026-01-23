<?php
namespace App\Models;

use Core\Model;
use Core\Database;

class Streaming extends Model {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->table = 'streaming_platforms';
    }

    public function getAllStreamings() {
        $this->db->query("SELECT * FROM streaming_platforms ORDER BY name ASC");
        return $this->db->resultSet();
    }

    public function getStreamingById($id) {
        $this->db->query("SELECT * FROM streaming_platforms WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addPlatform($data) {
        $this->db->query('INSERT INTO streaming_platforms (name, price, offer) VALUES (:name, :price, :offer)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':offer', $data['offer']);
        return $this->db->execute();
    }

    public function updatePlatform($id, $data) {
        $this->db->query('UPDATE streaming_platforms SET name = :name, price = :price, offer = :offer WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':offer', $data['offer']);
        return $this->db->execute();
    }

    public function deletePlatform($id) {
        $this->db->query('DELETE FROM streaming_platforms WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}