<!DOCTYPE html>
<?php
    ob_start();
?>
<?php
    session_start();
    if(!empty($_SESSION["usuario"])){
      header('location: admin/index.php');
    }else{
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <style>
        body{
          background-image:url(https://i.ytimg.com/vi/bQoXORzoQls/maxresdefault.jpg);
          background-repeat:   no-repeat;
          background-size: cover;
          background-attachment: fixed;

        }

    </style>
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="width:20%"> <img src="ic_launcher.png" style="width:30px;display:inline;margin-top:-5px"/></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Animes</a></li>
          </ul>
          <form id="signin" class="navbar-form navbar-right" role="form" method="post" >
                 <div class="input-group">
                     <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                     <input id="username" type="text" class="form-control" name="username" value="" placeholder="Email Address">
                 </div>

                 <div class="input-group">
                     <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                     <input id="userpass" type="password" class="form-control" name="userpass" value="" placeholder="Password">
                 </div>

                 <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <?php
                  if (isset($_POST["username"])) {
                     $rol ="";
                     include 'conexion.php';
                     $user = $_POST["username"];
                     $pass = $_POST["userpass"];

                     $consulta = "SELECT * FROM usuario WHERE username = '$user' AND userpass ='$pass'";
                     if ($result = $connection->query($consulta)) {
                        if ($result->num_rows==0) {
                          header("Location: index.php");
                          var_dump($result->num_rows);
                        } else {
                          $nombre = "";
                          while($obj=$result->fetch_object()){
                              $nombre=$obj->nombre;
                          }
                          $_SESSION["usuario"]=$user;
                          header("Location: admin/index.php");
                        }
                     } else {
                       var_dump( $connection->error());
                     }
                  }else{
                  }
             ?>
         </div><!-- /.navbar-collapse -->

      </div><!-- /.container-fluid -->


    </nav>
    <div class="container fondo" >
    <div class="table-responsive" style="margin-top:80px;background-color:white;opacity:0.9;">
      <div style="background-color:#143393;font-size:18px;width:100%;height:40px;text-align:center;padding-top:10px;padding-bottom:10px;color:white;font-weight:bold"><?php echo $_GET["tit"]; ?></div>
    <table class="table table-bordered" style="margin-top:20px;" >
       <tr>
        <th style="text-align:center;">Capitulo</th>
        <th style="text-align:center;">Parte</th>
        <th style="text-align:center;">Enlace</th>
      </tr>
      <?php
          include 'conexion.php';
          $consulta = "SELECT * FROM capitulo where animeid = ".$_GET['animeid'].";";
          if ($result = $connection->query($consulta)){
            if($result->num_rows==0){

            }else{
              while($fila = $result->fetch_object()){
                echo '<tr style="height:50px">
                 <td style="width:50px;text-align:center">'.$fila->ncapitulo.'</td>
                 <td style="width:50px;text-align:center">'.$fila->parte.'</td>';

                 if(strlen($fila->url) > 14){
                   if(strlen($fila->url) > 160){
                     echo '<td style="text-align:center;font-size:10px"><a style="width:400px" href="'.$fila->url.'">'.$fila->url.'</a></td>';
                   }else{
                     echo '<td style="text-align:center;"><a style="width:400px" href="'.$fila->url.'">'.$fila->url.'</a></td>';
                   }
                 }else{
                   echo '<td style="text-align:center;"><a href="https://www.youtube.com/watch?v='.$fila->url.'">https://www.youtube.com/watch?v='.$fila->url.'</a></td>';
                 }
               echo '</tr>';
              }
            }
          }else{
            echo $connection->error();
          }
          echo '</table>';

       ?>

       <?php
            if(isset($_GET["capi"])){
              $animeid = $_GET["animeid"];
              $ncaps = $_GET["ncaps"];
              $tit = $_GET["tit"];
              $capi = $_GET["capi"];
              $parte = $_GET["parte"];

              include 'conexion.php';
              $consulta = "DELETE FROM capitulo WHERE animeid = $animeid AND ncapitulo = $capi AND parte = $parte;";
              if($connection->query($consulta)){
                header('location: capitulos_anime.php?animeid='.$animeid.'&ncaps='.$ncaps.'&tit='.$tit.'');
              }else{

              }
            }
        ?>
  </div>
</div>
  </body>
</html>
