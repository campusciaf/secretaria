var id_ = "";
var ciclo_ = "";
var materia_ = "";
var jornada_ = "";
var id_programa = "";
var grupo = "";
var ciclo_h = "";
var huella_homologacion = "";
var api; // variable global para inicializar el responsive
var anchoVentana = window.innerWidth; // ancho de la ventana
//Función que se ejecuta al inicio
function init() {
	listarEstudiantes();
}

//Función Listar
function listarEstudiantes() {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
	tabla = $("#tbllistadogrupos").dataTable({
		"aProcessing": true, //Activamos el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		"dom": "Bfrtip", //Definimos los elementos del control de tabla
		"buttons": [{
			"extend": "excelHtml5",
			"text": '<i class="fa fa-file-excel" style="color: green"></i>',
			"titleAttr": "Excel",
		}, {
			"extend": "print",
			"text": '<i class="fas fa-print" style="color: #ff9900"></i>',
			"messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
			"title": "Ejes",
			"titleAttr": "Print",
		}],
		"ajax": {
			"url": "../controlador/InvitacionesGrados.php?op=listarEstudiantes",
			"type": "get",
			"dataType": "json",
			error: function (e) {
			},
		},
		"bDestroy": true,
		"initComplete": function (settings, json) {
			$("#precarga").hide();
		}
	});
}

// Generar QR y mostrar el modal
function generarQR(doc_visitante) {
    /*
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
	$("#table-responsive").hide();
	$("#listadoregistrosgrupos").hide();
	$("#precarga").show();
    */
	$.post(
		"../controlador/InvitacionesGrados.php?op=generarQR",
		{ "doc_visitante": doc_visitante },
		function (data, status) {
            var r = JSON.parse(data);

            console.log(r)

            if (r.file) {
                Swal.fire({
                    title: "Código QR generado",
                    html: '<img src="http://localhost/campus-virtual/' + r.file + '" style="width:200px;height:200px;">',
                    confirmButtonText: "Cerrar"
                });
            } else {
                Swal.fire("Error", "No se pudo generar el QR", "error");
            }
		}
	);
}


init();
