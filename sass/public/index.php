<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

include 'classes/config/Autoloader.php';
spl_autoload_register("Autoloader::load");
$cFront = new FrontController();
$cFront->dispatch();
// try {
  
// } catch (Exception $e) {
//     // $vError = new ErrorVista();
//     // $vError->show($e);
// }

?>