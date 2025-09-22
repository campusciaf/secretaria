$(document).ready(incio);
function incio() {
    $("#precarga").hide();

}

function consultaEstudiante(){

    var cedula = $("#cedula").val()
	$.post("../controlador/sofi_restringido.php?op=consultaEstudiante",{ "cedula": cedula },function(data){
		// console.log(data);
		data = JSON.parse(data);
		$("#consultaEstu").html(data);
		
	});
}

function estadoEst(estado){
    var cedula = $("#cedula").val();
	alertify.confirm("¿Está Seguro de desactivar el estudiante?", function(result){
		if(result){
			$.post("../controlador/sofi_restringido.php?op=estadoEst", {"estado" : estado, "cedula" : cedula}, function(e){
				// console.log(e);
				if(e){
					
					swal("Correcto!", "Actualizado Correctamente", "success");
                    consultaEstudiante();
				}else{
					swal("Opps!", "Algo falló al ejecutar la consulta", "error");
				}
			});	
        }
	})
}

