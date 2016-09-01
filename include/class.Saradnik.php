<?php
require_once  "class.Korisnik.php";
require_once "class.Administrator.php";
require_once "class.Lab_vezba.php";
require_once  "class.Baza.php";
require_once  "class.Metode.php";
require_once "class.Izuzetak.php";
require_once "class.Predmet.php";
require_once "class.Materijal.php";

class Saradnik extends Korisnik
{
    //има све атрибуте као и корисник
    private $opis;
    private $status;
    private $slika_url;

    /**
     * Saradnik constructor.
     * @param $korisnik_id
     * @param $kor_ime
     * @param $lozinka
     * @param $ime_prezime
     * @param $e_mail
     * @param $opis
     * @param $status
     * @param $slika_url
     */
    public function __construct($korisnik_id, $kor_ime, $lozinka, $ime_prezime, $e_mail, $opis, $status, $slika_url)
    {
        parent::__construct($korisnik_id, $kor_ime, $lozinka, $ime_prezime, $e_mail);
        $this->opis = $opis;
        $this->status = $status;
        $this->slika_url = $slika_url;
    }

    /**
     * Магична метода, претвара објекат у стринг
     * @return string
     */
    public function __toString()
    {
        return parent::__toString() . "\nОпис: " . $this->opis . "\nСтатус: " . $this->status .
        "\nУРЛ слике: " . $this->slika_url . "\n";
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
     * Имплементирати по потреби
     */
    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function dodajMaterijal($lab_vezba_id, $naziv, $lokacija)
    {
        //реализовати
        //TODO: realizuj dodavanje materijala
    }

    /**
     * @param $naziv
     * @param $opis
     * @param $datum_od
     * @param $br_lab
     * @param $saradnik_id
     */
    public static function dodajLabVezbu($naziv, $opis, $datum_od, $br_lab, $saradnik_id, $predmet_id)
    {
        ### потребно је ажурирати најпре табелу lab_vezba, затим табелу laboratorija, затим табелу материјал;
        #   треба проверити и да ли та вежба већ постоји.
        #   мислим да би најбољи приступ уносу био попуњавање форме и слање података на страницу лаб. вежба
        #   материјали се исто убацују путем форме за датотеке

        //конвертовање датума у валидан облик за базу
        $datum_od = date('Y-m-d H:i:s', strtotime($datum_od));

        //провера да ли постоји вежба
        $lab_vezbe = Lab_vezba::procitajSve();
        $saradnik_id = intval($saradnik_id);
        $predmet_id = intval($predmet_id);
        $vezba = "";
        $status = 0;
        $materijal_id = "";
        $lab_vezbe->data_seek(0);

        while ($vezba = $lab_vezbe->fetch_assoc()) {
            if (($vezba["naziv"] == $naziv || $vezba['opis'] == $opis) && $vezba["saradnik_id"] == $saradnik_id && strtotime($vezba['datum_odrzavanja']) == strtotime($datum_od)) {
                echo "Грешка: Лаб. вежба са тим описом и датумом одржавања већ постоји!";
                $status = 1;
                break;
            } else if (($br_lab <= Lab_vezba::BROJ_LAB_MIN) || ($br_lab >= Lab_vezba::BROJ_LAB_MAX)) {
                echo "Грешка: Неисправан број лабараторије. Број мора бити у опсегу од: " .
                    Lab_vezba::BROJ_LAB_MIN . " до " . Lab_vezba::BROJ_LAB_MAX . ".";
                $status = 1;
                break;
            }
        }
        $lab_vezbe->data_seek(0);

        if ($status == 0) {
//                //УРАЂЕНА ПРОВЕРА ПРЕКО ЈАВАСКРИПТА
//                # провера да сарадник не додаје другог сарадника на вежбу
//                ## провера да ли је овај сарадник сарадник на предмету, у табели предмет-сарадник, али нам треба предмет_ид
//                //предмет_ид узимамо из табеле предмет-сарадник
//                $rez = Baza::vratiInstancu()->select("SELECT predmet_id FROM predmet_saradnik WHERE saradnik_id={$saradnik_id} ");
//                $predmet = $rez->fetch_assoc();
//                $predmet_id = intval($predmet['predmet_id']);
//
//                if (!$predmet_id) //ако не постоји, излазимо из методе са грешком
//                {
//                    echo "Грешка: Унети сарадник није сарадник на предмету.";
//                    return;
//                }

            $promenjeno_redova1 = Baza::vratiInstancu()->inUpDel("INSERT INTO lab_vezba ( saradnik_id, predmet_id ,naziv, opis, datum_odrzavanja )" .
                " VALUES ( {$saradnik_id}, {$predmet_id},'{$naziv}' ,'{$opis}', '{$datum_od}' )");

            if ($promenjeno_redova1 != 0) {
                //ажурирање табеле лабораторија
                #узимамо лаб_вежба_ид који је тек додат у табелу

                $rez = Baza::vratiInstancu()->select("SELECT lab_vezba_id FROM lab_vezba WHERE saradnik_id={$saradnik_id} AND opis='{$opis}' AND datum_odrzavanja ='{$datum_od}' ");
                $lab = $rez->fetch_assoc();
                $lab_vezba_id = intval($lab['lab_vezba_id']);

                $promenjeno_redova2 = Baza::vratiInstancu()->inUpDel("INSERT INTO laboratorija ( lab_vezba_id, saradnik_id, broj_lab ) 
                                                                              VALUES ( {$lab_vezba_id}, {$saradnik_id}, {$br_lab} )");
                if ($promenjeno_redova2 != 0) {
                    //убацивање у табелу материјали
                    $promenjeno_redova4 = Baza::vratiInstancu()->inUpDel("INSERT INTO materijal ( lab_vezba_id, opis ) 
                                                                               VALUES ( {$lab_vezba_id}, '{$opis}')");

                    $rez = Baza::vratiInstancu()->select("SELECT materijal_id FROM materijal WHERE lab_vezba_id={$lab_vezba_id}");
                    $materijal_id = $rez->fetch_assoc();
                    $materijal_id = intval($materijal_id['materijal_id']);

                    if ($promenjeno_redova4 != 0)
                        echo "База је успешно ажурирана!" . "Материјал: {$materijal_id}";
                    else
                        echo "Грешка: Лаб. вежба није уписана!" . Baza::vratiInstancu()->vratiObjekatKonekcije()->error;
                }
            }
        } else return;
    }

    /**
     * Метода за измену постојеће вежбе. За детерминисање постојеће лаб вежбе користе се
     * прва три параметра. Друга три су опциона, и проверава се да си су постављена један по један.
     * Прослеђују се параметри из форме.
     * @param $lab_vezba_id
     * @param $naziv
     * @param $opis
     * @param $datum
     * @param $br_lab
     * @param $saradnik_id
     * @param $predmet_id
     * @throws Izuzetak
     * @internal param string $novi_opis
     * @internal param string $novi_datum
     * @internal param int $novi_br_lab
     */
    public static function izmeniLabVezbu($lab_vezba_id, $naziv, $opis, $datum, $br_lab, $predmet_id, $saradnik_id)
    {
        echo "поздрав из функције измениЛабВежбу :)\n Подаци: lab_id: {$lab_vezba_id} назив: {$naziv} opis: {$opis} datum: {$datum} br_lab: {$br_lab} pred_id: {$predmet_id} sar_id: {$saradnik_id}";
        $datum = date('Y-m-d H:i:s', strtotime($datum));
        //ако смо убацили фајл

        $materijali = Materijal::procitaj($lab_vezba_id);


        // ово ради //
        if (Baza::vratiInstancu()->inUpDel("UPDATE lab_vezba SET naziv='{$naziv}', opis='{$opis}', 
                                                  datum_odrzavanja='{$datum}', saradnik_id={$saradnik_id} , predmet_id={$predmet_id} WHERE lab_vezba_id={$lab_vezba_id}")
        ) {
            if (Baza::vratiInstancu()->inUpDel("UPDATE laboratorija SET broj_lab={$br_lab}, saradnik_id={$saradnik_id} WHERE lab_vezba_id={$lab_vezba_id}")) {
                foreach ($materijali as $materijal)
                {
                    if (Baza::vratiInstancu()->inUpDel("UPDATE materijal SET opis='{$opis}' WHERE lab_vezba_id={$lab_vezba_id} )"))
                    {
                        echo "Успешно сте изменили лаб. вежбу!";
                    }
                    else
                    {
                        echo "Грешка: није успело ажурирање материјала.";
                    }

                }
            } else
                echo "Грешка: није успело ажурирање табеле лаб. вежба";
        } else
            echo "Грешка: није успело ажурирање табеле лабораторија.";

    }

    /**
     * @param $opis
     * @param $datum
     * @param $br_lab
     * @throws Izuzetak
     */
    public static function obrisiLabVezbu($lab_vezba_id) //проверити да ли ради и како каскадно брисање, иначе треба обрисати и из лабораторије и материјала
    {
        $materijali = Materijal::procitaj($lab_vezba_id); //fetch-ovano
        $status = 0;

        if (Baza::vratiInstancu()->inUpDel("DELETE FROM lab_vezba WHERE lab_vezba_id={$lab_vezba_id}")) {
            if (Baza::vratiInstancu()->inUpDel("DELETE FROM laboratorija WHERE lab_vezba_id={$lab_vezba_id}")) {
                if (Baza::vratiInstancu()->inUpDel("DELETE FROM materijal WHERE lab_vezba_id={$lab_vezba_id}")) {
                    foreach ($materijali as $mat) {
                        if (Baza::vratiInstancu()->inUpDel("DELETE FROM fajlovi WHERE materijal_id={$mat['materijal_id']} "))
                            $status = 1;
                        else
                            $status = 0;
                    }
                    if ($status) {
                        echo "Успешно сте обрисали вежбу!";
                        return;
                    } else echo "Грешка при брисању материјала... ";
                } else echo "Грешка при брисању материјала...";
            } else echo "Грешка при брисању лабораторије...";
        } else echo "Грешка при брисању лаб. вежбе...";

    }

    public static function izmenaProfila($saradnik_id,$lozinka,$opis,$slika_url)
    {
        if( isset($lozinka) && !empty($lozinka) && !is_null($lozinka)  )
        {
            $lozinka = md5(sha1(sha1($lozinka)));
            if (Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET lozinka='{$lozinka}', opis='{$opis}', slika_url='{$slika_url}' WHERE saradnik_id={$saradnik_id} ")) {
                echo "Успешно сте ажурирали свој профил.";
                return;
            }
            else
            {
                echo "Дошло је до грешке при ажурирању. Покушајте поново.";
                return;
            }
        }
        else
        {
            if (Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET opis='{$opis}', slika_url='{$slika_url}' WHERE saradnik_id={$saradnik_id} "))
            {
                echo "Успешно сте ажурирали свој профил.";
                return;
            }
            else
            {
                echo "Дошло је до грешке при ажурирању. Покушајте поново.";
                return;
            }        }
    }

    public static function izlistajSveSaradnike()
    {
        $rezultat = Baza::vratiInstancu()->select("SELECT * FROM saradnik ");
        return $rezultat;

    }

    public static function sviSaradniciNaPredmetu($predmet_id)
    {
        $svi_saradnici = self::izlistajSveSaradnike();
        $predmet_saradnik_sve_rs = Baza::vratiInstancu()->select("SELECT * FROM predmet_saradnik WHERE predmet_id={$predmet_id}");
        $niz_saradnika_na_predmetu = [];

        while ($saradnik = $svi_saradnici->fetch_assoc()) {
            while ($pr_sr = $predmet_saradnik_sve_rs->fetch_assoc()) {
                if ($saradnik['saradnik_id'] == $pr_sr['saradnik_id'])
                    array_push($niz_saradnika_na_predmetu, $saradnik);
            }
            $predmet_saradnik_sve_rs->data_seek(0);
        }

        return $niz_saradnika_na_predmetu;
    }

    /**
     * За прослеђен ид, враћа сарадника
     * @param $saradnik_id
     * @return array
     */
    public static function vratiSaradnika($saradnik_id)
    {
        $svi_saradnici = self::izlistajSveSaradnike(); //nije fetch-ovano
        while ($saradnik = $svi_saradnici->fetch_assoc()) {
            if ($saradnik['saradnik_id'] == $saradnik_id)
                return $saradnik;
        }

    }




}