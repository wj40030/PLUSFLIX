<?php

namespace App\Controllers;

use Core\Controller;

class Pages extends Controller {
    private $exampleModel;
    private $movieModel;
    private $ratingModel;

    public function __construct() {
        $this->exampleModel = $this->model('Example');
        $this->movieModel = $this->model('Movie');
        $this->ratingModel = $this->model('Rating');
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

        $ratings = $this->ratingModel->getAllRatings();

        $data = [
            'title' => 'Panel Administratora',
            'description' => 'Witaj w panelu administratora',
            'css' => ['admin', 'reviews'],
            'ratings' => $ratings
        ];
        $this->view('pages/admin', $data);
    }

    public function approveRating($id): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->ratingModel->approveRating($id)) {
                header('Location: ' . URLROOT . '/pages/admin#comments');
            } else {
                die('Coś poszło nie tak');
            }
        } else {
            header('Location: ' . URLROOT . '/pages/admin');
        }
    }

    public function deleteRating($id): void {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->ratingModel->deleteRating($id)) {
                header('Location: ' . URLROOT . '/pages/admin#comments');
            } else {
                die('Coś poszło nie tak');
            }
        } else {
            header('Location: ' . URLROOT . '/pages/admin');
        }
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isLoggedIn()) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'production_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'rating' => isset($_POST['rating']) ? trim($_POST['rating']) : '',
                'comment' => isset($_POST['comment']) ? trim($_POST['comment']) : ''
            ];

            if (!empty($data['rating'])) {
                if ($this->ratingModel->addRating($data)) {
                    header('Location: ' . URLROOT . '/pages/detail/' . $id);
                    exit;
                } else {
                    die('Coś poszło nie tak przy dodawaniu oceny.');
                }
            }
        }

        $movie = $this->movieModel->getMovieById($id);

        if (!$movie) {
            header('Location: ' . URLROOT);
            exit;
        }

        $currentUserId = isLoggedIn() ? $_SESSION['user_id'] : null;
        $ratings = $this->ratingModel->getRatingsByProductionId($id, $currentUserId);

        $data = [
            'title' => $movie->title,
            'movie' => $movie,
            'css' => 'reviews',
            'ratings' => $ratings
        ];

        $this->view('pages/movie', $data);
    }
}
