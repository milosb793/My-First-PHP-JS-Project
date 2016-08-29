<?php
session_start();
require_once "include/class.Baza.php";
require_once "include/class.Metode.php";
require_once "include/class.Administrator.php";
require_once "include/class.Saradnik.php";
require_once "include/class.Predmet.php";

if( !isset($_SESSION['korisnik']['admin_id']) )
    Metode::autorizuj();

$svi_saradnici = Saradnik::izlistajSveSaradnike();
$svi_predmeti = Predmet::procitajSve();


?>

<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .invalid {
            -webkit-box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
            -moz-box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
            box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
        }
    </style>
</head>
<body>

<?php



echo "Пријављен је админ са ИД-ом: {$_SESSION['admin_id']}" . "<br/>";
echo "Кор. име: {$_SESSION['korisnik']['kor_ime']}" . "<br/>";
echo "Лозинка(хеш): " . sha1($_SESSION['korisnik']['kor_ime']) . "<br/>";
echo "Е-пошта: {$_SESSION['korisnik']['e_mail']}" ; echo  "<br/>";

// код методе, додај предмет:
# try { Administrator::dodajPredmet() } catch($e) { echo $e->getMessag

?>
<br/> <br/>
<a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime'] ?> (одјавите се)</a> <br/> <br/>
<a href="#" id="dodajSaradnikaLink">Додајте сарадника</a> <br/>
<a href="#" id="izmeniSaradnikaLink">Измени сарадника</a> <br/>
<a href="#" id="deaktivirajSaradnikaLink">Деактивирај сарадника</a> <br/>
<a href="#" id="dodajPredmetLink">Додај нови предмет</a> <br/>
<a href="#" id="izmeniPredmetLink">Додај нови предмет</a> <br/>
<hr/>

<div id="dodavanjeSaradnikaForma" style='display: none;' hidden="hidden">

<?php

$forma = "<form id='noviSaradnik' method='post' action='#'>";

$tabela = "<table border='0'>";
$tabela .= "<th>Наслов</th>";
$tabela .= "<tr> <td>Име и презиме*: </td>    <td> <input type='text' id='ime_prezime1' class='reqd ime_prezime1'/>      </td> </tr>";
$tabela .= "<tr> <td>Koр. име*: </td>         <td> <input type='text' id='kor_ime1' class='reqd kor_ime1'/>               </td> </tr>";
$tabela .= "<tr> <td>Лозинка*: </td>          <td> <input type='password' id='lozinkaI'  class='reqd '/>            </td>   </tr>";
$tabela .= "<tr> <td>Е-пошта*: </td>          <td> <input type='email' id='e_mail1' class='reqd email1'/>                </tr>";
$tabela .= "<tr> <td>Опис: </td>              <td> <input type='text' id='opis1' class=''/>                            </tr>";
$tabela .= "<tr> <td>Статус: </td> 
<td> 
<select id='status1' name='status1' class='' >
<option name='1' value='aktiviran'>Активиран</option> 
<option name='0' value='deaktiviran' selected='selected'>Деактивиран</option> 
</select> </td>  </tr>";

$tabela .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url1' class='slika_url'/> </td>   </tr>";

$tabela .= "</table> </form>";
$tabela .= "<button id='prosledi1' name='prosledi1'>Проследи</button>";

$forma .= $tabela;

echo $forma;
?>

</div>
<div id="izmeniSaradnikaDiv" style='display: none;' hidden="hidden">
    <br/>

    <div id="padajucaLista1">
        Изаберите сарадника са листе: <br/>
        <!-- Исписивање динамичке падајуће листе           -->
        <select name='saradnici' id="saradnici" class="reqd" >
            <option selected="selected" disabled="disabled"> - Изаберите сарадника - </option>
          <?php  while($row = $svi_saradnici->fetch_assoc()):; ?>
            <option value='<?php echo $row['saradnik_id']; ?>' > <?php echo $row['ime_prezime']; ?> </option>
            <?php endwhile; ?>
            </select>
    </div>
    <br/> <br/>
    <div id="izmeniSaradnikaForma" style='display: none;' hidden="hidden">
        <form id='izmeniSaradnika' method='post' action='#'>

               <table border='0'> 
                   <th>Наслов</th> 
                <tr> <td>Име и презиме: </td> <td> <input type='text' id='ime_prezime2' class='' placeholder=''/>      </td> <td id='greska' hidden='hidden'>" .$poruka. "</td> </tr>
                <tr> <td>Koр. име: </td> <td> <input type='text' id='kor_ime2' class='' placeholder=''/>                       </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>
                <tr> <td>Лозинка: </td> <td> <input type='password' id='lozinkaII' class='' placeholder=''/>                    </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>
                <tr> <td>Е-пошта: </td> <td> <input type='email' id='e_mail2' class='' placeholder=''/>                           </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>
                <tr> <td>Опис: </td> <td> <input type='text' id='opis2' class='' placeholder=''/>                                        </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>
                <tr> <td>Статус: </td>
                    <td>
                        <select id='status2' name='status2' class='' >
                            <option name='1' value='aktiviran'>Активиран</option>
                            <option name='0' value='deaktiviran' selected='selected'>Деактивиран</option>
                        </select> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr> 

                <tr> <td>URL слике: </td> <td> <input type='url' id='slika_url2' class='' placeholder=''/> </td>            <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>

                </table>
        </form>
        <button id='prosledi2' name='prosledi2'>Проследи</button> 

    </div>
</div>
<div id="deaktivirajSaradnikaDiv" style='display: none;' hidden="hidden">
    <br/>
    <?php $svi_saradnici->data_seek(0); ?>
    <div id="padajucaLista2">
        Изаберите сарадника са листе: <br/>
        <!-- Исписивање динамичке падајуће листе           -->
        <select name='saradnici2' id="saradnici2" class="reqd" >
            <option selected="selected" disabled="disabled"> - Изаберите сарадника - </option>
          <?php  while($row = $svi_saradnici->fetch_assoc()):; ?>
            <option value='<?php echo $row['saradnik_id']; ?>' > <?php echo $row['ime_prezime']; ?> </option>
            <?php endwhile; ?>
            </select>
    </div>
    <br/>
        <button id='deaktiviraj' >Деактивирај</button>

</div>
<div id="dodajPredmetDiv" style='display: none;' hidden="hidden">
    <form id="dodajPredmetForma" method="post" action="#">
    <table border="0">
        <tr >Попуните форму за додавање предмета:</tr> <br/> <br/>
        <tr>Назив предмета*: <input type="text" id="nazivPredmeta" class="reqd"/></tr> <br/>
        <tr>Oпис: </tr>
    </table>
        <textarea id="opisPredmeta" rows="5" cols="15" maxlength="255" ></textarea>
    </form>
        <button id='dodajPredmet' >Додај</button>

</div>
<div id="izmeniPredmetDiv" style='display: none;' hidden="hidden">
    <br/>

    <div id="padajucaLista2">
        Изаберите предмет са листе: <br/>
        <!-- Исписивање динамичке падајуће листе           -->
        <select name='predmeti' id="predmeti" class="reqd" >
            <option selected="selected" disabled="disabled"> - Изаберите сарадника - </option>
            <?php  while($row = $svi_predmeti->fetch_assoc() ):; ?>
                <option value='<?php echo $row['predmet_id']; ?>' > <?php echo $row['naziv']; ?> </option>
            <?php endwhile; ?>
        </select>
    </div>
    <br/> <br/>
    <div id="izmeniPredmetDiv" style='display: none;' hidden="hidden">
        <form id='izmeniPredmetForma' method='post' action='#'>
            <table border="0">
                <tr >Попуните форму за додавање предмета:</tr> <br/> <br/>
                <tr>Назив предмета*: <input type="text" id="nazivPredmeta2" class="" placeholder=""/> </tr> <br/>
                <tr>Oпис: </tr>
            </table>
            <textarea id="opisPredmeta2" rows="5" cols="15" maxlength="255" placeholder=""></textarea>
        </form>
        <button id='izmeniPredmet' >Додај</button>
    </div>
</div>


</body>
<!--<script type="text/javascript" src="js/polja_forme.js"></script>-->
<script type="text/javascript" src="../js/jquery-3.0.0.js"></script>
<script type="text/javascript" src="../js/g_fnc.js"></script>
<script type="text/javascript" src="../js/izm_sar.js"></script>
<script type="text/javascript" src="../js/deak_s.js"></script>
<script type="text/javascript" src="../js/dod_pr.js"></script>

</html>

