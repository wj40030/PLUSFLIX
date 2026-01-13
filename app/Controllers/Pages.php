<?php

namespace App\Controllers;

use Core\Controller;

class Pages extends Controller {
    private $exampleModel;
    private $movieModel;

    public function __construct() {
        $this->exampleModel = $this->model('Example');
        $this->movieModel = $this->model('Movie');
    }

    public function index(): void {
        $examples = $this->exampleModel->getTestData();
        $movies = $this->movieModel->getAllMovies();

        $searchTerm = '';
        $searchResults = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

            if (!empty($searchTerm)) {
                $searchResults = $this->movieModel->searchMovies($searchTerm);
            }
        }

        $data = [
            'title' => 'Witaj',
            'description' => 'To jest strona glowna aplikacji PLUSFLIX.',
            'examples' => $examples,
            'movies' => $movies,
            'searchTerm' => $searchTerm,
            'searchResults' => $searchResults
        ];

        $this->view('pages/index', $data);
    }

    public function productions($id = null): void {
        if ($id) {
            $movie = $this->movieModel->getMovieById($id);

            if (!$movie) {
                header('Location: ' . URLROOT);
                exit;
            }

            $data = [
                'title' => $movie->title,
                'movie' => $movie
            ];

            $this->view('pages/movie', $data);
        } else {
            $movies = $this->movieModel->getAllMovies();

            $data = [
                'title' => 'Produkcje',
                'description' => 'Wszystkie dostepne filmy',
                'css' => 'productions',
                'movies' => $movies
            ];
            $this->view('pages/productions', $data);
        }
    }

    public function search(): void {
        $searchTerm = '';
        $movies = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

            if (!empty($searchTerm)) {
                $movies = $this->movieModel->searchMovies($searchTerm);
            }
        }

        $data = [
            'title' => 'Wyszukiwanie filmów',
            'description' => 'Znajdź swój ulubiony film',
            'movies' => $movies,
            'searchTerm' => $searchTerm
        ];

        $this->view('pages/search', $data);
    }

    public function random(): void {
        $data = [
            'title' => 'Losowy program',
            'description' => 'To jest strona z losowym programem.'
        ];
        $this->view('pages/random', $data);
    }

    public function admin(): void {
        requireAdmin();

        $data = [
            'title' => 'Panel Administratora',
            'description' => 'Witaj w panelu administratora'
        ];
        $this->view('pages/admin', $data);
    }

    public function watchlist(): void {
        requireLogin();

        $data = [
            'title' => 'Watchlist',
            'description' => 'To jest twoja watchlista'
        ];

        $this->view('pages/watchlist', $data);
    }

    public function detail($id = null): void {
        if (!$id) {
            header('Location: ' . URLROOT);
            exit;
        }

        $movie = $this->movieModel->getMovieById($id);

        if (!$movie) {
            header('Location: ' . URLROOT);
            exit;
        }

        $data = [
            'title' => $movie->title,
            'movie' => $movie
        ];

        $this->view('pages/movie', $data);
    }
}
