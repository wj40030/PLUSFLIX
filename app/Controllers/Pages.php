<?php

namespace App\Controllers;

use Core\Controller;

class Pages extends Controller {
    private $exampleModel;

    public function __construct() {
        $this->exampleModel = $this->model('Example');
    }

    public function index(): void {
        $examples = $this->exampleModel->getTestData();

        $data = [
            'title' => 'Witaj',
            'description' => 'To jest strona główna aplikacji PLUSFLIX.',
            'examples' => $examples
        ];

        $this->view('pages/index', $data);
    }

    public function productions(): void {
        $data = [
            'title' => 'Produkcje',
            'description' => 'To jest strona z produkcjami.',
            'css' => 'productions'
        ];
        $this->view('pages/productions', $data);
    }

    public function random(): void {
        $data = [
            'title' => 'Losowy program',
            'description' => 'To jest strona z losowym programem.'
        ];
        $this->view('pages/random', $data);
    }

    public function recommended(): void {
        $data = [
            'title' => 'Polecane programy',
            'description' => 'To jest strona z polecanymi programami.'
        ];
        $this->view('pages/recommended', $data);
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
}
