// Función que se ejecuta al cargar el documento
$(document).ready(incio);
// Variable que almacena el número de celular seleccionado en el chat
var numero_seleccionado = ""; var audioFile = ""; var video; var canvas; var context; var numero_previo = ""; envio_mensaje = false;
// Lista de emojis disponibles
const emojis = [
    "😀", "😃", "😄", "😁", "😆", "😅", "😂", "🤣", "😊", "😇", "🙂", "🙃", "😉", "😌", "😍", "😘", "😗", "😙", "😚", "😋", "😛", "😝", "😜", "🤪", "🤨", "🧐", "🤓", "😎", "🤩", "😏", "😒", "😞", "😔", "😟", "😕", "🙁", "☹️", "😣", "😖", "😫", "😩", "🥺", "😢", "😭", "😤", "😠", "😡", "🤬", "🤯", "😳", "🥵", "🥶", "😱", "😨", "😰", "😥", "😓", "🤗", "🤔", "🤭", "🤫", "🤥", "😶", "😐", "😑", "😬", "🙄", "😯", "😦", "😧", "😮", "😲", "😴", "🤤", "😪", "😵", "🤐", "🥴", "🤢", "🤮", "🤧", "😷", "🤒", "🤕", "🤑", "🤠", "😈", "👿", "👹", "👺", "🤡", "💩", "👻", "💀", "☠️", "👽", "👾", "🤖", "🎃", "😺", "😸", "😹", "😻", "😼", "😽", "🙀", "😿", "😾", "💋", "👋", "🤚", "🖐️", "✋", "🖖", "👌", "🤏", "✌️", "🤞", "🤟", "🤘", "🤙", "👈", "👉", "👆", "🖕", "👇", "☝️", "👍", "👎", "✊", "👊", "🤛", "🤜", "👏", "🙌", "👐", "🤲", "🤝", "🙏", "✍️", "💅", "🤳", "💪", "🦾", "🦿", "🦵", "🦶", "👂", "🦻", "👃", "🧠", "🦷", "🦴", "👀", "👁️", "👅", "👄", "💋", "💘", "❤️", "💓", "💔", "💕", "💖", "💗", "💙", "💚", "💛", "🧡", "💜", "🖤", "🤍", "🤎", "💝", "💞", "💟", "❣️", "💤", "💢", "💬", "🗨️", "🗯️", "💭", "🕳️", "👓", "🕶️", "🥽", "🥼", "🦺", "👔", "👕", "👖", "🧣", "🧤", "🧥", "🧦", "👗", "👘", "🥻", "🩱", "🩲", "🩳", "👙", "👚", "👛", "👜", "👝", "🎒", "👞", "👟", "🥾", "🥿", "👠", "👡", "🩰", "👢", "👑", "👒", "🎩", "🎓", "🧢", "⛑️", "📿", "💄", "💍", "💼", "🩸"
];
function incio() {
    $(".recording-text").hide();
    $("#btn_cancelar_grabacion").hide();
    $(".seccion_capturada").hide();
    // Soporte para notificaciones y service workers
    if ('Notification' in window) {
        // Verificar si las notificaciones ya están permitidas por el usuario
        if (Notification.permission !== "granted") {
            // Mostrar una alerta con SweetAlert para solicitar permisos de notificaciones
            Swal.fire({
                title: 'Activar Notificaciones',
                text: 'Para recibir alertas, por favor activa las notificaciones.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Activar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario acepta, solicitar permisos de notificaciones
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            activarNotificaciones();
                        } else {
                            Swal.fire('Permiso denegado', 'No podremos enviarte notificaciones.', 'error');
                        }
                    });
                } else {
                    // Si el usuario cancela la solicitud de permisos
                    Swal.fire('Acción cancelada', 'No se activaron las notificaciones.', 'info');
                }
            });
        } else {
            // Si las notificaciones ya están activadas
            console.log("Notificaciones ya activadas.");
        }
    }
    // Ocultar elementos iniciales
    $("#precarga").hide();
    $(".emoji-list").hide();
    $(".con_chat_seleccionado").hide();
    $('[data-toggle="tooltip"]').tooltip(); // Activar tooltips
    listarChats(); // Listar los chats disponibles
    setInterval(listarChats, 10000); // Refrescar la lista de chats cada 10 segundos
    // Asociar evento de envío de mensaje a un formulario
    $("#send_message_ciaf").on("submit", function (e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
        sendWhatsappMessage(); // Enviar el mensaje de WhatsApp
    });
    // Crear los botones de emojis
    button_emoji = '';
    emojis.forEach(emoji => {
        button_emoji += '<button type="button" class="btn" onclick="add_emoji(this)">' + emoji + '</button>';
    });
    $(".emoji-list").html(button_emoji);
    $("#input_mensaje").on("keyup", verificarTipoMensaje);
    $('#fotoVideoModal').on('hidden.bs.modal', function (e) {
        $('#fileFotoVideo').val('');
    });
    // Lista las dependencias para la redireccion
    ListarDependencias();
    // Asociar evento de envío de mensaje a un formulario
    $("#formularioRedirigirChat").on("submit", function (e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
        redigirChat(); // Enviar el mensaje de WhatsApp
    });
}
// Función para que cuando se escriba aparezca el boton de enviar texto y oculte el audio
function verificarTipoMensaje() {
    // Tomamos el tamaño del input
    input_mensaje = $("#input_mensaje").val();
    if (input_mensaje.length >= 1) { // Si es mayor a uno, debe mostrar el boton de enviar mensaje
        $(".envio_texto").removeClass("d-none"); // Removemos la clase d-none
        $(".envio_audio").addClass("d-none"); // Agregamos la clase d-none
    } else { //Sino, mostramos el audio y ocultamos el de enviar mensaje de texto
        $(".envio_texto").addClass("d-none"); // Agregamos la clase d-none
        $(".envio_audio").removeClass("d-none"); // Removemos la clase d-none
    }
}
// Función para agregar un emoji al campo de texto del mensaje
function add_emoji(boton) {
    $("#input_mensaje").val($("#input_mensaje").val() + $(boton).text());
}
// Función para abrir o cerrar la lista de emojis
function abrirListaEmoji() {
    $(".emoji-list").toggle();
}
// Función que se ejecutará periódicamente para verificar cambios en numero_seleccionado
function verificarCambioNumeroSeleccionado() {
    // Verificar si ha cambiado el valor de numero_seleccionado
    if (numero_seleccionado !== "") {
        // Llamar a otra función si hay un cambio
        listarDatos(numero_seleccionado);
    }
}
// Función para listar los chats disponibles
function listarChats() {
    input = $("input[type=search]").val();
    console.log(input);
    if (input == '' || input === undefined) {
        // Configuración de la tabla que lista los chats
        $(".users").dataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                "search": "", // Esto removerá la palabra "Buscar"
                "searchPlaceholder": "Buscar", // Texto de placeholder
                "paginate": {
                    "previous": '<i class="fas fa-backward"></i>',
                    "next": '<i class="fas fa-forward"></i>'
                }
            },
            "stateSave": true,
            "dom": 'ftp',
            "ordering": false,
            "deferRender": true,
            "initComplete": function (status, data) {
                // Si hay chats no mostrados, activar notificaciones
                if (data.total_sin_mostrar != 0) {
                    activarNotificaciones();
                }
                $("#precarga").hide();
                $('.dataTables_processing').hide();
                $("input[type=search]").on("keyup", listarChats);
                $(".dataTables_paginate").html("");
            },
            "ajax": {
                "url": '../controlador/whatsapp_chats.php?op=listarChats',
                "type": "post",
                "dataType": "json",
                "error": function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
        }).DataTable();
        verificarCambioNumeroSeleccionado(); // Verificar cambios en el chat seleccionado
    } else {
        // Configuración de la tabla que lista los chats
        $(".users").dataTable({
            "language": {
                "search": "", // Esto removerá la palabra "Buscar"
                "searchPlaceholder": "Buscar", // Texto de placeholder
                "paginate": {
                    "previous": '<i class="fas fa-backward"></i>',
                    "next": '<i class="fas fa-forward"></i>'
                }
            },
            "stateSave": true,
            "dom": 'ftp',
            "ordering": false,
            "initComplete": function (status, data) {
                // Si hay chats no mostrados, activar notificaciones
                if (data.total_sin_mostrar != 0) {
                    activarNotificaciones();
                }
                $("#precarga").hide();
                $('.dataTables_processing').hide();
            },
            "ajax": {
                "url": '../controlador/whatsapp_chats.php?op=listarChats',
                "type": "post",
                "dataType": "json",
                "error": function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5, // Paginación: cantidad de chats mostrados por página
        }).DataTable();
        verificarCambioNumeroSeleccionado(); // Verificar cambios en el chat seleccionado
    }
}
// Función para seleccionar un chat y cargar su contenido
function seleccionarChat(e, numero_celular) {
    //console.log(numero_previo, numero_celular);
    numero_seleccionado = numero_celular; // Asignar el número de celular seleccionado
    $("td").removeClass("active-user"); // Remover la clase activa de todos los usuarios
    $(e).parent().addClass("active-user"); // Añadir la clase activa al usuario seleccionado
    $(".sin_chat_seleccionado").hide(); // Ocultar la vista sin chat seleccionado
    $(".sin_chat_seleccionado").removeClass("d-flex"); // Remover la clase 'd-flex'
    $(".con_chat_seleccionado").show(); // Mostrar la vista con chat seleccionado
    listarDatos(numero_celular); // Listar los datos del chat seleccionado
    
    const anchoPantalla = window.innerWidth;
    if(anchoPantalla <= 486){
        $(".listado_chats").hide();
        $(".seccion_conversacion").css("width", "100%");
        $(".seccion_conversacion").removeClass("d-none");
        $(".historial_mensajes").css("height", "80vh");
        $(".mini").css("display", "none");
        $(".movilchat").removeClass("d-none");
        $(".pcchat").addClass("d-none");
    }
   
}
function volverlista(){
        $(".listado_chats").show();
        //$(".seccion_conversacion").css("width", "100%");
        $(".seccion_conversacion").addClass("d-none");
        $(".historial_mensajes").css("height", "80vh");
        $(".mini").css("display", "block");
        $(".movilchat").addClass("d-none");
        $(".pcchat").removeClass("d-none");

}
// Función para ver una imagen en tamaño grande
function verImagenGrande(imagen) {
    url_imagen = $(imagen).attr("src"); // Obtener la URL de la imagen
    $("#imgGrande").attr("src", url_imagen); // Asignar la URL al modal
    $("#modalVerImagenGrande").modal("show"); // Mostrar el modal con la imagen
}
// Función para listar los datos del chat seleccionado
function listarDatos(numero_celular) {
    // Cargar los datos del chat desde el servidor
    $.post("../controlador/whatsapp_chats.php?op=listarConversacion", { "numero_celular": numero_celular }, function (r) {
        r = JSON.parse(r); // Parsear la respuesta JSON
        if (r.exito == 1) {
            // Se verifica si es una nueva consulta al mismo numero
            mismo_numero = (numero_previo == numero_celular) ? true : false;
            //Se toma el valor enviado desde el controlador
            total_sin_mostrar = r.total_sin_mostrar;
            //console.log(total_sin_mostrar); 
            if (!mismo_numero || (mismo_numero && total_sin_mostrar >= 1 || envio_mensaje)) {
                //console.log(numero_previo, numero_celular);
                verificarSeguimientoActivo(numero_celular); // Verificar si hay un seguimiento activo
                $(".historial_mensajes").html(""); // Limpiar el historial de mensajes
                $(".nombre_completo").text(""); // Limpiar el nombre completo
                $(".celular_perfil").text(""); // Limpiar el número de celular en el perfil
                $(".celular_perfil").text(numero_celular); // Mostrar el número de celular en el perfil
                $("#send_numero_celular").val(numero_celular); // Asignar el número de celular al campo oculto
                $(".historial_mensajes").html(r.historial_mensajes); // Mostrar el historial de mensajes
                $(".nombre_completo").text(r.nombre_completo); // Mostrar el nombre completo
                $(".imagen_perfil").attr("src", r.imagen); // Asignar la imagen de perfil
                var div = $('.chatContainerScroll');
                div.scrollTop(div.prop('scrollHeight')); // Desplazar el scroll al final del chat
                if (r.mostrar_templates == 0) {
                    $("#send_message_ciaf").show(); // Mostrar el formulario de envío de mensaje
                    $("#iniciar_chat_template").hide(); // Ocultar la opción de iniciar chat con plantilla
                } else {
                    $("#send_message_ciaf").hide(); // Ocultar el formulario de envío de mensaje
                    $("#iniciar_chat_template").show(); // Mostrar la opción de iniciar chat con plantilla
                }
            }
        }
        numero_previo = numero_celular;
        envio_mensaje = false;
    });
}
// Función para enviar un mensaje de WhatsApp
function sendWhatsappMessage() {
    formData = new FormData($("#send_message_ciaf")[0]); // Crear objeto FormData con los datos del formulario
    // Agrega el archivo al FormData con la clave 'audio' no importa si va vacia
    formData.append('audio', audioFile);
    // Establecer el tipo de mensaje como texto
    $("#tipo_mensaje").val("text");
    $.ajax({
        "url": "../controlador/whatsapp_chats.php?op=sendWhatsappMessage",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            console.log(datos);
            data = JSON.parse(datos); // Parsear la respuesta JSON
            if (data.exito == "1") {
                $("#input_mensaje").val(""); // Limpiar el campo de mensaje
                $("#nombre_template").val(""); // Limpiar el campo de plantilla
                $("#modalTemplates").modal("hide"); // Ocultar el modal de plantillas
                $("#fotoVideoModal").modal("hide"); // Ocultar el modal de Imagenes y Video
                $("#camaraModal").modal("hide"); // Oculta el modal de capturar foto
                $("#DocumentosModal").modal("hide"); // Oculta el modal de documentos
                $('#fileFotoVideo').val('');// Limpia el input file que alamcena las imagenes
                $('#fileDocumentos').val('');// Limpia el input file que alamcena Los documentos
                var div = $('.chatContainerScroll'); // Crea una variable con el campo de scroll
                div.scrollTop(div.prop('scrollHeight')); // Desplazar el scroll al final del chat 
                $(".ultimo_mensaje_" + data.numero_celular).html(data.ultimo_mensaje); // Actualizar el último mensaje
                envio_mensaje = true;
                listarDatos(data.numero_celular); // Listar los datos del chat actualizado
                // Eliminar clases de todos los elementos dentro del contenedor del chat
                $("div[data-chat=" + data.numero_celular + "]").find('*').removeClass('font-weight-bold');
                $("div[data-chat=" + data.numero_celular + "]").find('*').removeClass('text-success');
                $("div[data-chat=" + data.numero_celular + "]").find('.mensajes_no_vistos').addClass('d-none');
            } else {
                console.log(data.err_info); // Mostrar el error en la consola
            }
        }
    });
}
// Función para listar las plantillas disponibles
function listarTemplates() {
    $("#modalTemplates").modal("show"); // Mostrar el modal de plantillas
    $("#templateList").dataTable({
        "processing": true,
        "serverSide": true,
        "language": {
            "search": "", // Esto removerá la palabra "Buscar"
            "searchPlaceholder": "Buscar", // Texto de placeholder
            "paginate": {
                "previous": '<i class="fas fa-backward"></i>',
                "next": '<i class="fas fa-forward"></i>'
            }
        },
        "stateSave": true,
        "dom": '',
        "ordering": false,
        "deferRender": true,
        "initComplete": function (json, settings) {
            $("#precarga").hide(); // Ocultar la precarga
        },
        "ajax": {
            "url": '../controlador/whatsapp_chats.php?op=listarTemplates',
            "type": "post",
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText); // Mostrar el error en la consola
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, // Paginación: cantidad de plantillas mostradas por página
    }).DataTable();
}
// Función para seleccionar una plantilla y enviar el mensaje correspondiente
function seleccionarTemplate(nombre_template) {
    $("#tipo_mensaje").val("template"); // Establecer el tipo de mensaje como plantilla
    $("#nombre_template").val(nombre_template); // Asignar el nombre de la plantilla
    body_template = $("#texto_" + nombre_template).text(); // Obtener el cuerpo de la plantilla
    $("#input_mensaje").val(body_template); // Establecer el cuerpo de la plantilla en el campo de mensaje
    sendWhatsappMessage(); // Enviar el mensaje con la plantilla seleccionada
}
// Función para verificar si hay un seguimiento activo para el número de celular
function verificarSeguimientoActivo(numero_celular) {
    $.post("../controlador/whatsapp_chats.php?op=verificarSeguimientoActivo", { "numero_celular": numero_celular }, function (r) {
        r = JSON.parse(r); // Parsear la respuesta JSON
        if (r.exito == 1) {
            $("#formas_de_envio").show(); // Mostrar las formas de envío
            $("#estado_seguimiento").hide(); // Ocultar el estado de seguimiento
            $(".btn_iniciar_seguimiento").addClass("d-none"); // Ocultar el botón de iniciar seguimiento
            $(".btn_cerrar_seguimiento").removeClass("d-none"); // Mostrar el botón de cerrar seguimiento
        } else if (r.exito == 2) {
            $("#formas_de_envio").hide(); // Ocultar las formas de envío
            $("#estado_seguimiento").hide(); // Ocultar el estado de seguimiento
            $(".btn_iniciar_seguimiento").removeClass("d-none"); // Mostrar el botón de iniciar seguimiento
            $(".btn_cerrar_seguimiento").addClass("d-none"); // Ocultar el botón de cerrar seguimiento
            $(".btn_iniciar_seguimiento").attr("disabled", false); // Habilitar el botón de iniciar seguimiento
        } else {
            $("#formas_de_envio").hide(); // Ocultar las formas de envío
            $("#estado_seguimiento").show(); // Mostrar el estado de seguimiento
            $(".info_estado_seguimiento").html(r.info); // Mostrar la información del estado de seguimiento
            $(".btn_iniciar_seguimiento").attr("disabled", true); // Deshabilitar el botón de iniciar seguimiento
        }
    });
}
// Función para activar el seguimiento para un número de celular
function ActivarSeguimiento() {
    numero_celular = $("#send_numero_celular").val(); // Obtener el número de celular del campo oculto
    $.post("../controlador/whatsapp_chats.php?op=ActivarSeguimiento", { "numero_celular": numero_celular }, function (r) {
        r = JSON.parse(r); // Parsear la respuesta JSON
        if (r.exito == 1) {
            $("#formas_de_envio").show(); // Mostrar las formas de envío
            $("#estado_seguimiento").hide(); // Ocultar el estado de seguimiento
            $(".historial_mensajes").append(r.info); // Añadir información al historial de mensajes
            $(".btn_iniciar_seguimiento").attr("disabled", true); // Deshabilitar el botón de iniciar seguimiento
        } else {
            Swal.fire({ "position": "top-end", "icon": "error", "title": r.info }); // Mostrar error con SweetAlert
        }
    });
}
// Función para finalizar el seguimiento de un chat
function FinalizarSeguimiento() {
    Swal.fire({
        "title": "Resultados obtenidos",
        "input": "text",
        "inputAttributes": { autocapitalize: "off" },
        "showCancelButton": true,
        "confirmButtonText": "Finalizar"
    }).then((resultado_seguimiento) => {
        if (resultado_seguimiento.isConfirmed) {
            numero_celular = $("#send_numero_celular").val(); // Obtener el número de celular del campo oculto
            $.post("../controlador/whatsapp_chats.php?op=FinalizarSeguimiento", { "numero_celular": numero_celular, "resultado_seguimiento": resultado_seguimiento.value }, function (r) {
                r = JSON.parse(r); // Parsear la respuesta JSON
                if (r.exito == 1) {
                    $("#formas_de_envio").hide(); // Ocultar las formas de envío
                    $("#estado_seguimiento").show(); // Mostrar el estado de seguimiento
                    $(".historial_mensajes").append(r.info); // Añadir información al historial de mensajes
                    $(".btn_iniciar_seguimiento").attr("disabled", false); // Habilitar el botón de iniciar seguimiento
                    verificarSeguimientoActivo(numero_celular); // Verificar el estado del seguimiento
                } else {
                    Swal.fire({ "position": "top-end", "icon": "error", "title": r.info }); // Mostrar error con SweetAlert
                }
            });
        }
    });
}
// Función para activar las notificaciones (simulación)
function activarNotificaciones() {
    playSound(); // Reproducir sonido de notificación
}
// Función para reproducir un sonido
function playSound() {
    let sound = document.getElementById('notification-sound'); // Obtener el elemento de sonido
    sound.play().catch(error => {
        console.error("Error al reproducir el sonido:", error); // Mostrar error si falla la reproducción
    });
}
// Empezar a grabar por medio del microfono a travez de una funcion asincronica
async function empezarGrabacion() {
    // Muestra el boton de cancelar de manera dinamica
    $('#btn_cancelar_grabacion').show(10).animate({ width: "47px" }).animate({ opacity: 1 });
    // Muestra el text de grabando de manera dinamica
    $('.recording-text').show(10).animate({ width: "120px" }).animate({ opacity: 1 });
    // Activa la funcion para detener la grabacion
    $("#btn_empezar_grabacion").attr("onclick", "detenerGrabacion()");
    // Al iniciar la grabación, remueve el icono del microfono
    $(".icono_grabacion").removeClass("fa-microphone");
    // Al iniciar la grabación, añade el icono del enviar
    $(".icono_grabacion").addClass("fa-play");
    // Solicita permiso para usar el micrófono al navegador
    stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    // Crea un nuevo objeto MediaRecorder para grabar el audio
    mediaRecorder = new MediaRecorder(stream);
    // Inicia la grabación
    mediaRecorder.start();
    // Define un arreglo para almacenar los fragmentos de audio grabados
    audioChunks = [];
    // Evento que se activa cuando hay datos disponibles durante la grabación
    mediaRecorder.ondataavailable = function (event) {
        // Agrega los datos de audio (fragmentos) al arreglo
        audioChunks.push(event.data);
    };
}
// Detener Grabacion
function detenerGrabacion() {
    // oculta el boton de cancelar de manera dinamica
    $('#btn_cancelar_grabacion').animate({ opacity: 0 }).animate({ width: 0 }).hide(0);
    // oculta el text de grabando de manera dinamica
    $('.recording-text').animate({ opacity: 0 }).animate({ width: 0 }).hide(0);
    // Al iniciar la grabación, remueve el icono del enviar
    $(".icono_grabacion").removeClass("fa-play");
    // Al iniciar la grabación, añade el icono del microfono
    $(".icono_grabacion").addClass("fa-microphone");
    // Activa la funcion para Empezar la grabacion
    $("#btn_empezar_grabacion").attr("onclick", "empezarGrabacion()");
    // Detiene la grabación
    mediaRecorder.stop();
    // Evento que se activa cuando la grabación se ha detenido
    mediaRecorder.onstop = function () {
        // Crea un Blob a partir de los fragmentos de audio grabados y especifica el tipo de archivo
        const audioBlob = new Blob(audioChunks, { type: 'audio/mpeg' });
        // Crea un archivo (File) con el Blob, asignándole un nombre y un tipo MIME
        audioFile = new File([audioBlob], 'grabacion.mp3', { type: 'audio/mpeg' });
        //enviamos al formulario de envio el tipo de mensaje 
        $("#tipo_mensaje").val("audio");
        // Ejecuta la funcion que realiza el proceso de enviar mensaje
        sendWhatsappMessage();
        // Detener y liberar todos los flujos de medios para liberar los recursos del micrófono
        stream.getTracks().forEach(track => track.stop());
        // Limpiar los fragmentos de audio para que no se mezclen con futuras grabaciones
        audioChunks = [];
    };
}
// Ejecuta un click sobre el input file para video y audio 
function seleccionarFotoVideo() {
    $("#fileFotoVideo").trigger("click");
}
// Previsualización de todos los archivos seleccionados
function MostrarFotosVideo(input) {
    var html = '';
    // Almacenamos todos los archivos seleccionados en una variable
    var archivos = input.files;
    // Limpia el contenido previo
    $('#fotoVideoPreview').empty();
    // Creamos la estructura inicial del carousel
    html += '<div id="carouselFotosVideos" class="carousel slide" data-ride="carousel">';
    html += '<div class="carousel-inner">';
    // las imágenes están en un arreglo que envía html 
    for (var i = 0; i < archivos.length; i++) {
        // Tomamos cada archivo
        var archivo = archivos[i];
        // Almacenamos el peso del archivo
        var pesoArchivo = archivo.size;
        // Verificamos que el peso no exceda los 60 MB
        if (pesoArchivo > 60 * 1024 * 1024) {
            // Enviamos un mensaje de error
            Swal.fire({ icon: "error", title: 'El tamaño de uno de los archivos seleccionados excede los 60 MB.', showConfirmButton: false, timer: 1500 });
            // Cancelamos el proceso finalizando la función totalmente 
            return;
        }
        // Creamos una URL para el archivo seleccionado, ya que está almacenado temporalmente
        var fileURL = URL.createObjectURL(archivo);
        // Activamos la primera imagen/video
        var activeClass = i === 0 ? 'active' : '';
        html += '<div class="carousel-item ' + activeClass + '">';
        // Comprobamos si es imagen o video verificando si el tipo de archivo es image o video 
        if (archivo.type.startsWith('image/')) {
            html += '<img src="' + fileURL + '" class="d-block w-100 h-100" alt="Imagen seleccionada">';
        } else if (archivo.type.startsWith('video/')) {
            html += '<video controls class="d-block w-100 h-100"><source src="' + fileURL + '" type="' + archivo.type + '"></video>';
        }
        html += '</div>';
    }
    // Cierre de carousel-inner
    html += '</div>';
    // Añadimos los controles
    html += '   <a class="carousel-control-prev" href="#carouselFotosVideos" role="button" data-slide="prev">';
    html += '       <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    html += '       <span class="sr-only">Anterior</span>';
    html += '   </a>';
    html += '   <a class="carousel-control-next" href="#carouselFotosVideos" role="button" data-slide="next">';
    html += '       <span class="carousel-control-next-icon" aria-hidden="true"></span>';
    html += '       <span class="sr-only">Siguiente</span>';
    html += '   </a>';
    html += '</div>'; // Cierre del carousel
    // Insertamos el contenido en el modal
    $('#fotoVideoPreview').html(html);
    // Abrimos el modal
    $('#fotoVideoModal').modal('show');
}
// Configura en tipo de mensaje en imagen para que entre al switch del controlador
function SubirFotoVideo() {
    $("#tipo_mensaje").val("image");
    sendWhatsappMessage();
}
// activa el permiso de la camara
function ActivarCamara() {
    // Para mostrar la camara se necesita la etiqueta de video de html
    video = $('#seccion_camara')[0];
    // Al momento de capturar la foto, se crea un canva para dibujar la captura 
    canvas = $('#canvas')[0];
    // Esta captura se va aplicar en 2d, para que cuando se genere el 
    context = canvas.getContext('2d');
    // Ejecutamos el servicio de Camara que ofrece el navegador
    navigator.mediaDevices.getUserMedia({ video: true }).then(function (stream) {
        // Abrimos el modal donde esta el video y el canva
        $("#camaraModal").modal("show");
        // Plasmamos la camara en la etiqueta de video 
        video.srcObject = stream;
        // Se ejecuta la funcion para que cuando le modal se cierre finalice el pro
        $('#camaraModal').on('hidden.bs.modal', function (e) {
            // Detener todas las pistas de video
            stream.getTracks().forEach(function (track) {
                track.stop();
            });
            // Vacea la etiqueta de video html para que no genere mas informacion
            video.srcObject = null;
            // Muestra la seccion de toamr Foto
            $(".seccion_captura").show();
            // Oculta la seccion de la foto tomada
            $(".seccion_capturada").hide();
            // Vacea el input donde se va almacenar la foto
            $('#fileFotoVideo').val('');
        })
    }).catch(function (err) {
        // Indicamos que hay un error al acceder a la camara
        Swal.fire({ "icon": "error", "title": "Error al acceder a la cámara: " + err });
    });
}
// Toma la foto y la envia al input file
function CapturarFoto() {
    // Toma el ancho de la etiqueta
    canvas.width = video.videoWidth;
    // Toma el Alto de la etiqueta
    canvas.height = video.videoHeight;
    // Dibuja la imagen en el canva con las poporciones y la captura instantanea del momento
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    // Convierte la imagen del canvas en un Blob
    canvas.toBlob(function (blob) {
        // Crea un archivo desde el Blob
        let file = new File([blob], "photo.png", { type: "image/png" });
        // Crea un DataTransfer para agregar el archivo al input file
        let dataTransfer = new DataTransfer();
        // Añade el archivo creado al datatransfer
        dataTransfer.items.add(file);
        // Transfiere el archivo al input file de foto para subirlo
        $("#fileFotoVideo")[0].files = dataTransfer.files;
        // Oculta la seccion de tomar Foto
        $(".seccion_captura").hide();
        // Muestra la seccion de la foto tomada
        $(".seccion_capturada").show();
    });
}
// Ejecuta un click sobre el input file para video y audio 
function seleccionarDocumentos() {
    $("#fileDocumentos").trigger("click");
}
// Previsualización de todos los archivos seleccionados
function MostrarDocumentos(input) {
    var html = '';
    // Almacenamos todos los archivos seleccionados en una variable
    var archivos = input.files;
    // Limpia el contenido previo
    $('#DocumentosPreview').empty();
    // Iteramos sobre los archivos seleccionados
    for (var i = 0; i < archivos.length; i++) {
        var archivo = archivos[i];
        var pesoArchivo = archivo.size;
        // Verificamos que el peso no exceda los 100 MB
        if (pesoArchivo > 100 * 1024 * 1024) {
            Swal.fire({ icon: "error", title: 'El tamaño de uno de los archivos seleccionados excede los 100 MB.', showConfirmButton: false, timer: 1500 });
            return;
        }
        // Determinamos el tipo de archivo para seleccionar el ícono correspondiente
        var icono;
        // tomamos la extension del archivo para saber el icono
        var extension = archivo.name.split('.').pop().toLowerCase();
        switch (extension) {
            case 'txt':
                icono = 'fas fa-file-alt';
                break;
            case 'xls':
            case 'xlsx':
                icono = 'fas fa-file-excel';
                break;
            case 'doc':
            case 'docx':
                icono = 'fas fa-file-word';
                break;
            case 'ppt':
            case 'pptx':
                icono = 'fas fa-file-powerpoint';
                break;
            case 'pdf':
                icono = 'fas fa-file-pdf';
                break;
            default:
                icono = 'fas fa-file';
                break;
        }
        // Creamos el HTML para mostrar el nombre del archivo con el ícono
        html += `
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <i class="`+ icono + `} fa-lg text-primary"></i> ` + archivo.name + `
                </div>
                <span class="badge badge-secondary badge-pill">`+ (pesoArchivo / 1024).toFixed(2) + ` KB</span>
            </a>`;
    }
    // Insertamos el contenido en el contenedor de previsualización
    $('#DocumentosPreview').html(html);
    // Abrimos el modal
    $('#DocumentosModal').modal('show');
}
// Configura en tipo de mensaje en imagen para que entre al switch del controlador
function SubirDocumentos() {
    $("#tipo_mensaje").val("document");
    sendWhatsappMessage();
}
// Lista en un select todas las dependecias a las cuales se pueden redirigr
function ListarDependencias() {
    $.post("../controlador/whatsapp_chats.php?op=ListarDependencias", {}, function (r) {
        r = JSON.parse(r); // Parsear la respuesta JSON
        html = '<option value="" selected disabled> Selecciona una dependencia </option>';
        for (let index = 0; index < r.length; index++) {
            const element = r[index]["dependencia"];
            html += '<option value="' + element + '">' + element + '</option>';
        }
        $("#dependencias").html(html);
    });
}
//Ejecuta la funcion que redirecciona el caso a otra de las areas disponibles
function redigirChat() {
    // Tomamos el numero de celular del chat elegido
    numero_celular = $("#send_numero_celular").val();
    // Crear objeto FormData con los datos del formulario
    formDataRedirigir = new FormData($("#formularioRedirigirChat")[0]);
    // Agregamos el numeor de celular al formadata 
    formDataRedirigir.append('numero_celular', numero_celular);
    // Establecer el tipo de mensaje como texto
    $("#tipo_mensaje").val("text");
    $.ajax({
        "url": "../controlador/whatsapp_chats.php?op=redigirChat",
        "type": "POST",
        "data": formDataRedirigir,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            data = JSON.parse(datos); // Parsear la respuesta JSON
            if (data.exito == "1") {
                // Muestra el resultado con SweetAlert
                Swal.fire({ "icon": "success", "title": data.info });
                // Oculta la vista sin chat seleccionado
                $(".sin_chat_seleccionado").show();
                // Muestra la vista con chat seleccionado
                $(".con_chat_seleccionado").hide();
                // Cierra el modal de redirección 
                $("#modalRedirigirChat").modal("hide");
                // Esto elimina el tr mas cercano del data celular
                $('div[data-chat="' + numero_celular + '"]').closest('tr').remove();
            } else {
                // Muestra el error en la consola
                console.log(data.err_info);
            }
        }
    });
}