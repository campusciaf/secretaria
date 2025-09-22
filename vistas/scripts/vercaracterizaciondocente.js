var tabla;

function init() {
	// ejecuta la accion para los formularios de guardar y agregar programa
	listar();
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
						title: "Horarios",
						intro:
							"Módulo para consultar los horarios por salones creados en el periodo actual.",
					},
					{
						title: "Docente",
						element: document.querySelector("#t-programa"),
						intro:
							"Campo de opciones que contiene los nombres de los salones activos en plataforma para consultar.",
					},
				],
			},
		)
		.start();
}

function  listar() {
		var tabla_caracterizacion_docente = $("#tbllistado").DataTable({
			aProcessing: true,
			aServerSide: true,
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel',
					exportOptions: {
						columns: ':visible'
					}
				},
			],
			ajax: {
				url: "../controlador/vercaracterizaciondocente.php?op=listar",
				type: "get",
				dataType: "json",
				error: function(e) {
				},
			},
			bDestroy: true,
			iDisplayLength: 10,
			order: [[1, "asc"]],
			initComplete: function(settings, json) {
				$("#precarga").hide();
			},
			columnDefs: [
				{
					visible: false,
					targets: [
						4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22,
						23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39,
						40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53
					],
					className: "hidden",
				},
			],
		});
		
		$("a.toggle-vis").on("click", function(e) {
			var column = tabla_caracterizacion_docente.column($(this).attr("data-column"));
			column.visible(!column.visible());
		});
}

function activarBotonDt(boton) {
	// Si el botón ya tiene la clase 'btn-success', se considera activo y se cambiará a gris (inactivo)
	if ($(boton).hasClass("btn-success")) {
		$(boton).removeClass("btn-success").addClass("btn-secondary");
	} else {
		// Si el botón no tiene la clase 'btn-success', se considera inactivo y se cambiará a verde (activo)
		$(boton).removeClass("btn-secondary").addClass("btn-success");
	}
}

function ocultarBotonDt(boton_2) {
	// Asegura que el botón siempre se cambie a inactivo (gris) cuando se oculte
	$(boton_2).removeClass("btn-success").addClass("btn-secondary");
}



function actualizarEstadoBotones() {
    var tabla = $('#tbllistado').DataTable();

    var todosActivos = $('a.toggle-vis.btn-secondary').length === 0;

    if (todosActivos) {
        // Cambia todos los botones a inactivo excepto los primeros cuatro
        $('a.toggle-vis').addClass('btn-secondary').removeClass('btn-success');
        $('a.toggle-vis').slice(0, 4).addClass('btn-success').removeClass('btn-secondary'); // Asegura los primeros cuatro

        // Oculta todas las columnas
        tabla.columns().visible(false, false);
        // Muestra solo las primeras cuatro columnas
		// Asegurando que las primeras 4 columnas siempre estén visibles
		tabla.columns([0, 1, 2, 3,4]).visible(true, false);

        // tabla.columns(':lt(0)').visible(true, false);
    } else {
        // Activa todos los botones
        $('a.toggle-vis').addClass('btn-success').removeClass('btn-secondary');

        // Asegura que todas las columnas sean visibles, incluida la primera
        tabla.columns().visible(true, false);
    }

    // Ajusta el tamaño de las columnas y redibuja la tabla
    tabla.columns.adjust().draw(false);
}







init();
