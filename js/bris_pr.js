var predmet_id;

$("#obrisiPredmetLink").click(function ()
{
    $.get(
        "ajax/brisanjePredmeta.php?zid=1000",
        {},
        function (podaci,status)
        {
            $("#sadrzaj").html(podaci);

            $("#predmeti").change(function ()
            {
                predmet_id = $(this).find("option:selected").val();
            });

            $("#obrisi").click(function ()
            {
                if(confirm("Јесте ли сигурни да желите да обришете предмет?"))
                    $.post(
                        "ajax/brisanjePredmeta.php?zid=1",
                        {predmet_id:predmet_id},
                        function (odgovor,status)
                        {
                            alert(odgovor);
                        }
                    );
            });

        }
    );

});