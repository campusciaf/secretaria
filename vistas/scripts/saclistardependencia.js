var id_meta_global;
var seleccion_global;
var tabla; 
var meta_responsable_global; 
var fecha_ano_global; 

//Función que se ejecuta al inicio
function init(){

	
	$("#ocultar_boton_volver").hide();
	activarEdicionFechaAccion()
	activarEdicionNombreAccion();
	activarEdicionresponsable();
	activarEdicionresponsableTarea();
	

	$.post("../controlador/sac_listar_dependencia.php?op=periodo", function(data){
		data = JSON.parse(data);
		$("#precarga").show();
		// buscar(data.periodo);
	});	
	//listamos el cargo en el html
	$.post("../controlador/sac_listar_dependencia.php?op=selectListarCargo", function (r) {
		$("#meta_responsable").append(r);
		$('#meta_responsable').selectpicker('refresh');
	});
	
	$.post("../controlador/sac_listar_dependencia.php?op=selectListarResponsableTrea", function (r) {
		$("#responsable_tarea").html(r);
		$('#responsable_tarea').selectpicker('refresh');
	});
	//listamos las condiciones institucionales en el html
	$.post("../controlador/sac_listar_dependencia.php?op=condiciones_institucionales", function (r) {
		$(".box_condiciones_institucionales").html(r);
	});
	//listamos las dependencias en el html
	$.post("../controlador/sac_listar_dependencia.php?op=dependencias", function (r) {
		$("#dependencias").html(r);
	});
	//listamos las condiciones de programa en el html
	$.post("../controlador/sac_listar_dependencia.php?op=condiciones_programa&id=", function (r) {
		$("#condiciones_programa").html(r);
	});
	//listamos el cargo en el html
	$.post("../controlador/sac_listar_dependencia.php?op=selectListarTiposIndicadores", function (r) {
		$("#indicador").html(r);
		$('#indicador').selectpicker('refresh');
	});
	$(document).on('change', '#indicador', function () {
		var seleccion = $(this).val();
		mostrarElementosSegunSeleccion(seleccion);
	});
	$.post("../controlador/sac_listar_dependencia.php?op=selectListarEjes", function (r) {
		$("#nombre_ejes").html(r);
		$('#nombre_ejes').selectpicker('refresh');
	});


	$.post("../controlador/sac_listar_dependencia.php?op=selectListarEjes", function (r) {
		$("#id_eje").html(r);
		$('#id_eje').selectpicker('refresh');
	});

	$.post("../controlador/sac_listar_dependencia.php?op=selectListarProyectos", function (r) {
		$("#id_proyecto").html(r);
		$('#id_proyecto').selectpicker('refresh');
	});
	// listamos los responsables en la tabla de usuario que esten activos.
	$.post("../controlador/sac_listar_dependencia.php?op=selectListarResponsables", function (r) {
			// console.log(r);
			$("#responsables_meta").html(r);
			$('#responsables_meta').selectpicker('refresh');
		});


	$("#formulariocrearmetaeditar").on("submit", function (e) {
		if ($('[name="anio_eje"]').val() === null || $('[name="anio_eje"]').val() === "") {
			e.preventDefault();
			Swal.fire("Por favor, selecciona un año.");
			return;
		}
		if ($('#meta_responsable').val() === null || $('#meta_responsable').val() === "") {
			e.preventDefault();
			Swal.fire("Por favor, selecciona un responsable.");
			return;
		}	

		guardarcreoyeditometa(e);
	});

	$("#formnuevameta").on("submit", function (e) {
		e.preventDefault();
		guardarnuevameta();
		return false; // 👈 evita que siga el flujo por defecto
	});


	$("#formulariocreartarea").on("submit", function (e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			url: "../controlador/sac_listar_dependencia.php?op=guardaryeditartarea",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function (datos) {
				var obj = JSON.parse(datos);
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Tarea guardada",
					showConfirmButton: false,
					timer: 1500
				});
				acciones(obj.id_meta);
				$('#tbcuadricula').DataTable().ajax.reload();
				cerrarPopoverTarea();
				$("#formulariocreartarea")[0].reset();
			}
		});
	});


	//realizamos el for en el jquery para permitir que funcione el required
	for (let year = 2021; year <= 2030; year++) {
		$('#anio_eje').append(`<option value="${year}">${year}</option>`);
	}
	$('#anio_eje').selectpicker('refresh');


	const valorGuardado = localStorage.getItem('sacmostrar');
	if (valorGuardado==1) {
		modopanel();
		$("#verpanel").show();
		$("#vercuadricula").hide();
	}else{
		modocuadricula();
		$("#verpanel").hide();
		$("#vercuadricula").show();
	}
		actualizarEstilos(valorGuardado);

		
	
}


function guardarLocal(valor) {
  localStorage.setItem('sacmostrar', valor);
  if (valor==1) {
    modopanel();
	$("#verpanel").show();
	$("#vercuadricula").hide();
  }else{
	modocuadricula();
	$("#verpanel").hide();
	$("#vercuadricula").show();
  }
  actualizarEstilos(valor);

}

function actualizarEstilos(valor) {
  const btnPanel = document.getElementById('btn-panel');
  const btnCuadricula = document.getElementById('btn-cuadricula');

  if (valor == 1) {
    btnPanel.classList.add('text-primary');
    btnCuadricula.classList.remove('text-primary');
  } else if (valor == 2) {
    btnCuadricula.classList.add('text-primary');
    btnPanel.classList.remove('text-primary');
  }
}

//Función para mostrar nombre de la meta 
function modopanel(){

	$("#mostrar_metas").show();
	$("#mostrar_ocultar_metas").hide();
	$("#ocultar_boton_volver").show();
	$.post("../controlador/sac_listar_dependencia.php?op=modopanel",{ },function(data){
		data = JSON.parse(data);
		// $("#myModalNombreMetaUsuario").modal("show");
		$("#datopanel").html(data);
		$("#precarga").hide();
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
					url: '../controlador/sac_listar_dependencia.php?op=modocuadricula',
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

	$('#tbcuadricula').on('draw.dt', function () {
		activarEdicionFecha(); // Muy importante
		activarEdicionFechaFinal();  // Para fecha final
		activarEdicionNombreMeta(); //  Agregado
		activarEdicionTarea();
		
	});
}

function detalle(id_meta){
	cerrarPopoverTarea();
	$.post("../controlador/sac_listar_dependencia.php?op=detalle",{id_meta:id_meta},function(data){
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$("#detalleconte").html(data);
	});
}

function cambiofechainicio(nuevaFecha, id_meta) {
	$.post("../controlador/sac_listar_dependencia.php?op=cambiofechainicio",{nuevaFecha:nuevaFecha, id_meta:id_meta },function(data){
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Fecha actualizada",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar la fecha",
			showConfirmButton: false,
			timer: 1500
			});
		}
	});

}

function activarEdicionFecha() {
	document.querySelectorAll(".fecha-editable").forEach(function(span) {
		span.addEventListener("click", function handler() {
			const fecha = this.dataset.fecha;
			const id = this.dataset.id;

			const input = document.createElement("input");
			input.type = "date";
			input.value = fecha;
			input.className = "form-control form-control-sm";
			input.style.width = "150px";

			this.replaceWith(input);

			input.addEventListener("change", function () {
				const nuevaFecha = this.value;

				// Llama a tu función personalizada
				cambiofechainicio(nuevaFecha, id);

				// Reemplaza el input con un nuevo span editable
				const nuevoSpan = document.createElement("span");
				nuevoSpan.className = "fecha-editable pointer";
				nuevoSpan.dataset.fecha = nuevaFecha;
				nuevoSpan.dataset.id = id;
				nuevoSpan.textContent = nuevaFecha;

				// Reconectar el evento de clic
				nuevoSpan.addEventListener("click", handler);

				this.replaceWith(nuevoSpan);
			});

			setTimeout(() => input.focus(), 0);
		});
	});
}

function activarEdicionFechaFinal() {
	document.querySelectorAll(".fecha-final-editable").forEach(function (span) {
		span.addEventListener("click", function handler() {
			const fecha = this.dataset.fecha;
			const id = this.dataset.id;

			const input = document.createElement("input");
			input.type = "date";
			input.value = fecha;
			input.className = "form-control form-control-sm";
			input.style.width = "150px";

			this.replaceWith(input);

			input.addEventListener("change", function () {
				const nuevaFecha = this.value;
				cambiofechafinal(nuevaFecha, id);

				const nuevoSpan = document.createElement("div");
				nuevoSpan.className = "fecha-final-editable pointer";
				nuevoSpan.dataset.fecha = nuevaFecha;
				nuevoSpan.dataset.id = id;
				nuevoSpan.textContent = nuevaFecha;
				nuevoSpan.addEventListener("click", handler);

				this.replaceWith(nuevoSpan);
			});

			setTimeout(() => input.focus(), 0);
		});
	});
}

function cambiofechafinal(nuevaFecha, id_meta) {
	$.post("../controlador/sac_listar_dependencia.php?op=cambiofechafinal",{nuevaFecha:nuevaFecha, id_meta:id_meta },function(data){
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Fecha actualizada",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar la fecha",
			showConfirmButton: false,
			timer: 1500
			});
		}
	});

}

function activarEdicionNombreMeta() {
	document.querySelectorAll(".nombremeta-editable").forEach(function (div) {
		div.addEventListener("click", function handler() {
			const nombre = this.dataset.nombre;
			const id = this.dataset.id;

			const input = document.createElement("input");
			input.type = "text";
			input.value = nombre;
			input.className = "form-control form-control-sm p-2";
			input.style.width = "100%";

			this.replaceWith(input);

			input.addEventListener("blur", function () {
				const nuevoNombre = this.value.trim();
				cambionombremeta(nuevoNombre, id);

				const nuevoDiv = document.createElement("div");
				nuevoDiv.className = "nombremeta-editable pointer";
				nuevoDiv.dataset.nombre = nuevoNombre;
				nuevoDiv.dataset.id = id;
				nuevoDiv.style.width = "400px";
				nuevoDiv.style.height = "20px";
				nuevoDiv.style.paddingTop = "3px";
				nuevoDiv.style.overflow = "hidden";
				nuevoDiv.textContent = nuevoNombre;
				nuevoDiv.addEventListener("click", handler);

				this.replaceWith(nuevoDiv);
			});

			setTimeout(() => input.focus(), 0);
		});
	});
}

// editr el responsable

function activarEdicionresponsable() {
	document.addEventListener("click", function (e) {
		if (e.target.classList.contains("editar-responsable")) {
			const span = e.target;
			const id_usuario_actual = span.dataset.id_usuario;
			const id_meta = span.dataset.id_meta;
			const select = document.createElement("select");
			select.className = "form-select selectpicker form-select-sm";
			select.setAttribute("data-live-search", "true");
			select.setAttribute("required", "required");
			select.style.width = "100%";
			select.dataset.id_meta = id_meta;
			$.post("../controlador/sac_listar_dependencia.php?op=selectListarResponsables", function (optionsHTML) {
				select.innerHTML = optionsHTML;
				select.value = id_usuario_actual;
				span.replaceWith(select);
				$(select).selectpicker('render');
				$(select).selectpicker('refresh');
				select.addEventListener("change", function () {
					const nuevo_id_usuario = this.value;
					const nuevo_nombre = this.options[this.selectedIndex].text;
					cambionombreresponsable(nuevo_id_usuario, id_meta);
					const nuevoSpan = document.createElement("span");
					nuevoSpan.className = "editar-responsable small pointer";
					nuevoSpan.dataset.id_usuario = nuevo_id_usuario;
					nuevoSpan.dataset.id_meta = id_meta;
					nuevoSpan.textContent = nuevo_nombre;
					$(select).selectpicker('destroy');
					select.replaceWith(nuevoSpan);
				});
				select.focus();
			});
		}
	});
}

function cambionombreresponsable(id_usuario, id_meta) {

	$.post("../controlador/sac_listar_dependencia.php?op=cambionombreresponsable",{id_usuario:id_usuario, id_meta:id_meta },function(data){
		// console.log(data);
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Nombre Responsable actualizado",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar el nombre",
			showConfirmButton: false,
			timer: 1500
			});
		}
	});

}





function cambionombremeta(nombre, id_meta) {
	$.post("../controlador/sac_listar_dependencia.php?op=cambionombremeta",{nombre:nombre, id_meta:id_meta },function(data){
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Nombre actualizado",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar el nombre",
			showConfirmButton: false,
			timer: 1500
			});
		}
	});

}

function guardarnuevameta() {
    var formData = new FormData($("#formnuevameta")[0]);
    $.ajax({
        url: "../controlador/sac_listar_dependencia.php?op=nuevameta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
			// console.log(datos);
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Meta Registrada",
                showConfirmButton: false,
                timer: 1500
            });

            document.getElementById('formnuevameta').reset();
            $("#modalmeta").modal("hide");
            $('#tbcuadricula').DataTable().ajax.reload();
        }
    });
}

function acciones(id_meta){
	cerrarPopoverTarea();
	$.post("../controlador/sac_listar_dependencia.php?op=acciones",{id_meta:id_meta},function(data){
		data = JSON.parse(data);
		$("#modalacciones").modal("show");
		$("#detalleacciones").html(data);
	});
}

$(document).on("submit", "#formularioaccionguardar", function(e){
    guardaraccion(e);
});


function guardaraccion(e){
    e.preventDefault(); // No se activará la acción predeterminada del evento
    $("#btnGuardarAccion").prop("disabled", true);
    var formData = new FormData($("#formularioaccionguardar")[0]);
    $.ajax({
    "url": "../controlador/sac_listar_dependencia.php?op=guardaraccion",
    "type": "POST",
    "data": formData,
    "contentType": false,
    "processData": false,
    success: function(datos){  
		var obj = JSON.parse(datos);
        Swal.fire({ 
            position: "top-end", 
            icon: "success", 
            title: "Acción Actualizada", 
            showConfirmButton: false, 
            timer: 1500 
        }); 
		// modopanel(meta_responsable_global,fecha_ano_global);
        // Recarga la tabla de acciones
        // $('#refrescar_tabla_accion_insertar').DataTable().ajax.reload(); 
		acciones(obj.id_meta);
        $("#btnGuardarAccion").prop("disabled", false); 
        $("#formularioaccionguardar")[0].reset(); 
		$('#tbcuadricula').DataTable().ajax.reload();
    }
});
}

function cambiofechaaccion(nuevaFecha, id_accion) {

	$.post("../controlador/sac_listar_dependencia.php?op=cambiofechaaccion",{nuevaFecha:nuevaFecha, id_accion:id_accion },function(data){
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Fecha actualizada",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar la fecha",
			showConfirmButton: false,
			timer: 1500
			});
		}
	});

}


function activarEdicionFechaAccion() {
	// Escucha el clic incluso si se crea dinámicamente dentro del DOM del modal
	$(document).on("click", ".fecha-editable-accion", function () {
		const $this = $(this);
		const fecha = $this.data("fecha");
		const id = $this.data("id");

		const input = $("<input>", {
			type: "date",
			class: "form-control form-control-sm",
			val: fecha,
			css: { width: "150px" }
		});

		$this.replaceWith(input);

		input.on("change", function () {
			const nuevaFecha = $(this).val();

			cambiofechaaccion(nuevaFecha, id);

			const nuevoSpan = $("<div>", {
				class: "fecha-editable-accion pointer",
				"data-fecha": nuevaFecha,
				"data-id": id,
				text: nuevaFecha
			});

			$(this).replaceWith(nuevoSpan);
		});

		setTimeout(() => input.trigger("focus"), 0);
	});

}

function eliminar_accion(id_accion,id_meta) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la acción?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/sac_listar_dependencia.php?op=eliminar_accion", { id_accion:id_accion, id_meta:id_meta }, function (data) {
 			obj = JSON.parse(data);
				if (obj.status == 'success') {
					 Swal.fire({
						position: "top-end",
						icon: "success",
						title: "accion Eliminada",
						showConfirmButton: false,
						timer: 1500
					});
					acciones(obj.id_meta);
					$('#tbcuadricula').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción no se puede eliminar.",
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


function cambiarNombreAccion(nuevoNombre, id_accion) {
    $.post("../controlador/sac_listar_dependencia.php?op=cambionombreaccion", {nuevoNombre: nuevoNombre,id_accion: id_accion}, function (data) {
        const respuesta = JSON.parse(data);
        if (respuesta.status === "success") {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Nombre acción actualizado",
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "No se pudo actualizar el nombre de la acción",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

function activarEdicionNombreAccion() {
	$(document).on("click", ".nombreaccion-editable", function () {
		const span = $(this);
		const nombre = span.data("nombre");
		const id = span.data("id");

		const input = $("<input>", {
			type: "text",
			value: nombre,
			class: "form-control form-control-sm",
			css: { width: "100%" }
		});

		span.replaceWith(input);

		input.on("blur", function () {
			const nuevoNombre = $(this).val();

			// Llamar a función para guardar
			cambiarNombreAccion(nuevoNombre, id);

			const nuevoSpan = $("<span>", {
				class: "nombreaccion-editable pointer",
				"data-nombre": nuevoNombre,
				"data-id": id,
				text: nuevoNombre
			});

			$(this).replaceWith(nuevoSpan);
		});

		setTimeout(() => input.focus(), 0);
	});

}

function CrearTarea(id_accion, id_meta) {
    
    $('#responsable_tarea').selectpicker('refresh');
    $('#id_accion_tarea').val(id_accion);
    $('#id_meta_tarea').val(id_meta);
    // $('#ModalCrearTarea').modal('show');
	$.post("../controlador/sac_listar_dependencia.php?op=mostrar_accion_modal", { "id_accion": id_accion }, function(data) {
        data = JSON.parse(data);
        if (Object.keys(data).length > 0) {
            if (data.fecha_fin) {
                $("#fecha_tarea").attr("max", data.fecha_fin);
            } else {
                $("#fecha_tarea").removeAttr("max");
            }
        } else {
            $("#fecha_tarea").removeAttr("max");
        }
        $('#ModalCrearTarea').modal('show');
    });

}

function cerrarPopoverTarea() {
  // Remueve cualquier popover creado dinámicamente
  document.querySelectorAll('#modalacciones .modal-body > .popover-tarea:not(#popoverFormularioTarea)').forEach(el => el.remove());
  // Oculta el formulario original (opcional)
  $("#popoverFormularioTarea").addClass("d-none");
}

function CrearTareaPopover(event, id_accion, id_meta) {
    event.stopPropagation();

    cerrarPopoverTarea();

    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverFormularioTarea");

    // Posicionar
    const modalBody = document.querySelector("#modalacciones .modal-body");
    const modalRect = modalBody.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();

    const popoverWidth = 300;
    const offsetTop = buttonRect.top - modalRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - modalRect.left - popoverWidth + boton.offsetWidth;

    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";

    // Mover el popover al contenedor
    modalBody.appendChild(popover);

    // Asignar valores
    document.getElementById("id_accion_tarea").value = id_accion;
    document.getElementById("id_meta_tarea").value = id_meta;
}





function cerrarPopoverTarea() {
    const popover = document.querySelector("#popoverFormularioTarea");
    popover.style.display = "none";
	    // Limpiar campos del formulario
    document.getElementById("formulariocreartarea").reset();

    // Si usas selectpicker de Bootstrap:
    $('.selectpicker').val('').selectpicker('refresh');
}


function mostrar_accion_modal(id_accion){
	$.post("../controlador/sac_listar_dependencia.php?op=mostrar_accion_modal",{"id_accion" : id_accion},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$(".id_accion").val(data.id_accion);
			$("#nombre_accion").val(data.nombre_accion);
			$("#id_meta_accion").val(data.id_meta);
			$("#fecha_accion").val(data.fecha_accion);
			$("#fecha_fin").val(data.fecha_fin);
			$("#fecha_fin").val(data.fecha_fin);
			$("#hora_accion").val(data.hora);
			$("#ModalAccion").modal("show");
			$("#myModalNombreMetaUsuario").modal("hide");
			$("#formularioguardometa").modal("hide");

			
			// let fecha_fin = data.fecha_fin; // debe estar en formato yyyy-mm-dd
            // // Poner límite max en el input de fecha
            // $("#fecha_tarea").attr("max", fecha_fin);

			$.post("../controlador/sac_listar_dependencia.php?op=listar_marcadas_meta", { "id_meta": data.id_meta }, function(metaData) {
                metaData = JSON.parse(metaData);
                if (Object.keys(metaData).length > 0) {
                    let meta_fecha = metaData.meta_fecha;
                    $("#fecha_fin").attr("max", meta_fecha);
                } else {
                    $("#fecha_fin").removeAttr("max");
                }
                $("#ModalAccion").modal("show");
            });
		}
	});
}

function guardarcreoyeditometa(e) {
	e.preventDefault(); 
	var formData = new FormData($("#formulariocrearmetaeditar")[0]);
	$.ajax({
		"url": "../controlador/sac_listar_dependencia.php?op=guardarcreoyeditometa",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Meta Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			//lo usamos para refrescar la tabla cuando abrimos la meta en caso de que el id_meta venga lleno no se ejecuta la funcion.
			var id_meta = $("#id_meta").val();
            if (id_meta !== "") {
				modopanel(meta_responsable_global, fecha_ano_global);
			}else{
				// $('#tbllistado').DataTable().ajax.reload();
			}
			$("#myModalMeta").modal("hide");
			$("#formulariocrearmetaeditar").modal("hide");
		}
	});
}
//Función mostrar formulario
function mostrarform(flag){
	if (flag){
		$("#listadoregistros").hide();
	}else{
		$("#listadoregistros").show();
	
	}
}
function terminar_accion_dependencia(id_accion) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de terminar la acción?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/sac_listar_dependencia.php?op=terminar_accion", { 'id_accion' : id_accion }, function (e) {
				
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción Terminada con éxito.",
						icon: "success"
					});
					modopanel(meta_responsable_global,fecha_ano_global);
					// $("#myModalNombreMetaUsuario").modal("hide");
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción no se puedo terminar.",
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
// limpiamos el modal a la hora de insertar para que no tome los datos anteriores en caso de que lo editen.
$('#modalmeta').on('show.bs.modal', function () {
    limpiarFormularioNuevaMeta();
});

function limpiarFormularioNuevaMeta() {
    const formulario = $('#formnuevameta');

    formulario.find("input[type='text'], input[type='number'], input[type='date'], input[type='email'], textarea").val('');
    formulario.find("select").val('').change();
    formulario.find("select").prop('selectedIndex', 0);
    formulario.find("select.selectpicker").selectpicker('refresh');
    formulario.find("input[type='checkbox'], input[type='radio']").prop('checked', false);
    formulario.find(".is-invalid, .is-valid").removeClass("is-invalid is-valid");
}

//crea la meta desde los seguimientos
function crear_meta() {
	 limpiarFormularioNuevaMeta();
    // limpiamos todos los campos del modal
    $("#myModalMeta").find("input[type='text'], input[type='number'], input[type='date'], textarea").val('');
    $("#myModalMeta").find("select").prop('selectedIndex', 0); 
    $("#myModalMeta").find("input[type='checkbox'], input[type='radio']").prop('checked', false);
    $("#myModalNombreMetaUsuario").modal("hide");
	// abrimos el modal
	$("#myModalMeta").modal("show");
	$("#editarycrearmeta").html("Crear Meta");
	$("#campo_ejes").show();
	// $("#nombre_ejes").attr("required", "required");
	$("#mostrar_ocultar_proyectos").show();
	// $("#nombre_proyectos").attr("required", "required");
	$("#nombre_ejes").selectpicker('refresh');
    $("#nombre_proyectos").selectpicker('refresh');
    $("#meta_responsable").selectpicker('refresh');


}

function mostrarproyectos(id_ejes) {
    $.post("../controlador/sac_listar_dependencia.php?op=selectListarProyectos", { id_ejes: id_ejes }, function (datos) {
        $("#nombre_proyectos").html(datos);
        $("#nombre_proyectos").attr("required", true);
        $("#nombre_proyectos").selectpicker('refresh');
    });
}

function mostrarproyectos_insertar(id_ejes) {
    $.post("../controlador/sac_listar_dependencia.php?op=selectListarProyectos", { id_ejes: id_ejes }, function (datos) {
        $("#id_proyecto").html(datos);
        $("#id_proyecto").attr("required", true);
        $("#id_proyecto").selectpicker('refresh');
    });
}


//Función para mostrar nombre de la meta 
function nombre_accion_usuario(meta_responsable){
	
	$.post("../controlador/sac_listar_dependencia.php?op=nombre_accion_usuario",{ "meta_responsable": meta_responsable },function(data){
		data = JSON.parse(data);
		$("#myModalNombreAccionUsuario").modal("show");
		$(".meta_responsable_accion").html(data);
	});
}
function actualizar_estado_meta(id_meta) {
    var estadoMeta = $('input[name="meta_lograda"]:checked').val();
    $.post("../controlador/sac_listar_dependencia.php?op=editarestadometa", {
        id_meta: id_meta,
        estado_meta: estadoMeta
    }, function(data) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Estado Meta Actualizada",
            showConfirmButton: false,
            timer: 1500
        });
        $('#tbllistado').DataTable().ajax.reload();
        $("#myModalNombreMetaUsuario").modal("hide");
        // $("#precarga").hide();
    });
}

function historico_tabla_indicadores() {
    $.post("../controlador/sac_listar_dependencia.php?op=historico_tabla_indicadores", { "id_meta_global": id_meta_global }, function (data) {
        data = JSON.parse(data);
        $("#tabla_indicadores").html(data);
        $("#tabla_indicadores").show();
    
    });
}
// function buscar(){

// 	var periodo_sac = $('#periodo_sac').val();
// 	$("#precarga").show();
// 	$("#dato_periodo").html("Seguimiento " + periodo_sac);
// 	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
// 	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
// 	var f=new Date();
// 	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
// 	tabla=$('#tbllistado').dataTable(
// 	{
// 		"aProcessing": true,//Activamos el procesamiento del datatables
// 	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
// 	    dom: 'Bfrtip',
// 				buttons: [

// 					{
// 						extend:    'excelHtml5',
// 						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
// 						titleAttr: 'Excel'
// 					},

// 					{
// 						extend: 'print',
// 						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
// 						messageTop: '<div style="width:50%;float:left">Asesor <br><b>Fecha de Impresión</b>: periodo_</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
// 						title: 'Reporte consultas',
// 						titleAttr: 'Print'
// 					},
// 				],
// 		"ajax":
// 			{
// 				url: '../controlador/sac_listar_dependencia.php?op=listar_tabla_campana&periodo_sac='+periodo_sac,
// 				type : "get",
// 				dataType : "json",						
// 				error: function(e){
					
// 				}
// 			},
// 			"bDestroy": true,
//             "iDisplayLength": 10,//Paginación
// 			"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
// 			'initComplete': function (settings, json) {
// 				$("#listadoregistros").show();
// 				// $("#precarga").hide();
				
// 			},
//     });
// }


function limpiar() {
	$("#meta_nombre").val("");
	$("#meta_nombre").change();
	$("#indicador").val("");
	$("#indicador").change();

}

function limpiarFormularioNuevaMeta() {
    const formulario = $('#formnuevameta');

    // Limpia todos los inputs (text, number, date, etc.)
    formulario.find("input[type='text'], input[type='number'], input[type='date'], input[type='email'], textarea").val('');

    // Reinicia selects
    formulario.find("select").prop('selectedIndex', 0);
    formulario.find("select").val('').change(); // Limpia valor seleccionado

    // Reinicia selectpicker (si estás usando Bootstrap Select)
    formulario.find("select.selectpicker").selectpicker('refresh');

    // Quita checks de checkboxes y radios
    formulario.find("input[type='checkbox'], input[type='radio']").prop('checked', false);

    // Limpia feedback de validaciones si existiera
    formulario.find(".is-invalid, .is-valid").removeClass("is-invalid is-valid");

    // Si hay campos con texto en mayúsculas automático, no se necesita nada extra (se aplica al cambiar).
}


//se edita la meta 
function listar_marcadas_meta(id_meta) {
	id_meta_global = id_meta;
	$("#mostrar_ocultar_proyectos").hide();
	$("#mostrar_ocultar_proyectos").hide();
	// $("#myModalNombreMetaUsuario").modal("show");
	$.post("../controlador/sac_listar_dependencia.php?op=listar_marcadas_meta", { "id_meta": id_meta }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#editarycrearmeta").html("Editar Meta");
			$("#myModalMeta").modal("show");
			$("#myModalNombreMetaUsuario").modal("hide");
			$(".id_meta").val(data.id_meta);
			$("#meta_nombre").val(data.meta_nombre);
			$(".id_proyecto").val(data.id_proyecto);
			$("#meta_fecha").val(data.meta_fecha);
			$("#nombre_indicador").val(data.nombre_indicador);
			$("#porcentaje_avance_indicador").val(data.porcentaje_avance);
			
			$("#anio_eje").val(data.anio_eje);
			$("#anio_eje").selectpicker('refresh');
			$("#nombre_ejes").val(data.id_ejes);
			$("#nombre_ejes").selectpicker('refresh');
			// mostrarproyectos(data.id_ejes);	
			mostrarproyectos(data.id_ejes, function() {
                $("#nombre_proyectos").val(data.id_proyecto);
                $("#nombre_proyectos").selectpicker('refresh');
            });
			// $("#nombre_proyectos").val(data.id_proyecto);
			// $("#nombre_proyectos").selectpicker('refresh');
			$("#plan_mejoramiento").val(data.plan_mejoramiento);
			$("input[name=meta_lograda][value=" + data.estado_meta + "]").prop('checked', true);
			$("input[name=meta_lograda]").parent().removeClass("active");
			$("input[name=meta_lograda][value=" + data.estado_meta + "]").parent().addClass("active");
			$("#meta_responsable").val(data.meta_responsable);
			$("#meta_responsable").selectpicker('refresh');
			if (data.condicion_institucional && Array.isArray(data.condicion_institucional)) {
				$("#box_condiciones_institucionales").find('[value=' + data.condicion_institucional.join('], [value=') + ']').prop("checked", true);
			}
			if (data.dependencias && Array.isArray(data.dependencias)) {
				$("#dependencias").find('[value=' + data.dependencias.join('], [value=') + ']').prop("checked", true);
			}

			let meta_fecha = data.meta_fecha; // debe estar en formato yyyy-mm-dd
            // Poner límite max en el input de fecha
            $("#fecha_fin").attr("max", meta_fecha);
			
			

		}
	});
}


function eliminar_meta_listar_dependencia(id_meta) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar la meta?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.post(
					"../controlador/sac_listar_dependencia.php?op=eliminar_meta_listar_dependencia",
					{ id_meta: id_meta },
					function (e) {
                        data = JSON.parse(e);
						if (data !== null) {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Meta eliminado con éxito.",
								icon: "success",
							});
							// $('#tbllistado').DataTable().ajax.reload();
							$("#myModalNombreMetaUsuario").modal("hide");
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Meta no se puede eliminar.",
								icon: "error",
							});
						}
					}
				);
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelado",
					text: "Tu proceso está a salvo :)",
					icon: "error",
				});
			}
		});
}



function volver() {
	$("#mostrar_metas").hide();
	$("#ocultar_boton_volver").hide();
	$("#mostrar_ocultar_metas").show();
}


function agregaraccion(id_meta) {
	$("#formularioaccionguardar")[0].reset(); 
	$("#id_meta_accion").val(id_meta);        
	// $("#ModalAccion").modal("show"); 
	
	$.post("../controlador/sac_listar_dependencia.php?op=listar_marcadas_meta", { "id_meta": id_meta }, function (data) {
        data = JSON.parse(data);
        if (Object.keys(data).length > 0) {
            let meta_fecha = data.meta_fecha;
            $("#fecha_fin").attr("max", meta_fecha);
        } else {
            $("#fecha_fin").removeAttr("max");
        }
        $("#ModalAccion").modal("show");
		$("#myModalNombreMetaUsuario").modal("hide");
		
    });


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
			$.post("../controlador/sac_listar_dependencia.php?op=terminar_tarea_accion", { 'id_tarea_sac' : id_tarea_sac }, function (e) {
				
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Tarea Terminada con éxito.",
						icon: "success"
					});
					modopanel(meta_responsable_global,fecha_ano_global);
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


function mostrar_tarea(id_tarea_sac, id_accion){
	$.post("../controlador/sac_listar_dependencia.php?op=mostrar_tarea",{"id_tarea_sac" : id_tarea_sac},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#ModalCrearTarea").modal("show");
			$("#id_tarea_sac").val(data.id_tarea_sac);
			$("#nombre_tarea").val(data.nombre_tarea);
			$("#fecha_tarea").val(data.fecha_entrega_tarea);
			$("#responsable_tarea").val(data.responsable_tarea);
			$("#responsable_tarea").selectpicker('refresh');
			$("#link_tarea").val(data.link_evidencia_tarea);
			// tomamos la fecha que esta en base de datos 
			if(id_accion) {
                $.post("../controlador/sac_listar_dependencia.php?op=mostrar_accion_modal", { "id_accion": id_accion }, function(actionData) {
                    actionData = JSON.parse(actionData);
                    if(actionData && actionData.fecha_fin){
                        $("#fecha_tarea").attr("max", actionData.fecha_fin);
                    } else {
                        $("#fecha_tarea").removeAttr("max");
                    }
                });
            } else {
                $("#fecha_tarea").removeAttr("max");
            }
		}
	});
}


function eliminar_tareas(id_tarea_sac,fila) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar la tarea?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.post(
					"../controlador/sac_listar_dependencia.php?op=eliminar_tareas",
					{ id_tarea_sac: id_tarea_sac },
					function (e) {
                        data = JSON.parse(e);
						if (data !== null) {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Tarea eliminado con éxito.",
								icon: "success",
							});
							// modopanel(meta_responsable_global,fecha_ano_global);
							$('#tbcuadricula').DataTable().ajax.reload();
							$("#filatareas"+ fila).hide()
						
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Tarea no se puede eliminar.",
								icon: "error",
							});
						}
					}
				);
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelado",
					text: "Tu proceso está a salvo :)",
					icon: "error",
				});
			}
		});
}



// agregamos para editar el nombre de la tarea cuando le dan click
function activarEdicionTarea() {
	$(document).on("click", ".nombre_editar_tarea", function () {
		const span = $(this);
		const nombre = span.data("nombre");
		const id_tarea_sac = span.data("id");
		const input = $("<input>", {
			type: "text",
			value: nombre,
			class: "form-control form-control-sm",
			css: { width: "100%" }
		});
		span.replaceWith(input);
		input.on("blur", function () {
			const nuevoNombre = $(this).val();
			cambiarNombreTarea(nuevoNombre, id_tarea_sac);
			const nuevoSpan = $("<span>", {
				class: "nombre_editar_tarea pointer",
				"data-nombre": nuevoNombre,
				"data-id": id_tarea_sac,
				text: nuevoNombre
			});
			$(this).replaceWith(nuevoSpan);
		});
		setTimeout(() => input.focus(), 0);
	});

}
function cambiarNombreTarea(nuevoNombre, id_tarea_sac) {
    $.post("../controlador/sac_listar_dependencia.php?op=cambionombretarea", {nuevoNombre: nuevoNombre,id_tarea_sac: id_tarea_sac}, function (data) {
        const respuesta = JSON.parse(data);
        if (respuesta.status === "success") {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Nombre tarea actualizado",
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "No se pudo actualizar el nombre de la tarea",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}



function activarEdicionresponsableTarea() {
	document.addEventListener("click", function (e) {
		if (e.target.classList.contains("editar-responsable-tarea")) {
			const span = e.target;
			const id_usuario_actual = span.dataset.id_usuario;
			const id_tarea_sac = span.dataset.id_tarea_sac;
			const select = document.createElement("select");
			select.className = "form-select selectpicker form-select-sm";
			select.setAttribute("data-live-search", "true");
			select.setAttribute("required", "required");
			select.style.width = "100%";
			select.dataset.id_tarea_sac = id_tarea_sac;
			$.post("../controlador/sac_listar_dependencia.php?op=selectListarResponsables", function (optionsHTML) {
				select.innerHTML = optionsHTML;
				select.value = id_usuario_actual;
				span.replaceWith(select);
				$(select).selectpicker('render');
				$(select).selectpicker('refresh');
				select.addEventListener("change", function () {
					const nuevo_id_usuario = this.value;
					const nuevo_nombre = this.options[this.selectedIndex].text;
					cambionombreresponsableTarea(nuevo_id_usuario, id_tarea_sac);
					const nuevoSpan = document.createElement("span");
					nuevoSpan.className = "editar-responsable-tarea small pointer";
					nuevoSpan.dataset.id_usuario = nuevo_id_usuario;
					nuevoSpan.dataset.id_tarea_sac = id_tarea_sac;
					nuevoSpan.textContent = nuevo_nombre;
					$(select).selectpicker('destroy');
					select.replaceWith(nuevoSpan);
				});
				select.focus();
			});
		}
	});
}

function cambionombreresponsableTarea(id_usuario, id_tarea_sac) {

	$.post("../controlador/sac_listar_dependencia.php?op=cambionombreresponsableTarea",{id_usuario:id_usuario, id_tarea_sac:id_tarea_sac },function(data){
		// console.log(data);
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Nombre Responsable actualizado",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar el nombre",
			showConfirmButton: false,
			timer: 1500
			});
		}
	});

}


//cambiar la fecha de la tarea
function activarEdicionFechaAccion() {
	// Escucha el clic incluso si se crea dinámicamente dentro del DOM del modal
	$(document).on("click", ".fecha-editable-tarea", function () {
		const $this = $(this);
		const fecha = $this.data("fecha");
		const id = $this.data("id");

		const input = $("<input>", {
			type: "date",
			class: "form-control form-control-sm",
			val: fecha,
			css: { width: "150px" }
		});

		$this.replaceWith(input);

		input.on("change", function () {
			const nuevaFecha = $(this).val();

			cambiofechatarea(nuevaFecha, id);

			const nuevoSpan = $("<div>", {
				class: "fecha-editable-tarea pointer",
				"data-fecha": nuevaFecha,
				"data-id": id,
				text: nuevaFecha
			});

			$(this).replaceWith(nuevoSpan);
		});

		setTimeout(() => input.trigger("focus"), 0);
	});

}


function cambiofechatarea(nuevaFecha, id_tarea_sac) {

	$.post("../controlador/sac_listar_dependencia.php?op=cambiofechatarea",{nuevaFecha:nuevaFecha, id_tarea_sac:id_tarea_sac },function(data){
		data = JSON.parse(data);
		if(data.status == "success"){
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Fecha actualizada",
			showConfirmButton: false,
			timer: 1500
			});
		}else{
			Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error al actualizar la fecha",
			showConfirmButton: false,
			timer: 1500
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
				"title": 'Seleccionar Periodo',
				"element": document.querySelector('#seleccionar_periodo'),
				"intro": 'Muestra el reporte por periodo'
			},
			{
				"title": 'Reporte Proyectos',
				"element": document.querySelector('#tabla_ejemplo'),
				"intro": 'Muestra los nombres de cada director y la cantidad de metas que tiene cada uno.'
			},
			{
				"title": 'Porcentaje Avance',
				"element": document.querySelector('#porcentaje_avance'),
				"intro": 'Muestra el avance por medio de porcentaje de las metas cumplidas por cada coordinador.'
			}
		]
	},
	).start();
}
init();










