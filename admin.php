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
        nav{
            width: 100%;
            text-align: center;
        }
        ul {
            text-align: center;
            position: relative;
            display: inline-block;
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        li {
            float: left;
        }

        li a {
            text-decoration: none;
            display: inline;
            padding: 2px;
            background-color: rgba(255, 206, 172, 0.67);
         }
        #odjaviSe{

        }
    </style>
    <a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime']; echo "({$poruka})"?> </a> <br/> <br/>
</head>
<body>

<nav id="nav" >
    <ul id="linkovi">
       <li> <a href="#" id="dodajSaradnikaLink">Додајте сарадника | </a> </li>
        <li><a href="#" id="izmeniSaradnikaLink">Измени сарадника | </a></li>
        <li><a href="#" id="deaktivirajSaradnikaLink">Деактивирај сарадника | </a></li>
        <li><a href="#" id="angazujSaradnikaLink">Ангажуј сарадника на предмет | </a></li>
        <li><a href="#" id="ukiniAngazovanjeLink">Укини ангажовање сараднику | </a></li>
        <li><a href="#" id="dodajPredmetLink">Додај нови предмет | </a> </li>
        <li><a href="#" id="izmeniPredmetLink">Измени предмет</a> </li>
    </ul>
</nav>
    <hr/>


<div id="sadrzaj" align="center"> </div>

</body>

<script type="text/javascript" src="js/jquery-3.0.0.js"></script>
<script type="text/javascript" src="js/pr_frm.js" ></script>
<script type="text/javascript" src="js/g_fnc.js" ></script>
<script type="text/javascript" src="js/dod_sar.js" ></script>
<script type="text/javascript" src="js/izm_sar.js" ></script>
<script type="text/javascript" src="js/deak_s.js" ></script>
<script type="text/javascript" src="js/dod_pr.js" ></script>
<script type="text/javascript" src="js/izm_pred.js" ></script>
<script type="text/javascript" src="js/ang_sar_pr.js" ></script>
<script type="text/javascript" src="js/ukl_sar_pr.js" ></script>

</html>