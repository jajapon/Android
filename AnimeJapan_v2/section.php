<?php 
	session_start();

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
			<li id="comedia" onclick="changeSectionGenero('genero','comedia')">Comedia</li>
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
		}else if($_GET["section"]=="ver_capitulo"){
			if(isset($_GET["idanime"]) && isset($_GET["idtemporada"]) && isset($_GET["cap"]) && isset($_GET["parte"])){
			$query = "SELECT anime.nombre,temporada.num_temporada, capitulo.* FROM capitulo,anime,temporada WHERE anime.id = temporada.id_anime AND temporada.id = capitulo.temporada_id AND capitulo.animeid = ".$_GET["idanime"]." AND capitulo.temporada_id = ".$_GET["idtemporada"]." AND capitulo.ncapitulo = ".$_GET["cap"]." AND capitulo.parte =".$_GET["parte"];

				include('./php/conexion.php');
				$connection->query("SET NAMES 'utf8'");


				if($result = $connection->query($query)){
			 		while($row = $result->fetch_object()){
			 			$urlvideo = "";
			 			if(strlen($row->url) > 14){
		                   $urlvideo = $row->url;
		                 }else{
		                   $urlvideo = "https://www.youtube.com/embed/".$row->url;
		                 }
		                 $tipovideo = "";
		                 if(preg_match('/youtube.com/',$urlvideo)){
		                 	$tipovideo = "youtube";
		                 }
		                 if(preg_match('/'.'vk.com'.'/',$urlvideo)){
		                 	if(preg_match('/'.'video_ext'.'/',$urlvideo)){
		                 		$tipovideo = "vk";
		                 	}
		                 }
		                 if(preg_match('/'.'rutube'.'/',$urlvideo)){
		                 	$tipovideo = "rutube";
		                 }
		                 if(preg_match('/'.'googlevideo.com'.'/',$urlvideo)){
		                 	$tipovideo = "animeflv";
		                 }
		                 if(preg_match('/'.'tu.tv'.'/',$urlvideo)){
			             	if(preg_match('/'.'iframe'.'/',$urlvideo)){
				             	$tipovideo = "tutv";
			             	}
			             }
	?>
	<div id="title_section" class="row">
		<h2 style="text-align:center"><?php echo $row->nombre ?></h2>
	</div>
	<div id="subtitle_section" style="margin:0px">
		<h2 style="text-align:center;margin:0px">Temporada<?php echo " ".$row->num_temporada.": Capitulo ".$row->ncapitulo ?></h2>
	</div>

	<div id="content_section" class="container" style="padding:0px;z-index:10000!important">
		<div id="col-md-12" style="margin:0px">
			<div class="col-md-12" id="video" style="padding:0px;margin-top:10px">
				<div id="video_content" class="row col-md-12 col-xs-12" style="margin:0px;padding:0px">
					<div id="video_content" class="col-md-offset-1 col-md-10">

				<?php 
					if($tipovideo!=""){
						if($tipovideo=="youtube"){
				?>
			        <div class="players" id="player1-container">    
			        	<iframe  id="frameexterno" src="<?php echo $urlvideo?>" frameborder="0" allowfullscreen></iframe>
			        </div>
				</div>
		  		<?php
		  				}else if($tipovideo=="vk"){
		  				 ?>
		  					<iframe  id="frameexterno" src="<?php echo $urlvideo?>" frameborder="0" allowfullscreen></iframe>
		  		<?php
		  				}else if($tipovideo=="rutube"){
		  				 ?>
		  					<iframe  id="frameexterno" src="<?php echo $urlvideo?>" frameborder="0" allowfullscreen></iframe>
		  		<?php
		  				}else if($tipovideo=="animeflv"){
		  				 ?>
		  				 <video controls="" autoplay="" name="media" style="margin-left:15%!important;width:70%!important;height:auto" ><source src="<?php echo $urlvideo?>" type="video/mp4"></video>
		  		<?php
		  				}else if($tipovideo=="tutv"){
		  				 ?>
		  				 	<iframe  id="frameexterno" src="<?php echo $urlvideo?>" frameborder="0" allowfullscreen></iframe>
		  		<?php
		  				}
		  			}
		      	?>
		      	</div>
		    </div>
			<div id="row container col-md-10">
				<center>
				<?php 
				if($row->ncapitulo == 1){
					$siguienteCap = $row->ncapitulo+1;
					echo '<button type="button" style="position:relative;margin-top:20px!important;margin-bottom:20px" onclick="loadAnimeVideoCap(\''.$_GET['section'].'\','.$siguienteCap.','.$_GET['parte'].','.$_GET['idanime'].','.$_GET['idtemporada'].')" class="btn btn-warning">Siguiente</button>';
				}else{
					$siguienteCap = $row->ncapitulo+1;
					$anteriorCap = $row->ncapitulo-1;

					echo '<button type="button"   style="position:relative;margin-top:20px!important;margin-bottom:20px"  class="btn btn-warning" onclick="loadAnimeVideoCap(\''.$_GET['section'].'\','.$anteriorCap.','.$_GET['parte'].','.$_GET['idanime'].','.$_GET['idtemporada'].')">Anterior</button>
					<button type="button"   style="position:relative;margin-top:20px!important;margin-bottom:20px"  onclick="loadAnimeVideoCap(\''.$_GET['section'].'\','.$siguienteCap.','.$_GET['parte'].','.$_GET['idanime'].','.$_GET['idtemporada'].')" class="btn btn-warning">Siguiente</button>';
				} 
				?>
				</center>
			</div>
			<?php
		      }
		    }else{
		    	echo $connection->error;
		    }
		}
		?>
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
		}else if($_GET["section"]=="favoritos"){
?>

<div id="title_section" class="row">
	<h2>MIS FAVORITOS</h2>
</div>

<div id="content_section" class="container" style="padding:0px!important">
	<div id="col-md-12" style="margin:0px">
		<div class="col-md-12" id="others_popular" style="padding:0px">

		<?php 
			include('php/conexion.php');
			$query = "SELECT a.* FROM anime a, favoritos f WHERE a.id = f.id_anime AND f.id_usuario = ".$_SESSION['id'].';';
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
		}else if($_GET["section"]=="registro"){
?>

<div id="title_section" class="row">
	<h2>REGISTRO EN ANIMEJAPAN</h2>
</div>

<div id="content_section" class="container" style="padding:0px!important">
	<div class="col-md-12">
		<div class="col-md-offset-4 col-md-4" style="margin-top:50px;background-color:#A4A4A4;padding:20px">
			<div class="form-group">
				<input type="text" class="form-control" id="new_username" name="nombre" placeholder="Usuario" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="new_userpass" name="userpass" placeholder="Contraseña" required>
			</div>		
			<div class="form-group">
				<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required>
			</div>
			<div class="form-group">
				<input type="button" onclick="doUsuario('add')" class="form-control btn btn-success" style="float:right;margin-bottom:20px" value="Enviar">
			</div>
			<div  id="alert" style="margin-top:10px">
				
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
<div id="look_section" class="row" style="background-color:#084B8A;margin:0px;padding:0px">
	<div class="col-md-12" style="padding:0px">
       	<input type="text" id="lookfor_input" name="lookfor_input" onkeyup="loadAnimeInfoLook()" placeholder="Introduce el anime" class="form-control" style="padding:20px 20px!important; font-size:18px;width:100%;border-radius:0px">
    </div>
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
		<?php if(isset($_SESSION['user'])){ ?>
		<center>
		<?php 
			$query = "SELECT * FROM favoritos WHERE id_anime = ".$_GET["anime"]." AND id_usuario = ".$_SESSION['id'];
			if($resultFav = $connection->query($query)){
				if($resultFav->num_rows == 0){ ?>
					<a id="fav_button" onclick="doFavourite('add',<?php echo $_SESSION['id']; ?>,<?php echo $_GET['anime']; ?>)"><i class="fa fa-star-o" style="font-size:30px;margin-top:10px; color:#D7DF01"></i></a>
				<?php }else{ ?>
					<a id="fav_button" onclick="doFavourite('delete',<?php echo $_SESSION['id']; ?>,<?php echo $_GET['anime']; ?>)"><i class="fa fa-star" style="font-size:30px;margin-top:10px; color:#D7DF01"></i></a>
				<?php 
				}
 			}else{
 				echo $query;
 			}
		?>
		</center>
		<?php } ?>
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
<div id="look_section" class="row" style="background-color:#084B8A;margin:0px;padding:0px">
	<div class="col-md-12" style="padding:0px">
       	<input type="text" id="lookfor_input" name="lookfor_input" onkeyup="loadAnimeInfoLook()" placeholder="Introduce el anime" class="form-control" style="padding:20px 20px!important; font-size:18px;width:100%;border-radius:0px">
    </div>
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


