<?php
include("../../src/Routes/Route.php");
use App\Routes\Route;
if (@$_SERVER['HTTP_REFERER'] == "") {
    Route::notFound();
} else {
    $filename = strip_tags($_GET['file']);
    header('Content-Type: application/javascript');
    readfile("js_004/".$filename);
}
?>
