function inicio() {
	$.post("../controlador/paneladmisiones.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
	
 	$("#precarga").hide();

}
function listar(periodo){
    $.post("../controlador/paneladmisiones.php?op=listar",{periodo:periodo}, function (e) {
        var r = JSON.parse(e);
		console.log(r)
        $("#resultado").html(r);

        $("#precarga").hide();
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
				title: 'Panel Comercial',
				intro: "Bienvenido a nuestra gestión de panel comercial visualiza la información de una maenra general"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}

inicio();