var departamento_global;
var valor_global;
var global_id_credencial;
var global_credencial_login;
var global_estado_correo;
var global_id_estudiante;
var global_jornada;
var global_semestre_estudiante;
var global_perido;
var global_id_programa_ac;

function init() {
	$("#mostrar_formulario_estudiante").hide();
	$("#precarga").hide();
}
init();
function verificar_estudiante() {
	var dato = $("#dato_estudiante").val();
    var tipo = $("#tipo").val();
    if (dato != "" && tipo != "") {
		$.post(
			"../controlador/veedores.php?op=verificar_estudiante",
			{ "dato": dato,"tipo": tipo},
			function (data) {
				data = JSON.parse(data);
				if (data.exito == 1) {
					global_id_credencial =data.info.id_credencial;
					global_id_estudiante =data.info.id_estudiante;
					global_credencial_login =data.info.credencial_login;
					global_jornada =data.info.jornada;
					global_semestre_estudiante =data.info.semestre_estudiante;
					global_perido =data.info.perido;
					global_id_programa_ac =data.info.id_programa_ac;
					global_estado_correo =data.info.estado_correo;
					$(".box_nombre_estudiante").html(data.info.credencial_nombre+" "+data.info.credencial_nombre_2+" "+data.info.credencial_apellido+" "+data.info.credencial_apellido_2);
					$(".box_correo_electronico").html(data.info.credencial_login);
					$(".box_celular").html(data.info.celular);
					$(".box_jornada_e").html(data.info.jornada);
					$(".box_semestre_estudiante").html(data.info.semestre_estudiante);
                    listarEstudiante();
				} 
				else {
					Swal.fire({
						icon: "error",
						title: data.info,
						showConfirmButton: false,
						timer: 1500,
					});
				}
			}
		);
	}
}
function filtroportipo(valor) {
    $("#dato_estudiante").prop("disabled", false);
    $("#btnconsulta").prop("disabled", false);
    $("#input_dato_estudiante").show();
    $("#dato_estudiante").val("");
    $("#tipo").val(valor);
	valor_global = valor;
    if(valor == 1){
        $("#valortituloestudiante").html("Ingresar número de identificación")
        $("#ocultar_tabla").hide();
        $("#mostrar_datos_estudiante").show();
    }
    if(valor == 2){
        $("#valortituloestudiante").html("Ingresar nombre")
        $("#ocultar_tabla").show();
        $("#mostrar_datos_estudiante").hide();
    }
}

function enviarcorreo() {
    swal({
        "title": "",
        "text": "¿Estás seguro de Enviar el correo?",
        "icon": "warning",
        "buttons": ["Cancelar", "Enviar"],
        "dangerMode": true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#precarga").removeClass("hide");
			
            var data = {
                'global_id_credencial': global_id_credencial,
                'global_id_estudiante': global_id_estudiante,
                'global_jornada': global_jornada,
                'global_semestre_estudiante': global_semestre_estudiante,
                'global_perido': global_perido,
                'global_credencial_login': global_credencial_login,
				'global_id_programa_ac': global_id_programa_ac
				
            };
            $.ajax({
                "url": "../controlador/veedores.php?op=enviar_correo",
                "type": "POST",
                "data": data,
                success: function (datos) {
                    var r = JSON.parse(datos);
                    if (r.exito == "1") {
                        swal("Correo enviado correctamente", { "icon": "success" })
                            .then((value) => {
                                // Actualizar la página o hacer alguna otra acción necesaria
                                location.reload();
                            });
                    } else {
                        swal("Error al enviar la invitación", r.info, { "icon": "error" })
                            .then((value) => {
                                // Hacer alguna acción necesaria si hay un error
                            });
                    }
                    $("#precarga").addClass("hide");
                },
                error: function () {
                    // Manejar el error si la solicitud Ajax falla
                    swal("Error", "Hubo un problema al enviar la solicitud.", { "icon": "error" });
                    $("#precarga").addClass("hide");
                }
            });
        }
    });
}

function listarEstudiante() {

    var dato = $("#dato_estudiante").val();
    $("#mostrar_formulario_estudiante").hide();
    var tabla_estudiantes = $("#datos_estudiantes").DataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "Bfrtip", //Definimos los elementos del control de tabla
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": "Excel",
            "exportOptions": {
                "columns": ":visible",
            },
        }],
        "ajax": {
            // Modificamos la URL para incluir el ID de la credencial como un parámetro
            "url": "../controlador/veedores.php?op=listar_datos_estudiantes_filtrado&valor_global=" + valor_global+"&dato=" + dato,
            "type": "get",
            "type": "get",
            "dataType": "json",
            error: function(e) { 
            },
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [[1, "asc"]],
        "initComplete": function(settings, json) {
            $("#precarga").hide();
        }
    });
}


function enviarcorreopornombre(id_credencial_seleccionado,credencial_login_seleccionado) {
    swal({
        "title": "",
        "text": "¿Estás seguro de Enviar el correo?",
        "icon": "warning",
        "buttons": ["Cancelar", "Enviar"],
        "dangerMode": true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#precarga").removeClass("hide");
			
            var data = {
                'id_credencial_seleccionado': id_credencial_seleccionado,
                'credencial_login_seleccionado': credencial_login_seleccionado
				
            };
            $.ajax({
                "url": "../controlador/veedores.php?op=enviar_correo_por_nombre",
                "type": "POST",
                "data": data,
                success: function (datos) {
                    var r = JSON.parse(datos);
                    if (r.exito == "1") {
                        swal("Correo enviado correctamente", { "icon": "success" })
                            .then((value) => {
                                // Actualizar la página o hacer alguna otra acción necesaria
                                location.reload();
                            });
                    } else {
                        swal("Error al enviar la invitación", r.info, { "icon": "error" })
                            .then((value) => {
                                // Hacer alguna acción necesaria si hay un error
                            });
                    }
                    $("#precarga").addClass("hide");
                },
                error: function () {
                    // Manejar el error si la solicitud Ajax falla
                    swal("Error", "Hubo un problema al enviar la solicitud.", { "icon": "error" });
                    $("#precarga").addClass("hide");
                }
            });
        }
    });
}


function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Veedores',
				intro: 'Da un vistazo a nuestro modulo donde podrás enviar un correo a los veedores.'
			},
			{
				title: 'Filtro Estudiante',
				element: document.querySelector('#buscar_estudiante'),
				intro: "Aquí podrás filtrar por medio de nombre y cedula el estudiante al cual se le enviara el correo."
			},
			{
				title: 'Filtro Estudiante',
				element: document.querySelector('#tour_btn_enviar'),
				intro: "Aquí podrás enviar el correo al estudiante."
			},
		]
			
	},
	).start();

}

