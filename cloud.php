<?php
    session_start();
    if($_SESSION['accaunt'] == NULL){
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/qq/login.php");
        exit();
    }
    include 'database/db.php';
 $connection = connect();
$page = $_GET[way];
if($page > -1){
}else{
    $page = 0;
}
if($page != 0){
$recv = mysqli_query($connection, "SELECT * FROM `folders` WHERE `id` = '$page'");
    if(($ac = mysqli_fetch_assoc($recv))){
        if($ac[login] != $_SESSION[accaunt]){

        exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['accaunt']; ?> - QQ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@1,300&family=IBM+Plex+Serif&family=PT+Sans:ital@1&family=Rowdies&family=Ubuntu+Condensed&display=swap" rel="stylesheet">
</head>
<body>
    <canvas id="canvas" width="500px" height="500px"></canvas><br>
    <?php
        if($page != 0){
?>
    <h1><a onclick="window.history.back()">Назад</a></h1>
<?php
        }
    ?>
    <a href="out.php">Выйти</a><br>
    <a href="index.php">На главную</a>
    
    <div class="form_right">
    <?php
      if($page == 0){
    ?>
    <form action="upload.php" id="form" method="POST" enctype="multipart/form-data">
    <input class="input" type="file" name="file"> <a class="input_btn" onclick="sendform();">Загрузить</a><br>
    <a href="upload.php" class="grey">Большие файлы</a>
    </form>
    <?php
      }
    ?>
    <br>
    <input onclick="newfolder()" type="button" value="Создать папку" class="input_btn">
    </div>
    <div class="func"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script> 
    <script>
        
        class Files{
            constructor(id, name, way, type, servername, x, y){
                this.id = id;
                this.name = name;
                this.way = way;
                this.type = type;
                this.servername = servername;
                this.x = x;
                this.y = y;
            }
        }
        var mX = 0;
        var mY = 0;
        var taked = -1;
        var ggx = 0;
        var ggy = 0;
        var mouse = 0;
        var files = [];
        var counter = 0;
function sendform(){
            $("#form").ajaxForm({
              
            }).submit();
            $(".form_right").html("");
           alert("Файл появится, как только загрузится");
           $(".form_right").html('<form action="upload.php" id="form" method="POST" enctype="multipart/form-data"><input class="input" type="file" name="file"> <a class="input_btn" onclick="sendform();">Загрузить</a><br><a class="grey">Большие файлы могут загружаться долго</a></form>');
           update_files();
           
            
        }

        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
       
        var img_file = new Image();
        img_file.src = 'img/file.png';

        var img_archive = new Image();
        img_archive.src = 'img/archive.png';

        var img_folder = new Image();
        img_folder.src = 'img/folder.png';

        var lmX = 0;
        var lmY = 0;
        var mnn = 0;
        function update_files(){
            counter = 0;
        $.ajax({
      method: "GET",
      url: "getfiles.php",
      dataType: "text",
      data: {way: <?php echo $page; ?>},
      success: function(data){  
        var ob = data.split(":");
        ob.pop();
        //console.log(ob);
        //console.log(ob.length);
        for(var i = 0; i < ob.length; i++){
            var all = ob[i].split(",");
           
                files[counter] = new Files(all[0], all[1], all[2], all[3], all[4], all[5], all[6]);
                
            counter++;
              
        }
	}
});
setTimeout(update_files, 20000);
        }
        update_files();
        var wd = (window.innerWidth - 2) / 1920;
        var lastw = 0;
        function window_loop(){
            wd = (window.innerWidth - 2) / 1920;
        canvas.width = window.innerWidth - 2;
        canvas.height = 950 * wd; 
        lastw = canvas.width;
        }
        

        function files_loop(){
            if(lastw != window.innerWidth - 2){
                window_loop();
            }
            ctx.clearRect(0, 0, window.innerWidth - 2, 950 * wd);
            for(var i = 0; i < counter; i++){
                ctx.fillText(files[i].name,files[i].x * wd, files[i].y * wd + 120 * wd);
               var tpp = files[i].type;
               var tppc = tpp.split("/");
               if(tppc[0] == "image"){
                var ff = new Image();
                ff.src = 'files/' + files[i].servername;
                ctx.drawImage(ff, files[i].x * wd, files[i].y * wd, 100 * wd, 100 * wd);
               }else if(tppc[0] == "application"){
                ctx.drawImage(img_archive, files[i].x * wd, files[i].y * wd, 100 * wd, 100 * wd);
               }else if(tppc[0] == "folder"){
                ctx.drawImage(img_folder, files[i].x * wd, files[i].y * wd, 100 * wd, 100 * wd);
               }else
                ctx.drawImage(img_file, files[i].x * wd, files[i].y * wd, 100 * wd, 100 * wd);
                
            }
           if(mouse){
               if(taked > -1){
                files[taked].x = (mX - ggx) / wd;
                files[taked].y = (mY - ggy) / wd;
               }
           }
        setTimeout(files_loop, 20);
        }
        files_loop();

        canvas.addEventListener("mousedown", function() {
            mnn = 0;
            var ltaked = taked;
            mouse = 1;
            var ser = 0;
            for(var i = 0; i < counter; i++){
                if(files[i].x * wd < mX && files[i].y * wd < mY && files[i].x * wd + 100 * wd > mX && files[i].y * wd + 100 * wd > mY){
                    taked = i;
                    ggx = mX - files[i].x * wd;
                    ggy = mY - files[i].y * wd;
                    ser++;
                    break;
                }
            }
            if(ser == 0){
                taked = -1;
            }
            if(taked != -1){
                var funcc = "<h2>Опции</h2>" + files[taked].name + "<br><br>";
                var tpp = files[taked].type;
               var tppc = tpp.split("/");
               if(tppc[0] == "image" || tppc[0] == "text"){
                funcc += '<input type="button" onclick="opn()" value="Открыть" class="input_btn" style="width: 100%;"><br><br>';
               }
               if(tppc[0] == "folder"){
                funcc += '<input type="button" onclick="opn_folder()" value="Открыть папку" class="input_btn" style="width: 100%;"><br><br>';
                funcc += '<input type="button" onclick="delete_folder()" value="Удалить папку" class="input_btn" style="width: 100%; background-color: rgb(255, 150, 150); color: Black;"><br><br>';
               }else{
                funcc += '<input type="button" onclick="download_file()" value="Скачать" class="input_btn" style="width: 100%; background-color: rgb(200, 200, 200); color: Black;"><br><br>';
                funcc += '<input type="button" onclick="delete_file()" value="Удалить" class="input_btn" style="width: 100%; background-color: rgb(255, 150, 150); color: Black;"><br><br>';
               }
               <?php 
                    if($page != 0){
?>
            funcc += '<input type="button" onclick="file_down()" value="Извлечь из папки" class="input_btn" style="width: 100%;"><br><br>';
<?php
                    }

               ?>
               
               
               $(".func").html(funcc);
               if(ltaked == taked){
                lmX = mX;
                lmY = mY;
                mnn = 1;
            }
            }else{
                $(".func").html("");
            }
            
  });
  canvas.addEventListener("mouseup", function() {
            mouse = 0;
            if(taked != -1){
                if(files[taked].type == "folder/folder"){
                    $.ajax({
      method: "GET",
      url: "cords_folder.php",
      dataType: "text",
      data: {id: files[taked].id, x: files[taked].x, y: files[taked].y, way: <?php echo $page; ?>},
      success: function(data){  
	}
});
                }else{
                $.ajax({
      method: "GET",
      url: "cords.php",
      dataType: "text",
      data: {id: files[taked].id, x: files[taked].x, y: files[taked].y, way: <?php echo $page; ?>},
      success: function(data){  
	}
});
                }
            }
            for(var i = 0; i < counter; i++){
                if(files[i].x * wd < mX && files[i].y * wd < mY && files[i].x * wd + 100 * wd > mX && files[i].y * wd + 100 * wd > mY){
                   if(files[i].type == "folder/folder"){
                    if(files[taked].type == "folder/folder"){
                   if(i == taked){
                        continue;
                   }
                        $.ajax({
      method: "GET",
      url: "tofolderfolder.php",
      dataType: "text",
      data: {id: files[taked].id, folder: files[i].id},
      success: function(data){  
        taked = -1;
          $(".func").html("");
        update_files();
        
	}
});
                    }else{
                        $.ajax({
      method: "GET",
      url: "tofolder.php",
      dataType: "text",
      data: {id: files[taked].id, folder: files[i].id},
      success: function(data){  
        taked = -1;
          $(".func").html("");
        update_files();
       
	}
});
                    }
                    break;
                   }
                   
                }
            }
            if(mnn){
                if(lmX == mX && lmY == mY){
                    var tpp = files[taked].type;
               var tppc = tpp.split("/");
               if(tppc[0] == "image" || tppc[0] == "text"){
                opn();
               }
               if(tppc[0] == "folder"){
                opn_folder();
               }
                }
                mnn = 0;
            }
  });
  document.querySelector('#canvas').onmousemove = function(event) {
    event = event || window.event; // кроссбраузерность
    
    mX = event.offsetX;
    mY = event.offsetY;
}

function opn(){
    window.open('http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/files/' + files[taked].servername, '_blank');
}

function opn_folder(){
    location.href = 'http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/cloud.php?way=' + files[taked].id;
}
function download_file(){
    window.open('http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/files/' + files[taked].servername, '_blank');

    var link = document.createElement('a');
    var tpp = files[taked].type;
               var tppc = tpp.split("/");
               if(tppc[0] == "image" || tppc[0] == "text"){
link.setAttribute('href', 'http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/files/' + files[taked].servername);
link.setAttribute('download', 'http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/files/' + files[taked].servername);
               }else{
                //link.setAttribute('href', 'http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/files/' + files[taked].servername);
	link.setAttribute('download', 'http://<?php echo $_SERVER['SERVER_NAME'] ?>/qq/files/' + files[taked].servername);
               }
	
	link.click();
}

function delete_file(){
    $.ajax({
      method: "GET",
      url: "delete.php",
      dataType: "text",
      data: {id: files[taked].id},
      success: function(data){  
          alert("Файл удалён");
          taked = -1;
          $(".func").html("");
          update_files();
	}
});
}

function delete_folder(){
    $.ajax({
      method: "GET",
      url: "delete_folder.php",
      dataType: "text",
      data: {id: files[taked].id},
      success: function(data){  
          alert("Папка удалена");
          taked = -1;
          $(".func").html("");
          update_files();
	}
});
}

function newfolder(){
    var fname = prompt("Название новой папки");
    if(fname == ""){
        fname = "Папка";
    }
    $.ajax({
      method: "GET",
      url: "newfolder.php",
      dataType: "text",
      data: {way: <?php echo $page; ?>, name: fname},
      success: function(data){  
          alert("Папака создана");
          taked = -1;
          $(".func").html("");
          update_files();
	}
});
}

function file_down(){
    if(files[taked].type == "folder/folder"){
        $.ajax({
      method: "GET",
      url: "filedownfolder.php",
      dataType: "text",
      data: {id: files[taked].id},
      success: function(data){  
        taked = -1;
          $(".func").html("");
        update_files();
       
	}
});
    }else{
        $.ajax({
      method: "GET",
      url: "filedown.php",
      dataType: "text",
      data: {id: files[taked].id},
      success: function(data){  
        taked = -1;
          $(".func").html("");
        update_files();
       
	}
});
    }
}
    </script>
</body>
</html>