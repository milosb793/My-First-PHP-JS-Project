<?php
$host='localhost'; //this is the database hostname, Do not change this.
$user='root'; //please set your mysqli user name
$pass=''; // please set your mysqli user password
$dbname='lab_vezbe'; //please set your Database name
$charset='utf8'; // specify the character set
$collation='utf8_general_ci'; //specify what collation you wish to use

$db = mysqli_connect('localhost',$user,$pass,$dbname) or die("mysqli could not CONNECT to the database, in correct user or password " . mysqli_error($db));

$result=mysqli_query($db,"show tables") or die("mysqli could not execute the command 'show tables' " . mysqli_error($db));
while($tables = mysqli_fetch_array($result)) {
foreach ($tables as $key => $value) {
mysqli_query($db,"ALTER TABLE $value CONVERT TO CHARACTER SET $charset COLLATE $collation") or die("Could not convert the table " . mysqli_error($db));
}}
mysqli_query($db,"ALTER DATABASE $dbname DEFAULT CHARACTER SET $charset COLLATE $collation") or die("could not alter the collation of the databse " . mysqli_error($db));
echo "The collation of your database has been successfully changed!";
?>