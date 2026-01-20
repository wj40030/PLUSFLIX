<?php

namespace App\Controllers;

use Core\Controller;

class Auth extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function index() {
        header('Location: ' . URLROOT . '/auth/login');
        exit;
    }

    public function login() {
        if ($this->isLoggedIn()) {
            header('Location: ' . URLROOT);
            exit;
        }

        $data = [
            'title' => 'Logowanie',
            'username' => '',
            'password' => '',
            'error' => '',
            'errors' => []
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
            $data['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';

            if (empty($data['username'])) {
                $data['errors'][] = 'podaj nazwe użytkownika';
            }

            if (empty($data['password'])) {
                $data['errors'][] = 'podaj hasło';
            }

            if (!empty($data['errors'])) {
                $this->view('auth/login', $data);
                return;
            }

            $loggedInUser = $this->userModel->login($data['username'], $data['password']);

            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                $data['errors'][] = 'nieprawidłowy login lub haslo';
                $this->view('auth/login', $data);
            }
        } else {
            $this->view('auth/login', $data);
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy();
        header('Location: ' . URLROOT . '/auth/login');
        exit;
    }

    private function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
        header('Location: ' . URLROOT . '/pages/watchlist');
        exit;
    }

    private function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
