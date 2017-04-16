<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<link rel="stylesheet" href="./css/global.css">
	<link rel="stylesheet" href="./css/anime.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/global.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<header class="container-fluid">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			   
			    <div class="navbar-header">
				    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    </button>
				        <a class="navbar-brand" href="#"><img src="imgs/ic_launcher.png" id="ic_launcher"></a>
			    </div>

			   
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        <li><a href="#">Inicio <span class="sr-only">(current)</span></a></li>
			        <li class="active"><a href="#">Animes</a></li>
			        <li><a href="#">Contacto</a></li>
			      </ul>
			      <form id="signin" class="navbar-form navbar-right" role="form">
			            <div class="input-group">
			                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			                <input id="email" type="email" class="form-control" name="email" value="" placeholder="Email Address">    
			            </div>

			            <div class="input-group">
			                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			                <input id="password" type="password" class="form-control" name="password" value="" placeholder="Password">              
			            </div>

			            <button type="submit" class="btn btn-primary">Login</button>
			       </form>
			     
			    </div>
		  </div>
		</nav>
	</header>
	<section style="position: relative!important;">
		<div class="col-md-2" id="menu_section">
			<center><img src="imgs/ic_launcher.png" style="height:45px;padding:4px;"/></center>
			<ul>
				<li onclick="changeSection('animes')" id="animes">Animes</li>
				<li onclick="changeSection('genero')" id="genero">Género</li>
				<li onclick="changeSection('alfabetico')" id="alfabetico">Alfabéticamente</li>
				<li onclick="changeSection('ultimos')" id="ultimos">Últimos agregados</li>
				<li onclick="changeSection('populares')" id="populares">Populares</li>
			</ul>
		</div>
		<div class="col-md-10" id="datos_section"
>
			<?php 
				include('section.php');
			 ?>
		</div>		
	</section>
</body>
</html>