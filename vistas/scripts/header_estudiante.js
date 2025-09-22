function initheader() {
    listarTemaPrincipal();
    listar_titulaciones();
    heteroevaluacion();
    generar_qr();
    //verificarcaracterizacion();
    // encuentaEstDigital();
    verificar_veedor();
    listarPuntos();
    // $("#formularioencuestauno").on("submit", function (e1) {
    //     guardarencuentaEstDigital(e1);
    // });
    $("#formularioConfirmarVeedor").on("submit", function (e1) {
        guardarConfirmacionVeedor(e1);
    });
}
function listarPuntos(){
    $.post("../controlador/header_estudiante.php?op=listarPuntos", function (datos) {
        data = JSON.parse(datos);
        $("#mispuntos").html(data.exito);
        $("#nivel").html(data.nivel);
    });
}
function verificarcaracterizacion(){
    $.post("../controlador/header_estudiante.php?op=verificarcaracterizacion", function (e) {
        var r = JSON.parse(e);

        if(r[0].seres==0){
            $("#carseres").html('<i class="fa-solid fa-question text-warning"></i>');
        }else{
            $("#carseres").html('<i class="fa-solid fa-check text-success"></i>'); 
        }
        if(r[0].insp==0){
            $("#carins").html('<i class="fa-solid fa-question text-warning"></i>');
        }else{
            $("#carins").html('<i class="fa-solid fa-check text-success"></i>');
        }
        if(r[0].empresas==0){
            $("#carempresas").html('<i class="fa-solid fa-question text-warning"></i>');
        }else{
            $("#carempresas").html('<i class="fa-solid fa-check text-success"></i>');
        }
        if(r[0].confiamos==0){
            $("#carconfiamos").html('<i class="fa-solid fa-question text-warning"></i>');
        }else{
            $("#carconfiamos").html('<i class="fa-solid fa-check text-success"></i>');
        }
        if(r[0].exp==0){
            $("#carexperiencia").html('<i class="fa-solid fa-question text-warning"></i>');
        }else{
            $("#carexperiencia").html('<i class="fa-solid fa-check text-success"></i>');
        }
        if(r[0].bienestar==0){
            $("#carbien").html('<i class="fa-solid fa-question text-warning"></i>');
        }else{
            $("#carbien").html('<i class="fa-solid fa-check text-success"></i>');
        }

        var url = window.location.href;
        if(url == "https://ciaf.digital/vistas/financiacion.php"){

        }else{


            if(r[0].seres==0){
                if (!window.location.href.includes("carseresoriginales.php")) {
                    window.location.href = "https://ciaf.digital/vistas/carseresoriginales.php";
                }
            }
            else if(r[0].insp==0){
                if (!window.location.href.includes("carinspiradores.php")) {
                    window.location.href = "https://ciaf.digital/vistas/carinspiradores.php";
                }
                
            }
            else if(r[0].empresas==0){
                if (!window.location.href.includes("carempresas.php")) {
                    window.location.href = "https://ciaf.digital/vistas/carempresas.php";
                }
            }
            else if(r[0].confiamos==0){
                if (!window.location.href.includes("carconfiamos.php")) {
                    window.location.href = "https://ciaf.digital/vistas/carconfiamos.php";
                }

            }
            else if(r[0].exp==0){
                if (!window.location.href.includes("carexperiencia.php")) {
                    window.location.href = "https://ciaf.digital/vistas/carexperiencia.php";
                }

            }
            else if(r[0].bienestar==0){
                if (!window.location.href.includes("carbienestar.php")) {
                    window.location.href = "https://ciaf.digital/vistas/carbienestar.php";
                    
                }
            }else{

            }

        }

      
    });
}
function verificar_veedor() {
    $.post("../controlador/header_estudiante.php?op=verificar_veedor", function (e) {
        var r = JSON.parse(e);
        if (r.exito == 1) {
            $("#myModalAcepto").modal("show");
        }
    });
}
function listarTemaPrincipal() {
    $.post("../controlador/header_estudiante.php?op=listarTema", function (e) {
        var r = JSON.parse(e);
        if (r.conte == 1) {
            document.documentElement.setAttribute('tema', 'light');
        } else {
            document.documentElement.setAttribute('tema', 'dark');
        }
    });
}
function listar_titulaciones() {
    $.post("../controlador/header_estudiante.php?op=menu_titulaciones", function (datos) {
        data = JSON.parse(datos);
        $("#cantidad_titu").html(data[0].num);// muestra la cantidad de programas activos en el menu del estudiante
        //$("#contenido").html(data[0].programas);// muestra los programas
        $("#miprograma").html(data[0].campus);// muesttra los programas

    });
}
function heteroevaluacion() {
    $.post("../controlador/header_estudiante.php?op=heteroevaluacion", function (datos) {
        data = JSON.parse(datos);
   
        if(data[0].egresado=="no"){// si no es egresado que consulte

        
            if(data[0].estado==1){// evaluacion activa
                var pagina_actual = window.location.href.split("/").pop();
                
                if (pagina_actual === 'evaluaciondocente.php' || pagina_actual === 'ayuda.php') {
                    // Si estamos en 'verencuestadocente.php', se oculta el modal
                    $("#modal_evaluacion_docente").modal("hide");
                }else{
                    $("#modal_evaluacion_docente").modal("show");
                }

            }else{// evaluacion inactiva

            }

        }
    });
}

function listar_titulaciones2() {
    $.post("../controlador/header_estudiante.php?op=menu_titulaciones", function (data) {
        data = JSON.parse(data);
        // valor para saber si la evaluacion esta activa si es 1 se activa y si es 0 se desactiva
        estado_evaluacion_estudiante = data[0].estado_evaluacion_estudiante;
        // si es igual a 0 oculta el modal si es igual 1 muestra el modal de la evaluacion docente bienestar
        comparacion_terminada = data[0].evaluacion_docente_finalizada;
        var pagina_actual = window.location.href.split("/").pop();
        // Verificamos si estamos en 'verencuestadocente.php' para que cuando el estudiante se vaya a otro lugar siempre le muestre el modal hasta terminarlo 
        if (pagina_actual === 'evaluaciondocente.php' || pagina_actual === 'ayuda.php') {
            // Si estamos en 'verencuestadocente.php', se oculta el modal
            $("#modal_evaluacion_docente").modal("hide");
        } else {
            // en caso de que estemos en otra pagina aplicamos esta logica
            if (estado_evaluacion_estudiante == 1) {
                // Si el estado de evaluación docente está activo (1)
                if (comparacion_terminada == 0) {
                    // Si la evaluación no está terminada (0), mostramos el modal
                    $("#modal_evaluacion_docente").modal({ backdrop: 'static', keyboard: false });
                } else if (comparacion_terminada == 1) {
                    // Si la evaluación está terminada (1), ocultar el modal
                    $("#modal_evaluacion_docente").modal("hide");
                    $("#cantidad_titu").html(data["0"]["1"]);// muestra la cantidad de programas activos en el menu del estudiante
                    $("#contenido").html(data["0"]["2"]);// muesttra los programas
                }
            } else if (estado_evaluacion_estudiante == 0) {
                // Si el estado de la evaluación docente está desactivado (0), ocultar el modal
                $("#modal_evaluacion_docente").modal("hide");
                $("#cantidad_titu").html(data["0"]["1"]);// muestra la cantidad de programas activos en el menu del estudiante
                $("#contenido").html(data["0"]["2"]);// muesttra los programas
            }
        }
    });
}
function generar_qr() {
    $.post("../controlador/header_estudiante.php?op=generarqr", function (e) {
        try {
            var r = JSON.parse(e);
            if (r.status == "ok") {
                $("#codigo").html(r.conte);
            }
        } catch (error) {
            console.log("Error al generar el QR.");
        }
    });
}
function encuentaEstDigital() {
    $.post("../controlador/header_estudiante.php?op=encuentaEstDigital", function (e) {
        var r = JSON.parse(e);
        if (r == "1") {
            $("#myModalEncuestaBienestar").modal("hide");// encuesta realizada
        }
        if (r == "2") {
            $("#myModalEncuestaBienestar").modal({ backdrop: 'static', keyboard: false });
            $("#myModalEncuestaBienestar").modal("show");// encuesta por realizar
        }
    });
}
function mostrarcuestionario(valor) {
    if (valor == "no") {
        $("#pre-cuestionario").hide();
        $("#btn-enviar-encuesta-no").show();
        $("#btn-enviar-encuesta-si").hide();
    } else {
        $("#pre-cuestionario").show();
        $("#btn-enviar-encuesta-no").hide();
        $("#btn-enviar-encuesta-si").show();
    }
}
function enviarno() {
    $.post("../controlador/header_estudiante.php?op=guardarencuentaEstDigitalNo", function (e) {
        var r = JSON.parse(e);
        if (r.estado = "1") {
            alertify.success("Encuesta enviada");
            encuentaEstDigital();
        } else {
            alertify.error("Encuesta errada");
        }
    });
}
function guardarencuentaEstDigital(e1) {
    e1.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioencuestauno")[0]);
    $.ajax({
        url: "../controlador/header_estudiante.php?op=guardarencuentaEstDigital",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            data = JSON.parse(datos);
            if (data.estado = "1") {
                alertify.success("Encuesta enviada");
                encuentaEstDigital();
            } else {
                alertify.error("Encuesta errada");
            }
        }
    });
}
function guardarConfirmacionVeedor(e1) {
    e1.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioConfirmarVeedor")[0]);
    $.ajax({
        "url": "../controlador/header_estudiante.php?op=guardarConfirmacionVeedor",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos.estado = "1") {
                Swal.fire({ position: 'top-end', icon: 'success', title: "Se ha guardado tu respuesta", showConfirmButton: false, timer: 1500 });
                $("#myModalAcepto").modal("hide");
            } else {
                Swal.fire({ position: 'top-end', icon: 'error', title: "Error al guardar tu respuesta", showConfirmButton: true });
            }
        }
    });
}
initheader();