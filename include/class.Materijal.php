<?php
require_once "class.Baza.php";
require_once "class.Metode.php";
require_once "class.Predmet.php";
require_once "class.Lab_vezba.php";
require_once "class.Saradnik.php";
require_once "class.Korisnik.php";
require_once "class.Izuzetak.php";

class Materijal
{
    private $materijal_id;
    private $lab_vezba_id;
    private $opis;
    private $materijal;

    /**
     * Materijal constructor.
     * @param $materijal_id
     * @param $lab_vezba_id
     * @param $opis
     * @param $materijal
     */
    public function __construct($materijal_id, $lab_vezba_id, $opis, $materijal)
    {
        $this->materijal_id = $materijal_id;
        $this->lab_vezba_id = $lab_vezba_id;
        $this->opis = $opis;
        $this->materijal = $materijal;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (property_exists("Saradnik", $this->$name))
            $this->$name = $value;
        else
            trigger_error("Не постоји такав параметар!" . "<br>",E_USER_ERROR);
    }

    /**
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }

    /**
     * @return array
     */
    public static function procitajSve()
    {
        $nizPredmeta=[];
        $rezultat = "";
        $objekat = null;

        $rezultat =  Baza::vratiInstancu()->select("SELECT * FROM materijal");
        while($objekat = $rezultat->fetch_assoc())
        {
            array_push($nizPredmeta, $objekat );
        }

        return $nizPredmeta;
    }

    /**
     * Враћа фечован низ
     * @param $lab_id
     * @return mixed|null
     */
    public static function procitaj($lab_id)
    {
        $niz = self::procitajSve();
        $nizMaterijala = [];

        foreach($niz as $objekat)
            if($objekat['lab_vezba_id'] == $lab_id)
                array_push($nizMaterijala,$objekat);

        return $nizMaterijala;
    }



}