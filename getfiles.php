<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/login.php");
    exit();
}
include 'database/db.php';
 $connection = connect();

$recv = mysqli_query($connection, "SELECT * FROM `files` WHERE `login` = '$_SESSION[accaunt]' AND `way` = $_GET[way]");
    while(($ac = mysqli_fetch_assoc($recv))){
        echo $ac[id];
        echo ',';
        echo $ac[name];
        echo ',';
        echo $ac[way];
        echo ',';
        echo $ac[type];
        echo ',';
        echo $ac[servername];
        echo ',';
        echo $ac[x];
        echo ',';
        echo $ac[y];
        
        echo ':';
       
        }

        $recv = mysqli_query($connection, "SELECT * FROM `folders` WHERE `login` = '$_SESSION[accaunt]' AND `way` = $_GET[way]");
        while(($ac = mysqli_fetch_assoc($recv))){
            echo $ac[id];
            echo ',';
            echo $ac[name];
            echo ',';
            echo $ac[way];
            echo ',';
            echo 'folder/folder';
            echo ',';
            echo 'folder';
            echo ',';
            echo $ac[x];
            echo ',';
            echo $ac[y];
            
            echo ':';
           
            }




?>