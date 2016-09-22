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
            <li><a href="modificar_cap.php?logout=yes" id="logout" name="logout"> <span class="glyphicon glyphicon-off"></span>  Cerrar sesion</a></li>
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
              <a class="navbar-brand" href="#" style="width:20%"> <img src="ic_launcher.png" style="width:30px;display:inline;margin-top:-30px"/></a>
			    		<h3 class="panel-title" style="display:inline;margin-left:20px;font-weight:bold;font-size:13px">MODIFICAR CAPITULO<small></h3>
			 			</div>
			 			<div class="panel-body">
			    		<form role="form" action="modificar_cap.php" method="POST">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-12">
			    					<div class="form-group">
                      <?php
                          if(isset($_GET["animeid"])){
                          echo '<input type="hidden" name="aniid" id="aniid" value="'.$_GET["animeid"].'" class="form-control input-sm" placeholder="Anime" required>
                          <input type="hidden" name="tit" id="tit" value="'.$_GET["tit"].'" class="form-control input-sm" placeholder="Anime" required>
                          <input type="hidden" name="ncaps" id="ncaps" value="'.$_GET["ncaps"].'" class="form-control input-sm" placeholder="Anime" required>
                          <input type="hidden" start="0" name="ncapi" id="ncapi" value="'.$_GET["capi"].'"  min="0" max="9999" class="form-control input-sm" placeholder="Parte del Video" required>
                          <input type="hidden" start="0" name="parte" id="parte" min="0" value="'.$_GET["parte"].'" max="9999" class="form-control input-sm" placeholder="Parte del Video" required>';
                        }
                       ?>
			    					</div>
			    				</div>
			    			</div>

                <div class="form-group">
			    				<input type="text" name="enlace" id="enlace" class="form-control input-sm" placeholder="Url video" required>
			    			</div>
                <?php
                if(isset($_GET["animeid"])){
                echo '<a style="display:inline:float:left;" href="capitulos_anime.php?animeid='.$_GET["animeid"].'&ncaps='.$_GET["ncaps"].'&tit='.$_GET["tit"].'" class="btn btn-success">Volver atras</a>';
              }
                 ?>
			    			<input type="submit" value="Modificar capitulo" class="btn btn-info" style="display:inline:float:right;height:32px;">

			    		</form>

              <?php
                  if(isset($_POST["aniid"])){
                     include 'conexion.php';
                     $animeid = $_POST["aniid"];
                     $ncaps = $_POST["ncaps"];
                     $tit = $_POST["tit"];
                     $ncapi = $_POST["ncapi"];
                     $enlace = $_POST["enlace"];
                     $parte = $_POST["parte"];


                              $consulta = "UPDATE capitulo SET url = '$enlace' WHERE animeid = $animeid AND ncapitulo = $ncapi AND parte = $parte;";
                              if($connection->query($consulta)){

                                header('Location: modificar_cap.php?animeid='.$animeid.'&ncaps='.$ncaps.'&tit='.$tit.'&parte='.$parte.'&capi='.$ncapi.'&msg=exito');
                              }else{
                                var_dump($consulta);
                                echo $connection->error;
                                echo $connection->errno;
                              }


                  }
                  if(isset($_GET["msg"])){
                    if($_GET["msg"]=="exito"){
                      echo "<div style='position:relative;width:100%;top:15px;margin:0 auto;color:white;background-color:#04B45F;margin-bottom:10px;border-radius:2px;padding:10px'>El capitulo fue modificado</div>";
                    }else{
                      echo "<div style='position:relative;width:100%;top:15px;margin:0 auto;color:white;background-color:#FA5858;margin-bottom:10px;border-radius:2px;padding:10px'>El capitulo para esa temporada y anime ya existe</div>";
                    }
                  }
               ?>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>
  </body>
</html>
