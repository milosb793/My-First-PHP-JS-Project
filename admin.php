<?php
session_start();
require_once "include/class.Baza.php";
require_once "include/class.Metode.php";
require_once "include/class.Administrator.php";
require_once "include/class.Saradnik.php";
require_once "include/class.Predmet.php";

if( !isset($_SESSION['korisnik']['admin_id']) )
    Metode::autorizuj_js();

$svi_saradnici = Saradnik::izlistajSveSaradnike();
$svi_predmeti = Predmet::procitajSve();
$poruka = " oдјави се";
?>
<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Админ</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/admin.css"/>
    <link rel="stylesheet" href="css/font-awesome.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <script type="text/javascript" src="js/upload.js" ></script>
    <script type="text/javascript" src="js/pr_frm.js" ></script>
</head>
<body>

<header class="header">

    <a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime']; echo "({$poruka})"?> </a> <br/> <br/>

    <nav id="nav">
        <button class="dugmenceMeni" id="pocetna"> Почетна </button>
        <div class="padajuciMeni">
            <button class="dugmenceMeni"> Сарадник <i class="fa fa-sort-desc" aria-hidden="true"></i> </button>
            <div class="padajucaLista">
                <a href="#" id="dodajSaradnikaLink">Додајте сарадника</a>
                <a href="#" id="izmeniSaradnikaLink">Измени сарадника</a>
                <a href="#" id="deaktivirajSaradnikaLink">Деактивирај сарадника</a>
            </div>
        </div>
        <div class="padajuciMeni">
            <button class="dugmenceMeni"> Предмет <i class="fa fa-sort-desc" aria-hidden="true"></i></button>
            <div class="padajucaLista">
                <a href="#" id="dodajPredmetLink">Додај нови предмет</a>
                <a href="#" id="izmeniPredmetLink">Измени предмет</a>
                <a href="#" id="obrisiPredmetLink">Обриши предмет</a>
                <a href="#" id="angazujSaradnikaLink">Ангажуј сарадника на предмет  </a>
                <a href="#" id="ukiniAngazovanjeLink">Укини ангажовање сараднику  </a>
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
    </nav>

</header>

<?php include "include/sadrzaj.php"; ?>

<?php include "include/footer_admin.php"; ?>

