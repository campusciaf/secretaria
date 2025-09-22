//Función que se ejecuta al inicio
function init() {
	$("#precarga").hide();
	$("#titulo").hide();
	$("#btn_print").hide();
	$.post("../controlador/reportedocenteprograma.php?op=selectPrograma", function (r) {
		$("#id_programa").html(r);
		$('#id_programa').selectpicker('refresh');
	});
	$.post("../controlador/reportedocenteprograma.php?op=selectPeriodo", function (r) {
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});

	$.post("../controlador/reportedocenteprograma.php?op=selectJornada", function (r) {
		$("#jornada_programa").html(r);
		$('#jornada_programa').selectpicker('refresh');
	});

	$("#buscar").on("submit", function (e) {
		buscar(e);
	});
	
}

//Función para guardar o editar
function buscarDatos() {
	periodo = $('#periodo').val();
	jornada_programa = $('#jornada_programa').val();
	id_programa = $('#id_programa').val();
	if (periodo != "" && jornada_programa != "" && id_programa != "") {
		mostrar_reporte();
	}
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
				title: 'Reporte docente programa',
				intro: 'Bienvenido a nuestro reporte de líderes creativos'
			},
			{
				title: 'programa académico',
				element: document.querySelector('#t-PA'),
				intro: "Aquí podrás consultar el programa académico del cual deseas recibir información "
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-Jo'),
				intro: "Elige la jornada a consultar donde comienza la experiencia creativa"
			},
			{
				title: 'Periodo',
				element: document.querySelector('#t-Pe'),
				intro: "Elige el respectivo periodo a consultar, teniendo en cuenta la información requerida "
			},
			{
				title: 'Semestre 1',
				element: document.querySelector('#t-s1'),
				intro: "Aquí podrás encontrar el semestre al que pertence nuestro líder creativo" 
			},
			{
				title: 'Asignatura',
				element: document.querySelector('#t-As'),
				intro: "Encontrarás la respectiva experiencia creativa lidera por nuestro respectivo docente "
			},
			{
				title: 'Docente',
				element: document.querySelector('#t-Dc'),
				intro: "Aquí podrás encontrar el nombre de nuestro líder creativo"
			},
			{
				title: 'Identificación',
				element: document.querySelector('#t-I'),
				intro: "Da un vistazo a este dato unico de nuestro líder creativo"
			},
			{
				title: 'Horas',
				element: document.querySelector('#t-H'),
				intro: "Aquí podrás encontrar las horas creativas asignadas a nuestro respectivo líder creativo"
			},
			

		]
			
	},
	console.log()
	
	).start();

}
function mostrar_reporte() {
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    var id_programa = $("#id_programa").val();
    var periodo = $("#periodo").val();
    var jornada_programa = $("#jornada_programa").val();
    $.post("../controlador/reportedocenteprograma.php?op=mostrar_reporte", {
        "id_programa": id_programa,
        "periodo": periodo,
        "jornada_programa": jornada_programa
    }, function (data) {
        data = JSON.parse(data);
        $("#reporte_docente").show();
        // Vaciar el contenido anterior del contenedor
        $("#reporte_docente").empty();
        // Recorrer el arreglo y agregar cada tabla al contenedor
        for (var nombreTabla in data) {
            $("#reporte_docente").append(data[nombreTabla]);
        }
        // Inicializar el plugin DataTables solo para las tablas con la clase "tabla-semestre"
        $("#reporte_docente table.tabla-semestre").dataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: "Excel",
                },

				{
					extend: 'print',
					text: '<i class=" text-center fa fa-file-pdf fa-2x" style="color: red"></i>',
					messageTop: '<div style="width:50%;float:left">Reporte Programa<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
					title: 'Reporte Programa',
					titleAttr: 'Print'
				},
                
				
            ],
        });
    });
}

init();