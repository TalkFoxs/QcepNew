<?php

class Autoloader{
    private const CARPETAS = ['modelo', 'vista', 'controlador', 'config'];
    
    public static function load($clase){
        foreach (self::CARPETAS as $carpeta) {
            if (file_exists("classes/$carpeta/".strtolower($clase).'.class.php')) {
                include "classes/$carpeta/".strtolower($clase).'.class.php';
                return;
            }
        }
        throw new Exception("No s'ha trobat la definicio de la classe $clase");
    }
    
    
}

