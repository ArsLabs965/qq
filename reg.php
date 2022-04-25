<?php
session_start();
if($_SESSION['accaunt'] != NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@1,300&family=IBM+Plex+Serif&family=PT+Sans:ital@1&family=Rowdies&family=Ubuntu+Condensed&display=swap" rel="stylesheet">
</head>
<body>
    <a href="index.php">На главную</a>
   <div class="center">
       <div class="padd">
       <h1>Регистрация</h1>
       <a href="login.php">Вход</a>
        <br><br>
        К сожалению на данный момент регистрация не доступна!
       </div>
       
   </div>
</body>
</html>