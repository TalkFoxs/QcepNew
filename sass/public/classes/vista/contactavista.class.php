<?php

class ContactaVista extends  Vista{
    public function show($fitxerDeTraduccions,$errors) {
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/contact-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
    
    public function manteniment($fitxerDeTraduccions,$resultat){
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/manteniment-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
}

