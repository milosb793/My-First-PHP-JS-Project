<?php
require_once "../include/class.Baza.php";

if(isset($_GET['id']))
{
// if id is set then get the file with the id from database

    $id    = intval($_GET['id']);

       $rez = Baza::vratiInstancu()->select("SELECT * FROM fajlovi WHERE fajl_id={$id}");
    $fajl = $rez->fetch_assoc();

    header("Content-length: {$fajl['velicina']}");
    header("Content-type: {$fajl['tip']}");
    header("Content-Disposition: attachment; filename={$fajl['naziv']}");
    echo $fajl['sadrzaj'];

    exit;
}