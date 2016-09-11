<?php
session_start();
require_once "../include/class.Baza.php";
require_once "../include/class.Korisnik.php";
require_once "../include/class.Metode.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Predmet.php";
require_once "../include/class.Administrator.php";

$svi_saradnici = Saradnik::izlistajSveSaradnike();

// приказ форме //
if(isset($_GET['zid']) && $_GET['zid'] == 1000)
{
    $predmet_saradnik_rs = "";
    $svi_predmeti = Predmet::procitajSve();
    $sve_lab = [
        101,102,103,104,105,106,107,108,109,201,202,203,204,205,206,207,208,209,
        301,302,303,304,305,306,307,308,309,401,402,403,404,405,406,407,408,409,
        501,502,503,504,505,506,507,508,509
    ];
    if(isset($_SESSION['korisnik']['saradnik_id']))
    {
        $saradnik_id = $_SESSION['korisnik']['saradnik_id'];
        $predmet_saradnik_rs = Predmet::vratiPredmete($saradnik_id); //nije fetch-ovano
    }

    $rezultat = "";

    $rezultat .= "<form id='dodajLabVezbuForma' method='post' action='#' enctype='multipart/form-data'>
        <table border='0' cellpadding='' cellspacing='5'>
            <tr> <td>Назив лаб. вежбе*: </td> <td><input type='text' id='nazivLab' class='reqd'/></td> <td> <span id='greska'></span> </td> </tr>
            <tr> <td>Oпис лаб. вежбе*: </td> <td> <input type='text' id='opisLab' class='reqd'/> </td> <td> <span id='greska'></span> </td> </tr>
            <tr> <td>Датум одржавања*: </td> <td> <input type='text' id='datumLab' class='reqd'/> </td> <td> <span id='greska'></span> </td></tr>
            <tr><td colspan='2'> <span class='poruka'>(унесите датум у формату: dd.mm.gggg. cc:mm)</span> </td> </tr> <br/>
            <tr> <td>Лабораторија*: </td> <td>    <select id='brojLab' class='reqd'> <option value='' disabled='disabled' selected='selected' hidden='hidden'> - Изаберите лабораторију -</option>";
                foreach ($sve_lab as $lab)
                    $rezultat .= "<option value='{$lab}'> {$lab} </option>";

    $rezultat .=" 
            </select> </td> <td> <span id='greska'></span> </td></tr>
            <tr> <td>Предмет*: </td> <td>         <select id='predmetLab' class='reqd'>
                <option value='' disabled='disabled' selected='selected' hidden='hidden'> - Изаберите предмет -</option>";

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

    $rezultat .="
            </select> </td> <td> <span id='greska'></span> </td></tr> 
            <tr> <td>Сарадник*: </td> <td>        <div id='sar' > <span class='poruka'>(изаберите најпре предмет)</span></div>";


           $rezultat .= "          </td> <td> <span id='greska'></span> </td></tr>
            <tr> <td>Материјали: </td> <td>       <input type='hidden' name='MAX_FILE_SIZE' value='200000000'> <input type='file' name='file1' id='file1' class=' '/>      </td> </tr>
            <tr> <td colspan='2'><span class='poruka'>(подржани формати:<br/><br/> 'jpg','png','gif','bmp','pdf','doc','docx','txt','zip','rar','ppt','pptx','xls','xlsx')</span> </td></tr> <br/>
            <tr> <td colspan='2'><span class='poruka'>(макс. један фајл)</span> </td></tr> <br/>
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

// допуна форме //
if(isset($_GET['zid']) && $_GET['zid'] == 1001)
{

    $predmet_id = intval($_POST['predmet_id']);
    $svi_saradnici_na_predmetu = Baza::vratiInstancu()->select("SELECT * FROM predmet_saradnik WHERE predmet_id={$predmet_id}" );

    $rezultat = "<select id='saradnikLab' class='reqd'><option value='' disabled='disabled' selected='selected' hidden='hidden' > - Изаберите сарадника -</option>";
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

// коначно: додавање вежбе //
if(isset($_GET['zid']) && $_GET['zid'] == 1 )
{
    $naziv = Metode::mysqli_prep($_POST['naziv_v']);
    $opis = Metode::mysqli_prep($_POST['opis_v']);
    $datum = Metode::mysqli_prep($_POST['datum']);
    $lab = Metode::mysqli_prep($_POST['lab']);
    $saradnik_id = Metode::mysqli_prep($_POST['saradnik_id']);
    $predmet_id = Metode::mysqli_prep($_POST['predmet_id']);

    Saradnik::dodajLabVezbu($naziv,$opis, $datum, intval($lab), intval($saradnik_id),intval($predmet_id));
    return;
}

// TODO: sakrij progress bar dok se ne klikne na njega

?>