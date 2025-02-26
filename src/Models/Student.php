<?php

namespace App\Models;

use App\Models\DB;

class Student {
    private $db;

    public function __construct() {
        $this->db = new DB('students');
    }

    public function all() {
        $students = $this->db->get();
        return $students;
    }

    public static function getStudentById($id) {
        $student = DB::table('students')->where('id', $id)->first();
        return $student;
    }

    public function addStudent($data) {
        return $this->db->table('students')->insert($data);
    }

    public function updateStudent($id, $data) {
        return $this->db->table('students')->where('id', $id)->update($data);
    }

    public function deleteStudent($id) {
        return $this->db->table('students')->where('id', $id)->delete();
    }

    public function getByIdentity($identity){
        $student = $this->db
            ->table('students')
            ->where('identity', $identity)
            ->first();
        return $student;
    }

    public function getById($id){
        $student = $this->db
            ->table('students')
            ->where('id', $id)
            ->first();
        return $student;
    }

    public function count(){
        return count($this->all());
    }
}