<?php
namespace App\Models;

use Core\Model;
use Core\Database;

class User extends Model {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->table = 'users';
    }

    public function getAllUsers() {
        $this->db->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        return $row ? $row : false;
    }

    public function login($username, $password) {
        $user = $this->findUserByUsername($username);
        
        if (!$user) {
            return false;
        }

        if ($password == $user->password) {
            return $user;
        }
        
        return false;
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
        
        return $row ? $row : false;
    }
}
