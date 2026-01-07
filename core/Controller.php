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

    public function view(string $view, array $data = []): void {
        if (file_exists(APPROOT . '/Views/' . $view . '.php')) {
            require_once APPROOT . '/Views/' . $view . '.php';
        } else {
            die('Widok nie istnieje');
        }
    }
}
