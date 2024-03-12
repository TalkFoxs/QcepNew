<?php

class Document
{
    public $nom;
    public $tipus;
    public $link;
    public $proces_nom;

    public function __construct($nom, $tipus, $link, $proces_nom)
    {
        $this->nom = $nom;
        $this->tipus = $tipus;
        $this->link = $link;
        $this->proces_nom = $proces_nom;
    }
}
