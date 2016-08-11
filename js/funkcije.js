/**
 * Created by logos on 8.8.16..
 */
window.onload = inicijalizujForme;


// ############### ГЛОБАЛНЕ ПРОМЕНЉИВЕ #############//
var statusValidacje = false;
var poruka = "";

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
            invalidLabel(ovajTag.parentNode);
            ovajTag.focus();
            if (ovajTag.nodeName == "INPUT") {
                ovajTag.select();
            }
            return false;
        }
        return true;

        function validiranjePoKlasi(ovaKlasa) {
            var novaKlasa = "";

            switch(ovaKlasa) {
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
                case "email":
                    novaKlasa += ovaKlasa;
                    break;
                default:
                    if (OK && !crossCheck(ovajTag,ovaKlasa))
                    {
                        novaKlasa = "invalid ";
                        poruka = "Лозинке се не поклапају.";
                    }
                    novaKlasa += ovaKlasa;
            }
            return novaKlasa;
        }

        function crossCheck(inTag,otherFieldID) {
            if (!document.getElementById(otherFieldID)) {
                return false;
            }
            return (inTag.value == document.getElementById(otherFieldID).value);
        }

        function invalidLabel(parentTag) {
            if (parentTag.nodeName == "TD") {
                parentTag.className += " invalid";
            }
        }
    }
}

// ### КРАЈ ПРОВЕРЕ ФОРМИ ###//

// прослеђивање форме //
$('#prosledi').click(function () {
    var imeprez = $('#ime_prezime').val();
    var kor_ime = $('#kor_ime').val();
    var loz = $('#lozinka').val();
    var em = $('#e_mail').val();
    var op = $('#opis').val();

    var st = $('select[name=status] option:selected').val();
    var url = $('#slika_url').val();


    // $("prosledi").click( function() { statusValidacje = validirajFormu(); return statusValidacje;} );
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