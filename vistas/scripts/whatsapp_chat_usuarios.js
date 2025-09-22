// Función que se ejecuta al cargar el documento
$(document).ready(incio);
function incio() {
    $(".con_chat_seleccionado").hide();
    listarUsuarios();
    setInterval(function () {
        id_usuario = $("#usuario").val();
        listarChats(id_usuario);
    }, 10000); // Refrescar la lista de chats cada 10 segundos
}
// Función para listar los chats disponibles
function listarChats(id_usuario) {
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
        },
        "ajax": {
            "url": '../controlador/whatsapp_chat_usuarios.php?op=listarChats&id_usuario='+id_usuario,
            "type": "post",
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 60, // Paginación: cantidad de chats mostrados por página
    }).DataTable();
}
function listarUsuarios(){
    // peticion para cargar los usuarios en el select
    $.post("../controlador/whatsapp_chat_usuarios.php?op=selectUsuario", function (r) {
        // Inserta la lista de usuarios en el select usuario
        $("#usuario").html(r);
        // refresca el selectpicker para que se actualice con los nuevos datos
        $("#usuario").selectpicker('refresh');
    });
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