<?php
class Organizacio
{
    public $nom;
    public $email;
    public $web;
    public $logo;

    public function __construct($nom, $email, $web, $logo)
    {
        $this->nom = $nom;
        $this->email = $email;
        $this->web = $web;
        $this->logo = $logo;
    }

    
}
