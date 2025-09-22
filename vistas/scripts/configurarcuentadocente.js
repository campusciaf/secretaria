$(document).ready(inicio);
var valor_defecto = "";
var image_ant = "";
function inicio() {
    mostrarpuntos();
    listarDatos();
    editarDatos();
    $("#precarga").hide();
    $("#confirma").keyup(function () {
        dos = $("#nueva").val();
        uno = $("#confirma").val();
        if (uno == dos) {
            //console.log("si");
            $(".confirmaCampo").removeClass("has-error");
            $(".confirmaCampodos").addClass("has-success");
            $(".confirmaCampo").addClass("has-success");
        } else {
            $(".confirmaCampo").addClass("has-error");
        }
    });
    $("#guardarDatosPersonales").on("submit", function (e0) {
        editarDatosPersona(e0);
    });
    $(".guardarDatos").on("submit", function (e1) {
        cambiarContra(e1);
    });
    $("#formulariodatos").on("submit", function (e) {
        editarCaracterizacion(e);
    });
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
//cancela el input activo
function cancelar_input(campo) {
    //toma el valor que tenia antes del cambio y lo reemplaza
    $(".input-" + campo).val(valor_defecto);
    //funcion para activr o desactivar onputs
    activar_input(campo);
    $(".img_user").attr("src", image_ant);
}
//funcion para activr o desactivar onputs
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
//Cambiar cualquier archivo, lo unico es colocar un digito cualquiera despues del nombre original de la carpeta
function cambiarImagen(campo) {
    input = $("#b_" + campo).val();
    if ((!input == "" || !input == null)) {
        $.ajax({
            "url": "../controlador/configurarcuentadocente.php?op=cambiarImagen", "type": "POST", "data": { 'campo': campo, 'valor': input }, "dataType": "JSON",
            success: function (datos) {
                //console.log(datos);
                if (datos.exito == 1) {
                    //si el boton guardar tiene d-none elimina la clase y si no la tiene se la pone
                    $(".guardar-" + campo).addClass("d-none");
                    $(".cancel-" + campo).addClass("d-none");
                    $(".edit-" + campo).toggleClass("d-none");
                    $("#b_" + campo).val("");
                    //si el boton cancelar tiene d-none elimina
                    alertify.success(datos.info);
                } else {
                    alertify.error(datos.info);
                }
            }, error: function (param) {
                $(".pop-up").addClass("d-none");
                alertify.error(param.responseText);
                console.log(param.responseText);
            }
        });
    } else {
        alertify.error("Debes subir la imagen de tu documento para continuar");
    }
}
function listarDatos() {
    $.post("../controlador/configurarcuentadocente.php?op=listarDatos", function (e) {
        //console.log(e);
        var r = JSON.parse(e);
        $(".mostrar-uno").html(r.conte);
        image_ant = $(".img_user").attr("src");
    });
}
function editarDatos() {
    $.post("../controlador/configurarcuentadocente.php?op=editarDatos", {}, function (e) {
        //console.log(e);
        var r = JSON.parse(e);
        $("#guardarDatosPersonales").html(r.conte);
        $("#conte1").show();
        $("#conte2").hide();
        $("#buttuno").show();
        $("#buttdos").hide();
    });
}
function editarContrasena(id) {
    $("#restrablecer").modal("show");
    $("#id").val(id);
}
function cambiarContra(e1) {
    e1.preventDefault();
    var formData = new FormData($("#formRestablecerClave")[0]);

    $.ajax({
        type: "POST",
        url: "../controlador/configurarcuentadocente.php?op=cambiarContra",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Contraseña actualizada con Exito");
                $("#formRestablecerClave")[0].reset();
                $("#restrablecer").modal("hide");
            } else {
                alertify.error(r.status);
            }
        },
    });
}
function mostrarpuntos() {
    $.post("../controlador/configurarcuentadocente.php?op=mostrarpuntos", function (datos) {
        var r = JSON.parse(datos);
        if (r[0].perfil == "si") {
            $("#coin-perfil").html("<span class='badge badge-success'>al día</span>");
        }
        if (r[0].seres == "si") {
            $("#coin-caracterizacion").html("<span class='badge badge-success'>al día</span>");
        }
    });
}
function editarDatosPersona(e0) {
    $("#precarga").show();
    e0.preventDefault();
    var formData = new FormData($("#guardarDatosPersonales")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/configurarcuentadocente.php?op=editarDatospersonales",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            r = JSON.parse(datos);
            if (r[0].estado == "si") {
                Swal.fire({
                    icon: "success",
                    title: "Datos actualizados",
                    showConfirmButton: false,
                    timer: 1500
                });
                listarDatos();
                $("#precarga").hide();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "error",
                    text: "Proceso rechazado!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (r[0].puntos == "si") {
                Swal.fire({
                    position: "top-end",
                    imageWidth: 150,
                    imageHeight: 150,
                    imageUrl: "../public/img/ganancia.gif",
                    title: "Te otorgamos " + r[0].puntosotorgados + " puntos, por actualizar su información de perfil",
                    showConfirmButton: false,
                    timer: 4000
                });
                setTimeout(function () {
                    location.reload();
                }, 4000); // 3000 milisegundos = 3 segundos
            }
        },
    });
}
function mostrarClave() {
    var tipo = document.getElementById("contrase");
    if (tipo.type == "password") {
        tipo.type = "text";
    } else {
        tipo.type = "password";
    }
}
function mostrarform(num) {
    for (let i = 1; i <= 6; i++) {
        if (i === num) {
            $("#caract-" + i).addClass("activo").removeClass("inactivo");
            $("#form" + i).show();
        } else {
            $("#caract-" + i).addClass("inactivo").removeClass("activo");
            $("#form" + i).hide();
        }
    }
}
function listarPreguntas() {
    $.post("../controlador/configurarcuentadocente.php?op=listarPreguntas", function (data) {
        data = JSON.parse(data);
        $("#preguntas").html(data);
        mostrarp2();// parentesco en caso de emergencia
        mostrarp6();// pareja
        mostrarp9();//mascota
        mostrarp12();//idioma
        mostrarp14();// cuanas personas viven en tu casa
        mostrarp16();// personas a cargo
        mostrarp17();//hijos
        mostrarp18();//Cuantos hijos
        mostrarp20();//tipo de vivienda
        mostrarp21();//tipo de transporte
        mostrarp27();//eps
        mostrarp35();//colores
        mostrarp37();//que prefieres de detalle
        mostrarp39();//destacas tema diferente a tu profesión
        mostrarp41();//deporte que practica
        mostrarp42();//actividad fisica
        $("#precarga").hide();
    });
}
function mostrarp2() {
    var campop2_val = $("#p2_val").val();
    let select = document.getElementById("p2");
    select.value = campop2_val;
}
function mostrarp6() {
    var campop6 = $("#p6").find("option:selected").html();
    if (campop6 == "No") {
        $("#p7").prop('disabled', true);
        $("#p8").prop('disabled', true);
        $("#p7").val("");
        $("#p8").val("");
    } else {
        $("#p7").prop("disabled", false);
        $("#p8").prop("disabled", false);
    }
}
function mostrarp9() {
    var campop9 = $("#p9").find("option:selected").html();
    if (campop9 == "No") {
        $("#p10").prop('disabled', true);
        $("#p11").prop('disabled', true);
        $("#p10").val("");
        $("#p11").val("");
    } else {
        $("#p10").prop("disabled", false);
        $("#p11").prop("disabled", false);
    }
}
function mostrarp12() {
    var campop12 = $("#p12").find("option:selected").html();
    var campop13_val = $("#p13_val").val();
    let select = document.getElementById("p13");
    select.value = campop13_val;
    if (campop12 == "No") {
        $("#p13").prop('disabled', true);
        let select2 = document.getElementById("p13");
        select2.value = "";
    } else {
        $("#p13").prop("disabled", false);
    }
}
function mostrarp14() {
    var campop14_val = $("#p14_val").val();
    let select = document.getElementById("p14");
    select.value = campop14_val;
}
function mostrarp16() {
    var campop16_val = $("#p16_val").val();
    let select = document.getElementById("p16");
    select.value = campop16_val;
}
function mostrarp17() {
    var campop17 = $("#p17").find("option:selected").html();
    if (campop17 == "No") {
        $("#p18").prop('disabled', true);
        $("#p19").prop('disabled', true);
        $("#p18").val("");
        $("#p19").val("");
    } else {
        $("#p18").prop("disabled", false);
        $("#p19").prop("disabled", false);
    }
}
function mostrarp18() {
    var campop18_val = $("#p18_val").val();
    let select = document.getElementById("p18");
    select.value = campop18_val;
}
function mostrarp20() {
    var campop20_val = $("#p20_val").val();
    let select = document.getElementById("p20");
    select.value = campop20_val;
}
function mostrarp21() {
    var campop21_val = $("#p21_val").val();
    let select = document.getElementById("p21");
    select.value = campop21_val;
}
function mostrarp27() {
    var campop27_val = $("#p27_val").val();
    let select = document.getElementById("p27");
    select.value = campop27_val;
}
function mostrarp35() {
    var campop35_val = $("#p35_val").val();
    let select = document.getElementById("p35");
    select.value = campop35_val;
}
function mostrarp37() {
    var campop37_val = $("#p37_val").val();
    let select = document.getElementById("p37");
    select.value = campop37_val;
}
function mostrarp39() {
    var campop39 = $("#p39").find("option:selected").html();
    if (campop39 == "No") {
        $("#p40").prop('disabled', true);
        $("#p40").val("");
    } else {
        $("#p40").prop("disabled", false);
    }
}
function mostrarp41() {
    var campop41_val = $("#p41_val").val();
    let select = document.getElementById("p41");
    select.value = campop41_val;
}
function mostrarp42() {
    var campop42_val = $("#p42_val").val();
    let select = document.getElementById("p42");
    select.value = campop42_val;
}
function editarCaracterizacion(e) {
    $("#precarga").show();
    e.preventDefault();
    var formData = new FormData($("#formulariodatos")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/configurarcuentadocente.php?op=guardaryeditar",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            r = JSON.parse(datos);
            console.log(r);
            if (r[0].estado == "si") {
                Swal.fire({
                    icon: "success",
                    title: "Caracterización actualizada",
                    showConfirmButton: false,
                    timer: 1500
                });
                listarPreguntas();
                $("#precarga").hide();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "error",
                    text: "Proceso rechazado!",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (r[0].puntos == "si") {
                Swal.fire({
                    position: "top-end",
                    imageWidth: 150,
                    imageHeight: 150,
                    imageUrl: "../public/img/ganancia.gif",
                    title: "Te otorgamos " + r[0].puntosotorgados + " puntos, por actualizar la caracterización",
                    showConfirmButton: false,
                    timer: 4000
                });
                setTimeout(function () {
                    location.reload();
                }, 4000); // 3000 milisegundos = 3 segundos
            }
        }
    });
}