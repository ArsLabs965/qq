<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/login.php");
    exit();
}
include 'database/db.php';
 $connection = connect();

 
 mysqli_query($connection, "DELETE FROM `folders` WHERE `id` = '$_GET[id]' AND `login` = '$_SESSION[accaunt]'");



?>