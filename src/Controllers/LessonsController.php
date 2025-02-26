<?php

namespace App\Controllers;

use App\Models\Lesson;
use App\Extensions\Json;
use App\Models\DB;
use DateTime;

class LessonsController {
    private $lesson;

    public function __construct()
    {
        $this->lesson = new Lesson();
    }

    public function getWeeklyTimetable() {
        $lessons = $this->lesson->all();
        if (empty($lessons)) {
            echo Json::error("Ders bulunamadı.");
            return;
        }
        usort($lessons, fn($a, $b) => strcmp($a["time_slot"], $b["time_slot"]));
        echo Json::data($lessons);
    }

    public function getWeeklyTimetableByIdentity(){
        $this->fetchLessonByField('identity');
    }

    public function getWeeklyTimetableById(){
        $this->fetchLessonByField('id');
    }

    private function fetchLessonByField($field) {
        $id = DB::filter($_GET[$field] ?? '');
        if (!$id) {
            echo Json::error("Geçersiz giriş!");
            return;
        }
        $lesson = $field === 'identity' ? $this->lesson->getByIdentity($id) : $this->lesson->getById($id);
        if (empty($lesson)) {
            echo Json::error("Ders bulunamadı.");
            return;
        }
        echo Json::data($lesson);
    }

    public function getLessons(){
        $lessons = $this->lesson->onlyLessons();
        if (empty($lessons)) {
            echo Json::error("Ders bulunamadı.");
            return;
        }
        echo Json::data($lessons);
    }

    public function registerLesson() {
        $data = $this->validateLessonInput($_POST);
        if (!$data) return;
        
        $targetDate = $this->calculateTargetDate($data['day']);
        $weeksToAdd = $this->getWeeksToAdd($data['timePeriod']);
        
        $paymentStatus = isset($_POST['paymentReceived']) && $_POST['paymentReceived'] === 'on' ? 1 : 0;
        
        for ($i = 0; $i < $weeksToAdd; $i++) {
            $weekDate = clone $targetDate;
            $weekDate->modify("+{$i} week");
            
            Lesson::save([
                'studentId' => $data['student'],
                'lessonId' => $data['lesson'],
                'time_slot' => $data['hour'],
                'dayName' => $data['dayName'],
                'signature' => '',
                'week_number' => $weekDate->format('Y-m-d'),
                'paymentStatus' => $paymentStatus
            ]);
        }
        
        echo Json::message("Dersler başarıyla kaydedildi.");
    }

    private function validateLessonInput($input) {
        $fields = ['student', 'lesson', 'day', 'hour', 'timePeriod'];
        foreach ($fields as $field) {
            if (empty($input[$field])) {
                echo Json::error("Lütfen gerekli alanları doldurunuz!");
                return false;
            }
        }
        return [
            'student' => DB::filter($input['student']),
            'lesson' => DB::filter($input['lesson']),
            'day' => DB::filter($input['day']),
            'hour' => DB::filter($input['hour']),
            'timePeriod' => DB::filter($input['timePeriod']),
            'dayName' => $this->getDayName($input['day'])
        ];
    }

    private function calculateTargetDate($day) {
        $today = new DateTime();
        $currentDay = (int) $today->format('N');
        if ($day <= $currentDay) {
            $today->modify('+1 week');
        }
        $targetDate = clone $today;
        $targetDate->modify((($day - $targetDate->format('N')) % 7) . ' days');
        return $targetDate;
    }

    public function createLesson() {
        $lessonName = DB::filter($_POST['lessonName'] ?? '');
        $payPerLesson = DB::filter($_POST['lessonPrice'] ?? '');
        
        if (empty($lessonName) || empty($payPerLesson)) {
            echo Json::error("Lütfen gerekli alanları doldurunuz!");
            return;
        }
        
        DB::table("lessons")->insert([
            'LessonName' => $lessonName,
            'payPerLesson' => $payPerLesson
        ]);
        
        echo Json::message("Ders başarıyla oluşturuldu.");
    }

    private function getWeeksToAdd($timePeriod) {
        return [1 => 1, 2 => 4, 3 => 8, 4 => 12][$timePeriod] ?? 1;
    }

    private function getDayName($day) {
        return [
            1 => 'Pazartesi',
            2 => 'Salı',
            3 => 'Çarşamba',
            4 => 'Perşembe',
            5 => 'Cuma',
            6 => 'Cumartesi'
        ][$day] ?? 'Bilinmeyen Gün';
    }
}
