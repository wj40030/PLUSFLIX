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
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
            $data['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';

            if (empty($data['username'])) {
                $data['error'] = 'podaj nazwe uzytkownika';
                $this->view('auth/login', $data);
                return;
            }

            if (empty($data['password'])) {
                $data['error'] = 'podaj haslo';
                $this->view('auth/login', $data);
                return;
            }

            $loggedInUser = $this->userModel->login($data['username'], $data['password']);

            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                $data['error'] = 'nieprawidlowy login lub haslo';
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
