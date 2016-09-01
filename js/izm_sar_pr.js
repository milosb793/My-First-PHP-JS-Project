$("#profilLink").click(function ()
{
    $.get(
        "ajax/izmenaProfilaSaradnika.php?zid=1000",
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);

            $("#izmeniBtn").click(function (e)
            {
                var opis = $("#opis").val();
                var slika_url = $("#slikaURL").val();
                var lozinka = $("#lozinka");
                var lozinka2 = $("#lozinka2");

                if(  lozinka.val() && lozinka2.val() == "" )
                {
                    alert("Морате унети лозинку још једном ради потврде.");
                    lozinka2.css("box-shadow","0px 0px 14px -1px rgba(255,0,0,0.45)");
                    lozinka2.select();
                }
                else if( lozinka.val() != "" && lozinka2.val() != lozinka.val())
                {
                    alert("Лозинке се не поклапају.");
                    lozinka2.css("box-shadow","0px 0px 14px -1px rgba(255,0,0,0.45)");
                    lozinka2.select();
                }
                else
                {
                    lozinka.css("box-shadow","none");
                    lozinka2.css("box-shadow","none");

                    if(confirm("Јесте ли сигурни да су подаци у реду?"))
                    {
                        $.post(
                            "ajax/izmenaProfilaSaradnika.php?zid=1",
                            {lozinka:lozinka.val(),opis:opis,slika_url:slika_url},
                            function (odgovor,status)
                            {
                                alert(odgovor);

                            }); // post

                    }//confirm

                }// else lozinka
            });// izmeni click

        });
});// profil click