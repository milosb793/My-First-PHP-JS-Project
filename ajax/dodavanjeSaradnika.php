<?php
require_once "../include/class.Administrator.php";

// приказ форме //
if(isset($_GET['zid']) && $_GET['zid']==1)
{
$rezultat = "<div id='dodavanjeSaradnikaForma' style='display: none;' hidden='hidden'> <br/> <h1>Додавање сарадника</h1> <br/>";
$rezultat .= "<form id='noviSaradnik' method='post' action='#'>";
$rezultat .= "<table border='0'>";
$rezultat .= "<th></th>";
$rezultat .= "<tr> <td>Име и презиме*: </td>    <td> <input type='text' id='ime_prezime1' class='reqd'/></td> <td> <span id='greska'></span> </td> </tr>";
$rezultat .= "<tr> <td>Koр. име*: </td>         <td> <input type='text' id='kor_ime1' class='reqd'/> </td> <td> <span id='greska'></span> </td> </tr>";
$rezultat .= "<tr> <td>Лозинка*: </td>          <td> <input type='password' id='lozinka1'  class='reqd loz'/></td> <td> <span id='greska'></span> </td>  </tr>";
$rezultat .= "<tr> <td>Поновљена лозинка*: </td><td> <input type='password' id='lozinka2'  class='reqd '/></td> <td> <span id='greska'></span> </td>  </tr>";
$rezultat .= "<tr> <td>Е-пошта*: </td>          <td> <input type='email' id='e_mail1' class='reqd '/> </td> <td> <span id='greska'></span> </td> </tr>";
$rezultat .= "<tr> <td>Опис: </td>              <td> <input type='text' id='opis1' class=''/> </td> <td> <span id='greska'></span> </td> </tr>";
$rezultat .= "<tr> <td>Статус: </td> 
<td> 
<select id='status1' name='status1' class='reqd' >
<option name='1' value='aktiviran'>Активиран</option> 
<option name='0' value='deaktiviran' selected='selected'>Деактивиран</option> 
</select> </td>  <td> <span id='greska'></span> </td></tr>";

$rezultat .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url1' class=''/> </td>   </tr>";

$rezultat .= "</table> </form>";
$rezultat .= "<button id='prosledi1' name='prosledi1' >Проследи</button>";

echo $rezultat . "</div>";
    return;
}
// коначно: додавање сарадника //
if(isset($_GET['zid']) && $_GET['zid'] == 2)
{
    $ime_prezime = Metode::mysqli_prep($_POST['ime_prezime']);
    $kor_ime = Metode::mysqli_prep($_POST['kor_ime']);
    $lozinka = Metode::mysqli_prep($_POST['lozinka']);
    $e_mail = Metode::mysqli_prep($_POST['e_mail']);
    $opis = Metode::mysqli_prep($_POST['opis']);
    $status = Metode::mysqli_prep($_POST['status']);
    $slika_url = Metode::mysqli_prep($_POST['slika_url']);

    Administrator::dodajSaradnika($ime_prezime, $kor_ime, $lozinka, $e_mail, $opis, $status, $slika_url);
    return;
}

