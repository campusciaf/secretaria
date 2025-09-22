var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	Listar_empresa();
	$("#formulario_crearyeditarofertaslaborales").on("submit", function (e) {
		guardaryeditareditarempresa(e);
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
function Listar_empresa() {
	var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	var diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
	var f = new Date();
	var fecha_hoy = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();

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
					'<div style="width:50%;float:left"><b>Asesor:</b> primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Ejes",
				titleAttr: "Print"
			}
		],
		ajax: {
			url: "../controlador/listado_empresa.php?op=Listar_empresa",
			type: "get",
			dataType: "json",
			error: function (e) {}
		},
		bDestroy: true,
		iDisplayLength: 10,
		order: [[6, "asc"]],
		initComplete: function (settings, json) {
			$("#precarga").hide();
		}
	});
}

function mostrar_empresa(id_usuario) {
    $("#btnagregar").hide();
    $.post(
        "../controlador/listado_empresa.php?op=mostrar_empresa",
        { id_usuario: id_usuario },
        function (data) {
            console.log(data); // Verifica el contenido de la respuesta
            data = JSON.parse(data);
            if (Object.keys(data).length > 0) {
                $("#listadoregistros").hide();
                $("#formularioregistros").show();
                $("#usuario_nit").val(data.usuario_nit);
                $("#usuario_nombre").val(data.usuario_nombre);
                $("#usuario_area_ss").val(data.usuario_area_ss);
                $("#usuario_representante").val(data.usuario_representante);
                $("#usuario_celular").val(data.usuario_celular); // Aquí se asigna el valor
                $("#usuario_horario_pactado").val(data.usuario_horario_pactado);
                $("#id_usuario").val(data.id_usuario);
            }
        }
    );
}

function limpiar() {
	$("#usuario_nit").val("");
	$("#usuario_nombre").val("");
	$("#usuario_area_ss").val("");
	$("#usuario_representante").val("");
	$("#usuario_celular").val("");
	$("#usuario_horario_pactado").val("");
	$("#id_usuario").val("");
}

function guardaryeditareditarempresa(e) {
	e.preventDefault();
	$("#btnGuardarAccion").prop("disabled", true);
	var formData = new FormData($("#formulario_crearyeditarofertaslaborales")[0]);
	$.ajax({
		"url": "../controlador/listado_empresa.php?op=guardaryeditareditarempresa",
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
function eliminar(id_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la empresa?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/listado_empresa.php?op=eliminar", {id_usuario : id_usuario}, function(e){
				
				if(e == 'null'){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "empresa eliminada con éxito.",
						icon: "success"
					  });

					$('#tblistaofertalaboral').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "la empresa no se puede eliminar.",
						icon: "error"
					  });
				}
        	});

		} else if (
		  /* Read more about handling dismissals below */
		  result.dismiss === Swal.DismissReason.cancel
		) {
		  swalWithBootstrapButtons.fire({
			title: "Cancelado",
			text: "Tu proceso está a salvo :)",
			icon: "error"
		  });
		}
	  });
}	


function listar_postulados(id_usuario) {
    $("#precarga").show();
    $.post(
        "../controlador/listado_empresa.php?op=mostrar_listado_postulados",
        { id_usuario: id_usuario }, 
        function (e) {
            var r = JSON.parse(e);
            if (r.error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: r.error,
                });
                $("#precarga").hide();
                return;
            }
            $("#usuarios_postulados").html(r[0]);
            $("#ModalListarPostulados").modal("show");
            $("#precarga").hide();
            $("#mostrarusuariospostulados").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class="text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}
init();
