var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

}


function listar(){
	
	$.post("../controlador/corresponsabilidad.php?op=listar",{},function(data, status){
	data = JSON.parse(data);
		
	$("#tllistado").html("");
	$("#tllistado").append(data["0"]["0"]);
	$("#precarga").hide()
	});
}

//Función para desactivar registros
function validarMeta(id_meta,fecha)
{

	alertify.confirm('Validar Meta', '¿Está Seguro(a) de validar la fuente de verificación?', function(){ 
	
	$.post("../controlador/corresponsabilidad.php?op=validarMeta",{id_meta : id_meta, fecha:fecha}, function(data, status)
			{

				data = JSON.parse(data);
				if(data==true){
				   alertify.success("Validado Correctamente");
					listar();
				   }

			});
	
	}
                , function(){ alertify.error('Cancelado')});
	

}

//Función para desactivar registros
function noValidarMeta(id_meta,fecha)
{

	alertify.confirm('No Validar Meta', '¿Está Seguro(a) de no validar la fuente de verificación?', function(){ 
	
	$.post("../controlador/corresponsabilidad.php?op=noValidarMeta",{id_meta : id_meta, fecha:fecha}, function(data, status)
			{

				data = JSON.parse(data);
				if(data==true){
				   alertify.success("invalidado Correctamente");
					listar();
				   }

			});
	
	}
                , function(){ alertify.error('Cancelado')});
	

}

function info(){

	alertify.alert('Pendiente','Proceso sin fuente de verificación.', function(){  });
}
init();