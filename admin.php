<?php
session_start();
require_once "include/class.Metode.php";
Metode::autorizuj("admin_id");
?>

<!DOCTYPE html>
<html lang="rs">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php



echo "Пријављен је админ са ИД-ом: {$_SESSION['admin_id']}" . "<br/>";
echo "Кор. име: {$_SESSION['korisnik']['kor_ime']}" . "<br/>";
echo "Лозинка(хеш): " . sha1($_SESSION['korisnik']['kor_ime']) . "<br/>";
echo "Е-пошта: {$_SESSION['korisnik']['e_mail']}";

?>

</body>
</html>

