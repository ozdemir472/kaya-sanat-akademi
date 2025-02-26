<?php

namespace App\Models;

use App\Models\DB;

class Teacher {
    private $db;

    public function __construct() {
        $this->db = new DB('teachers');
    }

    public function all() {
        $teachers = $this->db->table('teachers')->get();
        return $teachers;
    }

    public function getTeacherById($id) {
        $teacher = $this->db
            ->table('teachers')
            ->where('id', $id)
            ->first();
        return $teacher;
    }

    public function addTeacher($data) {
        return $this->db->table('teachers')->insert($data);
    }

    public function updateTeacher($id, $data) {
        return $this->db->table('teachers')->where('id', $id)->update($data);
    }

    public function deleteTeacher($id) {
        return $this->db->table('teachers')->where('id', $id)->delete();
    }

    public function count(){
        return count($this->all());
    }
}