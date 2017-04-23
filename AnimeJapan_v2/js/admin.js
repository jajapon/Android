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