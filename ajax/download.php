<?php
require_once "../include/class.Baza.php";

if(isset($_GET['materijal_id']))
{
// if id is set then get the file with the id from database

    $materijal_id    = intval($_GET['materijal_id']);

       $rez = Baza::vratiInstancu()->select("SELECT * FROM fajlovi WHERE materijal_id={$materijal_id}");
    $fajl = $rez->fetch_assoc();

    header("Content-length: {$fajl['velicina']}");
    header("Content-type: {$fajl['tip']}");
    header("Content-Disposition: attachment; filename={$fajl['naziv']}");
    echo $fajl['sadrzaj'];

    exit;
}