<?php
require_once "../include/class.Baza.php";

$fajl = array();

if(isset($_GET['materijal_id']))
{
    $materijal_id = intval($_GET['materijal_id']);

    $rez = Baza::vratiInstancu()->select("SELECT * FROM fajlovi WHERE materijal_id={$materijal_id}");
    $fajl = $rez->fetch_assoc();

}
else if( isset($_GET['fajl_id']) )
{
    $fajl_id = intval($_GET['fajl_id']);
    $rez = Baza::vratiInstancu()->select("SELECT * FROM fajlovi WHERE fajl_id={$fajl_id}");
    $fajl = $rez->fetch_assoc();
}

header("Content-length: {$fajl['velicina']}");
header("Content-type: {$fajl['tip']}");
header("Content-Disposition: attachment; filename={$fajl['naziv']}");
echo $fajl['sadrzaj'];

return;