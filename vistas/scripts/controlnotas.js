var tabla;
function init(){
    listar();
	$("#boton_regresar").hide();
}
/* Función para listar los docentes que se encuentran activos */
function listar(){
    $('#precarga').show();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
            "buttons": [{
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": 'Excel'
            },{
                "extend": 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				"title": 'Docentes',
                "titleAttr": 'Print'
            }],
		"ajax":{
            "url": '../controlador/controlnotas.php?op=listar',
            "type" : "get",
            "dataType" : "json",						
            "error": function(e){
                console.log(e.responseText);	
            }
        },
        "initComplete": function() {
            $('#precarga').hide();
        },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
/* Función para listar los grupos del docente seleccionado desde la lista principal */
function listarGrupos(id_docente){
    $("#listadoregistros").hide();
    $("#información_grupos").removeAttr("hidden");
	$("#boton_regresar").show();
	$("#listado_grupos").removeAttr("hidden");
	$("#estudiantes_grupo").dataTable();
	$("#id_docente").val(id_docente);
	generarSelectInput(id_docente);
}

$("#boton_regresar").off("click").on("click",function(){
    $("#listadoregistros").show();
    $("#información_grupos").attr("hidden",true);
	$("#boton_regresar").hide();
	$("#listado_grupos").attr("hidden",true);
	$("#selector_grupo").empty();
	$("#tblgrupos").html('');
	$("#tblpea").html('');
	$("#boton_pea").attr("hidden",true);
});

function cambiarEntregada(id_docente_grupo){
	$.ajax({
		type:'POST',
		url:'../controlador/controlnotas.php?op=cambiarEntregada',
		data:{id_docente_grupo:id_docente_grupo},
		success: function(msg){
			// en la variable msg llega la respuesta del controlador
			console.log(msg);
			//debemos leer esa informacion como JSON
			//JSON.parse convierte la informacion que llega del controlador nuevamente a json
			data = JSON.parse(msg);
			if (data.exito == 1) {
				//funcion del plugin datatables para recargar la tabla sin necesidad de recargar la pagina
				tabla.ajax.reload();
			}else{
				//alertify es un objeto del plugin alertify.js para notificaciones 
				alertify.error(data.info);
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});



}





function generarSelectInput(id_docente){
	/* Ajax para validar en tiempo real cuántos semestres ha cursado el estudiante */
	$.ajax({
		type:'POST',
		url:'../controlador/controlnotas.php?op=cargarOpciones',
		data:{id_docente:id_docente},
		success:function(msg){
			var datos = JSON.parse(msg);
			var option = '';
			var posiciones = datos.length;
			var id_grupo="";
			var jornada="";
			var materia="";
			var programa="";
			for (i = 0; i < posiciones; i++) {
				id_grupo = datos[i]['id_docente_grupo'];
				jornada = datos[i]['jornada'];
				materia = datos[i]['materia'];
				programa = datos[i]['nombre_programa'];
				option = '<option value="'+id_grupo+'">'+jornada+' - '+materia+' - '+programa+'</option>';
				$("#selector_grupo").append(option);
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

$("#listado_grupos_docente").on("submit",function(e){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	e.preventDefault();
	$("#boton_pea").removeAttr("hidden");
	var grupo_seleccionado = $("#selector_grupo").val();
	$.ajax({
		"type" : 'POST',
		"url" : '../controlador/controlnotas.php?op=listarEstudiantes',
        "data": {grupo_seleccionado : grupo_seleccionado},
		"success":function(msg){
			var datos = JSON.parse(msg);
			$("#tblgrupos").html(datos[0]);
			$("#estudiantes_grupo").dataTable({ dom: 'Bfrtip',
				"buttons": [{
                    "extend": 'excelHtml5',
                    "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    "titleAttr": 'Excel'
				},{
						"extend": 'print',
						"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						"messageTop": '<div style="width:50%;float:left">Registro y Control<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						"title": 'PEA',
						"titleAttr": 'Print'
					},
				],});
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
})

$("#boton_ver_pea").off("click").on("click",function(e2){
	$("#mostrarActividades").hide();
	$("#body-modal-pea").removeAttr("hidden");
	$("#contenedor_tabla").show();
	e2.preventDefault();
	var grupo_seleccionado = $("#selector_grupo").val();
	$.ajax({
		"type" : 'POST',
		"url" : '../controlador/controlnotas.php?op=cargarDatosPrograma',
		"data" : {grupo_seleccionado:grupo_seleccionado},
		"success" : function(msg){
			var datos = JSON.parse(msg);
			var materia = datos[0]['materia'];
			var id_programa = datos[0]['id_programa'];
			comprobar(materia,id_programa,grupo_seleccionado);
		},
		error:function() {
			alertify.error("Hay un error...");
		}
	});
});

function comprobar(materia, id_programa, id_docente_grupo){
	$.ajax({
		"type" : 'POST',
		"url" : '../controlador/controlnotas.php?op=comprobar',
		"data" : {materia:materia,id_programa:id_programa,id_docente_grupo:id_docente_grupo,},
		"success" : function(msg){
			var data = JSON.parse(msg);
            if(data==1){// no tiene pea por el admin
				$("#listadoregistros").hide();
				alertify.error("No tiene pea asignado");
                $("#tblpea").html('');
            }else if(data==2){// tiene pea por el admin pero no esta en la tabla pea docente
                alertify.success('Pea Creado y validado');
                listarPea(materia,id_programa,id_docente_grupo);
            }else{// tiene pea por el admin y por el pea docente
                listarPea(materia,id_programa,id_docente_grupo);
            }
		},
		"error":function(){
			alertify.error("Hay un error...");
		}
	});
}
//Función Listar PEA
function listarPea(materia,id_programa,id_docente_grupo){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tblpea').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',
            "buttons": [{
                    "extend": 'excelHtml5',
                    "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    "titleAttr": 'Excel'
				},{
                    "extend": 'print',
                    "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    "messageTop": '<div style="width:50%;float:left">Plan Educativo de Aula<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
                    "title": 'PEA',
                    "titleAttr": 'Print'
				}],
		"ajax":{
            "url": '../controlador/controlnotas.php?op=listarPea&id_programa='+id_programa+'&materia='+materia+'&id_docente_grupo='+id_docente_grupo,
            "type" : "get",
            "dataType" : "json",						
            "error": function(e){
				console.log(e.responseText);	
            }
        },
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
        "order": [[ 1, "asc" ]],//Ordenar (columna,orden)
	}).DataTable();
}
//Función Listar
function mostrarTemas(id_tema,id_docente_grupo){
	//id_tema,id_docente_grupo
	$("#contenedor_tabla").hide();
	$("#mostrarActividades").show();
	$.post("../controlador/controlnotas.php?op=listaractividades",{id_tema:id_tema, id_docente_grupo:id_docente_grupo}, function(data){
		data = JSON.parse(data);
		$("#mostrarActividades").show();
		$("#listadosactividades").html("");
        $("#listadosactividades").append(data["0"]["0"]);
		$("#id_tema").val(id_tema);
		$("#id_docente_grupo").val(id_docente_grupo);
	});
}

function volver(){
	$("#contenedor_tabla").show();
	$("#mostrarActividades").hide();
	$("#listadosactividades").html("");
}
//Función Listar
function programartemas(id_tema, id_docente_grupo){
	$("#listadoregistros").hide();
	$.post("../controlador/controlnotas.php?op=listaractividades",{id_tema:id_tema, id_docente_grupo:id_docente_grupo}, function(data){
		data = JSON.parse(data);
		$("#programaractividades").show();
		$("#listadosactividades").html("");
        $("#listadosactividades").append(data["0"]["0"]);
		$("#id_tema").val(id_tema);
		$("#id_docente_grupo").val(id_docente_grupo);
	});
}

$("#boton_horario").off("click").on("click",function(e3){
	e3.preventDefault();
	var id_docente = $("#id_docente").val();
	listarHorario(1, id_docente);
});

$("#boton_semana").off("click").on("click",function(e3){
	e3.preventDefault();
	var id_docente = $("#id_docente").val();
	listarHorario(1,id_docente);
});

$("#boton_fds").off("click").on("click",function(e3){
	e3.preventDefault();
	var id_docente = $("#id_docente").val();
	listarHorario(2, id_docente);
});

$("#boton_sabado").off("click").on("click",function(e3){
	e3.preventDefault();
	var id_docente = $("#id_docente").val();
	listarHorario(3,id_docente);
});

function listarHorario(opcion,id_docente){
	$("#precarga").show();
	$.post("../controlador/controlnotas.php?op=listarHorario", {opcion:opcion,id_docente:id_docente}, function(data){
		data = JSON.parse(data);
		$("#tblhorarios").html(""); 
		$("#tblhorarios").append(data["0"]["0"]);
		tablaDatos(opcion);
		$("#precarga").hide();	
	});	
}

function tablaDatos(opcion) {
	var horario = "";
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		if(opcion == 1){
			horario="Horario Semana";
		}else if(opcion == 2){
            horario="Fin de Semana";
		}else{
			horario="Solo Sabados";
		}
    $('#horario_docente').dataTable().fnDestroy();
    table = $('#horario_docente').DataTable({
		"bDestroy": true,
		"paging":   false,
		"searching": false,
		"scrollX": true,
		"fixedHeader": {headerOffset: 50},
		"columnDefs": [{ "width": "80px", "targets": 1 },{"className": "dt-center", "targets": "_all"}],
		dom: 'Bfrtip',
			buttons: [{
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": 'Excel'
            },{
                "extend": 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left">Reporte Horario Docente: '+horario+'<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
                "title": 'Materias Matriculadas',
                "titleAttr": 'Print'
            }],
		"language":{"url": "../public/datatables/idioma/Spanish.json"},
	});
}

init();