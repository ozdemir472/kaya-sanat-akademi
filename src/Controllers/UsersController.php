<?php

namespace App\Controllers;

use App\Models\DB;
use App\Extensions\Json;

class UsersController {
    public function createUser(){
        $username = DB::filter($_POST['username']);
        $longname = DB::filter($_POST['longname']);
        $password = DB::filter($_POST['password']);
        $email = DB::filter($_POST['email']);

        if(!empty($username) && !empty($password) && !empty($email)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = DB::table("users")->where("username", $username)->first();
                if(empty($sql)){
                    DB::table("users")->insert(["username" => $username, "password" => password_hash($password, PASSWORD_ARGON2I), "email" => $email, "name" => $longname]);
                    echo Json::message("Kullanıcı başarıyla oluşturuldu.");
                } else {
                    echo Json::error("Kullanıcı adı zaten mevcut.");
                }
            } else {
                echo Json::error("Lütfen geçerli bir e-posta adresi girin.");
            }
        } else {
            echo Json::error("Lütfen gerekli alanları doldurun.");
        }
    }

    public function getUserBySession(){
        $session_id = DB::filter($_GET['session_id']);
        echo Json::data(DB::table("users")->where("session_id", $session_id)->first());
    }

    public function removeUser(){
        $id = DB::filter($_GET['id']);
        DB::table("users")->where("id", $id)->delete();
        echo Json::message("Kullanıcı başarıyla silindi.");
    }

    public function getUsers(){
        $users = DB::table("users")->get();
        echo Json::data($users);
    }
}