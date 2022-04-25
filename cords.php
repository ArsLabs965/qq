<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    
    exit();
}
include 'database/db.php';
 $connection = connect();

 mysqli_query($connection, "UPDATE `files` SET `x` = $_GET[x] WHERE `id` = '$_GET[id]' AND `login` = '$_SESSION[accaunt]' AND `way` = $_GET[way]");
 mysqli_query($connection, "UPDATE `files` SET `y` = $_GET[y] WHERE `id` = '$_GET[id]' AND `login` = '$_SESSION[accaunt]' AND `way` = $_GET[way]");




?>