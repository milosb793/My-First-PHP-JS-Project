<?php
session_start();
require_once "include/class.Baza.php";
require_once "include/class.Metode.php";
require_once "include/class.Administrator.php";
require_once "include/class.Saradnik.php";
require_once "include/class.Predmet.php";

if( !isset($_SESSION['korisnik']['admin_id']) )
    Metode::autorizuj();

$svi_saradnici = Saradnik::izlistajSveSaradnike();
$svi_predmeti = Predmet::procitajSve();
$poruka = "Одјави се";


?>

<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .invalid {
            -webkit-box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
            -moz-box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
            box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
        }
        #linkovi {
            display: inline;
        }
    </style>
    <a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime']; echo "({$poruka})"?> </a> <br/> <br/>
</head>
<body>

<div id="linkovi">
    <a href="#" id="dodajSaradnikaLink">Додајте сарадника</a> <br/>
    <a href="#" id="izmeniSaradnikaLink">Измени сарадника</a> <br/>
    <a href="#" id="deaktivirajSaradnikaLink">Деактивирај сарадника</a> <br/>
    <a href="#" id="dodajPredmetLink">Додај нови предмет</a> <br/>
    <a href="#" id="izmeniPredmetLink">Додај нови предмет</a> <br/>
    <hr/>
</div>

<div id="sadrzaj"> </div>

</body>

<script type="text/javascript" src="js/jquery-3.0.0.js"></script>
<script type="text/javascript" src="js/pr_frm.js" defer></script>
<script type="text/javascript" src="js/g_fnc.js" defer></script>
<script type="text/javascript" src="js/dod_sar.js" defer></script>

</html>