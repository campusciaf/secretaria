$(document).ready(inicio);
function inicio() {
    $("#precarga").hide();
    buscar(1);
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
				title: 'Trazabilidad Tareas',
				intro: "Bienvenido a nuestro modulo de tranzabilidad de tareas donde podrás visualizar a las personas a las que se le han asignado acda uno de nuestros colaboradores"
			},
			{
				title: 'Usuario cambio',
				element: document.querySelector('#t-uc'),
				intro: "Aquí podrás encontrar el nombre nuestro colaborador a quien se la ha asignado la tarea"
			},
			{
				title: 'Fecha realizacón',
				element: document.querySelector('#t-fr'),
				intro: "Aquí podrás encontrar la fecha en la cual se ha asignado esta tarea con una hora de realización "
			},
			{
				title: 'Id tarea',
				element: document.querySelector('#t-it'),
				intro: "Da un vistazo el número de registro único de cada tarea"
			},
			{
				title: 'Fecha anterior',
				element: document.querySelector('#t-fa'),
				intro: "Aquí encontrarás la fecha anterior de la tarea asignada"
			},
			{
				title: 'Nueva fecha',
				element: document.querySelector('#t-nf'),
				intro: "Da un vistazo a la nueva fecha que se ha asigando a esta tarea para que sea cumplida y así seguir siendo un parche creativo e innoavdor teniendo sus tareas al día "
			},
			
			
			
			
			

		]
			
	},
	console.log()
	
	).start();

}


function buscar(val) {
    $("#precarga").show();
    $.post("../controlador/oncentertrazabilidad.php?op=buscar",{val:val},function (data) {
        //console.log(data);
        var r = JSON.parse(data);
        $(".datos").html(r.conte);
        $("#tbl_datos").DataTable({
            "dom": 'Bfrtip',
            buttons: [{
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel" style="color: green"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-alt"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf" style="color: red"></i>',
                titleAttr: 'PDF',
     
            }],

			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
      });
	
		
});
}
//Función para guardar o editar