$(document).ready(incio);
function incio() {
    ListarFuncionarios();
}
function ListarFuncionarios(){
    var tabla_listar_docentes = $("#dtl_docente_hoja_vida").DataTable({
        "aProcessing": true, 
        "aServerSide": true, 
        "dom": "Bfrtip",
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": "Excel",
            "exportOptions": {
                "columns": ":visible",
            },
        }],
        "ajax": {
            "url": "../controlador/reporte_hoja_vida_docentes.php?op=listar_docentes",
            "type": "get",
            "dataType": "json",
            // error: function (e) { console.log(e.responseText); },
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [[1, "asc"]],
        "initComplete": function (settings, json) {
            $("#precarga").hide();
        },
        "columnDefs": [
            {"visible": false, "targets": [9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27], "className": 'hidden' }
        ]
    });
    $("a.toggle-vis").on("click", function (e) { 
        var column = tabla_listar_docentes.column($(this).attr("data-column"));
        column.visible(!column.visible());
    });
}
function activarBotonDt(boton) {
  $(boton).toggleClass("btn-danger");
}

function ocultarBotonDt(boton_2) {
  $(boton_2).addClass("btn-danger");
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
				title: 'Usuarios',
				intro: "Bienvenido a nuestra gestión de información sobre todos nuestros seres originales"
			},
		
		
			
		]
			
	},
	
	).start();

}