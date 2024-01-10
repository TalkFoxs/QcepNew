<?php

class LangController extends  Controlador{
    public function set($params="es") {
        if (in_array($params[0], array("es","cn","en"))) {
            setcookie("lang",$params[0],time()+3600);
        }
        
        $lang = $params[0];
        $fitxerDeTraduccions = "languages/{$lang}_Texto.php";
        
        
        $vHome = new HomeVista();
        $vHome->show($lang, $fitxerDeTraduccions);
    }
}

