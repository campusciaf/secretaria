function init(){

	
	$.post("../controlador/proyeccionhorarios.php?op=listar", function(data){		
		data = JSON.parse(data);
		console.log(data["0"]["0"]);
		$("#resultado").html(data["0"]["0"]);
	});

}


init();