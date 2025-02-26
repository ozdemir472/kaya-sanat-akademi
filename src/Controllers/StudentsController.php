<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\DB;
use App\Extensions\Json;

class StudentsController {
    private $student;

    public function __construct()
    {
        $this->student = new Student();
    }

    public function listStudents(){
        $students = $this->student->all();
        if (!$students) {
            echo Json::error("Veri bulunamadı");
            return;
        }
        echo Json::data($students);
    }

    public function getStudentByIdentity(){
        $identity = DB::filter($_GET['identity'] ?? '');
        if (!$identity) {
            echo Json::error("Geçersiz kimlik numarası!");
            return;
        }
        
        $student = $this->student->getByIdentity($identity);
        if (!$student) {
            echo Json::error("Öğrenci bulunamadı!");
            return;
        }
        
        echo Json::data($student);
    }

    public function getStudentsCount(){
        $count = $this->student->count();
        if ($count === 0) {
            echo Json::error("Veri bulunamadı");
            return;
        }
        echo Json::data($count);
    }

    public function registerStudent(){
        $data = $this->validateStudentInput($_POST);
        if (!$data) return;
        
        if ($this->student->addStudent($data)) {
            echo Json::message("Kayıt Başarılı");
        } else {
            echo Json::error("Kayıt sırasında bir hata oluştu!");
        }
    }

    public function getStudentById(){
        $id = DB::filter($_GET['id']?? '');
        if (!$id) {
            echo Json::error("Geçersiz kimlik numarası!");
            return;
        }
        
        $student = $this->student->getById($id);
        if (!$student) {
            echo Json::error("Öğrenci bulunamadı!");
            return;
        }
        
        echo Json::data($student);
    }

    public function updateStudent(){
        $id = DB::filter($_POST['id'] ?? '');
        if (!$id) {
            echo Json::error("Geçersiz kimlik numarası!");
            return;
        }
        
        $data = $this->validateStudentInput($_POST);
        if (!$data) return;
        
        if ($this->student->updateStudent($id, $data)) {
            echo Json::message("Öğrenci güncellendi!");
        } else {
            echo Json::error("Güncelleme sırasında bir hata oluştu!");
        }
    }

    private function validateStudentInput($input) {
        $fields = ['studentName', 'registerDate', 'age', 'department', 'identity'];
        $data = [];

        foreach ($fields as $field) {
            $value = DB::filter($input[$field] ?? '');
            if (empty($value)) {
                echo Json::error("$field alanı zorunludur!");
                return false;
            }
            $data[$field] = $value;
        }

        return $data;
    }
}
