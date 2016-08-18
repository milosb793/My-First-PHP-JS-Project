<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Metode.php";

if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $svi_saradnici = Saradnik::izlistajSveSaradnike();
    $svi_predmeti = Predmet::procitajSve();

    $rezultat =
        "<div id='angazujDiv' > 
        Изаберите сарадника:
        <select name='saradnici' id='saradnici' class='reqd'  >
             <option selected='selected' disabled='disabled'> - Изаберите сарадника - </option> ";
    while ($row = $svi_saradnici->fetch_assoc())
        $rezultat .= "<option value='{$row['saradnik_id']} ?>' > {$row['ime_prezime']} </option>";

    $rezultat .= "</select> <br/> <br/>";

    $rezultat .= "Изаберите предмет: <br/>" .
    "<select name='predmeti' id='predmeti' class='reqd' >
             <option selected='selected' disabled='disabled'> - Изаберите предмет - </option> ";
    while ($row = $svi_predmeti->fetch_assoc())
        $rezultat .= "<option value='{$row['predmet_id']} ?>' > {$row['naziv']} </option>";
    
    $rezultat .= "</select> <br/> <br/>";

    $rezultat .= "<button id='angazuj'>Ангажуј </button>";

    echo $rezultat;
    return;
}

if(isset($_GET['saradnik_id']) )
{
    $vec_na_predmetu = false;
    $saradnik_id = intval($_GET['saradnik_id']);
    $predmet_id = intval($_GET['predmet_id']);
    $saradnik = Predmet::vratiPredmete($saradnik_id);

    while($red = $saradnik->fetch_assoc())
        if($red['predmet_id'] == $predmet_id)
        {
            $vec_na_predmetu = true;
            echo "true";
            return;
        }

    if(!$vec_na_predmetu)
    {
        $upit = "INSERT INTO predmet_saradnik VALUES ({$saradnik_id},{$predmet_id})";
        Baza::vratiInstancu()->inUpDel($upit);
        if(Baza::$affected_rows)
            echo "Успешно сте ангажовали сарадника!";
        else
            echo "Дошло је до грешке при убацивању у базу!";
    }
}
