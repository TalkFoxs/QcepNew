<?php

class Usuari
{

    public $email;
    public $pass;
    public $username;
    public $admin;


    public function __construct($email, $pass, $username, $admin)
    {
        $this->email = $email;
        $this->pass = $pass;
        $this->username = $username;
        $this->admin = $admin;
    }
}

