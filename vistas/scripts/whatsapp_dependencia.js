// Función que se ejecuta al cargar el documento
$(document).ready(incio);
// Variables globales
var valor_buscado = "";
var estado_chat = ""; // Estado del chat seleccionado
function incio() {
    $(".con_chat_seleccionado").hide();
    listarChats(); // Listar los chats disponibles
    setInterval(listarChats, 10000); // Refrescar la lista de chats cada 10 segundos
    // Evento para el formulario de búsqueda
    $("#formularioBusqueda").on("submit", function (e) {
        e.preventDefault(); // Prevenir el envío del formulario
        valor_buscado = $("#valor_buscado").val(); // Obtener el valor buscado
        listarChats(); // Listar los chats con el filtro aplicado
    });
    // Evento para cuando escriban en el campo de búsqueda
    $("#valor_buscado").on("input", function () {
        valor_buscado = $(this).val(); // Actualizar el valor buscado
        listarChats(); // Listar los chats con el nuevo valor
    });
    // Evento para el botón escape de búsqueda
    $(document).on('keydown', function (event) {
        if (event.keyCode === 27) { // Escape
            valor_buscado = ""; // Limpiar el valor buscado
            $("#valor_buscado").val("");
            listarChats(); // Listar los chats sin filtro
        }
    });
    // evento para saber cual input radio esta checked 
    $(".estado_chat").on('change', function () {
        estado_chat = $(this).val(); // Obtener el valor del estado del chat seleccionado
        listarChats(); // Listar los chats con el estado seleccionado
    });
}
// Función para listar los chats disponibles
function listarChats() {
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
        "dom": 'tp',
        "ordering": false,
        "deferRender": true,
        "initComplete": function (status, data) {
            // Si hay chats no mostrados, activar notificaciones
            if (data.total_sin_mostrar != 0) {
                activarNotificaciones();
            }
            $("#precarga").hide();
            $('.dataTables_processing').hide();
            $(".dataTables_paginate").html("");
        },
        "ajax": {
            "url": '../controlador/whatsapp_dependencia.php?op=listarChats',
            "type": "post",
            "data": { "valor_buscado": valor_buscado, "estado_chat": estado_chat }, // Enviar el valor buscado y el estado del chat
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": -1, // Paginación: cantidad de chats mostrados por página
    }).DataTable();
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
    if (anchoPantalla <= 486) {
        $(".listado_chats").hide();
        $(".seccion_conversacion").css("width", "100%");
        $(".seccion_conversacion").removeClass("d-none");
        $(".historial_mensajes").css("height", "80vh");
        $(".mini").css("display", "none");
        $(".movilchat").removeClass("d-none");
        $(".pcchat").addClass("d-none");
    }
}
function volverlista() {
    $(".listado_chats").show();
    //$(".seccion_conversacion").css("width", "100%");
    $(".seccion_conversacion").addClass("d-none");
    $(".historial_mensajes").css("height", "80vh");
    $(".mini").css("display", "block");
    $(".movilchat").addClass("d-none");
    $(".pcchat").removeClass("d-none");
}
