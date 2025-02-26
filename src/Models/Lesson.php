<?php

namespace App\Models;

use App\Models\DB;


class Lesson {
    private $db;

    public function __construct() {
        $this->db = new DB('weekly_timetable');
    }

    public function all() {
        $students = $this->db
            ->join('students', 'studentId', '=', 'students.id')
            ->join('lessons', 'lessonId', '=', 'lessons.id')
            ->select(['students.*', 'weekly_timetable.*', 'weekly_timetable.id AS timetableId', 'lessons.*'])
            ->get();
        return $students;
    }

    public static function save($data){
        return DB::table('weekly_timetable')->insert($data);
    }

    public function onlyLessons(){
        $lessons = DB::table("lessons")->get();
        return $lessons;
    }

    public static function onlyLessonsById($id){
        $lessons = DB::table("lessons")
            ->where('id', $id)
            ->first();
        return $lessons;
    }

    public function getByIdentity($identity){
        $students = $this->db
            ->table('weekly_timetable')
            ->join('students', 'studentId', '=', 'students.id')
            ->join('lessons', 'lessonId', '=', 'lessons.id')
            ->where('students.identity', $identity)
            ->select([
                'students.*', 
                'weekly_timetable.*', 
                'weekly_timetable.id AS timetableId', 
                'lessons.*'
            ])
            ->get();
        return $students;
            
    }

    public function getById($id){
        $student = $this->db
            ->table('weekly_timetable')
            ->where('id', $id)
            ->first();
        return $student;
    }
}