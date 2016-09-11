<?php
session_start();
require_once "../include/class.Korisnik.php";
require_once "../include/class.Baza.php";
require_once "../include/class.Metode.php";

if(isset($_GET['zid']) && $_GET['zid'] == 0  )
{
    Metode::odjaviSe();
    return;
}


if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $rezultat = "";
    $rezultat .= "
    <div id = 'loginDiv' align='center'>
        <h1  > Пријавите се </h1> <br/>
        <form action = '#' method = 'post' id = 'form' >
            <table border = '0' >
            <tr > <td > Корисничко име:</td >  <td ><input type = 'text' id = 'kor_ime' name = 'kor_ime' class='reqd' />    </td ></tr >
            <tr > <td > Лозинка:       </td >  <td ><input type = 'password' id = 'lozinka' name = 'lozinka' class='reqd' /></td ></tr >
            </table > <br />
        </form >
            <button id='ulogujSe' value='Пријави се' onclick=''>Пријави се </button> <br/> <br/>
    </div >
    ";

    echo $rezultat;
    return;
}


if(isset($_GET['zid']) && $_GET['zid'] == 1 )
{
    if(isset($_POST["kor_ime"]) && isset($_POST["lozinka"]))
    {
        $korisnik = Korisnik::vratiKorisnika($_POST["kor_ime"], $_POST["lozinka"]); // Враћа асоцијативни низ

        if (!empty($korisnik))
        {
            $_SESSION['korisnik'] = $korisnik;
            echo "Успешно сте се улоговали!";
            Metode::autorizuj_js();
            return;
        }
        echo "index.php";
    }
    else echo "Проблем са POST-ом";
}
else echo "Проблем са GET-ом";

