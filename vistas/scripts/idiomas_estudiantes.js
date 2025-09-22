$(document).ready(inicio);
function inicio() {
    listar();
}

function listar() {
    $.post("../controlador/idiomas_estudiantes.php?op=listar", function(datos){
            //console.log(datos);
            var r = JSON.parse(datos);            
            $("#contenido").html(r.conte);
            $("#tbllistado").DataTable();
    });
      
}

function consulta_cc(val) {
    $.post("../controlador/idiomas_estudiantes.php?op=consulta",{val:val}, function(datos){
        //console.log(datos);
        var r = JSON.parse(datos);
        if (r) {
            $(".custom-select").removeAttr("disabled");
            consulta_programa();
        }
    });
}

function consulta_programa() {
    $.post("../controlador/idiomas_estudiantes.php?op=consulta_programa", function(datos){
        //console.log(datos);
        var r = JSON.parse(datos);
        $("#programas").html(r.conte);
    });
}

function nivel(val) { 
    var valor = 0;
    var conte = '';
    if (val == 105) {
        valor = 4;
    } else {
        valor = 3;
    }
    conte += '<option selected disabled>-Selecciona-</option>';
    for (let index = 0; index < valor; index++) {
        conte += '<option value="'+(index+1)+'">'+(index+1)+'</option>';
    }

    $("#niveles").html(conte);
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
				title: 'Idiomas',
				intro: "Bienvenido a nuestro modulo de idiomas donde podrás agregar a los seres originales que desean inscribirse a nuestro curso de idiomas"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}
