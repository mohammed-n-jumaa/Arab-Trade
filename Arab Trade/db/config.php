<?php
$hostName = "localhost";
$dbName = "testt";
$dbUser = "Abood";
$dbUserPass="SY)zKBlbuOg[b]s(";



//database sourse Name (dsn)

$dsn ="mysql:host=$hostName;dbname=$dbName";
// لخيارات عرض الاخطاء او عدم عرضها 
//php databaes opject (PDO) =>
$option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
?>