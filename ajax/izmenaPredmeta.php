<?php
session_start();
require_once "../include/class.Administrator.php";
require_once "../include/class.Predmet.php";

if(isset($_GET['pid']) )
{
    $predmet = Predmet::procitaj($_GET['pid']);
    if($predmet != false || $predmet != null || !empty($predmet))
        echo "{$predmet['naziv']}|{$predmet['opis']}";
}

// приказ форме //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $saradnik_id = "";
    $predmet_saradnik_rs = "";

    // ако је улогован сарадник, приказују се само предмети на којима је ангажован //
    if(isset($_SESSION['korisnik']['saradnik_id']))
    {
        $saradnik_id = $_SESSION['korisnik']['saradnik_id'];
        $predmet_saradnik_rs = Predmet::vratiPredmete($saradnik_id); //nije fetch-ovano
    }

    $svi_predmeti = Predmet::procitajSve();
    $rezultat = "
<div id='izmeniPredmetDiv' style='display: none;' hidden='hidden'>
    <br/>

    <div id='listaPredmeta'>
    Изаберите предмет са листе: <br/>
        <!-- Исписивање динамичке падајуће листе           -->
        <select name='predmeti' id='predmeti' class='reqd' >
            <option selected='selected' disabled='disabled' hidden='hidden'> - Изаберите предмет - </option>";

        while($row = $svi_predmeti->fetch_assoc() )
        {
            if(isset($_SESSION['korisnik']['saradnik_id']))
            {
                while($pr_sr = $predmet_saradnik_rs->fetch_assoc())
                {
                    if($pr_sr['predmet_id'] == $row['predmet_id'])
                        $rezultat .= "<option value=' {$row['predmet_id']}' > {$row['naziv']} </option>";
                }
                $predmet_saradnik_rs->data_seek(0);
            }
            else
                $rezultat .= "<option value=' {$row['predmet_id']}' > {$row['naziv']} </option>";
        }
        $rezultat .= "
</select>
</div>
<br/> <br/>

<div id='izmeniPredmetForma' style='display: none;' hidden='hidden'>
    <form id='forma' method='post' action='#'>
        <table border='0'>
            <tr >Попуните форму за додавање предмета:</tr> <br/> <br/>";

    if(isset($_SESSION['korisnik']['saradnik_id']))
           $rezultat.="<tr>Назив предмета: <input type='text' id='nazivPredmeta2' class='' placeholder='' disabled='disabled'/> </tr> <br/>";
    else
        $rezultat.="<tr>Назив предмета: <input type='text' id='nazivPredmeta2' class='' placeholder='' /> </tr> <br/>";

   $rezultat.=" <tr>Oпис: </tr>
        </table>
        <textarea id='opisPredmeta2' rows='5' cols='10' maxlength='255' placeholder='' class=''></textarea>
    </form>
    <button id='izmeniPredmet' >Измени</button>
</div>
</div> 
";
    echo $rezultat;
    return;
}

// коначно: измена предмета //
if(isset($_GET['zid']) && $_GET['zid'] == 1)
{
    $naziv = Metode::mysqli_prep($_POST['naziv']);
    $opis = Metode::mysqli_prep($_POST['opis']);

    Administrator::izmeniPredmet(intval($_POST['pid']), $naziv, $opis);
    return;
}
