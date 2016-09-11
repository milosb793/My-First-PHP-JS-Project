<?php
session_start();
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Izuzetak.php";
require_once "../include/class.Metode.php";

// приказ форме //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $saradnik_id = $_SESSION['korisnik']['saradnik_id'];
    $saradnik = Saradnik::vratiSaradnika($saradnik_id); //fetch-ovano
    $rezultat = "
    <div id='slikaNaslov'>
        <div id='tekstProfil'>
            <h2> Мој профил </h2>
        </div>
        <div id='slika' align='center'> 
            <img id='slikaProfil' src='{$saradnik['slika_url']}' alt='slikaProfil' />
        </div> 
    </div>
    <form id='izmeni' method='post' action='#' >
        <table border='0'>
            <tr> <td>Лозинка:</td> <td> <input type='text' id='lozinka' /> </td> </tr>
            <tr> <td>Поновљена лозинка:</td> <td><input type='text' id='lozinka2' /></td> </tr>
            <tr> <td>Опис:</td> <td> <input type='text' id='opis' value='{$saradnik['opis']}' /> </td> </tr>
            <tr> <td>URL слике:</td> <td><input type='url' id='slikaURL' value='{$saradnik['slika_url']}' /></td> </tr>
            <tr> <td colspan='2' class='poruka'>(најпре убаците слику на неки од сервиса попут www.dodaj.rs, imageshack.com ...)</td>  </tr>
            <tr> <td colspan='2'> <br/> <hr/></td> </tr>
            <tr> <td colspan='2'> <button id='izmeniBtn' onclick='return false;' > Измени профил </button></td> </tr>
        </table>
    </form>
    ";

    echo $rezultat;
    return;

}

// коначно: измена сараника //
if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    $lozinka = Metode::mysqli_prep($_POST['lozinka']);
    $opis = Metode::mysqli_prep($_POST['opis']);
    $slika_url = Metode::mysqli_prep($_POST['slika_url']);

    Saradnik::izmenaProfila(intval($_SESSION['korisnik']['saradnik_id']),$lozinka,$opis,$slika_url);
    return;
}
