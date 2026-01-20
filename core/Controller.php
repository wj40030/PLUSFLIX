<?php

namespace Core;

class Controller {
    public function model(string $model) {
        $modelPath = APPROOT . '/Models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
        }
        $fullModelName = 'App\\Models\\' . $model;

        return new $fullModelName(new Database());
    }

    public function view(string $view, array $data = [], string $layout = 'main'): void {
        $viewPath = APPROOT . '/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die('Widok nie istnieje: ' . $view);
        }

        $layoutPath = APPROOT . '/Views/layouts/' . $layout . '.php';
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            require $viewPath;
        }
    }
}
