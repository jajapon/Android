<div id="col-md-12" style="margin:0px">
	<div class="col-md-12" id="others_popular" style="padding:0px">
<?php 
	$query = "SELECT * FROM anime";

	if(isset($_GET["letter"])){
		if($_GET["letter"]!="todos"){
			$query .= " WHERE nombre LIKE '".$_GET["letter"]."%'";
		}
	}
	$query.= " ORDER BY nombre";

	include('conexion.php');
	$connection->query("SET NAMES 'utf8'");

	if($result = $connection->query($query)){
 		while($row = $result->fetch_object()){
  		?>
			<div class="col-md-3" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
			<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
			<div>
				<h1><?php echo $row->nombre ?></h1>
			</div>
		</div>
  		<?php
      	}
    }
?>
	</div>
</div>
