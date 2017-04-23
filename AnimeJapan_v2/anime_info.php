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

			$urlvideo = "";
 			if(strlen($row->url) > 14){
               $urlvideo = $row->url;
             }else{
               $urlvideo = "https://www.youtube.com/watch?v=".$row->url;
             }
             $tipovideo = "";
             if(preg_match('/youtube.com/',$urlvideo)){
             	$tipovideo = "youtube";
             }
             if(preg_match('/'.'vk.com'.'/',$urlvideo)){
             	if(preg_match('/'.'video_ext'.'/',$urlvideo)){
             		$tipovideo = "vk";
             	}
             }if(preg_match('/'.'rutube'.'/',$urlvideo)){
             	$tipovideo = "rutube";
             }
             if(preg_match('/'.'googlevideo.com'.'/',$urlvideo)){
             	$tipovideo = "animeflv";
             }
            if($tipovideo!=""){
	            echo '<button id="data_anime_cap" onclick="loadAnimeVideoCap(\'ver_capitulo\','.$row->ncapitulo.','.$row->parte.','.$_POST["animeid"].','.$_POST["season"].')" class="btn btn-danger btn-lg">
				    <span class="glyphicon glyphicon-facetime-video"></span><p>Ver capítulo</p> 
				 </button>';
            }else{
	            echo '<a id="data_anime_cap" target="_blank" href="'.$urlvideo.'" class="btn btn-danger btn-lg">
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