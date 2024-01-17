<?php
class DriveController{
    public function __construct(){

    }
    public function show(){
        echo "Hola";
    }
    public function crearCarpeta(){
        $prova = new DriveModel();
        $prova ->crearCarpeta("hola2024");
    }

}
?>