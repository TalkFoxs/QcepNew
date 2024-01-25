<?php
class Portada
{
    public $id;
    public $nom;
    public $icono;
    public $descripcio;
    public $enllac;

    public function __construct($id, $nom, $icono, $descripcio, $enllac)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->icono = $icono;
        $this->descripcio = $descripcio;
        $this->enllac = $enllac;
    }
}
?>