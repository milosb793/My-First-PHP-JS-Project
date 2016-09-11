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

    if(isset($_GET['materijal_id']))
    {
        $materijal_id = intval($_GET['materijal_id']);

        $query = "INSERT INTO fajlovi ( materijal_id, naziv, velicina, tip, sadrzaj )  
            VALUES ( {$materijal_id},'{$fileName}', '{$fileSize}', '{$fileType}', '{$sadrzaj}')";

        if(  Baza::vratiInstancu()->inUpDel($query)  )
            echo "Фајл {$fileName} је убачен.";
        else
            echo "Дошло је до грешке при убацивању фајла у табелу." . "\nГрешка: " . Baza::vratiInstancu()->vratiObjekatKonekcije()->error;

        return;
    }

    if(isset($_GET['lab_vezba_id']))
    {
        $materijal_id = "";
        echo "Поздрав из upload.php?zid=1&lab_vezba_id={$_GET['lab_vezba_id']}";
        $i = 0;
        $lab_vezba_id= intval($_GET['lab_vezba_id']);
        if( Baza::vratiInstancu()->inUpDel("INSERT INTO materijal ( lab_vezba_id ) VALUES ( {$lab_vezba_id} )") )
        {
            $rs = Baza::vratiInstancu()->select("SELECT materijal_id FROM materijal WHERE lab_vezba_id={$lab_vezba_id}");

            while($materijal_id = $rs->fetch_assoc()) $i++; // да дођемо до последњег записа

            $rs->data_seek($i-1);
            $materijal_id = $rs->fetch_assoc();

                $query = "INSERT INTO fajlovi ( materijal_id, naziv, velicina, tip, sadrzaj )  
                VALUES ( {$materijal_id['materijal_id']},'{$fileName}', '{$fileSize}', '{$fileType}', '{$sadrzaj}')";

                if (Baza::vratiInstancu()->inUpDel($query))
                    echo "Фајл {$fileName} је убачен.";
                else
                    echo "Дошло је до грешке при убацивању фајла у табелу." . "\nГрешка: " . Baza::vratiInstancu()->vratiObjekatKonekcije()->error;

        }
        else echo Baza::vratiInstancu()->vratiObjekatKonekcije()->error;
    }
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