<?php 
	function getLastRowId($table, $connection){
		$query = "SELECT MAX(id) as id FROM ".$table;
		$result = $connection->query($query);
		if($result){
			while($row = $result->fetch_object()){
				return ($row->id + 1);
			}
		}
	}

	if($_POST['action']){
		include('conexion.php');
		$connection->query("SET NAMES 'utf8'");

		switch($_POST['action']){
			case 'add':
				$id = getLastRowId('favoritos',$connection);
				$query = 'INSERT INTO favoritos VALUES('.$id.','.$_POST['idanime'].','.$_POST['iduser'].');';
			break;
			case 'delete':
				$query = 'DELETE FROM favoritos WHERE id_usuario = '.$_POST['iduser'].' AND id_anime = '.$_POST['idanime'].';';
			break;
		}

		
		if($connection->query($query)){

		}else{
			echo $connection->error;
			echo $query;
		}
	}
?>