var tabla;
var fechaActual = new Date(); 
var anoActual = fechaActual.getFullYear();
var id_tarea_sac_global; 
function init(){
	// listartareas(anoActual);
	// nombre_meta_usuario();
	$("#precarga").hide();

	const valorGuardado = localStorage.getItem('sacmostrar');

	if (valorGuardado == 1) {
		modopanel();
		$("#verpanel").show();
		$("#vercuadricula").hide();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").addClass('d-none');
	} else if (valorGuardado == 2) {
		modocuadricula();
		$("#verpanel").hide();
		$("#vercuadricula").show();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").addClass('d-none');
	} else if (valorGuardado == 3) {
		$("#verpanel").hide();
		$("#vercuadricula").hide();
		$("#verpendientes").removeClass('d-none');
		$("#verfinalizadas").addClass('d-none');
		mostrarTareasPendientes();
	} else if (valorGuardado == 4) {
		$("#verpanel").hide();
		$("#vercuadricula").hide();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").removeClass('d-none');
		mostrarTareasFinalizadas();
	} else {
		
		modopanel();
		$("#verpanel").show();
		$("#vercuadricula").hide();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").addClass('d-none');
	}

	actualizarEstilos(valorGuardado);
}

// Cargar y mostrar tareas pendientes
function mostrarTareasPendientes() {
	$.get('../controlador/sactareas.php?op=listar_tareas_pendientes', function(data) {
		var tareas = JSON.parse(data);
		var tbody = '';
		tareas.forEach(function(tarea, idx) {
			tbody += `<tr>
				<td>${idx + 1}</td>
				<td >${tarea.nombre_tarea}</td>
				<td width="250px">${tarea.fecha_entrega_tarea ? tarea.fecha_entrega_tarea : 'Sin fecha'}</td>
				<td width="200px">
					<button class="btn bg-purple btn-xs text-white" onclick="abrirModalLinkTarea(${tarea.id_tarea_sac})">
						<i class="fas fa-plus-circle"></i> Link Evidencia
					</button>
					${tarea.link_evidencia_tarea ? `<button class='btn btn-primary btn-xs ml-1' onclick='marcarTareaFinalizada(${tarea.id_tarea_sac})' title='Marcar como terminada'><i class='fas fa-check'></i></button>` : "<span class='fs-14 ml-2'></span>"}
				</td>
			</tr>`;
		});
		$('#tbpendientes tbody').html(tbody);
		if ($.fn.DataTable.isDataTable('#tbpendientes')) {
			$('#tbpendientes').DataTable().destroy();
		}
		$('#tbpendientes').DataTable({
			scrollX: true,
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
					titleAttr: 'Imprimir'
				}
			],
			bDestroy: true,
			iDisplayLength: 10,
			order: [[0, "desc"]]
		});
	});
}

// Marcar tarea como finalizada (global)
function marcarTareaFinalizada(idTarea) {
	Swal.fire({
		title: '¿Estás seguro?',
		text: '¿Deseas marcar esta tarea como terminada?',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, marcar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			$.post('../controlador/sactareas.php?op=marcar_tarea_finalizada', { id_tarea_sac: idTarea }, function(response) {
				if (response.trim() === 'Tarea marcada como finalizada') {
					Swal.fire('¡Listo!', 'La tarea ha sido marcada como finalizada.', 'success');
					mostrarTareasPendientes();
					mostrarTareasFinalizadas();
				} else {
					Swal.fire('Error', 'No se pudo marcar la tarea. Intenta nuevamente.', 'error');
				}
			});
		}
	});
}
// Cargar y mostrar tareas finalizadas
function mostrarTareasFinalizadas() {
	$.get('../controlador/sactareas.php?op=listar_tareas_finalizadas', function(data) {
		var tareas = JSON.parse(data);
		var tbody = '';
		tareas.forEach(function(tarea, idx) {
			tbody += `<tr>
				<td>${idx + 1}</td>
				<td>${tarea.nombre_tarea}</td>
				<td width="200px">${tarea.fecha_entrega_tarea ? tarea.fecha_entrega_tarea : 'Sin fecha'}</td>
				<td width="200px">
					${tarea.link_evidencia_tarea ? `<a href="${tarea.link_evidencia_tarea}" target="_blank" class="btn btn-outline-info btn-xs" title="Ver evidencia"><i class="fas fa-external-link-alt"></i> Ver</a>` : `<span class="bg-success text-white px-2 py-1 rounded">Finalizada</span>`}
				</td>
			</tr>`;
		});
		$('#tbfinalizadas tbody').html(tbody);
		if ($.fn.DataTable.isDataTable('#tbfinalizadas')) {
			$('#tbfinalizadas').DataTable().destroy();
		}
		$('#tbfinalizadas').DataTable({
			scrollX: true,
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
					titleAttr: 'Imprimir'
				}
			],
			bDestroy: true,
			iDisplayLength: 10,
			order: [[0, "desc"]]
		});
	});
}
function detalle(id_meta){
	$.post("../controlador/sactareas.php?op=detalle",{id_meta:id_meta},function(data){
		console.log(data);
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$("#detalleconte").html(data);
	});
}
function abrirModalLinkTarea(id_tarea_sac) {
    $('#modal_id_tarea_sac').val(id_tarea_sac);
    $('#modal_link_evidencia_tarea').val('');
    $('#modalLinkTarea').modal('show');
}

function guardarLinkDesdeModal() {
	var id_tarea_sac = $('#modal_id_tarea_sac').val();
	var link1 = $('#modal_link_evidencia_tarea').val().trim();
    var link2 = $('#modal_link_evidencia_tarea_cuadricula').val().trim();
    // Verifica cuál link está lleno
    var linkFinal = link1 !== "" ? link1 : (link2 !== "" ? link2 : null);
    guardarLinkTarea(linkFinal, id_tarea_sac);
	cerrarPopoverTarea();
    $('#modalLinkTarea').modal('hide');
	
}
function guardarLinkTarea(link, idTarea) {
    if (!link || link.trim() === '') {
        return Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El link no puede estar vacío.'
        });
    }
    const urlValida = /^(https?:\/\/)[\w\-]+(\.[\w\-]+)+[/#?]?.*$/i;
    if (!urlValida.test(link)) {
        return Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Por favor ingresa un link válido.'
        });
    }
    $.post('../controlador/sactareas.php?op=guardarlinktarea', {
        id_tarea_sac: idTarea,
        link_evidencia_tarea: link
    }, function(response) {
        const mensaje = response.trim();
        if (mensaje === 'Link guardado correctamente') {
			actualizarVistaTareas();
            Swal.fire({
                icon: 'success',
                title: 'Guardado',
                text: 'El link ha sido registrado correctamente.'
			}).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar el link. Intenta nuevamente.'
            });
        }
    });
}

function validacion_tarea(id_tarea_sac) {
	
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de terminar la tarea?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/sactareas.php?op=validacion_tarea", { 'id_tarea_sac' : id_tarea_sac }, function (e) {
				
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Tarea Terminada con éxito.",
						icon: "success"
					});
					$('#tbllistatareas').DataTable().ajax.reload();

					
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Tarea no se puedo terminar.",
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

function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [
			{
				"title": 'Filtro año',
				"element": document.querySelector('#tour_buscar'),
				"intro": 'Filtro por medio de año'
			},
			{
				"title": 'Nombre proyecto',
				"element": document.querySelector('#tour_proyecto'),
				"intro": 'Muestra el nombre del proyecto'
			},
			
		]
	},
	).start();ww
}

function terminar_tarea_accion(id_tarea_sac) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de terminar la tarea?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/sactareas.php?op=terminar_tarea_accion", { 'id_tarea_sac' : id_tarea_sac }, function (e) {
				
				if (e == 'null') {
					enviarcorrenotificaciontareafinalizada(id_tarea_sac);
					actualizarVistaTareas(); 
					
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Tarea Terminada con éxito.",
						icon: "success"
					
					}).then(() => {
						location.reload();
					});

					
					// nombre_meta_usuario();

					
					// $("#myModalNombreMetaUsuario").modal("hide");
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Tarea no se puedo terminar.",
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

function actualizarVistaTareas() {
    const valorGuardado = localStorage.getItem('sacmostrar');
    if (valorGuardado == 1) {
        modopanel();
        $("#verpanel").show();
        $("#vercuadricula").hide();
    } else {
        modocuadricula();
        $("#verpanel").hide();
        $("#vercuadricula").show();
    }
    actualizarEstilos(valorGuardado);
}

function enviarcorrenotificaciontareafinalizada(id_tarea_sac) {
	$.post("../controlador/sactareas.php?op=enviarcorrenotificaciontareafinalizada", { id_tarea_sac: id_tarea_sac }, function (data) {
		datos = JSON.parse(data);
		if (datos.exito == 1) {
			alertify.success(datos.info);
		} else {
			alertify.error(datos.info);
		}
	});
}

function guardarLocal(valor) {

  localStorage.setItem('sacmostrar', valor);
	if(valor == 1){
		modopanel();
		$("#verpanel").show();
		$("#vercuadricula").hide();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").addClass('d-none');
	}else if(valor == 2){
		modocuadricula();
		$("#verpanel").hide();
		$("#vercuadricula").show();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").addClass('d-none');
	}else if(valor == 3){
		$("#verpanel").hide();
		$("#vercuadricula").hide();
		$("#verpendientes").removeClass('d-none');
		$("#verfinalizadas").addClass('d-none');
		mostrarTareasPendientes();
	}else if(valor == 4){
		$("#verpanel").hide();
		$("#vercuadricula").hide();
		$("#verpendientes").addClass('d-none');
		$("#verfinalizadas").removeClass('d-none');
		mostrarTareasFinalizadas();
	}
	actualizarEstilos(valor);

}

function actualizarEstilos(valor) {
	const btnPanel = document.getElementById('btn-panel');
	const btnCuadricula = document.getElementById('btn-cuadricula');
	const btnPendientes = document.getElementById('btn-pendientes');
	const btnRealizadas = document.getElementById('btn-realizadas');

	btnPanel.classList.remove('text-primary');
	btnCuadricula.classList.remove('text-primary');
	btnPendientes.classList.remove('text-primary');
	btnRealizadas.classList.remove('text-primary');

	if (valor == 1) {
		btnPanel.classList.add('text-primary');
	} else if (valor == 2) {
		btnCuadricula.classList.add('text-primary');
	} else if (valor == 3) {
		btnPendientes.classList.add('text-primary');
	} else if (valor == 4) {
		btnRealizadas.classList.add('text-primary');
	}
}

//Función para mostrar nombre de la meta 
function modopanel(){
	$("#mostrar_metas").show();
	$("#mostrar_ocultar_metas").hide();
	$("#ocultar_boton_volver").show();
	$.post("../controlador/sactareas.php?op=modopanel",{ },function(data){
		// console.log(data);
		data = JSON.parse(data);
		// $("#myModalNombreMetaUsuario").modal("show");
		$("#datopanel").html(data);
		$("#precarga").hide();
	});
}

function acciones(id_meta){
	// cerrarPopoverTarea();
	$.post("../controlador/sactareas.php?op=acciones",{id_meta:id_meta},function(data){
		// console.log(data);
		data = JSON.parse(data);
		$("#modalacciones").modal("show");
		$("#detalleacciones").html(data);
	});
}


function modocuadricula(){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	tabla=$('#tbcuadricula').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
		"scrollX": true,
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	           buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/sactareas.php?op=modocuadricula',
					type : "get",
					dataType : "json",						
					error: function(e){
						// console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[0, "desc" ]],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
				
			},

      });

	// $('#tbcuadricula').on('draw.dt', function () {
	// 	activarEdicionFecha(); // Muy importante
	// 	activarEdicionFechaFinal();  // Para fecha final
	// 	activarEdicionNombreMeta(); //  Agregado
	// 	activarEdicionTarea();
		
	// });
}

function cerrarPopoverTarea() {
    document.querySelectorAll('#modalacciones .modal-body > .popover-tarea:not(#popoverFormularioLinkTarea)').forEach(el => el.remove());
    const popover = document.getElementById("popoverFormularioLinkTarea");
    if (popover) {
        popover.classList.add("d-none");
    }
}
function CrearTareaPopover(event, id_tarea_sac) {
    event.stopPropagation();
    cerrarPopoverTarea();
    const boton = event.currentTarget;
    const popover = document.getElementById("popoverFormularioLinkTarea");
    const modalBody = document.querySelector("#modalacciones .modal-body");
    const modalRect = modalBody.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const popoverWidth = 300;
    const offsetTop = buttonRect.top - modalRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - modalRect.left - popoverWidth + boton.offsetWidth;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.classList.remove("d-none");
    modalBody.appendChild(popover);
    document.getElementById("modal_id_tarea_sac").value = id_tarea_sac;
}




init();

