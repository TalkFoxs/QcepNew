<?php

class LoginVista extends Vista{
    
    public function show($fitxerDeTraduccions,$loginError) {
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/login-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
    
    public function registrar($fitxerDeTraduccions,$errores,$bien) {
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/registrar-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
}

