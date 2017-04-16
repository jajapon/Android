$(window).on("popstate", function(e) {
	window.location = window.location.href;
});

function changeSection(section){

	history.pushState(null, "", "animes.php?section="+section);
	var sections = ["animes", "genero", "alfabetico", "ultimos", "populares"];

	for(var i=0; i < sections.length; i++){
		if(sections[i] == section){
			document.getElementById(sections[i]).classList.add("active");
		}else{
			document.getElementById(sections[i]).classList.remove("active");
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
            document.getElementById('datos_section').innerHTML = data;
            document.getElementById("datos_section").style.display = "block";
       }           
    });
}

function changeSectionGenero(section, genero){
	history.pushState(null, "", "animes.php?section="+section+"&type="+genero);
	
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
			document.getElementById("content_section").innerHTML = data;
       }           
    });
}

function changeSectionLetter(section, letter){
	history.pushState(null, "", "animes.php?section="+section+"&letter="+letter);
	
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
			document.getElementById("content_section").innerHTML = data;
       }           
    });
}


function loadAnimeInfo(id){
	history.pushState(null, "", "animes.php?anime="+id);	
	
	var uri = './section.php';
	var dataString = 'anime='+id;

    $.ajax({
       type : "GET",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            document.getElementById('datos_section').innerHTML = data;
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