<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Izuzetak.php";
require_once "../include/class.Metode.php";

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $saradnik = mysqli_fetch_assoc(Baza::vratiInstancu()->select("SELECT * FROM saradnik WHERE saradnik_id={$id}"));
    echo $saradnik['saradnik_id'] . "|" . $saradnik['ime_prezime'] . "|" . $saradnik['kor_ime'] . "|" . $saradnik['lozinka'] . "|" . $saradnik['e_mail'] . "|" . $saradnik['opis'] . "|" . $saradnik['slika_url'];
    unset($_GET);
    return;
}


if(isset($_POST['sid']))
{

    $sid = intval($_POST['sid']);
    $saradnik = mysqli_fetch_assoc(Baza::vratiInstancu()->select("SELECT * FROM saradnik WHERE saradnik_id='{$sid}' "));

    Administrator::izmeniSaradnika($sid, $_POST['ime_prezime'], $_POST['kor_ime'], $_POST['lozinka'], $_POST['e_mail'], $_POST['opis'], $_POST['status'], $_POST['slika_url']);
}


