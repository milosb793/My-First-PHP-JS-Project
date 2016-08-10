<?php
require_once "../include/class.Administrator.php";

Administrator::dodajSaradnika($_POST['ime_prezime'],$_POST['kor_ime'], $_POST['lozinka'],$_POST['e_mail'],$_POST['opis'],$_POST['status'],$_POST['slika_url']);
//echo "Поздрав са странице!";
//echo "Поздрав са странице!!";



?>