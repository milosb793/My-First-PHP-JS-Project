<?php

require_once "class.Izuzetak.php";
require_once "class.Baza.php";
require_once "class.Metode.php";

class Predmet
{
    private $predmet_id;
    private $naziv;
    private $opis;

    /**
     * Predmet constructor.
     * @param $predmet_id
     * @param $naziv
     * @param $opis
     */
    public function __construct($predmet_id, $naziv, $opis)
    {
        $this->predmet_id = $predmet_id;
        $this->naziv = $naziv;
        $this->opis = $opis;
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
     * Чита све предмете из базе
     * @return array
     */
    public static function procitajSve()
    {
        $rezultat =  Baza::vratiInstancu()->select("SELECT * FROM predmet");
        return $rezultat;
    }

    /**
     * Враћа Предмет са прослеђеним ID-oм
     * @param $id
     * @return mixed|null
     */
    public static function procitaj($id)
    {
        $nizPredmeta = self::procitajSve();

        while($red = $nizPredmeta->fetch_assoc() )
            if($red['predmet_id'] == $id)
                return $red;

        return null;
    }

    /**
     * Враћа предмет из базе по прослеђеном називу
     * @param $naziv
     * @return mixed|null
     */
    public static function procitajNaziv($naziv)
    {
        $nizPredmeta = self::procitajSve();

        foreach($nizPredmeta as $objekat)
            if($objekat->naziv == $naziv)
                return $objekat;

        return null;
    }

    /**
     * За прослеђени сарадник ид, враћа све предмете на којима је тај сарадник нагажован
     * @param $saradnik_id
     * @return array
     */
    public static function vratiPredmete($saradnik_id)
    {

        $upit = "SELECT * FROM predmet_saradnik WHERE saradnik_id={$saradnik_id}";

        return Baza::vratiInstancu()->select($upit);

    }

    public static function izmeniOpis($predmet_id, $novi_opis)
    {
        ### провера да ли је сарадник на том предмету сарадник ###
        //узимамо сарадника који је пријављен из сесије
        $saradnik = unserialize($_SESSION['korisnik']);

        //сада пишемо упит за проверу да ли је сарадников ид у пару са ид-ом предмета, тј. да ли је сарадник на том предмету
        $upit = "SELECT * FROM predmet_saradnik WHERE predmet_id='" . $predmet_id . "' 
                                                AND saradnik_id='" . $saradnik->saradnik_id . "' ;";

        //ако упит врати резултат, значи да је сарадник сарадник на датом предмету
        $rezultat = Baza::vratiInstancu()->select($upit);

        if($rezultat > 0)
            if( (isset($predmet_id) && is_int($predmet_id) ) || ( isset($novi_opis) && is_string($novi_opis) ) )
            {
                $rez = Baza::vratiInstancu()->inUpDel("UPDATE predmet SET opis='". $novi_opis . "' WHERE predmet_id='" . $predmet_id . "' ;");
                if($rez > 0)
                    Metode::obavestenje("Успешно сте променили опис предмета!");
                else
                    throw new Izuzetak("Дошло је до грешке. Опис није ажуриран. ");
            }
            else
            {
                throw new Izuzetak("Прослеђени су неодговарајући параметри");
            }

        else
            throw new Izuzetak("Дошло је до грешке. Проверите да ли сте сарадник на овом предмету.");
    }
}