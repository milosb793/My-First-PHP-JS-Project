<?php
require_once "../include/class.Baza.php";

require_once "../include/class.Administrator.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Metode.php";

if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $svi_saradnici = Saradnik::izlistajSveSaradnike();

    $rezultat =
        " 
        Изаберите сарадника:
        <select name='saradnici' id='saradnici' class='reqd'  >
             <option selected='selected' disabled='disabled'> - Изаберите сарадника - </option> ";
    while ($row = $svi_saradnici->fetch_assoc())
        $rezultat .= "<option value='{$row['saradnik_id']} ' > {$row['ime_prezime']} </option>";

    $rezultat .= "</select> <br/> <br/>";
    $rezultat .= "Изаберите предмет(најпре изаберите сарадника): <br/> <div id='predmeti'></div>";


    echo $rezultat;
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1001)
{
    $saradnik_id = intval($_GET['saradnik_id']);
    $predmeti_id = Predmet::vratiPredmete($saradnik_id); //враћа низ предмет ид-ова
    $predmeti = Predmet::procitajSve(); // сви предмети
    $niz_predmeta = array();
    $option = "";

    while($id = $predmeti_id->fetch_assoc())
    {
        while($predmet = $predmeti->fetch_assoc())
        {
            if($predmet['predmet_id'] == $id['predmet_id'])
                $option .= "<option value='{$predmet['predmet_id']}'> {$predmet['naziv']} </option>";
        }
        $predmeti->data_seek(0);
    }

    $rezultat =
        "<select name='predmeti' id='predmeti' class='reqd' >
             <option selected='selected' disabled='disabled'> - Изаберите предмет - </option> " . $option;

    $rezultat .= "</select> <br/> <br/>";

    $rezultat .= "<button id='ukloni'>Уклони са предмета </button>";
    echo $rezultat;
    return;
}
if(isset($_GET['zid']) && $_GET['zid'] == 1 )
{
    $saradnik_id = intval($_GET['saradnik_id']);
    $predmet_id = intval($_GET['predmet_id']);

    Administrator::obrisiSaradnikaSaPredmeta($saradnik_id,$predmet_id);
}
