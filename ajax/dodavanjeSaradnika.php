<?php
require_once "../include/class.Administrator.php";


if(isset($_GET['zid']) && $_GET['zid']==1)
{
$rezultat = "<div id='dodavanjeSaradnikaForma' style='display: none;' hidden='hidden'>";


$rezultat .= "<form id='noviSaradnik' method='post' action='#'>";

$rezultat .= "<table border='0'>";
$rezultat .= "<th>Наслов</th>";
$rezultat .= "<tr> <td>Име и презиме*: </td>    <td> <input type='text' id='ime_prezime1' class='reqd ime_prezime1'/>      </td> </tr>";
$rezultat .= "<tr> <td>Koр. име*: </td>         <td> <input type='text' id='kor_ime1' class='reqd kor_ime1'/>               </td> </tr>";
$rezultat .= "<tr> <td>Лозинка*: </td>          <td> <input type='password' id='lozinkaI'  class='reqd '/>            </td>   </tr>";
$rezultat .= "<tr> <td>Е-пошта*: </td>          <td> <input type='email' id='e_mail1' class='reqd email1'/>                </tr>";
$rezultat .= "<tr> <td>Опис: </td>              <td> <input type='text' id='opis1' class=''/>                            </tr>";
$rezultat .= "<tr> <td>Статус: </td> 
<td> 
<select id='status1' name='status1' class='' >
<option name='1' value='aktiviran'>Активиран</option> 
<option name='0' value='deaktiviran' selected='selected'>Деактивиран</option> 
</select> </td>  </tr>";

$rezultat .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url1' class='slika_url'/> </td>   </tr>";

$rezultat .= "</table> </form>";
$rezultat .= "<button id='prosledi1' name='prosledi1'>Проследи</button>";

echo $rezultat . "</div>";
    return;
}

if(isset($_POST['ime_prezime']))
{
    Administrator::dodajSaradnika($_POST['ime_prezime'], $_POST['kor_ime'], $_POST['lozinka'], $_POST['e_mail'], $_POST['opis'], $_POST['status'], $_POST['slika_url']);
    return;
}

//echo "Поздрав са странице!";
//echo "Поздрав са странице!!";



?>