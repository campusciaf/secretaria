$(document).ready(inicio);
function inicio() {
    listarProgramas();
    mostrarJornada();
    mostrarPeriodo();
    $("#precarga").hide();
    $(".periodo").hide();
    $(".form").hide();
}

function mostrarJornada() {
    $.post("../controlador/actualidad.php?op=mostrarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            if(r[i].nombre=="Ninguno"){
                r[i].nombre="Todas las Jornadas";
            }
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $('#jornada').html(opti);
        $('#jornada').selectpicker();
        $('#jornada').selectpicker('refresh');
    });
}
function mostrarPeriodo() {
    $.post("../controlador/actualidad.php?op=mostrarPeriodo", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].periodo + '">' + r[i].periodo + '</option>';
        }
        $('#periodo').html(opti);
        $('#periodo').selectpicker();
        $('#periodo').selectpicker('refresh');
    });
}
function listarProgramas() {
    $.post("../controlador/actualidad.php?op=listarProgra", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            if(r[i].nombre=="Ninguno"){
                r[i].nombre="Todos los programas";
            }
            opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
        }
        $("#programa").append(opti);
        $('#programa').selectpicker();
        $('#programa').selectpicker('refresh');
    });
}
function nuevos() {
    $(".form").show();
    $(".periodo").show();
    $("#consulta").off().on("click", function () {
        data = ({
            'jornada': $('#jornada').val(),
            'programa': $('#programa').val(),
            'periodo': $('#periodo').val(),
            'guia': 'renovacion'
        });
        $("#precarga").show();
        $.post("../controlador/actualidad.php?op=consultaNuevos", data, function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".resultado").html(r.conte);
            $(".table").DataTable({
                'initComplete': function (settings, json) {
                    $("#precarga").hide();
                },dom: 'Bfrtip',
                "buttons": [{
                    "extend": 'excelHtml5',
                    "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    "titleAttr": 'Excel'
                },{
                    "extend": 'print',
                    "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    "titleAttr": 'Imprimir'
                }],
                "iDisplayLength": 10,//Paginación
            });
        });
    });
}
function activos() {
    $(".form").show();
    $(".periodo").hide();
    $("#consulta").off().on("click", function () {
        data = ({
            'jornada': $('#jornada').val(),
            'programa': $('#programa').val(),
            'guia': 'renovacion'
        });
        $("#precarga").show();
        $.post("../controlador/actualidad.php?op=consulta", data, function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".resultado").html(r.conte);
            $(".table").DataTable({
				"scrollX": true,
                'initComplete': function (settings, json) {
                    $("#precarga").hide();
                },dom: 'Bfrtip',
                "buttons": [{
                    "extend": 'excelHtml5',
                    "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    "titleAttr": 'Excel'
                },{
                    "extend": 'print',
                    "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    "titleAttr": 'Imprimir'
                }],
                "iDisplayLength": 10,//Paginación
            });
        });
    });
}