<?php
session_start();
require_once "include/class.Baza.php";
require_once "include/class.Korisnik.php";
require_once "include/class.Administrator.php";
require_once "include/class.Saradnik.php";
require_once "include/class.Predmet.php";
require_once "include/class.Metode.php";
//require_once "include/";
?>
<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .invalid {
            -webkit-box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
            -moz-box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
            box-shadow: 0px 0px 14px -1px rgba(255,0,0,0.45);
        }
    </style>
</head>

<body>
Сарадници:
<?php
echo "Проба";

$predmeti = Predmet::vratiPredmete(1);
foreach ($predmeti as $p)
{
    var_dump($p);
    echo "<br/>";
}

?>


</body>


</html>