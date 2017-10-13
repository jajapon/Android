<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
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
				<h1>Emuladores</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-xs-12" id="box_data">
		<?php  
			$cont = 0;
			/*for($i = 0; $i < 7; $i++){ */
			include 'php/conexion.php';
			$connection->query("SET NAMES 'utf8'");

			$query = 'SELECT * FROM emulador ORDER BY name;';
			$result = $connection->query($query);

			if($result){
				if($result->num_rows > 0){
					while($row = $result->fetch_object()){
						if($cont == 5){ $cont = 1;} else{ $cont++; }
			?>	
				<div class="col-md-3 col-sm-4 col-xs-6 col-lg-3 box_emulator ">
					<div class="row col-md-12 col-xs-12 col-sm-12 no-padding no-margin">
						<a href="detalles.php?id=<?php echo $row->id; ?>" ><img src="imagenes/emuladores/<?php echo $row->img; ?>"></a>				
					</div>
				</div>	
			<?php 
					}			
				}
			} 
			?>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>