<?php
require_once "../include/class.Korisnik.php";
require_once "../include/class.Metode.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Materijal.php";
require_once "../include/class.Lab_vezba.php";

$svi_predmeti = Predmet::procitajSve();
$svi_saradnici = Saradnik::izlistajSveSaradnike();

if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $rezultat = "<div id='predmeti'>
    Изаберите предмет са листе:
    <select id='predmet' class='reqd'>
         <option value='' disabled='disabled' selected='selected'> - Изаберите предмет -</option>";
    while($predmet = $svi_predmeti->fetch_assoc() )
        $rezultat .="<option value='{$predmet['predmet_id']}'> {$predmet['naziv']} </option>";

    $rezultat .= "</select> </div>

    <div id='lab_vezbe' > <i style='font-size: 8pt;'> (Кад изаберете предмет, овде ће се појавити листа вежби.)</i></div>
    <div id='izmenaLabVezbeForma'></div>";

    echo $rezultat;
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1001)
{
    $predmet_id = intval($_GET['predmet_id']);
    $sve_vezbe = Lab_vezba::procitaj_predmet_id($predmet_id); // stvarni asocijativni niz vezbi, fetch-ovan

    $rezultat = "
            <select id='lab_vezba' class='reqd'>
                    <option value='' disabled='disabled' selected='selected'> - Изаберите лаб. вежбу -</option>";
   foreach($sve_vezbe as $vezba)
    {
        $rezultat .= "<option value='{$vezba['lab_vezba_id']}'> {$vezba['naziv']} | {$vezba['datum_odrzavanja']} </option>";

    }
    $rezultat .= "</select>";
    echo $rezultat;
    return;

}

if(isset($_GET['zid']) && $_GET['zid'] == 1002)
{
    $lab_vezba_id = intval($_GET['lab_vezba_id']);
    $vezbe = Lab_vezba::procitaj_lab_id($lab_vezba_id); //враћа вежбу
    $lab_rs = Baza::vratiInstancu()->select("SELECT * FROM laboratorija WHERE lab_vezba_id={$lab_vezba_id}");
    $lab = $lab_rs->fetch_assoc();
    $sve_lab = [
        101,102,103,104,105,106,107,108,109,201,202,203,204,205,206,207,208,209,
        301,302,303,304,305,306,307,308,309,401,402,403,404,405,406,407,408,409,
        501,502,503,504,505,506,507,508,509
    ];
    $ta_vezba = [];
    for($i=0; $i<count($vezbe); $i++)
    {
        if($vezbe[$i]['lab_vezba_id'] == $lab_vezba_id)
        {
            $ta_vezba = $vezbe[$i];
            break;
        }
    }
    var_dump($ta_vezba);
    $predmet = Predmet::procitaj(intval($ta_vezba['predmet_id'])); //fetch-ovano

    //forma
    $rezultat = "
        <form id='izmenaLabVezbe' method='post' action='#' enctype='multipart/form-data'>
             <table border='0' cellpadding='' cellspacing=''>
                  <tr> <td>Назив лаб. вежбе*: </td> <td><input type='text' id='nazivLab' class='reqd' value='{$ta_vezba['naziv']}'/>           </td> </tr>
                  <tr> <td>Oпис лаб. вежбе*: </td> <td> <input type='text' id='opisLab' class='reqd' value='{$ta_vezba['opis']}'/>            </td> </tr>
                  <tr> <td>Датум одржавања*: </td> <td> <input type='datetime-local' id='datumLab' class='reqd' value='{$ta_vezba['datum_odrzavanja']}'/> </td> </tr>
                  <tr> <td>Лабораторија*: </td> <td>    <select id='brojLab' class='reqd'>
                        <option value='{$lab['broj_lab']}' selected='selected'> {$lab['broj_lab']} </option>";
                       foreach ($sve_lab as $lab)
                            $rezultat .= "<option value='{$lab}'> {$lab} </option>";

    $rezultat .=" 
            </select>               </td> </tr>
                <tr> <td>Предмет*: </td> <td>         <select id='predmetLab' class='reqd'>
                        <option value='{$ta_vezba['predmet_id']}'  selected='selected'> {$predmet['naziv']}</option>";
                        while($predmet = $svi_predmeti->fetch_assoc() )
                           $rezultat .="<option value='{$predmet['predmet_id']}'> {$predmet['naziv']} </option>";

    $rezultat .="
            </select>            </td> </tr>
            <tr> <td>Сарадник*: </td> <td>        <div id='sar' > <i>(изаберите најпре предмет)</i></div>";


           $rezultat .= "          </td> </tr>
            <tr> <td>Материјали: </td> <td><div id='materijali'> </div> </td> </tr> izlistavanje
              
              
            <tr> <td>Додај нови материјал: </td> <td>       <input type='hidden' name='MAX_FILE_SIZE' value='200000000'> <input type='file' name='file1' id='file1' class=' '/>      </td> </tr>
        </table> <br/>

        <progress id='progressBar' value='0' max='100' style='width:300px; background-color: dodgerblue;'>  </progress>
    <h3 id='status'></h3>
    <p id='loaded_n_total'></p> <hr/>
        <input type='button' id='izmeniLab' value='Измени лаб. вежбу' />
        </form>
    ";
    echo $rezultat;
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1003)
{
    $predmet_id = intval($_GET['predmet_id']);
    $lab_vezba_id = intval($_GET['lab_vezba_id']);
    $svi_saradnici_sa_predmeta = Saradnik::sviSaradniciNaPredmetu($predmet_id); //fetch-ovano
    $trenutni_saradnik_rs =  Baza::vratiInstancu()->select("SELECT * FROM lab_vezba WHERE saradnik_id={$saradnik_id} AND lab_vezba_id={$lab_vezba_id}");
    $tr_saradnik = $trenutni_saradnik_rs->fetch_assoc();

    foreach ($svi_saradnici_sa_predmeta as $saradnik )
        if($saradnik['saradnik_id'] == $tr_saradnik['saradnik_id'])
        {
            $tr_saradnik = $saradnik;
            break;
        }

    $rezultat = "<select id='saradnik'>
                    <option value='{$saradnik_id}' selected='selected' > {$tr_saradnik['ime_prezime']} </option>";
    foreach($svi_saradnici_sa_predmeta as $sar)
        $rezultat .= "<option value='{$sar['saradnik_id']}'> {$sar['ime_prezime']} </option>";

    $rezultat .= "</select>";

    echo $rezultat;
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1004)
{
    $lab_vezba_id = intval($_GET['lab_vezba_id']);
    $svi_materijali = Materijal::procitaj($lab_vezba_id); //fetch-ovano
    $rezultat = "";

    foreach($svi_materijali as $materijal)
    {
        $rs = Baza::vratiInstancu()->select("SELECT naziv,tip FROM fajlovi WHERE materijal_id={$materijal['materijal_id']}");
        $fajl = $rs->fetch_assoc();
        $tip = substr($fajl['naziv'], -4);
        switch($tip)
        {
            case'.pdf':
                $rezultat .= "<img src=images/pdf.png class='ico_img'/>";
                break;
            case'.jpg':
            case'.gif':
            case'.jpeg':
            case'.bmp':
            case'.png':
                $rezultat .= "<img src=images/image.png class='ico_img'/>";
                break;
            case'.zip':
            case'.rar':
                $rezultat .= "<img src=images/zip.png class='ico_img'/>";
                break;
            case'.txt':
            case'.doc':
            case'.docx':
                $rezultat .= "<img src=images/doc.png class='ico_img'/>";
                break;
            case'.xls':
            case'.xlsx':
                $rezultat .= "<img src=images/xls.png class='ico_img'/>";
                break;
            case'.ptt':
            case'.pttx':
                $rezultat .= "<img src=images/ppt.png class='ico_img'/>";
                break;
            default: $rezultat .= "<p> нешто није у реду... Тип: {$tip} </p>";
                break;
        }

        $rezultat .= "<a href='ajax/download.php?materijal_id={$materijal['materijal_id']}'> {$fajl['naziv']} </a>" . "<br/>";
    }

    echo $rezultat;
    return;
}
