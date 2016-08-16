var predmet_id;

$("#izmeniPredmetLink").click(function () {

    $.get(
        "ajax/izmenaPredmeta.php?zid=1000",
        {},
        function (podaci, status) {
            $("#sadrzaj").html(podaci);

            $("#izmeniPredmetDiv").toggle(function () {

                if ($(this).css('display') == 'none') {
                    $(this).prop('hidden', 'hidden');
                }
                else {
                    $(this).removeProp('hidden');
                    $(this).css('display', 'block');
                }
            });

            $("#listaPredmeta").change(function () {

                    predmet_id = $(this).find("option:selected").val();

                    if (predmet_id !== undefined || predmet_id != null || predmet_id > 0) {
                        $.get("ajax/izmenaPredmeta.php?pid=" + predmet_id + "",
                            {},
                            function (odgovor, status) {
                                var niz = odgovor.split("|");
                                var i = 0;

                                $('#forma').find("input[type=text], input[type=password], input[type=email], textarea").each(function (ev) {
                                    if (!$(this).val()) {
                                        if (niz.indexOf("status") > -1)
                                            ++niz;

                                        $(this).attr("placeholder", niz[i++]);
                                    }
                                });

                                $("#izmeniPredmetForma").toggle(function () {
                                    if ($(this).css('display') == 'none') {
                                        $(this).prop('hidden', 'hidden');
                                    }
                                    else {
                                        $(this).removeProp('hidden');
                                        $(this).css('display', 'block');
                                    }
                                });

                                $("#izmeniPredmet").click(function () {
                                    var naziv = $('#nazivPredmeta2').val();
                                    var opis = $('#opisPredmeta2').val();

                                    if (confirm("Јесте ли сигурни да су сви подаци у реду?")) {
                                        $.post("ajax/izmenaPredmeta.php?zid=1",
                                            {pid: predmet_id, naziv: naziv, opis: opis},
                                            function (odgovor, status) {
                                                alert(odgovor);
                                            });
                                    }
                                })
                            });
                    }
                }
            );

        });

});