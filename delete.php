<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/login.php");
    exit();
}
include 'database/db.php';
 $connection = connect();

 $recv = mysqli_query($connection, "SELECT * FROM `files` WHERE `login` = '$_SESSION[accaunt]' AND `id` = '$_GET[id]'");
    if(($ac = mysqli_fetch_assoc($recv))){
        unlink('files/' . $ac[servername]);
    }
 mysqli_query($connection, "DELETE FROM `files` WHERE `id` = '$_GET[id]' AND `login` = '$_SESSION[accaunt]'");



?>