<?php
session_start();
require_once "include/class.Korisnik.php";
require_once "include/class.Baza.php";
require_once "include/class.Metode.php";

if(isset($_GET['id']) && $_GET['id'] == 1  )
{
    Metode::odjaviSe();
}

if(isset($_POST["kor_ime"]) && isset($_POST["lozinka"]))
{
    $korisnik =  Korisnik::vratiKorisnika($_POST["kor_ime"], $_POST["lozinka"]); // Враћа асоцијативни низ

    if( !empty($korisnik) )
    {
        $_SESSION['korisnik'] = $korisnik;
        Metode::autorizuj();
    }
}
?>


<!doctype html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Пријављивање</title>
</head>
<body>

<h1>Пријавите се</h1>
<hr>

<form action="login.php" method="post" id="form">

    <label for="kor_ime">Корисничко име: <input type="text" id="kor_ime" name="kor_ime"/> </label> <br>
    <label for="lozinka">Лозинка:        <input type="password" id="lozinka" name="lozinka"/> </label> <br>

    <input id="ulogujSe" type="submit" value="Потврди"/>

</form>

</body>

<script src="js/jquery-3.0.0.js"></script>
<script src="js/funkcije.js"></script>

</html>

