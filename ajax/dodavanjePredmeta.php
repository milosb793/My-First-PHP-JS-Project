<?php

require_once "../include/class.Administrator.php";

if(isset($_GET['zid']) && $_GET['zid'] == 1) {
    Administrator::dodajPredmet($_POST['naziv'], $_POST['opis']);
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1000) {
    $rezultat = "<div id='dodajPredmetDiv' style='display: none;' hidden='hidden'>
    <form id='dodajPredmetForma' method='post' action='#'>
    <table border='0'>
        <tr >Попуните форму за додавање предмета:</tr> <br/> <br/>
        <tr>Назив предмета*: <input type='text' id='nazivPredmeta' class='reqd'/></tr> <br/>
        <tr>Oпис: </tr>
    </table>
        <textarea id='opisPredmeta' rows='5' cols='15' maxlength='255' ></textarea>
    </form>
        <button id='dodajPredmet' >Додај</button>

</div>";

    echo $rezultat;
    return;

}

