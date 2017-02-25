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
        <div style="margin:0 auto;width:60%">
          <form role="form" action="subida_multiple_caps.php" style="margin-top:10px;margin-left:10px" method="POST">
            <div class="row">
                <div class="col-sm-12 col-md-12" style="width:100%">
                  <div class="form-group">
                    <label for="animes">Anime:</label>
                    <select class="form-control" name="animes" id="animes" style="height:35px">
                      <option value="nada">Seleccione un anime</option>
                      <?php
                          include 'conexion.php';
                          $consulta = "SELECT * FROM anime ORDER BY titulo";
                          if ($result = $connection->query($consulta)){
                            if($result->num_rows==0){

                            }else{
                              while($fila = $result->fetch_object()){
                                 echo '<option value="'.$fila->animeid.'">'.$fila->titulo.' Temporada '. $fila->temporada.'</option>';
                              }
                            }
                          }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12">
                <div class="form-group">
                  <label for="datos">Enlaces:</label>
                  <textarea class="form-control" rows="10" name="datos" id="datos"></textarea>
                </div>
              </div>
              <div class="col-sm-12 col-md-3">
                <div class="form-group">
                  <input type="submit" value="Importar" class="btn btn-info btn-block" style="height:35px" style="height:30px">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>

<?php
    if(isset($_POST["datos"])){
      include 'conexion.php';
      $enlaces = nl2br($_POST['datos']);
      $enlaces = explode('<br />',$enlaces);
      $animes = $_POST['animes'];

      if($_POST['animes']=="nada"){

      }else{
        $consulta = "SELECT MAX(ncapitulo) AS ultimoCap FROM capitulo WHERE animeid=$animes;";
        if ($result = $connection->query($consulta)){
          if($result->num_rows==0){

          }else{
            while($fila = $result->fetch_object()){
              $cap = $fila->ultimoCap;
            }
            $cap = $cap + 1;
            foreach ($enlaces as &$valor) {
              $consulta = "INSERT INTO `capitulo`(`animeid`, `ncapitulo`, `parte`, `url`) VALUES ($animes,$cap,0,'$valor')";
              if ($connection->query($consulta)){
                 $cap = $cap + 1;
               }
            }
            header("Location: ./index.php");
          }
        }
      }
    }else{
      echo "No entra";
    }
 ?>
  </body>
</html>
