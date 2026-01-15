<?php

namespace App\Controllers;

use Core\Controller;

class Pages extends Controller {
    private $exampleModel;
    private $movieModel;
    private $ratingModel;
    private $userModel;
    private $genreModel;
    private $streamingModel;

    public function __construct() {
        $this->exampleModel = $this->model('Example');
        $this->movieModel = $this->model('Movie');
        $this->ratingModel = $this->model('Rating');
        $this->userModel = $this->model('User');
        $this->genreModel = $this->model('Genre');
        $this->streamingModel = $this->model('Streaming');
    }

    public function index(): void {
        $examples = $this->exampleModel->getTestData();
        $movies = $this->movieModel->getAllMovies();

        $data = [
            'title' => 'Witaj',
            'description' => 'To jest strona glowna aplikacji PLUSFLIX.',
            'examples' => $examples,
            'movies' => $movies,
            'searchTerm' => '',
            'searchResults' => []
        ];

        $this->view('pages/index', $data);
    }

    public function admin($page = 1): void {
        requireAdmin();

        $limit = 10;
        $offset = ($page - 1) * $limit;

        $totalMovies = $this->movieModel->getTotalMoviesCount();
        $movies = $this->movieModel->getMoviesWithPagination($limit, $offset);

        $ratings = $this->ratingModel->getAllRatings();
        $platforms = $this->streamingModel->getAllStreamings();

        $stats = [
            'users' => 'N/A',
            'movies' => $totalMovies,
            'ratings' => count($ratings)
        ];

        $data = [
            'movies' => $movies,
            'ratings' => $ratings,
            'platforms' => $platforms,
            'currentPage' => (int)$page,
            'totalPages' => ceil($totalMovies / $limit),
            'stats' => $stats,
            'css' => ['admin', 'reviews']
        ];

        $this->view('pages/admin', $data);
    }

    public function addProduction(): void {
        requireAdmin();

        $genres = $this->genreModel->getAllGenres();
        $streamings = $this->streamingModel->getAllStreamings();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'title' => trim($_POST['title']),
                'type' => trim($_POST['type']),
                'genre_id' => $_POST['genre_id'],
                'streaming_platforms_id' => $_POST['streaming_platforms_id'],
                'description' => trim($_POST['description']),
                'year' => $_POST['year']
            ];

            if ($this->movieModel->addMovie($data)) {
                header('Location: ' . URLROOT . '/pages/admin#productions');
                exit;
            }
        } else {
            $data = [
                'title' => 'Dodaj Nową Produkcję',
                'genres' => $genres,
                'streamings' => $streamings,
                'css' => 'admin'
            ];
            $this->view('pages/add_production', $data);
        }
    }

    public function editProduction($id): void {
        requireAdmin();

        $genres = $this->genreModel->getAllGenres();
        $streamings = $this->streamingModel->getAllStreamings();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'type' => trim($_POST['type']),
                'genre_id' => $_POST['genre_id'],
                'streaming_platforms_id' => $_POST['streaming_platforms_id'],
                'description' => trim($_POST['description']),
                'year' => $_POST['year']
            ];

            if ($this->movieModel->updateMovie($id, $data)) {
                header('Location: ' . URLROOT . '/pages/admin#productions');
                exit;
            } else {
                die('Błąd podczas aktualizacji.');
            }
        } else {
            $movie = $this->movieModel->getMovieById($id);

            if (!$movie) {
                header('Location: ' . URLROOT . '/pages/admin');
                exit;
            }

            $data = [
                'title' => 'Edytuj: ' . $movie->title,
                'movie' => $movie,
                'genres' => $genres, // Przekazujemy gatunki do widoku
                'streamings' => $streamings,
                'css' => 'admin'
            ];

            $this->view('pages/edit_production', $data);
        }
    }

    public function deleteProduction($id): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->movieModel->deleteMovie($id);
            header('Location: ' . URLROOT . '/pages/admin#productions');
        }
    }

    public function approveRating($id): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->ratingModel->approveRating($id)) {
                header('Location: ' . URLROOT . '/pages/admin#comments');
            }
        }
    }

    public function deleteRating($id): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->ratingModel->deleteRating($id)) {
                header('Location: ' . URLROOT . '/pages/admin#comments');
            }
        }
    }

    public function detail($id = null): void {
        if (!$id) {
            header('Location: ' . URLROOT);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isLoggedIn()) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $reviewData = [
                'production_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'rating' => trim($_POST['rating']),
                'comment' => trim($_POST['comment'])
            ];

            if (!empty($reviewData['rating'])) {
                $this->ratingModel->addRating($reviewData);
                header('Location: ' . URLROOT . '/pages/detail/' . $id);
                exit;
            }
        }

        $movie = $this->movieModel->getMovieById($id);
        if (!$movie) {
            header('Location: ' . URLROOT);
            exit;
        }

        $data = [
            'title' => $movie->title,
            'movie' => $movie,
            'css' => 'reviews',
            'ratings' => $this->ratingModel->getRatingsByProductionId($id, isLoggedIn() ? $_SESSION['user_id'] : null),
            'isInWatchlist' => isLoggedIn() ? $this->movieModel->isInWatchlist($_SESSION['user_id'], $id) : false
        ];

        $this->view('pages/movie', $data);
    }

    public function productions($id = null): void {
        if ($id) {
            $this->detail($id);
        } else {
            $genre_id = $_GET['genre_id'] ?? null;
            $streaming_id = $_GET['streaming_platforms_id'] ?? null;

            if ($genre_id || $streaming_id) {
                $movies = $this->movieModel->filterMovies($genre_id, $streaming_id);
            } else {
                $movies = $this->movieModel->getAllMovies();
            }

            $genres = $this->genreModel->getAllGenres();
            $streamings = $this->streamingModel->getAllStreamings();
            $data = [
                'title' => 'Produkcje',
                'description' => 'Wszystkie dostepne filmy',
                'css' => 'productions',
                'movies' => $movies,
                'genres' => $genres,
                'streamings' => $streamings
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
        $movie = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie = $this->movieModel->getRandomMovie();
        }
        $data = [
            'title' => 'Losuj Produkcję',
            'description' => 'Nie wiesz co obejrzeć? Wylosuj coś dla siebie!',
            'movie' => $movie
        ];
        $this->view('pages/random', $data);
    }

    public function watchlist(): void {
        requireLogin();
        $movies = $this->movieModel->getWatchlist($_SESSION['user_id']);
        $data = [
            'title' => 'Twoja Watchlista',
            'description' => 'Produkcje, które chcesz obejrzeć.',
            'movies' => $movies,
            'css' => 'productions'
        ];
        $this->view('pages/watchlist', $data);
    }

    public function addToWatchlist($id): void {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->movieModel->addToWatchlist($_SESSION['user_id'], $id);
            header('Location: ' . URLROOT . '/pages/detail/' . $id);
        }
    }

    public function removeFromWatchlist($id): void {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->movieModel->removeFromWatchlist($_SESSION['user_id'], $id);
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                header('Location: ' . URLROOT . '/pages/watchlist');
            }
        }
    }
}