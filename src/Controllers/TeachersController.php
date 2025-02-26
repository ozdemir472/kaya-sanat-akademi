<?php

namespace App\Controllers;

use App\Models\Teacher;
use App\Models\DB;
use App\Extensions\Json;

class TeachersController {
    private $teacher;

    public function __construct()
    {
        $this->teacher = new Teacher();
    }

    public function listTeachers() {
        $teachers = $this->teacher->all();
        if (empty($teachers)) {
            echo Json::error("Öğretmen bulunamadı.");
            return;
        }
        echo Json::data($teachers);
    }

    public function getTeachersCount() {
        $count = $this->teacher->count();
        echo Json::data($count);
    }

    public function getTeacherById() {
        $id = DB::filter($_GET['id'] ?? '');
        if (!$id) {
            echo Json::error("Geçersiz öğretmen ID!");
            return;
        }
        
        $teacher = $this->teacher->getTeacherById($id);
        if (!$teacher) {
            echo Json::error("Böyle bir öğretmen bulunamadı.");
            return;
        }
        
        echo Json::data($teacher);
    }

    public function registerTeacher() {
        $data = $this->validateTeacherInput($_POST);
        if (!$data) return;

        $data['name'] = $data['teacherName'];
        unset($data['teacherName']);

        if ($this->teacher->addTeacher($data)) {
            echo Json::message("Kayıt Başarılı");
        } else {
            echo Json::error("Kayıt başarısız.");
        }
    }

    private function validateTeacherInput($input) {
        $fields = ['teacherName', 'department', 'registerDate'];
        $data = [];
        
        foreach ($fields as $field) {
            $value = DB::filter($input[$field] ?? '');
            if ($value === '') {
                echo Json::error("$field alanı zorunludur!");
                return false;
            }
            $data[$field] = $value;
        }
        
        return $data;
    }
}
