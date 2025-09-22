
var id_ = "";
var ciclo_ = "";
var materia_ = "";
var jornada_ = "";
var id_programa = "";
var grupo = "";

function listar(id,ciclo,materia,jornada,id_programa,grupo)
{

	id_ = id;
	ciclo_ = ciclo;
	materia_ = materia;
	jornada_ = jornada;	
	id_programa_ = id_programa;
	grupo_ = grupo;

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	var fe = moment().format("YYYY-MM-DD");
	$("#fecha").val(fe);
	//console.log(fe);
	
		var nombre_programa="";
	$.get("../controlador/docente.php?op=programa",{id_programa:id_programa},function(datos, status){

		nombre_programa=datos;
		
	});
	

	$.get("../controlador/docente.php?op=listar",{id:id , ciclo:ciclo, materia: materia, jornada:jornada, id_programa:id_programa, grupo:grupo },function(data, status){
	//console.log(data);
	data = JSON.parse(data);
	
	
	$("#tllistado").hide();	// ocultamos los pea		
	$("#tbllistado").html("");
	$("#tbllistado").append(data["0"]["0"]);
		$(document).ready(function() {
			$('#example').DataTable( {
				"paging":   false,
				"searching": false,
				 "scrollX": true,
				"order":[[1,'asc']],
				fixedHeader: {
					header: true,
					footer: false
					
				},
//				dom: 'Bfrtip',
//				buttons: [
//
//					{
//						extend:    'excelHtml5',
//						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
//						titleAttr: 'Excel'
//					},
//
//					{
//						extend: 'print',
//						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
//						messageTop: '<div style="width:50%;float:left"><b>Programa: </b>'+nombre_programa+'<br><b>Asignatura:</b> '+materia+'<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
//						messageBottom: '<div style="width:50%;float:left"><br><br><br><br><br>______________________________<br><b>Firma docente</b>: </div>',
//						title: 'Reporte Notas',
//						titleAttr: 'Imprimir'
//					},
//				],
				"language":{ 
					"url": "../public/datatables/idioma/Spanish.json"
				},
				columnDefs: [

				{ className: 'text-center', targets: [1,2,3,4,5,6] },
			  ]



			} );
		} );
	});
}

function modalFalta(ciclo,id_estudiante,id_programa,id_materia) {
	$("#ciclo").data("ciclo",ciclo);
	$("#id_estudiante").data("id_estudiante",id_estudiante);
	$("#id_programa").data("id_programa", id_programa);
	$("#id_materia").data("id_materia", id_materia);
	$("#modalFaltas").modal("show");
}
function registraFalta() {
	if ($("#fecha").val() !== "") {
		var data = ({
			'ciclo': $("#ciclo").data("ciclo"),
			'id_estudiante': $("#id_estudiante").data("id_estudiante"),
			'id_programa': $("#id_programa").data("id_programa"),
			'id_materia': $("#id_materia").data("id_materia"),
			'programa': $("#materia").val(),
			'fecha': $("#fecha").val()
		});

		$.ajax({
			url: "../controlador/docente.php?op=aggfalta",
			type: "POST",
			data: data,
			cdataType: 'json',
			success: function (datos) {
				var r = JSON.parse(datos);
				console.log(r);
				if (r.status == 'existe') {
					alertify.error("El estudiante ya cuenta con esa falta");
				} else {
					if (r.status == 'ok') {
						alertify.success("Falta registrada");
						var url = dividirCadena(location.href, "?");
						$.get("../controlador/docente.php?op=listar&" + url, function (r, status) {
							var dato = JSON.parse(r);
							console.log(dato);
							$("#tllistado").hide();	// ocultamos los pea		
							$("#tbllistado").html("");
							$("#tbllistado").append(dato["0"]["0"]);

							$(document).ready(function () {
								$('#example').DataTable({
									"paging": false,
									"searching": false,
									"scrollX": true,
									"order": [[1, 'asc']],
									fixedHeader: {
										header: true,
										footer: false

									},
									dom: 'Bfrtip',
									buttons: [

										{
											extend: 'excelHtml5',
											text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
											titleAttr: 'Excel'
										},

										{
											extend: 'print',
											text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
											messageTop: '<div style="width:50%;float:left">Reporte perfil estudiante<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
											title: 'Materias Matriculadas',
											titleAttr: 'Print'
										},
									],
									"language": {
										"url": "../public/datatables/idioma/Spanish.json"
									},
									columnDefs: [

										{ className: 'text-center', targets: [1, 2, 3, 4, 5, 6] },
									]



								});
							});

						});

						$("#modalFaltas").modal('hide');
						$("#fecha").val("");

					} else {
						alertify.error("Error al registrar la falta");
					}
				}


			}
		});	
	}else{
		alertify.error("Completa el campo fecha.");
	}

}


function consulta(ciclo,jornada,id_programa,grupo,medio) {
	var data = ({
		'ciclo': ciclo,
		'materia': $("#materia").val(),
		'jornada': jornada,
		'id_programa': id_programa,
		'grupo': grupo,
		'medio': medio
	});
	//console.table(data);
	$("#modalReportes").modal('show');
	if ($.fn.DataTable.isDataTable('#tbl_listar')) {
		$('#tbl_listar').DataTable().destroy();
	}
	$.ajax({
		url: "../controlador/docente.php?op=consultaEstudiante",
		type: "POST",
		data: data,
		cdataType: 'json',
		success: function (datos){
			//console.log(datos);
			var r = JSON.parse(datos);
			$(".prueba").html(r.table);
			//$(document).ready(function (){
				$('#tbl_listar').dataTable({
					"paging": true,
					"searching": false,
					"autoWidth": false,
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'print',
							text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
							messageTop: '<div style="width:50%;float:left" > <b>Docente:</b> ' + r.docente + ' <br/><b>Programa:</b>' + r.programa + '  <br/><b>Jornada: </b>' + r.jornada + ' <br/><b>Asignatura: </b>' + r.materia + ' <br/><b>Fecha reporte: </b>' + r.fecha + ' <br/>  <br/> </div> <div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="280px"></div>',
							title: ' Horarios asiganados fin de semana',
							titleAttr: 'Print'
						},
					],
					 "order": [[1, "asc"]]
				});
			//});
			

		}
	});
}

function consultaAsistecia(ciclo, jornada, id_programa, grupo, medio) {
	var data = ({
		'ciclo': ciclo,
		'materia': $("#materia").val(),
		'jornada': jornada,
		'id_programa': id_programa,
		'grupo': grupo,
		'medio': medio
	});
	//console.table(data);
	$("#modalReportes").modal('show');
	if ($.fn.DataTable.isDataTable('#tbl_listar')) {
		$('#tbl_listar').DataTable().destroy();
	}
	$.ajax({
		url: "../controlador/docente.php?op=consultaEstudiante",
		type: "POST",
		data: data,
		cdataType: 'json',
		success: function (datos) {
			
			//console.log(datos);
			var r = JSON.parse(datos);
			$(".prueba").html(r.table);
			$(document).ready(function () {
				$('#tbl_listar').dataTable({

					"paging": true,
					"searching": false,
					"autoWidth": false,
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'print',
							text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
							messageTop: '<div style="width:50%;float:left" > <b>Docente:</b> ' + r.docente + ' <br/><b>Programa:</b>' + r.programa + '  <br/><b>Jornada: </b>' + r.jornada + ' <br/><b>Asignatura: </b>' + r.materia + ' <br/><b>Fecha reporte: </b>' + r.fecha + ' <br/>  <br/> </div> <div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="280px"></div>',
							title: ' Horarios asiganados fin de semana',
							titleAttr: 'Print'
						},
					]
				});
			});


		}
	});
}



function reporteFinal(id_docente,ciclo,materia,jornada,id_programa,grupo) {
	var data = ({
		'id_docente': id_docente,
		'ciclo': ciclo,
		'materia': materia,
		'jornada': jornada,
		'id_programa': id_programa,
		'grupo': grupo
	});
	//console.table(data);
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	$("#modalReportes").modal('show');
	if ($.fn.DataTable.isDataTable('#tbl_listar')) {
		$('#tbl_listar').DataTable().destroy();
	}
	$.ajax({
		url: "../controlador/docente.php?op=consultaReporteFinal",
		type: "POST",
		data: data,
		cdataType: 'json',
		success: function (datos) {
			
			
			var r = JSON.parse(datos);
			//console.log(datos);
			$(".prueba").html(r.table);
			$(document).ready(function () {
				$('#tbl_listar').dataTable({

					"paging": true,
					"searching": false,
					"autoWidth": false,
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'print',
							text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
							messageTop: '<div style="width:50%;float:left" > <b>Docente:</b> ' + r.docente + ' <br/><b>Programa:</b>' + r.programa + '  <br/><b>Jornada: </b>' + jornada + ' <br/><b>Asignatura: </b>' + materia + ' <br/><b>Fecha reporte: </b>' + fecha + ' <br/>  <br/> </div> <div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="280px"></div>',
							messageBottom: '<br><br><br><br>___________________________________<br>Firma Docente ',
							title: 'Reporte final Notas',
							titleAttr: 'Print'
						},
					],
					"order": [[ 1, "asc" ]],//Ordenar (columna,orden)
				});
			});


		}
	});
}

function enviarCorreos(ciclo, jornada, id_programa, grupo) {
	
		



	$("#enviarEmail").off("click").on("click", function () {
		var data = ({
			'ciclo': ciclo,
			'materia': $("#materia").val(),
			'jornada': jornada,
			'id_programa': id_programa,
			'grupo': grupo,
			'contenido': $("#conteMail").val()
		});

		$.ajax({
			url: "../controlador/docente.php?op=enviarCorreos",
			type: "POST",
			data: data,
			cdataType: 'json',
			success: function (datos) {
			    console.log(datos);
				var r = JSON.parse(datos);
				if (r.result == "ok") {
					$("#modalEmail").modal("hide");
					$("#conteMail").val("");
				}
			}
		});
	});


}

function nota(id,nota,tl,c) {
	
	if (nota.length <= 4) {
		if (nota <= 5.0 && nota >= 0) {
			//console.log(nota);
			$.post("../controlador/docente.php?op=nota", { id: id, nota: nota, tl: tl, c: c, pro: id_programa_} ,function (data) {
				console.log(data);
				var r = JSON.parse(data);
				if (r.status == "ok") {
					alertify.success("Nota agregada con exito");
					listar(id_,ciclo_,materia_,jornada_,id_programa_,grupo_);
				} else {
					alertify.error("Error al agregar la nota");
				}
			});
		} else {
			alertify.error("Coloca una nota valida");
		}
	}else{
		alertify.error("Coloca una nota valida");
	}
}

function dividirCadena(cadenaADividir, separador) {
	var arrayDeCadenas = cadenaADividir.split(separador);
	return arrayDeCadenas[1];
}

function hoyFecha() {
	var hoy = new Date();
	var dd = hoy.getDate();
	var mm = hoy.getMonth() + 1;
	var yyyy = hoy.getFullYear();

	dd = addZero(dd);
	mm = addZero(mm);

	var fecha = dd + '/' + mm + '/' + yyyy;
	$("#fecha").val(fecha);
}