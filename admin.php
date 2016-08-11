<?php
session_start();
require_once "include/class.Metode.php";
Metode::autorizuj("admin_id");
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
    </style>
</head>
<body>

<?php



echo "Пријављен је админ са ИД-ом: {$_SESSION['admin_id']}" . "<br/>";
echo "Кор. име: {$_SESSION['korisnik']['kor_ime']}" . "<br/>";
echo "Лозинка(хеш): " . sha1($_SESSION['korisnik']['kor_ime']) . "<br/>";
echo "Е-пошта: {$_SESSION['korisnik']['e_mail']}" . '\n';

// код методе, додај предмет:
# try { Administrator::dodajPredmet() } catch($e) { echo $e->getMessag

?>

<a href="#" id="dodajSaradnikaLink">додајте сарадника</a> ";

<div id="dodavanjeSaradnikaForma" style='display: none;' hidden="hidden">

<?php
$forma = "<form id='noviSaradnik' method='post' action='#'>";

$tabela = "<table border='0'>";
$tabela .= "<th>Наслов</th>";
$tabela .= "<tr> <td>Име и презиме*: </td> <td> <input type='text' id='ime_prezime' class='reqd ime_prezime'/>      </td> <td id='greska' hidden='hidden'>" .$poruka. "</td> </tr>";
$tabela .= "<tr> <td>Koр. име*: </td> <td> <input type='text' id='kor_ime' class='reqd kor_ime'/>               </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Лозинка*: </td> <td> <input type='password' id='lozinka' class='reqd lozinka'/>            </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Поновљена лозинка*: </td> <td> <input type='password' id='lozinka2' class='reqd lozinka'/> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Е-пошта*: </td> <td> <input type='email' id='e_mail' class='reqd email '/>               </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Опис: </td> <td> <input type='text' id='opis' class=''/>                          </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Статус*: </td> 
<td> 
<select id='status' name='status' class='' >
<option name='podrazumevano' value='---'></option> 
<option name='1' value='aktiviran'>Активиран</option> 
<option name='0' value='deaktiviran'>Деактивиран</option> 
</select> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";

$tabela .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url' class='slika_url'/> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";

$tabela .= "</table> </form>";
$tabela .= "<button id='prosledi' name='prosledi'>Проследи</button>";

$forma .= $tabela;

echo $forma;
?>

</div>

</body>
<!--<script type="text/javascript" src="js/polja_forme.js"></script>-->
<script type="text/javascript" src="js/jquery-3.0.0.js"></script>
<script type="text/javascript" src="js/funkcije.js"></script>

</html>

