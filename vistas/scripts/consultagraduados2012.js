$(document).ready(inicio);

function inicio() {
    $(".consultaDatos").on("submit", function (e) {
        consultaDatos(e);
    });
    
}
function todo() {
    
    if($('input:checkbox[name=todoprincipal]').prop('checked')){
        $('.parteUno').prop("checked", true);
    }else{
        $('.parteUno').prop("checked", false);
    }

}
function parteDos() {
    if ($('input:checkbox[name=todopersonal]').prop('checked')) {
        $('.partedos').prop("checked", true);
    } else {
        $('.partedos').prop("checked", false);
    }
}
function parteTre() {
    if ($('input:checkbox[name=todocontacto]').prop('checked')) {
        $('.parteTres').prop("checked", true);
    } else {
        $('.parteTres').prop("checked", false);
    }
}
function parteCuatro() {
    if ($('input:checkbox[name=todoacademi]').prop('checked')) {
        $('.parteCuatro').prop("checked", true);
    } else {
        $('.parteCuatro').prop("checked", false);
    }
}

function parteCinco() {
    if ($('input:checkbox[name=todolabora]').prop('checked')) {
        $('.parteCinco').prop("checked", true);
    } else {
        $('.parteCinco').prop("checked", false);
    }
}
function parteSeis() {
    if ($('input:checkbox[name=todocomple]').prop('checked')) {
        $('.parteSeis').prop("checked", true);
    } else {
        $('.parteSeis').prop("checked", false);
    }
}

function consultaDatos(e) {
    e.preventDefault();
    var formData = new FormData($("#form2")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/consultagraduados2012.php?op=consultaDatos",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".modal-body").html(r.conte);
            $("#modalDatos").modal("show");
            $('#tbl-consulta').DataTable();
        }
    });
}