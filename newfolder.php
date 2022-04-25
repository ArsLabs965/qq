<?php
session_start();
if($_SESSION['accaunt'] == NULL){
    
    exit();
}
include 'database/db.php';
 $connection = connect();


 $name= mysqli_real_escape_string($connection, $_GET['name']);

mysqli_query($connection, "INSERT INTO `folders` (`name`, `way`, `login`) VALUES ('$name', $_GET[way], '$_SESSION[accaunt]')");
                   
                
            
        
    
        
    




?>