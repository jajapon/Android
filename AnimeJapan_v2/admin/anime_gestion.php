<?php 
	include('../php/conexion.php');
	include('../php/admin_functions.php');
?>
<!DOCTYPE html>
<html lang="es">
 
<head>
	<title>Titulo de la web</title>
	<meta charset="utf-8" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
    <link rel="stylesheet" href="../css/global.css">
	<link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <script src="../js/admin.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

</head>
 
<body>
	<div id="container" style="padding:10px">
		<div class="col-md-3" style="padding:15px;border-radius:4px">
			<h1 style="margin:0px;padding:5px 10px;background-color:#086A87;color:#FFFFFF;text-align:center;font-family:bigNoodleTitling;font-size:24px;border-top-left-radius:4px;border-top-right-radius:4px">Alta de anime</h1>
			<form class="form-horizontal" action="anime_gestion.php"  method="POST" id="contact_form" enctype="multipart/form-data">
                <fieldset style="border:solid lightgray 1px;padding:15px;margin-bottom:15px">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="nombre" placeholder="Nombre" class="form-control" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<select class="form-control" name="genero" required>
								  	<option value="">----- Selecciona Genero -----</option>
								  	<option value="accion">Accion</option>
								  	<option value="aventuras">Aventuras</option>
								  	<option value="comedia">Comedia</option>								  	
								  	<option value="deportes">Deportes</option>								  	
								  	<option value="romance">Romance</option>								  	
								</select>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<select class="form-control" name="idioma" required>
								  	<option value="">----- Selecciona idioma -----</option>
								  	<option value="ESP">Español</option>
								  	<option value="LAT">Latino</option>
								  	<option value="JAP">Sub Español</option>			  	
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
	                		<div class="input-group">
				                <label class="input-group-btn">
				                    <span class="btn btn-primary">
				                        Imagen <input type="file" name="file" id="file" style="display: none;" multiple>
				                    </span>
				                </label>
				                <input type="text" class="form-control" style="background-color: #FFFFFF;" readonly required>
				            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                <textarea class="form-control" style="height:100px" name="descripcion" placeholder="Descripción" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-warning pull-right">Dar de alta <span class="glyphicon glyphicon-send"></span></button>
                        </div>
                    </div>
                </fieldset>
            </form>
		</div>
		<?php 
			if(isset($_POST["nombre"])){
				$nombre = $_POST["nombre"];
				$genero = $_POST["genero"];
				$descripcion = $_POST["descripcion"];
				$idioma = $_POST["idioma"];
				$imagen = $_FILES["file"];
				$fecha = new DateTime();
				$fecha = $fecha->format('Y-m-d H:i:s');
				$visitas = 0;

				$connection->query("SET NAMES 'utf8'");   
				$query = "SELECT * FROM anime WHERE nombre = '".$nombre."'";
				if($result = $connection->query($query)){
			 		if($result->num_rows == 0){
			 			$id = getLastRowId('anime',$connection);
			 			$queryInsert = "INSERT INTO anime VALUES (".$id.",'".$nombre."','".$genero."','".$descripcion."','".$imagen["name"]."','".$fecha."','".$idioma."',".$visitas.")";
			 			if($result = $connection->query($queryInsert)){
			 				uploadFile($imagen);
			 			}
			 		}else{
			 			//existe ya uno;
			 		}
			 	}
			}
		?>
		<div class="col-md-3" style="padding:15px;border-radius:4px">
			<h1 style="margin:0px;padding:5px 10px;background-color:#086A87;color:#FFFFFF;text-align:center;font-family:bigNoodleTitling;font-size:24px;border-top-left-radius:4px;border-top-right-radius:4px">Alta de Temporada</h1>
            <form class="form-horizontal" action="anime_gestion.php" method="POST" id="contact_form" enctype="multipart/form-data">
                <fieldset style="border:solid lightgray 1px;padding:15px" >
              		<div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<select class="form-control" name="t_anime" required>
								<option value="0">---- Selecciona anime ----</option>

								<?php 
									$connection->query("SET NAMES 'utf8'");   
									$query = "SELECT * FROM anime ORDER BY nombre";
									if($result = $connection->query($query)){
										while($row = $result->fetch_object()){

								?>
								<option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>		
								<?php 
										}
									}
								?>					  	
								</select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                           <div class="form-group">
		                        <div class="col-md-12">
		                            <div class="input-group">
		                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		                                <input name="t_num_temporada" min="1" placeholder="Número de temporada" class="form-control" type="number" required>
		                            </div>
		                        </div>
		                    </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                           <div class="form-group">
		                        <div class="col-md-12">
		                            <div class="input-group">
		                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		                                <input name="t_nombre_ext" placeholder="Nombre extendido" class="form-control" type="text" >
		                            </div>
		                        </div>
		                    </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-warning pull-right">Dar de alta <span class="glyphicon glyphicon-send"></span></button>
                        </div>
                    </div>
                </fieldset>
            </form>
		</div>
		<?php  
			if(isset($_POST["t_anime"])){
				$idanime = $_POST["t_anime"];
				$num_temporada = $_POST["t_num_temporada"];
				$nombre_ext = $_POST["t_nombre_ext"];

				if($idanime != 0 || $idanime != "0"){
					$connection->query("SET NAMES 'utf8'");   
					$query = "SELECT * FROM temporada WHERE id_anime = '".$idanime."' AND num_temporada = ".$num_temporada;
					if($result = $connection->query($query)){
				 		if($result->num_rows == 0){
				 			$id = getLastRowId('temporada',$connection);
				 			$queryInsert = "INSERT INTO temporada VALUES (".$id.",".$idanime.",".$num_temporada.",'','".$nombre_ext."');";
				 			if($result = $connection->query($queryInsert)){
				 				echo "correcto";
				 			}
				 		}else{
				 			//existe ya uno;
				 		}
				 	}
				}
			}
		?>
		<div class="col-md-4" style="padding:15px;border-radius:4px">
			<h1 style="margin:0px;padding:5px 10px;background-color:#086A87;color:#FFFFFF;text-align:center;font-family:bigNoodleTitling;font-size:24px;border-top-left-radius:4px;border-top-right-radius:4px">Subida multiple capitulos</h1>
			<form class="form-horizontal" action="anime_gestion.php" method="POST" id="contact_form" enctype="multipart/form-data">
                <fieldset style="border:solid lightgray 1px;padding:15px" >
					<div class="form-group">
		                <div class="col-md-12">
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<select class="form-control" name="c_anime" id="c_anime" onchange="loadAnimeTemps()" required>
								<option value="0">---- Selecciona anime ----</option>

								<?php 
									$connection->query("SET NAMES 'utf8'");   
									$query = "SELECT * FROM anime ORDER BY nombre";
									if($result = $connection->query($query)){
										while($row = $result->fetch_object()){

								?>
								<option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>		
								<?php 
										}
									}
								?>					  	
								</select>
		                    </div>
		                </div>
		            </div>
		            <div class="form-group">
		                <div class="col-md-12">
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<select class="form-control" name="c_temps" id="c_temps" required>
								<option value="0">---- Selecciona temporada ----</option>
			  	
								</select>
		                    </div>
		                </div>
		            </div>
                    <div class="form-group">
                        <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                <textarea class="form-control" style="height:200px" name="c_links" placeholder="Enlaces de capitulos" required></textarea>
                            </div>
                        </div>
                    </div>
		            <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-warning pull-right">Dar de alta <span class="glyphicon glyphicon-send"></span></button>
                        </div>
                    </div>
		        </fieldset>
		    </form>
		</div>
		<?php  
			if(isset($_POST["c_anime"])){
				$idanime = $_POST["c_anime"];
				$idtemporada = $_POST["c_temps"];
				$enlaces = nl2br($_POST['c_links']);
      			$enlaces = explode('<br />',$enlaces);

				if(($idanime != 0 || $idanime != "0") && ($idtemporada != 0 || $idtemporada != "0") && $enlaces != ""){
					$connection->query("SET NAMES 'utf8'");   
					$query = "SELECT MAX(ncapitulo) AS ultimoCap FROM capitulo WHERE animeid=".$idanime." AND temporada_id = ".$idtemporada.";";
					if($result = $connection->query($query)){
				 		if($result->num_rows == 0){

				 		}else{
				 			$cap = 0;
				 			while($fila = $result->fetch_object()){
				              $cap = $fila->ultimoCap;
				            }
				            $cap = $cap + 1;
				            foreach ($enlaces as $urlcap) {
				            	$urlcap = ltrim(rtrim($urlcap));
				            	$queryInsert = "INSERT INTO `capitulo`(`animeid`, `temporada_id`, `ncapitulo`, `parte`, `url`) VALUES (".$idanime.",".$idtemporada.",".$cap.",0,'".$urlcap."')";
				            	if($result = $connection->query($queryInsert)){
				               		$cap = $cap + 1;
					 			}else{
					 				echo $connection->error;
					 			}
				            }
				 			
				 		}
				 	}
				 }
			}
		?>
	</div>

	<script type="text/javascript">
		$(function() {
			$(document).on('change', ':file', function() {
			    var input = $(this),
		        numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			    input.trigger('fileselect', [numFiles, label]);
			});

			$(document).ready( function() {
			      $(':file').on('fileselect', function(event, numFiles, label) {

			          var input = $(this).parents('.input-group').find(':text'),
			              log = numFiles > 1 ? numFiles + ' files selected' : label;

			          if( input.length ) {
			              input.val(log);
			          } else {
			              if( log ) alert(log);
			          }

			      });
			  });
		  
		});
	</script>
</body>
</html>