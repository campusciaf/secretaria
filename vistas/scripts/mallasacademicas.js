//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();


	
	$.post("../controlador/mallasacademicas.php?op=selectPrograma", function(r){
	            $("#programa_ac").html(r);
	            $('#programa_ac').selectpicker('refresh');
	});

}



function listar(id_programa){
	$.post("../controlador/mallasacademicas.php?op=listar",{id_programa:id_programa}, function(data, status)
	{		
		data = JSON.parse(data);
		console.log(data);
		$("#mallas").html("");
		$("#mallas").append(data["0"]["0"]);

	});
}


function mostrar(id)
{
	$.post("../controlador/mallasacademicas.php?op=mostrar",{id : id}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);


		$("#programa").val(data.programa);
		$("#programa").selectpicker('refresh');
		$("#nombre").val(data.nombre);		
		$("#semestre").val(data.semestre);		
		$("#area").val(data.area);
		$("#area").selectpicker('refresh');
		$("#creditos").val(data.creditos);
		$("#codigo").val(data.codigo);
		$("#presenciales").val(data.presenciales);
		$("#independiente").val(data.independiente);
		$("#escuela").val(data.escuela);		
		$("#escuela").selectpicker('refresh');
		$("#id").val(data.id);

 	});
	
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/mallasacademicas.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			
			
	          alertify.success(datos);          
	          mostrarform(false);
	          tabla.ajax.reload();
			
	    }

	});
	limpiar();
}


//Función para desactivar registros
function desactivar(id_programa)
{


	alertify.confirm('Desactivar Programa',"¿Está Seguro de desactivar el programa?", function(){

        	$.post("../controlador/mallasacademicas.php?op=desactivar", {id_programa : id_programa}, function(e){
			
				if(e == 1){
				   alertify.success("Programa Desactivado");
					tabla.ajax.reload();
				   }
				else{
					alertify.error("Programa no se puede desactivar");
				}
        		
	            
        	});	
		}
					, function(){ alertify.error('Cancelado')});

}	
	
//Función para activar registros
function activar(id_programa)
{
	alertify.confirm('Activar Programa', '¿Está Seguro de activar el Programa?', function(){ 
	
		$.post("../controlador/mallasacademicas.php?op=activar", {id_programa : id_programa}, function(e){
				
        		if(e == 1){
				   alertify.success("Programa Activado");
					tabla.ajax.reload();
				   }
				else{
					alertify.error("Programa no se puede activar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}	
	
	

init();