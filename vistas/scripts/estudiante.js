$(document).ready(init);
var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
var f = new Date();
var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
var api, id_pea_ejercicios_global, id_pea_docente_global, nombre_archivo_global; 
var anchoVentana = window.innerWidth; // ancho de la ventana

	
function init() {

	iniciarhorario();

	$("#glosario").hide();
	$("#volver").hide();
	$("#formulariocrearejercicios").on("submit", function (e7) {
		guardaryeditarejercicios(e7);
	});
	$("#formularioenlace").on("submit", function (e8) {
		guardaryeditarenlace(e8);
	});
	$("#formularioenlacelink").on("submit", function (e9) {
		guardarenlacelink(e9);
	});
	$("#formularioenlacemensaje").on("submit", function (e10) {
		guardarenlacemensaje(e10);
	});

	$("#formularioenlacedocumento").on("submit", function (e11) {
		guardarenlacedocumento(e11);
	});

	$("#formulariodocumentomensaje").on("submit", function (e12) {
		guardardocumentomensaje(e12);
	});
	$("#formulariocrearvideos").on("submit", function (e7) {
		guardaryeditarvideos(e7);
	});

	


	$('#archivo_ejercicios').on('change', function () {
		var archivo = this.files[0];
		//Obtiene el nombre del archivo
		nombre_archivo_global = archivo.name;
		//Obtiene el peso del archivo  
		var tamano_archivo = archivo.size;
		// 5 MB en bytes
		var peso_maximo = 5 * 1024 * 1024; 
		// Define en un regex las extensiones permitidas
		var extensiones_permitidas = /(\.xlsx|\.xls|\.pptx|\.ppt|\.pdf|\.docx|\.doc|\.rar)$/i;
		// Si el tipo de archivo no es permitido
		if (!extensiones_permitidas.exec($(this).val())) {
			//muestra el badge que almacena el tipo de error
			$('#error_tipo').show();
			$('#error_peso').hide();
			// Limpia el input
			$(this).val(''); 
		} else if (tamano_archivo > peso_maximo) { // Si el archivo supera los 5 MB
			$('#error_peso').show();
			$('#error_tipo').hide();
			$(this).val('');
		} else {
			// Si el archivo es del tipo y tamaño adecuado
			$('#error_peso').hide();
			$('#error_tipo').hide();
		}
	});
}

function iniciarhorario() {
    $.post("../controlador/estudiante.php?op=iniciarhorario", {}, function (respuesta) {
        let datos = JSON.parse(respuesta);

        // Crear estructura de días
        const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        let horarioPorDia = {
            0: [], 1: [], 2: [], 3: [], 4: [], 5: [], 6: []
        };

        // Agrupar eventos por día
        datos.forEach(evento => {
            let dia = parseInt(evento.daysOfWeek);
            horarioPorDia[dia].push(evento);
        });

        // Crear tabla
        let tabla = '<div style="overflow-x:auto"><div class="calendario">';
        for (let i = 1; i <= 6; i++) {
            tabla += `<div class="dia" id="${dias[i].toLowerCase()}"><div class="tono-6 py-3 text-white text-center fs-18 font-weight-bolder">${dias[i]}</div>${crearBloques(horarioPorDia[i])}</div>`;
        }
        tabla += `<div class="dia" id="${dias[0].toLowerCase()}"><div class="tono-6 py-3 text-white text-center fs-18 font-weight-bolder">${dias[0]}</div>${crearBloques(horarioPorDia[0])}</div>`;
        tabla += '</div></div>';

        $('#horario').html(tabla);
        $('#horario').show();
        $("#precarga").hide();
    });
}

function crearBloques(eventos) {
    if (!eventos.length) return '<em>Sin clases</em>';

    eventos.sort((a, b) => a.startTime.localeCompare(b.startTime));

    let contenido = '';
    eventos.forEach(ev => {
        const horaInicio = convertirHora(ev.startTime);
		if(ev.corte_clase==1){
			var colortarjeta="bg-success";
		}else{
			var colortarjeta="bg-primary";
		}

        const horaFinal = convertirHora(ev.endTime);
        if (ev.cortes == 3) {
			
            contenido += `
                <div class="m-1 px-1 py-3 borde tono-3 text-center" >
                    <div class="position-absolute" style="margin-left:-8px"> ${ev.pea}</div>
                    <div class="badge badge-primary position-absolute" style="margin-left:60px" title="Faltas"> ${ev.faltas}</div>
                    <div>${ev.foto}${ev.destacado}${ev.influencer} </div>
                    <div class="fs-14 mb-2 text-secondary">${ev.docente}</div>
                    <div class="row" >
                        <div class="col-12 fs-18 line-height-16 font-weight-bolder">${ev.materia}</div>
                        <div class="col-12 text-secondary">${horaInicio} - ${horaFinal}</div>
                        <div class="col-12">Salón: ${ev.salon}</div>
						<div class="col-12 ${colortarjeta}">Corte: ${ev.corte_clase}</div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-2 text-center ">C1<br>${ev.nota1}</div>
                        <div class="col-2 text-center ">C2<br>${ev.nota2}</div>
                        <div class="col-2 text-center ">C3<br>${ev.nota3}</div>
                        <div class="col-3 text-center ">Final<br>${ev.promedio}</div>
                    </div>
                </div>
            `;
        } else {
            contenido += `
                <div class="m-1 p-2 py-3 borde tono-3" style="height:260px;">
                    <div>${ev.foto}</div>
                    <span class="fs-14">${ev.docente}</span><br>
                    <strong>${ev.materia}</strong><br>
                    ${horaInicio} - ${horaFinal}<br>
                    <small>Salón: ${ev.salon}</small><br>
                    <small></small> ${ev.nota1}</small>
                    <small> ${ev.pea}</small>
                </div>
            `;
        }
    });
    return contenido;
}

function convertirHora(hora24) {
    // Se asume formato "HH:MM"
    let partes = hora24.split(':');
    let hora = parseInt(partes[0], 10);
    const minutos = partes[1];
    const ampm = hora >= 12 ? 'PM' : 'AM';
    
    // Convertir hora de 24 a 12 horas.
    hora = hora % 12;
    hora = hora ? hora : 12; // la hora '0' se convierte en 12
    
    // Asegurarse de que se mantenga el formato de 12 horas en string.
    return hora + ':' + minutos + ' ' + ampm;
}


function guardaryeditarejercicios(e7) {
	e7.preventDefault(); //No se activará la acción predeterminada del evento
	// $("#btnCrearEjercicios").prop("disabled", true);
	var formData = new FormData($("#formulariocrearejercicios")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditarejercicios",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			//console.log(datos);
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirejercicios").modal("hide");
				$("#comentario_ejercicios").val("");
				$("#archivo_ejercicios").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearEjercicios").prop("disabled", false);
		}
	});
}

function guardaryeditarenlace(e8) {
	e8.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnCrearEnlace").prop("disabled", true);
	var formData = new FormData($("#formularioenlace")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditarenlace",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			//console.log(datos);
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirenlace").modal("hide");
				$("#comentario_enlace").val("");
				$("#archivo_enlace").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearEnlace").prop("disabled", false);
		}
	});
}

function guardarenlacelink(e9) {
	e9.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnCrearEnlaceLink").prop("disabled", true);
	var formData = new FormData($("#formularioenlacelink")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditarenlacelink",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			//console.log(datos);
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirenlacelink").modal("hide");
				$("#comentario_enlace_link").val("");
				$("#link_archivo").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearEnlacelink").prop("disabled", false);
		}
	});
}

function guardarenlacemensaje(e10) {
	e10.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnCrearEnlaceMensaje").prop("disabled", true);
	
	if (CKEDITOR.instances.comentario_archivo) {
		CKEDITOR.instances.comentario_archivo.updateElement();
	}
	var formData = new FormData($("#formularioenlacemensaje")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditarenlacemensaje",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirenlacemensaje").modal("hide");
				$("#comentario_archivo").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearEnlaceMensaje").prop("disabled", false);
		}
	});
}

function guardarenlacedocumento(e11) {
	e11.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnCrearEnlaceDocumento").prop("disabled", true);
	
	var formData = new FormData($("#formularioenlacedocumento")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditarenlacedocumento",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirenlaceDocumento").modal("hide");
				$("#link_archivo_documento").val("");
				$("#comentario_enlace_documento").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearEnlaceDocumento").prop("disabled", false);
		}
	});
}

function guardardocumentomensaje(e12) {
	e12.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnCrearDocumentoMensaje").prop("disabled", true);
	
	if (CKEDITOR.instances.comentario_archivo_mensaje) {
		CKEDITOR.instances.comentario_archivo_mensaje.updateElement();
	}
	var formData = new FormData($("#formulariodocumentomensaje")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditardocumentomensaje",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirdocumentomensaje").modal("hide");
				$("#comentario_archivo_mensaje").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearDocumentoMensaje").prop("disabled", false);
		}
	});
}

function guardaryeditarvideos(e7) {
	e7.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnCrearVideos").prop("disabled", true);
	var formData = new FormData($("#formulariocrearvideos")[0]);
	$.ajax({
		"url": "../controlador/estudiante.php?op=guardaryeditarvideos",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			//console.log(datos);
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": datos.info,
					"showConfirmButton": true,
				});
				agregarrecurso(datos.id_tema,datos.id_pea_docente,datos.ciclo);
				$("#subirvideos").modal("hide");
				$("#comentario_videos").val("");
				$("#archivo_videos").val("");
			} else {
				Swal.fire({
					"position": "center",
					"icon": "error",
					"title": datos.info,
					"showConfirmButton": true,
				});
			}
			$("#btnCrearVideos").prop("disabled", false);
		}
	});
}

// Limpia editor al cerrar (opcional)
$('#subirdocumentomensaje').on('hidden.bs.modal', function () {
  if (CKEDITOR.instances.comentario_archivo_mensaje) {
    CKEDITOR.instances.comentario_archivo_mensaje.setData('');
  }
});
$('#subirenlacemensaje').on('hidden.bs.modal', function () {
  if (CKEDITOR.instances.comentario_archivo) {
    CKEDITOR.instances.comentario_archivo.setData('');
  }
});

function listar() {

	$.post("../controlador/estudiante.php?op=listar", { }, function (data, status) {
		data = JSON.parse(data);
		$("#opciones").html("");
		$("#opciones").append(data["0"]["0"]);
	});
}
function volverhorario() {
	$("#horario").show();
	$("#calendar").hide();
	$("#volver").hide();
}
function iniciarcalendario(id_estudiante, ciclo, id_programa, grupo) {
	$("#horario").hide();
	$("#calendar").show();
	$("#volver").show();


	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'timeGridWeek',
		locales: 'es',
		slotMinTime: "06:00:00",
		slotMaxTime: "24:00:00",
		headerToolbar: {
			left: '',
			center: '',
			right: ''
		},
		slotLabelFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: true,
			meridiem: 'short',
		},
		eventTimeFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: true
		},
		eventSources: [
			{
				url: "../controlador/estudiante.php?op=iniciarcalendario", // URL del backend
				method: "POST",  // Se cambia a POST
				extraParams: {  // Parámetros que antes iban en la URL
					id_estudiante: id_estudiante,
					ciclo: ciclo,
					id_programa: id_programa,
					grupo: grupo
				},
				failure: function() {
					console.log('Hubo un error al cargar los eventos.');
				},
				success: function() {
					$("#precarga").hide();
				}
			}
		],
		eventClick: function(info) {
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.start.toLocaleDateString());
		},
	});

	calendar.render();

	// $.post("../controlador/estudiante.php?op=iniciarcalendario", {  }, function (data) {
	// 	data = JSON.parse(data);
	// 	console.log(data)
	// });

}
function validar_pea(ciclo, materia, docente) {

	var id_estudiante_materia = materia;
	var id_docente_materia = docente;// 
	alertify.confirm('Activar', "El sistema verificara que el docente tenga el PEA activo, persione ok para validar",
		function () {
			$.post("../controlador/estudiante.php?op=validar_pea", { ciclo: ciclo, id_estudiante_materia: id_estudiante_materia, id_docente_materia: id_docente_materia }, function (respuesta) {
				respuesta = JSON.parse(respuesta);
				//				console.log(respuesta);
				if (respuesta != "") {

					alertify.success('Pea Activado');

					iniciarhorario();
				} else {
					alertify.error('Reportar error al docente');
				}
			});
		},
		function () {
			alertify.error('Cancelado');
		});
}
function verPanel(id_docente_grupo, id_estudiante) {
	$.post("../controlador/estudiante.php?op=verpanel", { id_docente_grupo: id_docente_grupo, "id_estudiante_programa": id_estudiante }, function (data, status) {
		$("#horario").hide();
		$("#tbllistado").hide();
		
		$("#panel").show();
		data = JSON.parse(data);
		$("#panel").html("");
		$("#panel").append(data["0"]["0"]);
		$("#opciones").hide();
		$("#precarga").hide();
	});
}
function cerrarPea() {
	$("#horario").show();
	$("#tllistado").hide();
}
function descripcion(id_pea) {
	$("#precarga").show();
	$.post("../controlador/estudiante.php?op=descripcion", { id_pea: id_pea, }, function (data) {
		data = JSON.parse(data);
		$("#descripcion").html("");
		$("#descripcion").append(data["0"]["0"]);
		$("#panel").hide();
		$("#documentos").hide();
		$("#descripcion").show();
		$("#precarga").hide();
	});

}
function documentos(id_pea_docente, id_programa_ac) {
	$("#precarga").show();
	$.post("../controlador/estudiante.php?op=documentos", { id_pea_docente: id_pea_docente, id_programa_ac: id_programa_ac }, function (data) {
		data = JSON.parse(data);
		$("#documentos").html("");
		$("#documentos").append(data["0"]["0"]);
		$("#panel").hide();
		$("#descripcion").hide();
		$("#documentos").show();
		$("#precarga").hide();
		$('.post-module').hover(function () {
			$(this).find('.description').stop().animate({
				"height": "toggle",
				"opacity": "toggle"
			}, 300);
		});
	});
}
function descargarDoc(enlace, id_pea_documento, link) {
	$.post("../controlador/estudiante.php?op=descargarDoc", { id_pea_documento: id_pea_documento }, function (data) {
		data = JSON.parse(data);
		if (data["0"]["0"] == 1 && link == "1") {
			window.open('../files/pea/' + enlace, '_blank');
		} else {
			window.open(enlace, '_blank');
		}
	});
}
function descargarDocLink(enlace, id_pea_documento) {
	$.post("../controlador/estudiante.php?op=descargarDoc", { id_pea_documento: id_pea_documento }, function (data) {
		data = JSON.parse(data);
		if (data["0"]["0"] == 1) {
			window.open(enlace, '_blank');
		}
	});
}
function ejercicios(id_pea_docente, id_programa_ac) {
	$("#precarga").show();
	$.post("../controlador/estudiante.php?op=ejercicios", { id_pea_docente: id_pea_docente, id_programa_ac: id_programa_ac }, function (data) {
		data = JSON.parse(data);
		$("#ejercicios").html("");
		$("#ejercicios").append(data["0"]["0"]);
		$("#panel").hide();
		$("#descripcion").hide();
		$("#ejercicios").show();
		$("#documentos").hide();
		$("#precarga").hide();
		$('.post-module').hover(function () {
			$(this).find('.description').stop().animate({
				"height": "toggle",
				"opacity": "toggle"
			}, 300);
		});
	});
}

function enviarEjercicios(id_pea_documento, mifila) {
	$("#subirejercicios").modal("show");
	$("#id_pea_documento").val(id_pea_documento);
	$("#comentario_ejercicios").val("");
}

function enviarEnlace(id_pea_enlace, mifila) {
	$("#subirenlace").modal("show");
	$("#id_pea_enlace").val(id_pea_enlace);
	$("#comentario_enlace").val("");
}

function enviarEnlaceLink(id_pea_enlace, mifila) {
	$("#subirenlacelink").modal("show");
	$("#id_pea_enlace_link").val(id_pea_enlace);
	$("#comentario_enlace_link").val("");
}

function enviarEnlaceDocumento(id_pea_documento, mifila) {
	$("#subirenlaceDocumento").modal("show");
	$("#id_pea_enlace_documento").val(id_pea_documento);
	$("#link_archivo_documento").val("");
	$("#comentario_enlace_documento").val("");
}

function enviarVideos(id_pea_video, mifila) {
	$("#subirvideos").modal("show");
	$("#id_pea_video").val(id_pea_video);
	$("#comentario_videos").val("");
}

function enviarEnlaceMensaje(id_pea_enlace,mifila) {
	$("#subirenlacemensaje").modal("show");
	$("#id_pea_enlace_mensaje").val(id_pea_enlace);
	$("#comentario_archivo").val("");
	CKEDITOR.replace('comentario_archivo', {
    height: '400px',
    toolbar: [
        { name: 'document', items: [ 'Undo', 'Redo' ] },
        { name: 'styles',   items: [ 'Format' ] }, // para el menú "Heading 1"
        { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
        { name: 'links',    items: [ 'Link', 'Unlink' ] },
        { name: 'insert',   items: [ 'Image', 'Table' ] },
        { name: 'lists',    items: [ 'BulletedList', 'NumberedList' ] },
        { name: 'paragraph',items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ] }
    ],
    // Opcional: limitar formatos a solo H1, H2, párrafo
    format_tags: 'p;h1;h2'
});
}

function enviardocumentoMensaje(id_pea_documento,mifila) {
	$("#subirdocumentomensaje").modal("show");
	$("#id_pea_documento_mensaje").val(id_pea_documento);
	$("#comentario_archivo_mensaje").val("");
	CKEDITOR.replace('comentario_archivo_mensaje', {
    height: '400px',
    toolbar: [
        { name: 'document', items: [ 'Undo', 'Redo' ] },
        { name: 'styles',   items: [ 'Format' ] }, // para el menú "Heading 1"
        { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
        { name: 'links',    items: [ 'Link', 'Unlink' ] },
        { name: 'insert',   items: [ 'Image', 'Table' ] },
        { name: 'lists',    items: [ 'BulletedList', 'NumberedList' ] },
        { name: 'paragraph',items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ] }
    ],
    // Opcional: limitar formatos a solo H1, H2, párrafo
    format_tags: 'p;h1;h2'
});
}


function enlaces(id_pea_docente, id_programa_ac) {
	$("#precarga").show();
	$.post("../controlador/estudiante.php?op=enlaces", { id_pea_docente: id_pea_docente, id_programa_ac: id_programa_ac }, function (data) {
		data = JSON.parse(data);
		$("#enlaces").html("");
		$("#enlaces").append(data["0"]["0"]);
		$("#panel").hide();
		$("#descripcion").hide();
		$("#documentos").hide();
		$("#enlaces").show();
		$("#precarga").hide();

		// Activar el hover
		$('.post-module').hover(function () {
			$(this).find('.description').stop().animate({
				height: "toggle",
				opacity: "toggle"
			}, 300);
		});

		// Esperar a que imágenes de íconos carguen y posicionarlos
		const icons = document.querySelectorAll('.orbit-icon img');
		let loaded = 0;

		icons.forEach(img => {
			img.onload = () => {
				loaded++;
				if (loaded === icons.length) {
					positionOrbitIcons();
				}
			};
			if (img.complete) {
				img.onload();
			}
		});
	});
}

function positionOrbitIcons() {
	const container = document.querySelector('.icon-container');
	const orbitIcons = document.querySelectorAll('.orbit-icon');
	const radius = 180;
	const centerX = container.offsetWidth / 2;
	const centerY = container.offsetHeight / 2;

	orbitIcons.forEach((icon, index) => {
		const angle = (2 * Math.PI / orbitIcons.length) * index;
		const iconW = icon.offsetWidth;
		const iconH = icon.offsetHeight;

		const x = centerX + radius * Math.cos(angle) - iconW / 2;
		const y = centerY + radius * Math.sin(angle) - iconH / 2;

		icon.style.left = `${x}px`;
		icon.style.top = `${y}px`;
	});
}

function volverContenidos() {
	$("#panel").show();
	$("#descripcion").hide();
	$("#documentos").hide();
	$("#ejercicios").hide();
	$("#enlaces").hide();
	$("#glosario").hide();
}

function glosario(id_pea_docente, id_programa_ac) {
	$.post("../controlador/estudiante.php?op=glosarioCabecera", { id_pea_docente: id_pea_docente, id_programa_ac: id_programa_ac }, function (data) {
		data = JSON.parse(data);
		$("#glosariocabecera").html("");
		$("#glosariocabecera").append(data["0"]["0"]);
	});
	tabla = $('#tblglosario').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"dom": 'Bfrtip',
		"buttons": [{
			"extend": 'excelHtml5',
			"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
			"titleAttr": 'Excel'
		}, {
			"extend": 'print',
			"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
			"messageTop": '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
			"title": 'Programas Académicos',
			"titleAttr": 'Print'
		},
		],
		"ajax": {
			"url": '../controlador/estudiante.php?op=glosario&id_pea_docente=' + id_pea_docente,
			"type": "get",
			"dataType": "json",
			error: function (e) {
				// console.log(e);	
			}
		},
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (data) {
			// console.log(data);
			$("#horario").hide();
			$("#panel").hide();
			$("#descripcion").hide();
			$("#documentos").hide();
			$("#enlaces").hide();
			$("#glosario").show();
			$("#precarga").hide();
		},
	}).DataTable();
}

function enviarcorreonotificacionestudiante() {
	$.post("../controlador/estudiante.php?op=enviarcorreonotificacionestudiante", { "id_pea_ejercicios_global": id_pea_ejercicios_global, "id_pea_docente_global": id_pea_docente_global, "nombre_archivo_global": nombre_archivo_global }, function (data) {
		// console.log(data);
		datos = JSON.parse(data);
		if (datos.exito == 1) {
			alertify.success(datos.info);
		} else {
			alertify.error(datos.info);
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
				title: 'Programa y horario',
				intro: '¡Bienvenido a la información donde comienza tu experiencia creativa!'
			},
			{
				title: 'PEA',
				element: document.querySelector('#t-paso1'),
				intro: "Aquí podrás encontrar todos aquellos proyectos educativos de aula que nuestro docente tiene para todos nuestros seres originales creando asi un ambiente creativo e innovador"
			},

			{
				title: 'Asignatura',
				element: document.querySelector('#t-paso2'),
				intro: "Conoce las diferentes asinaturas de tu semestre teniendo encuenta donde comienza y donde termina la mágica experiencia creativa"
			},

			{
				title: 'Docente',
				element: document.querySelector('#t-paso3'),
				intro: "Conoce a los guias de esta aventura educativa, que te llevarán por el mundo de el conocimiento "
			},

			{
				title: 'Cortes',
				element: document.querySelector('#t-paso4'),
				intro: "Enterate de las diferentes notas que te han asignado en las experiencias creativas de tu semestre"
			},
			
			{
				title: 'Final',
				element: document.querySelector('#t-paso5'),
				intro: "Da un vistazo a tu nota final donde se hace un reencuento de todas las experiencias creativas que has vivido este semestre"
			},

			{
				title: 'Horario de clase',
				element: document.querySelector('#t-paso6'),
				intro: "Aquí te puedes enterar de la hora tan esperada para comenzar tu experiencia creativa "
			},

			{
				title: 'Faltas',
				element: document.querySelector('#t-paso7'),
				intro: "Da un vistazo a tus faltas reportadas por tus docentes, recuerda que es muy imporante reportar tu ausencia y el motivo de ella, luego te podrás poner al tanto de la experiencia creativa a la que has faltado"
			},

			{
				title: 'Calendario',
				element: document.querySelector('#t-paso8'),
				intro: "Observa de manera más detallada cuando comienza tu encuentro con el conocimiento en nuestro calendario donde podrás observar tus proximas experiencias creativas"
			},
		]
	}).start();
}

function agregarrecurso(id_tema,id_pea_docente,ciclo) {

  $.post( "../controlador/estudiante.php?op=agregarrecurso",{ id_tema:id_tema, id_pea_docente:id_pea_docente, ciclo:ciclo },
    function (data) {
      r = JSON.parse(data);

    if (r.data1 == 3) {
      // Cargar el contenido dinámicamente
      document.getElementById('contenidoPanelRecursos').innerHTML = `
        <div>${r[0].opciones }</div>
      `;

      abrirPanel(); // Mostrar panel
    }
    }
  );
}

function formatTime(seconds) {
  var minutes = Math.floor(seconds / 60);
  var secs = Math.floor(seconds % 60);
  if (secs < 10) secs = "0" + secs;
  return minutes + ":" + secs;
}

function getYoutubeId(url) {
  const regex = /(?:youtube\.com\/(?:.*v=|.*\/|embed\/)|youtu\.be\/)([^"&?/ ]{11})/i;
  const match = url.match(regex);
  return match ? match[1] : null;
}

function informacionVideo(param1){

	$.post("../controlador/estudiante.php?op=informacionVideo", { param1:param1}, function (data) {
		r = JSON.parse(data);
		$("#informacionDoc").modal("show");
		$("#resultadodoc").html("");
		$("#resultadodoc").append(r.data1);
    	$(document).ready(async function () {
			$("#example").DataTable({
				"paging": false,
				"searching": false,
				"scrollX": false,
				"order": [[2, "asc"]],
				"autoWidth": false,

				"buttons": [],
			});

			var preguntas = JSON.parse(r.preguntas);

			var id_video = await getYoutubeId(r.video);

			var player;
			player = new YT.Player('player', {
				height: '390',
				width: '640',
				videoId: id_video,
				playerVars: {
					controls: 0,
					disablekb: 1,
					modestbranding: 1,
					rel: 0,
				},
				events: {
					
				}
			});


			var preguntasMostradas = new Set();

			setInterval(function () {
				if (player && player.getPlayerState() === YT.PlayerState.PLAYING) {
					var currentTime = Math.floor(player.getCurrentTime());
          			var tiempoFormateado = formatTime(currentTime);

					if ( preguntas.length == preguntasMostradas.size ) {
						$("#guardar-todas-respuestas").prop("disabled", false);
					}

					preguntas.forEach(p => {
						let preguntaSegundos = p.tiempo_segundos;

						if (tiempoFormateado >= preguntaSegundos && !preguntasMostradas.has(p.id)) {
							mostrarPregunta(p);
							preguntasMostradas.add(p.id);
						}
					});
				}
			}, 1000);

			function mostrarPregunta(p) {
				let html = "";

				if (p.tipo_pregunta == 1) {
					html = `
					<div class="list-group-item " data-id="${p.id}" style="background-color: #283157;" >
						<h5>${p.pregunta}</h5>
						<div class="form-check">
						<input class="form-check-input respuesta-video" type="radio" 
								name="preg-${p.id}" value="Verdadero">
						<label class="form-check-label">Verdadero</label>
						</div>
						<div class="form-check">
						<input class="form-check-input respuesta-video" type="radio" 
								name="preg-${p.id}" value="Falso">
						<label class="form-check-label">Falso</label>
						</div>
					</div>
					`;
				} else {
					html = `
					<div class="list-group-item" data-id="${p.id}" style="background-color: #283157;" >
						<h5>${p.pregunta}</h5>
						<input type="text" class="form-control respuesta-video-texto" 
							placeholder="Escribe tu respuesta aquí">
					</div>
					`;
				}

				$("#preguntas-listado").append(html);
			}
		});
	});
}

$(document).off("click", "#guardar-todas-respuestas").on("click", "#guardar-todas-respuestas", function (e) {
	e.preventDefault();
	let respuestas = [];

	$("#preguntas-listado .list-group-item").each(function () {
		let id = $(this).data("id");
		let respuesta = "";

		if ($(this).find(".respuesta-video-texto").length) {
			respuesta = $(this).find(".respuesta-video-texto").val();
		} else {
			respuesta = $(this).find(".respuesta-video:checked").val();
		}

		respuestas.push({
			id_pregunta: id,
			respuesta: respuesta || null,
			id_video: r.id_video
		});
	});

	console.log("Respuestas a enviar:", respuestas);

	$.post("../controlador/estudiante.php?op=guardarRespuestasVideo", 
		{ respuestas: JSON.stringify(respuestas) }, 
		function (resp) {
			alertify.success("Todas las respuestas fueron guardadas");
			$("#preguntas-listado input, #preguntas-listado button").prop("disabled", true);
		}
	);
});


function abrirPanel() {
  document.getElementById('panelRecursos').classList.add('show');
}

function cerrarPanel() {
  document.getElementById('panelRecursos').classList.remove('show');
}



function informacionDoc(id_pea_documento){

	$.post("../controlador/estudiante.php?op=informacionDoc", { id_pea_documento:id_pea_documento}, function (data) {
		r = JSON.parse(data);
		$("#informacionDoc").modal("show");
		$("#resultadodoc").html("");
		$("#resultadodoc").append(r.data1);
	});

}

function informacionEnlace(id_pea_enlaces){

	$.post("../controlador/estudiante.php?op=informacionEnlace", { id_pea_enlaces:id_pea_enlaces}, function (data) {
		r = JSON.parse(data);
		$("#informacionEnlace").modal("show");
		$("#resultadoEnlace").html("");
		$("#resultadoEnlace").append(r.data1);
	});

}
function informacionGlosario(id_pea_glosario){

	$.post("../controlador/estudiante.php?op=informacionGlosario", { id_pea_glosario:id_pea_glosario }, function (data) {
		r = JSON.parse(data);
		$("#informacionGlosario").modal("show");
		$("#resultadoGlosario").html("");
		$("#resultadoGlosario").append(r.data1);
	});

}

function validarGlosario(id_pea_glosario,id_pea_docente,id_tema,ciclo){

	$.post("../controlador/estudiante.php?op=validarGlosario", { id_pea_glosario:id_pea_glosario}, function (data) {
		r = JSON.parse(data);
		if(r.puntos=="si"){
                   
			Swal.fire({
				position: "top-end",
				imageWidth: 150,
				imageHeight: 150,
				imageUrl: "../public/img/ganancia.gif",
				title: "Te otorgamos " + r.puntosotorgados +" puntos, por cumplir con la misión",
				showConfirmButton: false,
				timer: 4000
			});

		}else{
				Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Glosario Vista,",
				showConfirmButton: false,
				timer: 2500
			});
		}
		$("#informacionGlosario").modal("hide");
		agregarrecurso(id_tema,id_pea_docente,ciclo)
	});

}

function validarEnlace(id_pea_enlaces,id_pea_docente,id_tema,ciclo){

	$.post("../controlador/estudiante.php?op=validarEnlace", { id_pea_enlaces:id_pea_enlaces}, function (data) {
		r = JSON.parse(data);
		if(r.puntos=="si"){
                   
			Swal.fire({
				position: "top-end",
				imageWidth: 150,
				imageHeight: 150,
				imageUrl: "../public/img/ganancia.gif",
				title: "Te otorgamos " + r.puntosotorgados +" puntos, por cumplir con el taller",
				showConfirmButton: false,
				timer: 4000
			});

		}else{
				Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Actividad Vista,",
				showConfirmButton: false,
				timer: 2500
			});
		}
		$("#informacionEnlace").modal("hide");
		agregarrecurso(id_tema,id_pea_docente,ciclo)
	});

}

function validarDocumento(id_pea_documento,id_pea_docente,id_tema,ciclo){

	$.post("../controlador/estudiante.php?op=validarDocumento", { id_pea_documento:id_pea_documento}, function (data) {
		r = JSON.parse(data);
		if(r.puntos=="si"){
                   
			Swal.fire({
				position: "top-end",
				imageWidth: 150,
				imageHeight: 150,
				imageUrl: "../public/img/ganancia.gif",
				title: "Te otorgamos " + r.puntosotorgados +" puntos, por cumplir con el taller",
				showConfirmButton: false,
				timer: 4000
			});

		}else{
				Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Actividad Vista,",
				showConfirmButton: false,
				timer: 2500
			});
		}

		$("#informacionDoc").modal("hide");
		agregarrecurso(id_tema,id_pea_docente,ciclo)
	});

}

function validarVideo(id_pea_video,id_pea_docente,id_tema,ciclo){
	$.post("../controlador/estudiante.php?op=validarVideo", { id_pea_video:id_pea_video}, function (data) {
		r = JSON.parse(data);
		if (r.puntos == "si"){
			Swal.fire({
				position: "top-end",
				imageWidth: 150,
				imageHeight: 150,
				imageUrl: "../public/img/ganancia.gif",
				title: "Te otorgamos " + r.puntosotorgados +" puntos, por cumplir con el taller",
				showConfirmButton: false,
				timer: 4000
			});
		}else{
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Actividad Vista,",
				showConfirmButton: false,
				timer: 2500
			});
		}

		$("#informacionDoc").modal("hide");
		agregarrecurso(id_tema,id_pea_docente,ciclo)
	});
}

function verDocumentoMensaje(id_pea_ejercicios_est,id_pea_documento) {
  // Pides los datos al backend
  $.post("../controlador/estudiante.php?op=documentoMensaje", { id_pea_ejercicios_est:id_pea_ejercicios_est, id_pea_documento:id_pea_documento }, function (data) {
    const r = JSON.parse(data);

    // 1) Crea el editor una sola vez
    if (!CKEDITOR.instances.comentario_documento_archivo_ver) {
      CKEDITOR.replace('comentario_documento_archivo_ver', {
        height: 400,
        readOnly: true,                // Solo lectura (estás viendo)
        removePlugins: 'elementspath,resize',
        toolbar: [                     // Si quieres, deja la barra mínima
          { name: 'document', items: ['Undo', 'Redo'] },
          { name: 'styles',   items: ['Format'] },
          { name: 'basicstyles', items: ['Bold','Italic'] },
          { name: 'links',    items: ['Link','Unlink'] },
          { name: 'insert',   items: ['Image','Table'] },
          { name: 'lists',    items: ['BulletedList','NumberedList'] },
          { name: 'paragraph',items: ['JustifyLeft','JustifyCenter','JustifyRight'] }
        ],
        format_tags: 'p;h1;h2'
      });
    }

    // 2) Setea el contenido HTML devuelto por tu API
    CKEDITOR.instances.comentario_documento_archivo_ver.setData(r.data1 || '');

    // 3) Abre el modal al final (ya con el contenido cargado)
    $("#verDocumentoMensajeModal").modal("show");
  });
}

function verEnlaceMensaje(id_pea_enlaces_est,id_pea_enlaces) {
  // Pides los datos al backend
  $.post("../controlador/estudiante.php?op=enlaceMensaje", { id_pea_enlaces_est:id_pea_enlaces_est, id_pea_enlaces:id_pea_enlaces }, function (data) {
    const r = JSON.parse(data);

    // 1) Crea el editor una sola vez
    if (!CKEDITOR.instances.comentario_archivo_ver) {
      CKEDITOR.replace('comentario_archivo_ver', {
        height: 400,
        readOnly: true,                // Solo lectura (estás viendo)
        removePlugins: 'elementspath,resize',
        toolbar: [                     // Si quieres, deja la barra mínima
          { name: 'document', items: ['Undo', 'Redo'] },
          { name: 'styles',   items: ['Format'] },
          { name: 'basicstyles', items: ['Bold','Italic'] },
          { name: 'links',    items: ['Link','Unlink'] },
          { name: 'insert',   items: ['Image','Table'] },
          { name: 'lists',    items: ['BulletedList','NumberedList'] },
          { name: 'paragraph',items: ['JustifyLeft','JustifyCenter','JustifyRight'] }
        ],
        format_tags: 'p;h1;h2'
      });
    }

    // 2) Setea el contenido HTML devuelto por tu API
    CKEDITOR.instances.comentario_archivo_ver.setData(r.data1 || '');

    // 3) Abre el modal al final (ya con el contenido cargado)
    $("#verEnlaceMensajeModal").modal("show");
  });
}

// Opcional: si quieres “limpiar” al cerrar el modal
$('#verEnlaceMensaje').on('hidden.bs.modal', function () {
  if (CKEDITOR.instances.comentario_archivo_ver) {
    CKEDITOR.instances.comentario_archivo_ver.setData('');
  }
});

$('#verDocumentoMensajeModal').on('hidden.bs.modal', function () {
  if (CKEDITOR.instances.comentario_documento_archivo_ver) {
    CKEDITOR.instances.comentario_documento_archivo_ver.setData('');
  }
});
