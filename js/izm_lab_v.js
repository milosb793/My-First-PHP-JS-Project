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
          //change predmet

                $.get(
                    "ajax/izmenaLabVezbe.php?zid=1001&predmet_id="+predmet_id+"",
                    {},
                    function (odgovor, status)
                    {
                        $("#lab_vezbe").html(odgovor); //div lista vezbi


                        $("#lab_vezba").change(function ()
                        {
                            lab_vezba_id = $(this).find("option:selected").val();

                        $.get("ajax/izmenaLabVezbe.php?zid=1002&lab_vezba_id=" + lab_vezba_id + "",
                            {},
                            function (odgovor, status)
                            {
                                $("#izmenaLabVezbeForma").html(odgovor);

                                // $("#predmetLab").change(function ()
                                // {
                                    predmet_id = $("#predmetLab").find("option:selected").val();
                                    // change predmet x2
                                    $.get(
                                        "ajax/izmenaLabVezbe.php?zid=1003&predmet_id=" + predmet_id + "&lab_vezba_id=" + lab_vezba_id + "",
                                        {},
                                        function (odgovor, status)
                                        {
                                            $("#sar").html(odgovor);

                                            $.get(
                                                "ajax/izmenaLabVezbe.php?zid=1004&lab_vezba_id=" + lab_vezba_id + "",
                                                {},
                                                function (odgovor, status)
                                                {
                                                    $("#materijali").html(odgovor);

                                                    $(".obrisiFajl").click(function ()
                                                    {
                                                            var podaci = $(this).attr('class');
                                                            var niz = podaci.split(" ");

                                                        if(confirm("Јесте ли сигурни да желите да обришете фајл?"))
                                                            $.get(
                                                                "ajax/izmenaLabVezbe.php?zid=0&materijal_id="+niz[1]+"&fajl_id="+niz[2]+"",
                                                                {},
                                                                function (odgovor,status)
                                                                {
                                                                    var fajl_id = "#fajl"+niz[2];
                                                                    if( odgovor.indexOf("Успешно") > -1 )
                                                                        $(fajl_id).remove();
                                                                }); //get fajl
                                                    }); // obrisiFajl click


                                                    $("#izmeniLab").click(function ()
                                                    {
                                                        var naziv = $("#nazivLab").val();
                                                        var opis = $("#opisLab").val();
                                                        var datum = $("#datumLab").val();
                                                        var br_lab = $("#brojLab").find("option:selected").val();
                                                        var predmet_id = $("#predmetLab").find("option:selected").val();
                                                        var saradnik_id = $("#saradnik").find("option:selected").val();
                                                        var fajl =  $('input[type=file]')[0].files[0];
                                                        var ekst;
                                                        var u_redu = true;
                                                        var podrzani_formati = ["jpg","png","gif","bmp","pdf","doc","docx","txt","zip","rar","ppt","pptx","xls","xlsx"];

                                                        if(confirm("Јесте ли сигурни да су сви подаци у реду?"))
                                                        {
                                                            if(fajl)
                                                            {
                                                                ekst = fajl.name.split(".").pop();
                                                                u_redu = podrzani_formati.indexOf(ekst) > -1;

                                                                if (u_redu)
                                                                {
                                                                    uploadFile(0, lab_vezba_id);

                                                                    $.post(
                                                                        "ajax/izmenaLabVezbe.php?zid=1",
                                                                        {
                                                                            lab_vezba_id: lab_vezba_id,
                                                                            naziv: naziv,
                                                                            opis: opis,
                                                                            datum: datum,
                                                                            br_lab: br_lab,
                                                                            predmet_id: predmet_id,
                                                                            saradnik_id: saradnik_id
                                                                        },
                                                                        function (odgovor, status) {
                                                                            alert(odgovor);
                                                                        });
                                                                }
                                                                else alert("Фајл није подржаног формата. ");
                                                            }
                                                            else
                                                            {
                                                                $.post(
                                                                    "ajax/izmenaLabVezbe.php?zid=1",
                                                                    {
                                                                        lab_vezba_id: lab_vezba_id,
                                                                        naziv: naziv,
                                                                        opis: opis,
                                                                        datum: datum,
                                                                        br_lab: br_lab,
                                                                        predmet_id: predmet_id,
                                                                        saradnik_id: saradnik_id
                                                                    },
                                                                    function (odgovor, status) {
                                                                        alert(odgovor );
                                                                    });
                                                            }
                                                        }
                                                    });// izeniLab click
                                                }); //get 1004
                                        }); // change lab_vezba
                                     }); // get 1003
                                // }); //change predmet
                            }); // change predmet
                        }); //get 1002
                    }); //get 1001
            }); //get 1000
        }); //click link


