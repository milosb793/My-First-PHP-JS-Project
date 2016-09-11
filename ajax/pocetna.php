<?php

require_once "../include/class.Korisnik.php";
require_once "../include/class.Baza.php";
require_once "../include/class.Metode.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Materijal.php";
require_once "../include/class.Lab_vezba.php";
require_once "../include/class.Izuzetak.php";

$sve_laboratorije_rs = Baza::vratiInstancu()->select("SELECT * FROM laboratorija");
$sve_lab_vezbe =       Lab_vezba::procitajSve(); //fetch-ovano
$svi_predmeti =        Predmet::procitajSve(); //fetch-ovano
$svi_saradnici_rs =    Saradnik::izlistajSveSaradnike();
$svi_saradnici =       array();
$sve_laboratorije =    array();

while($red = $svi_saradnici_rs->fetch_assoc())
    array_push($svi_saradnici,$red);

while($red = $sve_laboratorije_rs->fetch_assoc())
    array_push($sve_laboratorije,$red);


$danas_ceo_datum = time();
$danasnji_dan_br = date("w",time());

$datum_pocetka_ove_nedelje =  date('Y-m-d H:i:s', strtotime("this week"));
$datum_kraja_nedelje = date('Y-m-d H:i:s', strtotime("this week + 6 days"));


// форма //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $ima_vezbi = false;
    $nedelja = 0;
    if(isset($_GET['sedmica']))
        $nedelja = intval($_GET['sedmica']);

    $datum_pocetka_ove_nedelje =  strtotime("{$datum_pocetka_ove_nedelje}+{$nedelja} weeks");
    $datum_kraja_nedelje =  strtotime("{$datum_kraja_nedelje}+{$nedelja} weeks");

    $datum_pocetak = date("d.m.Y H:i:s",$datum_pocetka_ove_nedelje);
    $datum_kraj = date("d.m.Y H:i:s",$datum_kraja_nedelje);

    $rezultat = "<div id='sveVezbePocetnaDiv'> 
                    <select id='sedmica'>
                        <option disabled='disabled'>- Изаберите недељу - </option>
                        <option value='0'>Ове седмице </option>
                        <option value='1'>Следећа седмица </option>
                        <option value='2'>3. седмица </option>
                    </select><br/><br/> <h3>Период:</h3> <br/>од {$datum_pocetak} до {$datum_kraj}";

     $rezultat .=  "
        <br/> <br/> <table id='sveVezbePocetnaForma' border='0' >";

    foreach($sve_lab_vezbe as $vezba)
    {
        $laboratorija = "";
        $predmet_sve = "";
        $saradnik_sve = "";
        $sekunde_trenutne_vezbe = strtotime($vezba['datum_odrzavanja']);

        foreach ($sve_laboratorije as $lab)
        {
            if($vezba['lab_vezba_id'] == $lab['lab_vezba_id'])
                $laboratorija = $lab['broj_lab'];
        }

        foreach ($svi_predmeti as $predmet)
        {
            if($vezba['predmet_id'] == $predmet['predmet_id'])
                $predmet_sve = $predmet;
        }
        foreach($svi_saradnici as $saradnik)
        {
            if($vezba['saradnik_id'] == $saradnik['saradnik_id'])
                $saradnik_sve = $saradnik;
        }
        if( $sekunde_trenutne_vezbe >= $datum_pocetka_ove_nedelje && $sekunde_trenutne_vezbe <= $datum_kraja_nedelje )
        {
            $rezultat .= "<tr class='red'> 
                            <td class='opis'> <a href='#' class='linkPredmet {$predmet_sve['predmet_id']}' onclick='predmetClick(this)'>{$predmet_sve['naziv']}</a> <br/> <br/> 
                                              Датум одржавања: {$vezba['datum_odrzavanja']} <br/> <br/>
                                              Бр. лаб. :{$laboratorija} <br/> <br/>
                                             <a href='#' class='linkVezba {$vezba['lab_vezba_id']}' onclick='vezbaClick(this)'>{$vezba['naziv']}</a></td>  
                            <td class='opis'> Сарадник: <br/><a href='#' class='linkSaradnik {$saradnik_sve['saradnik_id']}' onclick='saradnikClick(this)'>{$saradnik_sve['ime_prezime']}</a> </td> </tr>";
            $ima_vezbi = true;
        }
    }
    if(!$ima_vezbi)
    {
        $rezultat .= "<tr class='red'> <td class='opis' colspan='2'> Нема вежби ове недеље. :) </td> </tr>";
    }

        $rezultat .= "</table></div>";

    // сви предмети //

    $rezultat .= "<br/><br/><h3>Сви предмети:</h3><br/><hr/>";
    foreach ($svi_predmeti as $predmet)
    {
       $rezultat .= "<a href='#' class='linkPredmet {$predmet['predmet_id']}' onclick='predmetClick(this)'>{$predmet['naziv']}</a> <br/> <br/>";
    }

    echo $rezultat;
    return;
}

// предмет //
if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    $predmet_id = $_GET['predmet_id'];

    $predmet = Predmet::procitaj($predmet_id);
    $svi_saradnici_predmeta = Saradnik::sviSaradniciNaPredmetu($predmet_id);


    $rezultat = " <h1>{$predmet['naziv']}</h1><br/><h1>Сарадници на овом предмету:</h1>
                    <div id='predmetOpis'>{$predmet['opis']}</div><br/>
                    <div id='predmetSaradnici'> ";
                    foreach ($svi_saradnici_predmeta as $saradnik)
                    {
                        $rezultat .= "<a class='linkSaradnik {$saradnik['saradnik_id']}' href='#' onclick='saradnikClick(this)'>{$saradnik['ime_prezime']} </a> <br/> ";
                    }
                    $rezultat .= "</div>";

    $rezultat .= "<br/><br/>";
    $rezultat .= "<h1>Лаб. вежбе са овог предмета: </h1><br/><div id='labVezbePredmet'>";
    foreach($sve_lab_vezbe as $vezba)
    {
        if($vezba['predmet_id'] == $predmet_id)
            $rezultat .= "<a href='#' class='linkVezba {$vezba['lab_vezba_id']}' onclick='vezbaClick(this)'>{$vezba['naziv']} - {$vezba['datum_odrzavanja']}</a><br/>";
    }
    $rezultat .= "</div>";

echo $rezultat;
    return;
}

// лаб вежба //
if(isset($_GET['zid']) && $_GET['zid'] == 2)
{
    $lab_vezba_id = $_GET['lab_vezba_id'];
    $lab_vezba = Lab_vezba::procitaj_lab_id($lab_vezba_id);
    $predmet = Predmet::procitaj($lab_vezba['predmet_id']);
    $saradnik = Saradnik::vratiSaradnika($lab_vezba['saradnik_id']);
    $materijal = Materijal::procitaj($lab_vezba_id);
    $ima_materijala = false;
    $fajlovi = array();
    $status = 0;

    foreach ($materijal as $m)
    {
        $rs = Baza::vratiInstancu()->select("SELECT fajl_id, naziv,tip FROM fajlovi WHERE materijal_id={$m['materijal_id']}");
        array_push($fajlovi,$rs->fetch_assoc());
    }

    $rezultat = "<h1>{$lab_vezba['naziv']}</h1><br/><br/><br/>
                <div id='vezbaSviPodaci'>
                    Опис: {$lab_vezba['opis']} <br/> <br/>
                    Датум одржавања: {$lab_vezba['datum_odrzavanja']} <br/><br/>
                    Предмет: <a class='linkPredmet {$predmet['predmet_id']}' href='#' onclick='predmetClick(this)'>{$predmet['naziv']} </a><br/><br/>
                    Сарадник: <a class='linkSaradnik {$saradnik['saradnik_id']}' href='#' onclick='saradnikClick(this)'>{$saradnik['ime_prezime']} </a><br/><br/>
                    <div id='materijaliVezba'><h3>Материјали:</h3>";
                foreach($fajlovi as $fajl)
                {
                    $tip = substr($fajl['naziv'], strrpos($fajl['naziv'], '.') + 1);

                    switch(strtolower(trim($tip)))
                    {
                        case'pdf':
                            $rezultat .= "<img src=images/pdf.png class='ico_img'/>";
                            $status=1;
                            break;
                        case'jpg':
                        case'gif':
                        case'jpeg':
                        case'bmp':
                        case'png':
                            $rezultat .= "<img src=images/image.png class='ico_img'/>";
                            $status=1;
                            break;
                        case'zip':
                        case'rar':
                            $rezultat .= "<img src=images/zip.png class='ico_img'/>";
                            $status=1;
                            break;
                        case'txt':
                        case'doc':
                        case'docx':
                            $rezultat .= "<img src=images/doc.png class='ico_img'/>";
                            $status=1;
                            break;
                        case'xls':
                        case'xlsx':
                            $rezultat .= "<img src=images/xls.png class='ico_img'/>";
                            $status=1;
                            break;
                        case'ppt':
                        case'pptx':
                            $rezultat .= "<img src=images/ppt.png class='ico_img'/>";
                            $status=1;
                            break;
                        default: $status=0;
                            break;
                    }
                        $fajl_id = intval($fajl['fajl_id']);
                        $rezultat .= "<a  href='ajax/download.php?fajl_id={$fajl_id}'> {$fajl['naziv']} </a><br/>";


                }//foreach
                   $rezultat .= "</div>
                </div>";

    echo $rezultat;
    return;
}

// сарадник //
if(isset($_GET['zid']) && $_GET['zid'] == 3)
{
    $saradnik_assoc = [];
    $saradnik = Saradnik::vratiSaradnika(intval($_GET['saradnik_id']));
    $predmet_saradnik_rs = Predmet::vratiPredmete($saradnik['saradnik_id']);


    $rezultat = "
    <div id='slikaNaslov'>
        <div id='tekstProfil'>
            <h2> {$saradnik['ime_prezime']} </h2>
        </div>
        <div id='slika' align='center'> 
            <img id='slikaProfil' src='{$saradnik['slika_url']}' alt='slikaProfil' />
        </div> 
    </div>
    <form id='izmeni' method='post' action='#' >
        <table border='0'>
            <tr> <td>Е-адреса:</td> <td>{$saradnik['e_mail']} </td> </tr>
            <tr> <td>Опис:</td> <td> {$saradnik['opis']} </td> </tr>
            <tr> <td>Предмети:</td> <td><br/> ";

        foreach($svi_predmeti as $predmet)
        {
            while($pr_sr = $predmet_saradnik_rs->fetch_assoc() )
            {
                if( $pr_sr['predmet_id'] == $predmet['predmet_id'] )
                    $rezultat.= "<a href='#' class='linkPredmet {$predmet['predmet_id']}' onclick='predmetClick(this)'>{$predmet['naziv']} </a><br/> ";
            }
            $predmet_saradnik_rs->data_seek(0);
        }

        $rezultat .= "</td> </tr>
        </table>
    </form>
    ";

    echo $rezultat;
    return;

}