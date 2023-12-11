<?php

class HomeController{
   public function __construct() {
       
   }
   public  function show() {
       
       
       if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['lang'])) {
           $queIdioma = sanitize($_GET['lang']);
           $idiomaActive = [
               "es",
               "cn",
               "en"
           ];
           if (in_array($queIdioma, $idiomaActive)) {
               $tiempo = time() + (86400 * 30);
               setcookie("lang", $queIdioma, $tiempo, "/"); // La cookie expira en 30 días
           }
           $idioma = $_GET['lang'];
       } elseif (isset($_COOKIE['lang'])) {
           $idioma = $_COOKIE['lang'];
       } else {
           $idioma = 'es'; // Idioma por defecto
       }
       
       $fitxerDeTraduccions = "languages/{$idioma}_Texto.php";
       // Cargar el idioma
       HomeVista::show($idioma, $fitxerDeTraduccions);
       
   }
}

