<?php
require_once "class.Baza.php";
require_once "class.Metode.php";
require_once "class.Izuzetak.php";


abstract class Korisnik
{
    protected $korisnik_id;
    protected $kor_ime;
    protected $lozinka;
    protected $ime_prezime;
    protected $e_mail;

    /**
     * Korisnik constructor.
     * @param $korisnik_id
     * @param $kor_ime
     * @param $lozinka
     * @param $ime_prezime
     * @param $e_mail
     */
    public function __construct($korisnik_id, $kor_ime, $lozinka, $ime_prezime, $e_mail)
    {
        $this->korisnik_id = $korisnik_id;
        $this->kor_ime = $kor_ime;
        $this->lozinka = $lozinka;
        $this->ime_prezime = $ime_prezime;
        $this->e_mail = $e_mail;
    }
    
     public function __toString()
    {
        return "Име и презиме: " . $this->ime_prezime . "\nКор. име: " . $this->kor_ime . "\nЛозинка: " . $this->lozinka .
               "\nЕ-пошта: " . $this->e_mail . "\n";
    }
    
    abstract public function __clone();
    abstract public function __set($name,$value);
    abstract public function __get($name);

    /**
     * @param $kor_ime
     * @param $lozinka
     * @return bool|array
     */
    public static function vratiKorisnika($kor_ime, $lozinka, $tip="")
    {
        $korisnik = false;

        $kor_ime = Metode::mysqli_prep(trim($kor_ime));
        $lozinka = Metode::mysqli_prep(trim($lozinka));

        if ($tip == "admin") {
            $upit = "SELECT * FROM administrator WHERE kor_ime='{$kor_ime}' AND lozinka='{$lozinka}' ;"; // СТРИНГОВИ МОРАЈУ БИТИ ПОД НАВОДНИЦИМА
            $korisnik = Baza::vratiInstancu()->select($upit);  // УКОЛИКО НЕМА ЗАПИСА, ВРАЋА СЕ FALSE
            echo "Успешно сте се улоговали!";
            return mysqli_fetch_assoc($korisnik);
        } else if ($tip == "saradnik") {
            $upit = "SELECT * FROM saradnik WHERE kor_ime='{$kor_ime}' AND lozinka='{$lozinka}' ;";
            $korisnik = Baza::vratiInstancu()->select($upit);
            echo "Успешно сте се улоговали!";
            return mysqli_fetch_assoc($korisnik);
        } else {
            $upit = "SELECT * FROM administrator WHERE kor_ime='{$kor_ime}' AND lozinka='{$lozinka}' ;";
            $korisnik = Baza::vratiInstancu()->select($upit);

            // ако није админ, настављамо проверу
            if ($korisnik->num_rows == 0 || empty($korisnik)) {
                $upit = "SELECT * FROM saradnik WHERE kor_ime='{$kor_ime}' AND lozinka='{$lozinka}' ;";

                $korisnik = Baza::vratiInstancu()->select($upit);

                if ($korisnik->num_rows == 0 || empty($korisnik)) {
                    echo "Такав корисник не постоји у бази.";
                    exit;
                } else {
                    echo "Успешно сте се улоговали!";
                    return mysqli_fetch_assoc($korisnik);
                }
            }
        }
    }

}