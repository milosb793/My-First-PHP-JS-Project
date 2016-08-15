/**
 * Created by logos on 8.8.16..
 */



// ### ОДЈАВЉИВАЊЕ ### //
$("#odjaviSe").click(function ()
{
    if(confirm("Јесте ли сигурни? :("))
        $.post("login.php?id=1",
                function (odgovor,status) { window.location.assign("login.php"); });
});
// ### КРАЈ ФУНКЦИЈЕ ЗА ОДЈАВЉИВАЊЕ ### //