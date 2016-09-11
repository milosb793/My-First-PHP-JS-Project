var sedmica;
var predmet_id;
var saradnik_id;
var lab_vezba_id;

$("body").on( 'click',"#pocetna",function ()
{
    $.get(
        "ajax/pocetna.php?zid=1000",
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);

            $("body").on("change","#sedmica",function()
            {
                sedmica = $(this).find("option:selected").val();

                $.get(
                    "ajax/pocetna.php?zid=1000&sedmica=" + sedmica + "",
                    {},
                    function (odgovor, status)
                    {
                        $("#sadrzaj").html(odgovor);
                        document.getElementById("sedmica").selectedIndex=sedmica+1;

                    }); // get sedmica
            });// change sedmica


            // $(".linkPredmet").click( function ()
            // {
            //     predmetClick($(".linkPredmet"));
            // }); // linkPredmet click
            //
            // $(".linkVezba").click(function()
            // {
            //     vezbaClick($(".linkVezba"));
            // });
            //
            //
            // $(".linkSaradnik").click(function()
            // {
            //     saradnikClick($(".linkSaradnik"));
            // });

        });
}); // pocetna click


function predmetClick(a)
{
    if(a)
        predmet_id = $(a).attr("class").split(" ")[1];
    else
        predmet_id = $(this).attr("class").split(" ")[1];

    $.get(
        "ajax/pocetna.php?zid=1&predmet_id="+predmet_id+"",
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);
        });// get 1
}

function vezbaClick(a)
{
    if(a)
        lab_vezba_id = $(a).attr("class").split(" ")[1];
    else
        lab_vezba_id = $(this).attr("class").split(" ")[1];

    $.get(
        "ajax/pocetna.php?zid=2&lab_vezba_id="+lab_vezba_id+"",
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);
        });// get 2

}

function saradnikClick(a)
{
    if(a)
        saradnik_id = $(a).attr("class").split(" ")[1];
    else
        saradnik_id = $(this).attr("class").split(" ")[1];


    $.get(
        "ajax/pocetna.php?zid=3&saradnik_id="+saradnik_id+"",
        {},
        function (odgovor,status)
        {
            $("#sadrzaj").html(odgovor);
        });// get 3
}


$("document").ready(function()
{
    setTimeout(function()
    {
        $("#pocetna").trigger('click');
    },10);
});