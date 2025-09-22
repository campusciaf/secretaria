$(document).ready(inicio);
function inicio() {
    $("#form").on("submit", function(e){
        listar(e);
    });
}

function listar(e) {
    e.preventDefault();
    var formData = new FormData($("#form")[0]);
    $.ajax({
        "url": "../controlador/idiomas_pagos.php?op=listar",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos) {
            console.log(datos);
            var r = JSON.parse(datos);            
            $("#contenido").html(r.conte);
            $("#tbllistado").DataTable();
        }
    });    
}