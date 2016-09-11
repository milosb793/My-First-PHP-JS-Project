var lab_vezba_id;
var predmet_id;



$("#obrisiLabVezbuLink").click(function ()
{
    $.get(
        "ajax/brisanjeLabVezbe.php?zid=1000", //predmet i div
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);

            $("#predmeti").change(function ()
            {
                predmet_id = $(this).find("option:selected").val();

                $.get(
                    "ajax/brisanjeLabVezbe.php?zid=1001&predmet_id="+predmet_id+"", //ceo get mozda treba van
                    {},
                    function (odgovor,status)
                    {
                        $("#lab").html(odgovor);

                        $("#lab_vezbe").change(function ()
                        {
                           lab_vezba_id = $(this).find("option:selected").val();

                            $("#obrisiLab").click(function () //mozda treba van
                            {
                                if(confirm("Јесте ли сигурни да желите да обришете целу вежбу?"))
                                    $.get(
                                        "ajax/brisanjeLabVezbe.php?zid=1&lab_vezba_id="+lab_vezba_id+"",
                                        {},
                                        function (odgovor,status)
                                        {
                                            alert(odgovor);
                                        }); // get 1
                            }); // obrisiLab click
                        });// lab_vezbe change
                    }); // get 1001
            }); // predmeti change
        }); // link get predmet
}); //obrisi click

