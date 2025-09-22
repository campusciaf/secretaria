var data, cont;

function init(){
	select_ciudad();
}

function select_ciudad(){
	$.ajax({
		url: "../controlador/cv_ciudad_docente.php?op=mostrar",
	    type: "POST",
	    success: function(datos){
			//console.log(datos);
			data = JSON.parse(datos);
			cont = 0;
			while(cont < data.length){
				$(".usuario_municipio").append("<option value='"+data[cont]["1"]+"'>"+data[cont]["1"]+"</option>");
				cont++;
			}
	    }
	});

}

init();