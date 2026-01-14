<?php

namespace App\Models;

use Core\Model;
use Core\Database;

class Rating extends Model {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->table = 'ratings';
    }

    public function getRatingsByProductionId($productionId, $currentUserId = null) {
        if ($currentUserId) {
            $this->db->query('SELECT r.*, u.username FROM ratings r JOIN users u ON r.user_id = u.id WHERE r.production_id = :production_id AND (r.is_approved = 1 OR r.user_id = :user_id) ORDER BY r.created_at DESC');
            $this->db->bind(':user_id', $currentUserId);
        } else {
            $this->db->query('SELECT r.*, u.username FROM ratings r JOIN users u ON r.user_id = u.id WHERE r.production_id = :production_id AND r.is_approved = 1 ORDER BY r.created_at DESC');
        }
        $this->db->bind(':production_id', $productionId);
        return $this->db->resultSet();
    }

    public function addRating($data) {
        $this->db->query('INSERT INTO ratings (production_id, user_id, rating, comment, is_approved) VALUES (:production_id, :user_id, :rating, :comment, :is_approved)');
        $this->db->bind(':production_id', $data['production_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':comment', $data['comment']);
        
        // Jeśli użytkownik jest adminem, ocena może być od razu zatwierdzona
        $isApproved = isAdmin() ? 1 : 0;
        $this->db->bind(':is_approved', $isApproved);

        if ($this->db->execute()) {
            if ($isApproved) {
                $this->updateProductionRating($data['production_id']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function getAllRatings() {
        $this->db->query('SELECT r.*, u.username, p.title as production_title FROM ratings r JOIN users u ON r.user_id = u.id JOIN productions p ON r.production_id = p.id ORDER BY r.is_approved ASC, r.created_at DESC');
        return $this->db->resultSet();
    }

    public function approveRating($id) {
        // Najpierw pobierzmy production_id, aby móc zaktualizować średnią
        $this->db->query('SELECT production_id FROM ratings WHERE id = :id');
        $this->db->bind(':id', $id);
        $rating = $this->db->single();
        
        $this->db->query('UPDATE ratings SET is_approved = 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            if ($rating) {
                $this->updateProductionRating($rating->production_id);
            }
            return true;
        } else {
            return false;
        }
    }

    public function deleteRating($id) {
        // Pobierzmy production_id przed usunięciem
        $this->db->query('SELECT production_id FROM ratings WHERE id = :id');
        $this->db->bind(':id', $id);
        $rating = $this->db->single();

        $this->db->query('DELETE FROM ratings WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            if ($rating) {
                $this->updateProductionRating($rating->production_id);
            }
            return true;
        } else {
            return false;
        }
    }

    public function updateProductionRating($productionId) {
        // Oblicz średnią z zatwierdzonych ocen
        $this->db->query('SELECT AVG(rating) as avg_rating FROM ratings WHERE production_id = :production_id AND is_approved = 1');
        $this->db->bind(':production_id', $productionId);
        $row = $this->db->single();
        $avgRating = $row->avg_rating ? round($row->avg_rating, 1) : 0;

        // Aktualizuj tabelę productions
        $this->db->query('UPDATE productions SET rating = :rating WHERE id = :id');
        $this->db->bind(':rating', $avgRating);
        $this->db->bind(':id', $productionId);
        return $this->db->execute();
    }
}
