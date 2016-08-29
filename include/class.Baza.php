<?php
require_once "class.Izuzetak.php";

class Baza
{
    private $konekcija;
    private static $instanca;
    public static $affected_rows;
    public static $greska;

    public function __construct($server="localhost",$kor_ime="root",$lozinka="",$ime_baze="lab_vezbe")
    {
        $this->konekcija = new mysqli($server,$kor_ime,$lozinka,$ime_baze);
        if (mysqli_connect_errno())
        {
            die ('Конекција са базом није успела: '. mysqli_connect_error());
        }

        $this->konekcija->set_charset("utf8");
        mysqli_set_charset($this->konekcija,"utf8");
    }

    /**
     * Метода за враћање инстанце базе, не дозвољава инстанцирање више база.
     * @return Baza
     */
    public static function vratiInstancu()
    {
        if(self::$instanca==null)
            self::$instanca = new Baza();

        return self::$instanca;
    }

    public  function vratiObjekatKonekcije()
    {
        if($this->konekcija == null )
            self::vratiInstancu();

        $this->konekcija->set_charset("utf8");
        return $this->konekcija;

    }
    
     
    public function inUpDel($upit)
    {
        $uspesno = $this->konekcija->query($upit);
        self::$affected_rows = $this->konekcija->affected_rows;
        self::vratiInstancu()->vratiObjekatKonekcije()->error;
        
        return $uspesno;
    }
    
    public function select($upit)
    {
    
        $rezultat = $this->konekcija->query($upit);
        self::$affected_rows = $this->konekcija->affected_rows;
        self::vratiInstancu()->vratiObjekatKonekcije()->error;

        return $rezultat;
    }

    
     


}