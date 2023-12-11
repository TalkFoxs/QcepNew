<?php

class ErrorVista extends  Vista{
    
    public function show(Exception $e) {
        $fitxerDeTraduccions = "languages/{$this->lang}_Texto.php";
        include $fitxerDeTraduccions;
        $titol = "hi ha hagut un error";
        $missatge = $e->getMessage();
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/error-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
}

