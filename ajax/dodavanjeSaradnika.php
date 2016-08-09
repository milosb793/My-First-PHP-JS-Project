<?php
require_once "../include/class.Administrator.php";

echo Administrator::dodajSaradnika($_POST['ime_prezime'],$_POST['kor_ime'], $_POST['lozinka'],$_POST['e_mail'],$_POST['opis'],$_POST['status'],$_POST['slika_url']);
echo isset($odgovor)?$odgovor:"Празно";

// stampa oba pozdrava
//echo "Поздрав са странице!";
//echo "Поздрав са странице!!";



?>