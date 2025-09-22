var global_id_credencial;
var global_cedula;
var global_id_ubicacion;
var global_usuario_login;
var id_usuario_global;

$(document).ready(incio);
function incio() {
    $("#precarga").hide();
}
function consultaEstudiante() {
    //cedula 
	var dato = $("#dato_estudiante").val();
    //tipo de usuario(estudiante, funcionario, docente) 
    var ubicacion = $("#ubicacion").val();
    //nav de identificacion y correo.
    var seleccion_nav = $("#tipo").val();
    if (dato != "" && ubicacion != "" && seleccion_nav != "") {
		$.post(
			"../controlador/restaurar_contrasena.php?op=consultaEstudiante",
			{ "dato": dato,"ubicacion": ubicacion,"seleccion_nav": seleccion_nav },
			function (data) {
                // console.log(data);
				data = JSON.parse(data);
                if (data.exito == 1) {
                    global_id_credencial = data.info.id_credencial;
                    id_usuario_global = data.info.id_usuario;
                    global_id_ubicacion = ubicacion;
                    if (ubicacion == "1") {
                        $(".box_nombre_estudiante").html(data.info.credencial_nombre + " " + data.info.credencial_nombre_2 + " " + data.info.credencial_apellido + " " + data.info.credencial_apellido_2);
                        $(".box_correo_electronico").html(data.info.credencial_login);
                        global_cedula = data.info.credencial_identificacion;
                        global_usuario_login = data.info.credencial_login;
                        } else if (ubicacion == "3" || ubicacion == "2") { // Corrección aquí: uso de else if en lugar de elseif
                            $(".box_nombre_estudiante").html(data.info.usuario_nombre + " " + data.info.usuario_nombre_2 + " " + data.info.usuario_apellido + " " + data.info.usuario_apellido_2);
                            $(".box_correo_electronico").html(data.info.usuario_login);
                            global_cedula = data.info.usuario_identificacion;
                            global_usuario_login = data.info.usuario_login;
                    }
				} else {
					Swal.fire({
						icon: "error",
						title: data.info,
						showConfirmButton: false,
						timer: 1500,
					});
				}
			}
		);
	}else{
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Por favor completa los campos.",
			showConfirmButton: false,
			timer: 1500
		});
    }
}
function restablecer() {


    
    swal({
        "title": "",
        "text": "¿Estás seguro de restablecer la contraseña?",
        "icon": "warning",
        "buttons": ["Cancelar", "Restablecer"],
        "dangerMode": true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#precarga").removeClass("hide");
            enviar_correo = ($('#enviar_correo').prop('checked'))?1:0;
            var data = ({ 'global_id_credencial': global_id_credencial, 'global_cedula': global_cedula, 'global_id_ubicacion': global_id_ubicacion, "global_usuario_login": global_usuario_login, "enviar_correo": enviar_correo, "id_usuario_global": id_usuario_global });
            $.ajax({
                "url": "../controlador/restaurar_contrasena.php?op=restablecer",
                "type": "POST",
                "data": data,
                success: function (datos) {
                    // console.log(datos);
                    var r = JSON.parse(datos);
                    if (r.exito == 1) {
                        $("#precarga").addClass("hide");
                        swal(r.info, { "icon": "success" });
                        consultaEstudiante();
                    } else {
                        swal(r.info, { "icon": "error" });
                    }
                }
            });
        }
    });
}
function filtroportipo(valor) {
    // habilitamos los botones para poder buscar.
    $('#ubicacion').prop('disabled', false).selectpicker('refresh');
    $("#dato_estudiante").prop("disabled", false);
    $("#btnconsulta").prop("disabled", false);
    $("#input_dato_estudiante").show();
    //utilizamos el val para cuando cambian de valor se reinicie el texto que sale en el input
    $("#dato_estudiante").val("");
    $("#tipo").val(valor);
    if(valor == 1){
        $("#valortituloestudiante").html("Identificación");
    } else if(valor == 2){
        $("#valortituloestudiante").html("Ingresar correo");
    }
}
