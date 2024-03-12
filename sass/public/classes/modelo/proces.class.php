<?php
class Proces
{
    private $nom;
    private $tipus;
    private $objectiu;
    private $usuari_email;

    public function __construct($nom, $tipus, $objectiu, $usuari_email)
    {
        $this->nom = $nom;
        $this->tipus = $tipus;
        $this->objectiu = $objectiu;
        $this->usuari_email = $usuari_email;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            echo "Property $name does not exist.";
        }
    }
}
