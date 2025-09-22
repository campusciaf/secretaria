var departamento_global;
var valor_global;
function init() {
    listarescuelas();
	$("#mostrar_formulario_estudiante").hide();
	$("#info_personal_formulario").on("submit", function (e) {
        e.preventDefault();;
    });

	$("#precarga").hide();
}
init();
function verificarDocumento(id_credencial_seleccionado) {
 
	var dato = $("#dato_estudiante").val();
    var tipo = $("#tipo").val();
    if (dato != "" && tipo != "") {
		$.post(
			"../controlador/especial_es.php?op=verificar",
			{ "dato": dato,"tipo": tipo,"id_credencial_seleccionado": id_credencial_seleccionado },
			function (data) {
				data = JSON.parse(data);
				if (data.exito == 1) {
					$("#mostrar_formulario_estudiante").hide();
					listarEstudiante(data.info.id_credencial);
					
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
		$("#mostrar_formulario_estudiante").hide();
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Por favor completa los campos.",
			showConfirmButton: false,
			timer: 1500
		});
        

    }
}

/**** FUNCIONES PARA GUARDAR EL FORMULARIO DEL ESTUDIANTE ****/


function filtroportipo(valor) {
    $("#dato_estudiante").prop("disabled", false);
    $("#btnconsulta").prop("disabled", false);
    $("#input_dato_estudiante").show();
    $("#dato_estudiante").val("");
    $("#tipo").val(valor);
	valor_global = valor;
    if(valor == 1){
        $("#valortituloestudiante").html("Ingresar número de identificación")
    }
    if(valor == 2){
        $("#valortituloestudiante").html("Ingresar correo")
    }
    if(valor == 3){
        $("#valortituloestudiante").html("Ingresar número de celular")
    }
    if(valor == 4){
        $("#valortituloestudiante").html("Ingresar nombre")
    }
}

function listarEstudiante(idCredencial) {

	var dato = $("#dato_estudiante").val();
   

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
            "url": "../controlador/especial_es.php?op=listar_datos_estudiantes&id_credencial=" + idCredencial+ "&valor_global=" + valor_global+ "&dato=" + dato,
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
				title: 'Gestión perfiles',
				intro: 'Da un vistazo a nuestro modulo donde podrás observar todos nuestros horarios por salones activos'
			},
			{
				title: 'Salón',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar todos nuestros nuestros salones disponibles para que puedas consultar "
			},
		]
			
	},
	).start();

}

function cambiarEstadoEspecial(id_credencial) {
    $.ajax({
        url: '../controlador/especial_es.php?op=cambiar_estado_especial',
        type: 'POST',
        data: { id_credencial: id_credencial },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.resultado === "exito") {
                Swal.fire({
                    title: "Ejecutado!",
                    text: "Estado actualizado con éxito.",
                    icon: "success",
                    confirmButtonText: "OK"
                     }).then(() => {
            
                });
                
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Error al cambiar el estado.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function() {
            Swal.fire({
                title: "Error!",
                text: "Error en la solicitud AJAX.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
}


function desmarcar(id_credencial) {
    $.ajax({
        url: '../controlador/especial_es.php?op=desmarcar',
        type: 'POST',
        data: { id_credencial: id_credencial },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.resultado === "exito") {
                Swal.fire({
                    title: "Ejecutado!",
                    text: "Se ha desmarcado con éxito.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    $('#tblrenovar').DataTable().ajax.reload(); // Recarga la tabla
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Error al desmarcar el estado.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function() {
            Swal.fire({
                title: "Error!",
                text: "Error en la solicitud AJAX.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
}


function listarescuelas(){
    
	$.post("../controlador/especial_es.php?op=listarescuelas",{}, function(r){
		var e = JSON.parse(r);
		$("#escuelas").html(e.mostrar);
		$("#precarga").hide();
		
	});
}

function listar(id_escuela){

	$("#precarga").show();
    $("#datos_estudiantes").hide();
	// var id_programa = $("#selector_programa").val();
	// var semestre = $("#selector_semestres").val();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f = new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tblrenovar').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": 'Excel'
            },{
                "extend": 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				"title" : 'Docentes',
                "titleAttr": 'Print'
            }],
		"ajax":{
            "url": '../controlador/especial_es.php?op=listar&id_escuela='+id_escuela,
            "type" : "get",
            "dataType" : "json",						
            "error" : function(e){
                console.log(e.responseText);	
            }
        },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
	}).DataTable();
}

function listarEspecialesMatriculados() {
    $('#tablaModalEstudiantes').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            "url": "../controlador/especial_es.php?op=listar_especiales_matriculados",
            "type": "get",
            "dataType": "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "lengthChange": false,
        "order": [[1, "asc"]],
        "responsive": true,
        "autoWidth": false,
        "scrollX": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        },
        "columnDefs": [
            { targets: "_all", className: "text-center align-middle" },
            { targets: 0, width: "5%" } 
        ],
        "initComplete": function(settings, json) {
            $("#precarga").hide();
        }
    });
}


$('#btnListadoEstudiantes').on('click', function() {
    $('#modalListadoEstudiantes').modal('show');
    listarEspecialesMatriculados();
});