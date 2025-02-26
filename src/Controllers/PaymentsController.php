<?php

namespace App\Controllers;

use App\Models\DB;
use App\Models\Student;
use App\Models\Lesson;
use App\Extensions\Json;


class PaymentsController {
    public function changePaymentStatus(){
        $lessonId = DB::filter(@$_POST['lessonId']);

        if(!empty($lessonId)){
            $sql = DB::table("weekly_timetable")->where("id", $lessonId)->first();
            if($sql['paymentStatus'] == 1){
                
                $sql = DB::table("weekly_timetable")->where("id", $lessonId)->update([
                    'paymentStatus' => 0
                ]);
                echo Json::message("Ödeme Durumu Başarıyla Değiştirildi");
            } else {
                    $sql = DB::table("weekly_timetable")->where("id", $lessonId)->update([
                        'paymentStatus' => 1
                    ]);
                    echo Json::message("Ödeme Durumu Başarıyla Değiştirildi");
                }
        } else {
            Json::error("Ders ID'si gönderilmedi.");
        }
    }

    public function calculateTotalPriceByStudentIdentity()
    {
        try {
            $studentId = isset($_GET['id']) ? DB::filter($_GET['id']) : null;
            
            if (empty($studentId)) {
                echo Json::error("Öğrenci Kimlik No'su gönderilmedi veya geçersiz.");
                return;
            }
    
            $student = Student::getStudentById($studentId);
            
            if (empty($student) || empty($student['identity'])) {
                echo Json::error("Geçersiz öğrenci kimliği.");
                return;
            }
    
            $lessons = DB::table("weekly_timetable")
                ->where("studentId", $studentId)
                ->where("paymentStatus", 1)
                ->get();
    
            if (empty($lessons)) {
                echo Json::data([
                    "totalPrice" => 0,
                    "lessonCount" => 0,
                    "payPerLesson" => 0
                ]);
                return;
            }
    
            $totalPrice = 0;
            foreach ($lessons as $lesson) {
                $lessonData = Lesson::onlyLessonsById($lesson['lessonId']);
                
                if (empty($lessonData) || !isset($lessonData['payPerLesson'])) {
                    continue; // Eksik veri varsa bu dersi atla
                }
    
                $totalPrice += $lessonData['payPerLesson'];
            }
    
            echo Json::data([
                "totalPrice" => $totalPrice,
                "lessonCount" => count($lessons),
                "payPerLesson" => count($lessons) > 0 ? ($totalPrice / count($lessons)) : 0
            ]);
    
        } catch (\Exception $e) {
            echo Json::error("Bir hata oluştu: " . $e->getMessage());
        }
    }
    
}