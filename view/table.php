<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table</title>
</head>
<body>
<style>
        .wrapper{
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
        }
        /* Перенес стили в верстку для меньшего количества файлов */
   table{
       border: 1px solid black;
       border-top: 0;
       padding: 0;
       border-spacing: 0;
   }
   input{
       margin-top: 20px;
       margin-left:220px;
   }
    td{
        border-top: 1px solid black;

        color: #ffff;
        margin: 0;
        padding: 5px 10px;
        text-align: center;
    }
    tr{
        background-color: silver;
    }
</style>
    <div class="wrapper">
<div>
   
    <?php 
    require "../model/model.php";
    $base = new baseData();
    $base ->connectDB("localhost","root","","staff","utf8mb4");
    $result = $base->getPerson();
    if(!$result){
    die("Data Not Found");
    }else{?>
     <table>
    <tr>
        <td>UID</td>
        <td>Name</td>
        <td>Age</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Gender</td>
    </tr>
    <?php foreach ($result as $arr){  
        ?>
        <tr>
        <td><?= $arr[0]?></td>
        <td><?= $arr[1]?></td>
        <td><?= $arr[2]?></td>
        <td><?= $arr[3]?></td>
        <td><?= $arr[4]?></td>
        <td><?= $arr[5]?></td>
    
        </tr>
        


        <?php }
    ?></table>
<form action="../controler/download.php">
<input type="submit" value="Export to CSV">
</form>
   
    <?php
    
    }?>
    </div>
</div>
</body>
</html>