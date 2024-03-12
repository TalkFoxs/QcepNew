<?php
class ProcesVista extends Vista
{
    public function show($fitxerDeTraduccions, $html, $ok = '', $error = '')
    {
        require_once $fitxerDeTraduccions;
        echo "<!DOCTYPE html><html lang=\"en\">";
        include "template/head-tag.php";
        echo "<body>";
        include "template/header-tag.php";
        include "template/proces-tag.php";
        include "template/footer-tag.php";
        echo "</body></html>";
    }
}
