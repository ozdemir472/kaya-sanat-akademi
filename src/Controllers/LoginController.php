<?php

namespace App\Controllers;

use App\Models\DB;
use App\Controllers\LogController;
use App\Extensions\Json;

class LoginController {
    private $log;

    public function __construct() {
        $this->log = new LogController();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        header('Content-Type: application/json');

        $username = $this->sanitizeInput($_POST['username'] ?? null);
        $password = $this->sanitizeInput($_POST['password'] ?? null);

        if (empty($username)) {
            $this->sendResponse(false, "Kullanıcı adı gereklidir.");
            $this->log->createLog("Giriş denemesi / Kullanıcı Adı Belirtilmedi.", "fail");
            return;
        }

        if (empty($password)) {
            $this->sendResponse(false, "Şifre gereklidir.");
            $this->log->createLog("Giriş denemesi / Şifre Belirtilmedi.", "fail");
            return;
        }

        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user)) {
            $this->sendResponse(false, "Kullanıcı bulunamadı.");
            return;
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $user['password'];

            $this->log->createLog("Giriş başarılı.", "success", $user['id'], "login");
            $update = DB::table("users")->where("username", $username)->update([
                "session_id" => session_id(),
            ]);
            $this->sendResponse(true, "Giriş başarılı.");
        } else {
            $this->log->createLog("Giriş denemesi / Şifre Yanlış.", "fail", null, "login");
            $this->sendResponse(false, "Şifre yanlış.");
        }
    }

    public function authControl() {
        if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
            $this->log->createLog("Anasayfaya giriş denemesi / Oturum açılmadı veya oturum hatası.", "fail", null, "login");
            return $this->logout();
        }

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user) || !$password == $user['password']) {
            $this->log->createLog("Anasayfaya giriş denemesi / Oturum açılmadı veya oturum hatası.", "fail", null, "login");
            return $this->logout();
        }

        return true;
    }

    public function checkSession() {
        if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
            $this->log->createLog("Anasayfaya giriş denemesi / Oturum açılmadı veya oturum hatası.", "fail", null, "login");
            return false;
        }

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user) || !$password == $user['password']) {
            $this->log->createLog("Anasayfaya giriş denemesi / Oturum açılmadı veya oturum hatası.", "fail", null, "login");
            return false;
        }

        return true;
    }

    public function logout() {
        $userId = @$this->getUserBySession()['id'];
        $this->log->createLog("Çıkış yapıldı.", "success", $userId, "logout");
        session_destroy();
        header("Location: /");
    }

    private function sanitizeInput($input) {
        return htmlspecialchars(trim($input));
    }

    private function sendResponse($status, $message) {
        echo json_encode([
            'status' => $status,
            'message' => $message
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function getUserBySession(){
        if (!isset($_SESSION['username']) ||!isset($_SESSION['password'])) {
            return null;
        }
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        return DB::table("users")->where("username", $username)->where("password", $password)->first();
    }

    public function getUserById(){
        $userId = DB::filter(@$_GET['id']);
        if(!empty($userId)){
            $user = DB::table("users")->where("id", $userId)->first();
            if(!empty($user)){
                echo Json::data($user);
            } else {
                echo Json::error("Veri Bulunamadı.");
            }
        } else {
            echo Json::error("ID Gönderilmedi.");
        }
        return;
    }

    public function getLastLogins(){
        echo Json::data(DB::table("logs")->where("type", "login")->where("status", "success")->orderBy("timestamp", "desc")->limit(5)->get());
        return;
    }
}
