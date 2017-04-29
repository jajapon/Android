function loadAnimeTemps(){
	var animeid = document.getElementById("c_anime").value;

	var uri = './admin_ajax.php';
	var dataString = "opcion=1&animeid="+animeid;

    $.ajax({
       type : "POST",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            document.getElementById("c_temps").innerHTML = data;
       }           
    });
}

function loadAnimeTempsD(){
  var animeid = document.getElementById("d_anime").value;

  var uri = './admin_ajax.php';
  var dataString = "opcion=1&animeid="+animeid;

    $.ajax({
       type : "POST",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            document.getElementById("d_temps").innerHTML = data;
       }           
    });
}

function loadAnimeTempsCaps(){
  var animeid = document.getElementById("d_anime").value;
  var temporadaid = document.getElementById("d_temps").value;

  var uri = './admin_ajax.php';
  var dataString = "opcion=2&animeid="+animeid+"&temporadaid="+temporadaid;

    $.ajax({
       type : "POST",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            document.getElementById("table_caps").innerHTML = data;
       }           
    });
}

function EditCapAnime(animeid,temporadaid,capitulo,parte){
  var uri = './admin_ajax.php';
  var dataString = "opcion=3&animeid="+animeid+"&temporadaid="+temporadaid+"&capitulo="+capitulo+"&parte="+parte;

    $.ajax({
       type : "POST",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            document.getElementById("editar_content").innerHTML = data;
       }           
    });
}

function doEdit(animeid,temporadaid,capitulo,parte){
  var uri = './admin_ajax.php';
  var enlace = document.getElementById("enlace_cap").value;
  var dataString = "opcion=4&animeid="+animeid+"&temporadaid="+temporadaid+"&capitulo="+capitulo+"&parte="+parte+"&url="+enlace;

    $.ajax({
       type : "POST",
       url : uri,
       data : dataString,
       datatype: "json",
       success:function(data){
            document.getElementById("alert").innerHTML = data;
       }           
    });
}