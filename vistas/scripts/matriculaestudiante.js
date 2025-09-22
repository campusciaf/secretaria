var tabla;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
	$("#formulario2").on("submit",function(e2){
		guardaryeditar2(e2);
	});
	$("#formularioverificar").on("submit",function(e1){
		verificardocumento(e1);	
	});
	$.post("../controlador/matriculaestudiante.php?op=selectPrograma", function(r){
        $("#fo_programa").html(r);
        $('#fo_programa').selectpicker('refresh');
	});
	$.post("../controlador/matriculaestudiante.php?op=selectJornada", function(r){
        $("#jornada_e").html(r);
        $('#jornada_e').selectpicker('refresh');
	});
	$.post("../controlador/matriculaestudiante.php?op=selectGrupo", function(r){
        $("#grupo").html(r);
        $('#grupo').selectpicker('refresh');
	});	
	$("#precarga").hide();
}

//Función limpiar
function limpiar(){
	$("#data").val("");
	$("#id_credencial").val("");
	$("#credencial_nombre").val("");
	$("#credencial_nombre_2").val("");
	$("#credencial_apellido").val("");
	$("#credencial_apellido_2").val("");
	$("#credencial_login").val("");
	$("#id_credencial").val("");
	$("#id_programa_ac").val("");
	$("#id_estudiante").val("");
	$("#periodo_grado").val("");
	$("#cod_saber_pro").val("");
	$("#acta_grado").val("");
	$("#folio").val("");
    $("#fecha_grado").val("");
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#mostrardatos").hide();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#seleccionprograma").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#mostrardatos").show();
		$("#btnagregar").show();
		$("#seleccionprograma").show();
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función Listar
function verificardocumento(e1){
	limpiar();
	e1.preventDefault();
	//$("#btnVerificar").prop("disabled",true);
	var formData = new FormData($("#formularioverificar")[0]);
	$.ajax({
	url: "../controlador/matriculaestudiante.php?op=verificardocumento",
	type: "POST",
	data: formData,
	contentType: false,
	processData: false,
	success: function(datos){ 
		console.log(datos);  	
		data = JSON.parse(datos);
		var id_credencial="";
		if(JSON.stringify(data["0"]["1"])=="false"){// si llega vacio toca matricular
			alertify.success("Estudiante Nuevo para el sistema");
			mostrarform(true);
			$("#credencial_usuario").val(data["0"]["0"]);
			id_credencial=data["0"]["0"];
			}
		else{
			id_credencial=data["0"]["0"];
			alertify.success("Esta registrado");
			listar(id_credencial);	
		}	
	}
});	
}	   

//Función Listar
function listar(id_credencial){
	$("#listadoregistros").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());	
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',
				"buttons": [{
                    "extend":    'excelHtml5',
                    "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    "titleAttr": 'Excel'
                },{
                    "extend": 'print',
                    "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    "messageTop": '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
                    "title" : 'Programas Académicos',
                    "titleAttr" : 'Print'
                }],
            "ajax":{
					url: '../controlador/matriculaestudiante.php?op=listar&id_credencial='+id_credencial,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e);
					}
            },
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 2, "asc" ]],//Ordenar (columna,orden)
	}).DataTable();
	mostrardatos(id_credencial);
}

// Cambiar Estado al estudiante
function cambiarEstado(value, id_estudiante,id_credencial,id_programa_ac){
	var data = value;
	$("#id_estudiante").val(id_estudiante);
	if (data == 2) {
		$("#cambio_estado_graduado").modal();
		$("#data").val(data);
		$("#id_credencial").val(id_credencial);
		$("#id_programa_ac").val(id_programa_ac);
		cargarPeriodos();
	}else{
		$.ajax({
			type:'POST',
			url:'../controlador/matriculaestudiante.php?op=cambiarEstado',
			data:{data:data,id_estudiante:id_estudiante},
			success:function(msg){
				if(msg == 1){
					alertify.success("Cambio realizado con éxito");
					refrescartabla();
				} else {
					alertify.error("No se pudo realizar el cambio");
				}
			},
			error:function(){
				alertify.error("Hay un error...");
			}
		});
	}
	
}
// Registrar graduado
function registrarGraduado(){
	var data = $("#data").val();
	var id_estudiante = $("#id_estudiante").val();
	var id_credencial = $("#id_credencial").val();
	var id_programa_ac = $("#id_programa_ac").val();
	var periodo_grado = $("#periodo_grado").val();
	var saber_pro = $("#cod_saber_pro").val();
	var acta_grado = $("#acta_grado").val();
	var folio = $("#folio").val();
	var fecha_grado = $("#fecha_grado").val();
	$.ajax({
		type:'POST',
		url:'../controlador/matriculaestudiante.php?op=registrarGraduado',
		data:{data:data,
			id_estudiante:id_estudiante,
			id_credencial:id_credencial,
			id_programa_ac:id_programa_ac,
			periodo_grado:periodo_grado,
			saber_pro:saber_pro,
			acta_grado:acta_grado,
			folio:folio,
			fecha_grado:fecha_grado	
		},
		success:function(msg){

			if(msg == 1){
				alertify.success("Cambio realizado con éxito");
				$("#cambio_estado_graduado").modal('toggle');
				refrescartabla();
			} else {
				alertify.error("No se pudo realizar el cambio");
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

// Función para cargar el select con los periodos académicos
function cargarPeriodos(){
	$.post("../controlador/actualidad.php?op=mostrarPeriodo", function (datos) {
		//console.table(datos);
		var option = "";
		var cont = JSON.parse(datos);
		//console.log(r);
		option += '<option value="" selected disabled> - Periodos - </option>';
		for (let i = 0; i < cont.length; i++) {
			option += '<option value="' + cont[i].periodo + '">' + cont[i].periodo + '</option>';
		}
		$('#periodo_grado').html(option);
	});
}

// Cambiar Estado al estudiante
function cambiarGrupo(value,id_estudiante){
	var data = value;
	$.ajax({
		type:'POST',
		url:'../controlador/matriculaestudiante.php?op=cambiarGrupo',
		data:{data:data,id_estudiante:id_estudiante},
		success:function(msg){
			if(msg == 1){
				alertify.success("Cambio realizado con éxito");
			} else {
				alertify.error("No se pudo realizar el cambio");
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

// Cambiar jornada  estudiante
function cambiarJornada(value,id_estudiante){
	var data = value;
	$.ajax({
		type:'POST',
		url:'../controlador/matriculaestudiante.php?op=cambiarJornada',
		data:{data:data,id_estudiante:id_estudiante},
		success:function(msg){
			if(msg == 1){
				alertify.success("Cambio realizado con éxito");
			} else {
				alertify.error("No se pudo realizar el cambio");
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

function mostrardatos(id_credencial){
	$.post("../controlador/matriculaestudiante.php?op=mostrardatos",{id_credencial : id_credencial}, function(data, status)
	{	
		console.log(data);
		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);		
	});
}

function mostraragregarprograma(id_credencial){
	$("#btnGuardar2").prop("disabled",false);
	$("#id_credencial").val(id_credencial);
	$("#myModalAgregarPrograma").modal("show");
}

function matriculaprograma(id_credencial){
	$.post("../controlador/matriculaestudiante.php?op=matriculaprograma",{id_credencial : id_credencial}, function(data, status)
	{
		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
	});
}
function mostrar(id)
{
	$.post("../controlador/matriculaestudiante.php?op=mostrar",{id : id}, function(data, status)
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
	$("#btnGuardar2").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	var credencial=$("#credencial_identificacion").val();	
	$.ajax({
		url: "../controlador/matriculaestudiante.php?op=guardaryeditar&credencial_identificacion="+credencial,
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos)
	    {
    		data = JSON.parse(datos);
    		alertify.success(data["0"]["0"]);          
    		mostrarform(false);
    		listar(data["0"]["1"]);
	    }
	});
	limpiar();
}

function guardaryeditar2(e2)
{
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario2")[0]);
	var id_credencial=$("#id_credencial").val();	
	$.ajax({
		url: "../controlador/matriculaestudiante.php?op=guardaryeditar2&id_credencial="+id_credencial,
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos)
	    {
	        
			alertify.success(datos);          
			$("#myModalAgregarPrograma").modal("hide");	
			listar(id_credencial);	
	    }
	});
	limpiar();
}

//Funcion para refrescar la tabla de Proyecto
function refrescartabla(){
	tabla.ajax.reload( function ( json ) {
		$('#listadoregistros').val( json.lastInput );
	});
}
init();