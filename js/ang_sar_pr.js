/**
 * Created by logos on 17.8.16..
 */
var saradnik_id;
var predmet_id;
var angazovan_ = false;

$("#angazujSaradnikaLink").click(function ()
{
    $.get(
        "ajax/dodavanjeSaradnikPredmet.php?zid=1000",
        {},
        function (podaci,status)
        {
            $("#sadrzaj").html(podaci);

            $("#saradnici").change(function ()
            {
               saradnik_id = $(this).find("option:selected").val();
                if (saradnik_id !== undefined || saradnik_id != null || saradnik_id > 0)
                {
                    $("#predmeti").change(function ()
                    {
                        predmet_id =  $(this).find("option:selected").val();


                    });//predmeti change

                }//if

            });//saradnici change

            $("#angazuj").click(function ()
            {
                if(predmet_id != 0 || predmet_id !== undefined || predmet_id != null)
                {
                    if (confirm("Јесте ли сигурни?"))
                    {
                        $.get(
                            "ajax/dodavanjeSaradnikPredmet.php?saradnik_id="+saradnik_id+"&predmet_id="+predmet_id+"",          //provera da vec nije angazovan
                            {},
                            function (odgovor, status)
                            {
                                angazovan_ = odgovor;
                                if (angazovan_.indexOf("true") > -1)
                                {
                                    alert("Сарадник је већ ангажован на овом предмету!");
                                }
                                else alert(odgovor);
                            }); //get
                    }
                }
                else alert("Нисте одабрали предмет!");

            });//angazuj button



        }// prvi get
    );
});// angazujSaradnikaLink