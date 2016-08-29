<?php

require_once "class.Baza.php";
require_once "class.Predmet.php";
require_once "class.Saradnik.php";
require_once "class.Materijal.php";
require_once "class.Izuzetak.php";
require_once "class.Metode.php";


class Lab_vezba
{
    const  BROJ_LAB_MIN = 100;
    const  BROJ_LAB_MAX = 510;

    private $lab_vezba_id;
    private $saradnik_id;
    private $opis;
    private $datum_odrzavanja;
    private $materijal;
    private $br_lab;

    /**
     * Lab_vezba constructor.
     * @param $lab_vezba_id
     * @param $saradnik_id
     * @param $opis
     * @param $datum_odrzavanja
     * @param $materijal
     */
    public function __construct($lab_vezba_id, $saradnik_id, $opis, $datum_odrzavanja, $materijal, $br_lab)
    {
        $this->lab_vezba_id = $lab_vezba_id;
        $this->saradnik_id = $saradnik_id;
        $this->opis = $opis;
        $this->datum_odrzavanja = $datum_odrzavanja;
        $this->materijal = $materijal;
        $this->br_lab = $br_lab;
    }

    /**
     * @param $name
     * @param $value
     * @throws Izuzetak
     */
    public function __set($name, $value)
    {
        if (property_exists("Saradnik", $this->$name))
            $this->$name = $value;
        else
            throw new Izuzetak("Не постоји такав параметар!");
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
        $nizVezbi = [];
        $nizLab = [];
        $vezbe = "";

        $vezbe = Baza::vratiInstancu()->select("SELECT * FROM lab_vezba");
        return $vezbe;
//        $laboratorije = Baza::vratiInstancu()->select("SELECT * FROM laboratorija");
//        while($labaratorija = $laboratorije->fetch_assoc())
//        {
//            array_push($nizLab,Metode::ocistiNiz($labaratorija));
//        }
//
//        while($lab_vezba = $vezbe->fetch_assoc() )
//        {
//            $lab_vezba = Metode::ocistiNiz($lab_vezba);
//            $br_lab = "";
//
//            foreach ($nizLab as $lab)
//                if( ($lab["lab_vezba_id"] == $lab_vezba["lab_vezba_id"])  &&  ($lab["saradnik_id"] == $lab_vezba["saradnik_id"]) )
//                    array_push($nizVezbi, [ $lab_vezba["lab_vezba_id"],
//                                            $lab_vezba["saradnik_id"],
//                                            $lab_vezba["opis"],
//                                            $lab_vezba["datum_odrzavanja"],
//                                            $lab["br_lab"]
//                                            ]
//                                );
//        }
//
//        return $nizVezbi;
    }

    /**
     * @param $saradnik_id
     * @return mixed|null
     */
    public static function procitaj($saradnik_id)
    {
        $niz = self::procitajSve();
        $nizVezbi = [];

        while ($vezba = $niz->fetch_assoc())
            if ($saradnik_id == $vezba['saradnik_id'])
                array_push($nizVezbi, $vezba);

        return $nizVezbi;
    }


    public static function procitaj_lab_id($lab_vezba_id)
    {
        $niz = self::procitajSve();
        $nizVezbi = [];

        while ($vezba = $niz->fetch_assoc())
            if ($lab_vezba_id == $vezba['lab_vezba_id'])
                array_push($nizVezbi, $vezba);

        return $nizVezbi;
    }

    public static function procitaj_predmet_id($predmet_id)
    {
        $niz = self::procitajSve();
        $nizVezbi = [];

        while ($vezba = $niz->fetch_assoc())
            if ($predmet_id == $vezba['predmet_id'])
                array_push($nizVezbi, $vezba);

        return $nizVezbi;
    }

}

