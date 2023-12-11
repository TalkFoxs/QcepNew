<?php

class HomeVista extends Vista{
        
    
    public static function show($lang, $fitxerDeTraduccions ) {
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/main-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
}

