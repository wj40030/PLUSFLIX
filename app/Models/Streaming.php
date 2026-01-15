<?php
namespace App\Models;

use Core\Model;
use Core\Database;

class Streaming extends Model {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->table = 'streaming_platforms';
    }

    public function updatePlatform($id, $data) {
        $this->db->query('UPDATE streaming_platforms SET price = :price, offer = :offer WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':offer', $data['offer']);
        return $this->db->execute();
    }

    public function getAllStreamings() {
        $this->db->query("SELECT * FROM streaming_platforms ORDER BY name ASC");
        return $this->db->resultSet();
    }
}