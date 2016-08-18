var saradnik_id;
var predmet_id;

$("#ukiniAngazovanjeLink").click(function ()
{
    $.get(
        "ajax/uklanjanjeSaradnikPredmet.php?zid=1000",
        {},
        function (podaci,status)
        {
            $("#sadrzaj").html(podaci); // Први део, сарадници

            $("#saradnici").change(function ()
            {
                saradnik_id = $(this).find("option:selected").val();
                if (saradnik_id !== undefined || saradnik_id != null || saradnik_id > 0)
                {
                    $.get(
                        "ajax/uklanjanjeSaradnikPredmet.php?zid=1001&saradnik_id="+saradnik_id+"", //други део података
                        {},
                        function (podaci, status)
                        {
                            $("#predmeti").html(podaci);

                            $("#predmeti").change(function ()
                            {
                                predmet_id = $(this).find("option:selected").val();

                            });

                            $("#ukloni").click(function ()
                            {
                                if (confirm("Јесте ли сигурни да желите да уклоните ангажовање?"))
                                    $.get(
                                        "ajax/uklanjanjeSaradnikPredmet.php?zid=1&saradnik_id=" + saradnik_id + "&predmet_id=" + predmet_id + "",
                                        {},
                                        function (odgovor, status)
                                        {
                                            alert(odgovor);
                                        }
                                    );


                            });

                        });
                }//get zid 1001


                 //if

            });//saradnici change

        }); //get 1000
}); //click link