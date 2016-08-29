var predmet_id;
var lab_vezba_id;
var saradnik_id;

$("#izmeniLabVezbuLink").click(function ()
{
    $.get(
        "ajax/izmenaLabVezbe.php?zid=1000",
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);

            //изабира се предмет
            $("#predmet").change(function ()
            {
                predmet_id = $(this).find("option:selected").val();
                alert(predmet_id);

                $.get(
                    "ajax/izmenaLabVezbe.php?zid=1001&predmet_id="+predmet_id+"",
                    {},
                    function (odgovor, status)
                    {
                            $("#lab_vezbe").html(odgovor); //div

                            $("#lab_vezba").change(function ()
                            {
                                lab_vezba_id = $(this).find("option:selected").val();
                                alert(lab_vezba_id);
                            });
                            $.get("ajax/izmenaLabVezbe.php?zid=1002&lab_vezba_id="+lab_vezba_id+"",
                                  {},
                                function (odgovor,status)
                                {
                                    $("#izmenaLabVezbeForma").html(odgovor);

                                    $("#predmetLab").change(function ()
                                    {
                                        predmet_id = $(this).find("option:selected").val();
                                        alert(predmet_id);
                                    });

                                    $.get(
                                        "ajax/izmenaLabVezbe.php?zid=1003&predmet_id="+predmet_id+"&lab_vezba_id="+lab_vezba_id+"",
                                        {},
                                        function (odgovor,status)
                                        {
                                            $("#sar").html(odgovor);
                                        }
                                    );

                                    $.get(
                                        "ajax/izmenaLabVezbe.php?zid=1004&lab_vezba_id="+lab_vezba_id+"",
                                        {},
                                        function (odgovor,status)
                                        {
                                            $("#materijali").html(odgovor);

                                        }
                                    );


                                }
                            );
                    }
                );
            });
        }
    );
});