/**
 * Created by logos on 8.8.16..
 */





// ### ПРИКАЗ ФОРМЕ ЗА ДОДАВАЊЕ САРАДНИКА ### //
$('#dodajPredmetLink').click(function() {

    $.get(
        "ajax/dodavanjePredmeta.php?zid=1000",
        {},
        function (podaci,status) {
            $("#sadrzaj").html(podaci);

            $('#dodajPredmetDiv').toggle(function() {
                if ($(this).css('display')=='none'){
                    $(this).prop('hidden', 'hidden');
                }
                else
                {
                    $(this).removeProp('hidden');
                    $(this).css('display','block');
                }
            });

            $('#dodajPredmet').click(function ()
            {
                var naziv = $('#nazivPredmeta').val();
                var opis = $('#opisPredmeta').val();
                // TODO: ne radi provera
                // statusValidacje = validirajFormu();
                //
                // if(statusValidacje == true)
                // {
                    if(confirm("Јесте ли сигурни да су сви подаци у реду?"))
                    {
                        $.post("ajax/dodavanjePredmeta.php?zid=1",
                            {naziv:naziv, opis: opis},
                            function (odgovor, status) {
                                alert(odgovor);
                            });
                    }
                // }
                // else
                //     alert(poruka);
            });
        });
        }
    );
