$(document).ready(incio);
function incio() {
	$("#precarga").hide();
    historialReservas()

}
function historialReservas() {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#table_histo_reservas').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
			url: '../controlador/reserva_general.php?op=historialReservas',
			error: function (e) {
                // console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
			scroll(0, 0);
		},
	});
}

// para visualizar el formulario.
function mostrar_datos_personales_usuarios(){
    $.post("../controlador/reserva_general.php?op=mostrar_datos_personales_usuarios",{},function(data){
        // console.log(data);
        data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#nombre_docente").val(data.usuario_nombre + " " + data.usuario_nombre_2 + " " + data.usuario_apellido + " " + data.usuario_apellido_2);
			$("#correo_docente").val(data.usuario_email);
			$("#telefono_docente").val(data.usuario_celular);
		}
	});
}


function mostrarReserva(id){
    $.post("../controlador/reserva_general.php?op=mostrar_reserva_por_id",{id: id},function(data){
        // console.log(data);
        data = JSON.parse(data);
			if(Object.keys(data).length > 0){
            $("#estado_formulario").val(data.estado_formulario);

            aplicarEstadoFormulario();
            $("#nombre_docente").val(data.nombre_docente);
            $("#correo_docente").val(data.correo_docente);
            $("#telefono_docente").val(data.telefono_docente);
            $("#motivo_reserva").val(data.detalle_reserva);
            $("#fecha_reserva").val(data.fecha_reserva);
            $("#startTime").val(data.horario);
            $("#endTime").val(data.hora_f);
            $("#programa").val(data.programa);
            $("#programa_otro").val(data.programa_otro);
            $("#asistentes").val(data.asistentes);
            $("#asistentes_otro").val(data.asistentes_otro);
            $("#materia_evento").val(data.materia_evento);
            $("#experiencia_nombre").val(data.experiencia_nombre);
            $("#experiencia_objetivo").val(data.experiencia_objetivo);
            $("#duracion_horas").val(data.duracion_horas);
            $("#lugar").val(data.lugar);
            // traemos el valor del campo otro cuando esta seleccionado.
            $("#lugar").val(data.lugar).trigger("change");
            if(data.lugar === "otro"){
                $("#lugar_otro").val(data.lugar_otro);
            }
            $("#asistentes").val(data.asistentes).trigger("change");
            if(data.asistentes === "otro"){
                $("#asistentes_otro").val(data.asistentes_otro);
            }
            $("#programa").val(data.programa).trigger("change");
            if(data.programa === "otro"){
                $("#programa_otro").val(data.programa_otro);
            }
            //traemos y marcamos los requerimientos
            if (data.requerimientos) {
                let reqs = Array.isArray(data.requerimientos) ? data.requerimientos : data.requerimientos.split(",");
                $("input[name='requerimientos[]']").prop("checked", false);
                reqs.forEach(r => {
                    $(`input[name='requerimientos[]'][value='${r.trim()}']`).prop("checked", true);
                });
            }
            $("#requerimientos_otro").val(data.requerimientos_otro);
            $("#novedad").val(data.novedad);
        }
    });
}

function aplicarEstadoFormulario() {
    // mostrar_datos_personales_usuarios();
    var estado = $("#estado_formulario").val();
    if (estado == "1") {
        $("#lugar").on("change", ocultarLugar);
        $("#programa").on("change", ocultarPrograma);
        $("#asistentes").on("change", ocultarAsistentes);
        // campos requeridos para el formulario cuando es igual a 1
        $("#ocultar_campos_formulario").show();
        $("#ocultar_campos_formulario_normal").hide();
        $("#startTime").prop("disabled", false).prop("required", true);
        $("#endTime").prop("disabled", false).prop("required", true);
        $("#nombre_docente").prop("disabled", false).prop("required", true);
        $("#correo_docente").prop("disabled", false).prop("required", true);
        $("#telefono_docente").prop("disabled", false).prop("required", true);
        $("#programa").prop("disabled", false).prop("required", true);
        $("#asistentes").prop("disabled", false).prop("required", true);
        $("#materia_evento").prop("disabled", false).prop("required", true);
        $("#duracion_horas").prop("disabled", false).prop("required", true);
        $("#lugar").prop("disabled", false).prop("required", true);
        $("#experiencia_nombre").prop("disabled", false).prop("required", true);
        $("#experiencia_objetivo").prop("disabled", false).prop("required", true);
        $("#fecha_reserva").prop("disabled", false).prop("required", true);
        $("#novedad").prop("disabled", false).prop("required", true);
        // ocultamos los campos que no necesitamos
        $("#motivo_reserva").prop("disabled", true).prop("required", false).val("");

    } else {
        // campos que mostramos.
        $("#ocultar_campos_formulario_normal").show();
        $("#ocultar_campos_formulario").hide();
        $("#motivo_reserva").prop("disabled", false).prop("required", true);
        $("#startTime").prop("disabled", false).prop("required", true);
        $("#endTime").prop("disabled", false).prop("required", true);
        $("#fecha_reserva").prop("disabled", false).prop("required", true);
        //en caso de que sea 0 deshabilitamos los campos del formulario para solo dejarlos los que estaban antes.
        $("#nombre_docente").prop("disabled", true).prop("required", false).val("");
        $("#correo_docente").prop("disabled", true).prop("required", false).val("");
        $("#telefono_docente").prop("disabled", true).prop("required", false).val("");
        $("#programa").prop("disabled", true).prop("required", false).val("");
        $("#asistentes").prop("disabled", true).prop("required", false).val("");
        $("#materia_evento").prop("disabled", true).prop("required", false).val("");
        $("#duracion_horas").prop("disabled", true).prop("required", false).val("");
        $("#lugar").prop("disabled", true).prop("required", false).val("");
        $("#experiencia_nombre").prop("disabled", true).prop("required", false).val("");
        $("#experiencia_objetivo").prop("disabled", true).prop("required", false).val("");
        $("#novedad").prop("disabled", true).prop("required", false).val("");
    }
}


function ocultarLugar() {
    if ($("#lugar").val() === "otro") {
        $("#lugar_otro_wrap").removeClass("d-none");
        $("#lugar_otro").prop("required", true);
    } else {
        $("#lugar_otro_wrap").addClass("d-none");
        $("#lugar_otro").prop("required", false).val("");
    }
}

function ocultarPrograma() {
    if ($("#programa").val() === "otro") {
        $("#programa_otro_wrap").removeClass("d-none");
        $("#programa_otro").prop("required", true);
    } else {
        $("#programa_otro_wrap").addClass("d-none");
        $("#programa_otro").prop("required", false).val("");
    }
}

function ocultarAsistentes() {
    if ($("#asistentes").val() === "otro") {
        $("#asistentes_otro_wrap").removeClass("d-none");
        $("#asistentes_otro").prop("required", true);
    } else {
        $("#asistentes_otro_wrap").addClass("d-none");
        $("#asistentes_otro").prop("required", false).val("");
    }
}




