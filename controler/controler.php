<?php
require "../model/model.php";

$file = new fileCSV("localhost","root","","staff","utf8mb4");
$filename = $file->uploadCSV($_FILES["userfile"]);
$file_array = file('../files/' . $filename);
unlink("../files/" . $filename);
array_shift($file_array);
if(!$file->addPerson($file_array)){
header('Location: ../view/index.php?base=false');
}else{
header('Location: ../view/index.php?base=true');
}
?>