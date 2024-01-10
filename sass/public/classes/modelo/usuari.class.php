<?php

class Usuari
{

    public $email;
    public $username;
    public $admin;


    public function __construct($email, $username, $admin)
    {
        $this->email = $email;
        $this->username = $username;
        $this->admin = $admin;
    }
}

