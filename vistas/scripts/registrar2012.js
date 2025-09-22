var tabla;
$(document).ready(inicio);
function inicio() {
    tipoSangre();
    grupoEtnico();
    mostrarEscuela();
    mostrarJornada();
    listar();
    mostrarform(false);
    $("#formulario").on("submit", function (e) {
        e.preventDefault();
        agregar();
    });
    $("#registro_acta").on("submit", function (e) {
        e.preventDefault();
        guardar_editar_acta();
    });
    $("#registro_materia").on("submit", function (e) {
        e.preventDefault();
        guardarMateria();
    });
    $("#precarga").hide();
}
function tipoSangre() {
    $.post("../controlador/registrar2012.php?op=listarSangre", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += "<option selected></option>";
        for (let i = 0; i < r.length; i++) {
            opti +=
                '<option value="' +
                r[i].nombre_sangre +
                '">' +
                r[i].nombre_sangre +
                "</option>";
        }
        $("#tipo_sangre").html(opti);
        $("#tipo_sangre").selectpicker();
        $("#tipo_sangre").selectpicker("refresh");
    });
}
function grupoEtnico() {
    $.post("../controlador/registrar2012.php?op=grupoEtnico", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += "<option selected></option>";
        for (let i = 0; i < r.length; i++) {
            opti +=
                '<option value="' +
                r[i].grupo_etnico +
                '">' +
                r[i].grupo_etnico +
                "</option>";
        }
        $("#grupo_etnico").append(opti);
        $("#grupo_etnico").selectpicker();
        $("#grupo_etnico").selectpicker("refresh");
    });
}
function mostrar_nombre_etnico(id) {
    if (id == "Comunidad negra" || id == "Pueblo indígena") {
        $.post(
            "../controlador/registrar2012.php?op=nombreEtnico&id=" + id,
            function (datos) {
                //console.table(datos);
                var opti = "";
                var r = JSON.parse(datos);
                //console.log(r);
                opti += "<option selected>-- Selecciona una opción -- </option>";
                for (let i = 0; i < r.length; i++) {
                    opti +=
                        '<option value="' + r[i].codigo + '">' + r[i].nombre + "</option>";
                }
                $("#nombre_etnico").html(opti);
                $("#nombre_etnico").selectpicker();
                $("#nombre_etnico").selectpicker("refresh");
            }
        );
    } else {
        opti = '<option value="No Aplica" selected>No Aplica</option>';
        $("#nombre_etnico").html(opti);
        $("#nombre_etnico").selectpicker();
        $("#nombre_etnico").selectpicker("refresh");
    }
}
function mostrarEscuela() {
    $.post("../controlador/registrar2012.php?op=mostrarEscuela", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += "<option selected>Escuela...</option>";
        for (let i = 0; i < r.length; i++) {
            opti +=
                '<option value="' + r[i].escuelas + '">' + r[i].escuelas + "</option>";
        }
        $("#escuela_ciaf").html(opti);
        $("#escuela_ciaf").selectpicker();
        $("#escuela_ciaf").selectpicker("refresh");
    });
}
function mostrarJornada() {
    $.post("../controlador/registrar2012.php?op=mostrarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += "<option disabled selected value=''> - selecciona una jornada -</option>";
        for (let i = 0; i < r.length; i++) {
            opti +=
                '<option value="' + r[i].nombre + '">' + r[i].nombre + "</option>";
        }
        $("#jornada_asig").html(opti);
    });
}
function listar() {
    var meses = new Array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );
    var diasSemana = new Array(
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado"
    );
    var f = new Date();
    var fecha_hoy =
        diasSemana[f.getDay()] +
        ", " +
        f.getDate() +
        " de " +
        meses[f.getMonth()] +
        " de " +
        f.getFullYear();
    tabla = $("#tbllistado").dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "Bfrtip", //Definimos los elementos del control de tabla
        "buttons": [
            {
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: "Excel"
            },
            {
                extend: "print",
                text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop:
                    '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
                    fecha_hoy +
                    ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                title: "Ejes",
                titleAttr: "Print"
            }
        ],
        ajax: {
            url: "../controlador/registrar2012.php?op=listar",
            type: "get",
            dataType: "json",
            error: function (e) {
                // console.log(e.responseText);
                $("#tbllistado").DataTable().ajax.reload();
            }
        },
        bDestroy: true,
        iDisplayLength: 10, //Paginación
        order: [[6, "asc"]],
        initComplete: function (settings, json) {
            $("#precarga").hide();
        }
    }).DataTable();
}
function mostrarform(flag) {
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#formularidatos").show();
        $("#guia_guardar_estudiante_antiguo").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#formularidatos").hide();
        $("#btnagregar").show();
        $("#formulario")[0].reset();
    }
}
function cancelarform() {
    limpiar();
    mostrarform(false);
}
function limpiar() {
    $("#formulario")[0].reset();
    $("#registro_acta")[0].reset();
    $("#registro_materia")[0].reset();
}
function agregar() {
    $("#precarga").removeClass("hide");
    const formData = new FormData($("#formulario")[0]);
    $.ajax({
        "type": "POST",
        "url": "../controlador/registrar2012.php?op=guardaryeditar",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            $("#precarga").addClass("hide");
            // console.log(datos);
            var r = JSON.parse(datos);
            if (r.exito == 1) {
                tabla.ajax.reload();
                alertify.success(r.info);
                mostrarform(false);
            } else {
                alertify.error(r.info);
            }
        }
    });
    $("#id_estudiante").val("");
}
function guardarMateria() {
    $("#btnGuardarMateria").prop("disabled", true);
    var formData = new FormData($("#registro_materia")[0]);
    $.ajax({
        "url": "../controlador/registrar2012.php?op=aggMaterias",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            $("#btnGuardarMateria").prop("disabled", false);
            data = JSON.parse(datos);
            if (data.exito == "1") {
                Swal.fire({ position: "top-end", icon: "success", title: data.info, showConfirmButton: false, timer: 1500 });
                tabla_materias.ajax.reload();
                limpiar();
            } else {
                Swal.fire({ position: "top-end", icon: "error", title: data.info, showConfirmButton: false, timer: 1500 });
            }
        }
    });
}
//para la funcion editar
function mostrar(id_estudiante) {
    $.post(
        "../controlador/registrar2012.php?op=mostrar",
        { id_estudiante: id_estudiante },
        function (data, status) {
            // console.log(data);
            data = JSON.parse(data);
            mostrarform(true);
            //id se llena para la funcion guardar y editar para que edite
            $("#id_estudiante").val(data.id_estudiante);
            $("#tipo_documento").val(data.tipo_documento);
            $("#tipo_documento").selectpicker("refresh");
            $("#identificacion").val(data.identificacion);
            $("#expedido_en").val(data.expedido_en);
            $("#fecha_expedicion").val(data.fecha_expedicion);
            $("#fecha_expedicion").selectpicker("refresh");
            $("#nombre").val(data.nombre);
            $("#nombre_2").val(data.nombre_2);
            $("#apellidos").val(data.apellidos);
            $("#apellidos_2").val(data.apellidos_2);
            $("#lugar_nacimiento").val(data.lugar_nacimiento);
            $("#fecha_nacimiento").val(data.fecha_nacimiento);
            $("#genero").val(data.genero);
            $("#tipo_sangre").val(data.tipo_sangre);
            $("#tipo_sangre").selectpicker("refresh");
            $("#eps").val(data.eps);
            $("#fo_programa").val(data.fo_programa);
            $("#titulo_estudiante").val(data.titulo_estudiante);
            $("#titulo_estudiante").selectpicker("refresh");
            $("#escuela_ciaf").val(data.escuela_ciaf);
            $("#escuela_ciaf").selectpicker("refresh");
            $("#jornada_e").val(data.jornada_e);
            $("#jornada_e").selectpicker("refresh");
            $("#periodo").val(data.periodo);
            $("#grupo_etnico").val(data.grupo_etnico);
            $("#grupo_etnico").selectpicker("refresh");
            $("#nombre_etnico").val(data.nombre_etnico);
            $("#nombre_etnico").selectpicker("refresh");
            $("#discapacidad").val(data.discapacidad);
            $("#nombre_discapacidad").val(data.nombre_discapacidad);
            $("#direccion").val(data.direccion);
            $("#barrio").val(data.barrio);
            $("#municipio").val(data.municipio);
            $("#telefono").val(data.telefono);
            $("#telefono2").val(data.telefono2);
            $("#celular").val(data.celular);
            $("#email").val(data.email);
            $("#nombre_colegio").val(data.nombre_colegio);
            $("#tipo_institucion").val(data.tipo_institucion);
            $("#tipo_institucion").selectpicker("refresh");
            $("#jornada_institucion").val(data.jornada_institucion);
            $("#jornada_institucion").selectpicker("refresh");
            $("#ano_terminacion").val(data.ano_terminacion);
            $("#ciudad_institucion").val(data.ciudad_institucion);
            $("#fecha_presen_icfes").val(data.fecha_presen_icfes);
            $("#codigo_icfes").val(data.codigo_icfes);
            $("#trabaja_actualmente").val(data.trabaja_actualmente);
            $("#cargo_en_empresa").val(data.cargo_en_empresa);
            $("#empresa_trabaja").val(data.empresa_trabaja);
            $("#sector_empresa").val(data.sector_empresa);
            $("#sector_empresa").selectpicker("refresh");
            $("#tel_empresa").val(data.tel_empresa);
            $("#email_empresa").val(data.email_empresa);
            $("#segundo_idioma").val(data.segundo_idioma);
            $("#segundo_idioma").selectpicker("refresh");
            $("#cual_idioma").val(data.cual_idioma);
            $("#aficiones").val(data.aficiones);
            $("#tiene_pc").val(data.tiene_pc);
            $("#tiene_internet").val(data.tiene_internet);
            $("#tiene_internet").selectpicker("refresh");
            $("#tiene_hijos").val(data.tiene_hijos);
            $("#tiene_hijos").selectpicker("refresh");
            $("#estado_civil").val(data.estado_civil);
            $("#estado_civil").selectpicker("refresh");
            $("#persona_emergencia").val(data.persona_emergencia);
            $("#direccion_emergencia").val(data.direccion_emergencia);
            $("#email_emergencia").val(data.email_emergencia);
            $("#tel_fijo_emergencia").val(data.tel_fijo_emergencia);
            $("#celular_emergencia").val(data.celular_emergencia);
        }
    );
}
function mostrarIdentificacion(identificacion, id_estudiante) {
    $("#identificacion_acta").val(identificacion);
    $("#identificacion2").val(identificacion);
    $("#id_estudiante_acta").val(id_estudiante);
    $("#id_estudiante_materia").val(id_estudiante);
    mostrar_datos_acta(id_estudiante);
    listar_materias(id_estudiante);
}
function mostrar_datos_acta(id_estudiante_acta) {
    $.post(
        "../controlador/registrar2012.php?op=mostrar_datos_acta",
        { id_estudiante_acta: id_estudiante_acta },
        function (data, status) {
            // console.log(data);
            data = JSON.parse(data);
            //id se llena para la funcion guardar y editar para que edite
            $("#id_so").val(data.id_so);
            $("#titulo_acta").val(data.titulo);
            $("#estado_est").val(data.estado);
            $("#numero_acta").val(data.numero_acta);
            $("#libro").val(data.libro);
            $("#folio").val(data.folio);
            $("#ano_graduacion").val(data.ano_graduacion);
            $("#periodo_acta").val(data.periodo);
        }
    );
}
function listar_materias(identificacion) {
    var meses = new Array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );
    var diasSemana = new Array(
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado"
    );
    var f = new Date();
    var fecha_hoy =
        diasSemana[f.getDay()] +
        ", " +
        f.getDate() +
        " de " +
        meses[f.getMonth()] +
        " de " +
        f.getFullYear();
    tabla_materias = $("#tblmateria")
        .dataTable({
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            dom: "Bfrtip", //Definimos los elementos del control de tabla
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: "Excel"
                },
                {
                    extend: "print",
                    text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop:
                        '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
                        fecha_hoy +
                        ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: "Ejes",
                    titleAttr: "Print"
                }
            ],
            ajax: {
                url:
                    "../controlador/registrar2012.php?op=listar_materias&identificacion=" +
                    identificacion,
                type: "get",
                dataType: "json",
                error: function (e) {
                    // console.log(e.responseText);
                }
            },
            bDestroy: true,
            iDisplayLength: 10, //Paginación
            initComplete: function (settings, json) {
                $("#precarga").hide();
            }
        })
        .DataTable();
}
function eliminar(id_estudiante) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons
        .fire({
            title: "¿Está Seguro de eliminar este registro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, continuar!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        })
        .then(result => {
            if (result.isConfirmed) {
                $.post(
                    "../controlador/registrar2012.php?op=eliminar",
                    {
                        id_estudiante: id_estudiante
                    },
                    function (e) {
                        data = JSON.parse(e);
                        if (data.exito == 1) {
                            swalWithBootstrapButtons.fire({
                                title: "Ejecutado!",
                                text: data.info,
                                icon: "success"
                            });
                            tabla.ajax.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Error!",
                                text: data.info,
                                icon: "error"
                            });
                        }
                    }
                );
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Tu proceso está a salvo :)",
                    icon: "error"
                });
            }
        });
}
function guardar_editar_acta() {
    $("#btnGuardarActa").prop("disabled", true);
    var formData = new FormData($("#registro_acta")[0]);
    $.ajax({
        "url": "../controlador/registrar2012.php?op=guardar_editar_acta",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            // console.log(datos)
            $("#btnGuardarActa").prop("disabled", false);
            data = JSON.parse(datos);
            if (data.exito == "1") {
                Swal.fire({ "position": "top-end", "icon": "success", "title": data.info, "showConfirmButton": false, "timer": 1500 });
                tabla.ajax.reload();
                $("#estudianteModal").modal("hide");
            } else {
                Swal.fire({ "position": "top-end", "icon": "error", "title": data.info, "showConfirmButton": false, "timer": 1500 });
            }
            $("#id_so").val("");
            $("#id_estudiante_acta").val("");
        }
    });
    limpiar();
}

function cambiarEstadoFallecido(identificacion, estado_fallecido) {
    $.post("../controlador/registrar2012.php?op=editar_estado_fallecido", 
    {
        identificacion: identificacion,
        estado_fallecido: estado_fallecido
    }, 
    function(datos) {
        data = JSON.parse(datos);
        if (data.exito == "1") {
            Swal.fire({ "position": "top-end", "icon": "success", "title": data.info, "showConfirmButton": false, "timer": 1500 });
            tabla.ajax.reload();
         
        } else {
            Swal.fire({ "position": "top-end", "icon": "error", "title": data.info, "showConfirmButton": false, "timer": 1500 });
        }
    });
}

