<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Izuzetak.php";
require_once "../include/class.Metode.php";

// приказ форме //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $svi_saradnici = Saradnik::izlistajSveSaradnike();

    $rezultat = "<div id='izmeniSaradnikaDiv' style='display: none;' hidden='hidden'> <br/>";

    $rezultat .= "<div id='padajucaLista1'>";
    $rezultat .= "Изаберите сарадника са листе: <br/>";
    $rezultat .= "<select name='saradnici' id='saradnici' class='reqd' onchange='prikaziSaradnike()' >";
    $rezultat .= "<option selected='selected' disabled='disabled' hidden='hidden'> - Изаберите сарадника - </option>";
    while ($row = $svi_saradnici->fetch_assoc())
        $rezultat .= "<option value='{$row['saradnik_id']} ?>' > {$row['ime_prezime']} </option> ";
    $rezultat .= "</select></div><br/> <br/>";

    $rezultat .= "<div id='izmeniSaradnikaForma' style='display: none;' hidden='hidden'>";
    $rezultat .= "<form id='izmeniSaradnika' method='post' action='#'>";
    $rezultat .= "<table border='0'>";
    $rezultat .= "<th>Наслов</th>";
    $rezultat .=  "<tr> <td>Име и презиме: </td> <td> <input type='text' id='ime_prezime2' class='' placeholder=''/>      </td>  </tr>";
    $rezultat .= "<tr> <td>Koр. име: </td> <td> <input type='text' id='kor_ime2' class='' placeholder=''/>               </td>  </tr>";
    $rezultat .= "<tr> <td>Лозинка: </td> <td> <input type='password' id='lozinka2' class='' placeholder=''/>            </td>  </tr>";
    $rezultat .= "<tr> <td>Е-пошта: </td> <td> <input type='email' id='e_mail2' class='' placeholder=''/>                </td>  </tr>";
    $rezultat .= "<tr> <td>Опис: </td> <td> <input type='text' id='opis2' class='' placeholder=''/>                      </td>  </tr>";
    $rezultat .= "<tr> <td>Статус: </td>
                    <td>
                        <select id='status2' name='status2' class='' >
                            <option name='1' value='aktiviran'>Активиран</option>
                            <option name='0' value='deaktiviran' selected='selected'>Деактивиран</option>
                        </select> </td>   
                </tr>";
    $rezultat .= "<tr> <td>URL слике: </td> <td> <input type='url' id='slika_url2' class='' placeholder=''/> </td>              </tr>";
    $rezultat .= "</table>";
    $rezultat .= "</form>";
    $rezultat .= "<button id='prosledi2' name='prosledi2' onclick='return false;'>Проследи</button>";
    $rezultat .= "</div>";
    $rezultat .= "</div>";
    // TODO: izbaci redundansu

    echo $rezultat;
    return;
}

// узимање података сараника //
if(isset($_GET['id']))
{
    $id = intval($_GET['id']);
    $saradnik = Saradnik::vratiSaradnika($sid);
    echo $saradnik['saradnik_id'] . "|" . $saradnik['ime_prezime'] . "|" . $saradnik['kor_ime'] . "|" . $saradnik['lozinka'] . "|" . $saradnik['e_mail'] . "|" . $saradnik['opis'] . "|" . $saradnik['slika_url'];
    return;
}

// коначно: измена сарадника //
if(isset($_GET['zid']) && $_GET['zid'] == 2)
{
    $sid = intval($_POST['sid']);
    $ime_prezime = Metode::mysqli_prep($_POST['ime_prezime']);
    $kor_ime = Metode::mysqli_prep($_POST['kor_ime']);
    $lozinka = Metode::mysqli_prep($_POST['lozinka']);
    $e_mail = Metode::mysqli_prep($_POST['e_mail']);
    $opis = Metode::mysqli_prep($_POST['opis']);
    $status = Metode::mysqli_prep($_POST['status']);
    $slika_url = Metode::mysqli_prep($_POST['slika_url']);

    Administrator::izmeniSaradnika($sid, $ime_prezime, $kor_ime, $lozinka, $e_mail, $opis, $status, $slika_url);
    return;
}
