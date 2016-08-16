<?php

require_once "../include/class.Administrator.php";
require_once "../include/class.Predmet.php";

if(isset($_GET['zid']) && $_GET['zid'] == 1)
    Administrator::izmeniPredmet($_POST['pid'], $_POST['naziv'], $_POST['opis']);

if(isset($_GET['pid']) )
{
    $predmet = Predmet::procitaj($_GET['pid']);
    if($predmet != false || $predmet != null || !empty($predmet))
        echo "{$predmet['naziv']}|{$predmet['opis']}";
}

if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{

    $svi_predmeti = Predmet::procitajSve();
    $rezultat = "
<div id='izmeniPredmetDiv' style='display: none;' hidden='hidden'>
    <br/>

    <div id='listaPredmeta'>
    Изаберите предмет са листе: <br/>
        <!-- Исписивање динамичке падајуће листе           -->
        <select name='predmeti' id='predmeti' class='reqd' >
            <option selected='selected' disabled='disabled'> - Изаберите предмет - </option>";
        while($row = $svi_predmeti->fetch_assoc() )
           $rezultat .= "<option value=' {$row['predmet_id']}' > {$row['naziv']} </option>";
    $rezultat .= "
</select>
</div>
<br/> <br/>

<div id='izmeniPredmetForma' style='display: none;' hidden='hidden'>
    <form id='forma' method='post' action='#'>
        <table border='0'>
            <tr >Попуните форму за додавање предмета:</tr> <br/> <br/>
            <tr>Назив предмета: <input type='text' id='nazivPredmeta2' class='' placeholder=''/> </tr> <br/>
            <tr>Oпис: </tr>
        </table>
        <textarea id='opisPredmeta2' rows='5' cols='15' maxlength='255' placeholder='' class=''></textarea>
    </form>
    <button id='izmeniPredmet' >Измени</button>
</div>
</div> 
";

    echo $rezultat;
    return;
}