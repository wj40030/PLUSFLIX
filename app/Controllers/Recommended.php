<?php

namespace App\Controllers;

use Core\Controller;

class Recommended extends Controller {
    private $recommendedModel;

    public function __construct() {
        $this->recommendedModel = $this->model('Recommended');
    }

    public function index(): void {
        $recommended = $this->recommendedModel->getSeriesData();
        $data = [
            'title' => 'Polecane programy',
            'description' => 'To jest strona z polecanymi programami.',
            'series' => $recommended

        ];
        $this->view('pages/recommended', $data);
    }
}
?>