var isOnFullScreen = false;

$(window).on("popstate", function(e) {
	window.location = window.location.href;
});

function changeSection(section,session = false){
    document.getElementById('datos_section').innerHTML = '<center><img src="imgs/loading.gif" id="loading"/></center><h1 style="font-family:kenyanCoffee;text-align:center" >Cargando...</h1>';
    document.getElementById('section').style = 'background-color: #FFFFFF !important';
    document.getElementById("datos_section").style.display = "block";

	history.pushState(null, "", "animes.php?section="+section);
	if(session){
		var sections = ["animes", "genero", "alfabetico", "ultimos", "populares","favoritos"];
	}else{
		var sections = ["animes", "genero", "alfabetico", "ultimos", "populares"];
	}
	for(var i=0; i < sections.length; i++){
		if(sections[i] != 'registro'){
			if(sections[i] == section){
				document.getElementById(sections[i]).classList.add("active");
			}else{
				document.getElementById(sections[i]).classList.remove("active");
			}
		}
	}
	
	var uri = './section.php';
	var dataString = "";

	if(section !="animes"){
		dataString = 'section='+section;
	}

    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            setTimeout(function(){
            	document.getElementById('datos_section').innerHTML = data;
            	document.getElementById('section').style = 'background-color: #D8D8D8 !important';
            	document.getElementById("datos_section").style.display = "block";
            }, 1000);
       }           
    });
}

function changeSectionGenero(section, genero){
	history.pushState(null, "", "animes.php?section="+section+"&type="+genero);
	
	document.getElementById('content_section').innerHTML = '<center><img src="imgs/loading.gif" id="loading"/></center><h1 style="font-family:kenyanCoffee;text-align:center" >Cargando...</h1>';

	var generos= ["todos","accion", "deportes", "romance", "aventura","comedia"];

	for(var i=0; i < generos.length; i++){
		if(generos[i] == genero){
			document.getElementById(generos[i]).classList.add("active_genero");
		}else{
			document.getElementById(generos[i]).classList.remove("active_genero");
		}
	}
	
	var uri = './php/anime_genero.php';
	var dataString = '';

	dataString = dataString+'&type='+genero;

    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
       		setTimeout(function(){
				document.getElementById("content_section").innerHTML = data;
			    document.getElementById('content_section').style = 'background-color: #D8D8D8 !important; padding-left:0px;padding-right:0px';
				document.getElementById('section').style = 'background-color: #D8D8D8 !important';
            	document.getElementById("content_section").style.display = "block";
            }, 500);
       }           
    });
}

function changeSectionLetter(section, letter){
	history.pushState(null, "", "animes.php?section="+section+"&letter="+letter);
	
	document.getElementById('content_section').innerHTML = '<center><img src="imgs/loading.gif" id="loading"/></center><h1 style="font-family:kenyanCoffee;text-align:center" >Cargando...</h1>';
	
	var letters= ["todos","A", "B", "C", "D","F", "G", "H", "I","J", "K", "L", "M","N", "O", "P", "Q","R", "S", "T", "U","W", "X", "Y", "Z"];

	for(var i=0; i < letters.length; i++){
		if(letters[i] == letter){
			document.getElementById(letters[i]).classList.add("active_genero");
		}else{
			document.getElementById(letters[i]).classList.remove("active_genero");
		}
	}
	
	var uri = './php/animes_orden_alfabetico.php';
	var dataString = '';

	dataString = dataString+'&letter='+letter;

    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
       	    setTimeout(function(){
				document.getElementById("content_section").innerHTML = data;
			    document.getElementById('content_section').style = 'background-color: #D8D8D8 !important; padding-left:0px;padding-right:0px';
				document.getElementById('section').style = 'background-color: #D8D8D8 !important';
            	document.getElementById("content_section").style.display = "block";
            }, 500);
       }           
    });
}


function loadAnimeInfo(id){
	history.pushState(null, "", "animes.php?anime="+id);	
	document.getElementById('datos_section').innerHTML = '<center><img src="imgs/loading.gif" id="loading"/></center><h1 style="font-family:kenyanCoffee;text-align:center" >Cargando...</h1>';
	document.getElementById('section').style = 'background-color: #FFFFFF !important';	

	var uri = './section.php';
	var dataString = 'anime='+id;

    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
       	    setTimeout(function(){
				document.getElementById("datos_section").innerHTML = data;
			    document.getElementById('datos_section').style = 'background-color: #FFFFFF !important; padding-left:0px;padding-right:0px';
            	document.getElementById("datos_section").style.display = "block";
            }, 500);
       }           
    });
}

function showContentSeasonAnime(animeid, season){
	var uri = './anime_info.php';
	var dataString = 'animeid='+animeid+"&season="+season;
	if(document.getElementById("content_temp_"+season).style.display=="none"){

	    $.ajax({
	       type : "POST",
	       url : uri,
	       data : dataString,
	       datatype: "json",
	       success:function(data){
	            document.getElementById('content_tbody_temp_'+season).innerHTML = data;
	            document.getElementById("season_"+season).setAttribute("class","glyphicon glyphicon-menu-up");
				document.getElementById("content_temp_"+season).style.display="block";
	       }           
	    });

	}else{
		document.getElementById("season_"+season).setAttribute("class","glyphicon glyphicon-menu-down");
		document.getElementById("content_temp_"+season).style.display="none";
	}
}

function loadAnimeVideoCap(section,cap,parte,idanime,idtemporada){
	/*history.pushState(null, "", "animes.php?section="+section+'&idanime='+idanime+"&idtemporada="+idtemporada+"&cap="+cap+"&parte="+parte);	
	var uri = './section.php';
	var dataString = 'section=ver_capitulo';*/
	window.location.href = "animes.php?section="+section+'&idanime='+idanime+"&idtemporada="+idtemporada+"&cap="+cap+"&parte="+parte;
	/*dataString = dataString+'&idanime='+idanime+"&idtemporada="+idtemporada+"&cap="+cap+"&parte="+parte;
    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){

       }           
    });*/
}

function loadAnimeInfoLook(){
	var nombreAnime = "";
	var uri = './php/anime_search.php';
	var dataString = '';
	document.getElementById('content_section').innerHTML = '<center><img src="imgs/loading.gif" id="loading"/></center><h1 style="font-family:kenyanCoffee;text-align:center" >Cargando...</h1>';
    document.getElementById('content_section').style = 'background-color: #FFFFFF !important; padding-left:0px;padding-right:0px';
	document.getElementById('section').style = 'background-color: #FFFFFF !important';

	if(document.getElementById("lookfor_input").value !="" || document.getElementById("lookfor_input").value != null){
		nombreAnime = document.getElementById("lookfor_input").value;
	}else{
		nombreAnime = "";
	}
	dataString = dataString+'&nombre_anime='+nombreAnime;

    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
       	    setTimeout(function(){
				document.getElementById("content_section").innerHTML = data;
			    document.getElementById('content_section').style = 'background-color: #D8D8D8 !important; padding-left:0px;padding-right:0px';
				document.getElementById('section').style = 'background-color: #D8D8D8 !important';
            	document.getElementById("content_section").style.display = "block";
            }, 500);       
       	}           
    });
}

function doFavourite(action,iduser,idanime){
	var uri = './php/favourites.php';
	dataString = 'action='+action+'&iduser='+iduser+'&idanime='+idanime;

	$.ajax({
       type : "POST",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
       	    switch(action){
       	    	case 'add':
       	    		document.getElementById('fav_button').setAttribute('onclick','doFavourite(\'delete\','+iduser+','+idanime+')');
       	    		document.getElementById('fav_button').innerHTML = '<i class="fa fa-star" style="font-size:30px;margin-top:10px; color:#D7DF01">';    				   	    		
       	    		break;
       	    	case 'delete':
       	    		document.getElementById('fav_button').setAttribute('onclick','doFavourite(\'add\','+iduser+','+idanime+')');
       	    		document.getElementById('fav_button').innerHTML = '<i class="fa fa-star-o" style="font-size:30px;margin-top:10px; color:#D7DF01">';
       	    		break;
       	    	default:
       	    }     
       	}           
    });
}

function doUsuario(action){
	var uri = './php/usuarios.php';
	var username = document.getElementById('new_username').value;
	var userpass = document.getElementById('new_userpass').value;
	var nombre = document.getElementById('nombre').value;
	var apellidos = document.getElementById('apellidos').value;
	
	if(username != '' && userpass != '' && nombre != '' && apellidos != ''){
		dataString = 'action='+action+'&username='+username+'&userpass='+userpass+'&nombre='+nombre+'&apellidos='+apellidos;
		$.ajax({
	       type : "POST",
	       url : uri,
	       data : dataString,
	       datatype: "json",
	       success:function(data){
	  			document.getElementById('alert').innerHTML = data;
	       	}           
	    });
	}else{
		document.getElementById('alert').innerHTML = '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Debe rellenar todo el formulario.</div>';
	}
}