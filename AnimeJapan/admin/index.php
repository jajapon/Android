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
            <li><a href="index.php?logout=yes" id="logout" name="logout"> <span class="glyphicon glyphicon-off"></span>  Cerrar sesion</a></li>
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
      <div>
        <div style="float:left;width:45%">
          <form role="form" action="index.php" style="margin-top:10px;margin-left:10px" method="GET">
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <div class="form-group">
                  <input type="text" name="anime" style="height:35px"  id="anime" class="form-control input-sm" placeholder="Anime">
                </div>
              </div>
              <div class="col-sm-12 col-md-5">
                <div class="form-group">
                  <select class="form-control" name="idioma" id="idioma" style="height:35px">
                    <option value="nada">Seleccione un idioma</option>
                    <option value="ESP">Español</option>
                    <option value="LAT">Latino</option>
                    <option value="SUB">Sub Español</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3">
                <div class="form-group">
                  <input type="submit" value="Buscar" class="btn btn-info btn-block" style="height:35px" style="height:30px">
                </div>
              </div>
            </div>

          </form>
        </div>
        <div style="float:right">
          <a style="margin-right:10px;margin-top:10px;height:35px" href="index.php?descarga=ok" class="btn btn-info">Descarga APK Android</a>
          <a style="margin-top:10px;height:35px" href="subida_multiple_caps.php" class="btn btn-warning">Subida Multiple</a>
          <a style="margin-right:10px;margin-top:10px;height:35px" href="alta_anime.php" class="btn btn-success">Añadir</a>
        </div>
      </div>
    <table class="table .table-bordered" style="margin-top:20px;" >
       <tr>
        <th style="text-align:center;">Imagen</th>
        <th style="text-align:center;">Título</th>
        <th style="text-align:center;">Temporada</th>
        <th style="text-align:center;">Capitulos</th>
        <th style="text-align:center;">Idioma</th>
        <th style="text-align:center;">Operaciones</th>
      </tr>
      <?php
          include 'conexion.php';
          if(isset($_GET["anime"])){
            if($_GET["idioma"] == "nada"){
              $consulta = "SELECT * FROM anime WHERE titulo LIKE '%".$_GET["anime"]."%' AND animeid NOT IN(SELECT animeid FROM anime WHERE animeid =9999) ORDER BY titulo";
            }else{
              $consulta = "SELECT * FROM anime WHERE titulo LIKE '%".$_GET["anime"]."%' AND idioma = '".$_GET["idioma"]."' AND animeid NOT IN(SELECT animeid FROM anime WHERE animeid =9999) ORDER BY titulo";
            }
          }else{
            $consulta = "SELECT * FROM anime WHERE animeid NOT IN(SELECT animeid FROM anime WHERE animeid =9999) ORDER BY titulo";
          }
          if ($result = $connection->query($consulta)){
            if($result->num_rows==0){

            }else{
              while($fila = $result->fetch_object()){
                echo '<tr>
                 <th style="text-align:center;width:15%"><center><img src="'.$fila->imagen.'" style="width:35%"/></center></th>
                 <th style="text-align:center;width:15%">'.$fila->titulo.'</th>
                 <th style="text-align:center;width:10%">'.$fila->temporada.'</th>
                 <th style="text-align:center;width:10%">'.($fila->numcapitulos).'</th>';
                 if($fila->idioma=="ESP"){
                   echo '<th style="text-align:center;width:10%"><img src="../imagenes/es.jpg" alt="" /></th>';
                 }elseif($fila->idioma=="LAT"){
                   echo '<th style="text-align:center;width:10%"><img src="../imagenes/lat.png" alt="" /></th>';
                 }elseif($fila->idioma=="SUB"){
                   echo '<th style="text-align:center;width:10%"><img src="../imagenes/sub.png" alt="" /></th>';
                 }
                 echo '<th style="text-align:center;">
                    <a style="margin-left:5px;" href="modificar_anime.php?animeid='.$fila->animeid.'&tit='.$fila->titulo.'&tem='.$fila->temporada.'&ncap='.$fila->numcapitulos.'&idioma='.$fila->idioma.'&des='.$fila->descripcion.'" class="btn btn-warning">Modificar</a>
                    <a style="margin-left:5px;" href="index.php?animeBorrar='.$fila->animeid.'" class="btn btn-danger">Borrar</a>
                    <a style="margin-left:5px;" href="capitulos_anime.php?animeid='.$fila->animeid.'&tit='.$fila->titulo.'&ncaps='.$fila->numcapitulos.'" class="btn btn-info">Ver lista capitulos</a>
                </th>
               </tr>';
              }
            }
          }else{
            echo $connection->error();
          }
       ?>

      <?php
          if(isset($_GET["animeBorrar"])){
            include 'conexion.php';
            $consultaCaps = 'DELETE FROM capitulo WHERE animeid = '.$_GET["animeBorrar"].'';
            $consultaAnime = 'DELETE FROM anime WHERE animeid = '.$_GET["animeBorrar"].'';
            if($connection->query($consultaCaps)){
              if($connection->query($consultaAnime)){
                header('Location: index.php');
              }else{
                echo $connection->error();
              }
            }else{
              echo $connection->error();
            }
          }
       ?>

       <?php
          if(isset($_GET["descarga"])){
            $fichero = 'animejapan.apk';
                if (file_exists($fichero)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fichero));
                readfile($fichero);
                exit;
            }
          }
        ?>
    </table>
  </div>
</div>
  </body>
</html>
