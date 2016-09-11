<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Korisnik.php";
require_once "../include/class.Metode.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Administrator.php";

$svi_predmeti = Predmet::procitajSve();


if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $rezultat =
    "
        <form id='obrisiPr' method='post' action=''> 
        Изаберите предмет за брисање:
        <select id='predmeti' class='reqd'>
            <option value='' disabled='disabled' selected='selected' hidden='hidden'> - Изаберите предмет -</option>";
        while($red = $svi_predmeti->fetch_assoc() )
        {
            $rezultat .= "<option value='{$red['predmet_id']}'> {$red['naziv']} </option>";
        }
           $rezultat .= "</select>            
        <input type='button' id='obrisi' value='Обриши'/>
        </form>
        
    ";

    echo $rezultat;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    Administrator::obrisiPredmet(intval($_POST['predmet_id']));
}