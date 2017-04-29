<?php 
	include('../php/conexion.php');
	include('../php/admin_functions.php');

	$opcion = $_POST["opcion"];
	switch ($opcion) {
		case '1':
			$opciones = "<option value='0'>---- Selecciona Temporada ----</option>";
			if($_POST["animeid"] != 0 || $_POST["animeid"] != '0'){
				$connection->query("SET NAMES 'utf8'");   
				$query = "SELECT * FROM temporada WHERE id_anime = ".$_POST["animeid"]." ORDER BY num_temporada";
				if($result = $connection->query($query)){
					while($row = $result->fetch_object()){
						$opciones .= "<option value='".$row->id."'>Temporada ".$row->num_temporada."</option>";
					}
				}
			}
			echo $opciones;
		break;
		case '2':
			if(($_POST["animeid"] != 0 || $_POST["animeid"] != '0') && ($_POST["temporadaid"] != 0 || $_POST["temporadaid"] != '0')){
				$connection->query("SET NAMES 'utf8'");   
				$query = "SELECT * FROM capitulo WHERE animeid = ".$_POST["animeid"]." AND temporada_id = ".$_POST["temporadaid"]." ORDER BY ncapitulo";
				if($result = $connection->query($query)){
					while($row = $result->fetch_object()){
						echo '<tr>
								<td style="width:80%">Capitulo '.$row->ncapitulo.'</td>
								<td><button type="button" onclick="EditCapAnime('.$_POST["animeid"].','.$_POST["temporadaid"].','.$row->ncapitulo.','.$row->parte.')" class="btn btn-warning"><i class="fa fa-edit"></i> <span>Editar</span></button></td>
								<td><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i><span>Eliminar</span></button></td>
							</tr>';			
					}
				}
			}
		break;
		case '3':
			$connection->query("SET NAMES 'utf8'");   
			$query = "SELECT * FROM capitulo WHERE animeid = ".$_POST["animeid"]." AND temporada_id = ".$_POST["temporadaid"]." AND ncapitulo = ".$_POST["capitulo"]." AND parte =".$_POST["parte"].";";
			if($result = $connection->query($query)){
				while($row = $result->fetch_object()){
					echo '<div class="input-group" style="margin-bottom:20px">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            <textarea class="form-control" id="enlace_cap" style="height:70px" ;resize: none; name="descripcion" placeholder="Enlace" required="">'.$row->url.'</textarea>
                         </div>
                         <div class="input-group" style="margin-bottom:20px">
	                         <div class="col-md-12">
	                            <button type="submit" onclick="doEdit('.$_POST["animeid"].','.$_POST["temporadaid"].','.$_POST["capitulo"].','.$_POST["parte"].')" class="btn btn-warning pull-right">Modificar Capitulo <span class="fa fa-edit"></span></button>
	                        </div>
                        </div>
                        <div class="input-group" style="margin-bottom:20px">
	                         <div class="col-md-12" id="alert">
	                        </div>
                        </div>';			
				}
			}
		break;
		case '4':
			$connection->query("SET NAMES 'utf8'");   
			$query = "SELECT * FROM capitulo WHERE animeid = ".$_POST["animeid"]." AND temporada_id = ".$_POST["temporadaid"]." AND ncapitulo = ".$_POST["capitulo"]." AND parte =".$_POST["parte"].";";
			if($result = $connection->query($query)){
				while($row = $result->fetch_object()){
					$queryUpdate = "UPDATE capitulo SET url = '".$_POST["url"]."' WHERE animeid = ".$_POST["animeid"]." AND temporada_id = ".$_POST["temporadaid"]." AND ncapitulo = ".$_POST["capitulo"]." AND parte =".$_POST["parte"].";";
					if($result2 = $connection->query($queryUpdate)){
						echo '<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  	<strong>Exito!</strong> capitulo modificado con exito.
						</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  	<strong>Error!</strong> No se pudo modificar el capitulo.
						</div>';
					}			
				}
			}else{
				echo '<div class="alert alert-danger alert-dismissable">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  	<strong>Error!</strong> No se pudo encontrar el capitulo para modificarlo.
					</div>';
			}
		break;
	}
?>