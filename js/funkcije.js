// za admin.php


// ДОДАВАЊЕ САРАДНИКА

$('#dodajSaradnikaLink').click(function() {
    $('#dodavanjeSaradnikaForma').toggle(function() {
        if ($(this).css('display')=='none'){
            $(this).prop('hidden', 'hidden');
        }
        else
        {
            $(this).removeProp('hidden');
            $(this).css('display','block');
        }
    })
});

    // прослеђивање форме //
$('button[name=prosledi]').click(function () {
    var imeprez = $('input[name=ime_prezime]').val();
    var kor_ime = $('input[name=kor_ime]').val();
    var loz = $('input[name=lozinka]').val();
    var em = $('input[name=e_mail]').val();
    var op = $('input[name=opis]').val();
    var st = $('select[name=status] option:selected').val();
    var url = $('input[name=slika_url]').val();
    //proba var status;

    alert("pre posta");
    $.post("ajax/dodavanjeSaradnika.php",
        {ime_prezime:imeprez, kor_ime:kor_ime, lozinka:loz, e_mail:em, opis:op, status:st, slika_url:url},
        function (odgovor, status) {
            alert("Одговор: " + odgovor +'\n'+ "Статус: " + status);
        });
    alert("posle posta");


    // Не ради //
//     $.ajax({
//         url: "ajax/dodavanjeSaradnika.php",
//         type: "POST",
//         data: "ime_prezime="+imeprez + "&kor_ime=" + kor_ime + "&lozinka=" + loz + "&e_mail=" +em + "&opis=" + op + "&status=" + st + "&slika_url=" + url,
//     success: function(odg) {
//         alert(odg);
//     },
//     error: function () {
//         alert("Greska");
//     }
// })

});

