<?php
session_start();
require_once "include/class.Metode.php";
require_once "include/class.Saradnik.php";
if( !isset($_SESSION['korisnik']['saradnik_id']) )
    Metode::autorizuj();
?>

    <!DOCTYPE html>
    <html lang="rs">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Title</title>
    </head>
    <body>
    <a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime'] ?> (одјавите се)</a> <br/> <br/>

    <?php


    echo "Пријављен је админ са ИД-ом: {$_SESSION['korisnik']['saradnik_id']}" . "<br/>";
    echo "Кор. име: {$_SESSION['korisnik']['kor_ime']}" . "<br/>";
    echo "Лозинка(хеш): " . sha1($_SESSION['korisnik']['kor_ime']) . "<br/>";
    //echo "Име и презиме: " . utf8_decode($_SESSION['korisnik']['ime_prezime']) . "<br/>";
    echo "Име и презиме: " . $_SESSION['korisnik']['ime_prezime'] . "<br/>";
    echo "Е-пошта: {$_SESSION['korisnik']['e_mail']}" . "<br/>";
    echo "Опис: {$_SESSION['korisnik']['opis']}" . "<br/>";
    echo "Статус: {$_SESSION['korisnik']['status']}" . "<br/>";

    echo "Слика: " ; echo ( ($_SESSION['korisnik']['slika_url'])== "//" ) ? "Није још увек убачена. <br/>" : "<img src='{$_SESSION['korisnik']['slika_url']}' width='100px' height='100px'/>" . "<br/>";


    ?>

    </body>
    <script type="text/javascript" src="js/jquery-3.0.0.js"></script>
    <script type="text/javascript" src="js/g_fnc.js"></script>

    </html>







