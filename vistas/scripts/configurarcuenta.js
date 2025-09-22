$(document).ready(inicio);
	//Cargamos los items de los selects
	$.post("../controlador/configurarcuenta.php?op=selectTipoSangre", function(r){
        $("#usuario_tipo_sangre_p").html(r);
        $('#usuario_tipo_sangre_p').selectpicker('refresh');   
    });

    //Cargamos los items de los selects
	$.post("../controlador/configurarcuenta.php?op=selectDepartamento", function(r){
        $("#usuario_departamento_nacimiento_p").html(r);
        $('#usuario_departamento_nacimiento_p').selectpicker('refresh'); 
    });
      //Cargamos los items de los selects
	$.post("../controlador/configurarcuenta.php?op=selectMunicipio", function(r){
        $("#usuario_municipio_nacimiento_p").html(r);
        $('#usuario_municipio_nacimiento_p').selectpicker('refresh');  
    });

function inicio() {
    mostrar();
    listarDatos();
	$("#precarga").hide();


    $(".guardarDatosPersonales").on("submit", function (e) {
        editarDatosPersona(e);
    });

    $(".guardarDatos").on("submit", function (e) {
        cambiarContra(e);
    });

}

function mostrar()
{
	$.post("../controlador/configurarcuenta.php?op=mostrar",{}, function(data, status)
	{
		data = JSON.parse(data);	

        $("#usuario_nombre_p").val(data.usuario_nombre);
        $("#usuario_nombre_2_p").val(data.usuario_nombre_2);
        $("#usuario_apellido_p").val(data.usuario_apellido);
        $("#usuario_apellido_2_p").val(data.usuario_apellido_2);
        $("#usuario_telefono_p").val(data.usuario_telefono);
        $("#usuario_celular_p").val(data.usuario_celular);

        $("#usuario_departamento_nacimiento_p").val(data.usuario_departamento_nacimiento);
		$("#usuario_departamento_nacimiento_p").selectpicker('refresh');
        $("#usuario_municipio_nacimiento_p").val(data.usuario_municipio_nacimiento);
		$("#usuario_municipio_nacimiento_p").selectpicker('refresh');

        $("#usuario_tipo_sangre_p").val(data.usuario_tipo_sangre);
		$("#usuario_tipo_sangre_p").selectpicker('refresh');

        $("#usuario_direccion_p").val(data.usuario_direccion);
        $("#usuario_fecha_nacimiento_p").val(data.usuario_fecha_nacimiento);

		// $("#usuario_tipo_documento").val(data.usuario_tipo_documento);
		// $("#usuario_tipo_documento").selectpicker('refresh');

	});
		
}

function mostrarmunicipio(departamento) {	
	
    $.post("../controlador/configurarcuenta.php?op=selectMunicipio",{departamento:departamento} ,function (datos) {
        $("#usuario_municipio_nacimiento_p").html(datos);
        $("#usuario_municipio_nacimiento_p").selectpicker('refresh');
    });
}

function listarDatos() {
    $.post("../controlador/configurarcuenta.php?op=listarDatos", function (e) {
        //console.log(e);
        var r = JSON.parse(e);
        $(".mostrar-uno").html(r.conte);
    });
}

function editarDatos(id) {
    $.post("../controlador/configurarcuenta.php?op=editarDatos", { id: id }, function (e) {
        //console.log(e);
        var r = JSON.parse(e);
		$("#form").html(r.conte);
		$("#conte1").show();
		$("#conte2").hide();
		$("#buttuno").show();
    	$("#buttdos").hide();
        $("#editarDatos").modal("show");
    });
}

function editarContrasena(id) {
    $("#restrablecer").modal("show");
    $("#id").val(id);
}

function cambiarContra(e2) {
    e2.preventDefault();
    var formData = new FormData($("#form2")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/configurarcuenta.php?op=cambiarContra",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                Swal.fire({      
                    icon: "success",
                    title: "Contraseña actualizada con Exito",
                    showConfirmButton: false,
                    timer: 1500
                  });
                $("#form2")[0].reset();
                $("#restrablecer").modal("hide");
            } else {
                
                Swal.fire({      
                    icon: "error",
                    title: "error",
                    text: r.status,
                    showConfirmButton: false,
                    timer: 1500
                  });
              
            }
        }
    });

}

function editarDatosPersona(e) {
    $("#precarga").show();
    e.preventDefault();
    var formData = new FormData($("#form")[0]);

            $.ajax({
                type: "POST",
                url: "../controlador/configurarcuenta.php?op=editarDatospersonales",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    data = JSON.parse(datos);
                    console.log(data.estado);
                    if(data.estado == "si"){
                        Swal.fire({
                            icon: "success",
                            title: "Datos actualizados",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        
                        mostrar();
                        listarDatos();
                        $("#precarga").hide();
                    }else{
                        Swal.fire({      
                            icon: "error",
                            title: "error",
                            text: "Proceso rechazado!",
                            showConfirmButton: false,
                            timer: 1500
                          });
                      
                    }

                }
            });
        

}

function cambiarImagen(campo) {
    var input = $("#b_" + campo).val();
    if ((!input == "" || !input == null)) {
        $.ajax({
            url: "../controlador/configurarcuenta.php?op=cambiarImagen",
            type: "POST",
            data: { 'campo': campo, 'valor': input },
            dataType: "JSON",
            success: function (datos) {
                if (datos.exito == 1) {
                    $(".guardar-" + campo).addClass("d-none");
                    $(".cancel-" + campo).addClass("d-none");
                    $(".edit-" + campo).toggleClass("d-none");
                    $("#b_" + campo).val("");
                    // Recarga la imagen real desde el servidor (evita caché)
                    var img = $("#preview_" + campo);
                    var src = img.attr("src").split('?')[0];
                    img.attr("src", src + "?" + new Date().getTime());
                    alertify.success(datos.info);
                } else {
                    alertify.error(datos.info);
                }
            },
            error: function (param) {
                alertify.error(param.responseText);
                console.log(param.responseText);
            }
        });
    } else {
        alertify.error("Debes subir la imagen de tu documento para continuar");
    }
}

function mostrarClave() {
  var tipo = document.getElementById("contrase");
  if (tipo.type == "password") {
    tipo.type = "text";
  } else {
    tipo.type = "password";
  }
}

function cancelar_input(campo) {
    //toma el valor que tenia antes del cambio y lo reemplaza
    $(".input-" + campo).val(valor_defecto);
    //funcion para activr o desactivar onputs
    activar_input(campo);
    $(".img_user").attr("src", image_ant);
}


function activar_input(campo) {
    //guarda el valor por defecto que tiene el input antes de ser editado
    valor_defecto = $(".input-" + campo).val();
    //si esta readonly lo pasa a false y si esta false lo pasa a true
    ($(".input-" + campo).prop('readonly')) ? $(".input-" + campo).prop('readonly', false) : $(".input-" + campo).prop('readonly', true);
    //activa el focus del campo a editar
    $(".input-" + campo).focus();
    //si el boton guardar tiene d-none elimina la clase y si no la tiene se la pone
    $(".guardar-" + campo).toggleClass("d-none");
    //si el boton cancelar tiene d-none elimina la clase y si no la tiene se la pone
    $(".cancel-" + campo).toggleClass("d-none");
    //si el boton editar tiene d-none elimina la clase y si no la tiene se la pone
    $(".edit-" + campo).toggleClass("d-none");
}

function comprimirImagen(file_input) {
    const porcentajeCalidad = 20;
    var imagenComoArchivo = $("#" + file_input)[0];
    if (imagenComoArchivo.files.length <= 0) {
        return;
    }
    imagenComoArchivo = imagenComoArchivo.files[0];
    //crear un elemnto canvas para interpretar la imagen que llega
    elem_canvas = document.createElement("canvas");
    obj_imagen = new Image();
    //asignacion del fakepath al objeto de la imagen
    obj_imagen.src = URL.createObjectURL(imagenComoArchivo);
    //cuando la imagen este cargada hacemos una funcion callback
    obj_imagen.onload = () => {
        //al elemnto de canvas asignamos el width por defecto que tiene la imagen
        elem_canvas.width = obj_imagen.width;
        //al elemnto de canvas asignamos el height por defecto que tiene la imagen
        elem_canvas.height = obj_imagen.height;
        //con el canvas generado en 2 dimensiones, "dibujamos" la imagen sobre el lienzo
        elem_canvas.getContext("2d").drawImage(obj_imagen, 0, 0);
        //convertimos el canvas a un objeto tipo blob para modificar la calidad 
        elem_canvas.toBlob(function (blob) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                $("#b_" + file_input).val(reader.result);
                $("#preview_" + file_input).attr("src", reader.result);
                $(".btn_" + file_input).removeClass("d-none");
                $(".edit-" + file_input).toggleClass("d-none");
            }
        },
            'image/jpeg',
            porcentajeCalidad / 100);
    };
}
