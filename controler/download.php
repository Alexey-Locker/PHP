<?php
require "../model/model.php";
$file = new fileCSV("localhost","root","","staff","utf8mb4");
$file->preparingCSV("base");
$file->downloadFile("BASE_FILE.csv");
?>