<?php

namespace App\Controllers;

use App\Models\DB;
use App\Extensions\Json;
use App\Controllers\LogController;

class SignatureController {
    private $log;

    public function __construct()
    {
        $this->log = new LogController;
    }
    public function signatureLesson(){
        $lessonName = DB::filter($_POST['lessonName']);
        $teacherName = DB::filter($_POST['teacherName']);
        $lessonDate = DB::filter($_POST['lessonDate']);
        $lessonTime = DB::filter($_POST['lessonTime']);
        $identity = DB::filter($_POST['identity']);
        $studentId = DB::filter($_POST['studentId']);
        $signature = DB::filter($_POST['signature']);

        if($lessonName){
            if($teacherName){
                if($lessonDate){
                    if($lessonTime){
                        if($identity){
                            if($studentId){
                                if($signature){
                                    $data = [
                                        'lessonName' => $lessonName,
                                        'teacherName' => $teacherName,
                                        'lessonDate' => $lessonDate,
                                        'lessonTime' => $lessonTime,
                                        'identity' => $identity,
                                        'studentId' => $studentId,
                                        'signature' => $signature
                                    ];
                                    $sql = DB::table("signatures")->insert($data);
                                    if($sql){
                                        echo Json::message("Kayıt Başarılı");
                                        $this->log->createLog("İmza Atıldı", "success", $studentId, "signature");
                                    } else {
                                        echo Json::error("Kayıt Sırasında Hata Oluştu");
                                    }
                                } else {
                                    echo Json::error("Lütfen Kimlik No Girin");
                                }
                            } else {
                                echo Json::error("Lütfen Öğrenci ID Girin");
                            }
                        } else {
                            echo Json::error("Lütfen Ders Saati Girin");
                        }
                    } else {
                        echo Json::error("Lütfen Ders Tarihi Girin");
                    }
                } else {
                    echo Json::error("Lütfen Öğretmen Adı Girin");
                }
            } else {
                echo Json::error("Lütfen Ders Adı Girin");
            }
        }
    }

    public function getSignaturesCount(){
        $signaturesCount = DB::table("signatures")->get();
        echo Json::data(count($signaturesCount));
    }

    public function getAllSignatures(){
        $signatures = DB::table("signatures")->get();
        echo Json::data($signatures);
    }

    public function getSignaturesByIdentity(){
        $identity = DB::filter(@$_GET['identity']);
        $signatures = DB::table("signatures")->where("identity", $identity)->get();
        echo Json::data($signatures);
    }

    public function getLastSignatures(){
        $data = DB::table("logs")->where("type", "signature")->where("status", "success")->orderBy("timestamp", "desc")->limit(5)->get();
        if($data){
            echo Json::data($data);
        } else {
            echo Json::error("Kayıt Bulunamadı");
        }
        return;
    }
}