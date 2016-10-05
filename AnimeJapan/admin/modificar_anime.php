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
        }
        .centered-form{
          margin-top: 140px;
        }

        .centered-form .panel{
          background: rgba(255, 255, 255, 0.8);
          box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
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
            <li><a href="modificar_anime.php?logout=yes" id="logout" name="logout"> <span class="glyphicon glyphicon-off"></span>  Cerrar sesion</a></li>
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
    <div class="container">
        <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
              <img src="https://lh3.googleusercontent.com/-3K9g7x_fzu8/AAAAAAAAAAI/AAAAAAAAAAo/dZHUQLK_YeM/s36-p-k-rw-no/photo.jpg" style="display:inline"/>
			    		<h3 class="panel-title" style="display:inline;margin-left:20px;font-weight:bold;font-size:13px">MODIFICACIÓN DE ANIME<small></h3>
			 			</div>
			 			<div class="panel-body">
			    		<form role="form" action="modificar_anime.php" method="POST">
                <?php
                      include 'conexion.php';
                      if(isset($_GET["animeid"])){
                        $animeid = $_GET["animeid"];
                        $tit = $_GET["tit"];
                        $tem = $_GET["tem"];
                        $ncap = $_GET["ncap"];
                        $des = $_GET["des"];
                        $idi = $_GET["idioma"];

                        echo '
                        <div class="row">
        			    				<div class="col-xs-6 col-sm-6 col-md-6">
        			    					<div class="form-group">
                            <input type="hidden" name="animeid" id="animeid" class="form-control input-sm" placeholder="Anime" value="'.$animeid.'" required>
        			                <input type="text" name="anime" id="anime" class="form-control input-sm" placeholder="Anime" value="'.$tit.'" required>
        			    					</div>
        			    				</div>
        			    				<div class="col-xs-6 col-sm-6 col-md-6">
        			    					<div class="form-group">
        			    						<input type="number" name="temporada" id="temporada" value="'.$tem.'"  min="1" max="30" start="1" class="form-control input-sm" placeholder="Temporada" required>
        			    					</div>
        			    				</div>
        			    			</div>

                        <div class="form-group">
        			    				<input type="number" start="0" name="ncaps" id="ncaps" min="0" value="'.$ncap.'"  max="9999" class="form-control input-sm" placeholder="Número de capitulos" required>
        			    			</div>

                        <div class="form-group">
                        <select class="form-control" id="idioma" name="idioma">';
                            if($idi == "ESP"){
                                echo '<option value="ESP" selected>Español</option>
                                <option value="LAT">Latino</option>
                                <option value="SUB">Sub Español</option>';
                            }elseif($idi == "LAT"){
                                echo '<option value="ESP">Español</option>
                                <option value="LAT" selected>Latino</option>
                                <option value="SUB">Sub Español</option>';
                            }elseif($idi == "SUB"){
                                echo '<option value="ESP">Español</option>
                                <option value="LAT">Latino</option>
                                <option value="SUB" selected>Sub Español</option>';
                            }
                          echo '</select>
                        </div>

        			    			<div class="form-group">
                          <textarea class="form-control" rows="5" name="descripcion" id="descripcion"  placeholder="Descripción" required>'.$des.'</textarea>
        			    			</div>
                        ';
                      }
                 ?>


			    			<input type="submit" value="Modificar" class="btn btn-info btn-block">

			    		</form>
			    	</div>

            <?php
                if(isset($_POST["anime"])){
                   include 'conexion.php';
                   $anime = $_POST["anime"];
                   $temporada = $_POST["temporada"];
                   $ncaps = $_POST["ncaps"];
                   $descripcion = $_POST["descripcion"];
                   $animeid = $_POST["animeid"];
                   $idioma = $_POST["idioma"];


                            $consulta = "UPDATE anime SET titulo = '$anime', idioma = '$idioma', temporada =  $temporada, numcapitulos = $ncaps, descripcion = '$descripcion' WHERE animeid = $animeid;";
                            if($connection->query($consulta)){
                              echo "<div style='width:92%;margin:0 auto;color:white;background-color:#04B45F;margin-bottom:10px;border-radius:2px;padding:10px'>El anime fue modificado</div>";
                              header('Location: index.php');

                            }else{
                              echo $connection->error;
                            }

                }
             ?>
	    		</div>
    		</div>
    	</div>
    </div>
  </body>
</html>
