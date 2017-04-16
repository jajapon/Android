<?php 
	if(isset($_GET["section"])){
		if($_GET["section"]=="genero"){
?>

	<div id="title_section" class="row">
		<h2>ÁNIMES POR GÉNERO</h2>
	</div>

	<div class="container" id="menu_content">
		<ul>
			<li id="todos" onclick="changeSectionGenero('genero','todos')" class="active_genero">Todos</li>
			<li id="accion" onclick="changeSectionGenero('genero','accion')">Acción</li>
			<li id="deportes" onclick="changeSectionGenero('genero','deportes')">Deportes</li>
			<li id="romance" onclick="changeSectionGenero('genero','romance')">Romance</li>
			<li id="aventura" onclick="changeSectionGenero('genero','aventura')">Aventura</li>
			<li id="aventura" onclick="changeSectionGenero('genero','comedia')">Comedia</li>
		</ul>
	</div>

	<div id="content_section" class="container" style="padding:0px">
		<div id="col-md-12" style="margin:0px">
			<div class="col-md-12" id="others_popular" style="padding:0px">
		<?php 
			$query = "SELECT * FROM anime";

			if(isset($_GET["type"])){
				if($_GET["type"]!="todos"){
					$query .= " WHERE genero LIKE '%".$_GET["type"]."%'";
				}
			}
			include('php/conexion.php');
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
	</div>

<?php
		}else if($_GET["section"]=="alfabetico"){
?>

	<div id="title_section" class="row">
		<h2>ÁNIMES ORDEN ALFABÉTICO</h2>
	</div>

	<div class="container" id="menu_content">
		<ul>
			<li id="todos" onclick="changeSectionLetter('alfabetico','todos')" class="active_genero">Todos</li>
			<li id="A" onclick="changeSectionLetter('alfabetico','A')" >A</li>
			<li id="B" onclick="changeSectionLetter('alfabetico','B')" >B</li>
			<li id="C" onclick="changeSectionLetter('alfabetico','C')" >C</li>
			<li id="D" onclick="changeSectionLetter('alfabetico','D')" >D</li>
			<li id="E" onclick="changeSectionLetter('alfabetico','E')" >E</li>
			<li id="F" onclick="changeSectionLetter('alfabetico','F')" >F</li>
			<li id="G" onclick="changeSectionLetter('alfabetico','G')" >G</li>
			<li id="H" onclick="changeSectionLetter('alfabetico','H')" >H</li>
			<li id="I" onclick="changeSectionLetter('alfabetico','I')" >I</li>
			<li id="J" onclick="changeSectionLetter('alfabetico','J')" >J</li>
			<li id="K" onclick="changeSectionLetter('alfabetico','K')" >K</li>
			<li id="L" onclick="changeSectionLetter('alfabetico','L')" >L</li>
			<li id="M" onclick="changeSectionLetter('alfabetico','M')" >M</li>
			<li id="N" onclick="changeSectionLetter('alfabetico','N')" >N</li>
			<li id="O" onclick="changeSectionLetter('alfabetico','O')" >O</li>
			<li id="P" onclick="changeSectionLetter('alfabetico','P')" >P</li>
			<li id="Q" onclick="changeSectionLetter('alfabetico','Q')" >Q</li>
			<li id="R" onclick="changeSectionLetter('alfabetico','R')" >R</li>
			<li id="S" onclick="changeSectionLetter('alfabetico','S')" >S</li>
			<li id="T" onclick="changeSectionLetter('alfabetico','T')" >T</li>
			<li id="U" onclick="changeSectionLetter('alfabetico','U')" >U</li>
			<li id="V" onclick="changeSectionLetter('alfabetico','V')" >V</li>
			<li id="W" onclick="changeSectionLetter('alfabetico','W')" >W</li>
			<li id="X" onclick="changeSectionLetter('alfabetico','X')" >X</li>
			<li id="Y" onclick="changeSectionLetter('alfabetico','Y')" >Y</li>
			<li id="Z" onclick="changeSectionLetter('alfabetico','Z')" >Z</li>
		</ul>
	</div>

	<div id="content_section" class="container" style="padding:0px">
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

			include('./php/conexion.php');
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
	</div>
<?php
		}else if($_GET["section"]=="ultimos"){
?>

	<div id="title_section" class="row">
		<h2>ÚLTIMOS ÁNIMES AGREGADOS</h2>
	</div>

	<div id="content_section_popular" class="container">
		<div id="col-md-12">
		<?php 
			include('php/conexion.php');
			$query = "SELECT * FROM anime ORDER BY fecha_alta DESC LIMIT 5";
			$connection->query("SET NAMES 'utf8'");
			$contador=0;
			if($result = $connection->query($query)){
	     		while($row = $result->fetch_object()){
	      			if($contador == 0){?>
		      			<div class="col-md-6" id="first_popular" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
							<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
							<div>
								<h1><?php echo $row->nombre ?></h1>
							</div>
						</div>
	      			<?php
	      			}else if($contador==1){?>
	      				<div class="col-md-6" id="others_popular">
							<div class="col-md-6" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
								<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
								<div>
									<h1><?php echo $row->nombre ?></h1>
								</div>
							</div>
	      			<?php
	      			}else if($contador==4){?>
				      		<div class="col-md-6" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
								<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
								<div>
									<h1><?php echo $row->nombre ?></h1>
								</div>
							</div>
						</div>
				    <?php
	      			}else{?>
	      				<div class="col-md-6" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
							<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
							<div>
								<h1><?php echo $row->nombre ?></h1>
							</div>
						</div>
	      			<?php
	      			}
	      			$contador = $contador + 1;
		      	}
		    }
		?>
		</div>

		<div id="subtitle_section" class="col-md-12">
			<h2>Otros ánimes agregados recientemente</h2>
		</div>

			<div id="col-md-12">
				<div class="col-md-12" id="others_popular">

		<?php 
			include('php/conexion.php');
			$query = "SELECT * FROM anime ORDER BY fecha_alta DESC";
			$connection->query("SET NAMES 'utf8'");
			$contador=0;
			if($result = $connection->query($query)){
	     		while($row = $result->fetch_object()){
	      			if($contador > 4){?>
		      			<div class="col-md-3" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
							<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
							<div>
								<h1><?php echo $row->nombre ?></h1>
							</div>
						</div>
	      			<?php
	      			}
	      			$contador = $contador + 1;
		      	}
		    }
		?>
				</div>
			</div>

		</div>
	</div>


<?php
		}else if($_GET["section"]=="populares"){
?>

	<div id="title_section" class="row">
		<h2>ÁNIMES POPULARES</h2>
	</div>

	<div id="content_section_popular" class="container">
		<div id="col-md-12">
		<?php 
			include('php/conexion.php');
			$query = "SELECT * FROM anime WHERE visitas > 0 ORDER BY visitas DESC LIMIT 5";
			$connection->query("SET NAMES 'utf8'");
			$contador=0;
			if($result = $connection->query($query)){
	     		while($row = $result->fetch_object()){
	      			if($contador == 0){?>
		      			<div class="col-md-6" id="first_popular" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
							<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
							<div>
								<h1><?php echo $row->nombre ?></h1>
							</div>
						</div>
	      			<?php
	      			}else if($contador==1){?>
	      				<div class="col-md-6" id="others_popular">
							<div class="col-md-6" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
								<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
								<div>
									<h1><?php echo $row->nombre ?></h1>
								</div>
							</div>
	      			<?php
	      			}else if($contador==4){?>
				      		<div class="col-md-6" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
								<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
								<div>
									<h1><?php echo $row->nombre ?></h1>
								</div>
							</div>
						</div>
				    <?php
	      			}else{?>
	      				<div class="col-md-6" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
							<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
							<div>
								<h1><?php echo $row->nombre ?></h1>
							</div>
						</div>
	      			<?php
	      			}
	      			$contador = $contador + 1;
		      	}
		    }
		?>
		</div>

		<div id="subtitle_section" class="col-md-12">
			<h2>Otros animes populares</h2>
		</div>

			<div id="col-md-12">
				<div class="col-md-12" id="others_popular">

		<?php 
			include('php/conexion.php');
			$query = "SELECT * FROM anime ORDER BY visitas DESC";
			$connection->query("SET NAMES 'utf8'");
			$contador=0;
			if($result = $connection->query($query)){
	     		while($row = $result->fetch_object()){
	      			if($contador > 4){?>
		      			<div class="col-md-3" onclick="loadAnimeInfo(<?php echo $row->id;?>)">
							<img src="./imgs/animes/<?php echo $row->img_defecto;?>">
							<div>
								<h1><?php echo $row->nombre ?></h1>
							</div>
						</div>
	      			<?php
	      			}
	      			$contador = $contador + 1;
		      	}
		    }
		?>
				</div>
			</div>

		</div>
	</div>


<?php
		}else if($_GET["section"]=="animes"){
?>

<div id="title_section" class="row">
	<h2>ÁNIMES</h2>
</div>

<div id="content_section" class="container" style="padding:0px!important">
	<div id="col-md-12" style="margin:0px">
		<div class="col-md-12" id="others_popular" style="padding:0px">

		<?php 
			include('php/conexion.php');
			$query = "SELECT * FROM anime";
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
</div>
<?php 
		}
?>
<?php 
	}else{
?>

	<?php 
		if(isset($_GET["anime"])){
			include('php/conexion.php');
			$connection->query("UPDATE anime SET visitas = visitas+1 WHERE id = ".$_GET["anime"]);
			$query = "SELECT * FROM anime WHERE id = ".$_GET["anime"];
			$connection->query("SET NAMES 'utf8'");
			if($result = $connection->query($query)){
 				while($row = $result->fetch_object()){

	?>

<div id="title_section" class="row">
	<h2><?php echo $row->nombre ?></h2>
</div>

<div class="row" id="content_anime_info" >
	<div class="col-xs-12 col-sm-4 col-md-4">
		<img src="imgs/animes/<?php echo $row->img_defecto;?>" id="imagen_anime">
	</div>
	<div class="col-xs-12 col-sm-8 col-md-8" id="data_anime_info">
	  	<div class="form-group">
	    	<div id="table_title_info" class="col-md-2">Género: </div>
	    	<div id="table_content_info" class="col-md-10"><?php echo $row->genero ?></div>
	  	</div>
	  	<div class="form-group">
	    	<div id="table_title_info" class="col-md-2">Idioma: </div>
	    	<div id="table_content_info" class="col-md-10"><?php echo $row->idioma?></div>
	  	</div>
	  	<div class="form-group">
	    	<div id="table_title_info" class="col-md-2">Descripción: </div>
	    	<div id="table_content_info" class="col-md-10"><?php echo $row->descripcion ?></div>
	  	</div>
	</div>
</div>

<div class="row" id="content_anime_info" >
	<div class="col-md-12" style="margin-top:30px"></div>
		<?php 
			$query = "SELECT * FROM temporada WHERE id_anime = ".$_GET["anime"];
			$connection->query("SET NAMES 'utf8'");
			if($result2 = $connection->query($query)){
 				while($row_season = $result2->fetch_object()){

		?>
	<div class="col-md-12 title_temp">
		<h2>Temporada<?php echo " ".$row_season->num_temporada.": ".$row->nombre." ".$row_season->nombre_ext?></h2>
		<span  onclick="showContentSeasonAnime(<?php echo $_GET['anime'];?>,<?php echo $row_season->id ?>)" class="glyphicon glyphicon-menu-down" id="season_<?php echo $row_season->id ?>"></span>	
	</div>
	<div class="col-md-12 table-responsive" id="content_temp_<?php echo $row_season->id ?>" style="display:none;border:solid lightblue 1px;padding:0px">
		<table class="table" style="text-align:center;width:100%">
			<thead>
				<th style="text-align: center">Capitulo</th>
				<th style="text-align: center">Parte</th>
				<th style="text-align: center">Url</th>
			</thead>
			<tbody id="content_tbody_temp_<?php echo $row_season->id ?>">
				
			</tbody>
		</table>
	</div>

		<?php 
				}
			}
		?>
</div>


	<?php 
				}
			}
		}else{
	?>
<div id="title_section" class="row">
	<h2>ÁNIMES</h2>
</div>

<div id="content_section" class="container" style="padding:0px!important">
	<div id="col-md-12" style="margin:0px">
		<div class="col-md-12" id="others_popular" style="padding:0px">

		<?php 
			include('php/conexion.php');
			$query = "SELECT * FROM anime";
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
</div>

<?php 
			}
	}
?>


