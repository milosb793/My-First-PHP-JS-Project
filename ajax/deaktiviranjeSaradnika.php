<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Izuzetak.php";
require_once "../include/class.Metode.php";

if(isset($_GET['zid']) && $_GET['zid'] == 2) 
{
    Administrator::deaktivirajSaradnika(intval(trim($_POST['sid'])));
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1000) 
{
    $svi_saradnici = Saradnik::izlistajSveSaradnike();

$rezultat = "<div id='deaktivirajSaradnikaDiv' style='display: none;' hidden='hidden'>
    <br/>";

$rezultat .= "<div id='padajucaLista2'>
    Изаберите сарадника са листе: <br/>
    <!-- Исписивање динамичке падајуће листе           -->
    <select name='saradnici2' id='saradnici2' class='reqd' >
        <option selected='selected' disabled='disabled'> - Изаберите сарадника - </option>";
        while($row = $svi_saradnici->fetch_assoc())
        {
            if($row['status'] == "aktiviran")
                $rezultat .= "<option value=' {$row['saradnik_id']}' >  {$row['ime_prezime']} </option>";
            else continue;
        }

   $rezultat .=  "</select>
</div>
<br/>
<button id='deaktiviraj' >Деактивирај</button>

</div>";

    echo $rezultat;
    return;
}