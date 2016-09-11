<?php
session_start();
require_once "../include/class.Korisnik.php";
require_once "../include/class.Baza.php";
require_once "../include/class.Metode.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Materijal.php";
require_once "../include/class.Lab_vezba.php";
require_once "../include/class.Izuzetak.php";

// листа предмета //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $svi_predmeti = Predmet::procitajSve(); //nije fetch-ovano
    $rezultat = "";

    $rezultat .= "<h3>Брисање лаб. вежбе:</h3><br/>";
    $rezultat .= "<select id='predmeti'>
                        <option value='' selected='selected' disabled='disabled' hidden='hidden'>- Изаберите предмет - </option>";

    if(isset($_SESSION['korisnik']['saradnik_id']))
    {
        $saradnik_id = $_SESSION['korisnik']['saradnik_id'];
        $svi_predmeti_saradnika = Predmet::vratiPredmete($saradnik_id); // nije fetch-ovano, samo id-ovi

        while ($predmet = $svi_predmeti->fetch_assoc())
        {
            while ($saradnik_na_predmetu = $svi_predmeti_saradnika->fetch_assoc())
            {
                if ($predmet['predmet_id'] == $saradnik_na_predmetu['predmet_id'])
                    $rezultat .= "<option value='{$predmet['predmet_id']}' > {$predmet['naziv']}</option>";
            }
            $svi_predmeti_saradnika->data_seek(0);
        }
    }
    else
    {
        while ($predmet = $svi_predmeti->fetch_assoc())
        {
            $rezultat .= "<option value='{$predmet['predmet_id']}' > {$predmet['naziv']}</option>";
        }
    }

    $rezultat .= "</select><br/> <div id='lab'></div>";
    $svi_predmeti->data_seek(0);

    echo $rezultat;
    return;

}

// листа лаб. вежби //
if(isset($_GET['zid']) && $_GET['zid'] == 1001)
{
    $rezultat = "<br/><select id='lab_vezbe'>
                    <option value='' selected='selected' disabled='disabled' hidden='hidden'>- Изаберите лаб. вежбу - </option>";
    $predmet_id = $_GET['predmet_id'];

    $sve_vezbe_sa_predmeta = Lab_vezba::procitaj_predmet_id($predmet_id); // fetch-ovano

    foreach($sve_vezbe_sa_predmeta as $vezba)
    {
        $rezultat .= "<option value='{$vezba['lab_vezba_id']}' > {$vezba['naziv']}, {$vezba['datum_odrzavanja']} </option>";
    }

    $rezultat .= "</select> <br/>";

    $rezultat .= "<hr/> <button id='obrisiLab'>Обриши лаб. вежбу</button>";
    echo $rezultat;
    return;
}

// коначно: брисање //
if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    Saradnik::obrisiLabVezbu(intval($_GET['lab_vezba_id']));
    return;
}
