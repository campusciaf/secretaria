$(document).ready(inicio);
var seleccion_actual = 1;
function inicio() {
    listarTemaPrincipal();
    listarPuntos();
    codigo();   
    verificarInduccionPlataforma();
    docenteDestacado();
}

function listarTemaPrincipal() {
    $.post("../controlador/headerdocente.php?op=listarTema", function (e) {
       
    var r = JSON.parse(e);
        
        if(r.conte==1){
            document.documentElement.setAttribute('tema', 'light');
        }else{
            document.documentElement.setAttribute('tema', 'dark');
        }

    });
}

// codigo qr
function codigo() {
    $.post("../controlador/headerdocente.php?op=generarqrdocente", function (e) {
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

function listarPuntos(){
    $.post("../controlador/headerdocente.php?op=listarPuntos", function (datos) {
        data = JSON.parse(datos);
        $("#mispuntos").html(data.exito);
        $("#nivel").html(data.nivel);
    });
}
function verificarInduccionPlataforma() {
    // Obtener la última parte de la URL después del último "/"
    var urlActual = window.location.href;
    // Extrae solo el nombre del archivo
    var archivo = urlActual.split("/").pop(); 
    // Verifica si el archivo es el que deseas excluir
    if (!(archivo === "curso_para_creativos.php")) {
        $.post("../controlador/headerdocente.php?op=verificarInduccionPlataforma", function (e) {
            var r = JSON.parse(e);
            if (r.exito == 1) {
                $("#modalcurso").modal({ "backdrop": 'static', "keyboard": false }).modal('show');
            }
        });
    }

}

function docenteDestacado() {
     $.post("../controlador/headerdocente.php?op=docenteDestacado", function (e) {
        var r = JSON.parse(e);
        promedio = parseFloat(r.exito);
        if (promedio >= 94.56) {
            $("#estrella").html('<i class="fa-solid fa-star fs-24 text-warning" title="Docente destacado"></i>');
        }else{
            $("#estrella").html("");
        }

        if (r.influencer==1) {
            $("#influencer").html('<i class="fa-solid fa-heart text-danger fs-24" title="Influencer +"></i>');
        }else{
            $("#influencer").html("");
        }
    });

}

inicio();

