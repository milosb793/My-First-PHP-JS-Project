<?php
session_start();
require_once "include/class.Baza.php";
require_once "include/class.Korisnik.php";
require_once "include/class.Administrator.php";
require_once "include/class.Saradnik.php";
require_once "include/class.Predmet.php";
require_once "include/class.Lab_vezba.php";
require_once "include/class.Metode.php";
//require_once "include/";
?>
<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Тестирање</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
proba

<?php
 phpinfo();

$rez = Baza::vratiInstancu()->select("SELECT fajl_id, naziv FROM fajlovi WHERE materijal_id=52");
$rez = $rez->fetch_assoc();
$id = intval($rez['fajl_id']);

echo "<a href='ajax/download.php?id={$id}' > {$rez['naziv']} </a>";
?>


</body>


</html>