var tabla;
var tabla2;
var id_programa_ac_ = "";
var id_estudiante_ = "";
var ciclo_ = "";
var api; // variable global para inicializar el responsive
var anchoVentana = window.innerWidth; // ancho de la ventana
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	$("#listadoregistros").hide();
	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
	$("#formularioverificar").on("submit",function(e1){
		verificardocumento(e1);	
	});
	$("#formularionovedadjornada").on("submit",function(e2){
		actualizarCambioJornada(e2);	
	});
	$("#formularionovedadperiodo").on("submit",function(e3){
		actualizarCambioPeriodo(e3);	
	});
	
	$("#formularionovedadgrupo").on("submit",function(e4){
		actualizarCambioGrupo(e4);	
	});
	$.post("../controlador/consultaacademica.php?op=selectPrograma", function(r){
        $("#fo_programa").html(r);
        $('#fo_programa').selectpicker('refresh');
	});
	$.post("../controlador/consultaacademica.php?op=selectJornada", function(r){
        $("#jornada_e").html(r);
        $('#jornada_e').selectpicker('refresh');
    });
	$.post("../controlador/consultaacademica.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
	});
	$.post("../controlador/consultaacademica.php?op=selectGrupo", function(r){
        $("#grupo").html(r);
        $('#grupo').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar(){
	$("#id_credencial").val("");
	$("#credencial_nombre").val("");
	$("#credencial_nombre_2").val("");
	$("#credencial_apellido").val("");
	$("#credencial_apellido_2").val("");
	//$("#credencial_identificacion").val("");
	$("#credencial_login").val("");
}
//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#seleccionprograma").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
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
	$("#listadomaterias").hide();
    e1.preventDefault();
    var formData = new FormData($("#formularioverificar")[0]);
    $.ajax({
        "url": "../controlador/consultaacademica.php?op=verificardocumento",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){
            var data = JSON.parse(datos);
            var id_credencial="";
            if(JSON.stringify(data["0"]["1"])=="false"){// si llega vacio toca matricular
                alertify.error("Estudiante No Existe");
                $("#listadoregistros").hide();
                $("#mostrardatos").hide();
            }else{
                id_credencial=data["0"]["0"];
                $("#mostrardatos").show();
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
        "autoWidth": false,
		"dom":// dom para el responsive
		"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-right ml-2'B>f>>" +
		"<'row'<'col-sm-12'tr>>" +
		"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "buttons": [{
            "extend":    'excelHtml5',
            "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "messageTop": '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
            "title": 'Programas Académicos',
            "titleAttr": 'Print'
        }],
		"ajax":{
            "url": '../controlador/consultaacademica.php?op=listar&id_credencial='+id_credencial,
            "type" : "get",
            "dataType" : "json",						
            "error": function(e){
                console.log(e);
            }
        },
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
        "order": [[ 2, "asc" ]],//Ordenar (columna,orden)
        "select": 'single',// funcion para cambiar el responsive del data table
        "drawCallback": function(){
            api = this.api();
            var $table = $(api.table().node());
            if ($table.hasClass('cards')) {
                // Create an array of labels containing all table headers
                var labels = [];
                $('thead th', $table).each(function () {
                    labels.push($(this).text());
                });
                // Add data-label attribute to each cell
                $('tbody tr', $table).each(function () {
                    $(this).find('td').each(function (column) {
                        $(this).attr('data-label', labels[column]);
                    });
                });
                var max = 0;
                $('tbody tr', $table).each(function () {
                    max = Math.max($(this).height(), max);
               }).height(max);
            }else{
                // Remove data-label attribute from each cell
                $('tbody td', $table).each(function () {
                   $(this).removeAttr('data-label');
                });
                $('tbody tr', $table).each(function () {
                    $(this).height('auto');
                });
            }
        }
    });
	var width = $(window).width();
    if(width <= 750){
        $(api.table().node()).toggleClass('cards');
        api.draw('page');
    }
    window.onresize = function(){
        anchoVentana = window.innerWidth;
        if(anchoVentana > 1000){
            $(api.table().node()).removeClass('cards');
            api.draw('page');
        }else if(anchoVentana > 750 && anchoVentana < 1000){
            $(api.table().node()).removeClass('cards');
            api.draw('page');
        }else{
            $(api.table().node()).toggleClass('cards');
            api.draw('page');
        }
    }
	mostrardatos(id_credencial);
}
function mostrardatos(id_credencial){
	$.post("../controlador/consultaacademica.php?op=mostrardatos",{id_credencial : id_credencial}, function(data){
		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
	});
}
function mostrarmaterias(id_programa_ac,id_estudiante,ciclo){
	//variables globales para recargar las materias
	id_programa_ac_ = id_programa_ac;
	id_estudiante_ = id_estudiante;
	ciclo_ = ciclo;
	$("#precarga").show();
	$.post("../controlador/consultaacademica.php?op=mostrarmaterias",{id_programa_ac : id_programa_ac , id_estudiante : id_estudiante, ciclo:ciclo}, function(data){
		//console.log(data);
		data = JSON.parse(data);
		//$("#myModalAgregarPrograma").modal("show");
		$("#listadoregistros").hide();
		$("#listadomaterias").show();
		$("#listadomaterias").html("");
		$("#listadomaterias").append(data["0"]["0"]);
		$("#precarga").hide();
	});
}

function matriculaprograma(id_credencial){
	$.post("../controlador/consultaacademica.php?op=matriculaprograma",{id_credencial : id_credencial}, function(data){
		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
	});
}
function mostrar(id){
	$.post("../controlador/consultaacademica.php?op=mostrar",{id : id}, function(data){
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
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar2").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	var credencial=$("#credencial_identificacion").val();
	$.ajax({
		"url": "../controlador/consultaacademica.php?op=guardaryeditar&credencial_identificacion="+credencial,
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){   	
            var data = JSON.parse(datos);
            alertify.success(data["0"]["0"]);          
            mostrarform(false);
            listar(data["0"]["1"]);
        }
	});
	limpiar();
}
function matriculaMateriaNormal(id_estudiante,id_programa_ac,id_materia,semestres_del_programa,fecha){
	$("#precarga").show();
	$.post("../controlador/consultaacademica.php?op=matriculaMateriaNormal",{id_estudiante : id_estudiante , id_materia:id_materia, semestres_del_programa:semestres_del_programa, fecha:fecha}, function(data){		
		data = JSON.parse(data);
		if(data==true){
			alertify.success("Materia matriculada");
			mostrarmaterias(id_programa_ac,id_estudiante);
		}else{
			alertify.error("error");
		}
	});
}	
function eliminarMateria(id_estudiante,id_programa_ac,id_materia,semestres_del_programa,id_materia_matriculada,promedio_materia_matriculada){
	$("#precarga").show();
	$.post("../controlador/consultaacademica.php?op=eliminarMateria",{id_estudiante : id_estudiante , id_materia:id_materia, semestres_del_programa:semestres_del_programa, id_materia_matriculada: id_materia_matriculada, promedio_materia_matriculada : promedio_materia_matriculada}, function(data){
		data = JSON.parse(data);
		if(data==true){
			alertify.success("Materia eliminada");
			mostrarmaterias(id_programa_ac,id_estudiante);	
		}else{
			alertify.error("error");
		}
	});	
}	
function cambioJornada(id_materia,jornada,ciclo,id_programa_ac,id_estudiante){
    $("#myModalMatriculaNovedad").modal("show");
    $("#id_materia").val(id_materia);
    $("#ciclo").val(ciclo);
    $("#id_programa_ac").val(id_programa_ac);
    $("#id_estudiante").val(id_estudiante);
    $("#jornada_e").val(jornada);
    $("#jornada_e").selectpicker('refresh');
}
function cambioPeriodo(id_materia,periodo,ciclo,id_programa_ac,id_estudiante){	
    $("#myModalMatriculaNovedadPeriodo").modal("show");
    $("#id_materia_j").val(id_materia);
    $("#ciclo_j").val(ciclo);
    $("#id_programa_ac_j").val(id_programa_ac);
    $("#id_estudiante_j").val(id_estudiante);
    $("#periodo").val(periodo);
    $("#periodo").selectpicker('refresh');
}
function cambioGrupo(id_materia,periodo,ciclo,id_programa_ac,id_estudiante,grupo){	
    $("#myModalMatriculaNovedadGrupo").modal("show");
    $("#id_materia_g").val(id_materia);
    $("#ciclo_g").val(ciclo);
    $("#id_programa_ac_g").val(id_programa_ac);
    $("#id_estudiante_g").val(id_estudiante);
    $("#grupo").val(grupo);
    $("#grupo").selectpicker('refresh');
}
//Función Listar
function actualizarCambioJornada(e2){
    e2.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularionovedadjornada")[0]);
    $.ajax({
        "url": "../controlador/consultaacademica.php?op=actualizarJornada",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){   
            //console.log(datos);			
            datos = JSON.parse(datos);
            $("#myModalMatriculaNovedad").modal("hide");
            var id_programa_ac=datos["0"]["0"];
            var id_estudiante=datos["0"]["1"];
            alertify.success("Cambio Correcto");
            mostrarmaterias(id_programa_ac,id_estudiante);
        }
	});
}
//Función Listar
function actualizarCambioPeriodo(e3){
    e3.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularionovedadperiodo")[0]);
    $.ajax({
        "url": "../controlador/consultaacademica.php?op=actualizarPeriodo",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){
            datos = JSON.parse(datos);
            $("#myModalMatriculaNovedadPeriodo").modal("hide");
            var id_programa_ac=datos["0"]["0"];
            var id_estudiante=datos["0"]["1"];
            alertify.success("Cambio Correcto");
            mostrarmaterias(id_programa_ac,id_estudiante);
        }
    });
}
//Función Listar
function actualizarCambioGrupo(e4){
    e4.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularionovedadgrupo")[0]);
    $.ajax({
        "url": "../controlador/consultaacademica.php?op=actualizarGrupo",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){
            datos = JSON.parse(datos);
            $("#myModalMatriculaNovedadGrupo").modal("hide");
            var id_programa_ac=datos["0"]["0"];
            var id_estudiante=datos["0"]["1"];
            alertify.success("Cambio Correcto");
            mostrarmaterias(id_programa_ac,id_estudiante);
        }
   });
}
function nota(val,c,id,pro,tl) {
	if (val.length <= 4) {
		if (val <= 5.0 && val >= 0) {
			//console.log(nota);
			$.post("../controlador/consultaacademica.php?op=nota", { id: id, nota: val, tl: tl, c: c, pro: pro }, function (data) {
				//console.log(data);
				var r = JSON.parse(data);
				if (r.status == "ok") {
					alertify.success("Nota agregada con exito");
					mostrarmaterias(id_programa_ac_,id_estudiante_,ciclo_);
				} else {
					alertify.error("Error al agregar la nota");
				}
			});
		} else {
			alertify.error("Coloca una nota valida");
		}
	} else {
		alertify.error("Coloca una nota valida");
	}
}
function promedio(val,c,id) {
	if (val.length <= 4) {
		if (val <= 5.0 && val >= 0) {
			//console.log(nota);
			$.post("../controlador/consultaacademica.php?op=promedio", { id: id, val: val, c: c }, function (data) {
				console.log(data);
				var r = JSON.parse(data);
				if (r.status == "ok") {
					alertify.success("Promedio agregado con exito");
					mostrarmaterias(id_programa_ac_, id_estudiante_, ciclo_);
				} else {
					alertify.error(r.status);
				}
			});
		} else {
			alertify.error("Coloca una nota valida");
		}
	} else {
		alertify.error("Coloca una nota valida");
	}
}
function huella(valor,id,c) {
	$.post("../controlador/consultaacademica.php?op=huella", { id: id, val: valor, c:c }, function (data) {
		//console.log(data);
		var r = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("Huella agregada con exito");
			mostrarmaterias(id_programa_ac_, id_estudiante_, ciclo_);
		} else {
			alertify.error(r.status);
		}
	});
}
init();