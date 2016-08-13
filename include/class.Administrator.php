<?php
require_once "class.Baza.php";
require_once "class.Metode.php";
require_once "class.Korisnik.php";
require_once "class.Izuzetak.php";


class Administrator extends Korisnik
{

    public function __toString()
    {
        parent::__toString();
    }

    /**
     * Имплементирати по потреби
     */
    public function __clone()
    {
        // TODO: Implement __clone() method.
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
     * @param $naziv
     * @param $opis
     * @throws Izuzetak
     */
    public static function dodajPredmet($naziv,$opis)
    {
        if(isset($naziv) && isset($opis))
        {
            if( Baza::vratiInstancu()->inUpDel("INSERT INTO predmet(naziv, opis) VALUES( '{$naziv}', '{$opis}' ; ") )
                echo "Успешно сте додали предмет!";
            else
                echo "Дошло је до грешке при ажурирању базе. Покушајте поново.";
        }
        else
            echo "Нисте унели параметре за предмет.";
    }

    /**
     * Метода као параметре има поља форме која су попуњена. Прва два параметра су обавезна,
     * остала два су опциона.
     * @param $naziv
     * @param $opis
     * @param string $novi_naziv
     * @param string $novi_opis
     * @throws Izuzetak
     */
    public static function izmeniPredmet($naziv,$opis, $novi_naziv="", $novi_opis="")
    {
        //прво тражимо предмет_ид помоћу прва два параметра
        $result_set = Baza::vratiInstancu()->select("SELECT predmet_id FROM predmet WHERE opis='{$opis}' AND naziv='{$naziv}' ;");
        $predmet_id = $result_set->fetch_assoc();
        $predmet_id = $result_set['predmet_id']; //proveri

        if(empty($predmet_id) )
            echo"Предмет са унетим називом и описом не постоји.";
        else
        {
            if(!empty($novi_opis) && !empty($novi_naziv) )
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE predmet SET naziv= '{$novi_naziv}', opis='{$novi_opis}' WHERE predmet_id={$predmet_id} ;") )
                    echo "Успешно сте изменили предмет.";
                else
                    echo "Дошло је до грешке при ажурирању базе. ";
            }
            else if($novi_naziv!="")
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE predmet SET naziv='{$novi_naziv}' WHERE predmet_id='{$predmet_id}' ;") )
                    echo "Успешно сте изменили предмет.";
                else
                    throw new Izuzetak("Дошло је до грешке при ажурирању базе. ");
            }
            else if($novi_opis!="")
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE predmet SET opis='{$novi_opis}' WHERE predmet_id={$predmet_id} ;") )
                    echo "Успешно сте изменили предмет.";
                else
                    throw new Izuzetak("Дошло је до грешке при ажурирању базе. ");
            }
            else
                throw new Izuzetak("Нису унети исправни подаци за измену. Покушајте поново.");
        }





    }

    /**
     * @param $naziv
     * @param $opis
     * @throws Izuzetak
     */
    public static function obrisiPredmet($naziv, $opis) //проверити да ли се брише ланчано у сивим табелама
    {
        if( Baza::vratiInstancu()->inUpDel("DELETE FROM predmet WHERE naziv= '{$naziv}' AND opis='{$opis}' ;") )
            echo"Успешно сте обрисали предмет.";
        else
            throw new Izuzetak("Дошло је до грешке при брисању предмета. Покушајте поново.");
    }

    /**
     * @param $ime_prezime
     * @param $kor_ime
     * @param $lozinka
     * @param $e_mail
     * @param $opis
     * @param $status
     * @param $slika_url
     * @return string
     * @throws Izuzetak
     */
    public static function dodajSaradnika($ime_prezime,$kor_ime,$lozinka,$e_mail,$opis,$status,$slika_url="//") //слику мења сарадник када се пријави
    {
        //прво провера да ли постоји
        $korisnik = Korisnik::vratiKorisnika($kor_ime,$lozinka,"saradnik"); // асоц низ са свим атрибутима

        if( $korisnik )
        {
            echo "Такав сарадник већ постоји. Покушајте поново.";
        }
        else
        {
            $upit = "INSERT INTO saradnik (ime_prezime, kor_ime, lozinka, e_mail, opis, status, slika_url) ";
            $upit .= "VALUES ('{$ime_prezime}', '{$kor_ime}', '{$lozinka}', '{$e_mail}', '{$opis}', '{$status}', '{$slika_url}' ) ";

            // echo "Упит за убацивање: " . $upit ;

            Baza::vratiInstancu()->inUpDel($upit);
            if( Baza::vratiInstancu()->vratiObjekatKonekcije()->affected_rows != 0 )
                echo "Успешно сте додали сарадника!";
            else
                echo "Дошло је до грешке при ажурирању базе. Покушајте поново.";
        }
    }

    /**
     * Прва два атрибута су идентификација, остали су опциони
     * Ова метода се позива на ајакс страници. Прво се узимају резултати из базе,
     * онда се пре уписивања у базу пита да сарадник није деактивиран.
     * Дијалог се изводи јаваскриптом
     * @param $ime_prezime
     * @param $e_mail
     * @param string $novo_ime_prez
     * @param string $novo_kor_ime
     * @param string $nova_loz
     * @param string $novi_mejl
     * @param string $novi_opis
     * @param string $novi_status
     * @param string $nova_slika
     * @throws Izuzetak
     */
    public static function izmeniSaradnika($id, $novo_ime_prez="",$novo_kor_ime="",$nova_loz="",$novi_mejl="",$novi_opis="",$novi_status="",$nova_slika="")
    {
        $rezultat = [];
        $niz = array(-1,-1,-1,-1,-1,-1,-1); //овде ће се поставити 0 ако је прослеђен атрибут а није убачен у базу


        //прво провера да ли постоји
        $rezultat = mysqli_fetch_assoc(Baza::vratiInstancu()->select("SELECT saradnik_id FROM saradnik WHERE saradnik_id={$id} ;") );
        if($rezultat["saradnik_id"]!=0 && $rezultat["status"]=="deaktiviran")
        {
            // обавештење: сарадник је деактивиран. Да ли желите да га активирате?
            # ако да, уписује се у базу
            # ако не, прекида се акција и добија се порука
        }

        if(!empty( $rezultat["saradnik_id"]) || $rezultat['saradnik_id']!=0)
        {
            if(!empty($novo_ime_prez))
            {
                if (Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET ime_prezime='{$novo_ime_prez}' WHERE saradnik_id={$id} ;"))
                    $niz[0]=1;
            }
            else
                $niz[0]=0;

            if(!empty($novo_kor_ime))
            {
                if (Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET kor_ime='{$novo_kor_ime}' WHERE saradnik_id={$id}  "))
                    $niz[1]=1;
            }
            else
                $niz[1]=0;

            if(!empty($nova_loz))
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET lozinka='{$nova_loz}' WHERE saradnik_id={$id}  ") )
                    $niz[2]=1;
            }
            else
                $niz[2]=0;

            if(!empty($novi_mejl))
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET e_mail='{$novi_mejl}' WHERE saradnik_id={$id}  ") )
                    $niz[3]=1;
            }
            else
                $niz[3]=0;

            if(!empty($novi_opis))
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET opis='{$novi_opis}' WHERE saradnik_id={$id}  ") )
                    $niz[4]=1;
            }
            else
                $niz[4]=0;

            if(!empty($novi_status))
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET status='{$novi_status}' WHERE saradnik_id={$id}  ") )
                    $niz[5]=1;
            }
            else
                $niz[5]=0;

            if(!empty($nova_slika))
            {
                if( Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET slika_url='{$nova_slika}' WHERE saradnik_id={$id} ") )
                    $niz[6]=1;
            }
            else
                $niz[6]=0;

            $status = 0;
            //провера шта је од задатих параметара промењено; ако није један од задатих, изацује се грешка
            foreach($niz as $n)
            {
                if($n==-1)
                {  echo ("Дошло је до грешке при ажурирања базе. Покушајте поново.");
                  $status = 1; }
            }
            if($status == 1)
                echo ("Дошло је до грешке при ажурирања базе. Покушајте поново.");

            if( Baza::$affected_rows )
                echo "Успешно сте ажурирали сарадника!";
//
        }
        else
            echo "Не постоји такав сарадник.";
    }

    /**
     * Реализовати као линк
     * @param $ime_prezime
     * @param $e_mail
     * @throws Izuzetak
     */
    public static function deaktivirajSaradnika($ime_prezime, $e_mail)
    {
        $saradnik_id = 0;

        //прво провера да ли постоји
        $rezultat = Metode::ocistiNiz(mysqli_fetch_assoc(Baza::vratiInstancu()->select("SELECT saradnik_id FROM saradnik WHERE ime_prezime='{$ime_prezime}' AND e_mail='{$e_mail}' ;") ) );

        if( $rezultat["saradnik_id"] == 0 || empty($rezultat["saradnik_id"]) )
        {
            if( Baza::vratiInstancu()->inUpDel("UPDATE saradnik SET status='"."deaktiviran"."' WHERE saradnik_id={$saradnik_id} ;") )
                echo "Успешно сте променили статус.";
            else
                throw new Izuzetak("Дошло је до грешке при ажурурању базе. Покушајте поново.");
        }
        else
            throw new Izuzetak("Не постоји сарадник са унетим именом и презименом и мејлом.");
    }

    /**
     * Ажурирање табеле Сарадник-Предмет
     * изабира се предмет из падајуће листе, као и сарадник, подаци се прослеђују овој методи
     */
    public static function dodajSaradnikaNaPredmet($saradnik_id, $predmet_id)
    {
        //провера да већ не постоји овај пар
        $upit1 = "SELECT * FROM predmet_saradnik WHERE sardnik_id={$saradnik_id} AND predmet_id={$predmet_id} ; ";
        
       $rezultat = Metode::ocistiNiz( mysqli_fetch_assoc(Baza::vratiInstancu()->select($upit1) ) );

        if( $rezultat["saradnik_id"] == $saradnik_id && $rezultat["predmet_id"] == $predmet_id )
            echo "Сарадник је већ ангажован на том предмету.";
        else
            if( Baza::vratiInstancu()->inUpDel("UPDATE predmet_saradnik SET saradnik_id={$saradnik_id}, predmet_id={$predmet_id} ;") )
                echo "Сарадник је додат на предмет. ";
            else
                throw new Izuzetak("Дошло је до грешке при додавању сарадника на предмет. Покушајте поново.");
    }

    /**
     * Ажурирање табеле Сарадник-Предмет;
     * изабира се сарадник из падајуће листе, излиставају се предмети за датог сарадника,позивом методе из класе Предмет;
     * подаци се прослеђују овој методи
     */
    public static function obrisiSaradnikaSaPredmeta($saradnik_id, $predmet_id)
    {
        //провера да већ не постоји овај пар
        $upit1 = "SELECT * FROM predmet_saradnik WHERE sardnik_id='{$saradnik_id}' AND predmet_id='{$predmet_id}' ;";

        $rezultat = Metode::ocistiNiz( mysqli_fetch_assoc(Baza::vratiInstancu()->select($upit1) ) );

        if( $rezultat["saradnik_id"] == $saradnik_id && $rezultat["predmet_id"] == $predmet_id )
        {
            if( Baza::vratiInstancu()->inUpDel("DELETE FROM predmet_saradnik WHERE saradnik_id='{$saradnik_id}' AND predmet_id='{$predmet_id}' ;") )
                echo "Сарадник је успешно уклоњен са предмета. ";
            else
                throw new Izuzetak("Дошло је до грешке при уклањању сарадника са предмета. Покушајте поново.");
        }
        else
            echo "Сарадник није ангажован на том предмету.";

    }


}

