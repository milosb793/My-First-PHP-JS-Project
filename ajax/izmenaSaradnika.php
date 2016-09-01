<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Izuzetak.php";
require_once "../include/class.Metode.php";

if(isset($_GET['id']))
{
    $id = intval($_GET['id']);
    $saradnik = mysqli_fetch_assoc(Baza::vratiInstancu()->select("SELECT * FROM saradnik WHERE saradnik_id={$id}"));
    echo $saradnik['saradnik_id'] . "|" . $saradnik['ime_prezime'] . "|" . $saradnik['kor_ime'] . "|" . $saradnik['lozinka'] . "|" . $saradnik['e_mail'] . "|" . $saradnik['opis'] . "|" . $saradnik['slika_url'];
    return;
}


if(isset($_GET['zid']) && $_GET['zid'] == 2)
{

    $sid = intval($_POST['sid']);
    $saradnik = mysqli_fetch_assoc(Baza::vratiInstancu()->select("SELECT * FROM saradnik WHERE saradnik_id='{$sid}' "));
    Administrator::izmeniSaradnika($sid, $_POST['ime_prezime'], $_POST['kor_ime'], $_POST['lozinka'], $_POST['e_mail'], $_POST['opis'], $_POST['status'], $_POST['slika_url']);
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $svi_saradnici = Saradnik::izlistajSveSaradnike();

    $rezultat = "<div id='izmeniSaradnikaDiv' style='display: none;' hidden='hidden'> <br/>";

    $rezultat .= "<div id='padajucaLista1'>";
    $rezultat .= "Изаберите сарадника са листе: <br/>";
    $rezultat .= "<select name='saradnici' id='saradnici' class='reqd' onchange='prikaziSaradnike()' >";
    $rezultat .= "<option selected='selected' disabled='disabled'> - Изаберите сарадника - </option>";
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
    $rezultat .= "<button id='prosledi2' name='prosledi2' onclick='prosledi2()'>Проследи</button>";
    $rezultat .= "</div>";
    $rezultat .= "</div>";
    // TODO: izbaci redundansu

    echo $rezultat;
    return;
}
?>