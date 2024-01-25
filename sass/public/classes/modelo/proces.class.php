<?php
class Proces
{
    private $nom;
    private $tipus;
    private $objectiu;

    public function __construct($nom, $tipus, $objectiu)
    {
        $this->nom = $nom;
        $this->tipus = $tipus;
        $this->objectiu = $objectiu;
    }

}


?>