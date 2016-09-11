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
                    }); // post 1001
            }); // predmetLab change

            $('#dodajLab').click(function()
            {
                var naziv_v = $("#nazivLab").val();
                var opis_v = $("#opisLab").val();
                var datum = $("#datumLab").val();
                var lab = $("#brojLab").find("option:selected").val();
                var predmet_id = $("#predmetLab").find("option:selected").val();
                var saradnik_id = $("#saradnikLab").find("option:selected").val();
                var fajl = $('input[type=file]')[0].files[0];
                var ekst;
                var u_redu = true;
                var podrzani_formati = ["jpg", "png", "gif", "bmp", "pdf", "doc", "docx", "txt", "zip", "rar", "ppt", "pptx", "xls", "xlsx"];

                if( proveri($("#nazivLab"),5) && proveri($("#opisLab"),5) &&  proveri($("#datumLab"),15) &&
                    validirajListu( $("#brojLab")) && validirajListu( $("#predmetLab")) && validirajListu( $("#saradnikLab")) )
                {
                if (confirm("Јесте ли сигруни да су сви подаци у реду? ")) {
                    if (fajl) {
                        ekst = fajl.name.split(".").pop();
                        u_redu = podrzani_formati.indexOf(ekst) > -1;

                        if (u_redu) {
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
                                function (odgovor, status) {
                                    var niz = odgovor.split("Материјал: ");
                                    var materijal_id = niz[1];


                                    alert(odgovor.split("!")[0] + "!");

                                    if ((odgovor.indexOf("Грешка") <= -1 )) {
                                        uploadFile(materijal_id, 0);
                                    }
                                });
                        }
                        else
                            alert("Изабрали сте неподржан тип фајла. ");
                    }
                    else {
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
                            function (odgovor, status) {
                                var niz = odgovor.split("Материјал: ");
                                var materijal_id = niz[1];

                                alert(odgovor.split("!")[0] + "!");

                                if ((odgovor.indexOf("Грешка") <= -1 )) {
                                    uploadFile(materijal_id, 0);
                                }
                            });
                    }
                }
            }
                });

            });
            // читање фајлова //


});// dodajVezbu link
