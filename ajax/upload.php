<?php
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

$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
$status = true;

if (empty($fileTmpLoc) || empty($fileName))
{ // if file not chosen
    echo "Грешка: Нисте одабрали фајл!";
    exit;
}

if(true)
{
    foreach($podrzani_formati as $format)
    {
        if(!strstr($fileType,$format) )
            $status = false;
    }
    if($status)
    {
        if(move_uploaded_file($fileTmpLoc, "../doc/$fileName"))
        {
            echo "Датотека {$fileName} је успешно убачена!";
        } else
        {
            echo "Грешка при премештању фајлова!";
        }
    }
}

?>