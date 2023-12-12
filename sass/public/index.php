<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once './glogin/vendor/autoload.php';
include 'classes/config/Autoloader.php';
spl_autoload_register("Autoloader::load");

try {
    $cFront = new FrontController();
    $cFront->dispatch();
} catch (Exception $e) {
    $vError = new ErrorVista();
    $vError->show($e);
}

?>