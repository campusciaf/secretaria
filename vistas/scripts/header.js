$(document).ready(inicio);
function inicio() {
    listarTema();
    listarPuntos();
    listar_notificaciones();
    verperfilactualizado();
    codigo();
    $("#formularioperfil").on("submit",function(e){
		actualizarperfil(e);	
	});

    buscarTareas();
}

function listarPuntos(){
    $.post("../controlador/header.php?op=listarPuntos", function (datos) {
        data = JSON.parse(datos);
        $("#mispuntos").html(data.exito);
       // $("#nivel").html(data.nivel);
    });
}


function cambia_estado_remision(id) {
    $.post("../controlador/quedatevercaso.php?op=cambia_estado_remision", { id: id }, function (datos) {
    });
}

function listar_notificaciones() {
    $.post("../controlador/quedatevercaso.php?op=listar_notificaciones", function (datos) {
        var r = JSON.parse(datos);
        $("#menu_notificaciones").html(r.conte);
        $(".cantidad_notifi").html(r.cantidad);
        $(".mensaje_cantidad").html('Tienes '+r.cantidad+' notificaciones');
    });
}

function verperfilactualizado() {
    $.post("../controlador/header.php?op=verperfilactualizado", function (datos) {     
        var r = JSON.parse(datos);
        if(r.estado==2){// paso el tiempo es hora de actualizar
            mostrar();
        }else{
            $("#perfil").modal("hide");// perfil esta actaulziado detro del rango
        }
    });
}

function mostrar(){
	$.post("../controlador/header.php?op=mostrar",{}, function(data, status){
		data = JSON.parse(data);
        $("#usuario_email").val(data.usuario_email);
		$("#usuario_telefono").val(data.usuario_telefono);
		$("#usuario_celular").val(data.usuario_celular);
        $("#usuario_direccion").val(data.usuario_direccion);

        $("#perfil").modal({backdrop: 'static', keyboard: false});
        $("#perfil").modal("show");
   
    });
}

function actualizarperfil(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioperfil")[0]);

	$.ajax({
		url: "../controlador/header.php?op=actualizarperfil",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
            data = JSON.parse(datos);
            if(data.estado="si"){
                alertify.success("Datos actualizados");
                verperfilactualizado();	 
                limpiarperfil(); 
            }else{
                alertify.error("Datos no actualizados");
            }	
            
	    }
	});
	
}

//Función limpiar
function limpiarperfil(){
    $("#usuario_email").val("");
    $("#usuario_telefono").val("");
    $("#usuario_celular").val("");
    $("#usuario_direccion").val("");

}
// codigo qr
function codigo() {
    $.post("../controlador/header.php?op=generarqradminis", function (e) {
        try {
            var r = JSON.parse(e);
            if (r.status == "ok") {
                $("#codigo").html(r.conte);
            }
        } catch (error) {
            console.log("Error al generar QR");
        }
    });
}


function datosCarnet() {
    $.post("../controlador/header.php?op=datosCarnet", {  }, function (e) {
        var r = JSON.parse(e);
        if (r.status == "ok") {
            $("#modalcarnet").modal("show");
            $("#frente").html(r.conte);
        } else {
            alertify.error("Error, no se encuentra el funcionario");
        }
    });
} 

// function datosCarnet() {

//     $.post("../controlador/header.php?op=datosCarnet", {  }, function (e) {
//         console.log(e)
//         var r = JSON.parse(e);
//             $("#modalcarnet").modal("show");
//             $("#frente").html(r.conte);
//     });
// }

function listarTema() {
    $.post("../controlador/header.php?op=listarTema", function (e) { 
        var r = JSON.parse(e);
        if(r.conte==1){
            document.documentElement.setAttribute('tema', 'light');
        }else{
            document.documentElement.setAttribute('tema', 'dark');
        }
    });
}


$('#cuenta').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
});

/* codigo para las tareas de mercadeo */

function buscarTareas(){

    $.post("../controlador/header.php?op=buscarPermiso", function (e) {
       
        var r = JSON.parse(e);

        if(r.conte == 0){// si es un asesor con permiso

             setInterval(() => {
                $.post("../controlador/header.php?op=buscarTareas", function (datos) {
                    var res = JSON.parse(datos);
                    if(res.conte !=''){
                        console.log(res.conte);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            footer: '<a href="oncentermistareas.php">ir a mis tareas?</a>',
                            showConfirmButton: false,
                            timer: 10000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.onmouseenter = Swal.stopTimer;
                              toast.onmouseleave = Swal.resumeTimer;
                            }
                          });
                          Toast.fire({
                            icon: "success",
                            title: res.conte
                          });
                    }
                });
            }, 10000);
            
        }

    });
   
}



