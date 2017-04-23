<?php 
	include('../php/conexion.php');
	include('../php/admin_functions.php');

	$opcion = $_POST["opcion"];
	switch ($opcion) {
		case '1':
			$opciones = "<option value='0'>---- Selecciona anime ----</option>";
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
	}
?>