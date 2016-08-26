<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Korisnik.php";
require_once "../include/class.Metode.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Administrator.php";
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
$svi_saradnici = Saradnik::izlistajSveSaradnike();

if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $svi_predmeti = Predmet::procitajSve();
    $sve_lab = [
        101,102,103,104,105,106,107,108,109,201,202,203,204,205,206,207,208,209,
        301,302,303,304,305,306,307,308,309,401,402,403,404,405,406,407,408,409,
        501,502,503,504,505,506,507,508,509
    ];

    $rezultat = "";

    $rezultat .= "<form id='dodajLabVezbuForma' method='post' action='#' enctype='multipart/form-data'>
        <table border='0' cellpadding='' cellspacing=''>
            <tr> <td>Назив лаб. вежбе*: </td> <td><input type='text' id='nazivLab' class='reqd'/>           </td> </tr>
            <tr> <td>Oпис лаб. вежбе*: </td> <td> <input type='text' id='opisLab' class='reqd'/>            </td> </tr>
            <tr> <td>Датум одржавања*: </td> <td> <input type='datetime-local' id='datumLab' class='reqd'/> </td> </tr>
            <tr> <td>Лабораторија*: </td> <td>    <select id='brojLab' class='reqd'> <option value='' disabled='disabled' selected='selected'> - Изаберите лабораторију -</option>";
                foreach ($sve_lab as $lab)
                    $rezultat .= "<option value='{$lab}'> {$lab} </option>";

    $rezultat .=" 
            </select>               </td> </tr>
            <tr> <td>Предмет*: </td> <td>         <select id='predmetLab' class='reqd'><option value='' disabled='disabled' selected='selected'> - Изаберите предмет -</option>";
                while($predmet = $svi_predmeti->fetch_assoc() )
                    $rezultat .="<option value='{$predmet['predmet_id']}'> {$predmet['naziv']} </option>";

    $rezultat .="
            </select>            </td> </tr> 
            <tr> <td>Сарадник*: </td> <td>        <div id='sar' > <i>(изаберите најпре предмет)</i></div>";


           $rezultat .= "          </td> </tr>
            <tr> <td>Материјали*: </td> <td>       <input type='hidden' name='MAX_FILE_SIZE' value='100000000'/> <input type='file' name='file1' id='file1' class=' '/>      </td> </tr>
        </table> <br/> 
        
        <progress id='progressBar' value='0' max='100' style='width:300px; background-color: dodgerblue;'></progress>
    <h3 id='status'></h3>
    <p id='loaded_n_total'></p> <hr/>
        <input type='button' id='dodajLab' value='Додај лаб. вежбу' />
    </form>
    ";

    echo $rezultat;
    return;
}

if(isset($_GET['zid']) && $_GET['zid'] == 1001)
{

    $predmet_id = intval($_POST['predmet_id']);
    $svi_saradnici_na_predmetu = Baza::vratiInstancu()->select("SELECT * FROM predmet_saradnik WHERE predmet_id={$predmet_id}" );

    $rezultat = "<select id='saradnikLab' class='reqd'><option value='' disabled='disabled' selected='selected'> - Изаберите сарадника -</option>";
        while($saradnik = $svi_saradnici->fetch_assoc() )
        {
            while ($predmet = $svi_saradnici_na_predmetu ->fetch_assoc() )
            {
                if ( (trim($saradnik['status']) == "aktiviran") && (intval($predmet['saradnik_id']) == intval($saradnik['saradnik_id']) ) )
                    $rezultat .= "<option value='{$saradnik['saradnik_id']}'> {$saradnik['ime_prezime']} </option>";
                else continue;
            }
            $svi_saradnici_na_predmetu->data_seek(0);
        }
        $rezultat .= "</select>";
        echo $rezultat;
    return;
}


if(isset($_GET['zid']) && $_GET['zid'] == 1 )
{
    Saradnik::dodajLabVezbu($_POST['naziv_v'],$_POST['opis_v'], $_POST['datum'], intval($_POST['lab']), intval($_POST['saradnik_id']),intval($_POST['predmet_id']));
    return;
}




?>