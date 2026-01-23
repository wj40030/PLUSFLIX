<?php

namespace App\Controllers;

use Core\Controller;

class Pages extends Controller {
    private const allowedPageItems = 10;

    public function index(): void {
        $exampleModel = $this->model('Example');
        $movieModel = $this->model('Movie');
        
        $examples = $exampleModel->getTestData();
        $movies = $movieModel->getAllMovies();

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

        $movieModel = $this->model('Movie');
        $ratingModel = $this->model('Rating');
        $streamingModel = $this->model('Streaming');

        $limit = self::allowedPageItems;
        $offset = ($page - 1) * $limit;

        $totalMovies = $movieModel->getTotalMoviesCount();
        $movies = $movieModel->getMoviesWithPagination($limit, $offset);

        $ratings = $ratingModel->getAllRatings();
        $platforms = $streamingModel->getAllStreamings();

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
            'title' => 'Panel administracyjny',
            'description' => 'Panel administracyjny - zarządzanie produkcjami i ocenami.'
        ];

        $this->view('pages/admin', $data);
    }

    public function addProduction(): void {
        requireAdmin();

        $genreModel = $this->model('Genre');
        $streamingModel = $this->model('Streaming');
        $movieModel = $this->model('Movie');

        $genres = $genreModel->getAllGenres();
        $streamings = $streamingModel->getAllStreamings();

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

            if ($movieModel->addMovie($data)) {
                header('Location: ' . URLROOT . '/pages/admin#productions');
                exit;
            }
        } else {
            $data = [
                'title' => 'Dodaj Nową Produkcję',
                'description' => 'Formularz dodawania nowej produkcji.',
                'genres' => $genres,
                'streamings' => $streamings
            ];
            $this->view('pages/add_production', $data);
        }
    }

    public function editProduction($id): void {
        requireAdmin();

        $genreModel = $this->model('Genre');
        $streamingModel = $this->model('Streaming');
        $movieModel = $this->model('Movie');

        $genres = $genreModel->getAllGenres();
        $streamings = $streamingModel->getAllStreamings();

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

            if ($movieModel->updateMovie($id, $data)) {
                header('Location: ' . URLROOT . '/pages/admin#productions');
                exit;
            } else {
                die('Błąd podczas aktualizacji.');
            }
        } else {
            $movie = $movieModel->getMovieById($id);

            if (!$movie) {
                header('Location: ' . URLROOT . '/pages/admin');
                exit;
            }

            $data = [
                'title' => 'Edytuj: ' . $movie->title,
                'description' => isset($movie->description) ? $movie->description : '',
                'movie' => $movie,
                'genres' => $genres,
                'streamings' => $streamings
            ];

            $this->view('pages/edit_production', $data);
        }
    }

    public function deleteProduction($id): void {
        requireAdmin();

        $movieModel = $this->model('Movie');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movieModel->deleteMovie($id);
            header('Location: ' . URLROOT . '/pages/admin#productions');
        }
    }

    public function approveRating($id): void {
        requireAdmin();

        $ratingModel = $this->model('Rating');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($ratingModel->approveRating($id)) {
                header('Location: ' . URLROOT . '/pages/admin#comments');
            }
        }
    }

    public function deleteRating($id): void {
        requireAdmin();

        $ratingModel = $this->model('Rating');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($ratingModel->deleteRating($id)) {
                header('Location: ' . URLROOT . '/pages/admin#comments');
            }
        }
    }

    public function detail($id = null): void {
        if (!$id) {
            header('Location: ' . URLROOT);
            exit;
        }

        $movieModel = $this->model('Movie');
        $ratingModel = $this->model('Rating');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isLoggedIn()) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $reviewData = [
                'production_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'rating' => trim($_POST['rating']),
                'comment' => trim($_POST['comment'])
            ];

            if (!empty($reviewData['rating'])) {
                $ratingModel->addRating($reviewData);
                header('Location: ' . URLROOT . '/pages/detail/' . $id);
                exit;
            }
        }

        $movie = $movieModel->getMovieById($id);
        if (!$movie) {
            header('Location: ' . URLROOT);
            exit;
        }

        $data = [
            'title' => $movie->title,
            'description' => isset($movie->description) ? $movie->description : '',
            'movie' => $movie,
            'ratings' => $ratingModel->getRatingsByProductionId($id, isLoggedIn() ? $_SESSION['user_id'] : null),
            'isInWatchlist' => isLoggedIn() ? $movieModel->isInWatchlist($_SESSION['user_id'], $id) : false
        ];

        $this->view('pages/movie', $data);
    }

    public function productions($id = null): void {
        if ($id) {
            $this->detail($id);
        } else {
            $movieModel = $this->model('Movie');
            $genreModel = $this->model('Genre');
            $streamingModel = $this->model('Streaming');
            
            $genre_id = filter_input(INPUT_GET, 'genre_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            $streaming_id = filter_input(INPUT_GET, 'streaming_platforms_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

            if (($genre_id !== null && $genre_id !== '') || ($streaming_id !== null && $streaming_id !== '')) {
                $movies = $movieModel->filterMovies($genre_id, $streaming_id);
            } else {
                $movies = $movieModel->getAllMovies();
            }

            $genres = $genreModel->getAllGenres();
            $streamings = $streamingModel->getAllStreamings();
            $data = [
                'title' => 'Produkcje',
                'description' => 'Wszystkie dostępne filmy',
                'movies' => $movies,
                'genres' => $genres,
                'streamings' => $streamings
            ];
            $this->view('pages/productions', $data);
        }
    }

    public function search(): void {
        $movieModel = $this->model('Movie');
        
        $searchTerm = '';
        $movies = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
            if (!empty($searchTerm)) {
                $movies = $movieModel->searchMovies($searchTerm);
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
        $movieModel = $this->model('Movie');
        
        $movie = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie = $movieModel->getRandomMovie();
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
        
        $movieModel = $this->model('Movie');
        
        $movies = $movieModel->getWatchlist($_SESSION['user_id']);
        $data = [
            'title' => 'Twoja Watchlista',
            'description' => 'Produkcje, które chcesz obejrzeć.',
            'movies' => $movies
        ];
        $this->view('pages/watchlist', $data);
    }

    public function addToWatchlist($id): void {
        requireLogin();

        $movieModel = $this->model('Movie');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieModel->addToWatchlist($_SESSION['user_id'], $id);
            header('Location: ' . URLROOT . '/pages/detail/' . $id);
        }
    }

    public function removeFromWatchlist($id): void {
        requireLogin();

        $movieModel = $this->model('Movie');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieModel->removeFromWatchlist($_SESSION['user_id'], $id);
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                header('Location: ' . URLROOT . '/pages/watchlist');
            }
        }
    }
}