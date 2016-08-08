<?php

$forma = "<form id='noviSaradnik' method='post' action='#' style='display: none;'>";

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
<option name='1' value='aktiviran'></option> 
<option name='0' value='deaktiviran'></option> 
</select> </td></tr>";

$tabela .= "<tr> <td>URL слике: </td> <td> <input type='url' name='slika_url'> </td></tr>";

$tabela .= "</form>";
$tabela .= "<button onclick='prosledi()'>";

$forma .= $tabela;

echo $forma;

