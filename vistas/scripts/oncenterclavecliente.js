
$(document).ready(incio);
function incio() {
    $("#precarga").hide();
    $("#form_restaurar_admision").on("submit", function(e) {
        e.preventDefault();
        consultaEstudiante();
    });
}

function consultaEstudiante() {
    var formData = new FormData($("#form_restaurar_admision")[0]);
    $.ajax({
        "url": "../controlador/oncenterclavecliente.php?op=consultaEstudiante",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false, 
        success: function (datos) {
            // console.log(datos);
            datos = JSON.parse(datos);
            if(datos.exito == 1){
                $("#consultaEstu").html(datos.info);
            }else{
                $("#consultaEstu").html(datos.info);
            }
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
				title: 'Restablecer clave',
				intro: 'Bienvenido a nuestro panel para restablacer la clave de nuestro ser creativo'
			},
			{
				title: 'Cosultas',
				element: document.querySelector('#t-Cc'),
				intro: "Aquí podrás ingresar el dato requerido de nuestro ser creativo"
			},
			{
				title: 'Número de caso',
				element: document.querySelector('#t-nc'),
				intro: "Ingresa el número de caso de nuestro ser creativo, con un pequeño click en consultar y tendrás los datos princiaples de nuestro ser creativo"
			},
			{
				title: 'Identificación',
				element: document.querySelector('#t-id'),
				intro: "Da un vistazo a el número de identificación de nuestro ser creativo"
			},
			{
				title: 'Nombre completo',
				element: document.querySelector('#t-nm'),
				intro: "Da un vistazo a su nombre completo"
			},
			{
				title: 'Correo electrónico',
				element: document.querySelector('#t-cl'),
				intro: "Aquí encontrarás el correo electrónico personal de nuestro ser creativo"
			},
			{
				title: 'Completa tu meta',
				element: document.querySelector('#t-cm'),
				intro: "Da un vistazo a el avance de tus metas alcanzando tu objetivo y cumpliendo cada meta creativa"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-cs'),
				intro: "Aquí encontrarás el número de caso de nuestro ser creativo"
			},
			{
				title: 'Campaña',
				element: document.querySelector('#t-cam'),
				intro: "Aquí encontrarás la campaña en la que nuestro ser original ha realizado todo su proceso "
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-es'),
				intro: "Aquí encontrarás el estado de nuestro ser creativo"
			},
			{
				title: 'Tips',
				element: document.querySelector('#t-tip'),
				intro: "Se restablece la clave de nuestro ser creativo con el número del caso"
			},



			
			
			
			

		]
			
	},
	console.log()
	
	).start();

}
function restablecer(id_estudiante) {
    swal({
        "title": "",
        "text": "¿Estás seguro de restablecer la contraseña?",
        "icon": "warning",
        "buttons": ["Cancelar", "Restablecer"],
        "dangerMode": true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#precarga").removeClass("hide");
            var data = ({'id_estudiante': id_estudiante});
            $.ajax({
                "url": "../controlador/oncenterclavecliente.php?op=restablecer_admision",
                "type": "POST",
                "data": data,
                success: function (datos) {
                    // console.log(datos);
                    var r = JSON.parse(datos);
                    if (r.exito == 1) {
                        $("#precarga").addClass("hide");
                        swal(r.info, { "icon": "success" });
                        consultaEstudiante();
                    } else {
                        swal(r.info, { "icon": "error" });
                    }
                }
            });
        }
    });
}



// function reestablecer() {
//     var caso=$("#caso").val();
	
// 	$.post("../controlador/oncenterclavecliente.php?op=mostrar",{caso : caso}, function(data, status)
// 	{
		
// 	    data = JSON.parse(data); 
// 		   alertify.success("Clave Reestablecida");

		 
// 	});
// }

