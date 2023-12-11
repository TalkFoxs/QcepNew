<?php

class InversisController extends  Controlador{
    public function __construct() {
        parent::__construct();
    }
    public function show(){
        $inversiVistas = new InversiVista();
        $inversiVistas->show();
        
    }
    
    
}

