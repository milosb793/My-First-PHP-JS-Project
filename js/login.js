$("#loginLink").click(function ()
{
    $.get(
        "ajax/login.php?zid=1000",
        {},
        function (podaci, status)
        {
            $("#sadrzajIndex").html(podaci);

            $("#ulogujSe").click(function ()
            {
                var kor_ime = $("#kor_ime").val();
                var loz = $("#lozinka").val();

                $.post(
                    "ajax/login.php?zid=1",
                    {kor_ime:kor_ime, lozinka:loz},
                    function (odgovor,status)
                    {
                        var niz = odgovor.split("!");
                        alert(status + niz[0] + niz[1]);
                        if(odgovor.indexOf(".php") > -1)
                            if(niz[1] === undefined || niz[1] == null || niz == false)
                                window.location.href = odgovor;
                            else
                                window.location.href = niz[1];
                    }
                );
            });
        }
    );

});

