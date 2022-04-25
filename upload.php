<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    
    exit();
}
include 'database/db.php';
 $connection = connect();






       
       

        if(isset($_FILES[file]) AND $_FILES[file][size] > 0){
           
            $name = $_FILES[file][name];
            $tmp = $_FILES[file][tmp_name];
            $size = $_FILES[file][size];
            $type = $_FILES[file][type];
            
               $newname = time() . $name;
                
                  
                    move_uploaded_file($tmp, "files/" . $newname);
                    mysqli_query($connection, "INSERT INTO `files` (`name`, `login`, `type`, `servername`) VALUES ('$name', '$_SESSION[accaunt]', '$type', '$newname')");
                   
                
            
        
    }
        
    




?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" id="form" method="POST" enctype="multipart/form-data">
    <input class="input" type="file" name="file"> <input class="input_btn" type="submit" value="Загрузить"><br>
    <a href="cloud.php" class="grey">Назад</a>
    </form>
</body>
</html>