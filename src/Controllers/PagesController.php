<?php

namespace App\Controllers;

use App\Controllers\LoginController;

class PagesController {
    private $loginController;

    public function __construct(){
        $this->loginController = new LoginController();
    }

    private function loadPageWithAuth(string $pageName) {
        $this->loginController->authControl();
        $filePath = "./src/Views/Pages/{$pageName}.php";

        if (file_exists($filePath)) {
            include($filePath);
        } else {
            http_response_code(404);
            echo "404 - Sayfa bulunamadı!";
        }
    }

    public function login(){
        if ($this->loginController->checkSession()) {
            header("Location: /dashboard");
            exit();
        }
        include("./src/Views/Pages/login.php");
    }

    public function logout(){
        $this->loginController->logout();
    }

    public function __call($method, $args) {
        $this->loadPageWithAuth($method);
    }
}
