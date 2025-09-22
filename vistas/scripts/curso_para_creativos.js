var activeIntervals = new Set(); // Set to store interval IDs
var player, apiLista, categoria, duracion;
var enlace_video_categoria;
var mostrarVideo = false;
$(document).ready(init);
function init() {
    listarCategorias();
    $("#form_preguntas").on("submit", function (e) {
        verificarRespuestas(e);
    });
}
//Función ListarCategorias
function listarCategorias() {
    clearAllIntervals();
    $("#form_preguntas").html("<div class='text-center'><h5 class='badge bg-info '>En <b> <span class='tiempo_restante'> </span> </b> segundos podrás visualizar las preguntas</h5></div>");
    $("#listado_categorias").show();
    $("#video_preguntas").hide();
    $.post("../controlador/curso_para_creativos.php?op=listarCategorias", function (data, status) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#precarga").hide();
            $("#listado_videos").html(data.html);
        }
    });
}
function mostrarVideoPreguntas(video_categoria) {
    clearAllIntervals();
    categoria = video_categoria;
    $("#listado_categorias").hide();
    $("#video_preguntas").show();
    $.post("../controlador/curso_para_creativos.php?op=mostrarVideoPreguntas", { "categoria": video_categoria }, function (data, status) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            enlace_video_categoria = data.enlace_video_categoria;
            mostrarVideo = true;
            onYouTubeIframeAPIReady();
        } else {
            Swal.fire("Error", "No se pudo mostrar el video", "error");
        }
    });
}
function mostrarVideoPreguntasAprobadas(video_categoria) {
    $.post("../controlador/curso_para_creativos.php?op=mostrarVideoPreguntasAprobadas", { "categoria": video_categoria }, function (data, status) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#video_pregunta_aprobada").html(data.info);
            $("#ModalVideoPreguntaAprobada").modal("show");
        } else {
            Swal.fire("Error", "No se pudo mostrar el video", "error");
        }
    });
}
function listarPreguntas(categoria) {
    $("#form_preguntas").html("<div class='text-center'><h5 class='badge bg-info '>En <b> <span class='tiempo_restante'> </span> </b> segundos podrás visualizar las preguntas</h5></div>");
    $.post("../controlador/curso_para_creativos.php?op=listarPreguntas", { "categoria": categoria }, function (data, status) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#form_preguntas").html(data.html);
        }
    });
}
function verificarRespuestas(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#form_preguntas")[0]);
    $.ajax({
        "url": "../controlador/curso_para_creativos.php?op=verificarRespuestas",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            try {
                let data = JSON.parse(datos);
                if (data.exito == "1") {
                    Swal.fire({ "position": "top-end", "icon": "success", "title": "!Pasaste este curso¡", "showConfirmButton": false, "timer": 1500 });
                    listarCategorias();
                    $("#form_preguntas").html("<div class='text-center'><h5 class='badge bg-info '>En <b> <span class='tiempo_restante'> </span> </b> segundos podrás visualizar las preguntas</h5></div>");
                } else if (data.exito == "0") {
                    Swal.fire({ "position": "top-end", "icon": "error", "title": "!Upps has fallado¡ Vuelve a intentarlo.", "showConfirmButton": false, "timer": 1500 });
                    categoria = data.categoria;
                    listarPreguntas(categoria);
                }
            } catch (error) {
                Swal.fire({ "icon": "error", "title": "Error", "text": "Hubo un problema al procesar la respuesta." });
            }
        }
    });
}
// Esta función es llamada automáticamente por la API de Youtube cuando está lista
function onYouTubeIframeAPIReady() {
    iniciarReproductor();
}
function iniciarReproductor() {
    if (mostrarVideo) {
        if (player) {
            player.stopVideo();
            player.destroy();
            player = null;
        }
        player = new YT.Player('player', {
            "videoId": enlace_video_categoria,
            "playerVars": { 'autoplay': 0, 'controls': 0, "disablekb": 1, 'modestbranding': 1, 'rel': 0, 'showinfo': 0, 'iv_load_policy': 3 },
            "events": {
                'onReady': onPlayerReady,
            }
        });
    }
}
function onPlayerReady(event) {
    function esperarDuracionIntento(maxIntentos) {
        let intentos = 0;
        const intervalo = setInterval(() => {
            try {
                duracion = player.getDuration();
            } catch (error) {

            }
            if (!isNaN(duracion) || duracion > 0) {
                clearInterval(intervalo);
                cuentaRegresiva(duracion);
            } else {
                console.log("Intento " + (intentos + 1) + ": No se pudo obtener la duración del video.");
                intentos++;
                if (intentos >= maxIntentos) {
                    duracion = 60; // Valor por defecto si no se obtiene la duración
                    clearInterval(intervalo);
                    console.log("No se pudo obtener la duración del video.");
                }
            }
        }, 300); 
        activeIntervals.add(intervalo2);
    }
    esperarDuracionIntento(10);
}
// cuenta regresiva para el video para mostrar las preguntas
function cuentaRegresiva(duracion){
    let tiempoRestante = duracion;
    const intervalo2 = setInterval(() => {
        if (tiempoRestante <= 0) {
            clearInterval(intervalo2);
            listarPreguntas(categoria);
        } else {
            tiempoRestante--;
            $('.tiempo_restante').text(tiempoRestante);
        }
    }, 1000);
    activeIntervals.add(intervalo2);
}
function clearAllIntervals() {
    activeIntervals.forEach(id => {
        try {
            clearInterval(id);
        } catch (error) {
            // "Error clearing interval:"
        }
    });
    activeIntervals.clear(); 
}