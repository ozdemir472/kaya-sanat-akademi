<?php
include("../../src/Routes/Route.php");
use App\Routes\Route;
if (@$_SERVER['HTTP_REFERER'] == "") {
    Route::notFound();
} else {
    $filename = strip_tags($_GET['file']);
    header('Content-Type: text/css');
    readfile("css_004/".$filename);
}
?>
