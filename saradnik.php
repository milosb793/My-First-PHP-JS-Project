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
    <style>


    </style>
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

<div id="stranica" align="center">

    <div id="sadrzaj" align="center"> </div>
</div>

<footer>
Висока школа електротехнике и рачунарства струковних студија <br/> август 2016. </footer>

</body>


<script type="text/javascript" src="js/jquery-3.0.0.js"></script>
<!--<script type="text/javascript" src="js/pr_frm.js" ></script>-->
<script type="text/javascript" src="js/g_fnc.js" ></script>
<script type="text/javascript" src="js/dod_sar.js" ></script>
<script type="text/javascript" src="js/izm_sar.js" ></script>
<script type="text/javascript" src="js/deak_s.js" ></script>
<script type="text/javascript" src="js/dod_pr.js" ></script>
<script type="text/javascript" src="js/izm_pred.js" ></script>
<script type="text/javascript" src="js/ang_sar_pr.js" ></script>
<script type="text/javascript" src="js/ukl_sar_pr.js" ></script>
<script type="text/javascript" src="js/upload.js" ></script>
<script type="text/javascript" src="js/dod_lab_v.js" ></script>
<script type="text/javascript" src="js/bris_pr.js" ></script>
<script type="text/javascript" src="js/login.js" ></script>
<script type="text/javascript" src="js/izm_lab_v.js" ></script>
<script type="text/javascript" src="js/bris_lab_v.js" ></script>
<script type="text/javascript" src="js/izm_sar_pr.js" ></script>



</html>