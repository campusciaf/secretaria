var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar_ofertas();
	$("#formulario_crearyeditarofertaslaborales").on("submit", function (e) {
		guardaryeditarofertalaboral(e);
	});
	$.post("../controlador/bolsa_empleo_ofertas.php?op=ListarEmpresas", function (r) {
		$("#id_usuario").html(r);
		$('#id_usuario').selectpicker('refresh');
	});
	$.post("../controlador/bolsa_empleo_ofertas.php?op=ListarProgramas", function (r) {
		$("#programa_estudio").html(r);
		$('#programa_estudio').selectpicker('refresh');
	});

	$("#motivo_eliminacion").on("submit", function (e) {
		registrar_motivo_eliminacion(e);
	});
}
function mostrarform(flag) {
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
function cancelarform() {
	limpiar();
	mostrarform(false);
}
//Función Listar ofertas
function listar_ofertas() {
	var meses = new Array(
		"Enero",
		"Febrero",
		"Marzo",
		"Abril",
		"Mayo",
		"Junio",
		"Julio",
		"Agosto",
		"Septiembre",
		"Octubre",
		"Noviembre",
		"Diciembre"
	);
	var diasSemana = new Array(
		"Domingo",
		"Lunes",
		"Martes",
		"Miércoles",
		"Jueves",
		"Viernes",
		"Sábado"
	);
	var f = new Date();
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();
	tabla = $("#tblistaofertalaboral").dataTable({
		aProcessing: true,
		aServerSide: true,
		dom: "Bfrtip",
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel"
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Ejes",
				titleAttr: "Print"
			}
		],
		ajax: {
			url: "../controlador/bolsa_empleo_ofertas.php?op=listar_ofertas_laborales",
			type: "get",
			dataType: "json",
			error: function (e) {
			}
		},
		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[6, "asc"]],
		initComplete: function (settings, json) {
			$("#precarga").hide();
		}
	});
}
function mostrar_ofertas_laborales(id_bolsa_empleo_oferta) {
	$("#btnagregar").hide();
	$.post(
		"../controlador/bolsa_empleo_ofertas.php?op=mostrar_ofertas_laborales",
		{ id_bolsa_empleo_oferta: id_bolsa_empleo_oferta },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#listadoregistros").hide();
				$("#formularioregistros").show();
				// datos empresa
				$("#tipo_contrato").val(data.tipo_contrato);
				$("#tipo_contrato").selectpicker('refresh');
				$("#salario").val(data.salario);
				$("#modalidad_trabajo").val(data.modalidad_trabajo);
				$("#modalidad_trabajo").selectpicker('refresh');
				$("#ciclo_propedeutico").val(data.ciclo_propedeutico);
				$("#ciclo_propedeutico").selectpicker('refresh');
				// perfil
				$("#id_usuario").val(data.id_usuario);
				$("#id_usuario").selectpicker('refresh');
				$("#cargo").val(data.cargo);
				$("#programa_estudio").val(data.programa_estudio);
				$("#programa_estudio").selectpicker('refresh');
				$("#perfil_oferta").val(data.perfil);
				$("#funciones").val(data.funciones);
				$("#fecha_contratacion").val(data.fecha_contratacion);
				// valida si entra en agregar o editar
				$("#id_bolsa_empleo_oferta").val(data.id_bolsa_empleo_oferta);
			}
		}
	);
}
function limpiar() {
	$("#tipo_contrato").val("");
	$("#salario").val("");
	$("#modalidad_trabajo").val("");
	$("#ciclo_propedeutico").val("");
	$("#id_usuario").val("");
	$("#id_usuario").selectpicker('refresh');
	$("#cargo").val("");
	$("#programa_estudio").val("");
	$("#programa_estudio").selectpicker('refresh');
	$("#perfil_oferta").val("");
	$("#funciones").val("");
	$("#fecha_contratacion").val("");
	$("#id_bolsa_empleo_oferta").val("");
}

// function guardaryeditarofertalaboral(e) {
// 	e.preventDefault();
// 	$("#btnGuardarAccion").prop("disabled", true);
// 	var formData = new FormData($("#formulario_crearyeditarofertaslaborales")[0]);
// 	$.ajax({
// 		"url": "../controlador/bolsa_empleo_ofertas.php?op=guardaryeditareditarofertalaboral",
// 		"type": "POST",
// 		"data": formData,
// 		"contentType": false,
// 		"processData": false,
// 		success: function (datos) {
// 			$("#listadoregistros").show();
// 			$("#btnagregar").show();
// 			$("#formularioregistros").hide();
// 			Swal.fire({
// 				position: "top-end",
// 				icon: "success",
// 				title: "Oferta Laboral Actualizada",
// 				showConfirmButton: false,
// 				timer: 1500
// 			});
// 			$("#tblistaofertalaboral").DataTable().ajax.reload();
// 		}
// 	});
// }

function guardaryeditarofertalaboral(e) {
	e.preventDefault();
	$("#btnGuardarAccion").prop("disabled", true);
	var formData = new FormData($("#formulario_crearyeditarofertaslaborales")[0]);
	$.ajax({
		"url": "../controlador/bolsa_empleo_ofertas.php?op=guardaryeditareditarofertalaboral",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			$("#listadoregistros").show();
			$("#btnagregar").show();
			$("#formularioregistros").hide();
			if(datos.exito == 1){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Datos guardados correctamente",
					showConfirmButton: false,
					timer: 1500
				});
				$("#tblistaofertalaboral").DataTable().ajax.reload();
			}else{
				Swal.fire({
					position: "top-end",
					icon: "error",
					title: "Error al guardar los datos",
					showConfirmButton: false,
					timer: 1500
				});
			}
		}
	});
}


function desactivar_oferta(id_bolsa_empleo_oferta) {
	$("#id_bolsa_empleo_oferta_desactivar_oferta").val(id_bolsa_empleo_oferta);
	$("#ModalMotivoEliminarPostulacion").modal("show");
}


function registrar_motivo_eliminacion(e) {
	e.preventDefault();
	$("#btnGuardarAccion").prop("disabled", true);
	var formData = new FormData($("#motivo_eliminacion")[0]);
	$.ajax({
		"url": "../controlador/bolsa_empleo_ofertas.php?op=registrar_motivo_eliminacion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			$("#ModalMotivoEliminarPostulacion").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Oferta Laboral Eliminada",
				showConfirmButton: false,
				timer: 1500
			});
			$("#tblistaofertalaboral").DataTable().ajax.reload();
		}
	});
}



//mostramos los usuarios postulados para esa oferta
function listar_postulados(id_bolsa_empleo_oferta) {
	$("#precarga").show();
	$.post(
		"../controlador/bolsa_empleo_ofertas.php?op=mostrar_listado_postulados",
		{ id_bolsa_empleo_oferta: id_bolsa_empleo_oferta },
		function (e) {
			var r = JSON.parse(e);
			$("#usuarios_postulados").html(r[0]);
			$("#ModalListarPostulados").modal("show");
			$("#precarga").hide();
			$("#mostrarusuariospostulados").dataTable({
				dom: "Bfrtip",
				buttons: [
					{
						extend: "excelHtml5",
						text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: "Excel",
					},
				],
			});
		}
	);
}

function iniciarTour() {
	introJs()
		.setOptions(
			{
				nextLabel: "Siguiente",
				prevLabel: "Anterior",
				doneLabel: "Terminar",
				showBullets: false,
				showProgress: true,
				showStepNumbers: true,
				steps: [
					{
						title: "Usuarios",
						intro:
							"Bienvenido a nuestra gestión de usuarios que hacen parte de nuestra comunidad CIAF"
					}
				]
			},
		)
		.start();
}
init();
