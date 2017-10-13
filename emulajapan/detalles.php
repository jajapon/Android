	<?php 
		if(isset($_GET['id']) && $_GET['id'] != ''){
			include 'php/conexion.php';
			$connection->query("SET NAMES 'utf8'");

			$query = 'SELECT * FROM emulador WHERE id = '.$_GET['id'].';';
			$result = $connection->query($query);

			if($result){
				if($result->num_rows > 0){
					$row = $result->fetch_object();
				}
			}
		}else{
			header('Location: index.php');
		}
	?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link href="css/detalles.css" rel="stylesheet" type="text/css">
    <link href="css/global.css" rel="stylesheet" type="text/css">
</head>
<body id="home">
	<header class="row col-md-12 col-xs-12 col-lg-12">
		<div id="banner" class="row col-md-12 col-xs-12 col-lg-12">
			<h1>EMULAJAPAN</h1>
		</div>
		<div id="menu" class="row col-md-12 col-xs-12 col-lg-12">
			<nav class="navbar navbar-default navbar-sm navbar-inverse navbar-static-top" role="navigation">
				<div class="container container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
						data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"></a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li class="active"><a href="index.php">Emuladores</a></li>
							<li><a href="#">Contacto</a></li>
						</ul>

						<ul class="nav navbar-nav navbar-right">
						</ul>
					</div>
				</div>
			</nav>
	   </div>
	</header>	
	<div class="row col-md-12 col-xs-12 col-lg-12" id="content_box">
		<div class="container" id="content">
			<div class="col-md-12 col-xs-12 col-lg-12 title">
				<h1><?php echo $row->name; ?></h1>
			</div>
			<div class="col-md-12 col-lg-12 col-xs-12" id="box_data">
				<div class="row col-md-4 col-lg-4 col-xs-12 no-margin"><img src="imagenes/emuladores/<?php echo $row->img ?>"></div>

				<div class="row col-md-8 col-lg-8 col-xs-12 no-margin">
					<div class="col-md-12 col-xs-12">
						<label>Descripción</label>
						<p><?php echo $row->description; ?></p>
					</div>
					<div class="col-md-12 col-xs-12">
						<label>Descargar Emulador</label>
						<?php 
						$cont = 1;
						if($row->drive != ''){ ?>
						<p>Opción <?php echo $cont; $cont++; ?>:
							<a target="_blank" href="<?php echo $row->drive; ?>"><img src="imagenes/drive.png" id="drive_icon" /></a>
						</p>
						<?php } ?>
						<?php 
						if($row->mega != ''){ ?>
						<p>Opción <?php echo $cont; $cont++; ?>:
							<a target="_blank" href="<?php echo $row->mega; ?>"><img src="imagenes/mega.png" id="mega_icon" /></a>
						</p>
						<?php } ?>
						<?php 
						if($row->mediafire != ''){ ?>
						<p>Opción <?php echo $cont; $cont++; ?>:
							<a target="_blank" href="<?php echo $row->mediafire; ?>"><img src="imagenes/mediafire.png" id="mediafire_icon" /></a>
						</p>
						<?php } ?>
					</div>	
					<div class="col-md-12 col-xs-12">
						<label>Webs donde encontrar juegos</label>
						<p><a target="_blank" href="<?php echo $row->uri_games_1; ?>"><?php echo $row->uri_games_1; ?></a></p>
						<p><a target="_blank" href="<?php echo $row->uri_games_2; ?>"><?php echo $row->uri_games_2; ?></a></p>
					</div>	
				</div>		
			</div>
			<div class="col-md-12 col-xs-12 col-lg-12 title" style="margin-top:30px">
				<h1>Configuración y uso</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-xs-12" id="box_data">
        		<iframe  id="frameexterno" src="https://www.youtube.com/embed/<?php echo $row->youtube_url?>" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>