<?php 
	if(isset($_POST["animeid"])){
		include("./php/conexion.php");
		$query = "SELECT * FROM capitulo WHERE animeid = ".$_POST["animeid"]." AND temporada_id=".$_POST["season"];
		$connection->query("SET NAMES 'utf8'");
		
		if($result = $connection->query($query)){
			while($row = $result->fetch_object()){
?>
	<tr>
		<td><?php echo $row->ncapitulo ?></td>
		<td><?php echo $row->parte ?></td>
		<td>
			<?php 
				if(strlen($row->url) > 14){
                   echo '<a id="data_anime_cap" href="'.$row->url.'" target="_blank"  class="btn btn-danger btn-lg">
					    <span class="glyphicon glyphicon-facetime-video"></span><p>Ver capítulo</p> 
					 </a>';
                 }else{
                    echo '<a id="data_anime_cap" target="_blank" href="https://www.youtube.com/watch?v='.$row->url.'" class="btn btn-danger btn-lg">
					    <span class="glyphicon glyphicon-facetime-video"></span><p>Ver capítulo</p> 
					 </a>';
                 }
             
			 ?>
		</td>
	</tr>
<?php
			}
     	}else{
     		echo $query."<br>";
     		echo $connection->error;
     	}	
	}
?>