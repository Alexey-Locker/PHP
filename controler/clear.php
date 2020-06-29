<?php 

require "../model/model.php";

$base = new baseData();
$base -> connectDB("localhost","root","","staff","utf8mb4");
$base -> clearRecords();

header("location: ../view/index.php?clear=true");