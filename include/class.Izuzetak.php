<?php

require_once "class.Metode.php";

class Izuzetak extends Exception
{
    public function __construct($message, $code="", Exception $previous=null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function poruka()
    {
         Metode::greska($this->message . ", " . $this->code);
    }
    
    public function __toString()
    {
        parent::__toString(); 
        echo self::poruka();
    }
}