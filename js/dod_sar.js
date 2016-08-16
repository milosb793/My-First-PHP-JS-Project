
// ############### ГЛОБАЛНЕ ПРОМЕНЉИВЕ #############//
var statusValidacje ;
var poruka = "";
var polje_sme_biti_prazno = false;





// ### ПРИКАЗ ФОРМЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //
$('#dodajSaradnikaLink').click(function() {

    $.post(
        "ajax/dodavanjeSaradnika.php?zid=1",
        {},
        function (podaci,status) {
            $("#sadrzaj").html(podaci);

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
        }
    );


});
// ### КРАЈ ФУНКЦИЈЕ ПРИКАЗА ФОРМЕ ### //

function prosledi1()
{
// прослеђивање форме //
//     $('#prosledi1').click(function () {
        var imeprez = $('#ime_prezime1').val();
        var kor_ime = $('#kor_ime1').val();
        var loz = $('#lozinka1').val();
        var em = $('#e_mail1').val();
        var op = $('#opis1').val();
        var st = $('select[name=status1] option:selected').val();
        var url = $('#slika_url1').val();

        statusValidacje = validirajFormu();

        if (statusValidacje == true) {
            if (confirm("Јесте ли сигурни да су сви подаци у реду?")) {
                $.post("ajax/dodavanjeSaradnika.php",
                    {
                        ime_prezime: imeprez,
                        kor_ime: kor_ime,
                        lozinka: loz,
                        e_mail: em,
                        opis: op,
                        status: st,
                        slika_url: url
                    },
                    function (odgovor, status) {
                        alert(odgovor);
                    });
            }
        }
        else
            alert(poruka);

// ### КРАЈ ФУНКЦИЈЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //
}