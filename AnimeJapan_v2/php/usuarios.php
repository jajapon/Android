<?php 
	if(isset($_POST['action'])){
		include('conexion.php');
		$connection->query("SET NAMES 'utf8'");

		function getLastRowId($table, $connection){
			$query = "SELECT MAX(id) as id FROM ".$table;
			$result = $connection->query($query);
			if($result){
				while($row = $result->fetch_object()){
					return ($row->id + 1);
				}
			}
		}

		switch($_POST['action']){
			case 'add':
				//Comprobar si existe el usuario
				$query = 'SELECT * FROM usuario WHERE username = "'.$_POST['username'].'";';
				$result = $connection->query($query);

				if($result){
					if($result->num_rows == 0){
						$id = getLastRowId('usuario',$connection);
						$query = 'INSERT INTO usuario VALUES('.$id.',"'.$_POST['username'].'","'.md5($_POST['userpass']).'",1,"'.$_POST['nombre'].'","'.$_POST['apellidos'].'","");';
						if($connection->query($query)){
							echo '<div class="alert alert-success alert-dismissable">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  	<strong>Exito!</strong> usuario dado da alta.
							</div>';
						}
					}else{
						echo '<div class="alert alert-danger alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  	<strong>Error!</strong> Ya existe un usuario con ese nombre.
						</div>';
					}
				}
			break;
		}
	}
?>