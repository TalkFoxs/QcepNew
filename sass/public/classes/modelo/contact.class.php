<?php

class contact
{
    public $id;
    public $data;
    public $missatge;
    public function __construct($id, $missatge, $data){
       $this->id=$id;
       $this->missatge=$missatge;
       $this->data=$data;
    }
}

