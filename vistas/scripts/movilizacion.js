$(document).ready(incio);
function incio() {
    listarMunicipios();
	$("#precarga").hide();
}
function listarMunicipios() {
    $('#tbl_municipios').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons:
                [{
                    extend: 'excelHtml5',
                    text: '<i style="color:green;" class="fas fa-file-excel fa-3x"></i>',
                    titleAttr: 'Reporte Excel',
                    title: 'Registro municipios movilización'
                }],
            "language": {
                "url": "public/DataTables/idioma/Spanish.json"
            },
            "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
            "ajax":
            {
                url: '../controlador/movilizacion.php?op=listar_municipios',
                type: "get",
                dataType: "json",

                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "asc"]]//Ordenar (columna,orden)
        }).DataTable();
}
function editar_municipio(id) {
    $("#modal-editar").modal("show");
    $.post("../controlador/movilizacion.php?op=consulta_municipios", { id: id }, function (r) {
        var datos = JSON.parse(r);
        // console.log(datos[0].nombre);
        $("#nombre_municipio").val(datos[0].nombre);
        $("#id_municipio").val(datos[0].id);
    });
}
function editar() {
    var data = {
        'id': $("#id_municipio").val(),
        'nombre': $("#nombre_municipio").val()
    };

    $.ajax({
        type: "POST",
        url: "../controlador/movilizacion.php?op=editar_municipios",
        data: data,
        dataType: 'json',
        success: function (r) {
            // console.log(r);

            if (r = "ok") {
                alertify.success("Municipio actualizado con exito");
                listarMunicipios();
                $("#modal-editar").modal("hide");
            } else {
                alertify.error("Error al actualizar el municipio");
            }

        }
    });
}
function delete_municipio(id) {
    alertify.confirm('Eliminar Municipio', "¿Está Seguro de eliminar el municipio?", function () {
        $.post("../controlador/movilizacion.php?op=delete_municipios", { id: id }, function (r) {
            console.log(r);
            listarMunicipios();
        });        
    }
    ,function () { alertify.error('Cancelado') });
}
function registrar_colegio(id) {
    $("#modal-registrar").modal("show");
    $("#id_muni").val(id);
}
function aggColegio() {
    //alert("sdffsd");
    var data = {
        'id_municipio': $("#id_muni").val(),
        'valor': $("#tarifa_colegio").val(),
        'nombre': $("#nombre_colegio").val()
    };
    //console.log(data)

    $.post("../controlador/movilizacion.php?op=aggcolegio", data, function (r) {
        //console.log(r);
        if (r = "ok") {
            alertify.success("Registro de colegio con exito");
            listarMunicipios();
            $("#modal-registrar").modal("hide");
        } else {
            alertify.error("Error al registrar el colegio");
        }
    }); 
}
function ver_colegios(id,colegios) {
    $("#div_listarcolegios").removeClass('hide');
    $('#tbl_colegios').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            "stateSave": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons:
                [{
                    extend: 'excelHtml5',
                    text: '<i style="color:green;" class="fas fa-file-excel fa-3x"></i>',
                    titleAttr: 'Reporte Excel',
                    title: 'Registro colegios articulación de ' + colegios
                }],
            "language": {
                "url": "public/DataTables/idioma/Spanish.json"
            },
            "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
            "ajax":
            {
                url: '../controlador/movilizacion.php?op=listarColegios&municipio=' + id,
                type: "get",
                dataType: "json",

                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}
function cerrar_listado_colegios() {
    $("#div_listarcolegios").addClass('hide');
}
function abrir_editar_colegio(id) {
    $("#modal-editar-colegio").modal("show");
    $.post("../controlador/movilizacion.php?op=consulta_colegio", { id: id }, function (r) {
        var datos = JSON.parse(r);
        //console.log(datos[0].nombre);
        $("#nombre_colegio_edit").val(datos[0].nombre);
        $("#id_colegio").val(datos[0].id);
        $("#tarifa_colegio_edit").val(datos[0].tarifa);
    });
}
function updaColegio() {
    var data = {
        'id': $("#id_colegio").val(),
        'nombre': $("#nombre_colegio_edit").val(),
        'tarifa': $("#tarifa_colegio_edit").val()
    };

    $.ajax({
        type: "POST",
        url: "../controlador/movilizacion.php?op=editar_colegio",
        data: data,
        dataType: 'json',
        success: function (r) {
            //sconsole.log(r);
            if (r = "ok") {
                alertify.success("Colegio actualizado con exito");
                ver_colegios($("#id_colegio").val());
                $("#modal-editar-colegio").modal("hide");
            } else {
                alertify.error("Error al actualizar el colegio");
            }
        }
    });
}
function abrir_registrar_municipio() {
    $("#modal_registro_municipios").modal("show");
}
function guardar_municipio() {
    var data = {
        'nombre': $("#agg_nombre_municipio").val()
    };
    //console.log(data)

    $.post("../controlador/movilizacion.php?op=aggMunicipio", data, function (r) {
        //console.log(r);
        if (r = "ok") {
            alertify.success("Registro de municipio con exito");
            listarMunicipios();
            $("#modal_registro_municipios").modal("hide");
        } else {
            alertify.error("Error al registrar el municipio");
        }
    });
}
function cerrar_registro_mun() {
    $("#modal_registro_municipios").modal("hide");
}
function eliminar_colegio(id,id_col) {
    alertify.confirm('Eliminar Municipio', "¿Está Seguro de eliminar el colegio?", function () {
        $.post("../controlador/movilizacion.php?op=delete_colegio", { id: id }, function (r) {
            console.log(r);
            ver_colegios(id_col);
        });
    }
    ,function () { alertify.error('Cancelado') });
}