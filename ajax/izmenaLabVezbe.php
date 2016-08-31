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

$svi_predmeti = Predmet::procitajSve();
$svi_saradnici = Saradnik::izlistajSveSaradnike();

// приказ изабраног предмета и листе предмета //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $saradnik_id = $_SESSION['korisnik']['saradnik_id'];
    $svi_predmeti_saradnika = Predmet::vratiPredmete($saradnik_id); // nije fetch-ovano

    $rezultat = "<div id='predmeti'>
    <select id='predmet' >
         <option value='' disabled='disabled' selected='selected'> - Изаберите предмет -</option>";
    while($predmet = $svi_predmeti->fetch_assoc() )
    {
        while($pr_sr = $svi_predmeti_saradnika->fetch_assoc())
        {
            if($predmet['predmet_id'] == $pr_sr['predmet_id'])
                $rezultat .="<option value='{$predmet['predmet_id']}'> {$predmet['naziv']} </option>";
        }
        $svi_predmeti_saradnika->data_seek(0);
    }

    $rezultat .= "</select> </div>
    <br/>
    <div id='lab_vezbe' > <span class='poruka'> (Кад изаберете предмет, овде ће се појавити листа вежби.)</span></div>
    <br/>
    <div id='izmenaLabVezbeForma'></div>";

    echo $rezultat;
    return;
}

// листа лаб. вежби //
if(isset($_GET['zid']) && $_GET['zid'] == 1001)
{
    $predmet_id = intval($_GET['predmet_id']);
    $sve_vezbe = Lab_vezba::procitaj_predmet_id($predmet_id); // stvarni asocijativni niz vezbi, fetch-ovan

    $rezultat = "
            <select id='lab_vezba' >
                    <option value='' disabled='disabled' selected='selected'> - Изаберите лаб. вежбу -</option>";
   foreach($sve_vezbe as $vezba)
    {
        $rezultat .= "<option value='{$vezba['lab_vezba_id']}'> {$vezba['naziv']} | {$vezba['datum_odrzavanja']} </option>";
    }
    $rezultat .= "</select>";
    echo $rezultat;
    return;

}

// испис форме //
if(isset($_GET['zid']) && $_GET['zid'] == 1002)
{
    // samo lista predmeta od saradnika, ne ubacuje materijale, testiraj
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

    $predmet = Predmet::procitaj(intval($ta_vezba['predmet_id'])); //fetch-ovano

    //forma
    $rezultat = "
        <form id='izmenaLabVezbe' method='post' action='#' enctype='multipart/form-data'>
             <table border='0' cellpadding='' cellspacing=''>
                  <tr> <td>Назив лаб. вежбе*: </td> <td><input type='text' id='nazivLab'  value='{$ta_vezba['naziv']}'/>           </td> </tr>
                  <tr> <td>Oпис лаб. вежбе*: </td> <td> <input type='text' id='opisLab'  value='{$ta_vezba['opis']}'/>            </td> </tr>
                  <tr> <td>Датум одржавања*: </td> <td> <input type='text' id='datumLab'  value='{$ta_vezba['datum_odrzavanja']}'/> </td> </tr>
                  <tr> <td>Лабораторија*: </td> <td>    <select id='brojLab' >
                        <option value='{$lab['broj_lab']}' selected='selected'> {$lab['broj_lab']} </option>";
                       foreach ($sve_lab as $lab)
                            $rezultat .= "<option value='{$lab}'> {$lab} </option>";

    $rezultat .=" 
            </select>               </td> </tr> <br/>
                <span class='poruka'>(Ако желите да промените сарадника, прво изаберите предмет, па сарадника).</span>
                <tr> <td>Предмет*: </td> <td>         <select id='predmetLab' >
                        <option value='{$ta_vezba['predmet_id']}'  selected='selected'> {$predmet['naziv']}</option>";
                        while($predmet = $svi_predmeti->fetch_assoc() )
                           $rezultat .="<option value='{$predmet['predmet_id']}'> {$predmet['naziv']} </option>";

    $rezultat .="
            </select>            </td> </tr>
            <tr> <td>Сарадник*: </td> <td>        <div id='sar' > <span class='poruka'>(изаберите најпре предмет)</span></div>";

           $rezultat .= "          </td> </tr>
            <tr> <td>Материјали: </td> <td> </td> </tr> <br/>
            <tr><td colspan='2'> <div id='materijali'> </div> </td> </tr>
              
            <tr> <td>Додај нови материјал: </td> <td>       <input type='hidden' name='MAX_FILE_SIZE' value='200000000'> <input type='file' name='file1' id='file1' class=' '/>      </td> </tr>
        </table> <br/>
        <tr> <td colspan='2'><span class='poruka'>(подржани фајлови: 'jpg','png','gif','bmp','pdf','doc','docx','txt','zip','ppt','pptx','xls','xls')</span> </td></tr> <br/>
        <tr> <td colspan='2'><span class='poruka'>(макс. један фајл)</span> </td></tr> <br/>
       
        <progress id='progressBar' value='0' max='100' style='width:300px; background-color: dodgerblue;'>  </progress>
    <h3 id='status'></h3>
    <p id='loaded_n_total'></p> <hr/>
    <button id='izmeniLab' onclick='return false;' >Измени лаб. вежбу</button>
        </form>
    ";
    echo $rezultat;
    return;
}

// приказ тренутног и свих сарадника на изабраном предмету //
if(isset($_GET['zid']) && $_GET['zid'] == 1003)
{
    $predmet_id = intval($_GET['predmet_id']);
    $lab_vezba_id = intval($_GET['lab_vezba_id']);
    $svi_saradnici_sa_predmeta = Saradnik::sviSaradniciNaPredmetu($predmet_id); //fetch-ovano
    $trenutni_saradnik_rs =  Baza::vratiInstancu()->select("SELECT * FROM lab_vezba WHERE predmet_id={$predmet_id} AND lab_vezba_id={$lab_vezba_id}");
    $tr_saradnik = $trenutni_saradnik_rs->fetch_assoc();

    foreach ($svi_saradnici_sa_predmeta as $saradnik )
        if($saradnik['saradnik_id'] == $tr_saradnik['saradnik_id'])
        {
            $tr_saradnik = $saradnik;
            break;
        }

    $rezultat = "<select id='saradnik'>
                    <option value='{$tr_saradnik['saradnik_id']}' selected='selected' > {$tr_saradnik['ime_prezime']} </option>";
    foreach($svi_saradnici_sa_predmeta as $sar)
        $rezultat .= "<option value='{$sar['saradnik_id']}'> {$sar['ime_prezime']} </option>";

    $rezultat .= "</select>";

    echo $rezultat;
    return;
}

// приказ листе материјала //
if(isset($_GET['zid']) && $_GET['zid'] == 1004)
{
    $lab_vezba_id = intval($_GET['lab_vezba_id']);
    $svi_materijali = Materijal::procitaj($lab_vezba_id); //fetch-ovano
    $rezultat = "";
    $status = 0;

    foreach($svi_materijali as $materijal)
    {
        $rs = Baza::vratiInstancu()->select("SELECT fajl_id,naziv,tip,velicina FROM fajlovi WHERE materijal_id={$materijal['materijal_id']}");
        $fajl = $rs->fetch_assoc();
        $tip = substr($fajl['naziv'], strrpos($fajl['naziv'], '.') + 1);

        switch(strtolower(trim($tip)))
        {
            case'pdf':
                $rezultat .= "<div id='fajl{$fajl['fajl_id']}' ><img src=images/pdf.png class='ico_img'/>";
                $status=1;
                break;
            case'jpg':
            case'gif':
            case'jpeg':
            case'bmp':
            case'png':
                $rezultat .= "<div id='fajl{$fajl['fajl_id']}' ><img src=images/image.png class='ico_img'/>";
                $status=1;
                break;
            case'zip':
            case'rar':
                $rezultat .= "<div id='fajl{$fajl['fajl_id']}' ><img src=images/zip.png class='ico_img'/>";
                $status=1;
                break;
            case'txt':
            case'doc':
            case'docx':
                $rezultat .= "<div id='fajl{$fajl['fajl_id']}' ><img src=images/doc.png class='ico_img'/>";
                $status=1;
                break;
            case'xls':
            case'xlsx':
                $rezultat .= "<div id='fajl{$fajl['fajl_id']}' ><img src=images/xls.png class='ico_img'/>";
                $status=1;
                break;
            case'ppt':
            case'pptx':
                $rezultat .= "<div id='fajl{$fajl['fajl_id']}' ><img src=images/ppt.png class='ico_img'/>";
                $status=1;
                break;
            default: $status=0;
                break;
        }
        if($status==1)
        {
            $rezultat .= "<a  href='ajax/download.php?materijal_id={$materijal['materijal_id']}'> {$fajl['naziv']} </a>";
            $rezultat .= "<a  class='obrisiFajl {$materijal['materijal_id']} {$fajl['fajl_id']}'   href='#' > <img src='images/recycle.png' class='ico_img' /> </a></div> <br/>";
        }
        $status=0;
    }

    echo $rezultat;
    return;

}

// брисање //
if(isset($_GET['zid']) && $_GET['zid'] == 0)
{
    echo "proba";
    $fajl_id = intval($_GET['fajl_id']);
    $materijal_id = intval($_GET['materijal_id']);
    if( Baza::vratiInstancu()->inUpDel("DELETE FROM materijal WHERE materijal_id={$materijal_id} ") )
        if(  Baza::vratiInstancu()->inUpDel("DELETE FROM fajlovi WHERE fajl_id={$fajl_id}") )
        {
            echo 'Успешно сте обрисали фајл.'; return;
        }
        else echo Baza::vratiInstancu()->vratiObjekatKonekcije()->error;
    else echo Baza::vratiInstancu()->vratiObjekatKonekcije()->error;
    return;
}

// коначно: измена вежбе
if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    echo "Поздрав из zid = 1 :) lab_id: {$_POST['lab_vezba_id']} naziv: {$_POST['naziv']} \n";
    Saradnik::izmeniLabVezbu(intval($_POST['lab_vezba_id']),$_POST['naziv'],$_POST['opis'],$_POST['datum'],intval($_POST['br_lab']),intval($_POST['predmet_id']),intval($_POST['saradnik_id']));
    return;
}
