<?php
require("./vendor/autoload.php");

use App\Routes\Route;

use App\Controllers\PagesController;
use App\Controllers\LoginController;
use App\Controllers\StudentsController;
use App\Controllers\TeachersController;
use App\Controllers\SignatureController;
use App\Controllers\LessonsController;
use App\Controllers\LogController;
use App\Controllers\PaymentsController;
use App\Controllers\SystemController;
use App\Controllers\UsersController;
use React\EventLoop\SignalsHandler;

$route = new Route();

$route->get('/', [PagesController::class, 'login']);
$route->get('/test', [LogController::class, 'createLog']);
$route->get('/logout', [PagesController::class, 'logout']);
$route->get('/dashboard', [PagesController::class, 'dashboard']);
$route->get('/students', [PagesController::class, 'students']);
$route->get('/signature', [PagesController::class, 'signature']);
$route->get('/lessons', [PagesController::class, 'lessons']);
$route->get('/settings', [PagesController::class, 'settings']);
$route->get('/registerStudent', [PagesController::class, 'registerStudent']);
$route->get('/registerTeacher', [PagesController::class, 'registerTeacher']);
$route->get('/studentSelection', [PagesController::class, 'studentSelection']);
$route->get('/signatureStudent', [PagesController::class, 'signatureStudent']);
$route->get('/systemLogs', [PagesController::class, 'systemLogs']);
$route->get("/registerStudentLesson", [PagesController::class, 'registerStudentLesson']);
$route->get("/lessonsIframe", [PagesController::class, 'lessonsIframe']);
$route->get("/studentDetails", [PagesController::class, 'studentDetails']);
$route->get("/createLesson", [PagesController::class, 'createLesson']);



Route::group("/api", function ($router) {
    $router->post("/login", [LoginController::class, "login"]);
    $router->post("/signatureLesson", [SignatureController::class, "signatureLesson"]);
    $router->post("/changePaymentStatus", [PaymentsController::class, "changePaymentStatus"]);
    $router->post("/registerStudent", [StudentsController::class, "registerStudent"]);
    $router->post("/registerTeacher", [TeachersController::class, "registerTeacher"]);
    $router->post("/registerLesson", [LessonsController::class, "registerLesson"]);
    $router->post("/saveWorkingHours", [SystemController::class, "saveWorkingHours"]);
    $router->post("/saveWorkingDays", [SystemController::class, "saveWorkingDays"]);
    $router->post("/createUser", [UsersController::class, "createUser"]);
    $router->post("/createLesson", [LessonsController::class, "createLesson"]);
    $router->post("/editStudent", [StudentsController::class, "updateStudent"]);
    $router->get("/listStudents", [StudentsController::class, "listStudents"]);
    $router->get("/listTeachers", [TeachersController::class, "listTeachers"]);
    $router->get("/getStudentByIdentity", [StudentsController::class, "getStudentByIdentity"]);
    $router->get("/getStudentById", [StudentsController::class, "getStudentById"]);
    $router->get("/listLessons", [LessonsController::class, "getWeeklyTimetable"]);
    $router->get("/getWeeklyTimetableByIdentity", [LessonsController::class, "getWeeklyTimetableByIdentity"]);
    $router->get("/getWeeklyTimetableById", [LessonsController::class, "getWeeklyTimetableById"]);
    $router->get("/getStudentsCount", [StudentsController::class, "getStudentsCount"]);
    $router->get("/getTeachersCount", [TeachersController::class, "getTeachersCount"]);
    $router->get("/getSignaturesCount", [SignatureController::class, "getSignaturesCount"]);
    $router->get("/getAllSignatures", [SignatureController::class, "getAllSignatures"]);
    $router->get("/getLessons", [LessonsController::class, "getLessons"]);
    $router->get("/getAllLogs", [LogController::class, "getLogs"]);
    $router->get("/getLastLogins", [LoginController::class, "getLastLogins"]);
    $router->get("/getUserById", [LoginController::class, "getUserById"]);
    $router->get("/getTeacherById", [TeachersController::class, "getTeacherById"]);
    $router->get("/getSignaturesByIdentity", [SignatureController::class, "getSignaturesByIdentity"]);
    $router->get("/calculateTotalPriceByStudentIdentity", [PaymentsController::class, "calculateTotalPriceByStudentIdentity"]);
    $router->get("/getSystemOption", [SystemController::class, "getSystemOption"]);
    $router->get("/getUserBySession", [UsersController::class, "getUserBySession"]);
    $router->get("/removeUser", [UsersController::class, "removeUser"]);
    $router->get("/getUsers", [UsersController::class, "getUsers"]);
    $router->get("/getLastSignatures", [SignatureController::class, "getLastSignatures"]);
});

Route::dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);