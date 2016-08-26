<?php
require_once "../include/class.Baza.php";





//if ( !isset($fileTmpLoc) )
//{ // if file not chosen
//    echo "Грешка: Нисте одабрали фајл!";
//    exit;
//}

if(isset($_GET['zid']) && $_GET['zid'] == 1 )
{
    //if(isset($_GET['zid']) && $_GET['zid'] == 2 )
//{
//    if ( $_FILES['file']['error'] > 0 )
//    {
//        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
//    }
//    else
//    {
//        move_uploaded_file($_FILES['file']['tmp_name'], '../doc/' . $_FILES['file']['name']);
//    }
//
//}
    $podrzani_formati = ['jpg','png','gif','bmp','pdf','doc','docx','txt','zip','ppt','pptx','xls','xls'];

    $fileName = Baza::vratiInstancu()->vratiObjekatKonekcije()->real_escape_string($_FILES["file1"]["name"]); // The file name
    $fileTmpLoc = Baza::vratiInstancu()->vratiObjekatKonekcije()->real_escape_string($_FILES["file1"]["tmp_name"]); // File in the PHP tmp folder
    $fileType = Baza::vratiInstancu()->vratiObjekatKonekcije()->real_escape_string($_FILES["file1"]["type"]); // The type of file it i
    $fileSize = intval($_FILES["file1"]["size"]); // File size in bytes
    $fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
    $status = true;

//    $fp      = fopen($fileTmpLoc, 'r');
//    $sadrzaj = fread($fp, filesize($fileName));
//    $sadrzaj = addslashes($sadrzaj);
//    fclose($fp);
    $sadrzaj = Baza::vratiInstancu()->vratiObjekatKonekcije()->real_escape_string(file_get_contents($fileTmpLoc));

    if(!get_magic_quotes_gpc())
    {
        $fileName = addslashes($fileName);
    }

    $materijal_id = intval($_GET['materijal_id']);

    $query = "INSERT INTO fajlovi ( materijal_id, naziv, velicina, tip, sadrzaj )  
        VALUES ( {$materijal_id},'{$fileName}', '{$fileSize}', '{$fileType}', '{$sadrzaj}')";

    if(  Baza::vratiInstancu()->inUpDel($query)  )
        echo "Фајл {$fileName} је убачен.";
    else
        echo "Дошло је до грешке при убацивању фајла у табелу.";

    return;
}

//if(true)
//{
//    foreach($podrzani_formati as $format)
//    {
//        if(!strstr($fileType,$format) )
//            $status = false;
//    }
//    if($status)
//    {
//        if(move_uploaded_file($fileTmpLoc, "../doc/$fileName"))
//        {
//            echo "Датотека {$fileName} је успешно убачена!";
//        } else
//        {
//            echo "Грешка при премештању фајлова!";
//        }
//    }
//}

?>