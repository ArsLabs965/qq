<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    
    exit();
}
include 'database/db.php';
 $connection = connect();

 
    mysqli_query($connection, "UPDATE `files` SET `way` = $_GET[folder] WHERE `id` = $_GET[id] AND `login` = '$_SESSION[accaunt]'");

 

 




?>