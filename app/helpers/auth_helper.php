<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . URLROOT . '/auth/login');
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ' . URLROOT);
        exit;
    }
}

