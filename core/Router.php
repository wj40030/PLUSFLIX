<?php

namespace Core;

class Router {
    protected $currentController = 'App\\Controllers\\Pages';
    protected string $currentMethod = 'index';
    protected array $params = [];

    public function __construct() {
        $url = $this->getUrl();

        if ($url && strtolower($url[0]) === 'detail') {
            $this->currentController = 'App\\Controllers\\Pages';
            $this->currentMethod = 'detail';
            unset($url[0]);
        } elseif ($url && file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = 'App\\Controllers\\' . ucwords($url[0]);
            unset($url[0]);
        } else {
            $pagesController = 'App\\Controllers\\Pages';
            if ($url && method_exists($pagesController, $url[0])) {
                $this->currentController = 'App\\Controllers\\Pages';
                $this->currentMethod = $url[0];
                unset($url[0]);
            }
        }

        $controllerFile = '../app/Controllers/' . (str_replace('App\\Controllers\\', '', $this->currentController)) . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        }
        $this->currentController = new $this->currentController;

        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        } else if (isset($url[0]) && method_exists($this->currentController, $url[0])) {
            $this->currentMethod = $url[0];
            unset($url[0]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(): ?array {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return null;
    }
}
