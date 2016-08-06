/**
 * Created by Milos on 14.6.2016..
 */
$("#ulogujSe").onclick(function () {
    var kor_ime = $("#kor_ime").val();
    var lozinka = $("#lozinka").val();

    if(kor_ime == "" || kor_ime.length < 3)
    {
        alert("Нисте унели корисничко име или је мање од три карактера. Унесите поново.");
        kor_ime = "";
        return;
    }
    if(lozinka == "" || lozinka.length < 3)
    {
        alert("Нисте унели лозинку или је мања од три карактера. Унесите поново.");
        lozinka = "";
        return;
    }

    $.post("ajax/prijavljivanje.php",{kor_ime:kor_ime, lozinka:lozinka}, function (odgovor,status) {
        

    })

    if(status == "success")
    {
        kor_ime = "";
        lozinka = "";

    }


    
})