//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();
	
	$("#titulo").hide();

    //Cargamos los items de los selects sede
	$.post("../controlador/horarioocupacion.php?op=selectSede", function(r){
        $("#sede").html(r);
        $('#sede').selectpicker('refresh');
});

	

	//Cargamos los items de los selects contrato
	$.post("../controlador/horarioocupacion.php?op=selectPeriodo", function(r){
	            $("#periodo").html(r);
	            $('#periodo').selectpicker('refresh');
	});

	$("#buscar").on("submit",function(e){
		buscar(e);	
		
	});

	$("#formularioAgregarGrupo").on("submit",function(e){
		guardaryeditar(e);	
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
				title: 'Horarios',
				intro: 'Da un vistazo a nuestro modulo donde podrás observar todos nuestros horarios por salones activos'
			},
			{
				title: 'Salón',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar todos nuestros nuestros salones disponibles para que puedas consultar "
			},
			{
				title: 'Periodo académico',
				element: document.querySelector('#t-periodo'),
				intro: "Aquí podrás encontrar todos nuestros periodos académicos activos para consultar"
			},

			{
				title: 'Calendario',
				element: document.querySelector('#t-calendario'),
				intro: "En este calendario toda nuestra comunidad académica podrá visualizar los horarios publicados"
			},

			{
				title: 'Tarjeta normal',
				element: document.querySelector('#t-cal-1'),
				intro: "Esta tarjeta nos indica que la asignatura estará presente desde nuestro inicio y final de la etapa creativa"
			},
			{
				title: 'Tarjeta corte2',
				element: document.querySelector('#t-cal-2'),
				intro: "Esta tarjeta nos indica la proxima asignatura que estara en nuestro segundo corte cada ves más creativo e innovador"
			}

		]
			
	},
	console.log()
	
	).start();

}




//Función para guardar o editar

function buscarDatos(){
	periodo		=	$('#periodo').val();
	sede		=   $('#sede').val();
    dia		    =   $('#dia').val();
    jornada		=   $('#jornada').val();

 	if(periodo != "" && sede != ""  && dia != ""  && jornada != ""){
		iniciar(periodo,sede,dia,jornada);
		$("#t-calendario").hide();
	}else{
		$("#precarga").hide();
	}
	
}


function calcularhoras(hasta){
	var horainicial=$("#hora").val();
	$.post("../controlador/horarioocupacion.php?op=calcularHoras", {horainicial:horainicial , hasta:hasta}, function(r){
		$("#diferencia").val(r)

	});
}



function iniciar(periodo,sede,dia,jornada){
    $.post("../controlador/horarioocupacion.php?op=iniciar", {periodo:periodo, sede:sede, dia:dia, jornada:jornada}, function(r){
		var datos = JSON.parse(r);
        console.log(datos);
        $("#resultados").html(datos.datos);

	});

}



init();

