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
</head>
<body>

<?php



echo "Пријављен је админ са ИД-ом: {$_SESSION['admin_id']}" . "<br/>";
echo "Кор. име: {$_SESSION['korisnik']['kor_ime']}" . "<br/>";
echo "Лозинка(хеш): " . sha1($_SESSION['korisnik']['kor_ime']) . "<br/>";
echo "Е-пошта: {$_SESSION['korisnik']['e_mail']}";

// код методе, додај предмет:
# try { Administrator::dodajPredmet() } catch($e) { echo $e->getMessag

?>

<a href="#" id="dodajSaradnikaLink">додајте сарадника</a> ";

<div id="dodavanjeSaradnikaForma" style='display: none;' hidden="hidden">

<?php
$forma = "<form id='noviSaradnik' method='post' action='#'>";

$tabela = "<table border='0'>";
$tabela .= "<th>Наслов</th>";
$tabela .= "<tr> <td>Име и презиме: </td> <td> <input type='text' name='ime_prezime'> </td></tr>";
$tabela .= "<tr> <td>Koр. име: </td> <td> <input type='text' name='kor_ime'> </td></tr>";
$tabela .= "<tr> <td>Лозинка: </td> <td> <input type='password' name='lozinka1'> </td></tr>";
$tabela .= "<tr> <td>Поновљена лозинка: </td> <td> <input type='password' name='lozinka2'> </td></tr>";
$tabela .= "<tr> <td>Е-пошта: </td> <td> <input type='email' name='e_mail'> </td></tr>";
$tabela .= "<tr> <td>Опис: </td> <td> <input type='text' name='opis'> </td></tr>";

$tabela .= "<tr> <td>Статус: </td> 
<td> 
<select id='status' name='status'>
<option name='podrazumevano' value='---'></option> 
<option name='1' value='aktiviran'>Активиран</option> 
<option name='0' value='deaktiviran'>Деактивиран</option> 
</select> </td></tr>";

$tabela .= "<tr> <td>URL слике: </td> <td> <input type='url' name='slika_url'> </td></tr>";

$tabela .= "</table> </form>";
$tabela .= "<button id='prosledi' name='prosledi'>Проследи</button>";

$forma .= $tabela;

echo $forma;
?>

</div>

</body>
<script type="text/javascript" src="js/jquery-3.0.0.js"></script>
<script type="text/javascript" src="js/funkcije.js"></script>
<script type="text/javascript" src="js/polja_forme.js"></script>

</html>

