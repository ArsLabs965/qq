<?php
 session_start();
 include 'database/db.php';
 $connection = connect();
 if($_SESSION['accaunt'] != NULL){
     header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/index.php");
     exit();
 }
 $option = 0;
if(isset($_POST[btn])){
    if($_POST[login] != '' AND $_POST[password] != ''){
       
$login = mysqli_real_escape_string($connection, $_POST[login]);
$password = mysqli_real_escape_string($connection, $_POST[password]);
$logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
if(($ac = mysqli_fetch_assoc($logge))){
    if($ac['password'] == $password){
        $_SESSION['accaunt'] = $login;
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/index.php");
        exit();
    }else{
        $option = 2;
    }
}else{
    $option = 2;
}
    }else{
        $option = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@1,300&family=IBM+Plex+Serif&family=PT+Sans:ital@1&family=Rowdies&family=Ubuntu+Condensed&display=swap" rel="stylesheet">
</head>
<body>
<a href="index.php">На главную</a>
   <div class="center">
       <div class="padd">
       <h1>Вход</h1>
       <a href="reg.php">Регистрация</a>
        <br><br>
        <?php
            if($option == 1){
                echo '<p class="red">Заполните все поля</p><br>';
            }
            if($option == 2){
                echo '<p class="red">Неверный логин или пароль</p><br>';
            }
        ?>
        <form action="" method="post">
            <input type="text" value="<?php echo $login; ?>" name="login" placeholder="Логин" class="input"><br><br>
            <input type="password" placeholder="Пароль" name="password" class="input"><br><br>
            <input type="submit" name="btn" class="input_btn" value="Войти">
        </form>
       </div>
       
   </div>
</body>
</html>