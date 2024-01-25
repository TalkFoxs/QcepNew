<?php
class Avalucaio
{
    private $tipo_id;
    private $nivell;
    private $valoracio;
    private $planificacio;
    private $accions;
    private $estrategi;

    public function __construct($tipo, $nivell, $valoracio, $planificacio, $accions, $estrategi)
    {
        $this->tipo_id = $tipo;
        $this->nivell = $nivell;
        $this->valoracio = $valoracio;
        $this->planificacio = $planificacio;
        $this->accions = $accions;
        $this->estrategi = $estrategi;
    }


}
?>