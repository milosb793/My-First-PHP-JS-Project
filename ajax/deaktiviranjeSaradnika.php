<?php
require_once "../include/class.Baza.php";
require_once "../include/class.Saradnik.php";
require_once "../include/class.Administrator.php";
require_once "../include/class.Izuzetak.php";
require_once "../include/class.Metode.php";

if(isset($_POST['sid'])) {

        Administrator::deaktivirajSaradnika(intval(trim($_POST['sid'])));

}
else echo "Нешто није у реду са пост-ом.";
