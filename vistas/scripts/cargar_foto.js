$(document).ready(incio);
function incio() {
    $("#formulario_usuario").on("submit",function(e)
	{
		guardaryeditarfuncionario(e);	
	});

    $("#formulario_carga_masiva").on("submit",function(e2)
	{
		guardarfotomasiva(e2);	
	});

}
$("#precarga").hide();

function guardaryeditarfuncionario(e)
{
    // declaramos las variables para saber cual ubicacion(docente, funcionario, estudiante) se selecciona 
    e.preventDefault(); // No se activará la acción predeterminada del evento
    var cedula = $('#cedula').val();
    var ubicacion = $('#ubicacion').val();
    var usuario_imagen = $('#usuario_imagen')[0].files[0];
    $("#imagenmuestra").show();
    // $("#imagenmuestra").attr("src","../files/usuarios/"+usuario_imagen);
    $("#imagenmuestra").val(usuario_imagen);
    var formData = new FormData();
    formData.append("cedula", cedula);
    formData.append("ubicacion", ubicacion);
    formData.append("usuario_imagen", usuario_imagen);
	$.ajax({
		url: "../controlador/cargar_foto.php?op=guardaryeditarfuncionario",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {   
            Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Foto actualiada.",
				showConfirmButton: false,
				timer: 1500
			});
        }

	});
}
// funcion para guardar las fotos masiva.
function guardarfotomasiva(e2)
{
    e2.preventDefault(); // No se activará la acción predeterminada del evento
    var ubicacion_masiva = $('#ubicacion_masiva').val();
    var archivos = $('#carga_masiva_imagen')[0].files; // Obtiene todos los archivos
    var formData = new FormData();
    formData.append("ubicacion_masiva", ubicacion_masiva);
    // Adjunta cada archivo a formData
    for (var i = 0; i < archivos.length; i++) {
        formData.append("carga_masiva_imagen[]", archivos[i]);
    }
    $.ajax({
        url: "../controlador/cargar_foto.php?op=guardarfotomasiva",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {
            Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Fotos actualiadas.",
				showConfirmButton: false,
				timer: 1500
			});
        }
    });
}

function consultaBuscar() {
    var data = ({
        'cedula': $("#cedula").val(),
        'ubicacion': $("#ubicacion").val(),
    });
    
    $.ajax({
        url: "../controlador/cargar_foto.php?op=consultaBuscar",
        type: "POST",
        data: data,
        cdataType: 'json',
        success: function (datos) {
            if (datos == "false") {
                $("#consultaBuscar").html('<div class="alert alert-danger" role="alert">No existe el usuario. </div >');
            } else {
                $("#consultaBuscar").html(datos);
            }
        }
    });

}
