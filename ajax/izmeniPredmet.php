<?php

require_once "../include/class.Administrator.php";

if(isset($_POST['pid']))
    Administrator::izmeniPredmet(intval($_POST['pid']));
else
    echo "Није послат параметар пост-ом!";