<?php
session_start();
require_once "include/class.Metode.php";
require_once "include/class.Saradnik.php";

if( !isset($_SESSION['korisnik']['admin_id']) )
    Metode::autorizuj();
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
echo "Е-пошта: {$_SESSION['korisnik']['e_mail']}" . '\n';

// код методе, додај предмет:
# try { Administrator::dodajPredmet() } catch($e) { echo $e->getMessag

?>
<br/> <br/>
<a href="#" id="odjaviSe">Добро дошли, <?php echo $_SESSION['korisnik']['kor_ime'] ?> (одјавите се)</a> <br/>

<a href="#" id="dodajSaradnikaLink">Додајте сарадника</a> <br/>

<div id="dodavanjeSaradnikaForma" style='display: none;' hidden="hidden">

<?php

$forma = "<form id='noviSaradnik' method='post' action='#'>";

$tabela = "<table border='0'>";
$tabela .= "<th>Наслов</th>";
$tabela .= "<tr> <td>Име и презиме*: </td> <td> <input type='text' id='ime_prezime' class='reqd ime_prezime'/>      </td> <td id='greska' hidden='hidden'>" .$poruka. "</td> </tr>";
$tabela .= "<tr> <td>Koр. име*: </td> <td> <input type='text' id='kor_ime' class='reqd kor_ime'/>               </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Лозинка*: </td> <td> <input type='password' id='lozinka' class='reqd lozinka'/>            </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Поновљена лозинка*: </td> <td> <input type='password' id='lozinka2' class='reqd lozinka'/> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Е-пошта*: </td> <td> <input type='email' id='e_mail' class='reqd email '/>               </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Опис: </td> <td> <input type='text' id='opis' class=''/>                          </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
$tabela .= "<tr> <td>Статус: </td> 
<td> 
<select id='status' name='status' class='' >
<option name='1' value='aktiviran'>Активиран</option> 
<option name='0' value='deaktiviran' selected='selected'>Деактивиран</option> 
</select> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";

$tabela .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url' class='slika_url'/> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";

$tabela .= "</table> </form>";
$tabela .= "<button id='prosledi1' name='prosledi1'>Проследи</button>";

$forma .= $tabela;

echo $forma;
?>

</div>

<a href="#" id="izmeniSaradnikaLink">Измени сарадника</a> <br/>

<div id="izmeniSaradnikaDiv" style='display: none;' hidden="hidden">
    <?php  $saradnici = Saradnik::izlistajSveSaradnike(); ?>

    <div id="padajucaLista1">
        <select id="saradnici" class="reqd" >
            <option selected="selected">Изаберите сарадника</option>
        <?php
            foreach ($saradnici as $saradnik)
                echo "<option id='saradnik{$saradnik['saradnik_id']}' value='{$saradnik['saradnik_id']}'>{$saradnik['ime_prezime']}</option>";
        ?>
        </select>
    </div>

    <div id="izmeniSaradnikaForma">
        <?php
        $forma = "<form id='izmeniSaradnika' method='post' action='#'>";

        $tabela = "<table border='0'>";
        $tabela .= "<th>Наслов</th>";
        $tabela .= "<tr> <td>Име и презиме: </td> <td> <input type='text' id='ime_prezime' class='ime_prezime'/>      </td> <td id='greska' hidden='hidden'>" .$poruka. "</td> </tr>";
        $tabela .= "<tr> <td>Koр. име: </td> <td> <input type='text' id='kor_ime' class='kor_ime'/>               </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
        $tabela .= "<tr> <td>Лозинка: </td> <td> <input type='password' id='lozinka' class='lozinka'/>            </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
        $tabela .= "<tr> <td>Поновљена лозинка: </td> <td> <input type='password' id='lozinka2' class='lozinka'/> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
        $tabela .= "<tr> <td>Е-пошта: </td> <td> <input type='email' id='e_mail' class='email '/>               </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
        $tabela .= "<tr> <td>Опис: </td> <td> <input type='text' id='opis' class=''/>                          </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";
        $tabela .= "<tr> <td>Статус: </td> 
                        <td> 
                        <select id='status' name='status' class='' >
                        <option name='1' value='aktiviran'>Активиран</option> 
                        <option name='0' value='deaktiviran' selected='selected'>Деактивиран</option> 
                        </select> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";

        $tabela .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url' class='slika_url'/> </td> <td id='greska' hidden='hidden'>" .$poruka. "</td>  </tr>";

        $tabela .= "</table> </form>";
        $tabela .= "<button id='prosledi2' name='prosledi2'>Проследи</button>";
        $forma .= $tabela;
        echo $forma;
        ?>

    </div>
</div>

</body>
<!--<script type="text/javascript" src="js/polja_forme.js"></script>-->
<script type="text/javascript" src="js/jquery-3.0.0.js"></script>
<script type="text/javascript" src="js/funkcije.js"></script>

</html>

