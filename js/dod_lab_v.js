var predmet_id;
var saradnik_id;
var status = false;


$("#dodajLabVezbuLink").click(function ()
{
    $.get(
        "ajax/dodavanjeLabVezbe.php?zid=1000",
        {},
        function (podaci,status)
        {
            $("#sadrzaj").html(podaci);

            $("#predmetLab").change(function ()
            {
                predmet_id = $(this).find("option:selected").val();
                $.post(
                    "ajax/dodavanjeLabVezbe.php?zid=1001",
                    {predmet_id:predmet_id},
                    function (podaci,status)
                    {
                        $("#sar").html(podaci);
                    }
                );
            });

            $('#dodajLab').click(function()
            {
                var naziv_v =    $("#nazivLab").val();
                var opis_v =     $("#opisLab").val();
                var datum =      $("#datumLab").val();
                var lab =        $("#brojLab").find("option:selected").val();
                var predmet_id=  $("#predmetLab").find("option:selected").val();
                var saradnik_id= $("#saradnikLab").find("option:selected").val();

                status = validirajFormu();
                if(status == true)
                {
                    if (confirm("Јесте ли сигруни да су сви подаци у реду? "))
                    {
                        $.post(
                            "ajax/dodavanjeLabVezbe.php?zid=1",
                            {
                                naziv_v: naziv_v,
                                opis_v: opis_v,
                                datum: datum,
                                lab: lab,
                                predmet_id: predmet_id,
                                saradnik_id: saradnik_id
                            },
                            function (odgovor, status)
                            {
                                alert(odgovor);
                                if ((odgovor.indexOf("Грешка") <= -1 ))
                                    uploadFile();
                            }
                        );
                    }
                }
                else
                    alert(poruka);
            });
            // читање фајлова //
        });
});// dodajVezbu link