var poruka = "";


function proveri(polje,min)
{
    var poruka = "";
    var vrednost = $(polje).val();

    if(vrednost!="" || vrednost!=" ")
    {
        if (vrednost.length >= min)
        {
            $(polje).removeClass("invalid");
            return true;
        }
        else
        {
            $(polje).addClass(" invalid");
            $("#greska").html("Нисте унели "+min+" карактера.");
            return false;
        }
    }
    else
        {
            $(polje).addClass(" invalid");
            $("#greska").html("Поље не сме бити празно.");
            return false;
        }
}

function dupljaPolja(polje1,polje2)
{
    var vrednost1 = $(polje1).val();
    var vrednost2 = $(polje2).val();

    if( proveri(polje1,3) && proveri(polje2,3) )
    {
        if( vrednost1 == vrednost2)
        {
            $(polje2).removeClass("invalid");
            return true;
        }
        else
        {
            $(polje2).addClass("invalid");
            $("#greska").html("Лозинке се не поклапају.");
            return false;
        }
    }
    else
    {
        $(polje1).addClass("invalid");
        $("#greska").html("Нисте унели лозинку.");
        return false;
    }
}

function proveriMejl(polje)
{
    var vrednost = $(polje).val();
    var nedozvoljeniZnaci = " /:,;";

    if (vrednost == "")
    {
        $(polje).addClass(" invalid");
        $("#greska").html("Нисте унели email");
        return false;
    }
    for (var k=0; k<nedozvoljeniZnaci.length; k++)
    {
        var nepozeljanKarakter = nedozvoljeniZnaci.charAt(k);
        if (vrednost.indexOf(nepozeljanKarakter) > -1)
        {
            $(polje).addClass(" invalid");
            $("#greska").html("Мејл адреса садржи непожељне знаке!");
            return false;
        }
    }
    var naPoziciji = vrednost.indexOf("@",1); //ако постоји знак @ на првом или другом месту
    if (naPoziciji == -1)
    {
        $(polje).addClass(" invalid");
        $("#greska").html("Мејл адреса је прекратка!");
        return false;
    }
    if (vrednost.indexOf("@",naPoziciji+1) != -1) // ако @ постоји уопште
    {
        $(polje).addClass(" invalid");
        $("#greska").html("Мејл адреса не садржи знак @!");
        return false;
    }
    var pozicijaTacke = vrednost.indexOf(".",naPoziciji);
    if (pozicijaTacke == -1)  // ако је тачка на првој или другој позицији
    {
        $(polje).addClass(" invalid");
        $("#greska").html("У адреси не постоји тачка!");
        return false;
    }
    if (pozicijaTacke+3 > vrednost.length)	// ако је мејл краћи од 3 каракера
    {
        $(polje).addClass(" invalid");
        $("#greska").html("Изгледа да нисте унели део после тачке!");
        return false;
    }

    $(polje).removeClass("invalid");
    return true;
}

function validirajListu(lista)
{
    var opcija = $(lista).find("option:selected").val();

    if( opcija )
    {
        $(lista).removeClass("invalid");
        return true;
    }
    else
    {
        $(lista).addClass(" invalid");
        $("#greska").html("Нисте изабрали опцију.");
        return false;
    }
}