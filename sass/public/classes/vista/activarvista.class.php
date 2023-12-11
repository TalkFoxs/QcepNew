<?php

class ActivarVista extends  Vista{
    public function show($fitxerDeTraduccions,$userid) {
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/activar-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
}

