/**
 * Created by logos on 8.8.16..
 */
window.onload = inicijalizujForme;


// ############### ГЛОБАЛНЕ ПРОМЕНЉИВЕ #############//
var statusValidacje = false;
var poruka = "";
var polje_sme_biti_prazno = false;

// ### ПРИКАЗ ФОРМЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //


$('#dodajSaradnikaLink').click(function() {
    $('#dodavanjeSaradnikaForma').toggle(function() {
        if ($(this).css('display')=='none'){
            $(this).prop('hidden', 'hidden');
        }
        else
        {
            $(this).removeProp('hidden');
            $(this).css('display','block');
        }
    })
});
// ### КРАЈ ФУНКЦИЈЕ ПРИКАЗА ФОРМЕ ### //




// ### ПРОВЕРА ФОРМИ ###
function inicijalizujForme()
{
    for (var i=0; i< document.forms.length; i++)
    {
        document.forms[i].onsubmit = function() {return validirajFormu();}
        //document.getElementById("prosledi").onclick = function() {statusValidacje = validirajFormu(); return statusValidacje;}
    }
}

function validirajFormu()
{
    var OK = true;
    var sviTagovi = document.getElementsByTagName("*");

    for (var i=0; i<sviTagovi.length; i++)
    {
        if (!validirajTag(sviTagovi[i]))
        {
            OK = false;
        }
    }
    return OK;

    function validirajTag(ovajTag)
    {
        var spoljnaKlasa = "";
        var sveKlase = ovajTag.className.split(" "); // Уколико имамо више речи у класи

        for (var j=0; j<sveKlase.length; j++)
        {
            spoljnaKlasa += validiranjePoKlasi(sveKlase[j]) + " "; // овде додаје invalid ако не ваља
        }

        ovajTag.className = spoljnaKlasa;

        if (spoljnaKlasa.indexOf("invalid") > -1) // ако је у класи пронађена реч Invalid
        {
            ovajTag.focus();
            if (ovajTag.nodeName == "INPUT") {
                ovajTag.select();
            }
            return false;
        }
        return true;

        function validiranjePoKlasi(ovaKlasa)
        {
            var novaKlasa = "";

            switch(ovaKlasa)
            {
                case "":
                case "invalid":
                    break;
                case "reqd":
                    if (OK && (ovajTag.value == "" || ovajTag.value == " ") )
                    {
                        novaKlasa = "invalid ";
                        poruka = "Поља означена са ознаком * не смеју бити празна.";
                    }
                    novaKlasa += ovaKlasa;
                    break;
                case "radio":
                    if (OK && !radioCekiran(ovajTag.name))
                    {
                        novaKlasa = "invalid ";
                    }
                    novaKlasa += ovaKlasa;
                    break;
                case "email":
                    if (OK && !validirajEmail(ovajTag.value))
                    {
                        novaKlasa = "invalid ";
                    }
                    novaKlasa += ovaKlasa;
                    break;
                default:
                    if (OK && !duplaPolja(ovajTag,ovaKlasa))
                    {
                        novaKlasa = "invalid ";
                        poruka = "Лозинке се не поклапају.";
                    }
                    novaKlasa += ovaKlasa;
            }
            return novaKlasa;
        }
        // проверава тако што узима ид садашњег елемента и пита да ли је садржан у класи другог елемента
        function duplaPolja(trenutniTag,idDrugogPolja)
        {
            if (!document.getElementById(idDrugogPolja))
            {
                return false;
            }
            return (trenutniTag.value == document.getElementById(idDrugogPolja).value);
        }
        // поставити радио дугмићу назив
        function radioCekiran(radioNaziv)
        {
            var radioPostavljen = "";

            for (var k=0; k<document.forms.length; k++)
            {
                if (!radioPostavljen)
                {
                    radioPostavljen = document.forms[k][radioNaziv];
                }
            }
            if (!radioPostavljen) return false;
            for (k=0; k<radioPostavljen.length; k++)
            {
                if (radioPostavljen[k].checked)
                {
                    return true;
                }
            }
            return false;
        }

        function validirajEmail(email)
        {
            var nedozvoljeniZnaci = " /:,;";

            if (email == "")
            {
                poruka = "Нисте унели email";
                return false;
            }
            for (var k=0; k<nedozvoljeniZnaci.length; k++)
            {
                var nepozeljanKarakter = nedozvoljeniZnaci.charAt(k);
                if (email.indexOf(nepozeljanKarakter) > -1)
                {
                    poruka = "Мејл адреса садржи непожељне знаке!";
                    return false;
                }
            }
            var naPoziciji = email.indexOf("@",1); //ако постоји знак @ на првом или другом месту
            if (naPoziciji == -1)
            {
                poruka = "Мејл адреса је прекратка!";
                return false;
            }
            if (email.indexOf("@",naPoziciji+1) != -1) // ако @ постоји уопште
            {
                poruka = "Мејл адреса не садржи знак @!";
                return false;
            }
            var pozicijaTacke = email.indexOf(".",naPoziciji);
            if (pozicijaTacke == -1)  // ако је тачка на првој или другој позицији
            {
                poruka = "У адреси не постоји тачка!";
                return false;
            }
            if (pozicijaTacke+3 > email.length)	// ако је мејл краћи од 3 каракера
            {
                poruka = "Изгледа да нисте унели део после тачке!";
                return false;
            }
            return true;
        }
    }
}

// ### КРАЈ ПРОВЕРЕ ФОРМИ ###//

// прослеђивање форме //
$('#prosledi1').click(function () {
    var imeprez = $('#ime_prezime').val();
    var kor_ime = $('#kor_ime').val();
    var loz = $('#lozinka').val();
    var em = $('#e_mail').val();
    var op = $('#opis').val();
    var st = $('select[name=status] option:selected').val();
    var url = $('#slika_url').val();

    statusValidacje = validirajFormu();

    if(statusValidacje == true)
    {
        if(confirm("Јесте ли сигурни да су сви подаци у реду?"))
        {
            $.post("ajax/dodavanjeSaradnika.php",
                {ime_prezime: imeprez, kor_ime: kor_ime, lozinka: loz, e_mail: em, opis: op, status: st, slika_url: url},
                function (odgovor, status) {
                    alert("Одговор: " + odgovor + '\n' + "Статус: " + status);
                });
        }
    }
    else
        alert(poruka);
});
// ### КРАЈ ФУНКЦИЈЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //


// ### КРАЈ ПРОВЕРЕ ФОРМИ ###//


// ### ПРИКАЗ ФОРМЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //


$('#izmeniSaradnikaLink').click(function() //treba da se pokaze prvo padajuca lista, ne odmah sve
{
    $('#izmeniSaradnikaDiv').toggle(function()
    {
        if ($(this).css('display')=='none')
        {
            $(this).prop('hidden', 'hidden');
        }
        else
        {
            $(this).removeProp('hidden');
            $(this).css('display','block');
        }
    });

    var saradnik_id;
    $("saradnici").change(function ()
    {
        var saradnik_id = $(this).children(":selected").attr("value");
    });

    var forma = $("#izmeniSaradnikaForma");

    alert(saradnik_id);

    if( saradnik_id !== undefined || saradnik_id != null || saradnik_id > 0)
        forma.toggle(function()
        {
            if ($(this).css('display')=='none')
            {
                $(this).prop('hidden', 'hidden');
            }
            else
            {
                $(this).removeProp('hidden');
                $(this).css('display','block');
            }
        });
});


// ### КРАЈ ФУНКЦИЈЕ ПРИКАЗА ФОРМЕ ### //

// прослеђивање форме //
$('#prosledi2').click(function () {
    var imeprez = $('#ime_prezime').val();
    var kor_ime = $('#kor_ime').val();
    var loz = $('#lozinka').val();
    var em = $('#e_mail').val();
    var op = $('#opis').val();
    var st = $('select[name=status] option:selected').val();
    var url = $('#slika_url').val();

    statusValidacje = validirajFormu();

    if(statusValidacje == true)
    {
        if(confirm("Јесте ли сигурни да су сви подаци у реду?"))
        {
            $.post("ajax/izmeniSaradnika.php",
                {ime_prezime: imeprez, kor_ime: kor_ime, lozinka: loz, e_mail: em, opis: op, status: st, slika_url: url},
                function (odgovor, status) {
                    alert("Одговор: " + odgovor + '\n' + "Статус: " + status);
                });
        }
    }
    else
        alert(poruka);
});
// ### КРАЈ ФУНКЦИЈЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //


// ### ОДЈАВЉИВАЊЕ ### //
$("#odjaviSe").click(function ()
{
    if(confirm("Јесте ли сигурни? :("))
        $.post("login.php?id=1",
                function (odgovor,status) { window.location.assign("login.php"); });
});
// ### КРАЈ ФУНКЦИЈЕ ЗА ОДЈАВЉИВАЊЕ ### //