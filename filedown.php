<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    
    exit();
}
include 'database/db.php';
 $connection = connect();

 $recv = mysqli_query($connection, "SELECT * FROM `files` WHERE `login` = '$_SESSION[accaunt]' AND `id` = $_GET[id]");
    if(($ac = mysqli_fetch_assoc($recv))){
        $rec = mysqli_query($connection, "SELECT * FROM `folders` WHERE `id` = '$ac[way]'");
    if(($a = mysqli_fetch_assoc($rec))){
        mysqli_query($connection, "UPDATE `files` SET `way` = $a[way] WHERE `id` = $_GET[id] AND `login` = '$_SESSION[accaunt]'");
    }
        
    }
   

 

 




?>