<?php
require_once "class.Izuzetak.php";

class Baza
{
    private $konekcija;
    private static $instanca;

    public function __construct($server="localhost",$kor_ime="root",$lozinka="123455",$ime_baze="lab_vezbe")
    {
        $this->konekcija = new mysqli($server,$kor_ime,$lozinka,$ime_baze);
        if (mysqli_connect_errno())
        {
            throw new Izuzetak('Конекција са базом није успела: ', mysqli_connect_error());
        }

        $this->konekcija->set_charset("UTF-8");
        mysqli_set_charset($this->konekcija,"UTF-8");
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

        $this->konekcija->set_charset("UTF-8");
        return $this->konekcija;

    }
    
     
    public function inUpDel($upit)
    {
        $uspesno = Baza::vratiInstancu()->vratiObjekatKonekcije()->query($upit);
        
        return $uspesno;
    }
    
    public function select($upit)
    {
    
        $rezultat = $this->konekcija->query($upit);

        return $rezultat;
    }
    
     


}