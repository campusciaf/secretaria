function init(){

	$("#precarga").hide();
	$("#formulario").on("submit",function(e)
	{
		$("#precarga").removeClass("hide");
		buscarfiltrar(e);	
	});
	
	$.post("../controlador/consultavariables.php?op=selectPrograma", function(r){
	            $("#programa").html(r);
	            $('#programa').selectpicker('refresh');
	});
		//Cargamos los items de los selects contrato
	$.post("../controlador/consultavariables.php?op=selectJornada", function(r){
	            $("#jornada").html(r);
	            $('#jornada').selectpicker('refresh');
	});
	
		//Cargamos los items de los selects contrato
	$.post("../controlador/consultavariables.php?op=selectPeriodo", function(r){
	            $("#periodo").html(r);
	            $('#periodo').selectpicker('refresh');
	});

}
	


function buscarfiltrar(e)
{
	 
	e.preventDefault(); //No se activará la acción predeterminada del evento

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/consultavariables.php?op=listar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
			$("#precarga").addClass("hide");	
			data = JSON.parse(datos);
			$("#resultado").html("");
            $("#resultado").append(data["0"]["0"]);
	 
		}

	});
	//limpiar();
}


init();