<?php
session_start();
require_once "include/class.Baza.php";
require_once "include/class.Metode.php";
require_once "include/class.Administrator.php";
require_once "include/class.Saradnik.php";
require_once "include/class.Predmet.php";

if( !isset($_SESSION['korisnik']['saradnik_id']) )
    Metode::autorizuj_js();

$svi_saradnici = Saradnik::izlistajSveSaradnike();
$svi_predmeti = Predmet::procitajSve();
$poruka = " oдјави се";
?>
<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Сарадник</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/saradnik.css"/>
    <link rel="stylesheet" href="css/font-awesome.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <script type="text/javascript" src="js/upload.js" ></script>
</head>
<body>

<header class="header">

    <a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime']; echo "({$poruka})"?> </a> <br/> <br/>

    <nav id="nav">
        <button class="dugmenceMeni" id="pocetna"> Почетна </button>
        <div class="padajuciMeni">
            <button class="dugmenceMeni"> Предмет <i class="fa fa-sort-desc" aria-hidden="true"></i></button>
            <div class="padajucaLista">
                <a href="#" id="izmeniPredmetLink">Измени предмет</a>
            </div>
        </div>
        <div class="padajuciMeni">
            <button class="dugmenceMeni"> Лаб. вежба <i class="fa fa-sort-desc" aria-hidden="true"></i></button>
            <div class="padajucaLista">
                <a href="#" id="dodajLabVezbuLink"> Додај лаб. вежбу  </a>
                <a href="#" id="izmeniLabVezbuLink"> Измени лаб. вежбу  </a>
                <a href="#" id="obrisiLabVezbuLink"> Обриши лаб. вежбу  </a>
            </div>
        </div>
        <div id="profil" > <a id='profilLink' href="#">Мој профил</a> <img src="<?php echo $_SESSION['korisnik']['slika_url']; ?>" /></div>
    </nav>

</header>

<?php include "include/sadrzaj.php"; ?>

<?php include "include/footer_saradnik.php"; ?>

