<?php

require_once "../include/class.Administrator.php";

Administrator::dodajPredmet($_POST['naziv'],$_POST['opis']);
Administrator::dodajPredmet($_POST['nazivpredmeta'],$_POST['opisPredmeta']);