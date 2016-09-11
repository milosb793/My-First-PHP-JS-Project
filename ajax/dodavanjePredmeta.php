<?php
require_once "../include/class.Administrator.php";
require_once "../include/class.Metode.php";

//
if(isset($_GET['zid']) && $_GET['zid'] == 1000) {
    $rezultat = "<div id='dodajPredmetDiv' style='display: none;' hidden='hidden'>
    <form id='dodajPredmetForma' method='post' action='#'>
    <table border='0'>
        <tr >Попуните форму за додавање предмета:</tr> <br/> <br/>
        <tr> <td>Назив предмета*:</td> <td> <input type='text' id='nazivPredmeta' class='reqd'/> &nbsp;&nbsp;&nbsp;</td> <td> <span id='greska'></span> </td> </tr> <br/>
        <tr><td colspan='3'> Oпис: </td></tr>
        <tr > <td colspan='3'> <textarea id='opisPredmeta' rows='5' cols='33' maxlength='255' ></textarea> </td>  </tr>
    </table>
    </form>
        <button id='dodajPredmet' onclick='return false;'>Додај</button>

</div>";

    echo $rezultat;
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    $naziv = Metode::mysqli_prep($_POST['naziv']);
    $opis = Metode::mysqli_prep($_POST['opis']);

    Administrator::dodajPredmet($naziv, $opis);
}