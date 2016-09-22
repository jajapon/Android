<!DOCTYPE html>
<?php
    ob_start();
?>
<?php
    session_start();
    if(!empty($_SESSION["usuario"])){
    }else{
      header('location: ../index.php');
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
          <ul class="nav navbar-right" id="bs-example-navbar-collapse-1" style="margin-top:3px">
            <li><a href="capitulos_anime.php?logout=yes" id="logout" name="logout"> <span class="glyphicon glyphicon-off"></span>  Cerrar sesion</a></li>
          </ul>
            <?php
                     if (isset($_GET["logout"])) {
                          session_destroy();
                          header("Location: ../index.php");
                     }else{
                     }
            ?>
         </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->


    </nav>
    <div class="container fondo" >
    <div class="table-responsive" style="margin-top:80px;background-color:white;opacity:0.9;">
      <div style="background-color:#143393;font-size:18px;width:100%;height:40px;text-align:center;padding-top:10px;padding-bottom:10px;color:white;font-weight:bold"><?php echo $_GET["tit"]; ?></div>
      <?php
      echo '<center>
        <a style="margin-top:20px" href="alta_cap.php?animeid='.$_GET["animeid"].'&ncaps='.$_GET["ncaps"].'&tit='.$_GET["tit"].'" class="btn btn-success">Añadir capitulo</a>
      </center>';
       ?>
    <table class="table .table-bordered" style="margin-top:20px;" >
       <tr>
        <th style="text-align:center;">Capitulo</th>
        <th style="text-align:center;">Parte</th>
        <th style="text-align:center;">Enlace</th>
        <th style="text-align:center;">Operaciones</th>
      </tr>
      <?php
          include 'conexion.php';
          $consulta = "SELECT * FROM capitulo where animeid = ".$_GET['animeid'].";";
          if ($result = $connection->query($consulta)){
            if($result->num_rows==0){

            }else{
              while($fila = $result->fetch_object()){
                echo '<tr>
                 <td style="text-align:center">'.$fila->ncapitulo.'</td>
                 <td style="text-align:center">'.$fila->parte.'</td>';

                 if(strlen($fila->url) > 14){
                   echo '<td style="text-align:center;width:70%"><a href="'.$fila->url.'">'.$fila->url.'</a></td>';
                 }else{
                   echo '<td style="text-align:center;width:70%"><a href="https://www.youtube.com/watch?v='.$fila->url.'">https://www.youtube.com/watch?v='.$fila->url.'</a></td>';
                 }
                 echo '<td style="text-align:center;width:20%">
                    <a style="margin-left:5px;" href="modificar_cap.php?animeid='.$_GET["animeid"].'&ncaps='.$_GET["ncaps"].'&tit='.$_GET["tit"].'&capi='.$fila->ncapitulo.'&parte='.$fila->parte.'" class="btn btn-warning">Modificar</a>
                    <a style="margin-left:5px;" href="capitulos_anime.php?animeid='.$_GET["animeid"].'&ncaps='.$_GET["ncaps"].'&tit='.$_GET["tit"].'&capi='.$fila->ncapitulo.'&parte='.$fila->parte.'" class="btn btn-danger">Borrar</a>
                </td>
               </tr>';
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
